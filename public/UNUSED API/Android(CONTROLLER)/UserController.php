<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Android\User;

class UserController extends Controller
{
    public function checkVerificationStatus(Request $request)
    {
        $userId = $request->query('user_id');

        // Validate if user_id is provided
        if (!$userId) {
            return response()->json([
                'status' => 'error',
                'message' => 'User ID is required.'
            ], 400);
        }

        // Fetch user status
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.'
            ], 404);
        }

        // Build response
        $response = [
            'status' => $user->status,
            'message' => match ($user->status) {
                'verified' => 'Your account has been verified!',
                'rejected' => 'Your account has been rejected. Please contact support.',
                default => 'Your account is still pending verification.'
            }
        ];

        return response()->json($response);
    }
}
