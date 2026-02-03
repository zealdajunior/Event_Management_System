<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Category;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CalendarService
{
    /**
     * Get events formatted for FullCalendar
     */
    public function getCalendarEvents(array $filters = []): Collection
    {
        $query = Event::with(['venue', 'category', 'tickets'])
                     ->where('status', 'active')
                     ->where('date', '>=', now()->startOfMonth()->subMonth());

        // Apply filters
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['venue_id'])) {
            $query->where('venue_id', $filters['venue_id']);
        }

        if (!empty($filters['location'])) {
            $query->whereHas('venue', function($q) use ($filters) {
                $q->where('city', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('state', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('country', 'like', '%' . $filters['location'] . '%');
            });
        }

        if (!empty($filters['start_date'])) {
            $query->where('date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('date', '<=', $filters['end_date']);
        }

        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        // Location-based filtering
        if (!empty($filters['latitude']) && !empty($filters['longitude']) && !empty($filters['radius'])) {
            $query->whereHas('venue', function($q) use ($filters) {
                $q->withinDistance($filters['latitude'], $filters['longitude'], $filters['radius']);
            });
        }

        $events = $query->orderBy('date')->get();

        return $events->map(function ($event) {
            return $this->formatEventForCalendar($event);
        });
    }

    /**
     * Format single event for FullCalendar
     */
    public function formatEventForCalendar(Event $event): array
    {
        $availableTickets = $event->getAvailableTicketQuantity();
        $isSoldOut = $availableTickets === 0;
        
        // Determine event color based on status
        $color = $this->getEventColor($event, $isSoldOut);
        
        return [
            'id' => $event->id,
            'title' => $event->name,
            'start' => $event->date->toISOString(),
            'end' => $event->end_date ? $event->end_date->toISOString() : $event->date->addHours(2)->toISOString(),
            'url' => route('events.show', $event),
            'backgroundColor' => $color['background'],
            'borderColor' => $color['border'],
            'textColor' => $color['text'],
            'classNames' => [
                'event-' . $event->id,
                $isSoldOut ? 'event-sold-out' : 'event-available',
                $event->is_featured ? 'event-featured' : '',
                'event-category-' . ($event->category_id ?? 'none')
            ],
            'extendedProps' => [
                'description' => $event->description,
                'location' => $event->venue?->name ?? $event->location,
                'venue_id' => $event->venue_id,
                'category' => $event->category?->name,
                'category_id' => $event->category_id,
                'price' => $event->price,
                'formatted_price' => $event->formatted_price,
                'capacity' => $event->capacity,
                'available_tickets' => $availableTickets,
                'is_sold_out' => $isSoldOut,
                'is_featured' => $event->is_featured,
                'image' => $event->featuredImage?->file_path,
                'venue' => $event->venue ? [
                    'id' => $event->venue->id,
                    'name' => $event->venue->name,
                    'address' => $event->venue->full_address,
                    'coordinates' => $event->venue->coordinates,
                ] : null
            ]
        ];
    }

    /**
     * Get event color scheme based on status and category
     */
    private function getEventColor(Event $event, bool $isSoldOut): array
    {
        if ($isSoldOut) {
            return [
                'background' => '#ef4444',
                'border' => '#dc2626',
                'text' => '#ffffff'
            ];
        }

        if ($event->is_featured) {
            return [
                'background' => '#f59e0b',
                'border' => '#d97706',
                'text' => '#ffffff'
            ];
        }

        // Category-based colors
        $categoryColors = [
            'conference' => ['background' => '#3b82f6', 'border' => '#2563eb', 'text' => '#ffffff'],
            'workshop' => ['background' => '#10b981', 'border' => '#059669', 'text' => '#ffffff'],
            'concert' => ['background' => '#8b5cf6', 'border' => '#7c3aed', 'text' => '#ffffff'],
            'sports' => ['background' => '#f97316', 'border' => '#ea580c', 'text' => '#ffffff'],
            'exhibition' => ['background' => '#06b6d4', 'border' => '#0891b2', 'text' => '#ffffff'],
            'networking' => ['background' => '#84cc16', 'border' => '#65a30d', 'text' => '#ffffff'],
        ];

        $categorySlug = $event->category?->slug ?? 'default';
        
        return $categoryColors[$categorySlug] ?? [
            'background' => '#6b7280',
            'border' => '#4b5563',
            'text' => '#ffffff'
        ];
    }

    /**
     * Get calendar statistics for a date range
     */
    public function getCalendarStats(string $start, string $end): array
    {
        $events = Event::whereBetween('date', [$start, $end])
                      ->where('status', 'active')
                      ->with(['bookings.payment', 'category'])
                      ->get();

        $totalEvents = $events->count();
        $featuredEvents = $events->where('is_featured', true)->count();
        $freeEvents = $events->where('price', 0)->count();
        $paidEvents = $events->where('price', '>', 0)->count();

        // Revenue calculation
        $totalRevenue = $events->sum(function ($event) {
            return $event->bookings->sum(function ($booking) {
                return $booking->payment && $booking->payment->status === 'completed' 
                    ? $booking->payment->amount 
                    : 0;
            });
        });

        // Category breakdown
        $categoriesBreakdown = $events->groupBy('category.name')
                                   ->map(function ($events, $category) {
                                       return [
                                           'name' => $category ?? 'Uncategorized',
                                           'count' => $events->count(),
                                           'percentage' => 0 // Will be calculated below
                                       ];
                                   })
                                   ->values();

        // Calculate percentages
        if ($totalEvents > 0) {
            $categoriesBreakdown = $categoriesBreakdown->map(function ($category) use ($totalEvents) {
                $category['percentage'] = round(($category['count'] / $totalEvents) * 100, 1);
                return $category;
            });
        }

        return [
            'total_events' => $totalEvents,
            'featured_events' => $featuredEvents,
            'free_events' => $freeEvents,
            'paid_events' => $paidEvents,
            'total_revenue' => $totalRevenue,
            'average_price' => $paidEvents > 0 ? $events->where('price', '>', 0)->avg('price') : 0,
            'categories_breakdown' => $categoriesBreakdown,
            'date_range' => [
                'start' => $start,
                'end' => $end
            ]
        ];
    }

    /**
     * Get events for a specific date
     */
    public function getEventsForDate(string $date): Collection
    {
        $startOfDay = Carbon::parse($date)->startOfDay();
        $endOfDay = Carbon::parse($date)->endOfDay();

        return Event::with(['venue', 'category', 'tickets'])
                   ->where('status', 'active')
                   ->whereBetween('date', [$startOfDay, $endOfDay])
                   ->orderBy('date')
                   ->get();
    }

    /**
     * Get available filters for calendar
     */
    public function getFilterOptions(): array
    {
        return [
            'categories' => Category::where('is_active', true)
                                  ->orderBy('name')
                                  ->get(['id', 'name', 'slug', 'color']),
            'venues' => Venue::has('events')
                            ->orderBy('name')
                            ->get(['id', 'name', 'city', 'state']),
            'locations' => $this->getUniqueLocations(),
            'date_ranges' => [
                'this_week' => [
                    'label' => 'This Week',
                    'start' => now()->startOfWeek(),
                    'end' => now()->endOfWeek()
                ],
                'this_month' => [
                    'label' => 'This Month',
                    'start' => now()->startOfMonth(),
                    'end' => now()->endOfMonth()
                ],
                'next_month' => [
                    'label' => 'Next Month',
                    'start' => now()->addMonth()->startOfMonth(),
                    'end' => now()->addMonth()->endOfMonth()
                ],
                'next_3_months' => [
                    'label' => 'Next 3 Months',
                    'start' => now(),
                    'end' => now()->addMonths(3)
                ]
            ]
        ];
    }

    /**
     * Get unique locations from venues
     */
    private function getUniqueLocations(): Collection
    {
        $venues = Venue::has('events')
                      ->whereNotNull('city')
                      ->get(['city', 'state', 'country']);

        $locations = $venues->map(function ($venue) {
            $location = $venue->city;
            if ($venue->state) {
                $location .= ', ' . $venue->state;
            }
            return $location;
        })->unique()->sort()->values();

        return $locations;
    }

    /**
     * Search events with intelligent filtering
     */
    public function searchEvents(string $query, array $filters = []): Collection
    {
        $searchQuery = Event::with(['venue', 'category', 'tickets'])
                           ->where('status', 'active')
                           ->where(function ($q) use ($query) {
                               $q->where('name', 'like', "%{$query}%")
                                 ->orWhere('description', 'like', "%{$query}%")
                                 ->orWhereHas('venue', function ($vq) use ($query) {
                                     $vq->where('name', 'like', "%{$query}%")
                                       ->orWhere('city', 'like', "%{$query}%")
                                       ->orWhere('address', 'like', "%{$query}%");
                                 })
                                 ->orWhereHas('category', function ($cq) use ($query) {
                                     $cq->where('name', 'like', "%{$query}%");
                                 });
                           });

        // Apply additional filters
        if (!empty($filters['category_id'])) {
            $searchQuery->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['price_range'])) {
            switch ($filters['price_range']) {
                case 'free':
                    $searchQuery->where('price', 0);
                    break;
                case 'under_50':
                    $searchQuery->whereBetween('price', [0.01, 50]);
                    break;
                case 'under_100':
                    $searchQuery->whereBetween('price', [0.01, 100]);
                    break;
                case 'over_100':
                    $searchQuery->where('price', '>', 100);
                    break;
            }
        }

        return $searchQuery->orderBy('date')->get();
    }
}