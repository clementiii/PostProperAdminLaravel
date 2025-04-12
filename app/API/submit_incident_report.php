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
    error_log("Failed to load environment variables. Using fallback local storage for media.");
}

// Function to upload image to Cloudinary
function uploadImageToCloudinary($base64Image) {
    // Get Cloudinary credentials from environment variables
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    // Check if Cloudinary credentials are available
    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
        error_log('Cloudinary credentials not found');
        return null;
    }
    
    try {
        // Remove the data URI header if present
        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
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
// Enhanced function to upload video to Cloudinary with better error handling
function uploadVideoToCloudinary($base64Video) {
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    // Debug environment variables
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
        $base64Video = preg_replace('/\s+/', '', $base64Video); // Remove any whitespace
        
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
        
        // Create a temporary file with .mp4 extension
        $tempFilePath = tempnam(sys_get_temp_dir(), 'vid_') . '.mp4';
        file_put_contents($tempFilePath, $videoData);
        
        // Check if it's a valid video file by examining first bytes
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $tempFilePath);
        finfo_close($fileInfo);
        
        error_log("File MIME type: " . $mimeType);
        
        if (strpos($mimeType, 'video/') !== 0 && strpos($mimeType, 'application/octet-stream') !== 0) {
            error_log("Not a valid video file: " . $mimeType);
            unlink($tempFilePath);
            return null;
        }
        
        // API call to Cloudinary
        $timestamp = time();
        $folder = 'incident_videos';
        $publicId = 'incident_video_' . $timestamp . '_' . bin2hex(random_bytes(4));
        
        // Build signature
        $paramsToSign = array(
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId
        );
        
        ksort($paramsToSign);
        
        $signatureStr = '';
        foreach ($paramsToSign as $key => $value) {
            $signatureStr .= $key . '=' . $value . '&';
        }
        $signatureStr = rtrim($signatureStr, '&');
        $signatureStr .= $apiSecret;
        
        $signature = sha1($signatureStr);
        
        error_log("String to sign: " . $signatureStr);
        error_log("Generated signature: " . $signature);
        
        // Explicitly set the content type and filename
        $postFields = array(
            'file' => new CURLFile($tempFilePath, 'video/mp4', 'video.mp4'),
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'api_key' => $apiKey,
            'signature' => $signature,
            'resource_type' => 'video'
        );
        
        $ch = curl_init("https://api.cloudinary.com/v1_1/{$cloudName}/video/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 180);
        
        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
        unlink($tempFilePath); // Clean up
        
        if ($curlError) {
            error_log("Curl error: " . $curlError);
            return null;
        }
        
        error_log("Cloudinary response: " . $response);
        $result = json_decode($response, true);
        
        if ($httpCode != 200 || !isset($result['secure_url'])) {
            $errorMsg = isset($result['error']['message']) ? $result['error']['message'] : 'Unknown error';
            error_log("Cloudinary upload failed: " . $errorMsg);
            return null;
        }
        
        return $result['secure_url'];
    } catch (Exception $e) {
        error_log("Cloudinary video upload error: " . $e->getMessage());
        return null;
    }
}

// Fallback function to save image locally
function saveImageLocally($base64Image) {
    try {
        // Remove the data URI header if present
        $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
        $base64Image = str_replace(' ', '+', $base64Image);
        
        // Create directory if it doesn't exist
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/incident_reports/";
        $relativePath = "/storage/uploads/incident_reports/"; // Relative path for database storage
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate unique filename
        $timestamp = time();
        $randomString = bin2hex(random_bytes(8));
        $filename = $timestamp . '_' . $randomString . '.jpg';
        
        // Use absolute path for file operations
        $filepath = $targetDir . $filename;
        
        // Use relative path for database storage
        $databasePath = $relativePath . $filename;
        
        // Decode and save image
        $imageData = base64_decode($base64Image);
        if ($imageData === false) {
            throw new Exception('Failed to decode base64 image');
        }

        if (file_put_contents($filepath, $imageData) === false) {
            throw new Exception('Failed to save image file');
        }
        
        return $databasePath;
    } catch (Exception $e) {
        error_log("Local image storage error: " . $e->getMessage());
        return null;
    }
}

