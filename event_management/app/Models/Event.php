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
        'description',
        'date',
        'end_date',
        'venue_id',
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
        'min_age',
        'max_age',
        'language',
        'accessibility_info',
        'contact_person',
        'website',
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
}
