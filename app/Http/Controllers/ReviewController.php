<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display reviews for a specific event
     */
    public function index(Event $event)
    {
        $reviews = $event->approvedReviews()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $canReview = $event->canBeReviewedBy(Auth::user());
        $userReview = $event->reviews()
            ->where('user_id', Auth::id())
            ->first();

        return view('reviews.index', compact('event', 'reviews', 'canReview', 'userReview'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create(Event $event)
    {
        if (!$event->canBeReviewedBy(Auth::user())) {
            return redirect()->back()
                ->with('error', 'You cannot review this event. You must have attended the event to leave a review.');
        }

        return view('reviews.create', compact('event'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request, Event $event)
    {
        if (!$event->canBeReviewedBy(Auth::user())) {
            return redirect()->back()
                ->with('error', 'You cannot review this event. You must have attended the event to leave a review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        $review = new Review([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'reviewed_at' => now(),
        ]);

        $review->save();

        return redirect()->route('events.show', $event)
            ->with('success', 'Thank you for your review! It has been published.');
    }

    /**
     * Show the form for editing a review
     */
    public function edit(Review $review)
    {
        if (!$review->canBeEditedBy(Auth::user())) {
            return redirect()->back()
                ->with('error', 'You cannot edit this review or the edit time has expired.');
        }

        return view('reviews.edit', compact('review'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, Review $review)
    {
        if (!$review->canBeEditedBy(Auth::user())) {
            return redirect()->back()
                ->with('error', 'You cannot edit this review or the edit time has expired.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_anonymous' => $request->boolean('is_anonymous'),
        ]);

        return redirect()->route('events.show', $review->event)
            ->with('success', 'Your review has been updated successfully.');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Review $review)
    {
        if (!$review->canBeDeletedBy(Auth::user())) {
            return redirect()->back()
                ->with('error', 'You cannot delete this review.');
        }

        $event = $review->event;
        $review->delete();

        return redirect()->route('events.show', $event)
            ->with('success', 'Review has been deleted successfully.');
    }

    /**
     * AJAX endpoint to get rating summary for an event
     */
    public function ratingSummary(Event $event)
    {
        return response()->json([
            'average_rating' => round($event->average_rating, 1),
            'rating_count' => $event->rating_count,
            'rating_distribution' => $event->rating_distribution,
        ]);
    }
}
