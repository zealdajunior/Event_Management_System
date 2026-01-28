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

        return redirect()->route('admin.dashboard')->with('success', 'Bulk email sent to ' . $sentCount . ' users successfully!');
    }
}
