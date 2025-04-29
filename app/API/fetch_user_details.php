<?php
@include 'dbSqli.php';

// Helper function to properly format profile picture URL
function formatProfilePictureUrl($path) {
    if (empty($path) || $path === 'default.jpg') {
        return '';
    }
    
    // Check if the path is already a full URL (Cloudinary URL)
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
        return $path;
    }
    
    // Otherwise, assume it's a relative path and construct a full URL
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];
    return $base_url . '/' . $path;
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
        
        // Combine address fields for backward compatibility
        $address = '';
        if (!empty($row['adrHouseNo'])) {
            $address .= $row['adrHouseNo'] . ' ';
        }
        if (!empty($row['adrStreet'])) {
            $address .= $row['adrStreet'] . ' ';
        }
        if (!empty($row['adrZone'])) {
            $address .= 'Zone ' . $row['adrZone'];
        }
        $address = trim($address);
        
        // Create response array with both combined and separate address fields
        $response = array(
            'status' => 'success',
            'user' => array(
                'id' => $id,
                'firstName' => $row['firstName'],
                'lastName' => $row['lastName'],
                'username' => $row['username'],
                'address' => $address,  // Keep combined address for backward compatibility
                'age' => intval($row['age']),
                'gender' => $row['gender'],
                'dateOfBirth' => $row['birthday'],
                'password' => $row['password'],
                'profilePicture' => formatProfilePictureUrl($row['user_profile_picture']),
                // Add individual address fields for the app to use directly
                'houseNo' => $row['adrHouseNo'],
                'zone' => $row['adrZone'],
                'street' => $row['adrStreet']
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