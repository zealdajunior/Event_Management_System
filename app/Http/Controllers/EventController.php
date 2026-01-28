<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMedia;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\AuditLogger;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with(['venue', 'user', 'media', 'images', 'videos', 'featuredImage'])->latest()->get();
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('events.create', compact('venues'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'end_date' => 'nullable|date|after:date',
            'location' => 'required|string|max:255',
            'venue_id' => 'nullable|exists:venues,id',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:255',
            'event_type' => 'nullable|string|max:255',
            'organizer_name' => 'nullable|string|max:255',
            'organizer_email' => 'nullable|email|max:255',
            'organizer_phone' => 'nullable|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max per image
            'image_captions.*' => 'nullable|string|max:500', // Caption for each image
            'videos.*' => 'nullable|mimes:mp4,mov,avi,wmv,flv|max:102400', // 100MB max per video
        ]);

        $data['user_id'] = auth()->id();
        $data['status'] = 'active';

        $event = Event::create($data);

        // Handle image uploads with captions
        if ($request->hasFile('images')) {
            $captions = $request->input('image_captions', []);
            foreach ($request->file('images') as $index => $image) {
                $caption = $captions[$index] ?? null;
                $this->storeMedia($event, $image, 'image', $index, $caption);
            }
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $index => $video) {
                $this->storeMedia($event, $video, 'video', $index + count($request->file('images') ?? []));
            }
        }

        // Log audit action
        AuditLogger::log('created', 'Event', $event->id, [
            'name' => $event->name,
            'date' => $event->date,
            'venue' => $event->venue->name ?? $event->location
        ]);

        return redirect()->route('events.index')->with('status', 'Event created successfully with media files.');
    }

    public function show(Event $event)
    {
        $event->load(['venue', 'user', 'media', 'images', 'videos', 'featuredImage']);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $venues = Venue::all();
        return view('events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'venue_id' => 'nullable|exists:venues,id',
            'status' => 'required|in:active,inactive',
        ]);

        $event->update($data);
        
        // Log audit action
        AuditLogger::log('updated', 'Event', $event->id, [
            'name' => $event->name,
            'status' => $data['status']
        ]);
        
        return redirect()->route('events.index')->with('status', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        // Log audit action before deletion
        AuditLogger::log('deleted', 'Event', $event->id, [
            'name' => $event->name,
            'date' => $event->date
        ]);
        
        $event->delete();
        return redirect()->route('events.index')->with('status', 'Event deleted successfully.');
    }

    /**
     * Store media file for an event.
     */
    private function storeMedia($event, $file, $type, $order, $caption = null)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('events/' . $event->id . '/' . $type . 's', $fileName, 'public');

        EventMedia::create([
            'event_id' => $event->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $type,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'order' => $order,
            'caption' => $caption,
            'is_featured' => $order === 0, // First image is featured
        ]);
    }
}
