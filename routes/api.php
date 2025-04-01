<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('android/login', function() {
    // Capture the Laravel request and convert to POST vars for legacy compatibility
    request()->merge($_POST = request()->all());
    
    // Include the legacy endpoint
    require app_path('API/Android_login.php');
    
    // Prevent Laravel from sending additional response
    return response('', 200, ['Content-Type' => 'application/json']);
});