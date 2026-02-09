<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizerPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
        'notes',
        'transaction_reference',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Mark payout as processing
     */
    public function markAsProcessing(): bool
    {
        $this->status = 'processing';
        return $this->save();
    }

    /**
     * Mark payout as completed
     */
    public function markAsCompleted(string $transactionReference = null): bool
    {
        $this->status = 'completed';
        $this->processed_at = now();
        if ($transactionReference) {
            $this->transaction_reference = $transactionReference;
        }
        return $this->save();
    }

    /**
     * Mark payout as failed
     */
    public function markAsFailed(string $reason = null): bool
    {
        $this->status = 'failed';
        if ($reason) {
            $this->notes = $reason;
        }
        return $this->save();
    }
}
