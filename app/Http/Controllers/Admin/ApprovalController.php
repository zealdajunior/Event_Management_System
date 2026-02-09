<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Payout;
use App\Notifications\EventApprovedNotification;
use App\Notifications\EventRejectedNotification;
use App\Notifications\UserVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->is_admin) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    /**
     * Show admin approval dashboard
     */
    public function dashboard()
    {
        $pendingEvents = Event::where('approval_status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingVerifications = User::where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pendingPayouts = Payout::where('status', 'pending')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'pending_events' => Event::where('approval_status', 'pending')->count(),
            'pending_verifications' => User::where('verification_status', 'pending')->count(),
            'pending_payouts' => Payout::where('status', 'pending')->count(),
            'total_platform_revenue' => Event::sum('platform_revenue'),
        ];

        return view('admin.approval-dashboard', compact(
            'pendingEvents',
            'pendingVerifications',
            'pendingPayouts',
            'stats'
        ));
    }

    /**
     * Show event details for review
     */
    public function reviewEvent(Event $event)
    {
        $event->load(['user', 'tickets', 'verifications']);
        
        return view('admin.review-event', compact('event'));
    }

    /**
     * Approve an event
     */
    public function approveEvent(Request $request, Event $event)
    {
        $event->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        // Notify event organizer
        $event->user->notify(new EventApprovedNotification($event));

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'Event approved successfully');
    }

    /**
     * Reject an event
     */
    public function rejectEvent(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $event->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by' => Auth::id(),
        ]);

        // Notify event organizer
        $event->user->notify(new EventRejectedNotification($event));

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'Event rejected');
    }

    /**
     * Show user verification details
     */
    public function reviewUser(User $user)
    {
        return view('admin.review-user', compact('user'));
    }

    /**
     * Approve user verification
     */
    public function approveUser(User $user)
    {
        $user->update([
            'verification_status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // Notify user
        $user->notify(new UserVerifiedNotification());

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'User verified successfully');
    }

    /**
     * Reject user verification
     */
    public function rejectUser(Request $request, User $user)
    {
        $request->validate([
            'verification_notes' => 'required|string|max:1000',
        ]);

        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->verification_notes,
            'verified_by' => Auth::id(),
        ]);

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'User verification rejected');
    }

    /**
     * Show payout details
     */
    public function reviewPayout(Payout $payout)
    {
        $payout->load('user');
        
        return view('admin.review-payout', compact('payout'));
    }

    /**
     * Approve and process payout
     */
    public function approvePayout(Request $request, Payout $payout)
    {
        $request->validate([
            'transaction_reference' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $payout->update([
            'status' => 'completed',
            'transaction_reference' => $request->transaction_reference,
            'notes' => $request->notes,
            'processed_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'Payout processed successfully');
    }

    /**
     * Reject payout and refund balance
     */
    public function rejectPayout(Request $request, Payout $payout)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        // Refund the amount to user's balance
        $payout->user->increment('balance', $payout->amount);

        $payout->update([
            'status' => 'failed',
            'notes' => $request->notes,
            'processed_at' => now(),
            'processed_by' => Auth::id(),
        ]);

        return redirect()->route('admin.approval.dashboard')
            ->with('success', 'Payout rejected and balance refunded');
    }

    /**
     * Platform revenue report
     */
    public function revenueReport()
    {
        $totalRevenue = Event::sum('platform_revenue');
        $monthlyRevenue = Event::whereMonth('created_at', now()->month)
            ->sum('platform_revenue');

        $topEvents = Event::where('approval_status', 'approved')
            ->orderBy('platform_revenue', 'desc')
            ->take(10)
            ->get();

        $recentPayouts = Payout::where('status', 'completed')
            ->with('user')
            ->orderBy('processed_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.revenue-report', compact(
            'totalRevenue',
            'monthlyRevenue',
            'topEvents',
            'recentPayouts'
        ));
    }
}
