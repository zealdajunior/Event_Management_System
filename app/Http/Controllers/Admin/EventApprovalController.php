<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventApproved;
use App\Mail\EventRejected;

class EventApprovalController extends Controller
{
    /**
     * Display pending events for approval
     */
    public function index(Request $request)
    {
        $query = Event::with(['user', 'verification', 'venue'])
            ->where('approval_status', 'pending');

        // Filter by risk score if specified
        if ($request->has('risk_level')) {
            $query->whereHas('verification', function ($q) use ($request) {
                switch ($request->risk_level) {
                    case 'high':
                        $q->where('risk_score', '>=', 60);
                        break;
                    case 'medium':
                        $q->whereBetween('risk_score', [30, 59]);
                        break;
                    case 'low':
                        $q->where('risk_score', '<', 30);
                        break;
                }
            });
        }

        // Search by event name or organizer
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $pendingEvents = $query->orderBy('created_at', 'desc')->paginate(20);
        $stats = $this->getApprovalStats();

        return view('admin.events.approval.index', compact('pendingEvents', 'stats'));
    }

    /**
     * Show detailed view of event for approval
     */
    public function show(Event $event)
    {
        $event->load(['user', 'verification', 'venue', 'tickets']);
        
        // Calculate risk assessment if not done
        if ($event->verification && !$event->verification->risk_score) {
            $event->verification->calculateRiskScore();
        }

        return view('admin.events.approval.show', compact('event'));
    }

    /**
     * Approve an event
     */
    public function approve(Request $request, Event $event)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Update event approval status
            $event->update([
                'approval_status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Update verification status if exists
            if ($event->verification) {
                $event->verification->approve(
                    Auth::id(),
                    $request->notes
                );
            }

            // Mark user as able to organize events
            if ($event->user && !$event->user->can_organize_events) {
                $event->user->update([
                    'can_organize_events' => true,
                ]);
            }

            DB::commit();

            // Send approval email to organizer
            try {
                Mail::to($event->user->email)->send(new EventApproved($event));
            } catch (\Exception $e) {
                // Log email error but don't fail the approval
                \Log::error('Failed to send event approval email', [
                    'event_id' => $event->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()
                ->route('admin.events.approval.index')
                ->with('success', 'Event approved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve event: ' . $e->getMessage());
        }
    }

    /**
     * Reject an event
     */
    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Update event approval status
            $event->update([
                'approval_status' => 'rejected',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Update verification status if exists
            if ($event->verification) {
                $event->verification->reject(
                    Auth::id(),
                    $request->rejection_reason,
                    $request->notes
                );
            }

            DB::commit();

            // Send rejection email to organizer
            try {
                Mail::to($event->user->email)->send(new EventRejected($event));
            } catch (\Exception $e) {
                \Log::error('Failed to send event rejection email', [
                    'event_id' => $event->id,
                    'error' => $e->getMessage(),
                ]);
            }

            return redirect()
                ->route('admin.events.approval.index')
                ->with('success', 'Event rejected successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject event: ' . $e->getMessage());
        }
    }

    /**
     * Get approval statistics
     */
    private function getApprovalStats(): array
    {
        return [
            'pending' => Event::where('approval_status', 'pending')->count(),
            'approved_today' => Event::where('approval_status', 'approved')
                ->whereDate('approved_at', today())->count(),
            'rejected_today' => Event::where('approval_status', 'rejected')
                ->whereDate('approved_at', today())->count(),
            'high_risk' => Event::where('approval_status', 'pending')
                ->whereHas('verification', function ($q) {
                    $q->where('risk_score', '>=', 60);
                })->count(),
        ];
    }

    /**
     * Bulk approve events
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'event_ids' => 'required|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $count = 0;
        foreach ($request->event_ids as $eventId) {
            $event = Event::find($eventId);
            if ($event && $event->approval_status === 'pending') {
                $event->update([
                    'approval_status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                $count++;
            }
        }

        return redirect()
            ->route('admin.events.approval.index')
            ->with('success', "Approved {$count} event(s) successfully!");
    }
}
