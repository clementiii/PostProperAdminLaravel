<?php
require_once 'db.php';

// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Increase PHP limits
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);
ini_set('post_max_size', '50M');
ini_set('upload_max_filesize', '50M');

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
    error_log("Failed to load environment variables. Using fallback local storage for images.");
}

// Function to upload image to Cloudinary
function uploadToCloudinary($base64Image) {
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
        error_log('Successfully uploaded to Cloudinary: ' . $result['secure_url']);
        return $result['secure_url'];
        
    } catch (Exception $e) {
        error_log("Cloudinary upload error: " . $e->getMessage());
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
        error_log("Local storage error: " . $e->getMessage());
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

    // Handle image uploads if present
    if (!empty($_POST['incident_picture'])) {
        try {
            // Decode the JSON array of images
            $imageArray = json_decode($_POST['incident_picture'], true);
            
            // Check if decode was successful and it's an array
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid image data format');
            }

            // Process each image in the array
            foreach ($imageArray as $base64Image) {
                // First try uploading to Cloudinary
                $imageUrl = uploadToCloudinary($base64Image);
                
                // If Cloudinary upload failed, fall back to local storage
                if ($imageUrl === null) {
                    error_log("Cloudinary upload failed, falling back to local storage");
                    $imageUrl = saveImageLocally($base64Image);
                    
                    if ($imageUrl === null) {
                        throw new Exception('Failed to save image');
                    }
                }
                
                // Add the URL to our array
                $uploadedImages[] = $imageUrl;
            }
        } catch (Exception $e) {
            error_log("Image processing error: " . $e->getMessage());
            throw new Exception('Failed to process images: ' . $e->getMessage());
        }
    }

    // Convert image array to JSON
    $incident_picture_json = json_encode($uploadedImages);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO incident_reports (name, title, description, incident_picture, date_submitted, status) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    
    if (!$stmt->execute([$name, $title, $description, $incident_picture_json, $date_submitted, $status])) {
        throw new Exception('Database insertion failed: ' . implode(", ", $stmt->errorInfo()));
    }

    $response['status'] = 'success';
    $response['message'] = 'Incident report submitted successfully';
    $response['images'] = $uploadedImages; // Return the image URLs in the response

} catch (Exception $e) {
    error_log("Error in submit_incident_report.php: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);