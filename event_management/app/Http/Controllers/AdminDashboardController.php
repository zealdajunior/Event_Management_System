<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\EventRequest;
use App\Models\Booking;

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
        $recentBookings = Booking::latest()->take(5)->get();
        $eventRequests = EventRequest::where('status', 'pending')->get();

        return view('admin-dashboard', [
            'totalEvents' => $totalEvents,
            'totalUsers' => $totalUsers,
            'pendingRequests' => $pendingRequests,
            'totalBookings' => $totalBookings,
            'recentEvents' => $recentEvents,
            'eventRequests' => $eventRequests,
            'recentBookings' => $recentBookings,
        ]);
    }
}