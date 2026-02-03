<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket - {{ $ticket['event_title'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 30px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .success-message {
            max-width: 1100px;
            width: 100%;
            background: white;
            border-radius: 12px;
            padding: 18px 25px;
            margin-bottom: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 18px;
            border-left: 5px solid #3b82f6;
        }

        .success-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .success-icon svg {
            width: 30px;
            height: 30px;
            color: white;
        }

        .success-text {
            flex: 1;
        }

        .success-text h3 {
            color: #3b82f6;
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .success-text p {
            color: #666;
            font-size: 14px;
        }

        .ticket-container {
            max-width: 1100px;
            width: 100%;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.1);
        }

        .ticket-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 35px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #1d4ed8;
        }

        .ticket-header-left {
            flex: 1;
        }

        .ticket-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .ticket-header .reference {
            font-size: 14px;
            opacity: 0.95;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-block;
            backdrop-filter: blur(10px);
        }

        .ticket-body {
            padding: 35px 40px;
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 35px;
            align-items: start;
        }

        .ticket-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .ticket-section {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #3b82f6;
        }

        .section-title {
            font-size: 11px;
            color: #2563eb;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1.5px;
        }

        .section-content {
            font-size: 24px;
            color: #1e293b;
            font-weight: 700;
            line-height: 1.3;
        }

        .event-details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .detail-item {
            padding: 16px 18px;
            background: white;
            border-radius: 10px;
            border: 2px solid #dbeafe;
            transition: all 0.2s;
        }

        .detail-item:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .detail-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            color: #1e293b;
            font-weight: 600;
        }

        .qr-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 25px 20px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 12px;
            border: 3px solid #3b82f6;
            position: sticky;
            top: 20px;
        }

        .qr-code-container {
            padding: 12px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
            margin-bottom: 15px;
        }

        .qr-code-container img {
            display: block;
            width: 200px;
            height: 200px;
        }

        .qr-label {
            font-size: 12px;
            color: #1e293b;
            font-weight: 700;
            text-align: center;
            line-height: 1.4;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .qr-code-text {
            font-size: 10px;
            color: #64748b;
            font-family: 'Courier New', monospace;
            text-align: center;
            word-break: break-all;
            padding: 8px;
            background: white;
            border-radius: 6px;
        }

        .ticket-footer {
            background: linear-gradient(to right, #eff6ff 0%, #dbeafe 100%);
            padding: 25px 40px;
            border-top: 3px dashed #93c5fd;
        }

        .footer-note {
            font-size: 13px;
            color: #475569;
            line-height: 1.8;
        }

        .footer-note strong {
            color: #1e293b;
            font-size: 14px;
            display: block;
            margin-bottom: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 18px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 12px;
            box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
            letter-spacing: 1px;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            grid-column: 1 / -1;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: white;
            color: #3b82f6;
            border: 2px solid #3b82f6;
        }

        .btn-secondary:hover {
            background: #3b82f6;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }
            
            body {
                background: white;
                padding: 0;
            }
            
            .ticket-container {
                box-shadow: none;
                max-width: 100%;
            }
            
            .action-buttons {
                display: none;
            }
        }

        @media (max-width: 1024px) {
            .ticket-body {
                grid-template-columns: 1fr;
            }
            
            .event-details-grid {
                grid-template-columns: 1fr;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    @if(session('status'))
    <div class="success-message">
        <div class="success-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <div class="success-text">
            <h3>Booking Successful!</h3>
            <p>{{ session('status') }}</p>
        </div>
    </div>
    @endif

    <div class="ticket-container">
        <!-- Ticket Header -->
        <div class="ticket-header">
            <div class="ticket-header-left">
                <h1>🎟️ EVENT TICKET</h1>
                <div class="reference">{{ $ticket['booking_reference'] }}</div>
            </div>
        </div>

        <!-- Ticket Body -->
        <div class="ticket-body">
            <div class="ticket-details">
                <!-- Event Title -->
                <div class="ticket-section">
                    <div class="section-title">Event Name</div>
                    <div class="section-content">{{ $ticket['event_title'] }}</div>
                    <span class="status-badge">{{ strtoupper($ticket['status']) }}</span>
                </div>

                <!-- Event Details Grid -->
                <div class="event-details-grid">
                    <div class="detail-item">
                        <div class="detail-label">📅 Date</div>
                        <div class="detail-value">{{ $ticket['event_date'] }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">🕐 Time</div>
                        <div class="detail-value">{{ $ticket['event_time'] }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">📍 Venue</div>
                        <div class="detail-value">{{ $ticket['event_venue'] }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">🎫 Ticket Type</div>
                        <div class="detail-value">{{ $ticket['ticket_type'] }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">👤 Attendee</div>
                        <div class="detail-value">{{ $ticket['user_name'] }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">💰 Price</div>
                        <div class="detail-value">${{ $ticket['ticket_price'] }}</div>
                    </div>
                </div>

                <!-- Address -->
                @if($ticket['event_address'] !== 'TBA')
                <div class="detail-item">
                    <div class="detail-label">🗺️ Full Address</div>
                    <div class="detail-value">{{ $ticket['event_address'] }}</div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button onclick="window.print()" class="btn btn-primary">
                        🖨️ Print Ticket
                    </button>
                    <a href="{{ route('bookings.ticket.download', $ticket['booking_id']) }}" class="btn btn-primary">
                        💾 Download PDF
                    </a>
                    <form method="POST" action="{{ route('bookings.ticket.email', $ticket['booking_id']) }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            📧 Email Ticket
                        </button>
                    </form>
                    <a href="@dashboardRoute" class="btn btn-secondary">
                        ← Dashboard
                    </a>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="qr-section">
                <div class="qr-code-container">
                    <img src="{{ $ticket['qr_code'] }}" alt="Ticket QR Code">
                </div>
                <div class="qr-label">Scan at Entrance</div>
                <div class="qr-code-text">{{ $ticket['qr_code_text'] }}</div>
            </div>
        </div>

        <!-- Ticket Footer -->
        <div class="ticket-footer">
            <div class="footer-note">
                <strong>Important Instructions:</strong><br>
                • Please arrive 30 minutes before the event starts<br>
                • Present this ticket (printed or on mobile) at the entrance<br>
                • QR code will be scanned for verification<br>
                • This ticket is non-transferable and valid for one person only<br>
                • Booked on: {{ $ticket['booking_date'] }}
            </div>
        </div>
    </div>
</body>
</html>
