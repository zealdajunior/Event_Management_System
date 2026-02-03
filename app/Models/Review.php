<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'rating',
        'comment',
        'is_anonymous',
        'is_approved',
        'reviewed_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_approved' => 'boolean',
        'reviewed_at' => 'datetime',
        'rating' => 'integer',
    ];

    /**
     * Get the user who wrote this review
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event being reviewed
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope for approved reviews only
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope for recent reviews
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for reviews with specific rating
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Get review author name (handle anonymous reviews)
     */
    public function getAuthorNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous User';
        }
        
        return $this->user ? $this->user->name : 'Unknown User';
    }

    /**
     * Get star display for rating
     */
    public function getStarsAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }

    /**
     * Check if review can be edited
     */
    public function canBeEditedBy($user)
    {
        return $this->user_id === $user->id && 
               $this->created_at->diffInHours(now()) < 24; // Allow editing within 24 hours
    }

    /**
     * Check if review can be deleted by user
     */
    public function canBeDeletedBy($user)
    {
        return $this->user_id === $user->id || 
               $user->hasRole('admin') || 
               ($user->is_super_admin ?? false);
    }
}
