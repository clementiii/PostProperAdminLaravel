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
use App\Http\Controllers\HelpDeskController;

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
    Route::delete('/admin/{id}/delete', [AdminStaffController::class, 'delete'])->name('admin.delete');
    
    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.view');
        Route::get('/verify/{id}', [UserController::class, 'verifyUser'])->name('users.verify');
        Route::post('/users/{id}/approve', 'App\Http\Controllers\UserController@approveUser')->name('users.approve');
        Route::post('/users/{id}/reject', 'App\Http\Controllers\UserController@rejectUser')->name('users.reject');
        Route::delete('/users/{id}', [UserController::class, 'destroyUser'])->name('users.delete');
    });
    
    // Announcements
    Route::prefix('announcements')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
        Route::put('/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::get('/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit'); // Fixed syntax
    });

    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [DocumentRequestController::class, 'show'])->name('show');
        Route::post('/updatePickupStatus', [DocumentRequestController::class, 'updatePickupStatus'])->name('updatePickupStatus');
        Route::put('/{id}', [DocumentRequestController::class, 'update'])->name('update');
    });

    Route::prefix('document-requests')->group(function () {
        Route::get('/{id}', [DocumentRequestController::class, 'show'])->name('document-requests.show');
        Route::put('/{id}', [DocumentRequestController::class, 'update'])->name('document-requests.update');
    });

    Route::get('/document-request/{id}', [DashboardController::class, 'show']);

    // Document Requests (Livewire)
    Route::get('/documents', function () {
        return view('documents'); // Render the Blade view that includes the Livewire component
    })->name('documents.index');

    // Admin Profile
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
        Route::post('/admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/admin/profile/update-picture', [AdminProfileController::class, 'updateProfilePicture'])->name('admin.profile.update-picture');
    });

    // Incident Reports
    Route::prefix('incident-reports')->name('incident-reports.')->group(function () {
        Route::get('/', [IncidentReportController::class, 'index'])->name('index');
        Route::get('/incident-reports', [IncidentReportController::class, 'index'])->name('incident.reports');
        Route::get('/{incidentReport}', [IncidentReportController::class, 'show'])->name('show');
    });

    // Desk Support (Coming Soon)
    Route::get('/desk-support', function () {
        return "Desk Support Page (Coming Soon)";
    })->name('desk_support.index');

    // Help Desk Routes
    Route::prefix('help-desk')->group(function () {
        Route::get('/', [HelpDeskController::class, 'index'])->name('help_desk.index');
        Route::post('/send-message', [HelpDeskController::class, 'sendMessage'])->name('help_desk.send_message');
        Route::get('/get-messages', [HelpDeskController::class, 'getMessages'])->name('help_desk.get_messages');
    });

});