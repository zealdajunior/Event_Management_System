<?php

namespace App\Observers;

use App\Models\Event;
use App\Models\User;
use App\Services\NotificationService;

class EventObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        // Send notification to all users when a new event is created
        $users = User::where('role', 'user')->get();
        
        foreach ($users as $user) {
            $this->notificationService->sendToUser(
                user: $user,
                title: 'New Event Available!',
                message: "A new event '{$event->name}' has been created and is now available for booking.",
                type: 'info',
                data: ['event_id' => $event->id, 'event_name' => $event->name],
                channel: 'app' // Start with app-only, respect user preferences later
            );
        }
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        // Only send notifications for significant changes
        if ($event->wasChanged(['date', 'time', 'location', 'venue_id'])) {
            // Get users who have bookings for this event
            $users = User::whereHas('bookings', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->get();

            foreach ($users as $user) {
                $this->notificationService->sendToUser(
                    user: $user,
                    title: 'Event Update',
                    message: "The event '{$event->name}' has been updated. Please check the latest details.",
                    type: 'warning',
                    data: ['event_id' => $event->id, 'event_name' => $event->name],
                    channel: 'both' // Important updates should go to both channels
                );
            }
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        // Get users who had bookings for this event
        $users = User::whereHas('bookings', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->get();

        foreach ($users as $user) {
            $this->notificationService->sendToUser(
                user: $user,
                title: 'Event Cancelled',
                message: "The event '{$event->name}' has been cancelled. You will receive a full refund if applicable.",
                type: 'error',
                data: ['event_id' => $event->id, 'event_name' => $event->name],
                channel: 'both' // Critical updates should go to both channels
            );
        }
    }
}
