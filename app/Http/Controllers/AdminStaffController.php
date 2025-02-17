<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin; // Use Admin model to fetch from admin_accounts

class AdminStaffController extends Controller
{
    public function index()
    {
        $adminStaff = Admin::all(); // Fetch all admin staff from admin_accounts
        return view('admin_staff', compact('adminStaff'));
    }
}
