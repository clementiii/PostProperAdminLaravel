<?php
// app/API/get_notifications.php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

header('Content-Type: application/json');

try {
    // Get user_id from query parameters
    $userId = $_GET['user_id'] ?? null;
    
    if (!$userId) {
        echo json_encode([
            'success' => false,
            'message' => 'User ID is required'
        ]);
        exit;
    }
    
    // Query notifications using Laravel's DB facade
    $notifications = DB::table('notifications')
        ->where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get()
        ->toArray();
    
    // Convert to proper format
    $notifications = array_map(function($notification) {
        $notificationArray = (array)$notification;
        $notificationArray['is_read'] = (bool)$notificationArray['is_read'];
        return $notificationArray;
    }, $notifications);
    
    echo json_encode([
        'success' => true,
        'notifications' => $notifications
    ]);
    
} catch (Exception $e) {
    Log::error('Error fetching notifications: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching notifications: ' . $e->getMessage()
    ]);
}