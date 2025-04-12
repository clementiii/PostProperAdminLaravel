<?php
require_once 'db.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Increase PHP limits for video uploads
ini_set('memory_limit', '512M');
ini_set('max_execution_time', 600);
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_input_time', 600);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Function to load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        error_log("ENV file not found at: " . $path);
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
        if (strpos($line, '=') !== false) { // Make sure the line contains an equals sign
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            // Remove quotes if present
            if (strpos($value, '"') === 0 || strpos($value, "'") === 0) {
                $value = substr($value, 1, -1);
            }
            
            // Set environment variable
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
    
    return true;
}

// Load environment variables from .env file
$envPath = $_SERVER['DOCUMENT_ROOT'] . '/.env';
$envLoaded = loadEnv($envPath);

if (!$envLoaded) {
    // Try fallback to Heroku environment variables
    error_log("Failed to load environment variables from .env file. Using environment variables directly.");
}

// Function to upload image to Cloudinary
function uploadImageToCloudinary($base64Image) {
    // Get Cloudinary credentials from environment variables
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    // Check if Cloudinary credentials are available
    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
        error_log('Cloudinary credentials not found. CLOUD_NAME: ' . $cloudName);
        return null;
    }
    
    try {
        // Remove the data URI header if present
        if (strpos($base64Image, 'data:image/jpeg;base64,') === 0) {
            $base64Image = substr($base64Image, 23);
        }
        $base64Image = str_replace(' ', '+', $base64Image);
        
        // Decode base64 to binary
        $imageData = base64_decode($base64Image);
        if ($imageData === false) {
            throw new Exception('Failed to decode base64 image');
        }
        
        // Create a temporary file
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];
        file_put_contents($tempFilePath, $imageData);
        
        // Prepare upload parameters
        $timestamp = time();
        $folder = 'incident_reports'; // Folder in Cloudinary
        $publicId = 'incident_' . $timestamp . '_' . bin2hex(random_bytes(8));
        
        // Generate signature
        $params = [
            'folder' => $folder,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
        ];
        ksort($params); // Sort params alphabetically
        
        $signature = '';
        foreach ($params as $key => $value) {
            $signature .= $key . '=' . $value . '&';
        }
        $signature = rtrim($signature, '&');
        $signature .= $apiSecret;
        $signature = sha1($signature);
        
        // Prepare multipart form data
        $postFields = [
            'file' => new CURLFile($tempFilePath, 'image/jpeg', 'image.jpg'),
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'signature' => $signature,
        ];
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute request
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            error_log('Cloudinary cURL error: ' . curl_error($ch));
            curl_close($ch);
            fclose($tempFile); // Close the temporary file
            return null;
        }
        
        curl_close($ch);
        fclose($tempFile); // Close the temporary file
        
        $result = json_decode($response, true);
        
        // Check if Cloudinary response contains secure_url
        if (!isset($result['secure_url'])) {
            error_log('Cloudinary upload failed: ' . json_encode($result));
            return null;
        }
        
        // Return Cloudinary secure URL for the uploaded image
        error_log('Successfully uploaded image to Cloudinary: ' . $result['secure_url']);
        return $result['secure_url'];
        
    } catch (Exception $e) {
        error_log("Cloudinary image upload error: " . $e->getMessage());
        return null;
    }
}

// Function to upload video to Cloudinary
function uploadVideoToCloudinary($base64Video) {
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    error_log("CLOUDINARY_CLOUD_NAME: " . $cloudName);
    error_log("CLOUDINARY_API_KEY (length): " . strlen($apiKey));
    error_log("CLOUDINARY_API_SECRET (length): " . strlen($apiSecret));
    
    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
        error_log('Cloudinary credentials not found');
        return null;
    }
    
    try {
        // Clean up the base64 data
        if (strpos($base64Video, 'data:video/mp4;base64,') === 0) {
            $base64Video = substr($base64Video, 23);
        } elseif (strpos($base64Video, 'data:video/') === 0) {
            $parts = explode(';base64,', $base64Video);
            if (count($parts) == 2) {
                $base64Video = $parts[1];
            }
        }
        
        // Remove whitespace that might have been added
        $base64Video = str_replace([' ', "\r", "\n", "\t"], '', $base64Video);
        
        // Decode base64 to binary
        $videoData = base64_decode($base64Video);
        if ($videoData === false) {
            throw new Exception('Failed to decode base64 video');
        }
        
        $videoSize = strlen($videoData);
        error_log("Video data size after decoding: " . $videoSize . " bytes");
        
        // Create a temporary file with .mp4 extension
        $tempFilePath = tempnam(sys_get_temp_dir(), 'vid_') . '.mp4';
        file_put_contents($tempFilePath, $videoData);
        
        $fileSize = filesize($tempFilePath);
        error_log("Temporary file size: " . $fileSize . " bytes");
        
        // Test if the file starts with an MP4 signature
        $fileHandle = fopen($tempFilePath, "rb");
        $header = fread($fileHandle, 12);
        fclose($fileHandle);
        
        $hexHeader = bin2hex($header);
        error_log("First 12 bytes (hex): " . $hexHeader);
        
        // API call to Cloudinary
        $timestamp = time();
        $folder = 'incident_videos';
        $publicId = 'incident_video_' . $timestamp . '_' . bin2hex(random_bytes(4));
        
        // Build signature parameters
        $paramsToSign = array(
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId
        );
        
        // Sort parameters alphabetically
        ksort($paramsToSign);
        
        // Build signature string
        $signatureStr = '';
        foreach ($paramsToSign as $key => $value) {
            $signatureStr .= $key . '=' . $value . '&';
        }
        $signatureStr = rtrim($signatureStr, '&');
        
        // Add API secret to the end of the string
        $signatureStr .= $apiSecret;
        
        // Generate signature
        $signature = sha1($signatureStr);
        
        // Set up curl to use verbose debugging
        $verbose = fopen('php://temp', 'w+');
        
        // Prepare upload parameters
        $postFields = array(
            'file' => new CURLFile($tempFilePath, 'video/mp4', 'video.mp4'),
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'signature' => $signature,
            'resource_type' => 'video'
        );
        
        // Initialize cURL with more debugging
        $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/video/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_STDERR, $verbose);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        
        // Execute request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Get verbose debug information
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        fclose($verbose);
        
        // Log curl verbose output
        error_log("cURL verbose log: " . $verboseLog);
        
        // Clean up
        curl_close($ch);
        unlink($tempFilePath);
        
        // Parse response
        $result = json_decode($response, true);
        
        if ($httpCode != 200 || !isset($result['secure_url'])) {
            $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Unknown error';
            throw new Exception('The video format is not supported. Please use a standard MP4 video file.');
        }
        
        return $result['secure_url'];
    } catch (Exception $e) {
        error_log("Cloudinary video upload error: " . $e->getMessage());
        throw $e; // Re-throw the exception to be caught by the main try-catch
    }
}

