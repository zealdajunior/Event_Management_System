@component('mail::message')
# Your Event Ticket 🎫

Hello {{ $booking->user->name }},

Thank you for your payment! Your ticket for **{{ $booking->event->name }}** is now ready for download.

## Event Details
- **Event:** {{ $booking->event->name }}
- **Date:** {{ $booking->event->date ? \Carbon\Carbon::parse($booking->event->date)->format('l, F j, Y \a\t g:i A') : 'TBD' }}
- **Venue:** {{ $booking->event->venue->name ?? 'TBD' }}
- **Ticket Type:** {{ $booking->ticket->type }}
- **Booking Reference:** {{ $booking->booking_reference }}

## Important Information
📧 Your ticket is attached to this email as a PDF file  
📱 You can also download it from your dashboard  
🆔 Bring your ticket (printed or on your phone) to the event  
⏰ Please arrive 15 minutes before the event starts  

@component('mail::button', ['url' => route('bookings.ticket', $booking)])
View Ticket Online
@endcomponent

## What to Expect
- Your ticket contains a unique QR code for quick check-in
- Our staff will scan your QR code at the event entrance
- Keep your ticket safe and don't share the QR code

If you have any questions or need assistance, please don't hesitate to contact our support team.

Thanks,<br>
{{ config('app.name') }} Team

---
*This is an automated message. Please do not reply to this email.*
@endcomponent