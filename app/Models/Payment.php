<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'payment_date',
        'transaction_id',
        'status',
        'metadata',
        'refunded_at',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'refunded_at' => 'datetime',
        'metadata' => 'json',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
