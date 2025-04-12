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
function uploadVideoToCloudinary($base64Video) {
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
        $base64Video = str_replace('data:video/mp4;base64,', '', $base64Video);
        $base64Video = str_replace(' ', '+', $base64Video);
        
        // Decode base64 to binary
        $videoData = base64_decode($base64Video);
        if ($videoData === false) {
            throw new Exception('Failed to decode base64 video');
        }
        
        // Create a temporary file
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];
        file_put_contents($tempFilePath, $videoData);
        
        // Prepare upload parameters
        $timestamp = time();
        $folder = 'incident_videos'; // Separate folder for videos
        $publicId = 'incident_video_' . $timestamp . '_' . bin2hex(random_bytes(8));
        
        // Generate signature
        $params = [
            'folder' => $folder,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'resource_type' => 'video',
            // Video optimization parameters
            'eager' => 'q_auto:low,w_640', // Auto quality optimization and resize
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
            'file' => new CURLFile($tempFilePath, 'video/mp4', 'video.mp4'),
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'signature' => $signature,
            'resource_type' => 'video',
            'eager' => $params['eager'],
        ];
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/video/upload");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5-minute timeout for video upload
        
        // Execute request
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            error_log('Cloudinary video cURL error: ' . curl_error($ch));
            curl_close($ch);
            fclose($tempFile); // Close the temporary file
            return null;
        }
        
        curl_close($ch);
        fclose($tempFile); // Close the temporary file
        
        $result = json_decode($response, true);
        
        // Check if Cloudinary response contains secure_url
        if (!isset($result['secure_url'])) {
            error_log('Cloudinary video upload failed: ' . json_encode($result));
            return null;
        }
        
        // Return Cloudinary secure URL for the uploaded video
        error_log('Successfully uploaded video to Cloudinary: ' . $result['secure_url']);
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
        
        // Create directory if it doesn't exist
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/incident_videos/";
        $relativePath = "/storage/uploads/incident_videos/"; // Relative path for database storage
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate unique filename
        $timestamp = time();
        $randomString = bin2hex(random_bytes(8));
        $filename = $timestamp . '_' . $randomString . '.mp4';
        
        // Use absolute path for file operations
        $filepath = $targetDir . $filename;
        
        // Use relative path for database storage
        $databasePath = $relativePath . $filename;
        
        // Decode and save video
        $videoData = base64_decode($base64Video);
        if ($videoData === false) {
            throw new Exception('Failed to decode base64 video');
        }

        if (file_put_contents($filepath, $videoData) === false) {
            throw new Exception('Failed to save video file');
        }
        
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