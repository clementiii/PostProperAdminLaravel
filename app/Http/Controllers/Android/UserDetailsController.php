<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Android\User;

class UserDetailsController extends Controller
{
    public function fetchUserDetails(Request $request)
    {
        $userId = $request->query('id');
        
        if (!$userId) {
            return response()->json(['status' => 'failure', 'message' => 'User ID is required'], 400);
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json(['status' => 'failure', 'message' => 'User not found'], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'id' => $user->id,
            'firstName' => $user->firstName,
            'lastName' => $user->lastName,
            'username' => $user->username,
            'age' => $user->age,
            'gender' => $user->gender,
            'adrHouseNo' => $user->adrHouseNo,
            'adrZone' => $user->adrZone,
            'adrStreet' => $user->adrStreet,
            'birthday' => $user->birthday,
            'profilePicture' => $user->user_profile_picture
        ]);
    }
}
