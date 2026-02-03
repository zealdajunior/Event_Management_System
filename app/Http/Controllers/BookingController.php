<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Waitlist;
use App\Services\TicketService;
use App\Services\WaitlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected $ticketService;
    protected $waitlistService;

    public function __construct(TicketService $ticketService, WaitlistService $waitlistService)
    {
        $this->ticketService = $ticketService;
        $this->waitlistService = $waitlistService;
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

    public function createForEvent(Event $event)
    {
        $event->load('tickets');
        
        // Check if user is coming from waitlist promotion
        $fromWaitlist = request()->query('from_waitlist', false);
        $waitlistTicketId = request()->query('ticket_id');
        $waitlistQuantity = request()->query('quantity', 1);
        
        return view('bookings.create_for_event', compact('event', 'fromWaitlist', 'waitlistTicketId', 'waitlistQuantity'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        try {
            DB::beginTransaction();

            $quantity = $request->quantity ?? 1;
            $fromWaitlist = $request->from_waitlist === 'true';

            // Check if ticket is available using service
            $ticket = Ticket::find($request->ticket_id);
            if (!$this->ticketService->isTicketAvailable($ticket, $quantity)) {
                // If not available and not from waitlist, suggest joining waitlist
                if (!$fromWaitlist) {
                    $event = Event::find($request->event_id);
                    $canJoinWaitlist = $event->canJoinWaitlist(auth()->id(), $ticket->id);
                    
                    if ($canJoinWaitlist['can_join']) {
                        return back()->withErrors([
                            'ticket_id' => 'This ticket type is sold out. Would you like to join the waitlist?',
                            'show_waitlist_option' => true,
                            'event_id' => $request->event_id,
                            'ticket_id' => $request->ticket_id,
                            'quantity' => $quantity,
                        ]);
                    }
                }
                
                return back()->withErrors(['ticket_id' => 'This ticket type is sold out.']);
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'quantity' => $quantity,
                'booking_date' => now(),
                'status' => 'confirmed',
            ]);

            // Decrement ticket quantity using service
            $this->ticketService->updateTicketAvailability($ticket, -$quantity);

            // If this booking came from waitlist, mark waitlist as converted
            if ($fromWaitlist) {
                $waitlistEntry = Waitlist::where('user_id', auth()->id())
                                       ->where('event_id', $request->event_id)
                                       ->where('ticket_id', $request->ticket_id)
                                       ->where('status', 'notified')
                                       ->first();
                
                if ($waitlistEntry) {
                    $waitlistEntry->markAsConverted();
                }
            }

            // Create attendance record with QR code
            \App\Models\Attendance::create([
                'booking_id' => $booking->id,
                'event_id' => $request->event_id,
                'user_id' => auth()->id(),
                'qr_code' => \Illuminate\Support\Str::uuid(),
                'status' => 'pending',
            ]);

            // Send booking confirmation notification
            auth()->user()->notify(new \App\Notifications\BookingConfirmedNotification($booking));

            DB::commit();

            Log::info("Booking created successfully", [
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'quantity' => $quantity,
                'from_waitlist' => $fromWaitlist,
            ]);

            // Redirect to payment if price > 0, otherwise to ticket
            if ($ticket->price > 0) {
                return redirect()->route('payments.create.for.booking', $booking)
                               ->with('status', 'Booking created successfully! Please complete payment.');
            } else {
                return redirect()->route('bookings.ticket', $booking)
                               ->with('status', 'Booking created successfully! Your ticket is ready.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to create booking", [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'quantity' => $quantity ?? 1,
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
        try {
            DB::beginTransaction();

            $eventId = $booking->event_id;
            $ticketId = $booking->ticket_id;
            $quantity = $booking->quantity ?? 1;

            // Restore ticket availability
            $ticket = $booking->ticket;
            if ($ticket) {
                $this->ticketService->updateTicketAvailability($ticket, $quantity);
            }

            // Delete the booking
            $booking->delete();

            // Try to promote someone from waitlist
            $this->waitlistService->handleTicketRelease($eventId, $ticketId, $quantity);

            DB::commit();

            Log::info("Booking deleted and waitlist processed", [
                'booking_id' => $booking->id,
                'event_id' => $eventId,
                'ticket_id' => $ticketId,
                'quantity' => $quantity,
            ]);

            return redirect()->route('bookings.index')->with('status', 'Booking cancelled successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Failed to delete booking", [
                'error' => $e->getMessage(),
                'booking_id' => $booking->id,
            ]);

            return back()->withErrors(['general' => 'Failed to cancel booking. Please try again.']);
        }
    }
}