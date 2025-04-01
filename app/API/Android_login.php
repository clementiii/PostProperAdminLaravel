<?php
require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Http\Kernel::class)
    ->handle($request = Illuminate\Http\Request::capture());

// Get database config from Laravel
$config = $app->make('config')->get('database.connections.mysql');

// Create connection using Laravel's config
$conn = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]));
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Modified SQL to include status check
    $sql = "SELECT id, password, status FROM user_accounts WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $inputUsername, $inputPassword);
    $stmt->execute();
    $stmt->store_result();

    $response = array();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $storedPassword, $accountStatus);
        $stmt->fetch();
    
        if ($inputPassword == $storedPassword) {
            $response['status'] = 'success';
            $response['id'] = $userId;
            $response['accountStatus'] = $accountStatus;
            
            if ($accountStatus === 'pending') {
                $response['message'] = 'Your account is pending verification.';
            } else if ($accountStatus === 'rejected') {
                $response['message'] = 'Your account has been rejected.';
            }
        } else {
            $response['status'] = 'failure';
            $response['message'] = 'Invalid password';
        }
    } else {
        $response['status'] = 'failure';
        $response['message'] = 'Invalid username';
    }

    $stmt->close();
    $conn->close();
    
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('status' => 'failure', 'message' => 'Username or password not provided.');
    echo json_encode($response);
}
?>