<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    /**
     * Create a new notification instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
        return (new MailMessage)
            ->subject('Booking Confirmed - ' . $this->booking->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your booking has been confirmed successfully.')
            ->line('**Event:** ' . $this->booking->event->title)
            ->line('**Date:** ' . $this->booking->event->date->format('F d, Y'))
            ->line('**Time:** ' . $this->booking->event->date->format('g:i A'))
            ->line('**Venue:** ' . $this->booking->event->venue->name)
            ->line('**Ticket Type:** ' . $this->booking->ticket->type)
            ->action('View & Download Your Ticket', route('bookings.ticket', $this->booking))
            ->line('Your unique ticket with QR code is ready. Click the button above to view and download it.')
            ->line('Please present this ticket (printed or on mobile) at the event entrance for check-in.')
            ->line('Thank you for booking with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'event_id' => $this->booking->event_id,
            'event_title' => $this->booking->event->title,
            'event_date' => $this->booking->event->date->format('Y-m-d H:i:s'),
            'message' => 'Your booking for ' . $this->booking->event->title . ' has been confirmed.',
        ];
    }
}
