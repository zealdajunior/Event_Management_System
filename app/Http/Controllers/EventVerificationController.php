<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventVerificationController extends Controllerhttp://localhost:8000
{
    /**
     * Show verification form for an event
     */
    public function show(Event $event)
    {
        // Ensure user owns the event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $verification = $event->verification ?? new EventVerification();

        return view('events.verification', compact('event', 'verification'));
    }

    /**
     * Submit verification documents
     */
    public function store(Request $request, Event $event)
    {
        // Ensure user owns the event
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            // Identity documents
            'id_document_type' => 'required|in:passport,drivers_license,national_id',
            'id_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'id_number' => 'required|string|max:50',
            'id_expiry_date' => 'nullable|date|after:today',
            
            // Business documents (optional)
            'business_name' => 'nullable|string|max:255',
            'business_registration_number' => 'nullable|string|max:100',
            'business_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'tax_id' => 'nullable|string|max:50',
            
            // Address verification
            'address' => 'required|string|max:500',
            'address_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            
            // Phone verification
            'phone_number' => 'required|string|max:20',
            
            // Venue verification
            'venue_verified' => 'boolean',
            'venue_verification_notes' => 'nullable|string|max:1000',
            
            // Permits
            'has_permits' => 'boolean',
            'permit_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        try {
            // Upload identity document
            $idDocPath = null;
            if ($request->hasFile('id_document')) {
                $idDocPath = $request->file('id_document')->store(
                    'verifications/identity/' . $event->id,
                    'private'
                );
            }

            // Upload business document
            $businessDocPath = null;
            if ($request->hasFile('business_document')) {
                $businessDocPath = $request->file('business_document')->store(
                    'verifications/business/' . $event->id,
                    'private'
                );
            }

            // Upload address proof
            $addressProofPath = null;
            if ($request->hasFile('address_proof')) {
                $addressProofPath = $request->file('address_proof')->store(
                    'verifications/address/' . $event->id,
                    'private'
                );
            }

            // Upload permit document
            $permitDocPath = null;
            if ($request->hasFile('permit_document')) {
                $permitDocPath = $request->file('permit_document')->store(
                    'verifications/permits/' . $event->id,
                    'private'
                );
            }

            // Create or update verification
            $verification = EventVerification::updateOrCreate(
                [
                    'event_id' => $event->id,
                    'user_id' => Auth::id(),
                ],
                [
                    'id_document_type' => $validated['id_document_type'],
                    'id_document_path' => $idDocPath,
                    'id_number' => $validated['id_number'],
                    'id_expiry_date' => $validated['id_expiry_date'] ?? null,
                    'business_name' => $validated['business_name'] ?? null,
                    'business_registration_number' => $validated['business_registration_number'] ?? null,
                    'business_document_path' => $businessDocPath,
                    'tax_id' => $validated['tax_id'] ?? null,
                    'address' => $validated['address'],
                    'address_proof_path' => $addressProofPath,
                    'phone_number' => $validated['phone_number'],
                    'email_verified' => Auth::user()->hasVerifiedEmail(),
                    'venue_verified' => $validated['venue_verified'] ?? false,
                    'venue_verification_notes' => $validated['venue_verification_notes'] ?? null,
                    'has_permits' => $validated['has_permits'] ?? false,
                    'permit_document_path' => $permitDocPath,
                    'status' => 'pending',
                    'submitted_at' => now(),
                ]
            );

            // Calculate risk score
            $verification->calculateRiskScore();

            // Update event to require approval
            $event->update([
                'approval_status' => 'pending',
                'requires_approval' => true,
            ]);

            return redirect()
                ->route('events.show', $event)
                ->with('success', 'Verification documents submitted successfully! Your event is now pending admin approval.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to submit verification: ' . $e->getMessage());
        }
    }

    /**
     * Download verification document (admin only)
     */
    public function downloadDocument(EventVerification $verification, string $type)
    {
        // Check if user is admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $path = match($type) {
            'identity' => $verification->id_document_path,
            'business' => $verification->business_document_path,
            'address' => $verification->address_proof_path,
            'permit' => $verification->permit_document_path,
            default => null,
        };

        if (!$path || !Storage::disk('private')->exists($path)) {
            abort(404, 'Document not found');
        }

        return Storage::disk('private')->download($path);
    }
}
