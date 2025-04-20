<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\UserAccount;
use App\Models\AdminAccount;
use Illuminate\Support\Facades\Auth; // Needed for authentication
use Illuminate\Support\Facades\DB;   // If using DB facade for specific queries
use Illuminate\Support\Facades\Log;  // For logging errors
use Illuminate\Support\Facades\Validator; // For input validation
use Carbon\Carbon;                  // For timestamp handling

class ChatController extends Controller
{
    /**
     * Fetch chat messages for the authenticated user.
     * Replicates logic from old get_messages.php
     */
    public function getMessages(Request $request)
    {
        // --- Authentication ---
        // IMPORTANT: Use proper API authentication (e.g., Sanctum)
        // $userId = Auth::id(); // Use this once auth is set up
        $userId = $request->query('user_id'); // TEMPORARY

        if (!$userId) {
             return response()->json(['error' => 'User ID not specified'], 400);
        }

        try {
            $messages = Message::where('sender_id', $userId)
                            ->with(['sender', 'admin']) // Eager load
                            ->orderBy('timestamp', 'asc')
                            ->get();

            // Use the helper method to format messages
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
     * Replicates logic from old send_user_message.php
     */
    public function sendMessage(Request $request)
    {
        // --- Authentication ---
        // IMPORTANT: Use proper API authentication (e.g., Sanctum)
        // $userId = Auth::id(); // Use this once auth is set up
         $userId = $request->input('sender_id'); // TEMPORARY & INSECURE
         if (!$userId || !UserAccount::find($userId)) { return response()->json(['status' => 'error', 'message' => 'Valid Sender ID is required.'], 400); }
        // --- End Temporary Auth ---

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 422);
        }

        try {
            $message = new Message();
            $message->sender_id = $userId; // Should use Auth::id()
            $message->message = $request->input('message');
            $message->is_admin = 0;
            $message->admin_id = null;
            $message->save(); // DB default timestamp will be used

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error("API SendMessage Error for user {$userId}: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to send message.'], 500);
        }
    }

    /**
     * Check for new messages since a given timestamp for the authenticated user.
     * Replicates logic from old check_new_messages.php
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkNewMessages(Request $request)
    {
        // --- Authentication ---
        // IMPORTANT: Use proper API authentication (e.g., Sanctum)
        // $userId = Auth::id(); // Use this once auth is set up
        $userId = $request->query('user_id'); // TEMPORARY
        if (!$userId) { return response()->json(['error' => 'User ID not specified'], 400); }
        // --- End Temporary Auth ---

        // Validate the timestamp parameter
        $validator = Validator::make($request->all(), [
            'last_message_timestamp' => 'required|numeric', // Expecting milliseconds
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Missing or invalid last_message_timestamp parameter.'], 400);
        }

        $lastTimestampMillis = $request->query('last_message_timestamp');

        try {
            // Convert milliseconds timestamp to a Carbon instance for comparison
            $lastCheckedTime = Carbon::createFromTimestampMs($lastTimestampMillis);

            // Query for new messages for this user context
            // where the timestamp is strictly greater than the last checked time
            // Potential issue: If DB timestamp precision is only seconds, this might refetch messages from the same second.
            $newMessages = Message::where('sender_id', $userId)
                                ->where('timestamp', '>', $lastCheckedTime)
                                ->with(['sender', 'admin']) // Eager load
                                ->orderBy('timestamp', 'asc')
                                ->get();

            // Format the new messages using the helper method
            $formattedMessages = $newMessages->map(function ($message) use ($userId) {
                return $this->formatMessageForApi($message, $userId);
            });

            // Return response matching MessageCheckResponse.java
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
     *
     * @param Message $message The Eloquent message object.
     * @param int $contextUserId The ID of the user whose chat context this is.
     * @return array Formatted message data.
     */
    private function formatMessageForApi(Message $message, $contextUserId): array
    {
        $senderName = 'Unknown';
        if ($message->is_admin) {
            // If message is from admin, use admin name or 'Admin'
            // Assumes 'admin' relationship is loaded via with()
            $senderName = $message->admin->name ?? 'Admin';
        } else {
            // If message is from user, use user's name
            // Assumes 'sender' relationship is loaded via with()
             if ($message->sender_id == $contextUserId && $message->sender) {
                 $senderName = $message->sender->firstName . ' ' . $message->sender->lastName;
             }
        }

        // Convert timestamp to milliseconds for Android (long)
        $timestampMillis = $message->timestamp ? Carbon::parse($message->timestamp)->valueOf() : 0;

        return [
            'id' => $message->id,
            'sender_id' => $message->sender_id, // Keep original sender_id for context
            'admin_id' => $message->admin_id,
            'message' => $message->message,
            'is_admin' => (bool)$message->is_admin,
            'timestamp' => $timestampMillis, // Milliseconds timestamp
            'sender_name' => $senderName
        ];
    }

}
