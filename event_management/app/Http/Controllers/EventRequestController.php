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
        $requests = EventRequest::where('user_id', auth()->id())->get();
        return view('event_requests.index', compact('requests'));
    }

    /**
     * Store a new event request from a user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'event_title' => 'required|string|max:255',
            'event_description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'venue' => 'required|string|max:255',
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = 'pending';

        EventRequest::create($data);

        return redirect()->route('event-requests.index')
            ->with('status', 'Your event request has been submitted and is pending approval.');
    }

    /**
     * Admin: view all event requests.
     */
    public function adminIndex()
    {
        $requests = EventRequest::with('user')->get();
        return view('admin.event_requests.index', compact('requests'));
    }

    /**
     * Admin: approve a request and create an Event.
     */
    public function approve($id)
    {
        $req = EventRequest::findOrFail($id);
        $req->status = 'approved';
        $req->save();

        // Handle venue: either find existing or create new
        $venue = Venue::firstOrCreate(
            ['name' => $req->venue],
            ['address' => 'TBD', 'capacity' => 0]
        );

        Event::create([
            'title' => $req->event_title,
            'description' => $req->event_description,
            'start_date' => $req->start_date,
            'end_date' => $req->end_date,
            'venue_id' => $venue->id,
        ]);

        return back()->with('status', 'Event request approved and event created.');
    }

    /**
     * Admin: reject a request.
     */
    public function reject($id)
    {
        $req = EventRequest::findOrFail($id);
        $req->status = 'rejected';
        $req->save();

        return back()->with('status', 'Event request rejected.');
    }
}