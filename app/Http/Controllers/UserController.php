<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAccount;

class UserController extends Controller
{
    public function index()
    {
        // Set inactive threshold
        $inactiveThreshold = now()->subDays(30);

        // Fetch users
        $users = UserAccount::select('id', 'firstName', 'lastName', 'adrHouseNo', 'adrZone', 'adrStreet', 'status', 'last_active')->get();

        // Count statistics
        $registeredResidentsCount = $users->count();
        $activeUsersCount = $users->where('last_active', '>=', $inactiveThreshold)->count();
        $inactiveUsersCount = $registeredResidentsCount - $activeUsersCount;

        return view('users.index', compact('users', 'registeredResidentsCount', 'activeUsersCount', 'inactiveUsersCount'));
    }
}
