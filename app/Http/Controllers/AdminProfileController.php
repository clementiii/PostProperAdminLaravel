<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        return view('admin_profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:admin_accounts,username,' . Auth::id(),
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:6',
            'confirm_password' => 'same:new_password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $admin = Auth::user();
        
        // Handle password verification
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }
        }

        // Update admin information
        $admin->name = $request->name;
        $admin->username = $request->username;
        
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($admin->profile_picture && Storage::exists('public/' . $admin->profile_picture)) {
                Storage::delete('public/' . $admin->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/admin_profile_pictures', $filename);
            $admin->profile_picture = 'admin_profile_pictures/' . $filename;
        }

        // Update password if provided
        if ($request->new_password) {
            $admin->password = Hash::make($request->new_password);
        }

        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully'
        ]);
    }
}