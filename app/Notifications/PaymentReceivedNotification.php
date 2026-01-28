<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
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
            ->subject('Payment Received - ' . $this->payment->booking->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('We have received your payment successfully.')
            ->line('**Amount:** $' . number_format($this->payment->amount, 2))
            ->line('**Event:** ' . $this->payment->booking->event->title)
            ->line('**Payment Method:** ' . $this->payment->payment_method)
            ->line('**Transaction ID:** ' . $this->payment->transaction_id)
            ->action('View Payment Receipt', route('payments.show', $this->payment))
            ->line('Thank you for your payment!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'booking_id' => $this->payment->booking_id,
            'amount' => $this->payment->amount,
            'event_title' => $this->payment->booking->event->title,
            'message' => 'Payment of $' . number_format($this->payment->amount, 2) . ' received for ' . $this->payment->booking->event->title,
        ];
    }
}
