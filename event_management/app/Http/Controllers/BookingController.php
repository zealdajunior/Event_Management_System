<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $bookings = Booking::with(['user','event','ticket'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $events = \App\Models\Event::with('tickets')->get();
        return view('bookings.create', compact('events'));
    }

    public function createForEvent(\App\Models\Event $event)
    {
        $event->load('tickets');
        return view('bookings.create_for_event', compact('event'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        try {
            DB::beginTransaction();

            // Check if ticket is available using service
            $ticket = Ticket::find($request->ticket_id);
            if (!$this->ticketService->isTicketAvailable($ticket)) {
                return back()->withErrors(['ticket_id' => 'This ticket type is sold out.']);
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'booking_date' => now(),
                'status' => 'confirmed', // Add status field
            ]);

            // Decrement ticket quantity using service
            $this->ticketService->updateTicketAvailability($ticket, -1);

            DB::commit();

            Log::info("Booking created successfully", [
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id
            ]);

            return redirect()->route('bookings.show', $booking)->with('status', 'Booking created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to create booking", [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id
            ]);

            return back()->withErrors(['general' => 'An error occurred while processing your booking. Please try again.']);
        }
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $events = \App\Models\Event::with('tickets')->get();
        return view('bookings.edit', compact('booking', 'events'));
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $booking->update($data);
        return redirect()->route('bookings.show', $booking)->with('status', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('status', 'Booking deleted successfully.');
    }
}