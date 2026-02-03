<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationSetting extends Model
{
    protected $fillable = [
        'user_id',
        'notification_type',
        'channel',
        'enabled'
    ];

    protected $casts = [
        'enabled' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getDefaultSettings(): array
    {
        return [
            'event_created' => ['channel' => 'app', 'enabled' => true],
            'event_updated' => ['channel' => 'app', 'enabled' => true],
            'booking_confirmed' => ['channel' => 'both', 'enabled' => true],
            'booking_cancelled' => ['channel' => 'both', 'enabled' => true],
            'payment_received' => ['channel' => 'both', 'enabled' => true],
            'announcement' => ['channel' => 'app', 'enabled' => true],
            'reminder' => ['channel' => 'app', 'enabled' => true]
        ];
    }

    public static function createDefaultsForUser($userId): void
    {
        $defaults = self::getDefaultSettings();
        
        foreach ($defaults as $type => $settings) {
            self::firstOrCreate(
                ['user_id' => $userId, 'notification_type' => $type],
                $settings
            );
        }
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