$response = array();

try {
    // Log all POST data for debugging
    error_log("POST data received: " . print_r($_POST, true));

    // Try both methods of getting data
    $rawData = file_get_contents('php://input');
    error_log("Raw POST data: " . $rawData);

    // Check if we got form data
    if (!empty($_POST)) {
        $postData = $_POST;
        error_log("Using _POST data");
    } else {
        // Try to parse as JSON first
        $jsonData = json_decode($rawData, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $postData = $jsonData;
            error_log("Using JSON decoded data");
        } else {
            // Fall back to parse_str for URL encoded data
            parse_str($rawData, $postData);
            error_log("Using parse_str data: " . print_r($postData, true));
        }
    }

    if (!isset($postData['user_id']) || !isset($postData['title']) || !isset($postData['description'])) {
        throw new Exception('Missing required fields: user_id, title, or description');
    }

    error_log("Looking up user: " . $postData['user_id']);
    $stmt = $conn->prepare("SELECT firstName, lastName FROM user_accounts WHERE id = ?");
    $stmt->execute([$postData['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception('User not found with ID: ' . $postData['user_id']);
    }

    $name = $user['firstName'] . ' ' . $user['lastName'];
    $title = $postData['title'];
    $description = $postData['description'];
    $date_submitted = date('Y-m-d H:i:s');
    $status = 'pending';
    $uploadedImages = array();
    $uploadedVideo = null;

    error_log("Processing media for user: " . $name);

    if (!empty($postData['media_data'])) {
        try {
            $mediaData = json_decode($postData['media_data'], true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid media data format: ' . json_last_error_msg());
            }

            // Process images
            if (isset($mediaData['images']) && is_array($mediaData['images'])) {
                error_log("Processing " . count($mediaData['images']) . " images");
                foreach ($mediaData['images'] as $imageData) {
                    // Check if it's already a URL (starts with http)
                    if (strpos($imageData, 'http') === 0) {
                        error_log("Image is already a URL: " . $imageData);
                        $uploadedImages[] = $imageData;
                    } else {
                        $imageUrl = uploadImageToCloudinary($imageData);
                        
                        if ($imageUrl === null) {
                            throw new Exception('Failed to upload image to Cloudinary');
                        }
                        
                        $uploadedImages[] = $imageUrl;
                    }
                }
            }

            // Process video
            if (isset($mediaData['video']) && !empty($mediaData['video'])) {
                error_log("Processing video");
                $videoData = $mediaData['video'];
                
                // Check if it's already a URL (starts with http)
                if (strpos($videoData, 'http') === 0) {
                    error_log("Video is already a URL: " . $videoData);
                    $uploadedVideo = $videoData;
                } else {
                    $videoUrl = uploadVideoToCloudinary($videoData);
                    
                    if ($videoUrl === null) {
                        throw new Exception('Failed to upload video to Cloudinary');
                    }
                    
                    $uploadedVideo = $videoUrl;
                }
            }
        } catch (Exception $e) {
            error_log("Media processing error: " . $e->getMessage());
            throw new Exception('Failed to process media: ' . $e->getMessage());
        }
    }

    // Always ensure incident_picture is at least an empty array
    $incident_picture_json = json_encode($uploadedImages);
    
    error_log("Inserting report into database");
    // Insert into database with all required fields
    $stmt = $conn->prepare("INSERT INTO incident_reports (
        name, title, description, incident_picture, incident_video, 
        date_submitted, status, created_at, updated_at
    ) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
    
    if (!$stmt->execute([
        $name, $title, $description, $incident_picture_json, $uploadedVideo,
        $date_submitted, $status
    ])) {
        $error = $stmt->errorInfo();
        throw new Exception('Database insertion failed: ' . implode(", ", $error));
    }

    error_log("Report inserted successfully");
    $response['status'] = 'success';
    $response['message'] = 'Incident report submitted successfully';
    $response['images'] = $uploadedImages;
    $response['video'] = $uploadedVideo;

} catch (Exception $e) {
    error_log("Error in submit_incident_report.php: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);