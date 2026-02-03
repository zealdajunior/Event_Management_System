<?php

namespace App\Mail;

use App\Models\Booking;
use App\Services\TicketGeneratorService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketDeliveryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $ticketData;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        
        // Generate ticket data
        $ticketGenerator = app(TicketGeneratorService::class);
        $this->ticketData = $ticketGenerator->getTicketData($booking);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Event Ticket - ' . $this->booking->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-delivery',
            with: [
                'booking' => $this->booking,
                'ticket' => $this->ticketData,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Generate PDF ticket
        $pdf = Pdf::loadView('tickets.pdf', ['ticket' => $this->ticketData])
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // Create filename
        $filename = 'ticket-' . $this->booking->booking_reference . '.pdf';

        return [
            Attachment::fromData(
                fn() => $pdf->output(),
                $filename
            )->withMime('application/pdf'),
        ];
    }
}