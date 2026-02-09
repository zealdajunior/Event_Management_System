<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'summary',
        'description',
        'date',
        'end_date',
        'venue_id',
        'venue_name',
        'room_details',
        'location',
        'city',
        'country',
        'country_code',
        'latitude',
        'longitude',
        'user_id',
        'status',
        'capacity',
        'price',
        'category',
        'tags',
        'image',
        'agenda',
        'organizer_name',
        'organizer_email',
        'organizer_phone',
        'requirements',
        'is_featured',
        'allow_registrations',
        'registration_deadline',
        'additional_info',
        'event_type',
        'event_format',
        'online_event_link',
        'min_age',
        'max_age',
        'language',
        'accessibility_info',
        'contact_person',
        'website',
        'category_id',
        'terms',
        'cancellation_policy',
    ];

    protected $casts = [
        'date' => 'datetime',
        'end_date' => 'datetime',
        'tags' => 'array',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'allow_registrations' => 'boolean',
        'registration_deadline' => 'datetime',
        'min_age' => 'integer',
        'max_age' => 'integer',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function waitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class);
    }

    public function activeWaitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class)->whereIn('status', ['waiting', 'notified']);
    }

    public function waitingUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'waitlists')
                   ->wherePivot('status', 'waiting')
                   ->orderByPivot('position');
    }

    public function media(): HasMany
    {
        return $this->hasMany(EventMedia::class)->orderBy('order');
    }

    public function images(): HasMany
    {
        return $this->hasMany(EventMedia::class)->where('file_type', 'image')->orderBy('order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(EventMedia::class)->where('file_type', 'video')->orderBy('order');
    }

    public function featuredImage()
    {
        return $this->hasOne(EventMedia::class)->where('is_featured', true)->where('file_type', 'image');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(EventRevenue::class);
    }

    public function verification()
    {
        return $this->hasOne(EventVerification::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now());
    }

    public function scopeOrderByDistance($query, $tableName, $latitude, $longitude)
    {
        return $query->select('events.*')
            ->selectRaw("
                (6371 * acos(cos(radians(?)) 
                * cos(radians({$tableName}.latitude)) 
                * cos(radians({$tableName}.longitude) - radians(?)) 
                + sin(radians(?)) 
                * sin(radians({$tableName}.latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
            ->join($tableName, 'events.venue_id', '=', $tableName . '.id')
            ->orderBy('distance');
    }

    // Accessors
    public function getIsUpcomingAttribute()
    {
        return $this->date >= now();
    }

    public function getIsPastAttribute()
    {
        return $this->date < now();
    }

    public function getFormattedDateAttribute()
    {
        return $this->date->format('M j, Y g:i A');
    }

    public function getFormattedPriceAttribute()
    {
        return $this->price ? '$' . number_format($this->price, 2) : 'Free';
    }

    // Review-related methods
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?: 0;
    }

    public function getRatingCountAttribute()
    {
        return $this->approvedReviews()->count();
    }

    public function getRatingDistributionAttribute()
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->approvedReviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    public function getStarsDisplayAttribute()
    {
        $rating = round($this->average_rating, 1);
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = 5 - $fullStars - $halfStar;
        
        $stars = str_repeat('★', $fullStars);
        if ($halfStar) {
            $stars .= '☆';
        }
        $stars .= str_repeat('☆', $emptyStars);
        
        return $stars;
    }

    public function hasReviewFromUser($userId)
    {
        return $this->reviews()->where('user_id', $userId)->exists();
    }

    public function canBeReviewedBy($user)
    {
        // User must have attended the event (have a completed booking)
        $hasAttended = $this->bookings()
            ->where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->exists();
        
        // Event must be past
        $isPast = $this->date < now();
        
        // User hasn't already reviewed
        $hasntReviewed = !$this->hasReviewFromUser($user->id);
        
        return $hasAttended && $isPast && $hasntReviewed;
    }

    // Waitlist-related methods
    public function isSoldOut(): bool
    {
        foreach ($this->tickets as $ticket) {
            $bookedQuantity = $ticket->bookings()
                                   ->whereHas('payment', function($query) {
                                       $query->whereIn('status', ['completed', 'pending']);
                                   })
                                   ->sum('quantity');
            
            if ($ticket->quantity > $bookedQuantity) {
                return false; // At least one ticket type is available
            }
        }
        
        return true; // All tickets are sold out
    }

    public function getWaitlistCount(?int $ticketId = null): int
    {
        return $this->waitlists()
                   ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                   ->where('status', 'waiting')
                   ->count();
    }

    public function getTotalWaitlistCount(): int
    {
        return $this->waitlists()->where('status', 'waiting')->count();
    }

    public function userIsOnWaitlist(int $userId, ?int $ticketId = null): bool
    {
        return $this->waitlists()
                   ->where('user_id', $userId)
                   ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                   ->whereIn('status', ['waiting', 'notified'])
                   ->exists();
    }

    public function getUserWaitlistPosition(int $userId, ?int $ticketId = null): ?int
    {
        $waitlistEntry = $this->waitlists()
                            ->where('user_id', $userId)
                            ->when($ticketId, fn($q) => $q->where('ticket_id', $ticketId))
                            ->where('status', 'waiting')
                            ->first();

        return $waitlistEntry?->position;
    }

    public function getAvailableTicketQuantity(?int $ticketId = null): int
    {
        if ($ticketId) {
            $ticket = $this->tickets()->find($ticketId);
            if (!$ticket) return 0;

            $bookedQuantity = $ticket->bookings()
                                   ->whereHas('payment', function($query) {
                                       $query->whereIn('status', ['completed', 'pending']);
                                   })
                                   ->sum('quantity');

            return max(0, $ticket->quantity - $bookedQuantity);
        }

        // Return total available across all tickets
        $totalAvailable = 0;
        foreach ($this->tickets as $ticket) {
            $bookedQuantity = $ticket->bookings()
                                   ->whereHas('payment', function($query) {
                                       $query->whereIn('status', ['completed', 'pending']);
                                   })
                                   ->sum('quantity');
            
            $totalAvailable += max(0, $ticket->quantity - $bookedQuantity);
        }

        return $totalAvailable;
    }

    public function canJoinWaitlist(int $userId, ?int $ticketId = null): array
    {
        // Check if event is past
        if ($this->date->isPast()) {
            return [
                'can_join' => false,
                'reason' => 'Cannot join waitlist for past events.',
            ];
        }

        // Check if user already has a booking
        $hasBooking = $this->bookings()
                          ->where('user_id', $userId)
                          ->whereHas('payment', function($query) {
                              $query->whereIn('status', ['completed', 'pending']);
                          })
                          ->exists();

        if ($hasBooking) {
            return [
                'can_join' => false,
                'reason' => 'You already have a booking for this event.',
            ];
        }

        // Check if user is already on waitlist
        if ($this->userIsOnWaitlist($userId, $ticketId)) {
            return [
                'can_join' => false,
                'reason' => 'You are already on the waitlist for this event.',
            ];
        }

        // Check if tickets are still available
        if (!$this->isSoldOut()) {
            if ($ticketId) {
                $availableQuantity = $this->getAvailableTicketQuantity($ticketId);
                if ($availableQuantity > 0) {
                    return [
                        'can_join' => false,
                        'reason' => 'Tickets are still available. Please book directly.',
                    ];
                }
            } else {
                return [
                    'can_join' => false,
                    'reason' => 'Tickets are still available. Please book directly.',
                ];
            }
        }

        return [
            'can_join' => true,
            'reason' => null,
        ];
    }
}
