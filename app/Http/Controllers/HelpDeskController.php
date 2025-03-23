<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpDeskController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('sender_id', $user->id)
                         ->orWhere(function($query) use ($user) {
                             $query->where('admin_id', $user->id)
                                   ->where('is_admin', true);
                         })
                         ->orderBy('timestamp', 'desc')
                         ->get();
                         
        return view('help-desk.index', compact('messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->message = $request->message;
        $message->is_admin = Auth::user()->is_admin ?? false;
        $message->save();

        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function getMessages(Request $request)
    {
        $messages = Message::where('sender_id', Auth::id())
                         ->orWhere(function($query) {
                             $query->where('admin_id', Auth::id())
                                   ->where('is_admin', true);
                         })
                         ->orderBy('timestamp', 'desc')
                         ->get();

        return response()->json($messages);
    }
} 