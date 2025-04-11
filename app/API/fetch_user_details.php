<?php
@include 'dbSqli.php';

// Helper function to properly format profile picture URL
function formatProfilePictureUrl($path) {
    if (empty($path)) {
        return "";
    }
    
    // If it's already a full URL (Cloudinary or other external source)
    if (filter_var($path, FILTER_VALIDATE_URL)) {
        return $path;
    }
    
    // If it starts with storage/ or /storage/
    if (strpos($path, 'storage/') === 0) {
        return "https://" . $_SERVER['HTTP_HOST'] . "/" . $path;
    }
    
    // If it has a leading slash, remove it for consistency
    $path = ltrim($path, '/');
    
    // Return a complete URL
    return "https://" . $_SERVER['HTTP_HOST'] . "/" . $path;
}

// Check if the 'id' parameter is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL statement to fetch user details
    $sql = "SELECT firstName, lastName, username, age, gender, adrHouseNo, adrZone, adrStreet, birthday, password, user_profile_picture 
            FROM user_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        
        // Combine address fields
        $address = trim($row['adrHouseNo'] . ' ' . $row['adrZone'] . ' ' . $row['adrStreet']);
        
        // Create response array with correct field names
        $response = array(
            'status' => 'success',
            'user' => array(
                'firstName' => $row['firstName'],
                'lastName' => $row['lastName'],
                'username' => $row['username'],
                'address' => $address,
                'age' => intval($row['age']),
                'gender' => $row['gender'],
                'dateOfBirth' => $row['birthday'],
                'password' => $row['password'],
                'profilePicture' => formatProfilePictureUrl($row['user_profile_picture'])
            )
        );
        
        // Log the final response for debugging
        error_log("User details response: " . json_encode($response));
        
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'failure', 'message' => 'User not found']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'failure', 'message' => 'ID not provided']);
}

$conn->close();
?>