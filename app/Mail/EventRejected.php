<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Event $event
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Submission Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.events.rejected',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
