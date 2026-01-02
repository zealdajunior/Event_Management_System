<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Favorite;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Dashboard stats - simplified to avoid potential issues
        $upcomingEventsCount = Event::where('date', '>=', now())->count();
        $totalAttendees = Booking::count();
        $totalRevenue = Payment::sum('amount') ?? 0;
        $notificationsCount = 0; // Placeholder

        // Get search and filter parameters
        $search = request('search', '');
        $categoryFilter = request('category', '');
        $typeFilter = request('type', '');

        // Build query for available events with filters
        $availableEventsQuery = Event::where('status', 'active')
            ->with('venue', 'user');

        if ($search) {
            $availableEventsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%')
                      ->orWhereHas('venue', function($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
            });
        }

        if ($categoryFilter) {
            $availableEventsQuery->where('category', $categoryFilter);
        }

        if ($typeFilter === 'free') {
            $availableEventsQuery->where(function($query) {
                $query->where('price', 0)->orWhereNull('price');
            });
        } elseif ($typeFilter === 'paid') {
            $availableEventsQuery->where('price', '>', 0);
        }

        $availableEvents = $availableEventsQuery->get();

        // Get all categories for filter dropdown
        $allCategories = Event::where('status', 'active')
            ->whereNotNull('category')
            ->pluck('category')
            ->unique()
            ->sort()
            ->values();

        // Featured events (not affected by search filters)
        $featuredEvents = Event::where('status', 'active')
            ->where('is_featured', true)
            ->take(6)
            ->get();

        // User's bookings and tickets
        $myBookings = Booking::where('user_id', $user->id)->get();
        $myTickets = Ticket::where('user_id', $user->id)->get();

        // User's favorite events
        $myFavorites = Favorite::where('user_id', $user->id)->with('event')->get()->pluck('event');

        return view('user-dashboard', [
            'upcomingEventsCount' => $upcomingEventsCount,
            'totalAttendees' => $totalAttendees,
            'totalRevenue' => $totalRevenue,
            'notificationsCount' => $notificationsCount,
            'availableEvents' => $availableEvents,
            'allCategories' => $allCategories,
            'featuredEvents' => $featuredEvents,
            'myBookings' => $myBookings,
            'myTickets' => $myTickets,
            'myFavorites' => $myFavorites,
            'currentSearch' => $search,
            'currentCategory' => $categoryFilter,
            'currentType' => $typeFilter,
        ]);
    }
}
