<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMedia;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('events.create', compact('venues', 'categories'));
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
            'category_id' => 'nullable|exists:categories,id',
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
        // Check if the current admin is the creator of the event
        if ($event->user_id !== auth()->id()) {
            return redirect()->route('events.index')
                ->with('error', 'You can only edit events that you created. Events from event requests can only be edited by their creators.');
        }

        $venues = Venue::all();
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('events.edit', compact('event', 'venues', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        // Check if the current admin is the creator of the event
        if ($event->user_id !== auth()->id()) {
            return redirect()->route('events.index')
                ->with('error', 'You can only update events that you created. Events from event requests can only be updated by their creators.');
        }

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
        // Check if user is super admin or event owner
        $user = auth()->user();
        if (!$user->isSuperAdmin() && $event->user_id !== $user->id) {
            return redirect()->route('events.index')->with('error', 'You do not have permission to delete this event.');
        }

        // Get event details for logging and notifications
        $eventName = $event->name;
        $eventDate = $event->date;
        $bookingsCount = $event->bookings()->count();
        
        try {
            // Cancel all bookings and notify users
            if ($bookingsCount > 0) {
                $bookings = $event->bookings()->with('user')->get();
                
                // Cancel bookings (this could trigger email notifications)
                foreach ($bookings as $booking) {
                    // You could send cancellation notifications here
                    // Mail::to($booking->user)->send(new EventCancelledNotification($booking));
                    $booking->delete();
                }
            }

            // Delete event media files
            if ($event->images()->exists()) {
                foreach ($event->images as $image) {
                    // Delete file from storage
                    if (Storage::disk('public')->exists($image->file_path)) {
                        Storage::disk('public')->delete($image->file_path);
                    }
                    $image->delete();
                }
            }

            // Remove from favorites (use the correct relationship method)
            $event->favoritedByUsers()->detach();
            
            // Delete any standalone favorites records
            $event->favorites()->delete();
            
            // Delete event tickets
            $event->tickets()->delete();
            
            // Log audit action before deletion
            AuditLogger::log('deleted', 'Event', $event->id, [
                'name' => $eventName,
                'date' => $eventDate,
                'bookings_cancelled' => $bookingsCount,
                'deleted_by' => $user->name . ' (ID: ' . $user->id . ')',
                'user_role' => $user->role,
                'is_super_admin' => $user->isSuperAdmin()
            ]);
            
            // Delete the event
            $event->delete();
            
            // Enhanced success message
            $message = "Event '{$eventName}' has been successfully deleted.";
            if ($bookingsCount > 0) {
                $message .= " {$bookingsCount} booking(s) were cancelled and users have been notified.";
            }
            
            return redirect()->route('events.index')->with('status', $message);
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Event deletion failed', [
                'event_id' => $event->id,
                'event_name' => $eventName,
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
            
            return redirect()->route('events.index')->with('error', 'Failed to delete event. Please try again or contact support.');
        }
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
