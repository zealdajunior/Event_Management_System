<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of feedback (admin view).
     */
    public function index(Request $request)
    {
        $query = Feedback::with(['event', 'user', 'booking']);
        
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        
        if ($request->has('status')) {
            $isApproved = $request->status === 'approved';
            $query->where('is_approved', $isApproved);
        }
        
        $feedbacks = $query->latest()->paginate(20);
        $events = Event::all();
        
        return view('feedback.index', compact('feedbacks', 'events'));
    }

    /**
     * Store a newly created feedback.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $feedback = Feedback::create([
            'event_id' => $request->event_id,
            'user_id' => Auth::id(),
            'booking_id' => $request->booking_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    /**
     * Approve a feedback.
     */
    public function approve($id)
    {
        $feedback = Feedback::findOrFail($id);
        
        $feedback->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Feedback approved successfully!');
    }

    /**
     * Reject/delete a feedback.
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->back()->with('success', 'Feedback deleted successfully!');
    }

    /**
     * Get approved feedback for an event.
     */
    public function getEventFeedback($eventId)
    {
        $feedbacks = Feedback::with('user')
            ->where('event_id', $eventId)
            ->where('is_approved', true)
            ->latest()
            ->get();

        $averageRating = $feedbacks->avg('rating');
        $totalFeedback = $feedbacks->count();

        return response()->json([
            'feedbacks' => $feedbacks,
            'average_rating' => round($averageRating, 1),
            'total_feedback' => $totalFeedback,
        ]);
    }
}
