<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\AdminProfile;
use Exception;

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
            
            $request->validate($rules);
            
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
        } catch (Exception $e) {
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
                // Configure Cloudinary directly using cURL
                $cloudName = env('CLOUDINARY_CLOUD_NAME', '');
                $apiKey = env('CLOUDINARY_API_KEY', '');
                $apiSecret = env('CLOUDINARY_API_SECRET', '');
                
                if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                    Log::error('Cloudinary credentials not found');
                    return redirect()->route('admin.profile')->with('error', 'Cloud storage is not properly configured. Please contact the administrator.');
                }
                
                // Prepare the file for upload
                $file = $request->file('profile_picture');
                $filePath = $file->getRealPath();
                
                // Prepare upload parameters
                $timestamp = time();
                $folder = 'admin_profile_pictures';
                $publicId = 'admin_' . $admin->id . '_' . $timestamp;
                
                // Generate signature
                $params = [
                    'folder' => $folder,
                    'public_id' => $publicId,
                    'timestamp' => $timestamp,
                ];
                ksort($params); // Sort params alphabetically
                
                $signature = '';
                foreach ($params as $key => $value) {
                    $signature .= $key . '=' . $value . '&';
                }
                $signature = rtrim($signature, '&');
                $signature .= $apiSecret;
                $signature = sha1($signature);
                
                // Prepare multipart form data
                $postFields = [
                    'file' => new \CURLFile($filePath),
                    'api_key' => $apiKey,
                    'timestamp' => $timestamp,
                    'folder' => $folder,
                    'public_id' => $publicId,
                    'signature' => $signature,
                ];
                
                // Initialize cURL and set options
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                // Execute the request
                $response = curl_exec($ch);
                
                // Check for errors
                if (curl_errno($ch)) {
                    Log::error('Cloudinary cURL error: ' . curl_error($ch));
                    curl_close($ch);
                    return redirect()->route('admin.profile')->with('error', 'Failed to upload image to cloud storage.');
                }
                
                curl_close($ch);
                
                // Process the response
                $result = json_decode($response, true);
                
                if (!isset($result['secure_url'])) {
                    Log::error('Cloudinary upload failed: ' . json_encode($result));
                    return redirect()->route('admin.profile')->with('error', 'Failed to upload image to cloud storage.');
                }
                
                // Update database with the cloudinary URL
                AdminProfile::where('id', $admin->id)->update([
                    'profile_picture' => $result['secure_url']
                ]);

                return redirect()->route('admin.profile')->with('success', 'Profile picture updated successfully.');
            }
            
            return redirect()->route('admin.profile')->with('error', 'No profile picture was uploaded.');
        } catch (Exception $e) {
            Log::error('Profile picture update error: ' . $e->getMessage());
            return redirect()->route('admin.profile')->with('error', 'An error occurred while updating your profile picture. Please try again.');
        }
    }
}