<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Event $event)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
                           ->where('event_id', $event->id)
                           ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Event removed from favorites.');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
            ]);
            return back()->with('success', 'Event added to favorites.');
        }
    }
}
