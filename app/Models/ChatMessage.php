<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'role',
        'message',
        'context',
        'suggested_events',
        'intent',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'context' => 'array',
        'suggested_events' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events()
    {
        if (!$this->suggested_events) {
            return collect();
        }
        return Event::whereIn('id', $this->suggested_events)->get();
    }
}
