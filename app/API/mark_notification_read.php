<?php
// app/API/mark_notification_read.php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

header('Content-Type: application/json');

try {
    // Get notification_id from POST data
    $notificationId = $_POST['notification_id'] ?? null;
    
    if (!$notificationId) {
        echo json_encode([
            'success' => false,
            'message' => 'Notification ID is required'
        ]);
        exit;
    }
    
    // Update notification as read
    $updated = DB::table('notifications')
        ->where('id', $notificationId)
        ->update(['is_read' => true]);
    
    if ($updated) {
        echo json_encode([
            'success' => true,
            'message' => 'Notification marked as read'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Notification not found'
        ]);
    }
    
} catch (Exception $e) {
    Log::error('Error marking notification as read: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error updating notification: ' . $e->getMessage()
    ]);
}