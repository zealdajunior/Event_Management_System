<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'payment_method',
        'payment_details',
        'transaction_reference',
        'notes',
        'processed_at',
        'processed_by',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user who requested the payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who processed the payout.
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
