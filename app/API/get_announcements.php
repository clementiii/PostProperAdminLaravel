<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database connection
include 'db.php';

/**
 * Helper function to process image URLs
 * @param string $imagePath The image path from database
 * @return string Properly formatted image URL
 */
function formatImageUrl($imagePath) {
    // If empty, return empty string
    if (empty($imagePath) || $imagePath === '/' || $imagePath === 'null') {
        return '';
    }
    
    // If it's already a full URL (Cloudinary or other external source)
    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        return $imagePath;
    }
    
    // Clean the path
    $imagePath = str_replace('\\/', '/', $imagePath);
    $imagePath = ltrim($imagePath, '/');
    $imagePath = trim($imagePath);
    
    // Create base URL
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'] . '/';
    
    // For local storage paths
    return $baseUrl . $imagePath;
}

try {
    // Query to get announcements
    $query = "SELECT * FROM barangay_announcements ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $announcements = array();
    
    while ($row = $stmt->fetch()) {
        // Get the raw image data
        $raw_images = $row['announcement_images'];
        
        // Initialize processed images array
        $processedImages = array();
        
        // Handle different types of image data
        if (!empty($raw_images)) {
            // First try to decode as JSON
            $images = json_decode($raw_images, true);
            
            // If json_decode failed, try to parse the string manually
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Remove extra escapes and try again
                $cleaned_json = stripslashes($raw_images);
                $images = json_decode($cleaned_json, true);
                
                // If still failed, try to parse the string as a comma-separated list
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // Check if it's a single string URL (Cloudinary case)
                    if (filter_var($raw_images, FILTER_VALIDATE_URL)) {
                        $images = [$raw_images];
                    } else {
                        // Try as a comma-separated list
                        $images = explode(',', str_replace(['[', ']', '"'], '', $raw_images));
                    }
                }
            }
            
            // Process images if we have any
            if (!empty($images) && is_array($images)) {
                foreach ($images as $image) {
                    if (!empty($image) && trim($image) !== '/' && trim($image) !== 'null') {
                        $processedImages[] = formatImageUrl($image);
                    }
                }
            } elseif (is_string($raw_images) && !empty(trim($raw_images)) && trim($raw_images) !== '/' && trim($raw_images) !== 'null') {
                // Handle the case where it might be a single string
                $processedImages[] = formatImageUrl($raw_images);
            }
        }
        
        // Format the announcement data
        $announcement = array(
            "id" => $row['id'],
            "announcement_title" => $row['announcement_title'],
            "description_text" => $row['description_text'],
            "announcement_images" => $processedImages,
            "created_at" => $row['created_at'],
            "posted_at" => $row['posted_at']
        );
        
        array_push($announcements, $announcement);
    }
    
    // Log the response for debugging (optional)
    error_log("Announcements response: " . json_encode($announcements));
    
    // Set response code - 200 OK and output the data
    http_response_code(200);
    echo json_encode($announcements);
    
} catch(PDOException $e) {
    // Set response code - 500 Internal server error
    http_response_code(500);
    echo json_encode(array("message" => "Error: " . $e->getMessage()));
    
    // Log the error for debugging
    error_log("Error in get_announcements.php: " . $e->getMessage());
}

// Close connection
$conn = null;
?>