<?php
// List of files to update
$files = [
    'app/API/db.php',
    'app/API/dbSqli.php'
];

// Get Heroku database variables
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_name = getenv('DB_DATABASE') ?: 'pps_barangay_system';
$db_user = getenv('DB_USERNAME') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Update the content with the environment variables
    $content = preg_replace('/\$host\s*=\s*\'[^\']*\'/', "\$host = '$db_host'", $content);
    $content = preg_replace('/\$db\s*=\s*\'[^\']*\'/', "\$db = '$db_name'", $content);
    $content = preg_replace('/\$user\s*=\s*\'[^\']*\'/', "\$user = '$db_user'", $content);
    $content = preg_replace('/\$pass\s*=\s*\'[^\']*\'/', "\$pass = '$db_pass'", $content);
    
    // For mysqli
    $content = preg_replace('/\$servername\s*=\s*\"[^\"]*\"/', "\$servername = \"$db_host\"", $content);
    $content = preg_replace('/\$username\s*=\s*\"[^\"]*\"/', "\$username = \"$db_user\"", $content);
    $content = preg_replace('/\$password\s*=\s*\"[^\"]*\"/', "\$password = \"$db_pass\"", $content);
    $content = preg_replace('/\$dbname\s*=\s*\"[^\"]*\"/', "\$dbname = \"$db_name\"", $content);
    
    file_put_contents($file, $content);
}

echo "Database connection files updated!";
?>