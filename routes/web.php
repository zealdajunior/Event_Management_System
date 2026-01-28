<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EventRequestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\TicketDownloadController;

Route::get('/', function () {
    $upcomingEvents = \App\Models\Event::where('date', '>=', now())->orderBy('date')->take(6)->get();
    $pastEvents     = \App\Models\Event::past()->with('venue','bookings')->orderByDesc('date')->take(3)->get();
    return view('welcome', compact('upcomingEvents', 'pastEvents'));
})->name('home');

// Password Reset Routes - Using Livewire for modern SPA-like experience
Route::view('forgot-password', 'auth.forgot-password')->name('password.request');
Route::view('verify-code', 'auth.verify-code')->name('password.verify-code');

// Event creation (accessible to both users and admins) - MUST be before {event} route
Route::middleware('auth')->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
});

// Public event view (accessible to all authenticated users) - AFTER /events/create
Route::middleware('auth')->get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Onboarding Routes
Route::middleware('auth')->group(function () {
    Route::get('/onboarding/step1', [OnboardingController::class, 'step1'])->name('onboarding.step1');
    Route::post('/onboarding/step1', [OnboardingController::class, 'storeStep1'])->name('onboarding.step1.store');
    Route::get('/onboarding/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2');
    Route::post('/onboarding/step2', [OnboardingController::class, 'storeStep2'])->name('onboarding.step2.store');
    Route::get('/onboarding/step3', [OnboardingController::class, 'step3'])->name('onboarding.step3');
    Route::post('/onboarding/step3', [OnboardingController::class, 'storeStep3'])->name('onboarding.step3.store');
    Route::get('/onboarding/skip', [OnboardingController::class, 'skip'])->name('onboarding.skip');
});

use Illuminate\Support\Facades\Auth;

Route::middleware('auth')->get('/dashboard', function () {
    $user = Auth::user();
    if ($user && method_exists($user, 'isAdmin') && $user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->name('dashboard');

    // Profile route (legacy)
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Settings pages (wrappers that mount settings Livewire components)
    Route::middleware('auth')->group(function () {
        Route::get('/settings/profile', fn () => view('settings.profile'))->name('profile.edit');
        Route::get('/settings/password', fn () => view('settings.password'))->name('user-password.edit');
        // two-factor requires password confirmation
        Route::get('/settings/two-factor', fn () => view('settings.two-factor'))
            ->middleware('password.confirm')
            ->name('two-factor.show');
        Route::get('/settings/appearance', fn () => view('settings.appearance'))->name('appearance.edit');
    });

    // User Dashboard Routes
    Route::middleware(['role:user', 'verified', \App\Http\Middleware\CheckOnboarding::class])->group(function () {
        Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
        Route::get('/event-requests/create', [EventRequestController::class, 'create'])->name('event-requests.create');
        Route::post('/event-requests', [EventRequestController::class, 'store'])->name('event-requests.store');
        Route::get('/event-requests', [EventRequestController::class, 'index'])->name('event-requests.index');
        Route::get('/event-requests/{request}', [EventRequestController::class, 'show'])->middleware('auth')->name('event-requests.show');
        // User event creation routes (user-specific URL to avoid conflict with admin)
        Route::get('/my-events/create', [EventController::class, 'create'])->name('events.create.user');
        Route::post('/my-events', [EventController::class, 'store'])->name('events.store.user');
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
        // User feedback routes
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/events/{event}/feedback', [FeedbackController::class, 'getEventFeedback'])->name('events.feedback');
        // Ticket download routes
        Route::get('/bookings/{booking}/ticket', [TicketDownloadController::class, 'show'])->name('bookings.ticket');
        Route::get('/bookings/{booking}/ticket/download', [TicketDownloadController::class, 'download'])->name('bookings.ticket.download');
    });

    // Admin Dashboard Routes
    Route::middleware(['role:admin', 'verified'])->group(function () {
        Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        // Admin event management (edit, delete only - create/store moved to auth group above)
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/events', [EventController::class, 'index'])->name('events.index');
        Route::resource('venues', \App\Http\Controllers\VenueController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
        Route::resource('tickets', \App\Http\Controllers\TicketController::class);
        // Admin views for bookings and payments (index, edit, delete)
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
        Route::get('/admin/event-requests', [EventRequestController::class, 'adminIndex'])->name('admin.event_requests.index');
        Route::post('/admin/event-requests/{id}/approve', [EventRequestController::class, 'approve'])->name('admin.event_requests.approve');
        Route::post('/admin/event-requests/{id}/reject', [EventRequestController::class, 'reject'])->name('admin.event_requests.reject');
        Route::delete('/admin/event-requests/{id}', [EventRequestController::class, 'destroy'])->name('admin.event_requests.destroy');
        // Admin attendance routes
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/scanner', [AttendanceController::class, 'scanner'])->name('attendance.scanner');
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.check-in');
        Route::post('/attendance/verify', [AttendanceController::class, 'verify'])->name('attendance.verify');
        // Admin bulk email route
        Route::post('/admin/send-bulk-email', [AdminDashboardController::class, 'sendBulkEmail'])->name('admin.send-bulk-email');
        Route::get('/attendance/statistics/{event}', [AttendanceController::class, 'statistics'])->name('attendance.statistics');
        // Admin feedback routes
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback/{id}/approve', [FeedbackController::class, 'approve'])->name('feedback.approve');
        Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    });

    // Local-only helper to ensure a default admin user exists (safe in local environment only)
    if (app()->environment('local')) {
        Route::get('/_dev/ensure-admin', function () {
            $admin = \App\Models\User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'password' => bcrypt('admin123'),
                    'role' => 'admin',
                    'email_verified_at' => now(),
                ]
            );

            return response()->json(['status' => 'ok', 'email' => $admin->email]);
        })->name('dev.ensure-admin');

        // Debug route to check current user role
        Route::middleware('auth')->get('/_dev/check-role', function () {
            $user = Auth::user();
            return response()->json([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'isAdmin' => $user->isAdmin(),
                'hasAdminRole' => $user->hasRole('admin'),
            ]);
        })->name('dev.check-role');

        // Make current user an admin
        Route::middleware('auth')->get('/_dev/make-me-admin', function () {
            $user = Auth::user();
            $user->role = 'admin';
            $user->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'You are now an admin!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]);
        })->name('dev.make-admin');
    }
