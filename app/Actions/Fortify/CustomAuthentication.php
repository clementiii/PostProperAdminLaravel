<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Fortify\Fortify;
use Illuminate\Validation\ValidationException;

class CustomAuthentication
{
    /**
     * Authenticate the user based on provided credentials.
     *
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        $user = User::where(Fortify::username(), $request->username)->first();
        
        // Check if user exists
        if (!$user) {
            throw ValidationException::withMessages([
                Fortify::username() => ['The username you entered doesn\'t match any account.'],
            ]);
        }
        
        // Check if password is correct
        if (!Hash::check($request->password, $user->password) && $request->password !== $user->password) {
            throw ValidationException::withMessages([
                'password' => ['The password you entered is incorrect. Please try again.'],
            ]);
        }
        
        return $user;
    }
}