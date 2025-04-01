<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use App\Models\Android\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class UserDetailsController extends Controller
{
    /**
     * Fetch user details by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getUserDetails($id): JsonResponse
    {
        $user = UserDetails::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'failure',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'username' => $user->username,
                'address' => $user->full_address,
                'age' => (int) $user->age,
                'gender' => $user->gender,
                'dateOfBirth' => $user->birthday,
                'password' => $user->password,
                'profilePicture' => url($user->user_profile_picture)
            ]
        ]);
    }

    /**
     * Update user's last active timestamp
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUserActivity(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:user_accounts,id',
        ]);

        $user = UserDetails::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'failure',
                'message' => 'User not found'
            ], 404);
        }

        // Only update last_active timestamp
        $user->last_active = Carbon::now('Asia/Manila');
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User activity updated successfully'
        ]);
    }
}
