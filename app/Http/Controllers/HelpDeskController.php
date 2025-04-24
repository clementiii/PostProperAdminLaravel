<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\UserAccount;
use App\Models\AdminAccount; // Using the provided AdminAccount model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Import DB facade
use Carbon\Carbon;

class HelpDeskController extends Controller
{
    /**
     * Display the help desk index page with ALL users.
     * Users are ordered alphabetically. Latest message details are included if available.
     */
    public function index()
    {
        // ** FIX: Fetch ALL users, not just those with messages **
        $allUsers = UserAccount::select('user_accounts.*')
            // Subquery to get latest timestamp (will be NULL if no messages)
            ->selectSub(function ($query) {
                $query->select('timestamp')
                    ->from('messages')
                    ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'last_message_time_ts')
             // Subquery to get latest message text (will be NULL if no messages)
            ->selectSub(function ($query) {
                $query->select('message')
                    ->from('messages')
                     ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'latest_message_text')
             // Subquery to check if latest message was from admin (will be NULL if no messages)
             ->selectSub(function ($query) {
                $query->select('is_admin')
                    ->from('messages')
                     ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'latest_message_is_admin')
            // ** FIX: Removed the whereExists clause that filtered users **
            // ->whereExists(...) // <-- REMOVED

            // ** FIX: Changed ordering to alphabetical **
            ->orderBy('firstName', 'asc')
            ->orderBy('lastName', 'asc')
            ->get();

        $selectedUser = null; // No user selected initially
        $messages = collect(); // No messages loaded initially

        // ** FIX: Pass the new variable name to the view **
        return view('help-desk.index', compact('allUsers', 'selectedUser', 'messages'));
    }

    // --- getUserMessages() method remains the same ---
    public function getUserMessages(Request $request)
    {
        $request->validate([ 'user_id' => 'required|integer|exists:user_accounts,id', ]);
        $userId = $request->user_id;
        $user = UserAccount::findOrFail($userId);
        // Ensure messages related to the user are fetched correctly
        $messages = Message::where('sender_id', $userId)
                        // ->where(function($query) use ($userId) { // Original logic might be slightly off if admin messages don't use user's ID as sender_id
                        //     $query->where('sender_id', $userId)
                        //           ->where('is_admin', 0); // User sent
                        // })->orWhere(function($query) use ($userId) {
                        //     $query->where('sender_id', $userId) // Check if this is correct for admin messages context
                        //           ->where('is_admin', 1); // Admin sent
                        // })
                        ->orderBy('timestamp', 'asc')
                        ->get();
        return response()->json([ 'user' => $user, 'messages' => $messages ]);
    }

    // --- sendMessage() method remains the same ---
     public function sendMessage(Request $request)
     {
         $request->validate([
             'message' => 'required|string|max:1000',
             'user_id' => 'required|integer|exists:user_accounts,id',
         ]);
         $message = new Message();
         $message->sender_id = $request->user_id;
         $message->admin_id = Auth::id();
         $message->message = $request->message;
         $message->is_admin = true;
         $message->timestamp = Carbon::now(); // Explicitly set timestamp
         $message->save();
         // Optionally load admin relationship if needed in response
         // $message->load('admin');
         return response()->json([ 'status' => 'success', 'message' => $message ]);
     }

    // --- getMessages() method remains the same (potentially unused) ---
    public function getMessages(Request $request)
    {
         $request->validate([ 'user_id' => 'sometimes|integer|exists:user_accounts,id', ]);
         $userId = $request->user_id;
         if (!$userId) {
              // When fetching all users, maybe return all users instead of just those with messages?
              // Or perhaps this endpoint isn't needed if index() shows all users.
              $allUsers = UserAccount::orderBy('firstName')->orderBy('lastName')->get(); // Example: Fetch all
              // $usersWithMessages = UserAccount::whereHas('messages') ->with(['messages' => function ($query) { $query->orderBy('timestamp', 'desc')->limit(1); }]) ->orderBy('last_active', 'desc') ->get();
             return response()->json([ 'users' => $allUsers ]); // Return all users if no specific ID
         }
         $user = UserAccount::find($userId);
          if (!$user) { return response()->json(['error' => 'User not found'], 404); }
         // Fetch messages like getUserMessages
         $messages = Message::where('sender_id', $userId)->orderBy('timestamp', 'asc')->get();
         return response()->json($messages);
    }


    // --- checkNewMessages() method remains the same ---
    public function checkNewMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:user_accounts,id',
            'last_message_timestamp' => 'required|numeric',
        ]);
        $userId = $request->user_id;
        $lastTimestampMillis = $request->last_message_timestamp;
        $lastCheckedTime = Carbon::createFromTimestampMs($lastTimestampMillis);

        $newMessages = Message::where('sender_id', $userId)
                            ->where('timestamp', '>', $lastCheckedTime)
                            // Eager load relationships if needed by formatMessageForApi (which isn't used here)
                            // ->with(['sender', 'admin'])
                            ->orderBy('timestamp', 'asc')
                            ->get();

        // ** Important: Need to format these messages if the web JS expects it **
        // Assuming the web JS polling (if any) handles raw message data or doesn't use this specific endpoint.
        // If the web JS *does* use this and needs formatted data, apply formatting similar to the Api/ChatController.
        
        return response()->json([
            'hasNewMessages' => $newMessages->isNotEmpty(),
            'newMessages' => $newMessages // Returning raw messages for now
        ]);
    }

}
