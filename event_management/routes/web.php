<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EventRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    $upcomingEvents = \App\Models\Event::where('date', '>=', now())->orderBy('date')->take(6)->get();
    return view('welcome', compact('upcomingEvents'));
})->name('home');

// Password Reset Routes
Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('verify-code', [PasswordResetController::class, 'showCodeForm'])->name('password.code.form');
Route::post('verify-code', [PasswordResetController::class, 'verifyCode'])->name('password.code.verify');
Route::get('reset-password', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::middleware('auth')->get('/dashboard', function () {
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
        // User booking routes
        Route::get('/bookings/create/{event}', [BookingController::class, 'createForEvent'])->name('bookings.create.for.event');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        // User payment routes
        Route::get('/payments/create/{booking}', [PaymentController::class, 'createForBooking'])->name('payments.create.for.booking');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        // User favorite routes
        Route::post('/favorites/{event}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
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
        Route::get('/admin/event-requests', [EventRequestController::class, 'adminIndex'])->name('admin.event_requests.index');
        Route::post('/admin/event-requests/{id}/approve', [EventRequestController::class, 'approve'])->name('admin.event_requests.approve');
        Route::post('/admin/event-requests/{id}/reject', [EventRequestController::class, 'reject'])->name('admin.event_requests.reject');
    });
