<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\TicketGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketDownloadController extends Controller
{
    protected $ticketGenerator;

    public function __construct(TicketGeneratorService $ticketGenerator)
    {
        $this->ticketGenerator = $ticketGenerator;
    }

    /**
     * Display the ticket for a booking
     */
    public function show(Booking $booking)
    {
        // Ensure user owns this booking or is admin
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Get ticket data
        $ticket = $this->ticketGenerator->getTicketData($booking);

        return view('tickets.download', compact('ticket'));
    }

    /**
     * Download ticket as PDF
     */
    public function download(Booking $booking)
    {
        // Ensure user owns this booking or is admin
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Get ticket data
        $ticket = $this->ticketGenerator->getTicketData($booking);

        // Generate PDF
        $pdf = Pdf::loadView('tickets.pdf', compact('ticket'))
            ->setPaper('a4', 'landscape')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        // Generate filename
        $filename = 'ticket-' . $booking->booking_reference . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * Email ticket to user
     */
    public function email(Booking $booking)
    {
        // Ensure user owns this booking or is admin
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        try {
            // Send ticket email
            \Illuminate\Support\Facades\Mail::to($booking->user->email)
                ->send(new \App\Mail\TicketDeliveryMail($booking));

            return back()->with('status', 'Ticket has been sent to your email address: ' . $booking->user->email);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send ticket email. Please try again later.']);
        }
    }
}
