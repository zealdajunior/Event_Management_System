<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user','event','ticket'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'event_id' => $request->event_id,
            'ticket_id' => $request->ticket_id,
            'booking_date' => now(),
        ]);

        $ticket = Ticket::find($request->ticket_id);
        $ticket->quantity -= 1;
        $ticket->save();

        return redirect()->route('bookings.show', $booking);
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index');
    }
}