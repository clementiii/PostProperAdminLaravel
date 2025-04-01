<?php
// Database configuration
$host = 'localhost';        
$db = 'pps_barangay_system'; 
$user = 'root';             
$pass = '';                 

try {
    // Create a new connection using PDO
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: set the default fetch mode to fetch associative arrays
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Error handling if the connection fails
    echo "Database connection failed: " . $e->getMessage();
    exit; // Exit if the database connection fails
}
?>
