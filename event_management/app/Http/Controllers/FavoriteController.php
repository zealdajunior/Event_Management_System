<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for an event.
     */
    public function toggle(Event $event)
    {
        $user = Auth::user();

        // Check if the event is already favorited by the user
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('event_id', $event->id)
                           ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $message = 'Event removed from favorites.';
            $isFavorited = false;
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
            ]);
            $message = 'Event added to favorites.';
            $isFavorited = true;
        }

        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_favorited' => $isFavorited,
            ]);
        }

        // Redirect back with message for regular requests
        return back()->with('success', $message);
    }
}
