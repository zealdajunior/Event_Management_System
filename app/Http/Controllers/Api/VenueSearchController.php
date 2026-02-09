<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueSearchController extends Controller
{
    /**
     * Search for venues by name or location
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        $venues = Venue::where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('address', 'like', "%{$query}%")
                  ->orWhere('city', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'address', 'city', 'country', 'country_code', 'latitude', 'longitude', 'capacity')
            ->limit(10)
            ->get();
        
        return response()->json($venues);
    }
}
