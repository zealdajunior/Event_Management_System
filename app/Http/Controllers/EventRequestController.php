<?php

namespace App\Http\Controllers;

use App\Models\EventRequest;
use App\Models\EventMedia;
use App\Models\Event;
use App\Models\Venue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\EventRequestStatusNotification;
use App\Notifications\NewEventRequestNotification;
use App\Services\AuditLogger;

class EventRequestController extends Controller
{
    /**
     * Show all requests for the logged-in user.
     */
    public function index()
    {
        $userId = Auth::check() ? Auth::id() : null;
        $requests = EventRequest::where('user_id', $userId)
            ->latest()
            ->get();

        return view('event_requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new event request.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('event_requests.create', compact('categories'));
    }

    /**
     * Store a new event request from a user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            // Basic Information
            'name'                 => 'required|string|max:255',
            'category_id'          => 'required|exists:categories,id',
            'summary'              => 'required|string|max:200',
            'description'          => 'required|string',
            
            // Date and Time
            'date'                 => 'required|date',
            'end_date'             => 'required|date|after_or_equal:date',
            
            // Location Details
            'event_format'         => 'required|in:physical,online,hybrid',
            'location'             => 'nullable|string|max:500',
            'latitude'             => 'nullable|numeric',
            'longitude'            => 'nullable|numeric',
            'country_code'         => 'nullable|string|max:2',
            'venue_name'           => 'nullable|string|max:255',
            'room_details'         => 'nullable|string|max:255',
            'online_event_link'    => 'nullable|url|max:500',
            
            // Capacity and Pricing
            'capacity'             => 'required|integer|min:1',
            'price'                => 'required|numeric|min:0',
            'event_type'           => 'required|in:public,private,vip,corporate',
            
            // Organizer Information
            'organizer_name'       => 'nullable|string|max:255',
            'organizer_email'      => 'required|email|max:255',
            'organizer_phone'      => 'nullable|string|max:255',
            
            // Publish Settings
            'status'               => 'nullable|in:draft,published',
            'terms'                => 'accepted',
            'cancellation_policy'  => 'accepted',
            
            // Media Files
            'images.*'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff,tif,heic,heif|max:10240',
            'image_captions.*'     => 'nullable|string|max:200',
            'videos.*'             => 'nullable|mimes:mp4,mov,avi,wmv,flv,webm,mkv,mpeg,mpg|max:102400',
        ]);

        // Set user_id and override status to pending (user submissions always need approval)
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $eventRequest = EventRequest::create($data);

        // Handle image uploads with captions
        if ($request->hasFile('images')) {
            $imageCaptions = $request->input('image_captions', []);
            foreach ($request->file('images') as $index => $image) {
                $caption = $imageCaptions[$index] ?? null;
                $this->storeMedia($eventRequest, $image, 'image', $index, $caption);
            }
        }

        // Handle video uploads
        if ($request->hasFile('videos')) {
            $imageCount = count($request->file('images') ?? []);
            foreach ($request->file('videos') as $index => $video) {
                $this->storeMedia($eventRequest, $video, 'video', $index + $imageCount);
            }
        }

        // Notify all admins
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewEventRequestNotification($eventRequest));
        }

        return redirect()
            ->route('event-requests.index')
            ->with('status', 'Your event request has been submitted successfully! Our team will review it within 24-48 hours.');
    }

    /**
     * Admin: view all event requests.
     */
    public function adminIndex()
    {
        $requests = EventRequest::with('user')
            ->latest()
            ->get();

        return view('admin.event_requests.index', compact('requests'));
    }

    /**
     * Admin: approve a request and create an Event.
     */
    public function approve($id)
    {
        $req = EventRequest::findOrFail($id);
        $req->update(['status' => EventRequest::STATUS_APPROVED, 'rejection_reason' => null]);

        // Handle venue: either find existing or create new
        $venue = Venue::firstOrCreate(
            ['name' => $req->venue],
            ['address' => 'TBD', 'capacity' => 0]
        );

        $event = Event::create([
            'name'        => $req->event_title,
            'description' => $req->event_description,
            'date'        => $req->start_date,
            'end_date'    => $req->end_date,
            'venue_id'    => $venue->id,
            'location'    => $venue->address ?? $req->venue,
            'user_id'     => $req->user_id,
            'status'      => 'active',
        ]);

        // Copy media from event request to event
        $requestMedia = $req->media;
        foreach ($requestMedia as $media) {
            // Copy the file to new location
            $oldPath = $media->file_path;
            $newPath = str_replace('event_requests/' . $req->id, 'events/' . $event->id, $oldPath);
            
            // Copy file in storage
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->copy($oldPath, $newPath);
            }

            // Create new media record for event
            EventMedia::create([
                'event_id' => $event->id,
                'file_name' => $media->file_name,
                'file_path' => $newPath,
                'file_type' => $media->file_type,
                'mime_type' => $media->mime_type,
                'file_size' => $media->file_size,
                'order' => $media->order,
                'caption' => $media->caption,
                'is_featured' => $media->is_featured,
            ]);
        }

        // Notify user
        if ($req->user) {
            $req->user->notify(new EventRequestStatusNotification($req, 'approved'));
        }

        // Log audit action
        AuditLogger::log('approved', 'EventRequest', $req->id, [
            'event_id' => $event->id,
            'event_title' => $event->name,
            'requester' => $req->user->name ?? 'Unknown'
        ]);

        return redirect()
            ->route('admin.event_requests.index')
            ->with('status', 'Event request approved, event created with all media files.');
    }

    /**
     * Admin: reject a request.
     */
    public function reject(Request $request, $id)
    {
        $req = EventRequest::findOrFail($id);
        $reason = $request->input('rejection_reason');
        $req->update([
            'status' => EventRequest::STATUS_REJECTED,
            'rejection_reason' => $reason,
        ]);

        // Notify user
        if ($req->user) {
            $req->user->notify(new EventRequestStatusNotification($req, 'rejected', $reason));
        }

        // Log audit action
        AuditLogger::log('rejected', 'EventRequest', $req->id, [
            'reason' => $reason,
            'requester' => $req->user->name ?? 'Unknown'
        ]);

        return redirect()
            ->route('admin.event_requests.index')
            ->with('status', 'Event request rejected.');
    }

    /**
     * Show a single request (admin or owner).
     */
    public function show(EventRequest $request)
    {
        $user = Auth::check() ? Auth::user() : null;

        // Allow admins or the owner of the request
        if (! $user || (! $user->isAdmin() && $user->id !== $request->user_id)) {
            abort(403, 'Unauthorized.');
        }

        return view('event_requests.show', compact('request'));
    }

    /**
     * Admin: delete a request.
     */
    public function destroy($id)
    {
        $req = EventRequest::findOrFail($id);

        $user = Auth::check() ? Auth::user() : null;
        if (! $user || ! $user->isAdmin()) {
            abort(403, 'Unauthorized.');
        }

        $req->delete();

        return redirect()
            ->route('admin.event_requests.index')
            ->with('status', 'Event request deleted.');
    }
    /**
     * Store media file for an event request.
     */
    private function storeMedia($eventRequest, $file, $type, $order, $caption = null)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('event_requests/' . $eventRequest->id . '/' . $type . 's', $fileName, 'public');

        EventMedia::create([
            'event_request_id' => $eventRequest->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $filePath,
            'file_type' => $type,
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'order' => $order,
            'is_featured' => $order === 0,
            'caption' => $caption,
        ]);
    }
}