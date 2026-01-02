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
        'event_title',
        'event_description',
        'start_date',
        'end_date',
        'venue',
        'status',
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
}
