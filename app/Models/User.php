<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Automatically make the first admin a super admin
        static::creating(function ($user) {
            if ($user->role === 'admin' && !isset($user->is_super_admin)) {
                $existingAdmins = self::where('role', 'admin')->count();
                if ($existingAdmins === 0) {
                    $user->is_super_admin = true;
                }
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_super_admin',
        'onboarding_completed',
        'interests',
        'favorite_event_types',
        'location',
        'occupation',
        'date_of_birth',
        'bio',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'interests' => 'array',
            'date_of_birth' => 'date',
            'onboarding_completed' => 'boolean',
            'is_super_admin' => 'boolean',
        ];
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roles): bool
    {
        if (is_null($roles)) {
            return false;
        }

        $roles = is_array($roles) ? $roles : explode('|', $roles);
        return in_array($this->role, $roles, true);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true && $this->role === 'admin';
    }

    /**
     * Check if user is admin or super admin.
     */
    public function isAdminOrSuperAdmin(): bool
    {
        return $this->isAdmin() || $this->isSuperAdmin();
    }

    /**
     * Determine if the user has two-factor authentication enabled.
     */
    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return ! is_null($this->two_factor_secret) && ! is_null($this->two_factor_confirmed_at);
    }

    /**
     * Get user's favorite events.
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get user's favorited events.
     */
    public function favoritedEvents()
    {
        return $this->belongsToMany(Event::class, 'favorites');
    }

    /**
     * Get user's app notifications.
     */
    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    /**
     * User's event bookings.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Events created by the user.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get user's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->hasMany(AppNotification::class)->unread();
    }

    /**
     * Get user's notification settings.
     */
    public function notificationSettings()
    {
        return $this->hasMany(NotificationSetting::class);
    }

    /**
     * Get unread notification count.
     */
    public function getUnreadNotificationCountAttribute(): int
    {
        return $this->unreadNotifications()->count();
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }
}