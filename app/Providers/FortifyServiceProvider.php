<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Fortify\Fortify;

Fortify::authenticateUsing(function (Request $request) {
    $admin = User::where('username', $request->username)->first();

    if ($admin && Hash::check($request->password, $admin->password)) {
        return $admin;
    }

    return null;
});
