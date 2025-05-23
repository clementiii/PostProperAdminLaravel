<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function getUserNotifications(Request $request)
    {
        try {
            $userId = $request->query('user_id');
            
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID is required'
                ], 400);
            }

            $notifications = Notification::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            return response()->json([
                'success' => true,
                'notifications' => $notifications
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching notifications: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching notifications'
            ], 500);
        }
    }

    public function markAsRead(Request $request)
    {
        try {
            $notificationId = $request->input('notification_id');
            
            $notification = Notification::find($notificationId);
            if ($notification) {
                $notification->is_read = true;
                $notification->save();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Notification marked as read'
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating notification'
            ], 500);
        }
    }

    // Helper method to create notifications
    public static function createNotification($userId, $type, $title, $message, $relatedId = null)
    {
        try {
            return Notification::create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,  
                'related_id' => $relatedId,
                'is_read' => false
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating notification: ' . $e->getMessage());
            return null;
        }
    }
}