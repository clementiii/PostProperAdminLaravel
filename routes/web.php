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
        Route::get('/users/verify/{id}', [UserController::class, 'verifyUser'])->name('users.verify');
        Route::post('/users/verify/{id}/approve', [UserController::class, 'approveUser'])->name('users.approve');
        Route::post('/users/verify/{id}/reject', [UserController::class, 'rejectUser'])->name('users.reject');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    });

    Route::get('/documents', [DocumentRequestController::class, 'index'])->name('documents.index');
    Route::get('/document-requests/{id}', [DocumentRequestController::class, 'show'])->name('document-requests.show');
    Route::put('/document-requests/{id}', [DocumentRequestController::class, 'update'])->name('document-requests.update');
    Route::post('/documents/updatePickupStatus', [DocumentRequestController::class, 'updatePickupStatus'])->name('documents.updatePickupStatus');

    Route::get('/documents/{id}', [DocumentRequestController::class, 'show'])->name('documents.show');

    // Temporary placeholders for all pages
    //Route::get('/documents', function () {
    //    return "Document Requests Page (Coming Soon)";
    //})->name('documents.index');

  

    Route::get('/desk-support', function () {
        return "Desk Support Page (Coming Soon)";
    })->name('desk_support.index');

    Route::get('/profile', function () {
        return "Profile Page (Coming Soon)";
    })->name('profile');

    // Add the incident reports route here
    Route::get('/incident-reports', [IncidentReportController::class, 'index'])
        ->name('incident.reports');
});

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/fetch-data', [DashboardController::class, 'fetchData'])->name('dashboard.fetch');
});

Route::get('/document-request/{id}', [DashboardController::class, 'show']);

// Admin Profile Routes
Route::middleware(['auth'])->group(function () {
    // View profile
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    
    // Update profile
    Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});
