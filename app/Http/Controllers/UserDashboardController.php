<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user has created any events (for conditional analytics display)
        $userCreatedEvents = Event::where('user_id', $user->id)->with('bookings', 'category')->get();
        $hasCreatedEvents = $userCreatedEvents->count() > 0;
        
        // Event Creator Analytics (only if user has created events)
        $creatorAnalytics = [];
        if ($hasCreatedEvents) {
            $creatorAnalytics = [
                'total_events_created' => $userCreatedEvents->count(),
                'active_events' => $userCreatedEvents->where('status', 'active')->count(),
                'total_registrations' => $userCreatedEvents->sum(function($event) {
                    return $event->bookings ? $event->bookings->count() : 0;
                }),
                'ticket_sales_simulation' => $userCreatedEvents->sum(function($event) {
                    return $event->bookings ? $event->bookings->count() * ($event->price ?? 0) : 0;
                }),
                'upcoming_events' => $userCreatedEvents->filter(function($event) {
                    return $event->date && $event->date >= now();
                })->count(),
                'past_events' => $userCreatedEvents->filter(function($event) {
                    return $event->date && $event->date < now();
                })->count(),
            ];

            // Monthly event creation data for creators
            $monthlyCreatedEvents = [];
            $monthlyRegistrations = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $monthKey = $month->format('M Y');
                
                $eventsCreated = Event::where('user_id', $user->id)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                
                $registrationsCount = Event::where('user_id', $user->id)
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->withCount('bookings')
                    ->get()
                    ->sum('bookings_count');
                
                $monthlyCreatedEvents[] = ['month' => $monthKey, 'events' => $eventsCreated];
                $monthlyRegistrations[] = ['month' => $monthKey, 'registrations' => $registrationsCount];
            }
            
            $creatorAnalytics['monthly_created_events'] = $monthlyCreatedEvents;
            $creatorAnalytics['monthly_registrations'] = $monthlyRegistrations;
        }

        // Enhanced Dashboard Stats with better analytics
        $upcomingEventsCount = Event::where('date', '>=', now())->count();
        $totalAttendees = Booking::count();
        $totalRevenue = Payment::sum('amount') ?? 0;
        $notificationsCount = 0; // Placeholder for future notification system

        // User-specific analytics
        $userBookings = Booking::where('user_id', $user->id)->with('event', 'payment')->get();
        $userSpending = $userBookings->sum(function($booking) {
            return $booking->payment ? $booking->payment->amount : 0;
        });
        $userEventsAttended = $userBookings->filter(function($booking) {
            return $booking->event && $booking->event->date && $booking->event->date < now();
        })->count();
        $userUpcomingEvents = $userBookings->filter(function($booking) {
            return $booking->event && $booking->event->date && $booking->event->date >= now();
        })->count();

        // Monthly event data for charts (last 6 months)
        $monthlyData = [];
        $monthlyBookings = [];
        $monthlySpending = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('M Y');
            
            $eventsCount = Event::whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->count();
            
            $userBookingsCount = Booking::where('user_id', $user->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $userMonthSpending = Booking::where('user_id', $user->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->with('payment')
                ->get()
                ->sum(function($booking) {
                    return $booking->payment ? $booking->payment->amount : 0;
                });
            
            $monthlyData[] = ['month' => $monthKey, 'events' => $eventsCount];
            $monthlyBookings[] = ['month' => $monthKey, 'bookings' => $userBookingsCount];
            $monthlySpending[] = ['month' => $monthKey, 'spending' => $userMonthSpending];
        }

        // Category preferences analysis
        $categoryStats = $userBookings->groupBy(function($booking) {
            return $booking->event->category->name ?? 'Uncategorized';
        })->map(function($bookings, $category) {
            return [
                'category' => $category,
                'count' => $bookings->count(),
                'spending' => $bookings->sum(function($booking) {
                    return $booking->payment ? $booking->payment->amount : 0;
                })
            ];
        })->values();

        // Event type preferences
        $freeEventsBooked = $userBookings->filter(function($booking) {
            return $booking->event && ($booking->event->price ?? 0) == 0;
        })->count();
        
        $paidEventsBooked = $userBookings->filter(function($booking) {
            return $booking->event && ($booking->event->price ?? 0) > 0;
        })->count();

        // Get search and filter parameters
        $search = request('search', '');
        $categoryFilter = request('category', '');
        $typeFilter = request('type', '');
        $dateFrom = request('date_from');
        $dateTo = request('date_to');
        $priceMin = request('price_min');
        $priceMax = request('price_max');
        $location = request('location', '');

        // Build query for available events with filters
        $availableEventsQuery = Event::where('status', 'active')
            ->with('venue', 'user', 'category');

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
            $availableEventsQuery->where('category_id', $categoryFilter);
        }

        if ($typeFilter === 'free') {
            $availableEventsQuery->where(function($query) {
                $query->where('price', 0)->orWhereNull('price');
            });
        } elseif ($typeFilter === 'paid') {
            $availableEventsQuery->where('price', '>', 0);
        }

        // Date range filter
        if ($dateFrom) {
            $availableEventsQuery->whereDate('date', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $availableEventsQuery->whereDate('date', '<=', $dateTo);
        }

        // Price range filter
        if ($priceMin !== null && $priceMin !== '') {
            $availableEventsQuery->where('price', '>=', $priceMin);
        }
        
        if ($priceMax !== null && $priceMax !== '') {
            $availableEventsQuery->where('price', '<=', $priceMax);
        }

        // Location filter
        if ($location) {
            $availableEventsQuery->where(function($query) use ($location) {
                $query->where('location', 'like', '%' . $location . '%')
                      ->orWhereHas('venue', function($q) use ($location) {
                          $q->where('name', 'like', '%' . $location . '%')
                            ->orWhere('address', 'like', '%' . $location . '%')
                            ->orWhere('city', 'like', '%' . $location . '%');
                      });
            });
        }

        $availableEvents = $availableEventsQuery->get();

        // Get all categories for filter dropdown
        $allCategories = \App\Models\Category::active()->ordered()->get();

        // Featured events (not affected by search filters)
        $featuredEvents = Event::where('status', 'active')
            ->where('is_featured', true)
            ->with('venue', 'category')
            ->take(6)
            ->get();

        // User's bookings and tickets
        $myBookings = Booking::where('user_id', $user->id)
            ->with(['event.category', 'ticket'])
            ->orderBy('created_at', 'desc')
            ->get();
        $myTickets = $myBookings; // Bookings contain the ticket info

        // User's favorite events
        $myFavorites = Favorite::where('user_id', $user->id)->with('event.category')->get()->pluck('event');

        // Personalized recommendations based on user interests
        $recommendedEvents = collect();
        if ($user && isset($user->interests) && is_array($user->interests) && !empty($user->interests)) {
            $recommendedEvents = Event::where('status', 'active')
                ->where('date', '>=', now())
                ->where(function($query) use ($user) {
                    foreach ($user->interests as $interest) {
                        $query->orWhere('category', 'like', '%' . $interest . '%')
                              ->orWhere('name', 'like', '%' . $interest . '%')
                              ->orWhere('description', 'like', '%' . $interest . '%');
                    }
                })
                ->with('venue', 'category')
                ->take(3)
                ->get();
        }

        // Trending events (most bookings)
        $trendingEvents = Event::where('status', 'active')
            ->where('date', '>=', now())
            ->withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->take(3)
            ->get();

        // Fun facts and stats for user
        $userStats = [
            'events_attended' => $myBookings->count(),
            'favorites_count' => $myFavorites->count(),
            'member_since' => $user->created_at ? $user->created_at->diffForHumans() : 'Recently',
            'upcoming_bookings' => $myBookings->filter(function($booking) {
                return $booking->event && $booking->event->date >= now();
            })->count(),
        ];

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
            'recommendedEvents' => $recommendedEvents,
            'trendingEvents' => $trendingEvents,
            'userStats' => $userStats,
            // Enhanced analytics data
            'userSpending' => $userSpending,
            'userEventsAttended' => $userEventsAttended,
            'userUpcomingEvents' => $userUpcomingEvents,
            'monthlyData' => $monthlyData,
            'monthlyBookings' => $monthlyBookings,
            'monthlySpending' => $monthlySpending,
            'categoryStats' => $categoryStats,
            'freeEventsBooked' => $freeEventsBooked,
            'paidEventsBooked' => $paidEventsBooked,
            // Conditional creator analytics
            'hasCreatedEvents' => $hasCreatedEvents,
            'creatorAnalytics' => $creatorAnalytics,
            'userCreatedEvents' => $userCreatedEvents,
        ]);
    }
}
