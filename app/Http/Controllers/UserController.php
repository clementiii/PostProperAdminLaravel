<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function view($id)
    {
        $user = UserAccount::findOrFail($id);
        return view('users.view', compact('user'));
    }

    public function delete($id)
    {
        try {
            $user = UserAccount::findOrFail($id);
            $user->delete();
            return redirect()->route('users.view')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.view')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function destroyUser(Request $request, $id)
    {
        try {
            $user = UserAccount::findOrFail($id);
            $user->delete();
            return redirect()->route('users.view')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('users.view')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function verifyUser($id)
    {
        try {
            $user = UserAccount::findOrFail($id);
            
            // Add checks for empty strings
            $user->user_profile_picture = !empty($user->user_profile_picture) ? $user->user_profile_picture : null;
            $user->user_valid_id = !empty($user->user_valid_id) ? $user->user_valid_id : null;
            $user->user_valid_id_back = !empty($user->user_valid_id_back) ? $user->user_valid_id_back : null;
            
            return view('users.user-verify', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('users.view')
                ->with('error', 'User not found or error occurred.');
        }
    }

    public function approveUser($id)
    {
        $user = UserAccount::findOrFail($id);
        $user->update([
            'status' => 'verified',
            'verified_at' => now()
        ]);

        // Return to the verification page with a success message instead of immediately redirecting
        return back()->with('success', 'User has been verified successfully');
    }

    public function rejectUser($id)
    {
        $user = UserAccount::findOrFail($id);
        $user->update([
            'status' => 'rejected',
            'rejected_at' => now()
        ]);

        // Return to the verification page with a success message instead of immediately redirecting
        return back()->with('success', 'User has been rejected');
    }
}