<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Support\Collection;

class MapService
{
    /**
     * Get events with location data for map display
     */
    public function getEventsWithLocation(array $filters = []): Collection
    {
        $query = Event::with(['venue', 'category', 'tickets'])
                     ->where('status', 'active')
                     ->whereHas('venue', function($q) {
                         $q->whereNotNull('latitude')
                           ->whereNotNull('longitude');
                     });

        // Apply filters
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
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

        if (!empty($filters['location'])) {
            $query->whereHas('venue', function($q) use ($filters) {
                $q->where('city', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('state', 'like', '%' . $filters['location'] . '%')
                  ->orWhere('country', 'like', '%' . $filters['location'] . '%');
            });
        }

        return $query->orderBy('date')->get();
    }

    /**
     * Get map center point based on events or default location
     */
    public function getMapCenter(Collection $events = null): array
    {
        if (!$events || $events->isEmpty()) {
            // Default to major city if no events
            return [
                'latitude' => 40.7128, // New York
                'longitude' => -74.0060,
                'zoom' => 10
            ];
        }

        $venues = $events->pluck('venue')->filter();
        
        if ($venues->isEmpty()) {
            return [
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'zoom' => 10
            ];
        }

        // Calculate center point from all venues
        $totalLat = $venues->sum('latitude');
        $totalLng = $venues->sum('longitude');
        $count = $venues->count();

        return [
            'latitude' => $totalLat / $count,
            'longitude' => $totalLng / $count,
            'zoom' => $this->calculateOptimalZoom($venues)
        ];
    }

    /**
     * Get event markers for map display
     */
    public function getEventMarkers(array $filters = []): array
    {
        $events = $this->getEventsWithLocation($filters);
        
        $markers = [];
        $venueGroups = $events->groupBy('venue_id');

        foreach ($venueGroups as $venueEvents) {
            $venue = $venueEvents->first()->venue;
            
            if (!$venue || !$venue->hasCoordinates()) {
                continue;
            }

            $markerEvents = $venueEvents->map(function ($event) {
                return $this->formatEventForMarker($event);
            });

            $markers[] = [
                'id' => $venue->id,
                'latitude' => (float) $venue->latitude,
                'longitude' => (float) $venue->longitude,
                'venue' => [
                    'id' => $venue->id,
                    'name' => $venue->name,
                    'address' => $venue->full_address,
                    'city' => $venue->city,
                    'state' => $venue->state,
                    'phone' => $venue->phone,
                    'website' => $venue->website,
                    'description' => $venue->description
                ],
                'events' => $markerEvents,
                'event_count' => $markerEvents->count(),
                'cluster' => $markerEvents->count() > 1,
                'icon' => $this->getMarkerIcon($venueEvents),
                'color' => $this->getMarkerColor($venueEvents)
            ];
        }

        return $markers;
    }

    /**
     * Get events near a specific location
     */
    public function getEventsNearby(float $latitude, float $longitude, int $radius = 25, int $limit = 20): Collection
    {
        $events = Event::with(['venue', 'category'])
                      ->where('status', 'active')
                      ->where('date', '>=', now())
                      ->whereHas('venue', function($q) use ($latitude, $longitude, $radius) {
                          $q->withinDistance($latitude, $longitude, $radius);
                      })
                      ->orderByDistance('venue', $latitude, $longitude)
                      ->limit($limit)
                      ->get();

        return $events->map(function ($event) use ($latitude, $longitude) {
            $eventData = $this->formatEventForMap($event);
            
            // Add distance calculation
            if ($event->venue && $event->venue->hasCoordinates()) {
                $eventData['distance'] = $event->venue->distanceTo($latitude, $longitude);
                $eventData['distance_formatted'] = number_format($eventData['distance'], 1) . ' km away';
            }
            
            return $eventData;
        });
    }

    /**
     * Format event for map marker popup
     */
    public function formatEventForMarker(Event $event): array
    {
        return [
            'id' => $event->id,
            'name' => $event->name,
            'description' => \Str::limit($event->description, 100),
            'date' => $event->date->format('M d, Y'),
            'time' => $event->date->format('g:i A'),
            'formatted_datetime' => $event->date->format('M d, Y \a\t g:i A'),
            'price' => $event->formatted_price,
            'category' => $event->category?->name,
            'category_color' => $event->category?->color ?? '#6b7280',
            'available_tickets' => $event->getAvailableTicketQuantity(),
            'is_sold_out' => $event->getAvailableTicketQuantity() === 0,
            'is_featured' => $event->is_featured,
            'image' => $event->featuredImage?->file_path,
            'url' => route('events.show', $event),
            'booking_url' => route('events.book', $event)
        ];
    }

    /**
     * Format event for map display (full details)
     */
    public function formatEventForMap(Event $event): array
    {
        $data = $this->formatEventForMarker($event);
        
        // Add venue and location details
        if ($event->venue) {
            $data['venue'] = [
                'id' => $event->venue->id,
                'name' => $event->venue->name,
                'address' => $event->venue->full_address,
                'city' => $event->venue->city,
                'state' => $event->venue->state,
                'coordinates' => [
                    'latitude' => $event->venue->latitude,
                    'longitude' => $event->venue->longitude
                ],
                'phone' => $event->venue->phone,
                'website' => $event->venue->website
            ];
        }

        return $data;
    }

    /**
     * Get marker icon based on events
     */
    private function getMarkerIcon(Collection $events): string
    {
        $hasMultipleEvents = $events->count() > 1;
        $hasFeaturedEvent = $events->where('is_featured', true)->isNotEmpty();
        $hasSoldOutEvent = $events->filter(function($event) {
            return $event->getAvailableTicketQuantity() === 0;
        })->isNotEmpty();

        if ($hasSoldOutEvent) {
            return $hasMultipleEvents ? 'cluster-sold-out' : 'marker-sold-out';
        }

        if ($hasFeaturedEvent) {
            return $hasMultipleEvents ? 'cluster-featured' : 'marker-featured';
        }

        return $hasMultipleEvents ? 'cluster-default' : 'marker-default';
    }

    /**
     * Get marker color based on events
     */
    private function getMarkerColor(Collection $events): string
    {
        $hasFeaturedEvent = $events->where('is_featured', true)->isNotEmpty();
        $hasSoldOutEvent = $events->filter(function($event) {
            return $event->getAvailableTicketQuantity() === 0;
        })->isNotEmpty();

        if ($hasSoldOutEvent) {
            return '#ef4444'; // Red for sold out
        }

        if ($hasFeaturedEvent) {
            return '#f59e0b'; // Amber for featured
        }

        // Get dominant category color
        $categoryColors = $events->pluck('category.color')->filter();
        
        if ($categoryColors->isNotEmpty()) {
            return $categoryColors->first();
        }

        return '#3b82f6'; // Default blue
    }

    /**
     * Calculate optimal zoom level based on venue spread
     */
    private function calculateOptimalZoom(Collection $venues): int
    {
        if ($venues->count() <= 1) {
            return 14;
        }

        $latitudes = $venues->pluck('latitude');
        $longitudes = $venues->pluck('longitude');

        $latRange = $latitudes->max() - $latitudes->min();
        $lngRange = $longitudes->max() - $longitudes->min();

        $maxRange = max($latRange, $lngRange);

        if ($maxRange > 10) return 6;
        if ($maxRange > 5) return 8;
        if ($maxRange > 2) return 10;
        if ($maxRange > 1) return 11;
        if ($maxRange > 0.5) return 12;
        if ($maxRange > 0.1) return 13;

        return 14;
    }

    /**
     * Get venue clusters for map performance
     */
    public function getVenueClusters(array $filters = [], int $zoom = 10): array
    {
        $events = $this->getEventsWithLocation($filters);
        $venues = $events->pluck('venue')->unique('id');

        if ($zoom >= 12) {
            // Show individual markers at high zoom
            return $this->getEventMarkers($filters);
        }

        // Cluster venues by geographic proximity
        $clusters = $this->clusterVenuesByProximity($venues, $zoom);

        return $clusters;
    }

    /**
     * Cluster venues by geographic proximity
     */
    private function clusterVenuesByProximity(Collection $venues, int $zoom): array
    {
        $clusters = [];
        $processed = [];

        // Distance threshold based on zoom level
        $distanceThreshold = $this->getClusterDistanceThreshold($zoom);

        foreach ($venues as $venue) {
            if (in_array($venue->id, $processed) || !$venue->hasCoordinates()) {
                continue;
            }

            $cluster = [
                'id' => 'cluster_' . $venue->id,
                'latitude' => (float) $venue->latitude,
                'longitude' => (float) $venue->longitude,
                'venues' => [$venue],
                'event_count' => $venue->events()->where('status', 'active')->count()
            ];

            $processed[] = $venue->id;

            // Find nearby venues to cluster
            foreach ($venues as $otherVenue) {
                if (in_array($otherVenue->id, $processed) || !$otherVenue->hasCoordinates()) {
                    continue;
                }

                $distance = $venue->distanceTo($otherVenue->latitude, $otherVenue->longitude);

                if ($distance <= $distanceThreshold) {
                    $cluster['venues'][] = $otherVenue;
                    $cluster['event_count'] += $otherVenue->events()->where('status', 'active')->count();
                    $processed[] = $otherVenue->id;

                    // Recalculate cluster center
                    $totalLat = collect($cluster['venues'])->sum('latitude');
                    $totalLng = collect($cluster['venues'])->sum('longitude');
                    $count = count($cluster['venues']);

                    $cluster['latitude'] = $totalLat / $count;
                    $cluster['longitude'] = $totalLng / $count;
                }
            }

            $cluster['is_cluster'] = count($cluster['venues']) > 1;
            $cluster['venue_count'] = count($cluster['venues']);
            
            $clusters[] = $cluster;
        }

        return $clusters;
    }

    /**
     * Get distance threshold for clustering based on zoom level
     */
    private function getClusterDistanceThreshold(int $zoom): float
    {
        // Distance in kilometers
        $thresholds = [
            1 => 1000,  // Very low zoom - cluster everything far apart
            2 => 500,
            3 => 250,
            4 => 100,
            5 => 50,
            6 => 25,
            7 => 15,
            8 => 10,
            9 => 5,
            10 => 2,
            11 => 1,
            12 => 0.5,  // High zoom - minimal clustering
        ];

        return $thresholds[$zoom] ?? 0.5;
    }

    /**
     * Get popular locations with event counts
     */
    public function getPopularLocations(int $limit = 10): Collection
    {
        return Venue::has('events')
                   ->withCount(['events' => function($query) {
                       $query->where('status', 'active')
                             ->where('date', '>=', now());
                   }])
                   ->whereNotNull('latitude')
                   ->whereNotNull('longitude')
                   ->orderByDesc('events_count')
                   ->limit($limit)
                   ->get(['id', 'name', 'city', 'state', 'latitude', 'longitude'])
                   ->map(function($venue) {
                       return [
                           'id' => $venue->id,
                           'name' => $venue->name,
                           'location' => $venue->city . ', ' . $venue->state,
                           'coordinates' => [
                               'latitude' => $venue->latitude,
                               'longitude' => $venue->longitude
                           ],
                           'event_count' => $venue->events_count,
                           'url' => route('venues.show', $venue)
                       ];
                   });
    }
}