<?php
header('Content-Type: application/json');
require_once 'db.php';

// Simple function to load environment variables from .env file
function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        
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
    
    return true;
}

// Load environment variables from .env file
$envPath = $_SERVER['DOCUMENT_ROOT'] . '/.env';
loadEnv($envPath);

// Function to upload file to Cloudinary
function uploadToCloudinary($file, $prefix = '') {
    // Get Cloudinary credentials from environment variables
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    // Check if Cloudinary credentials are available
    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
        error_log('Cloudinary credentials not found');
        return ["success" => false, "message" => "Cloud storage is not properly configured."];
    }
    
    // Check if file is valid
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ["success" => false, "message" => "No file was uploaded."];
    }
    
    try {
        // Check if image file is actual image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            return ["success" => false, "message" => "File is not an image."];
        }
        
        // Check file size (10MB max)
        if ($file["size"] > 10000000) {
            return ["success" => false, "message" => "File is too large (max 10MB)."];
        }
        
        // Get file extension
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return ["success" => false, "message" => "Only JPG, JPEG, PNG files are allowed."];
        }
        
        // Prepare upload parameters
        $timestamp = time();
        $folder = 'valid_ids'; // Folder in Cloudinary
        $publicId = 'valid_id_' . $timestamp . '_' . $prefix . uniqid();
        
        // Generate signature
        $params = [
            'folder' => $folder,
            'public_id' => $publicId,
            'timestamp' => $timestamp,
            'format' => $imageFileType,
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
            'file' => new CURLFile($file["tmp_name"]),
            'api_key' => $apiKey,
            'timestamp' => $timestamp,
            'folder' => $folder,
            'public_id' => $publicId,
            'format' => $imageFileType,
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
            return handleLocalFileUpload($file, $prefix);
        }
        
        curl_close($ch);
        $result = json_decode($response, true);
        
        if (!isset($result['secure_url'])) {
            error_log('Cloudinary upload failed: ' . json_encode($result));
            return handleLocalFileUpload($file, $prefix);
        }
        
        return ["success" => true, "filepath" => $result['secure_url']];
        
    } catch (Exception $e) {
        error_log("Cloudinary upload error: " . $e->getMessage());
        return handleLocalFileUpload($file, $prefix);
    }
}

// Function to handle local file upload as fallback
function handleLocalFileUpload($file, $prefix = '') {
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/valid_ids/";
    
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ["success" => false, "message" => "No file was uploaded."];
    }

    if (!file_exists($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            error_log("Failed to create directory: " . $targetDir);
            return ["success" => false, "message" => "Failed to create upload directory."];
        }
    }

    $uniqueFilename = uniqid() . '_' . $prefix . basename($file["name"]);
    $targetFile = $targetDir . $uniqueFilename;
    $relativePath = "/storage/uploads/valid_ids/" . $uniqueFilename;
    
    try {
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            return ["success" => false, "message" => "File is not an image."];
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error checking image: " . $e->getMessage()];
    }
    
    if ($file["size"] > 10000000) {
        return ["success" => false, "message" => "File is too large (max 10MB)."];
    }
    
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return ["success" => false, "message" => "Only JPG, JPEG, PNG files are allowed."];
    }
    
    try {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            chmod($targetFile, 0644);
            return ["success" => true, "filepath" => $relativePath];
        } else {
            $errorDetails = error_get_last();
            error_log("Upload failed. Error: " . ($errorDetails ? $errorDetails['message'] : 'Unknown error'));
            return ["success" => false, "message" => "Failed to move uploaded file. Check directory permissions."];
        }
    } catch (Exception $e) {
        error_log("Exception during file upload: " . $e->getMessage());
        return ["success" => false, "message" => "Error during file upload: " . $e->getMessage()];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $requestId = $_POST['requestId'];
        $errors = [];

        // Handle front ID upload
        if (isset($_FILES['frontId'])) {
            $validIdFrontUpload = uploadToCloudinary($_FILES['frontId'], 'front_');
            if (!$validIdFrontUpload['success']) {
                throw new Exception('Front ID: ' . $validIdFrontUpload['message']);
            }
            $validIdFrontPath = $validIdFrontUpload['filepath'];
        } else {
            $errors[] = 'Front ID image is required';
        }

        // Handle back ID upload
        if (isset($_FILES['backId'])) {
            $validIdBackUpload = uploadToCloudinary($_FILES['backId'], 'back_');
            if (!$validIdBackUpload['success']) {
                throw new Exception('Back ID: ' . $validIdBackUpload['message']);
            }
            $validIdBackPath = $validIdBackUpload['filepath'];
        } else {
            $errors[] = 'Back ID image is required';
        }

        // If there are any errors, throw an exception
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }

        // Update database
        $stmt = $conn->prepare("UPDATE document_requests SET 
            valid_id_front = :frontId,
            valid_id_back = :backId,
            Quantity = :quantity 
            WHERE Id = :requestId");

        $stmt->bindParam(':frontId', $validIdFrontPath);
        $stmt->bindParam(':backId', $validIdBackPath);
        $stmt->bindParam(':quantity', $_POST['quantity']);
        $stmt->bindParam(':requestId', $requestId);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'Requirements uploaded successfully',
                'front_path' => $validIdFrontPath,
                'back_path' => $validIdBackPath
            ]);
        } else {
            throw new Exception('Failed to update database');
        }

    } catch (Exception $e) {
        error_log("Upload error: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error uploading requirements: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>