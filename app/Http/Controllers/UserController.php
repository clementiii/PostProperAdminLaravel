<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;

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
        $user = UserAccount::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
