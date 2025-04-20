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
    // --- index() method remains the same (with previous optimizations) ---
    public function index()
    {
        // Refined query to fetch users, their latest message details, and order by latest message time
        $usersWithMessages = UserAccount::select('user_accounts.*')
            ->selectSub(function ($query) {
                $query->select('timestamp')
                    ->from('messages')
                    ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'last_message_time_ts')
            ->selectSub(function ($query) {
                $query->select('message')
                    ->from('messages')
                     ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'latest_message_text')
             ->selectSub(function ($query) {
                $query->select('is_admin')
                    ->from('messages')
                     ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 0); })
                    ->orWhere(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id')->where('messages.is_admin', 1); })
                    ->orderBy('timestamp', 'desc')->limit(1);
            }, 'latest_message_is_admin')
            ->whereExists(function ($query) {
                 $query->select(DB::raw(1)) ->from('messages')
                       ->where(function($subQuery) { $subQuery->whereColumn('messages.sender_id', 'user_accounts.id'); });
            })
            ->orderByDesc('last_message_time_ts')
            ->get();

        $selectedUser = null;
        $messages = collect();
        return view('help-desk.index', compact('usersWithMessages', 'selectedUser', 'messages'));
    }

    // --- getUserMessages() method remains the same ---
    public function getUserMessages(Request $request)
    {
        $request->validate([ 'user_id' => 'required|integer|exists:user_accounts,id', ]);
        $userId = $request->user_id;
        $user = UserAccount::findOrFail($userId);
        $messages = Message::where('sender_id', $userId) ->orderBy('timestamp', 'asc')->get();
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
         $message->timestamp = Carbon::now();
         $message->save();
         return response()->json([ 'status' => 'success', 'message' => $message ]);
     }

    // --- getMessages() method remains the same (potentially unused) ---
    public function getMessages(Request $request)
    {
        // ... (keep existing code for getMessages) ...
         $request->validate([ 'user_id' => 'sometimes|integer|exists:user_accounts,id', ]);
         $userId = $request->user_id;
         if (!$userId) {
              $usersWithMessages = UserAccount::whereHas('messages') ->with(['messages' => function ($query) { $query->orderBy('timestamp', 'desc')->limit(1); }]) ->orderBy('last_active', 'desc') ->get();
             return response()->json([ 'users' => $usersWithMessages ]);
         }
         $user = UserAccount::find($userId);
          if (!$user) { return response()->json(['error' => 'User not found'], 404); }
         $messages = Message::where('sender_id', $userId) ->orderBy('timestamp', 'asc') ->get();
         return response()->json($messages);
    }


    // ** ADD THIS METHOD FOR POLLING **
    public function checkNewMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:user_accounts,id',
            'last_message_timestamp' => 'required|numeric', // Expecting milliseconds from JS
        ]);

        $userId = $request->user_id;
        $lastTimestampMillis = $request->last_message_timestamp;

        // Convert milliseconds timestamp to a Carbon instance for comparison
        // Divide by 1000 to get seconds, then createFromTimestamp
        $lastCheckedTime = Carbon::createFromTimestampMs($lastTimestampMillis);

        // Query for new messages for this user context (sent by user or admin)
        // where the timestamp is strictly greater than the last checked time
        $newMessages = Message::where('sender_id', $userId)
                            ->where('timestamp', '>', $lastCheckedTime)
                            ->orderBy('timestamp', 'asc')
                            ->get();

        return response()->json([
            'hasNewMessages' => $newMessages->isNotEmpty(),
            'newMessages' => $newMessages
        ]);
    }

}
