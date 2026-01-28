<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventRequest;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BulkEmailNotification;
use App\Services\AuditLogger;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalEvents = Event::count();
        $totalUsers = User::count();
        $pendingRequests = EventRequest::where('status', 'pending')->count();
        $totalBookings = Booking::count();
        $recentEvents = Event::latest()->take(5)->get();
        // Only show recent bookings (last 10) with proper error handling
        $recentBookings = Booking::with(['event', 'user', 'ticket'])
            ->latest()
            ->take(10)
            ->get();
        
        // Event Requests data - only show pending requests
        $eventRequests = EventRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->take(6)
            ->get();
        
        // User statistics and recent users
        $recentUsers = User::latest()->take(10)->get();
        $usersByRole = User::select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->pluck('count', 'role');
        
        // Analytics data
        $totalRevenue = Payment::sum('amount') ?? 0;
        $upcomingEvents = Event::where('date', '>=', now())->count();
        $pastEvents = Event::where('date', '<', now())->count();
        
        // Booking stats - simplified since bookings table may not have status column
        $confirmedBookings = $totalBookings; // Assume all are confirmed for now
        $pendingBookings = 0;
        $cancelledBookings = 0;
        
        // Request statistics
        $approvedRequests = EventRequest::where('status', 'approved')->count();
        $rejectedRequests = EventRequest::where('status', 'rejected')->count();
        
        // Monthly bookings trend (last 6 months)
        $monthlyBookings = Booking::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('count(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Top events by bookings
        $topEvents = Event::withCount('bookings')
            ->having('bookings_count', '>', 0)
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        return view('admin-dashboard', [
            'totalEvents' => $totalEvents,
            'totalUsers' => $totalUsers,
            'pendingRequests' => $pendingRequests,
            'totalBookings' => $totalBookings,
            'recentEvents' => $recentEvents,
            'eventRequests' => $eventRequests,
            'recentBookings' => $recentBookings,
            'recentUsers' => $recentUsers,
            'usersByRole' => $usersByRole,
            'totalRevenue' => $totalRevenue,
            'upcomingEvents' => $upcomingEvents,
            'pastEvents' => $pastEvents,
            'confirmedBookings' => $confirmedBookings,
            'pendingBookings' => $pendingBookings,
            'cancelledBookings' => $cancelledBookings,
            'approvedRequests' => $approvedRequests,
            'rejectedRequests' => $rejectedRequests,
            'monthlyBookings' => $monthlyBookings,
            'topEvents' => $topEvents,
        ]);
    }

    /**
     * Send bulk email to users
     */
    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:all,recent_bookings,upcoming_events',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $users = collect();
        
        switch ($request->recipient_type) {
            case 'all':
                $users = User::where('role', 'user')->get();
                break;
            case 'recent_bookings':
                $userIds = Booking::where('created_at', '>=', now()->subDays(30))
                    ->pluck('user_id')->unique();
                $users = User::whereIn('id', $userIds)->get();
                break;
            case 'upcoming_events':
                $userIds = Booking::whereHas('event', function($query) {
                    $query->where('date', '>', now());
                })->pluck('user_id')->unique();
                $users = User::whereIn('id', $userIds)->get();
                break;
        }

        $sentCount = 0;
        foreach ($users as $user) {
            try {
                Mail::raw($request->message, function ($message) use ($user, $request) {
                    $message->to($user->email)->subject($request->subject);
                });
                $sentCount++;
            } catch (\Exception $e) {
                \Log::error('Bulk email failed: ' . $e->getMessage());
            }
        }

        // Log audit action
        AuditLogger::log('sent', 'BulkEmail', 'N/A', [
            'recipient_type' => $request->recipient_type,
            'subject' => $request->subject,
            'recipients_count' => $sentCount
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Bulk email sent to ' . $sentCount . ' users successfully!');
    }

    /**
     * Export revenue data as CSV
     */
    public function exportRevenue()
    {
        $payments = Payment::with(['booking.user', 'booking.event'])
            ->where('status', 'completed')
            ->orderBy('payment_date', 'desc')
            ->get();

        $filename = 'revenue-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Payment ID', 'Booking ID', 'User Name', 'User Email', 'Event Title', 'Amount', 'Payment Method', 'Transaction ID', 'Payment Date', 'Status']);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->booking_id,
                    $payment->booking->user->name ?? 'N/A',
                    $payment->booking->user->email ?? 'N/A',
                    $payment->booking->event->title ?? 'N/A',
                    $payment->amount,
                    $payment->payment_method,
                    $payment->transaction_id ?? 'N/A',
                    $payment->payment_date,
                    $payment->status,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export bookings data as CSV
     */
    public function exportBookings()
    {
        $bookings = Booking::with(['user', 'event', 'ticket', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->get();

        $filename = 'bookings-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Booking ID', 'Ticket ID', 'User Name', 'User Email', 'Event Title', 'Event Date', 'Quantity', 'Booking Date', 'Status', 'Payment Amount', 'Payment Status']);
            
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->ticket_id ?? 'N/A',
                    $booking->user->name ?? 'N/A',
                    $booking->user->email ?? 'N/A',
                    $booking->event->title ?? 'N/A',
                    $booking->event->date ?? 'N/A',
                    $booking->quantity ?? 1,
                    $booking->booking_date,
                    $booking->status ?? 'confirmed',
                    $booking->payment->amount ?? '0',
                    $booking->payment->status ?? 'N/A',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export users data as CSV
     */
    public function exportUsers()
    {
        $users = User::withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'users-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['User ID', 'Name', 'Email', 'Role', 'Total Bookings', 'Email Verified', 'Created At', 'Last Login']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'user',
                    $user->bookings_count ?? 0,
                    $user->email_verified_at ? 'Yes' : 'No',
                    $user->created_at,
                    $user->last_login_at ?? 'Never',
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export events data as CSV
     */
    public function exportEvents()
    {
        $events = Event::withCount(['bookings', 'feedback'])
            ->with('venue')
            ->orderBy('date', 'desc')
            ->get();

        $filename = 'events-export-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($events) {
            $file = fopen('php://output', 'w');
            
            // CSV Headers
            fputcsv($file, ['Event ID', 'Title', 'Date', 'Time', 'Venue', 'Capacity', 'Price', 'Total Bookings', 'Total Feedback', 'Status', 'Created At']);
            
            foreach ($events as $event) {
                fputcsv($file, [
                    $event->id,
                    $event->title,
                    $event->date,
                    $event->time ?? 'N/A',
                    $event->venue->name ?? 'N/A',
                    $event->capacity ?? 'Unlimited',
                    $event->price ?? '0',
                    $event->bookings_count ?? 0,
                    $event->feedback_count ?? 0,
                    $event->date >= now() ? 'Upcoming' : 'Past',
                    $event->created_at,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
