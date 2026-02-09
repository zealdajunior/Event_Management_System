<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'booking_id',
        'user_id',
        'event_id',
        'amount',
        'payment_method',
        'payment_date',
        'transaction_id',
        'status',
        'metadata',
        'refunded_at',
        'stripe_session_id',
        'stripe_payment_intent_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'refunded_at' => 'datetime',
        'metadata' => 'json',
        'amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function revenues()
    {
        return $this->hasMany(EventRevenue::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
