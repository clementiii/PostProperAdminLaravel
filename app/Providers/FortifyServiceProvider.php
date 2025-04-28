<?php
namespace App\Providers;

use App\Actions\Fortify\CustomAuthentication;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Define the rate limiter correctly
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->username . '|' . $request->ip());
        });

        // Ensure Fortify uses the correct login view
        Fortify::loginView(function () {
            return view('auth.login');
        });
        
        // Use custom authentication logic
        Fortify::authenticateUsing(function (Request $request) {
            $authenticator = new CustomAuthentication();
            return $authenticator->authenticate($request);
        });
    }
}
