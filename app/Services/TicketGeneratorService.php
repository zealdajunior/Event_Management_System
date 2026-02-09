<?php

namespace App\Services;

use App\Models\Booking;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Illuminate\Support\Facades\Storage;

class TicketGeneratorService
{
    /**
     * Generate QR code for a booking
     */
    public function generateQRCode(Booking $booking): string
    {
        // Create attendance record if it doesn't exist
        $attendance = $booking->attendance;
        
        if (!$attendance) {
            $qrCodeData = json_encode([
                'booking_id' => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'user_id' => $booking->user_id,
                'event_id' => $booking->event_id,
            ]);
            
            $attendance = \App\Models\Attendance::create([
                'booking_id' => $booking->id,
                'user_id' => $booking->user_id,
                'event_id' => $booking->event_id,
                'status' => 'pending',
                'qr_code' => $qrCodeData,
            ]);
        }

        // Use SVG writer (doesn't require GD extension)
        $qrCode = new QrCode($attendance->qr_code);
        $writer = new SvgWriter();
        $result = $writer->write($qrCode);

        return $result->getDataUri();
    }

    /**
     * Get ticket data for display
     */
    public function getTicketData(Booking $booking): array
    {
        $booking->load(['event', 'ticket', 'user', 'attendance']);

        return [
            'booking_id' => $booking->id,
            'booking_reference' => $booking->booking_reference ?? 'BKG-' . str_pad($booking->id, 8, '0', STR_PAD_LEFT),
            'user_name' => $booking->user->name,
            'user_email' => $booking->user->email,
            'event_title' => $booking->event->name,
            'event_description' => $booking->event->description,
            'event_date' => $booking->event->date ? \Carbon\Carbon::parse($booking->event->date)->format('F d, Y') : 'TBA',
            'event_time' => $booking->event->date ? \Carbon\Carbon::parse($booking->event->date)->format('g:i A') : 'TBA',
            'event_venue' => $booking->event->venue->name ?? $booking->event->location ?? 'TBA',
            'event_address' => $booking->event->venue->address ?? $booking->event->location ?? 'TBA',
            'ticket_type' => $booking->ticket->type,
            'ticket_price' => number_format($booking->ticket->price, 2),
            'booking_date' => $booking->booking_date ? $booking->booking_date->format('F d, Y g:i A') : now()->format('F d, Y g:i A'),
            'status' => $booking->status,
            'qr_code' => $this->generateQRCode($booking),
            'qr_code_text' => $booking->attendance->qr_code ?? 'N/A',
        ];
    }
}
