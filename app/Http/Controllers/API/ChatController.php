<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\UserAccount;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function __construct()
    {
        // Set the default timezone for all Carbon instances in this controller
        date_default_timezone_set('Asia/Manila');
        Carbon::setLocale('en');
    }

    /**
     * Fetch chat messages for the authenticated user.
     */
    public function getMessages(Request $request)
    {
        $userId = $request->query('user_id');

        if (!$userId) {
            return response()->json(['error' => 'User ID not specified'], 400);
        }

        try {
            $messages = Message::where('sender_id', $userId)
                            ->with(['sender', 'admin'])
                            ->orderBy('timestamp', 'asc')
                            ->get();

            // Format messages for API response
            $formattedMessages = $messages->map(function ($message) use ($userId) {
                return $this->formatMessageForApi($message, $userId);
            });

            return response()->json($formattedMessages);

        } catch (\Exception $e) {
            Log::error("API GetMessages Error for user {$userId}: " . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve messages.'], 500);
        }
    }

    /**
     * Store a new chat message sent by the authenticated user.
     */
    public function sendMessage(Request $request)
    {
        $userId = $request->input('sender_id');
        if (!$userId || !UserAccount::find($userId)) { 
            return response()->json(['status' => 'error', 'message' => 'Valid Sender ID is required.'], 400); 
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $message = new Message();
            $message->sender_id = $userId;
            $message->message = $request->input('message');
            $message->is_admin = 0;
            $message->admin_id = null;
            
            // Explicitly set timestamp to Philippines time
            $message->timestamp = Carbon::now('Asia/Manila');
            
            $message->save();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error("API SendMessage Error for user {$userId}: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to send message.'], 500);
        }
    }

    /**
     * Check for new messages since a given timestamp for the authenticated user.
     */
    public function checkNewMessages(Request $request)
    {
        $userId = $request->query('user_id');
        if (!$userId) { 
            return response()->json(['error' => 'User ID not specified'], 400); 
        }

        $validator = Validator::make($request->all(), [
            'last_message_timestamp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Missing or invalid last_message_timestamp parameter.'], 400);
        }

        $lastTimestampMillis = $request->query('last_message_timestamp');

        try {
            // Convert milliseconds timestamp to a Carbon instance in Philippines timezone
            $lastCheckedTime = Carbon::createFromTimestampMs($lastTimestampMillis, 'Asia/Manila');

            // Query for new messages
            $newMessages = Message::where('sender_id', $userId)
                                ->where('timestamp', '>', $lastCheckedTime)
                                ->with(['sender', 'admin'])
                                ->orderBy('timestamp', 'asc')
                                ->get();

            // Format the new messages
            $formattedMessages = $newMessages->map(function ($message) use ($userId) {
                return $this->formatMessageForApi($message, $userId);
            });

            return response()->json([
                'hasNewMessages' => $formattedMessages->isNotEmpty(),
                'newMessages' => $formattedMessages
            ]);

        } catch (\Exception $e) {
            Log::error("API CheckNewMessages Error for user {$userId}: " . $e->getMessage());
            return response()->json(['error' => 'Failed to check for new messages.'], 500);
        }
    }

    /**
     * Helper method to format a Message object for API response.
     */
    private function formatMessageForApi(Message $message, $contextUserId): array
    {
        $senderName = 'Unknown';
        if ($message->is_admin) {
            $senderName = $message->admin->name ?? 'Admin';
        } else {
            if ($message->sender_id == $contextUserId && $message->sender) {
                $senderName = $message->sender->firstName . ' ' . $message->sender->lastName;
            }
        }

        // Ensure the timestamp is in Philippines timezone
        $timestamp = $message->timestamp 
            ? Carbon::parse($message->timestamp)->setTimezone('Asia/Manila') 
            : Carbon::now('Asia/Manila');
        
        // Convert to milliseconds for Android
        $timestampMillis = $timestamp->valueOf();

        return [
            'id' => $message->id,
            'sender_id' => $message->sender_id,
            'admin_id' => $message->admin_id,
            'message' => $message->message,
            'is_admin' => (bool)$message->is_admin,
            'timestamp' => $timestampMillis,
            'sender_name' => $senderName
        ];
    }
}