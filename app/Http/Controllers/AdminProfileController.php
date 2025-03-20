<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin_accounts,username,' . $admin->id,
            'current_password' => 'nullable|required_with:new_password,password_confirmation|min:6',
            'new_password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $admin->name = $request->name;
        $admin->username = $request->username;

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Incorrect current password.']);
            }
            $admin->password = Hash::make($request->new_password);
        }

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
}
