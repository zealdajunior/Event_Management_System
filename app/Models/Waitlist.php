<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Waitlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'ticket_id',
        'quantity',
        'position',
        'status',
        'notified_at',
        'expires_at',
        'notification_preferences',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'expires_at' => 'datetime',
        'notification_preferences' => 'json',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    // Scopes
    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeNotified($query)
    {
        return $query->where('status', 'notified');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere(function($q) {
                        $q->where('status', 'notified')
                          ->where('expires_at', '<', now());
                    });
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForTicket($query, $ticketId)
    {
        return $query->where('ticket_id', $ticketId);
    }

    // Helper Methods
    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->status === 'notified' && $this->expires_at && $this->expires_at->isPast());
    }

    public function isWaiting(): bool
    {
        return $this->status === 'waiting';
    }

    public function isNotified(): bool
    {
        return $this->status === 'notified' && !$this->isExpired();
    }

    public function markAsNotified($expirationHours = 24): void
    {
        $this->update([
            'status' => 'notified',
            'notified_at' => now(),
            'expires_at' => now()->addHours($expirationHours),
        ]);
    }

    public function markAsConverted(): void
    {
        $this->update([
            'status' => 'converted',
        ]);
    }

    public function markAsExpired(): void
    {
        $this->update([
            'status' => 'expired',
        ]);
    }

    public function getTimeRemainingAttribute(): ?string
    {
        if (!$this->expires_at || $this->status !== 'notified') {
            return null;
        }

        $diff = $this->expires_at->diffInMinutes(now());
        
        if ($diff < 0) return 'Expired';
        if ($diff < 60) return $diff . ' minutes';
        if ($diff < 1440) return round($diff / 60) . ' hours';
        
        return round($diff / 1440) . ' days';
    }

    // Static Methods
    public static function addToWaitlist(int $userId, int $eventId, ?int $ticketId = null, int $quantity = 1): self
    {
        // Get next position in waitlist for this event/ticket combination
        $nextPosition = self::where('event_id', $eventId)
                           ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                           ->where('status', 'waiting')
                           ->max('position') + 1;

        return self::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'ticket_id' => $ticketId,
            'quantity' => $quantity,
            'position' => $nextPosition,
            'status' => 'waiting',
        ]);
    }

    public static function getNextInLine(int $eventId, ?int $ticketId = null): ?self
    {
        return self::where('event_id', $eventId)
                  ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                  ->where('status', 'waiting')
                  ->orderBy('position')
                  ->first();
    }

    public static function promoteNext(int $eventId, ?int $ticketId = null, int $availableQuantity = 1): array
    {
        $promoted = [];
        $remaining = $availableQuantity;

        while ($remaining > 0) {
            $next = self::getNextInLine($eventId, $ticketId);
            
            if (!$next) break;

            if ($next->quantity <= $remaining) {
                $next->markAsNotified();
                $promoted[] = $next;
                $remaining -= $next->quantity;
            } else {
                break; // Not enough tickets for this person's full request
            }
        }

        return $promoted;
    }
}
