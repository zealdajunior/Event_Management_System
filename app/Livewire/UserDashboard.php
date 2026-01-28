<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Payment;
use Livewire\Component;

class UserDashboard extends Component
{
    public $search = '';
    public $categoryFilter = '';
    public $typeFilter = '';

    public function render()
    {
        $user = auth()->user();

        // Dashboard stats - simplified to avoid potential issues
        $upcomingEventsCount = Event::where('date', '>=', now())->count();
        $totalAttendees = Booking::count();
        $totalRevenue = Payment::sum('amount') ?? 0;
        $notificationsCount = 0; // Placeholder

        // Build query for available events with filters
        $availableEventsQuery = Event::where('status', 'active')
            ->with('venue', 'user');

        if ($this->search) {
            $availableEventsQuery->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%')
                      ->orWhereHas('venue', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            });
        }

        if ($this->categoryFilter) {
            $availableEventsQuery->where('category', $this->categoryFilter);
        }

        if ($this->typeFilter === 'free') {
            $availableEventsQuery->where(function($query) {
                $query->where('price', 0)->orWhereNull('price');
            });
        } elseif ($this->typeFilter === 'paid') {
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

        // User's bookings, tickets, and payments
        $myBookings = Booking::where('user_id', $user->id)->with('event')->get();
        $myTickets = Ticket::where('user_id', $user->id)->with('event')->get();
        $myPayments = Payment::where('user_id', $user->id)->with('booking.event')->get();

        return view('livewire.user-dashboard', [
            'upcomingEventsCount' => $upcomingEventsCount,
            'totalAttendees' => $totalAttendees,
            'totalRevenue' => $totalRevenue,
            'notificationsCount' => $notificationsCount,
            'availableEvents' => $availableEvents,
            'allCategories' => $allCategories,
            'featuredEvents' => $featuredEvents,
            'myBookings' => $myBookings,
            'myTickets' => $myTickets,
            'myPayments' => $myPayments,
        ]);
    }
}
