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
        }
        $base64Video = str_replace(' ', '+', $base64Video);
        $base64Video = preg_replace('/\s+/', '', $base64Video);
        
        // Check if the data is valid base64
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $base64Video)) {
            error_log("Invalid base64 data");
            return null;
        }
        
        // Decode base64 to binary
        $videoData = base64_decode($base64Video, true);
        if ($videoData === false) {
            error_log("Failed to decode base64 video");
            return null;
        }
        
        // Check video size (100MB limit for free plan)
        $videoSize = strlen($videoData);
        $maxSize = 100 * 1024 * 1024; // 100MB in bytes
        if ($videoSize > $maxSize) {
            error_log("Video size exceeds Cloudinary free plan limit (100MB)");
            throw new Exception('Video size exceeds the maximum allowed size of 100MB');
        }
        
        // Create a temporary file with .mp4 extension
        $tempFilePath = tempnam(sys_get_temp_dir(), 'vid_') . '.mp4';
        file_put_contents($tempFilePath, $videoData);
        
        // Check if it's a valid video file
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $tempFilePath);
        finfo_close($fileInfo);
        
        error_log("File MIME type: " . $mimeType);
        
        // Accept both video/* and application/octet-stream
        if (strpos($mimeType, 'video/') !== 0 && strpos($mimeType, 'application/octet-stream') !== 0) {
            error_log("Not a valid video file: " . $mimeType);
            unlink($tempFilePath);
            return null;
        }
        
        // API call to Cloudinary
        $timestamp = time();
        $folder = 'incident_videos';
        $publicId = 'incident_video_' . $timestamp . '_' . bin2hex(random_bytes(4));
        
        // Build signature parameters - REMOVE resource_type from here
        $paramsToSign = array(
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId
            // Removed 'resource_type' => 'video' from here
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
        
        error_log("String to sign: " . $signatureStr);
        error_log("Generated signature: " . $signature);
        
        // Prepare upload parameters - include resource_type here
        $postFields = array(
            'file' => new CURLFile($tempFilePath, 'video/mp4', 'video.mp4'),
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'signature' => $signature,
            'resource_type' => 'video'  // Keep it here in the request
        );
        
        // Initialize cURL
        $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/video/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        
        // Execute request
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Log response for debugging
        error_log("Cloudinary response code: " . $httpCode);
        error_log("Cloudinary response: " . $response);
        
        // Clean up
        curl_close($ch);
        unlink($tempFilePath);
        
        if ($curlError) {
            error_log("Curl error: " . $curlError);
            return null;
        }
        
        $result = json_decode($response, true);
        
        if ($httpCode != 200 || !isset($result['secure_url'])) {
            $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Unknown error';
            error_log("Cloudinary upload failed: " . $errorMsg);
            
            // Check for specific Cloudinary free plan errors
            if (strpos($errorMsg, 'storage quota') !== false) {
                throw new Exception('Cloudinary storage quota exceeded. Please upgrade your plan or delete old videos.');
            } elseif (strpos($errorMsg, 'bandwidth') !== false) {
                throw new Exception('Cloudinary bandwidth limit exceeded. Please upgrade your plan or try again later.');
            } elseif (strpos($errorMsg, 'duration') !== false) {
                throw new Exception('Video duration exceeds the 10-minute limit of the free plan.');
            } else {
                throw new Exception('Failed to upload video to Cloudinary: ' . $errorMsg);
            }
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

            if (isset($mediaData['images']) && is_array($mediaData['images'])) {
                error_log("Processing " . count($mediaData['images']) . " images");
                foreach ($mediaData['images'] as $base64Image) {
                    $imageUrl = uploadImageToCloudinary($base64Image);
                    
                    if ($imageUrl === null) {
                        throw new Exception('Failed to upload image to Cloudinary');
                    }
                    
                    $uploadedImages[] = $imageUrl;
                }
            }

            if (isset($mediaData['video']) && !empty($mediaData['video'])) {
                error_log("Processing video");
                $base64Video = $mediaData['video'];
                
                $videoUrl = uploadVideoToCloudinary($base64Video);
                
                if ($videoUrl === null) {
                    throw new Exception('Failed to upload video to Cloudinary');
                }
                
                $uploadedVideo = $videoUrl;
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