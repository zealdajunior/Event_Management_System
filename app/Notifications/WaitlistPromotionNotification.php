<?php

namespace App\Notifications;

use App\Models\Waitlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WaitlistPromotionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $waitlistEntry;

    /**
     * Create a new notification instance.
     */
    public function __construct(Waitlist $waitlistEntry)
    {
        $this->waitlistEntry = $waitlistEntry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $event = $this->waitlistEntry->event;
        $ticket = $this->waitlistEntry->ticket;
        $quantity = $this->waitlistEntry->quantity;
        $expiresAt = $this->waitlistEntry->expires_at;

        $subject = "🎫 Good News! Tickets Available for {$event->name}";
        
        $ticketText = $ticket ? 
            "Ticket Type: {$ticket->name} (Quantity: {$quantity})" : 
            "General Admission (Quantity: {$quantity})";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Great news, {$notifiable->name}!")
            ->line("Tickets are now available for **{$event->name}**!")
            ->line($ticketText)
            ->line("**Event Details:**")
            ->line("📅 Date: {$event->date->format('M j, Y \\a\\t g:i A')}")
            ->line("📍 Location: {$event->location}")
            ->line("⏰ **Important:** You have **24 hours** to complete your booking.")
            ->line("⚠️ This offer expires on: {$expiresAt->format('M j, Y \\a\\t g:i A')}")
            ->action('Book Now', route('waitlist.accept', $this->waitlistEntry))
            ->line('If you no longer wish to book this event, you can decline this offer.')
            ->action('Decline Offer', route('waitlist.decline', $this->waitlistEntry))
            ->line('Thank you for your patience!')
            ->salutation('The ' . config('app.name') . ' Team');
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $event = $this->waitlistEntry->event;
        $ticket = $this->waitlistEntry->ticket;

        return [
            'type' => 'waitlist_promotion',
            'title' => 'Tickets Available!',
            'message' => "Tickets are now available for {$event->name}",
            'event_id' => $event->id,
            'event_name' => $event->name,
            'ticket_id' => $ticket?->id,
            'ticket_name' => $ticket?->name,
            'quantity' => $this->waitlistEntry->quantity,
            'expires_at' => $this->waitlistEntry->expires_at,
            'waitlist_id' => $this->waitlistEntry->id,
            'action_url' => route('waitlist.accept', $this->waitlistEntry),
            'decline_url' => route('waitlist.decline', $this->waitlistEntry),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }

    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable): bool
    {
        // Don't send if waitlist entry has been converted or expired
        return $this->waitlistEntry->status === 'notified' && !$this->waitlistEntry->isExpired();
    }
}
