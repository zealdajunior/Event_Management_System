<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'booking_date',
        'status',
        'notes',
        'quantity',
        'booking_reference',
        'payment_id',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = self::generateBookingReference();
            }
        });
    }

    public static function generateBookingReference()
    {
        do {
            $reference = 'BKG' . strtoupper(\Illuminate\Support\Str::random(10));
        } while (self::where('booking_reference', $reference)->exists());
        
        return $reference;
    }

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function attendance()
    {
        return $this->hasOne(\App\Models\Attendance::class);
    }
}