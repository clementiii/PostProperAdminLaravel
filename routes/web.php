<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DocumentRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\IncidentReportController;

// ===================================
// PUBLIC ROUTES
// ===================================

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// ===================================
// AUTHENTICATION ROUTES
// ===================================

// Login routes (for unauthenticated users)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(['throttle:login']);
});

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// ===================================
// AUTHENTICATED ROUTES
// ===================================

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/fetch-data', [DashboardController::class, 'fetchData'])->name('dashboard.fetch');
    
    // Admin Staff Management
    Route::get('/admin-staff', [AdminStaffController::class, 'index'])->name('admin.staff');
    
    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.view');
        Route::get('/verify/{id}', [UserController::class, 'verifyUser'])->name('users.verify');
        Route::post('/verify/{id}/approve', [UserController::class, 'approveUser'])->name('users.approve');
        Route::post('/verify/{id}/reject', [UserController::class, 'rejectUser'])->name('users.reject');
    });
    
    // Announcements
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/', [AnnouncementController::class, 'store'])->name('announcements.store');
    });
    
    // Document Requests
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentRequestController::class, 'index'])->name('documents.index');
        Route::get('/{id}', [DocumentRequestController::class, 'show'])->name('documents.show');
        Route::post('/updatePickupStatus', [DocumentRequestController::class, 'updatePickupStatus'])
            ->name('documents.updatePickupStatus');
    });
    
    Route::prefix('document-requests')->group(function () {
        Route::get('/{id}', [DocumentRequestController::class, 'show'])->name('document-requests.show');
        Route::put('/{id}', [DocumentRequestController::class, 'update'])->name('document-requests.update');
    });
    
    Route::get('/document-request/{id}', [DashboardController::class, 'show']);
    
    // Admin Profile
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
        Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/admin/profile/update-picture', [App\Http\Controllers\AdminProfileController::class, 'updateProfilePicture'])->name('admin.profile.update-picture');
    });
    
    // Incident Reports
    Route::get('/incident-reports', [IncidentReportController::class, 'index'])->name('incident.reports');
    
    // Profile Page (Coming Soon)
    Route::get('/profile', function () {
        return "Profile Page (Coming Soon)";
    })->name('profile');
    
    // Desk Support (Coming Soon)
    Route::get('/desk-support', function () {
        return "Desk Support Page (Coming Soon)";
    })->name('desk_support.index');
});