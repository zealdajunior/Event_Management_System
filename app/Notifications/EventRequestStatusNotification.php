<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\EventRequest;

class EventRequestStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $eventRequest;
    public $status;
    public $reason;

    public function __construct(EventRequest $eventRequest, $status, $reason = null)
    {
        $this->eventRequest = $eventRequest;
        $this->status = $status;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Your Event Request Has Been ' . ucfirst($this->status))
            ->line('Your event request ("' . $this->eventRequest->event_title . '") has been ' . $this->status . '.');
        if ($this->status === 'rejected' && $this->reason) {
            $mail->line('Reason for rejection: ' . $this->reason);
        }
        return $mail;
    }

    public function toArray($notifiable)
    {
        return [
            'event_request_id' => $this->eventRequest->id,
            'event_title' => $this->eventRequest->event_title,
            'status' => $this->status,
            'reason' => $this->reason,
        ];
    }
}
