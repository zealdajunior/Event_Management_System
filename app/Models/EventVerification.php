<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'id_document_type',
        'id_document_path',
        'id_number',
        'id_expiry_date',
        'business_name',
        'business_registration_number',
        'business_document_path',
        'tax_id',
        'address',
        'address_proof_path',
        'phone_number',
        'phone_verified',
        'phone_verified_at',
        'email_verified',
        'venue_verified',
        'venue_verification_notes',
        'has_permits',
        'permit_document_path',
        'risk_score',
        'risk_factors',
        'status',
        'reviewed_by',
        'reviewer_notes',
        'rejection_reason',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
        'email_verified' => 'boolean',
        'venue_verified' => 'boolean',
        'has_permits' => 'boolean',
        'id_expiry_date' => 'date',
        'phone_verified_at' => 'datetime',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Calculate risk score based on various factors
     */
    public function calculateRiskScore(): int
    {
        $score = 0;
        $factors = [];

        // Identity verification checks
        if (!$this->id_document_path) {
            $score += 30;
            $factors[] = 'No identity document provided';
        }

        if (!$this->phone_verified) {
            $score += 15;
            $factors[] = 'Phone not verified';
        }

        if (!$this->email_verified) {
            $score += 15;
            $factors[] = 'Email not verified';
        }

        // Business verification
        if ($this->event && $this->event->ticket_price > 1000 && !$this->business_registration_number) {
            $score += 20;
            $factors[] = 'High-value event without business registration';
        }

        // Venue verification
        if (!$this->venue_verified) {
            $score += 10;
            $factors[] = 'Venue not verified';
        }

        // Permits
        if (!$this->has_permits && $this->event && $this->event->expected_attendees > 100) {
            $score += 10;
            $factors[] = 'Large event without required permits';
        }

        $this->risk_score = min($score, 100);
        $this->risk_factors = json_encode($factors);
        $this->save();

        return $this->risk_score;
    }

    /**
     * Submit verification for review
     */
    public function submit(): bool
    {
        $this->status = 'under_review';
        $this->submitted_at = now();
        return $this->save();
    }

    /**
     * Approve verification
     */
    public function approve(int $reviewerId, string $notes = null): bool
    {
        $this->status = 'verified';
        $this->reviewed_by = $reviewerId;
        $this->reviewer_notes = $notes;
        $this->reviewed_at = now();
        return $this->save();
    }

    /**
     * Reject verification
     */
    public function reject(int $reviewerId, string $reason, string $notes = null): bool
    {
        $this->status = 'rejected';
        $this->reviewed_by = $reviewerId;
        $this->rejection_reason = $reason;
        $this->reviewer_notes = $notes;
        $this->reviewed_at = now();
        return $this->save();
    }
}
