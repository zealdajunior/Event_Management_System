<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use App\Services\MapService;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class CalendarController extends Controller
{
    protected CalendarService $calendarService;
    protected MapService $mapService;

    public function __construct(CalendarService $calendarService, MapService $mapService)
    {
        $this->calendarService = $calendarService;
        $this->mapService = $mapService;
    }

    /**
     * Display the calendar view
     */
    public function index(Request $request)
    {
        $filters = $this->calendarService->getFilterOptions();
        
        // Get initial calendar stats for current month
        $currentMonth = now();
        $stats = $this->calendarService->getCalendarStats(
            $currentMonth->startOfMonth()->toDateString(),
            $currentMonth->endOfMonth()->toDateString()
        );

        return view('calendar.index', compact('filters', 'stats'));
    }

    /**
     * Get calendar events as JSON for FullCalendar
     */
    public function events(Request $request): JsonResponse
    {
        $filters = $request->only([
            'category_id',
            'venue_id', 
            'location',
            'start_date',
            'end_date',
            'price_min',
            'price_max',
            'latitude',
            'longitude',
            'radius'
        ]);

        // Add date range from FullCalendar
        if ($request->has('start')) {
            $filters['start_date'] = Carbon::parse($request->start)->startOfDay();
        }
        if ($request->has('end')) {
            $filters['end_date'] = Carbon::parse($request->end)->endOfDay();
        }

        $events = $this->calendarService->getCalendarEvents($filters);

        return response()->json($events);
    }

    /**
     * Get calendar statistics for date range
     */
    public function stats(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after:start'
        ]);

        $stats = $this->calendarService->getCalendarStats(
            $request->start,
            $request->end
        );

        return response()->json($stats);
    }

    /**
     * Get events for a specific date
     */
    public function eventsForDate(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $events = $this->calendarService->getEventsForDate($request->date);

        return response()->json([
            'date' => $request->date,
            'events' => $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'name' => $event->name,
                    'time' => $event->date->format('H:i'),
                    'formatted_time' => $event->date->format('g:i A'),
                    'duration' => $event->duration_hours,
                    'venue' => $event->venue?->name ?? $event->location,
                    'price' => $event->formatted_price,
                    'available_tickets' => $event->getAvailableTicketQuantity(),
                    'is_sold_out' => $event->getAvailableTicketQuantity() === 0,
                    'url' => route('events.show', $event),
                    'image' => $event->featuredImage?->file_path,
                    'category' => $event->category?->name
                ];
            })
        ]);
    }

    /**
     * Calendar and Map combined view
     */
    public function mapView(Request $request)
    {
        $filters = $this->calendarService->getFilterOptions();
        
        // Get events with location data for map
        $eventsWithLocation = $this->mapService->getEventsWithLocation();
        
        // Get map center based on events or user location
        $mapCenter = $this->mapService->getMapCenter($eventsWithLocation);

        return view('calendar.map', compact('filters', 'eventsWithLocation', 'mapCenter'));
    }

    /**
     * Get map markers for events
     */
    public function mapMarkers(Request $request): JsonResponse
    {
        $filters = $request->only([
            'category_id',
            'location',
            'start_date',
            'end_date',
            'price_min',
            'price_max',
            'latitude',
            'longitude',
            'radius'
        ]);

        $markers = $this->mapService->getEventMarkers($filters);

        return response()->json($markers);
    }

    /**
     * Get events near a location
     */
    public function eventsNearby(Request $request): JsonResponse
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'integer|min:1|max:500', // km
            'limit' => 'integer|min:1|max:100'
        ]);

        $radius = $request->radius ?? 25; // Default 25km
        $limit = $request->limit ?? 20;

        $events = $this->mapService->getEventsNearby(
            $request->latitude,
            $request->longitude,
            $radius,
            $limit
        );

        return response()->json([
            'location' => [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'radius' => $radius
            ],
            'events' => $events
        ]);
    }

    /**
     * Search events with location and calendar filtering
     */
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'type' => 'in:events,calendar,map',
            'category_id' => 'exists:categories,id',
            'price_range' => 'in:free,under_50,under_100,over_100',
            'location' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date'
        ]);

        $query = $request->query;
        $type = $request->type ?? 'events';
        $filters = $request->only(['category_id', 'price_range', 'location', 'start_date', 'end_date']);

        $results = $this->calendarService->searchEvents($query, $filters);

        $response = [
            'query' => $query,
            'total_results' => $results->count(),
            'results' => []
        ];

        switch ($type) {
            case 'calendar':
                $response['results'] = $results->map(function ($event) {
                    return $this->calendarService->formatEventForCalendar($event);
                });
                break;

            case 'map':
                $response['results'] = $results->filter(function ($event) {
                    return $event->venue && $event->venue->hasCoordinates();
                })->map(function ($event) {
                    return $this->mapService->formatEventForMap($event);
                });
                break;

            default: // events
                $response['results'] = $results->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'name' => $event->name,
                        'description' => \Str::limit($event->description, 150),
                        'date' => $event->date->format('M d, Y'),
                        'time' => $event->date->format('g:i A'),
                        'venue' => $event->venue?->name ?? $event->location,
                        'location' => $event->venue?->city ?? '',
                        'price' => $event->formatted_price,
                        'category' => $event->category?->name,
                        'image' => $event->featuredImage?->file_path,
                        'url' => route('events.show', $event),
                        'is_featured' => $event->is_featured,
                        'available_tickets' => $event->getAvailableTicketQuantity()
                    ];
                });
                break;
        }

        return response()->json($response);
    }

    /**
     * Export calendar events
     */
    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:ics,csv,json',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date'
        ]);

        $format = $request->format;
        $filters = $request->only(['start_date', 'end_date', 'category_id', 'venue_id']);
        
        $events = $this->calendarService->getCalendarEvents($filters);

        switch ($format) {
            case 'ics':
                return $this->exportICS($events);
            case 'csv':
                return $this->exportCSV($events);
            case 'json':
                return response()->json($events, 200, [
                    'Content-Disposition' => 'attachment; filename="events-calendar-' . date('Y-m-d') . '.json"'
                ]);
        }
    }

    /**
     * Export events as ICS format
     */
    private function exportICS($events)
    {
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Event Management System//Calendar//EN\r\n";
        
        foreach ($events as $event) {
            $ics .= "BEGIN:VEVENT\r\n";
            $ics .= "UID:" . $event['id'] . "@eventmanagement.local\r\n";
            $ics .= "DTSTART:" . Carbon::parse($event['start'])->format('Ymd\THis\Z') . "\r\n";
            $ics .= "DTEND:" . Carbon::parse($event['end'])->format('Ymd\THis\Z') . "\r\n";
            $ics .= "SUMMARY:" . $event['title'] . "\r\n";
            
            if (isset($event['extendedProps']['description'])) {
                $ics .= "DESCRIPTION:" . str_replace(["\r", "\n"], ['\r', '\n'], $event['extendedProps']['description']) . "\r\n";
            }
            
            if (isset($event['extendedProps']['location'])) {
                $ics .= "LOCATION:" . $event['extendedProps']['location'] . "\r\n";
            }
            
            if (isset($event['url'])) {
                $ics .= "URL:" . $event['url'] . "\r\n";
            }
            
            $ics .= "END:VEVENT\r\n";
        }
        
        $ics .= "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar',
            'Content-Disposition' => 'attachment; filename="events-calendar-' . date('Y-m-d') . '.ics"'
        ]);
    }

    /**
     * Export events as CSV format
     */
    private function exportCSV($events)
    {
        $csvData = [];
        $csvData[] = ['Event Name', 'Date', 'Time', 'Location', 'Category', 'Price', 'Available Tickets', 'Status'];
        
        foreach ($events as $event) {
            $csvData[] = [
                $event['title'],
                Carbon::parse($event['start'])->format('Y-m-d'),
                Carbon::parse($event['start'])->format('H:i'),
                $event['extendedProps']['location'] ?? '',
                $event['extendedProps']['category'] ?? '',
                $event['extendedProps']['formatted_price'] ?? '',
                $event['extendedProps']['available_tickets'] ?? '',
                $event['extendedProps']['is_sold_out'] ? 'Sold Out' : 'Available'
            ];
        }

        $filename = 'events-calendar-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];

        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
