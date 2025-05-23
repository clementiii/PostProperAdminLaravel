<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\API\ChatController;

// SIMPLE TEST ROUTE - This should work first
Route::get('android/test-endpoint', function() {
    return response()->json([
        'success' => true,
        'message' => 'API is working',
        'timestamp' => now()
    ]);
});

// Android Login 
Route::post('android/login', function() {
    // Capture the Laravel request and convert to POST vars for legacy compatibility
    request()->merge($_POST = request()->all());
    require app_path('API/Android_login.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// Verification Status Check (GET)
Route::get('android/check-verification', function() {
    $_GET = request()->query();
    require app_path('API/check_verification_status.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// User Details Fetch (GET)
Route::get('android/fetch-user-details', function() {
    $_GET = request()->query();
    require app_path('API/fetch_user_details.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

//Android Register
Route::post('android/register-user', function(Request $request) {
    // Properly format $_FILES array to match what PHP expects
    $_FILES = [];
    
    if ($request->hasFile('valid_id')) {
        $frontFile = $request->file('valid_id');
        $_FILES['valid_id'] = [
            'name' => $frontFile->getClientOriginalName(),
            'type' => $frontFile->getMimeType(),
            'tmp_name' => $frontFile->getPathname(),
            'error' => 0,
            'size' => $frontFile->getSize()
        ];
    }
    
    if ($request->hasFile('valid_id_back')) {
        $backFile = $request->file('valid_id_back');
        $_FILES['valid_id_back'] = [
            'name' => $backFile->getClientOriginalName(),
            'type' => $backFile->getMimeType(),
            'tmp_name' => $backFile->getPathname(),
            'error' => 0,
            'size' => $backFile->getSize()
        ];
    }
    
    // Set all other POST fields
    $_POST = $request->except(['valid_id', 'valid_id_back']);
    
    // Include the PHP file and capture its output
    ob_start();
    require app_path('API/register_user.php');
    $response = ob_get_clean();
    
    // Return the JSON response from the PHP file
    return response($response, 200)->header('Content-Type', 'application/json');
})->middleware('api');

//Submit Document Request
Route::post('android/document-requests', function () {
    require app_path('API/submit_document_request.php');
});

//Upload Requirements
Route::post('android/upload-requirements', function(Request $request) {
    // Properly format $_FILES array to match what PHP expects
    $_FILES = [];
    
    if ($request->hasFile('frontId')) {
        $frontFile = $request->file('frontId');
        $_FILES['frontId'] = [
            'name' => $frontFile->getClientOriginalName(),
            'type' => $frontFile->getMimeType(),
            'tmp_name' => $frontFile->getPathname(),
            'error' => 0,
            'size' => $frontFile->getSize()
        ];
    }
    
    if ($request->hasFile('backId')) {
        $backFile = $request->file('backId');
        $_FILES['backId'] = [
            'name' => $backFile->getClientOriginalName(),
            'type' => $backFile->getMimeType(),
            'tmp_name' => $backFile->getPathname(),
            'error' => 0,
            'size' => $backFile->getSize()
        ];
    }
    
    // Set all other POST fields
    $_POST = $request->except(['frontId', 'backId']);
    
    ob_start();
    require app_path('API/upload_requirements.php');
    $response = ob_get_clean();
    
    return response($response, 200)->header('Content-Type', 'application/json');
})->middleware('api');

// User Document Requests (GET)
Route::get('android/get-user-requests', function() {
    $_GET = request()->query();
    require app_path('API/get_user_requests.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// Check Document Request Limit (GET)
Route::get('android/check-document-limit', function() {
    $_GET = request()->query();
    require app_path('API/check_document_limit.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// Cancel Document Request (POST)
Route::post('android/cancel-request', function() {
    $_POST = request()->post();
    require app_path('API/cancel_request.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// Android Update User Profile
Route::post('android/update-user-profile', function(Request $request) {
    // Properly format $_FILES array to match what PHP expects
    $_FILES = [];
    
    if ($request->hasFile('profile_picture')) {
        $profilePicture = $request->file('profile_picture');
        $_FILES['profile_picture'] = [
            'name' => $profilePicture->getClientOriginalName(),
            'type' => $profilePicture->getMimeType(),
            'tmp_name' => $profilePicture->getPathname(),
            'error' => 0,
            'size' => $profilePicture->getSize()
        ];
    }
    
    // Set all other POST fields
    $_POST = $request->except(['profile_picture']);
    
    // Include the PHP file and capture its output
    ob_start();
    require app_path('API/update_user_profile.php');
    $response = ob_get_clean();
    
    // Return the JSON response from the PHP file
    return response($response, 200)->header('Content-Type', 'application/json');
})->middleware('api');

// Submit Incident Report
Route::post('android/incident-reports', function () {
    require app_path('API/submit_incident_report.php');
});

// Get User Incident Reports
Route::get('android/user-incident-reports', function () {
    require app_path('API/get_user_incident_reports.php');

});// post user incident reports video
Route::post('android/incident-reports-video', function () {
    require app_path('API/upload_video.php');
});

// update user activity
Route::post('android/update_user_activity', function () {
    require app_path('API/update_user_activity.php');
});

// Get Announcement
Route::get('android/get_announcements', function () {
    require app_path('API/get_announcements.php');
});

// Document Verification API
Route::post('android/verify-document', 'App\Http\Controllers\API\DocumentVerificationController@verify');

Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('api.chat.messages.index');
Route::post('/chat/messages', [ChatController::class, 'sendMessage'])->name('api.chat.messages.store');
// This is the route causing the 404
Route::get('/chat/messages/new', [ChatController::class, 'checkNewMessages'])->name('api.chat.messages.checkNew');

// REPLACE your existing notifications route with this fixed version
Route::get('android/notifications', function(Request $request) {
    try {
        $userId = $request->query('user_id');
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required'
            ], 400);
        }

        // Get notifications from database
        $notifications = DB::table('notifications')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Convert is_read from 0/1 to true/false
        $notifications = $notifications->map(function($notification) {
            $notification->is_read = (bool)$notification->is_read;
            return $notification;
        });

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error fetching notifications: ' . $e->getMessage()
        ], 500);
    }
});

Route::post('android/notifications/mark-read', function(Request $request) {
    try {
        $notificationId = $request->input('notification_id');
        
        if (!$notificationId) {
            return response()->json([
                'success' => false,
                'message' => 'Notification ID is required'
            ], 400);
        }
        
        $updated = DB::table('notifications')
            ->where('id', $notificationId)
            ->update(['is_read' => true]);
            
        if ($updated) {
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
        return response()->json([
            'success' => false,
            'message' => 'Error updating notification: ' . $e->getMessage()
        ], 500);
    }
});

// Test route to create a notification manually
Route::get('android/create-test-notification', function(Request $request) {
    try {
        $userId = $request->query('user_id', 58);
        
        DB::table('notifications')->insert([
            'user_id' => $userId,
            'type' => 'test',
            'title' => 'Test Notification',
            'message' => 'This is a test notification created at ' . now(),
            'related_id' => null,
            'is_read' => false,
            'created_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Test notification created for user ' . $userId
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error creating notification: ' . $e->getMessage()
        ]);
    }
});

// TEMPORARY - Cache clearing route
Route::get('android/clear-cache', function() {
    try {
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        
        return response()->json([
            'success' => true,
            'message' => 'Cache cleared successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error clearing cache: ' . $e->getMessage()
        ]);
    }
});

// Helper function to create notifications - Add this to your api.php
function createNotification($userId, $type, $title, $message, $relatedId = null) {
    try {
        DB::table('notifications')->insert([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'related_id' => $relatedId,
            'is_read' => false,
            'created_at' => now(),
        ]);
        return true;
    } catch (Exception $e) {
        Log::error('Error creating notification: ' . $e->getMessage());
        return false;
    }
}

// Route to create notifications for recent document status changes
Route::get('android/create-document-notifications', function() {
    try {
        $created = 0;
        
        // Get recently approved documents (last 30 days)
        $approvedDocs = DB::table('document_requests')
            ->where('Status', 'approved')
            ->where('date_approved', '>=', now()->subDays(30))
            ->get();
            
        foreach ($approvedDocs as $doc) {
            // Check if notification already exists for this document
            $existingNotification = DB::table('notifications')
                ->where('user_id', $doc->userId)
                ->where('type', 'document_status')
                ->where('related_id', $doc->Id)
                ->first();
                
            if (!$existingNotification) {
                $success = createNotification(
                    $doc->userId,
                    'document_status',
                    'Document Approved',
                    "Your {$doc->DocumentType} request has been approved and is ready for pickup.",
                    $doc->Id
                );
                if ($success) $created++;
            }
        }
        
        // Get recently rejected documents
        $rejectedDocs = DB::table('document_requests')
            ->where('Status', 'rejected')
            ->whereNotNull('rejection_reason')
            ->where('updated_at', '>=', now()->subDays(30))
            ->get();
            
        foreach ($rejectedDocs as $doc) {
            $existingNotification = DB::table('notifications')
                ->where('user_id', $doc->userId)
                ->where('type', 'document_status')
                ->where('related_id', $doc->Id)
                ->first();
                
            if (!$existingNotification) {
                $success = createNotification(
                    $doc->userId,
                    'document_status',
                    'Document Request Update',
                    "Your {$doc->DocumentType} request requires attention. Reason: {$doc->rejection_reason}",
                    $doc->Id
                );
                if ($success) $created++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Created {$created} notifications for recent document changes"
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
});

// Route to manually trigger notification for a specific document (for testing)
Route::get('android/notify-document-status', function(Request $request) {
    try {
        $documentId = $request->query('document_id');
        
        if (!$documentId) {
            return response()->json([
                'success' => false,
                'message' => 'Document ID is required'
            ], 400);
        }
        
        $doc = DB::table('document_requests')->where('Id', $documentId)->first();
        
        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Document not found'
            ], 404);
        }
        
        $message = '';
        $title = '';
        
        switch ($doc->Status) {
            case 'approved':
                $title = 'Document Approved';
                $message = "Your {$doc->DocumentType} request has been approved and is ready for pickup.";
                break;
            case 'rejected':
                $title = 'Document Request Update';
                $message = "Your {$doc->DocumentType} request requires attention. Reason: {$doc->rejection_reason}";
                break;
            case 'pending':
                $title = 'Document Under Review';
                $message = "Your {$doc->DocumentType} request is being reviewed.";
                break;
            default:
                $title = 'Document Status Update';
                $message = "Your {$doc->DocumentType} request status has been updated to: {$doc->Status}";
        }
        
        $success = createNotification(
            $doc->userId,
            'document_status',
            $title,
            $message,
            $doc->Id
        );
        
        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Notification created successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create notification'
            ]);
        }
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
});