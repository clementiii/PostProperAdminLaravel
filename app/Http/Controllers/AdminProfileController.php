<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\AdminProfile;

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
            // Base validation rules
            $validator = $request->validate([
                'username' => ['required', 'string', 'max:255', 'unique:admin_accounts,username,' . $admin->id],
                'current_password' => ['required', 'string'],
                'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
            ]);
            
            // Always verify current password
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withInput()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            
            // Check if username is being changed
            $isUsernameChanged = $request->username !== $admin->username;
            
            // Prepare data to update
            $data = [];
            
            // Add username to data if it's changed
            if ($isUsernameChanged) {
                $data['username'] = $request->username;
            }
            
            // Add password to data if it's provided
            if ($request->filled('new_password')) {
                $data['password'] = Hash::make($request->new_password);
            }
            
            // Update the admin profile without timestamps
            if (!empty($data)) {
                AdminProfile::where('id', $admin->id)->update($data);
                
                // Provide specific feedback on what was updated
                if ($isUsernameChanged && $request->filled('new_password')) {
                    return redirect()->route('admin.profile')->with('success', 'Username and password updated successfully.');
                } elseif ($isUsernameChanged) {
                    return redirect()->route('admin.profile')->with('success', 'Username updated successfully.');
                } elseif ($request->filled('new_password')) {
                    return redirect()->route('admin.profile')->with('success', 'Password updated successfully.');
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
                // Delete old profile picture if it exists
                if ($admin->profile_picture) {
                    if (Storage::disk('public')->exists($admin->profile_picture)) {
                        Storage::disk('public')->delete($admin->profile_picture);
                    }
                }

                // Generate a sanitized filename and store the file
                $extension = $request->file('profile_picture')->getClientOriginalExtension();
                $filename = 'admin_' . time() . '_' . rand(1000, 9999) . '.' . $extension;
                $storagePath = 'admin_profile_pictures';
                $path = $request->file('profile_picture')->storeAs($storagePath, $filename, 'public');
                
                // Update database with the file path
                AdminProfile::where('id', $admin->id)->update([
                    'profile_picture' => $path
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