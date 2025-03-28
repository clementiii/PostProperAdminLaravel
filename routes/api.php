<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Android\AuthController;
use App\Http\Controllers\Android\UserController;
use App\Http\Controllers\Android\UserDetailsController;
use App\Http\Controllers\Android\UserProfileUpdateController;
use App\Http\Controllers\Android\AndroidRegistrationController;


// Authentication
Route::post('/login', [AuthController::class, 'login']);

// User verification status
Route::get('/check_verification_status', [UserController::class, 'checkVerificationStatus']);

// Fetch user details
Route::get('/user/{id}', [UserDetailsController::class, 'getUserDetails']);

Route::post('/user/activity', [UserDetailsController::class, 'updateUserActivity']);

Route::post('/user_update_profile', [UserProfileUpdateController::class, 'updateProfile']);

Route::post('/android/register', [AndroidRegistrationController::class, 'register']);