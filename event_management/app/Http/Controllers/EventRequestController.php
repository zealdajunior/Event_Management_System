<?php

namespace App\Http\Controllers;

use App\Models\EventRequest;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\Request;

class EventRequestController extends Controller
{
    /**
     * Show all requests for the logged-in user.
     */
    public function index()
    {
        $requests = EventRequest::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('event_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new event request.
     */
    public function create()
    {
        return view('event_requests.create');
    }

    /**
     * Store a new event request from a user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_title'          => 'required|string|max:255',
            'event_description'    => 'required|string',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date|after_or_equal:start_date',
            'venue'                => 'required|string|max:255',
            'expected_attendance'  => 'nullable|integer|min:1',
            'event_category'       => 'nullable|string|max:255',
            'target_audience'      => 'nullable|string',
            'budget_estimate'      => 'nullable|numeric|min:0',
            'ticket_pricing'       => 'nullable|string|max:255',
            'special_requirements' => 'nullable|string',
            'marketing_plan'       => 'nullable|string',
            'contact_phone'        => 'nullable|string|max:255',
            'contact_email'        => 'nullable|email|max:255',
            'additional_notes'     => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'pending'; // use string instead of constant

        EventRequest::create($data);

        return redirect()
            ->route('event-requests.index')
            ->with('status', 'Your event request has been submitted and is pending approval.');
    }

    /**
     * Admin: view all event requests.
     */
    public function adminIndex()
    {
        $requests = EventRequest::with('user')
            ->latest()
            ->get();

        return view('admin.event_requests.index', compact('requests'));
    }

    /**
     * Admin: approve a request and create an Event.
     */
    public function approve($id)
    {
        $req = EventRequest::findOrFail($id);

        $req->update(['status' => EventRequest::STATUS_APPROVED]);

        // Handle venue: either find existing or create new
        $venue = Venue::firstOrCreate(
            ['name' => $req->venue],
            ['address' => 'TBD', 'capacity' => 0]
        );

        Event::create([
            'name'        => $req->event_title,
            'description' => $req->event_description,
            'date'        => $req->start_date,
            'end_date'    => $req->end_date,
            'venue_id'    => $venue->id,
            'user_id'     => $req->user_id, // link event to requester
            'status'      => 'active', // ensure event is active and visible to all users
        ]);

        return redirect()
            ->route('admin.event_requests.index')
            ->with('status', 'Event request approved and event created.');
    }

    /**
     * Admin: reject a request.
     */
    public function reject($id)
    {
        $req = EventRequest::findOrFail($id);

        $req->update(['status' => EventRequest::STATUS_REJECTED]);

        return redirect()
            ->route('admin.event_requests.index')
            ->with('status', 'Event request rejected.');
    }
}