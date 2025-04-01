<?php

namespace App\Http\Controllers\Android;

use App\Http\Controllers\Controller;
use App\Models\Android\UserProfileUpdate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserProfileUpdateController extends Controller
{
    /**
     * Update user profile (username, address, password, profile picture).
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(Request $request): JsonResponse
    {
        Log::info("Starting profile update process");
        
        if (!$request->has('user_id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'No user ID provided'
            ], 400);
        }

        $userId = $request->user_id;
        $updates = [];

        // Find the user
        $user = UserProfileUpdate::find($userId);
        if (!$user) {
            Log::error("User not found for ID: " . $userId);
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        // Handle profile picture upload if present
        if ($request->hasFile('profile_picture')) {
            try {
                $file = $request->file('profile_picture');
                
                // Validate file
                if (!$file->isValid()) {
                    Log::error("Invalid file upload");
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid file upload'
                    ], 400);
                }

                // Generate unique filename
                $fileName = $userId . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Define storage path
                $storagePath = 'uploads/user_profile_pictures';

                // Store the file
                $filePath = $file->storeAs($storagePath, $fileName, 'public');

                // Update user's profile picture path
                $updates['user_profile_picture'] = 'storage/' . $filePath;
                $user->user_profile_picture = $updates['user_profile_picture'];

                Log::info("Profile picture uploaded successfully: " . $filePath);
            } catch (\Exception $e) {
                Log::error("Profile picture upload error: " . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to upload profile picture'
                ], 500);
            }
        }

        // Handle field updates
        if ($request->filled('username')) {
            $updates['username'] = $request->username;
            $user->username = $request->username;
        }
        
        if ($request->filled('adrHouseNo')) {
            $updates['adrHouseNo'] = $request->adrHouseNo;
            $user->adrHouseNo = $request->adrHouseNo;
        }
        
        if ($request->filled('adrStreet')) {
            $updates['adrStreet'] = $request->adrStreet;
            $user->adrStreet = $request->adrStreet;
        }
        
        if ($request->filled('adrZone')) {
            $updates['adrZone'] = $request->adrZone;
            $user->adrZone = $request->adrZone;
        }

        // Handle password update with verification
        if ($request->filled('password') && $request->filled('currentPassword')) {
            Log::info("Attempting password update");
            
            // Direct comparison of passwords (matching your original code's approach)
            if ($request->currentPassword !== $user->password) {
                Log::error("Password verification failed - Passwords don't match");
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect'
                ], 401);
            }

            Log::info("Password verification successful");
            $updates['password'] = $request->password;
            $user->password = $request->password;
        }

        // Update last_active timestamp with Filipino time
        $user->last_active = Carbon::now('Asia/Manila');

        if (!empty($updates)) {
            try {
                if ($user->save()) {
                    // Refresh the user instance to get the updated data
                    $user = UserProfileUpdate::find($userId);
                    
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Profile updated successfully',
                        'user' => [
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
                            'user_profile_picture' => $user->user_profile_picture
                        ]
                    ]);
                } else {
                    throw new \Exception('Failed to update user data');
                }
            } catch (\Exception $e) {
                Log::error("Error in updateProfile: " . $e->getMessage());
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No fields to update'
            ], 400);
        }
    }
    
    /**
     * Update user's last active timestamp with Filipino time
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUserActivity(Request $request): JsonResponse
    {
        if (!$request->has('user_id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'No user ID provided'
            ], 400);
        }

        $user = UserProfileUpdate::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        // Update last_active timestamp with Filipino time (UTC+8)
        $user->last_active = Carbon::now('Asia/Manila');
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User activity updated successfully'
        ]);
    }
}