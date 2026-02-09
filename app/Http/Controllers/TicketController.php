<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Event;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->middleware('auth');
        $this->paymentService = $paymentService;
    }

    /**
     * Show checkout page for event
     */
    public function checkout(Event $event)
    {
        // Check if event is approved
        if ($event->approval_status !== 'approved') {
            return redirect()->route('events.show', $event)
                ->with('error', 'This event is not available for ticket purchase');
        }

        // Check if there are available tickets
        $soldTickets = $event->tickets()->where('status', '!=', 'cancelled')->count();
        if ($event->capacity && $soldTickets >= $event->capacity) {
            return redirect()->route('events.show', $event)
                ->with('error', 'This event is sold out');
        }

        $availableTickets = $event->capacity ? ($event->capacity - $soldTickets) : 999;

        return view('tickets.checkout', compact('event', 'availableTickets'));
    }

    /**
     * Process checkout and create Stripe session
     */
    public function processCheckout(Request $request, Event $event)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $request->quantity;

        // Check availability
        $soldTickets = $event->tickets()->where('status', '!=', 'cancelled')->count();
        $availableCapacity = $event->capacity - $soldTickets;
        
        if ($event->capacity && $quantity > $availableCapacity) {
            return back()->with('error', "Only {$availableCapacity} tickets available");
        }

        try {
            $result = $this->paymentService->createCheckoutSession(
                $event,
                $quantity,
                Auth::user()
            );

            // Redirect to Stripe Checkout
            return redirect($result['session']->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment callback
     */
    public function success(Request $request, Payment $payment)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('dashboard')->with('error', 'Invalid payment session');
        }

        try {
            $result = $this->paymentService->processSuccessfulPayment($payment, $sessionId);

            return view('tickets.success', [
                'payment' => $result['payment'],
                'tickets' => $result['tickets'],
                'event' => $payment->event,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Payment verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment cancellation
     */
    public function cancel(Payment $payment)
    {
        $payment->update(['status' => 'cancelled']);

        return redirect()->route('events.show', $payment->event)
            ->with('error', 'Payment was cancelled');
    }

    /**
     * Show user's tickets
     */
    public function myTickets()
    {
        $tickets = Ticket::with(['event', 'payment'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tickets.my-tickets', compact('tickets'));
    }

    /**
     * View single ticket details
     */
    public function show(Ticket $ticket)
    {
        // Check authorization
        if ($ticket->user_id !== Auth::id() && $ticket->event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Check-in scanner page
     */
    public function scannerPage(Event $event)
    {
        // Only event organizer can access
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('tickets.scanner', compact('event'));
    }

    /**
     * Process ticket check-in
     */
    public function checkIn(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        try {
            $ticket = $this->paymentService->checkInTicket(
                $request->qr_data,
                Auth::user()
            );

            return response()->json([
                'success' => true,
                'message' => 'Ticket checked in successfully',
                'ticket' => $ticket->load('user', 'event'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show event check-in statistics
     */
    public function checkInStats(Event $event)
    {
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $stats = [
            'total_tickets' => $event->tickets()->count(),
            'checked_in' => $event->tickets()->where('status', 'used')->count(),
            'pending' => $event->tickets()->where('status', 'confirmed')->count(),
            'cancelled' => $event->tickets()->where('status', 'cancelled')->count(),
        ];

        $recentCheckIns = $event->tickets()
            ->where('status', 'used')
            ->with('user')
            ->orderBy('check_in_at', 'desc')
            ->take(10)
            ->get();

        return view('tickets.stats', compact('event', 'stats', 'recentCheckIns'));
    }

    // Legacy methods for admin ticket management
    public function index()
    {
        $tickets = Ticket::with('event')->paginate(20);
        return view('tickets.index', compact('tickets'));
    }
}
