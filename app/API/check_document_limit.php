<?php
header('Content-Type: application/json');
date_default_timezone_set('Asia/Manila');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Get user ID from query parameters
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : null;
        
        // Validate userId
        if (!$userId) {
            throw new Exception('User ID is required');
        }
        
        // Check daily document request limit (4 per day)
        $today = date('Y-m-d');
        $checkLimitSql = "SELECT COUNT(*) FROM document_requests 
                          WHERE userId = :userId 
                          AND DATE(DateRequested) = :today";
        
        $checkStmt = $conn->prepare($checkLimitSql);
        $checkStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $checkStmt->bindParam(':today', $today);
        $checkStmt->execute();
        
        $dailyRequestCount = $checkStmt->fetchColumn();
        $requestsRemaining = 4 - $dailyRequestCount;
        $limitReached = $dailyRequestCount >= 4;
        
        echo json_encode([
            'success' => true,
            'limitReached' => $limitReached,
            'requestsRemaining' => max(0, $requestsRemaining),
            'totalRequests' => $dailyRequestCount,
            'message' => $limitReached ? 
                'Daily limit reached: You have already submitted 4 document requests today. Please try again tomorrow.' : 
                "You have {$requestsRemaining} document request(s) remaining today."
        ]);
        
    } catch (Exception $e) {
        error_log("Error checking document limit: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error checking request limit: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
