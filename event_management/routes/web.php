use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EventRequestController;
<!-- 
Route::resource('events', EventController::class);
Route::resource('users', UserController::class);
Route::resource('venues', VenueController::class);
Route::resource('tickets', TicketController::class);
Route::resource('bookings', BookingController::class);
Route::resource('payments', PaymentController::class); -->

Route::get("/", function() {
    return view("welcome");
});

<!-- // Event requests
Route::get('/event-requests', [EventRequestController::class, 'index'])->name('event-requests.index');
Route::post('/event-requests', [EventRequestController::class, 'store'])->name('event-requests.store');
Route::get('/admin/event-requests', [EventRequestController::class, 'adminIndex'])->name('admin.event-requests.index');
Route::post('/admin/event-requests/{id}/approve', [EventRequestController::class, 'approve'])->name('admin.event-requests.approve');
Route::post('/admin/event-requests/{id}/reject', [EventRequestController::class, 'reject'])->name('admin.event-requests.reject'); -->