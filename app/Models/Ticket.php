<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = [
        'event_id',
        'type',
        'price',
        'quantity',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function waitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class);
    }

    // Helper methods
    public function getAvailableQuantity(): int
    {
        $bookedQuantity = $this->bookings()
                             ->whereHas('payment', function($query) {
                                 $query->whereIn('status', ['completed', 'pending']);
                             })
                             ->sum('quantity');

        return max(0, $this->quantity - $bookedQuantity);
    }

    public function isSoldOut(): bool
    {
        return $this->getAvailableQuantity() === 0;
    }

    public function getWaitlistCount(): int
    {
        return $this->waitlists()->where('status', 'waiting')->count();
    }
}