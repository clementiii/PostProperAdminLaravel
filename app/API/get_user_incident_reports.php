<?php
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
        
        if (!$userId) {
            throw new Exception('User ID is required');
        }
        
        $sql = "SELECT i.id, i.title, i.description, i.incident_picture, 
                       i.date_submitted, i.status, i.resolved_at, i.name 
                FROM incident_reports i 
                WHERE i.user_id = :userId 
                ORDER BY date_submitted DESC";
                
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'reports' => $reports
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>