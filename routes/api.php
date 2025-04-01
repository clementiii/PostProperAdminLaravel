<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Android Login
Route::post('android/login', function() {
    // Capture the Laravel request and convert to POST vars for legacy compatibility
    request()->merge($_POST = request()->all());
    require app_path('API/Android_login.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// Verification Status Check (GET)
Route::get('android/check-verification', function() {
    $_GET = request()->query();
    require app_path('API/check_verification_status.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

// User Details Fetch (GET)
Route::get('android/fetch-user-details', function() {
    $_GET = request()->query();
    require app_path('API/fetch_user_details.php');
    return response('', 200, ['Content-Type' => 'application/json']);
});

//Android Register
Route::post('android/register-user', function() {
    $_FILES = [
        'valid_id' => request()->file('valid_id'),
        'valid_id_back' => request()->file('valid_id_back')
    ];
    
    $_POST = request()->except(['valid_id', 'valid_id_back']);
    
    require app_path('API/register_user.php');
    return response('', 200, ['Content-Type' => 'application/json']);
})->middleware('api');