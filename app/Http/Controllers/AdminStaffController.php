<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminStaffController extends Controller
{
    public function index()
    {
        $adminStaff = Admin::all();
        return view('admin_staff', compact('adminStaff'));
    }
    
    public function delete($id)
    {
        // Ensure only the logged-in admin can delete their own account
        if (Auth::id() != $id) {
            return redirect()->back()->with('error', 'You can only delete your own account.');
        }
        
        // Find and delete the admin
        $admin = Admin::find($id);
        
        if (!$admin) {
            return redirect()->back()->with('error', 'Admin account not found.');
        }
        
        // Delete the account
        $admin->delete();
        
        // Invalidate the session instead of using Auth::logout()
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'Your admin account has been successfully deleted.');
    }
}