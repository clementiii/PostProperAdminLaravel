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
        return view('admin.admin_profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:admin_accounts,username,' . $admin->id,
            'current_password' => 'required_with:new_password|nullable|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Check if the user wants to update their username or password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            // Update username if provided
            $admin->username = $request->username;

            // Update password if provided
            if ($request->filled('new_password')) {
                $admin->password = Hash::make($request->new_password);
            }
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $admin = Auth::user();

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($admin->profile_picture && Storage::exists('public/' . $admin->profile_picture)) {
                Storage::delete('public/' . $admin->profile_picture);
            }

            // Store new image
            $path = $request->file('profile_picture')->store('admin_profile_pictures', 'public');
            $admin->profile_picture = 'storage/' . $path;
            $admin->save();
        }

        return redirect()->route('admin.profile')->with('success', 'Profile picture updated successfully.');
    }
}
