<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRevenue extends Model
{
    use HasFactory;

    protected $table = 'event_revenue';

    protected $fillable = [
        'event_id',
        'payment_id',
        'total_amount',
        'platform_fee',
        'organizer_earnings',
        'platform_fee_percentage',
        'status',
        'available_at',
        'paid_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'organizer_earnings' => 'decimal:2',
        'platform_fee_percentage' => 'decimal:2',
        'available_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Calculate revenue split based on total amount and platform fee percentage
     */
    public static function calculateSplit(float $totalAmount, float $platformFeePercentage = null): array
    {
        $feePercentage = $platformFeePercentage ?? config('payments.platform_fee_percentage', 10.00);
        $platformFee = round($totalAmount * ($feePercentage / 100), 2);
        $organizerEarnings = round($totalAmount - $platformFee, 2);

        return [
            'total_amount' => $totalAmount,
            'platform_fee' => $platformFee,
            'organizer_earnings' => $organizerEarnings,
            'platform_fee_percentage' => $feePercentage,
        ];
    }

    /**
     * Mark revenue as available for payout
     */
    public function markAsAvailable(): bool
    {
        $this->status = 'available';
        $this->available_at = now();
        return $this->save();
    }

    /**
     * Mark revenue as paid
     */
    public function markAsPaid(): bool
    {
        $this->status = 'paid';
        $this->paid_at = now();
        return $this->save();
    }

    /**
     * Check if revenue is available for payout
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && 
               $this->available_at && 
               $this->available_at->isPast();
    }
}
