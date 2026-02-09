<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Event Ticket</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1f2937;
            margin: 0;
            font-size: 28px;
        }
        .ticket-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }
        .greeting {
            font-size: 18px;
            color: #374151;
            margin-bottom: 20px;
        }
        .event-details {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .event-details h2 {
            color: #1e40af;
            margin: 0 0 15px 0;
            font-size: 20px;
        }
        .detail-item {
            margin: 10px 0;
            font-size: 15px;
        }
        .detail-item strong {
            color: #1f2937;
            display: inline-block;
            width: 150px;
        }
        .important-info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .important-info h2 {
            color: #92400e;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .info-list {
            list-style: none;
            padding: 0;
        }
        .info-list li {
            margin: 10px 0;
            padding-left: 30px;
            position: relative;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .button:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }
        .expectations {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .expectations h2 {
            color: #065f46;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .footer-note {
            font-style: italic;
            color: #9ca3af;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="ticket-icon">🎫</div>
            <h1>Your Event Ticket</h1>
        </div>

        <p class="greeting">Hello {{ $booking->user->name }},</p>

        <p>Thank you for your booking! Your ticket for <strong>{{ $booking->event->name }}</strong> is now ready.</p>

        <div class="event-details">
            <h2>📅 Event Details</h2>
            <div class="detail-item">
                <strong>Event:</strong> {{ $booking->event->name }}
            </div>
            <div class="detail-item">
                <strong>Date:</strong> {{ $booking->event->date ? \Carbon\Carbon::parse($booking->event->date)->format('l, F j, Y \a\t g:i A') : 'TBD' }}
            </div>
            <div class="detail-item">
                <strong>Venue:</strong> {{ $booking->event->venue->name ?? $booking->event->location ?? 'TBD' }}
            </div>
            <div class="detail-item">
                <strong>Ticket Type:</strong> {{ $booking->ticket->type }}
            </div>
            <div class="detail-item">
                <strong>Booking Reference:</strong> <strong style="color: #3b82f6; font-size: 16px;">{{ $booking->booking_reference }}</strong>
            </div>
        </div>

        <div class="important-info">
            <h2>⚠️ Important Information</h2>
            <ul class="info-list">
                <li>📧 Your ticket is attached to this email as a PDF file</li>
                <li>📱 You can also download it from your dashboard</li>
                <li>🆔 Bring your ticket (printed or on your phone) to the event</li>
                <li>⏰ Please arrive 15 minutes before the event starts</li>
            </ul>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('bookings.ticket', $booking) }}" class="button">
                View & Download Ticket
            </a>
        </div>

        <div class="expectations">
            <h2>✨ What to Expect</h2>
            <ul class="info-list">
                <li>Your ticket contains a unique QR code for quick check-in</li>
                <li>Our staff will scan your QR code at the event entrance</li>
                <li>Keep your ticket safe and don't share the QR code</li>
            </ul>
        </div>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <div class="footer">
            <p><strong>Thanks,</strong><br>{{ config('app.name') }} Team</p>
            <p class="footer-note">This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>