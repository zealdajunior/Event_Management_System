<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::all();
        return view('venues.index', compact('venues'));
    }

    public function store(Request $request)
    {
        Venue::create($request->all());
        return redirect()->route('venues.index');
    }

    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    public function destroy(Venue $venue)
    {
        $venue->delete();
        return redirect()->route('venues.index');
    }
}