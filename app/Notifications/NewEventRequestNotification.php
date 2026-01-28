<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EventRequest;

class NewEventRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $eventRequest;

    public function __construct(EventRequest $eventRequest)
    {
        $this->eventRequest = $eventRequest;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Event Request Submitted')
            ->line('A new event request has been submitted by: ' . $this->eventRequest->user->name)
            ->action('View Requests', url('/admin-dashboard'))
            ->line('Event Title: ' . $this->eventRequest->event_title);
    }

    public function toArray($notifiable)
    {
        return [
            'event_request_id' => $this->eventRequest->id,
            'event_title' => $this->eventRequest->event_title,
            'submitted_by' => $this->eventRequest->user->name,
        ];
    }
}
