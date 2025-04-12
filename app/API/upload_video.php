<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Cloudinary credentials - hardcoded for simplicity
$cloudName = "hwovp9krt";
$apiKey = "613375141957299";
$apiSecret = "ip4PaEblMwn5dtzcnUPCLPwVmM0";

// Get parameters from request
$timestamp = $_POST['timestamp'] ?? null;
$signature = $_POST['signature'] ?? null;
$folder = $_POST['folder'] ?? null;
$publicId = $_POST['public_id'] ?? null;
$apiKeyFromRequest = $_POST['api_key'] ?? null;

// Check required fields
if (!$timestamp || !$signature || !$folder || !$publicId || !$apiKeyFromRequest || !isset($_FILES['file'])) {
    echo json_encode([
        'error' => [
            'message' => 'Missing required parameters'
        ]
    ]);
    exit;
}

// Verify API key
if ($apiKeyFromRequest !== $apiKey) {
    echo json_encode([
        'error' => [
            'message' => 'Invalid API key'
        ]
    ]);
    exit;
}

// Verify signature
$expectedSignature = sha1("folder=$folder&public_id=$publicId&timestamp=$timestamp$apiSecret");
if ($signature !== $expectedSignature) {
    echo json_encode([
        'error' => [
            'message' => 'Invalid signature'
        ]
    ]);
    exit;
}

// Check if file was uploaded successfully
if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'error' => [
            'message' => 'File upload error: ' . $_FILES['file']['error']
        ]
    ]);
    exit;
}

// Prepare upload to Cloudinary
$file = $_FILES['file']['tmp_name'];
$fileType = $_FILES['file']['type'];
$fileName = $_FILES['file']['name'];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/$cloudName/video/upload");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_VERBOSE, true);

// Prepare multipart form data
$postFields = [
    'file' => new CURLFile($file, $fileType, $fileName),
    'timestamp' => $timestamp,
    'folder' => $folder,
    'public_id' => $publicId,
    'api_key' => $apiKey,
    'signature' => $signature,
    'resource_type' => 'video'
];

curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

// Execute request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Handle response
if ($response === false) {
    echo json_encode([
        'error' => [
            'message' => 'cURL error: ' . curl_error($ch)
        ]
    ]);
} else {
    // Just pass through the Cloudinary response
    echo $response;
}

curl_close($ch);
?>