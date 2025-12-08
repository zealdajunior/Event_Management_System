<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EventRequestController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Password Reset Routes
Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->name('dashboard');

    // Profile route
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // User Dashboard Routes
    Route::middleware('role:user')->group(function () {
        Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/event-requests/create', [EventRequestController::class, 'create'])->name('event-requests.create');
        Route::post('/event-requests', [EventRequestController::class, 'store'])->name('event-requests.store');
        Route::get('/event-requests', [EventRequestController::class, 'index'])->name('event-requests.index');
    });

    // Admin Dashboard Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('events', \App\Http\Controllers\EventController::class);
        Route::resource('venues', \App\Http\Controllers\VenueController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('tickets', \App\Http\Controllers\TicketController::class);
        Route::resource('bookings', \App\Http\Controllers\BookingController::class);
        Route::resource('payments', \App\Http\Controllers\PaymentController::class);
        Route::resource('event-requests', \App\Http\Controllers\EventRequestController::class);
    });
