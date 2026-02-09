<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Event $event
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Event Has Been Approved! 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.events.approved',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
