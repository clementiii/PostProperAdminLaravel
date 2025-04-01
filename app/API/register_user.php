<?php

@include 'dbSqli.php';

// Set response header to JSON
header('Content-Type: application/json');

// Function to handle file upload
function handleFileUpload($file, $prefix = '') {
    // Set the correct target directory path 
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/storage/uploads/valid_ids/";
    
    // Debug information
    error_log("Target directory: " . $targetDir);
    error_log("File upload details: " . print_r($file, true));
    
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        return ["success" => false, "message" => "No file was uploaded."];
    }

    // Create directory if it doesn't exist
    if (!file_exists($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            error_log("Failed to create directory: " . $targetDir);
            return ["success" => false, "message" => "Failed to create upload directory."];
        }
    }

    // Generate unique filename with prefix
    $uniqueFilename = uniqid() . '_' . $prefix . basename($file["name"]);
    $targetFile = $targetDir . $uniqueFilename;
    $relativePath = "/storage/uploads/valid_ids/" . $uniqueFilename; // Store relative path in database
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    try {
        $check = getimagesize($file["tmp_name"]);
        if($check === false) {
            return ["success" => false, "message" => "File is not an image."];
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error checking image: " . $e->getMessage()];
    }
    
    // Check file size (10MB max)
    if ($file["size"] > 10000000) {
        return ["success" => false, "message" => "File is too large (max 5MB)."];
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return ["success" => false, "message" => "Only JPG, JPEG, PNG files are allowed."];
    }
    
    // Try to upload file
    try {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            chmod($targetFile, 0644); // Set proper permissions
            return ["success" => true, "filepath" => $relativePath]; // Return relative path
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

// Validate and process registration
try {
    // Log received data (excluding password)
    $logData = $_POST;
    if (isset($logData['password'])) {
        unset($logData['password']);
    }
    error_log("Received registration data: " . print_r($logData, true));
    error_log("Files received: " . print_r($_FILES, true));

    // Check required fields
    if (!isset($_POST['firstName'], $_POST['lastName'], $_POST['username'], 
               $_POST['password'], $_FILES['valid_id'], $_FILES['valid_id_back'])) {
        throw new Exception('Missing required fields: ' . implode(', ', array_keys(array_filter([
            'firstName' => !isset($_POST['firstName']),
            'lastName' => !isset($_POST['lastName']),
            'username' => !isset($_POST['username']),
            'password' => !isset($_POST['password']),
            'valid_id' => !isset($_FILES['valid_id']),
            'valid_id_back' => !isset($_FILES['valid_id_back'])
        ]))));
    }
    
    // Get and sanitize input data
    $firstName = $conn->real_escape_string($_POST['firstName']);
    $lastName = $conn->real_escape_string($_POST['lastName']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $age = isset($_POST['age']) ? intval($_POST['age']) : null;
    $birthday = isset($_POST['birthday']) ? $conn->real_escape_string($_POST['birthday']) : null;
    $houseNo = isset($_POST['adrHouseNo']) ? $conn->real_escape_string($_POST['adrHouseNo']) : null;
    $zone = isset($_POST['adrZone']) ? $conn->real_escape_string($_POST['adrZone']) : null;
    $street = isset($_POST['adrStreet']) ? $conn->real_escape_string($_POST['adrStreet']) : null;
    $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : null;
    
    // Check if username exists
    $check_stmt = $conn->prepare("SELECT id FROM user_accounts WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    if ($check_stmt->get_result()->num_rows > 0) {
        throw new Exception('Username already exists');
    }
    $check_stmt->close();

    // Handle front valid ID upload
    $validIdUpload = handleFileUpload($_FILES['valid_id'], 'front_');
    if (!$validIdUpload['success']) {
        throw new Exception('Front ID: ' . $validIdUpload['message']);
    }

    // Handle back valid ID upload
    $validIdBackUpload = handleFileUpload($_FILES['valid_id_back'], 'back_');
    if (!$validIdBackUpload['success']) {
        throw new Exception('Back ID: ' . $validIdBackUpload['message']);
    }
    
    date_default_timezone_set('Asia/Manila');
    $created_at = date('Y-m-d H:i:s');
    
    // Insert new user with both front and back IDs and created_at timestamp
    $insert_query = "INSERT INTO user_accounts (firstName, lastName, username, password, 
                    age, birthday, adrHouseNo, adrZone, adrStreet, gender, 
                    user_valid_id, user_valid_id_back, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";
    
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssissssssss", 
        $firstName, $lastName, $username, $password, 
        $age, $birthday, $houseNo, $zone, $street, $gender,
        $validIdUpload['filepath'], $validIdBackUpload['filepath'],
        $created_at
    );
    
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful',
            'id' => $conn->insert_id 
        ]);
    } else {
        throw new Exception('Registration failed: ' . $stmt->error);
    }

} catch (Exception $e) {
    error_log("Registration error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
}
?>