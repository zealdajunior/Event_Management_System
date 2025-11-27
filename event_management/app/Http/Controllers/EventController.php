<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        // Fetch all events with their venue
        $events = Event::with('venue')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $venues = Venue::all();
        return view('events.create', compact('venues'));
    }

    /**
     * Store a newly created event in the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'venue_id' => 'nullable|exists:venues,id',
        ]);

        Event::create($data);

        return redirect()->route('events.index')
            ->with('status', 'Event created successfully.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        $venues = Venue::all();
        return view('events.edit', compact('event', 'venues'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'venue_id' => 'nullable|exists:venues,id',
        ]);

        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('status', 'Event updated successfully.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('status', 'Event deleted successfully.');
    }
}