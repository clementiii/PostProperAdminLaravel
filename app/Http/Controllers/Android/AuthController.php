<?php
namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Android\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate request input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // Find user by username
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid username'
            ], 401);
        }

        // Check if password matches (Laravel hashed password or plain text)
        if ($user->password !== $request->password) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Invalid password'
            ], 401);
        }

        // Prepare response
        $response = [
            'status' => 'success',
            'id' => $user->id,
            'accountStatus' => $user->status
        ];

        // Check account status messages
        if ($user->status === 'pending') {
            $response['message'] = 'Your account is pending verification.';
        } else if ($user->status === 'rejected') {
            $response['message'] = 'Your account has been rejected.';
        }

        return response()->json($response);
    }
}
