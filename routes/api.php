<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Android\AuthController;
use App\Http\Controllers\Android\UserController;
use App\Http\Controllers\Android\UserDetailsController;

// Authentication
Route::post('/login', [AuthController::class, 'login']);

// User verification status
Route::get('/check_verification_status', [UserController::class, 'checkVerificationStatus']);

// Fetch user details
Route::get('/user_details', [UserDetailsController::class, 'fetchUserDetails']);