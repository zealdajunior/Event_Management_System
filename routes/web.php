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
use App\Http\Controllers\WaitlistController;
use App\Http\Controllers\CalendarController;

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
    
    // Super admins and regular admins go to admin dashboard
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    // Regular users go to user dashboard
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
    Route::middleware(['role:user|admin', \App\Http\Middleware\CheckOnboarding::class])->group(function () {
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
        
        // User waitlist routes
        Route::get('/waitlist', [\App\Http\Controllers\WaitlistController::class, 'index'])->name('waitlist.index');
        Route::post('/events/{event}/waitlist/join', [\App\Http\Controllers\WaitlistController::class, 'join'])->name('waitlist.join');
        Route::delete('/events/{event}/waitlist/leave', [\App\Http\Controllers\WaitlistController::class, 'leave'])->name('waitlist.leave');
        Route::get('/events/{event}/waitlist/status', [\App\Http\Controllers\WaitlistController::class, 'status'])->name('waitlist.status');
        Route::get('/waitlist/{waitlist}/accept', [\App\Http\Controllers\WaitlistController::class, 'accept'])->name('waitlist.accept');
        Route::post('/waitlist/{waitlist}/decline', [\App\Http\Controllers\WaitlistController::class, 'decline'])->name('waitlist.decline');
        
        // User payment routes
        Route::get('/payments/create/{booking}', [PaymentController::class, 'createForBooking'])->name('payments.create.for.booking');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        // User favorite routes
        Route::post('/favorites/{event}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        // User feedback routes
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
        Route::get('/events/{event}/feedback', [FeedbackController::class, 'getEventFeedback'])->name('events.feedback');
        // User review routes
        Route::get('/events/{event}/reviews', [\App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/events/{event}/reviews/create', [\App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/events/{event}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviews/{review}/edit', [\App\Http\Controllers\ReviewController::class, 'edit'])->name('reviews.edit');
        Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/events/{event}/rating-summary', [\App\Http\Controllers\ReviewController::class, 'ratingSummary'])->name('reviews.rating-summary');
        // Ticket download routes
        Route::get('/bookings/{booking}/ticket', [TicketDownloadController::class, 'show'])->name('bookings.ticket');
        Route::get('/bookings/{booking}/ticket/download', [TicketDownloadController::class, 'download'])->name('bookings.ticket.download');
        Route::post('/bookings/{booking}/ticket/email', [TicketDownloadController::class, 'email'])->name('bookings.ticket.email');
        
        // Calendar and Map routes
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
        Route::get('/calendar/stats', [CalendarController::class, 'stats'])->name('calendar.stats');
        Route::get('/calendar/events-for-date', [CalendarController::class, 'eventsForDate'])->name('calendar.events-for-date');
        Route::get('/calendar/map', [CalendarController::class, 'mapView'])->name('calendar.map');
        Route::get('/calendar/map-markers', [CalendarController::class, 'mapMarkers'])->name('calendar.map-markers');
        Route::get('/calendar/events-nearby', [CalendarController::class, 'eventsNearby'])->name('calendar.events-nearby');
        Route::get('/calendar/search', [CalendarController::class, 'search'])->name('calendar.search');
        Route::get('/calendar/export', [CalendarController::class, 'export'])->name('calendar.export');
    });

    // Admin Dashboard Routes
    Route::middleware(['role:admin'])->group(function () {
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
        
        // Admin waitlist routes
        Route::get('/admin/events/{event}/waitlist', [\App\Http\Controllers\WaitlistController::class, 'adminIndex'])->name('admin.waitlist.index');
        Route::post('/admin/events/{event}/waitlist/promote', [\App\Http\Controllers\WaitlistController::class, 'promote'])->name('admin.waitlist.promote');
        Route::get('/admin/events/{event}/waitlist/statistics', [\App\Http\Controllers\WaitlistController::class, 'statistics'])->name('admin.waitlist.statistics');
        
        // Admin bulk email route
        Route::post('/admin/send-bulk-email', [AdminDashboardController::class, 'sendBulkEmail'])->name('admin.send-bulk-email');
        // Admin export routes
        Route::get('/admin/export/revenue', [AdminDashboardController::class, 'exportRevenue'])->name('admin.export.revenue');
        Route::get('/admin/export/bookings', [AdminDashboardController::class, 'exportBookings'])->name('admin.export.bookings');
        Route::get('/admin/export/users', [AdminDashboardController::class, 'exportUsers'])->name('admin.export.users');
        Route::get('/admin/export/events', [AdminDashboardController::class, 'exportEvents'])->name('admin.export.events');
        Route::get('/attendance/statistics/{event}', [AttendanceController::class, 'statistics'])->name('attendance.statistics');
        // Admin feedback routes
        Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        
        // Notification Manager route
        Route::get('/admin/notifications', \App\Livewire\Admin\NotificationManager::class)->name('admin.notifications');
        
        // Super Admin Management Routes
        Route::get('/admin/management', [\App\Http\Controllers\AdminManagementController::class, 'index'])->name('admin.management.index');
        Route::post('/admin/users/{user}/promote', [\App\Http\Controllers\AdminManagementController::class, 'promoteToAdmin'])->name('admin.users.promote');
        Route::post('/admin/users/{user}/demote', [\App\Http\Controllers\AdminManagementController::class, 'demoteToUser'])->name('admin.users.demote');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminManagementController::class, 'deleteUser'])->name('admin.users.delete');
        Route::post('/admin/admins/create', [\App\Http\Controllers\AdminManagementController::class, 'createAdmin'])->name('admin.admins.create');
        Route::post('/admin/users/{user}/toggle-super', [\App\Http\Controllers\AdminManagementController::class, 'toggleSuperAdmin'])->name('admin.users.toggle-super');
        Route::post('/feedback/{id}/approve', [FeedbackController::class, 'approve'])->name('feedback.approve');
        Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');
    });

    // Local-only helper to ensure a default admin user exists (safe in local environment only)
    if (app()->environment('local')) {
        Route::get('/_dev/ensure-admin', function () {
            // Check if this will be the first admin
            $existingAdmins = \App\Models\User::where('role', 'admin')->count();
            $isFirstAdmin = $existingAdmins === 0;
            
            $admin = \App\Models\User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'password' => bcrypt('admin123'),
                    'role' => 'admin',
                    'is_super_admin' => $isFirstAdmin, // First admin is super admin
                    'email_verified_at' => now(),
                ]
            );
            
            // If this is the only admin and not super admin yet, promote them
            if (!$admin->is_super_admin && \App\Models\User::where('role', 'admin')->count() === 1) {
                $admin->update(['is_super_admin' => true]);
            }

            return response()->json([
                'status' => 'ok', 
                'email' => $admin->email,
                'is_super_admin' => $admin->is_super_admin,
                'message' => $admin->is_super_admin ? 'First admin created as Super Admin' : 'Admin created'
            ]);
        })->name('dev.ensure-admin');

        // Check all admins in the system
        Route::get('/_dev/check-admins', function () {
            return view('check-admins');
        })->name('dev.check-admins');

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
            
            // Check if this will be the first admin
            $existingAdmins = \App\Models\User::where('role', 'admin')->where('id', '!=', $user->id)->count();
            $isFirstAdmin = $existingAdmins === 0;
            
            $user->role = 'admin';
            $user->is_super_admin = $isFirstAdmin; // First admin is super admin
            $user->save();
            
            return response()->json([
                'status' => 'success',
                'message' => $isFirstAdmin ? 'You are now a Super Admin!' : 'You are now an admin!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_super_admin' => $user->is_super_admin,
                ]
            ]);
        })->name('dev.make-admin');
    }