// Fallback function to save video locally
function saveVideoLocally($base64Video) {
    try {
        // Remove the data URI header if present
        $base64Video = str_replace('data:video/mp4;base64,', '', $base64Video);
        $base64Video = str_replace(' ', '+', $base64Video);
        
        // Log the length of the base64 string for debugging
        $base64Length = strlen($base64Video);
        error_log("Video base64 string length: " . $base64Length);
        
        // Create directory if it doesn't exist
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/incident_videos/";
        $relativePath = "/storage/uploads/incident_videos/"; // Relative path for database storage
        
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                error_log("Failed to create directory: " . $targetDir);
                throw new Exception('Failed to create directory for video storage');
            } else {
                // Set permissions explicitly
                chmod($targetDir, 0777);
                error_log("Created directory with permissions: " . $targetDir);
            }
        }
        
        // Check if directory is writable
        if (!is_writable($targetDir)) {
            error_log("Directory is not writable: " . $targetDir);
            throw new Exception('Video upload directory is not writable');
        }
        
        // Generate unique filename
        $timestamp = time();
        $randomString = bin2hex(random_bytes(8));
        $filename = $timestamp . '_' . $randomString . '.mp4';
        
        // Use absolute path for file operations
        $filepath = $targetDir . $filename;
        
        // Use relative path for database storage
        $databasePath = $relativePath . $filename;
        
        // Decode and save video - limit to 100MB
        $maxSize = 100 * 1024 * 1024; // 100MB in bytes
        
        // Check base64 length first (base64 is ~33% larger than binary)
        if ($base64Length > ($maxSize * 1.33)) {
            error_log("Video too large: " . $base64Length . " bytes in base64");
            throw new Exception('Video size exceeds limit (100MB)');
        }
        
        // Decode base64
        $videoData = base64_decode($base64Video);
        if ($videoData === false) {
            error_log("Failed to decode base64 video data");
            throw new Exception('Failed to decode base64 video');
        }
        
        // Get actual size of decoded data
        $videoSize = strlen($videoData);
        error_log("Decoded video size: " . $videoSize . " bytes");
        
        if ($videoSize > $maxSize) {
            error_log("Decoded video too large: " . $videoSize . " bytes");
            throw new Exception('Video size exceeds limit (100MB)');
        }
        
        // Try to save the file with error handling
        $bytesWritten = file_put_contents($filepath, $videoData);
        if ($bytesWritten === false) {
            error_log("Failed to write video file: " . error_get_last()['message']);
            throw new Exception('Failed to save video file: ' . error_get_last()['message']);
        }
        
        error_log("Successfully saved video file: " . $filepath . " (" . $bytesWritten . " bytes)");
        return $databasePath;
    } catch (Exception $e) {
        error_log("Local video storage error: " . $e->getMessage());
        return null;
    }
}

$response = array();

try {
    // Log incoming data
    error_log("Received POST data: " . print_r($_POST, true));

    // Check if all required fields are present
    if (!isset($_POST['user_id']) || !isset($_POST['title']) || !isset($_POST['description'])) {
        throw new Exception('Missing required fields');
    }

    // Get user details for the name
    $stmt = $conn->prepare("SELECT firstName, lastName FROM user_accounts WHERE id = ?");
    $stmt->execute([$_POST['user_id']]);
    $user = $stmt->fetch();

    if (!$user) {
        throw new Exception('User not found');
    }

    $name = $user['firstName'] . ' ' . $user['lastName'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date_submitted = date('Y-m-d H:i:s');
    $status = 'pending';
    $uploadedImages = array();
    $uploadedVideo = null;

    // Handle media uploads if present
    if (!empty($_POST['media_data'])) {
        try {
            // Decode the JSON object containing images and video
            $mediaData = json_decode($_POST['media_data'], true);
            
            // Check if decode was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid media data format: ' . json_last_error_msg());
            }

            // Process images if present
            if (isset($mediaData['images']) && is_array($mediaData['images'])) {
                foreach ($mediaData['images'] as $base64Image) {
                    // First try uploading to Cloudinary
                    $imageUrl = uploadImageToCloudinary($base64Image);
                    
                    // If Cloudinary upload failed, fall back to local storage
                    if ($imageUrl === null) {
                        error_log("Cloudinary image upload failed, falling back to local storage");
                        $imageUrl = saveImageLocally($base64Image);
                        
                        if ($imageUrl === null) {
                            throw new Exception('Failed to save image');
                        }
                    }
                    
                    // Add the URL to our array
                    $uploadedImages[] = $imageUrl;
                }
            }

            // Process video if present
            if (isset($mediaData['video']) && !empty($mediaData['video'])) {
                $base64Video = $mediaData['video'];
                
                // First try uploading to Cloudinary
                $videoUrl = uploadVideoToCloudinary($base64Video);
                
                // If Cloudinary upload failed, fall back to local storage
                if ($videoUrl === null) {
                    error_log("Cloudinary video upload failed, falling back to local storage");
                    $videoUrl = saveVideoLocally($base64Video);
                    
                    if ($videoUrl === null) {
                        throw new Exception('Failed to save video');
                    }
                }
                
                $uploadedVideo = $videoUrl;
            }
        } catch (Exception $e) {
            error_log("Media processing error: " . $e->getMessage());
            throw new Exception('Failed to process media: ' . $e->getMessage());
        }
    }

    // Convert image array to JSON
    $incident_picture_json = json_encode($uploadedImages);
    
    // Check if the incident_reports table has the incident_video column
    $stmt = $conn->prepare("SHOW COLUMNS FROM incident_reports LIKE 'incident_video'");
    $stmt->execute();
    $columnExists = $stmt->fetch();
    
    if (!$columnExists) {
        // Add the column if it doesn't exist
        $stmt = $conn->prepare("ALTER TABLE incident_reports ADD COLUMN incident_video VARCHAR(255) NULL AFTER incident_picture");
        $stmt->execute();
        error_log("Added incident_video column to incident_reports table");
    }

    // Insert into database (including incident_video field)
    $stmt = $conn->prepare("INSERT INTO incident_reports (name, title, description, incident_picture, incident_video, date_submitted, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt->execute([$name, $title, $description, $incident_picture_json, $uploadedVideo, $date_submitted, $status])) {
        throw new Exception('Database insertion failed: ' . implode(", ", $stmt->errorInfo()));
    }

    $response['status'] = 'success';
    $response['message'] = 'Incident report submitted successfully';
    $response['images'] = $uploadedImages; // Return the image URLs in the response
    $response['video'] = $uploadedVideo; // Return the video URL in the response

} catch (Exception $e) {
    error_log("Error in submit_incident_report.php: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);