<?php
require_once 'db.php';

header('Content-Type: application/json');

// Enable error reporting for debugging
error_log("Starting profile update process");

$response = array();

// Load environment variables from .env file
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
function uploadToCloudinary($file) {
    // Get Cloudinary credentials from environment variables
    $cloudName = getenv('CLOUDINARY_CLOUD_NAME');
    $apiKey = getenv('CLOUDINARY_API_KEY');
    $apiSecret = getenv('CLOUDINARY_API_SECRET');
    
    // Check if Cloudinary credentials are available
    if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
        error_log('Cloudinary credentials not found');
        return null;
    }
    
    // Check if file is valid
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return null;
    }
    
    try {
        // Check if image file is actual image
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            error_log("File is not an image");
            return null;
        }
        
        // Check file size (10MB max)
        if ($file["size"] > 10000000) {
            error_log("File is too large (max 10MB)");
            return null;
        }
        
        // Get file extension
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        
        // Prepare upload parameters
        $timestamp = time();
        $folder = 'user_profile_pictures'; // Folder in Cloudinary
        $publicId = 'user_profile_' . $timestamp . '_' . uniqid();
        
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
            return null;
        }
        
        curl_close($ch);
        $result = json_decode($response, true);
        
        // Check if Cloudinary response contains secure_url
        if (!isset($result['secure_url'])) {
            error_log('Cloudinary upload failed: ' . json_encode($result));
            return null;
        }
        
        error_log('Image uploaded to Cloudinary: ' . $result['secure_url']);
        // Return Cloudinary secure URL for the uploaded image
        return $result['secure_url'];
        
    } catch (Exception $e) {
        error_log("Cloudinary upload error: " . $e->getMessage());
        return null;
    }
}

// Function to handle local file upload (fallback)
function uploadToLocalStorage($file) {
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/user_profile_pictures/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = time() . '_' . uniqid() . '.jpg';
    $filePath = $targetDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        return 'storage/uploads/user_profile_pictures/' . $fileName;
    }
    
    return null;
}

try {
    if (!isset($_POST['user_id'])) {
        throw new Exception('No user ID provided');
    }

    $userId = $_POST['user_id'];
    $updates = array();

    // Handle profile picture upload if present
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_picture'];
        
        // Try Cloudinary upload first
        $cloudinaryUrl = uploadToCloudinary($file);
        
        if ($cloudinaryUrl) {
            // If Cloudinary upload succeeded, use the URL
            $updates['user_profile_picture'] = $cloudinaryUrl;
            error_log("Profile picture uploaded to Cloudinary: " . $cloudinaryUrl);
        } else {
            // If Cloudinary upload failed, fall back to local storage
            error_log("Cloudinary upload failed, falling back to local storage");
            
            // Create a temporary copy of the file since the original might have been consumed
            $tmpFile = array(
                'name' => $file['name'],
                'type' => $file['type'],
                'tmp_name' => $file['tmp_name'],
                'error' => $file['error'],
                'size' => $file['size']
            );
            
            $localPath = uploadToLocalStorage($tmpFile);
            if ($localPath) {
                $updates['user_profile_picture'] = $localPath;
                error_log("Profile picture saved to local storage: " . $localPath);
            } else {
                error_log("Failed to save profile picture to local storage");
            }
        }
    }

    // Handle other field updates
    if (isset($_POST['username']) && !empty($_POST['username'])) {
        $updates['username'] = $_POST['username'];
    }
    if (isset($_POST['adrHouseNo']) && !empty($_POST['adrHouseNo'])) {
        $updates['adrHouseNo'] = $_POST['adrHouseNo'];
    }
    if (isset($_POST['adrStreet']) && !empty($_POST['adrStreet'])) {
        $updates['adrStreet'] = $_POST['adrStreet'];
    }
    if (isset($_POST['adrZone']) && !empty($_POST['adrZone'])) {
        $updates['adrZone'] = $_POST['adrZone'];
    }

    // Handle password update with verification
    if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['currentPassword']) && !empty($_POST['currentPassword'])) {
        error_log("Attempting password update");
        
        // First verify the current password
        $stmt = $conn->prepare("SELECT password FROM user_accounts WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            error_log("User not found for ID: " . $userId);
            throw new Exception('User not found');
        }

        // Log password verification details (be careful with sensitive data in production)
        error_log("Stored password from DB: " . $user['password']);
        error_log("Current password from input: " . $_POST['currentPassword']);
        
        // Direct comparison of hashes
        if ($_POST['currentPassword'] !== $user['password']) {
            error_log("Password verification failed - Hashes don't match");
            throw new Exception('Current password is incorrect');
        }

        error_log("Password verification successful");
        // If verification passed, set the new password directly
        $updates['password'] = $_POST['password'];
    }

    if (!empty($updates)) {
        // Begin transaction
        $conn->beginTransaction();

        try {
            // Build and execute UPDATE query
            $sql = "UPDATE user_accounts SET ";
            $params = array();
            foreach ($updates as $key => $value) {
                $sql .= "$key = ?, ";
                $params[] = $value;
            }
            $sql = rtrim($sql, ', ');
            $sql .= " WHERE id = ?";
            $params[] = $userId;

            error_log("Update SQL: " . $sql);
            error_log("Update params (excluding sensitive data): " . count($params) . " parameters");

            $stmt = $conn->prepare($sql);
            if ($stmt->execute($params)) {
                // Fetch updated user data
                $selectStmt = $conn->prepare("SELECT * FROM user_accounts WHERE id = ?");
                $selectStmt->execute([$userId]);
                $user = $selectStmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $conn->commit();
                    $response['status'] = 'success';
                    $response['message'] = 'Profile updated successfully';
                    $response['user'] = array(
                        'id' => $user['id'],
                        'firstName' => $user['firstName'],
                        'lastName' => $user['lastName'],
                        'username' => $user['username'],
                        'age' => $user['age'],
                        'gender' => $user['gender'],
                        'adrHouseNo' => $user['adrHouseNo'],
                        'adrZone' => $user['adrZone'],
                        'adrStreet' => $user['adrStreet'],
                        'birthday' => $user['birthday'],
                        'user_profile_picture' => $user['user_profile_picture']
                    );
                } else {
                    throw new Exception('User not found after update');
                }
            } else {
                throw new Exception('Failed to update user data');
            }
        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }
    } else {
        throw new Exception('No fields to update');
    }

} catch (Exception $e) {
    error_log("Error in update_user_profile: " . $e->getMessage());
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

error_log("Final response: " . json_encode($response));
echo json_encode($response);
?>