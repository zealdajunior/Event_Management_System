<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Waitlist;
use App\Services\WaitlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WaitlistController extends Controller
{
    protected $waitlistService;

    public function __construct(WaitlistService $waitlistService)
    {
        $this->middleware('auth');
        $this->waitlistService = $waitlistService;
    }

    /**
     * Display user's waitlist entries
     */
    public function index()
    {
        $waitlists = Waitlist::with(['event', 'ticket'])
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();

        return view('waitlist.index', compact('waitlists'));
    }

    /**
     * Join waitlist for an event/ticket
     */
    public function join(Request $request, Event $event)
    {
        $request->validate([
            'ticket_id' => 'nullable|exists:tickets,id',
            'quantity' => 'integer|min:1|max:10',
        ]);

        try {
            $result = $this->waitlistService->joinWaitlist(
                Auth::id(),
                $event->id,
                $request->ticket_id,
                $request->quantity ?? 1
            );

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'position' => $result['position'],
                    'waitlist_id' => $result['waitlist']->id,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to join waitlist. Please try again.',
            ], 500);
        }
    }

    /**
     * Leave waitlist
     */
    public function leave(Request $request, Event $event)
    {
        $request->validate([
            'ticket_id' => 'nullable|exists:tickets,id',
        ]);

        try {
            $result = $this->waitlistService->leaveWaitlist(
                Auth::id(),
                $event->id,
                $request->ticket_id
            );

            return response()->json([
                'success' => $result['success'],
                'message' => $result['message'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to leave waitlist. Please try again.',
            ], 500);
        }
    }

    /**
     * Check waitlist status for user
     */
    public function status(Event $event, Request $request)
    {
        $ticketId = $request->query('ticket_id');
        
        $waitlistEntry = Waitlist::where('user_id', Auth::id())
                                ->where('event_id', $event->id)
                                ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                                ->first();

        if (!$waitlistEntry) {
            return response()->json([
                'on_waitlist' => false,
            ]);
        }

        return response()->json([
            'on_waitlist' => true,
            'position' => $waitlistEntry->position,
            'status' => $waitlistEntry->status,
            'quantity' => $waitlistEntry->quantity,
            'time_remaining' => $waitlistEntry->time_remaining,
            'notified_at' => $waitlistEntry->notified_at,
            'expires_at' => $waitlistEntry->expires_at,
        ]);
    }

    /**
     * Admin: View waitlist for an event
     */
    public function adminIndex(Event $event)
    {
        $this->authorize('viewAny', Waitlist::class);

        $waitlists = Waitlist::with(['user', 'ticket'])
                            ->where('event_id', $event->id)
                            ->orderBy('position')
                            ->get()
                            ->groupBy('ticket_id');

        $tickets = $event->tickets()->get();

        return view('admin.waitlist.index', compact('event', 'waitlists', 'tickets'));
    }

    /**
     * Admin: Manually promote from waitlist
     */
    public function promote(Request $request, Event $event)
    {
        $this->authorize('update', Waitlist::class);

        $request->validate([
            'waitlist_ids' => 'required|array',
            'waitlist_ids.*' => 'exists:waitlists,id',
        ]);

        try {
            DB::beginTransaction();

            $promoted = [];
            foreach ($request->waitlist_ids as $waitlistId) {
                $waitlistEntry = Waitlist::findOrFail($waitlistId);
                
                if ($waitlistEntry->status === 'waiting') {
                    $waitlistEntry->markAsNotified();
                    $promoted[] = $waitlistEntry;
                    
                    // Send notification
                    $this->waitlistService->sendPromotionNotification($waitlistEntry);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($promoted) . ' users promoted from waitlist.',
                'promoted_count' => count($promoted),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to promote from waitlist.',
            ], 500);
        }
    }

    /**
     * User: Accept waitlist promotion and proceed to booking
     */
    public function accept(Waitlist $waitlist)
    {
        if ($waitlist->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($waitlist->status !== 'notified' || $waitlist->isExpired()) {
            return redirect()->route('events.show', $waitlist->event)
                           ->with('error', 'This waitlist promotion has expired.');
        }

        // Mark as converted and redirect to booking
        $waitlist->markAsConverted();

        return redirect()->route('bookings.create-for-event', [
            'event' => $waitlist->event,
            'ticket_id' => $waitlist->ticket_id,
            'quantity' => $waitlist->quantity,
            'from_waitlist' => true,
        ])->with('success', 'You have been promoted from the waitlist! Please complete your booking within 10 minutes.');
    }

    /**
     * User: Decline waitlist promotion
     */
    public function decline(Waitlist $waitlist)
    {
        if ($waitlist->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($waitlist->status !== 'notified') {
            return response()->json([
                'success' => false,
                'message' => 'This promotion is no longer valid.',
            ]);
        }

        try {
            $waitlist->markAsExpired();

            // Promote next person in line
            $promoted = $this->waitlistService->promoteNext(
                $waitlist->event_id,
                $waitlist->ticket_id,
                $waitlist->quantity
            );

            return response()->json([
                'success' => true,
                'message' => 'You have declined the waitlist promotion.',
                'next_promoted' => count($promoted),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to decline promotion.',
            ], 500);
        }
    }

    /**
     * Get waitlist statistics for an event
     */
    public function statistics(Event $event)
    {
        $stats = [
            'total_waiting' => Waitlist::forEvent($event->id)->waiting()->count(),
            'total_notified' => Waitlist::forEvent($event->id)->notified()->count(),
            'total_converted' => Waitlist::forEvent($event->id)->where('status', 'converted')->count(),
            'total_expired' => Waitlist::forEvent($event->id)->where('status', 'expired')->count(),
            'by_ticket' => [],
        ];

        // Get stats by ticket type
        foreach ($event->tickets as $ticket) {
            $stats['by_ticket'][$ticket->id] = [
                'name' => $ticket->name,
                'waiting' => Waitlist::forEvent($event->id)->forTicket($ticket->id)->waiting()->count(),
                'notified' => Waitlist::forEvent($event->id)->forTicket($ticket->id)->notified()->count(),
            ];
        }

        return response()->json($stats);
    }
}
