<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'name',
        'venue_id',
        'description',
        'date',
        'location',
        'status',
        'user_id',
        'capacity',
        'price',
        'category',
        'tags',
        'image',
        'end_date',
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

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}