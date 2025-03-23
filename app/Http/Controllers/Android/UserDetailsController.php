<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use App\Models\Android\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
                'profilePicture' => url($user->user_profile_picture) // Convert to full URL
            ]
        ]);
    }
}
