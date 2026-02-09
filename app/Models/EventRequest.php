<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequest extends Model
{
    protected $table = 'event_requests';

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'user_id',
        // Basic Information
        'name',
        'category_id',
        'summary',
        'description',
        
        // Date and Time
        'date',
        'end_date',
        
        // Location Details
        'event_format',
        'location',
        'latitude',
        'longitude',
        'country_code',
        'venue_name',
        'room_details',
        'online_event_link',
        
        // Capacity and Pricing
        'capacity',
        'price',
        'event_type',
        
        // Organizer Information
        'organizer_name',
        'organizer_email',
        'organizer_phone',
        
        // Status
        'status',
        'rejection_reason',
        
        // Legacy fields (for backward compatibility)
        'event_title',
        'event_description',
        'start_date',
        'venue',
        'expected_attendance',
        'event_category',
        'target_audience',
        'budget_estimate',
        'ticket_pricing',
        'special_requirements',
        'marketing_plan',
        'contact_phone',
        'contact_email',
        'additional_notes',
    ];

    /**
     * Get the user that made the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the event.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all media for this event request.
     */
    public function media()
    {
        return $this->hasMany(EventMedia::class)->orderBy('order');
    }

    /**
     * Get only images for this event request.
     */
    public function images()
    {
        return $this->hasMany(EventMedia::class)->where('file_type', 'image')->orderBy('order');
    }

    /**
     * Get only videos for this event request.
     */
    public function videos()
    {
        return $this->hasMany(EventMedia::class)->where('file_type', 'video')->orderBy('order');
    }

    /**
     * Get the featured image for this event request.
     */
    public function featuredImage()
    {
        return $this->hasOne(EventMedia::class)->where('is_featured', true)->where('file_type', 'image');
    }
}
