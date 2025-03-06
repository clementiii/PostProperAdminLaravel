<?php
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminStaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnnouncementController;

use App\Http\Controllers\ProfileController;
// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

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

// Protected routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/admin-staff', [AdminStaffController::class, 'index'])->name('admin.staff');
    });
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.view');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    });

    // Temporary placeholders for all pages
    Route::get('/documents', function () {
        return "Document Requests Page (Coming Soon)";
    })->name('documents.index');

    Route::get('/reports', function () {
        return "Reports Page (Coming Soon)";
    })->name('reports.index');

    Route::get('/desk-support', function () {
        return "Desk Support Page (Coming Soon)";
    })->name('desk_support.index');

    Route::get('/profile', function () {
        return "Profile Page (Coming Soon)";
    })->name('profile');
});

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/fetch-data', [DashboardController::class, 'fetchData'])->name('dashboard.fetch');
});

Route::get('/document-request/{id}', [DashboardController::class, 'show']);
