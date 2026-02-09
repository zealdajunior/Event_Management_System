<?php

namespace App\Http\Controllers;

use App\Models\EventVerification;
use App\Models\Payout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show identity verification form
     */
    public function showVerificationForm()
    {
        $user = Auth::user();
        
        return view('verification.identity', compact('user'));
    }

    /**
     * Submit identity verification
     */
    public function submitVerification(Request $request)
    {
        $request->validate([
            'id_number' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB max
        ]);

        $user = Auth::user();

        // Upload ID document
        $documentPath = $request->file('id_document')->store('verification_documents', 'public');

        $user->update([
            'verification_status' => 'pending',
            'id_number' => $request->id_number,
            'phone_number' => $request->phone_number,
            'id_document_path' => $documentPath,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Verification documents submitted successfully. You will be notified once reviewed.');
    }

    /**
     * Upload event verification documents
     */
    public function uploadEventDocument(Request $request, \App\Models\Event $event)
    {
        // Check if user is event organizer
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'document_type' => 'required|string|in:venue_contract,permit,insurance,business_license,other',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB max
            'description' => 'nullable|string|max:500',
        ]);

        // Upload document
        $documentPath = $request->file('document')->store('event_verifications', 'public');

        EventVerification::create([
            'event_id' => $event->id,
            'document_type' => $request->document_type,
            'document_path' => $documentPath,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Verification document uploaded successfully');
    }

    /**
     * Show organizer earnings and payout page
     */
    public function earnings()
    {
        $user = Auth::user();
        
        $events = $user->events()
            ->where('approval_status', 'approved')
            ->withCount('tickets')
            ->get();

        $totalEarnings = $user->balance + $user->payouts()->where('status', 'completed')->sum('amount');
        $pendingPayouts = $user->payouts()->where('status', 'pending')->sum('amount');

        $recentPayouts = $user->payouts()->orderBy('created_at', 'desc')->take(10)->get();

        return view('verification.earnings', compact(
            'user',
            'events',
            'totalEarnings',
            'pendingPayouts',
            'recentPayouts'
        ));
    }

    /**
     * Request payout
     */
    public function requestPayout(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10|max:' . Auth::user()->balance,
            'payment_method' => 'required|string|in:bank_transfer,paypal,stripe',
            'account_details' => 'required|array',
        ]);

        $user = Auth::user();

        // Check if user is verified
        if ($user->verification_status !== 'verified') {
            return back()->with('error', 'You must complete identity verification before requesting payouts');
        }

        Payout::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_details' => json_encode($request->account_details),
            'status' => 'pending',
        ]);

        // Deduct from balance
        $user->decrement('balance', $request->amount);

        return redirect()->route('verification.earnings')
            ->with('success', 'Payout request submitted successfully. You will be notified once processed.');
    }
}
