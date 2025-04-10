<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\AdminProfile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('admin.admin_profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();
        
        try {
            // Validate the request
            $rules = [
                'username' => ['required', 'string', 'max:255', 'unique:admin_accounts,username,' . $admin->id],
                'current_password' => ['required', 'string'],
                'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
            ];
            
            // Add name field if it's present in the request
            if ($request->has('name')) {
                $rules['name'] = ['required', 'string', 'max:255'];
            }
            
            $validator = $request->validate($rules);
            
            // Always verify current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withInput()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            
            // Check if username is being changed
            $isUsernameChanged = $request->username !== $admin->username;
            $isNameChanged = isset($request->name) && $request->name !== $admin->name;
            
            // Prepare data to update
            $data = [];
            
            // Add username to data if it's changed
            if ($isUsernameChanged) {
                $data['username'] = $request->username;
            }
            
            // Add name to data if it's changed
            if ($isNameChanged) {
                $data['name'] = $request->name;
            }
            
            // Add password to data if it's provided
            if ($request->filled('new_password')) {
                $data['password'] = Hash::make($request->new_password);
            }
            
            // Update the admin profile without timestamps
            if (!empty($data)) {
                AdminProfile::where('id', $admin->id)->update($data);
                
                // Provide specific feedback on what was updated
                $updates = [];
                if ($isUsernameChanged) $updates[] = 'username';
                if ($isNameChanged) $updates[] = 'name';
                if ($request->filled('new_password')) $updates[] = 'password';
                
                if (count($updates) > 0) {
                    $updateMsg = implode(' and ', $updates);
                    return redirect()->route('admin.profile')->with('success', ucfirst($updateMsg) . ' updated successfully.');
                }
            } else {
                // No changes were made
                return redirect()->route('admin.profile')->with('info', 'No changes were made to your profile.');
            }
            
            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Profile update error: ' . $e->getMessage());
            
            // Return generic error message to the user
            return redirect()->route('admin.profile')->with('error', 'An error occurred while updating your profile. Please try again.');
        }
    }

    public function updateProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            ]);

            $admin = Auth::user();

            if ($request->hasFile('profile_picture')) {
                // Upload image to Cloudinary
                $uploadedFileUrl = Cloudinary::upload($request->file('profile_picture')->getRealPath(), [
                    'folder' => 'admin_profile_pictures',
                    'public_id' => 'admin_' . $admin->id . '_' . time(),
                    'overwrite' => true,
                    'resource_type' => 'image'
                ])->getSecurePath();

                // Delete old profile picture from Cloudinary if it exists
                if ($admin->profile_picture && strpos($admin->profile_picture, 'cloudinary.com') !== false) {
                    // Extract public_id from the URL
                    $parts = parse_url($admin->profile_picture);
                    $path = pathinfo($parts['path']);
                    $publicId = 'admin_profile_pictures/' . basename($path['dirname']) . '/' . $path['filename'];
                    
                    try {
                        // Delete the old image - wrapped in try/catch since old images might not exist
                        Cloudinary::destroy($publicId);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old Cloudinary image: ' . $e->getMessage());
                    }
                }
                
                // Update database with the cloudinary URL
                AdminProfile::where('id', $admin->id)->update([
                    'profile_picture' => $uploadedFileUrl
                ]);

                return redirect()->route('admin.profile')->with('success', 'Profile picture updated successfully.');
            }
            
            return redirect()->route('admin.profile')->with('error', 'No profile picture was uploaded.');
        } catch (\Exception $e) {
            Log::error('Profile picture update error: ' . $e->getMessage());
            return redirect()->route('admin.profile')->with('error', 'An error occurred while updating your profile picture. Please try again.');
        }
    }
}