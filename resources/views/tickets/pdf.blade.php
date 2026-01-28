<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Event Ticket - {{ $ticket['event_title'] }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: white;
            padding: 0;
            margin: 0;
            line-height: 1.4;
        }

        .ticket-container {
            width: 100%;
            background: white;
            border: 4px solid #3b82f6;
            border-radius: 16px;
            overflow: hidden;
        }

        .ticket-header {
            background: #3b82f6;
            color: white;
            padding: 25px 30px;
            text-align: left;
            border-bottom: 5px solid #2563eb;
        }

        .ticket-header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .reference-box {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .ticket-body {
            padding: 25px 30px;
        }

        .body-table {
            width: 100%;
            border-collapse: collapse;
        }

        .body-table td {
            vertical-align: top;
            padding: 0;
        }

        .left-column {
            width: 65%;
            padding-right: 25px;
        }

        .right-column {
            width: 35%;
        }

        .event-title-box {
            background: #eff6ff;
            padding: 20px;
            border-radius: 12px;
            border-left: 6px solid #3b82f6;
            margin-bottom: 20px;
        }

        .event-title-label {
            font-size: 10px;
            color: #2563eb;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 1.5px;
        }

        .event-title-value {
            font-size: 24px;
            color: #1e293b;
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .status-badge {
            background: #3b82f6;
            color: white;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            letter-spacing: 1px;
        }

        .details-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-bottom: 15px;
        }

        .detail-cell {
            background: white;
            padding: 14px;
            border: 2px solid #dbeafe;
            border-radius: 10px;
            width: 50%;
        }

        .detail-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 6px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 14px;
            color: #1e293b;
            font-weight: bold;
        }

        .address-box {
            background: white;
            padding: 14px;
            border: 2px solid #dbeafe;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .qr-box {
            background: #eff6ff;
            padding: 20px;
            border-radius: 12px;
            border: 4px solid #3b82f6;
            text-align: center;
        }

        .qr-inner {
            background: white;
            padding: 15px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .qr-inner img {
            width: 200px;
            height: 200px;
            display: block;
        }

        .qr-label {
            font-size: 11px;
            color: #1e293b;
            font-weight: bold;
            text-align: center;
            line-height: 1.4;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .qr-code-text {
            font-size: 9px;
            color: #64748b;
            font-family: 'Courier New', monospace;
            text-align: center;
            word-break: break-all;
            padding: 8px;
            background: white;
            border-radius: 6px;
        }

        .ticket-footer {
            background: #eff6ff;
            padding: 20px 30px;
            border-top: 4px dashed #93c5fd;
        }

        .footer-note {
            font-size: 11px;
            color: #475569;
            line-height: 1.8;
        }

        .footer-note strong {
            color: #1e293b;
            font-size: 13px;
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .footer-note br {
            line-height: 2;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <!-- Header -->
        <div class="ticket-header">
            <h1>🎟️ EVENT TICKET</h1>
            <span class="reference-box">{{ $ticket['booking_reference'] }}</span>
        </div>

        <!-- Body -->
        <div class="ticket-body">
            <table class="body-table">
                <tr>
                    <td class="left-column">
                        <!-- Event Title -->
                        <div class="event-title-box">
                            <div class="event-title-label">Event Name</div>
                            <div class="event-title-value">{{ $ticket['event_title'] }}</div>
                            <span class="status-badge">{{ strtoupper($ticket['status']) }}</span>
                        </div>

                        <!-- Details Grid -->
                        <table class="details-table">
                            <tr>
                                <td class="detail-cell">
                                    <div class="detail-label">📅 Date</div>
                                    <div class="detail-value">{{ $ticket['event_date'] }}</div>
                                </td>
                                <td class="detail-cell">
                                    <div class="detail-label">🕐 Time</div>
                                    <div class="detail-value">{{ $ticket['event_time'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="detail-cell">
                                    <div class="detail-label">📍 Venue</div>
                                    <div class="detail-value">{{ $ticket['event_venue'] }}</div>
                                </td>
                                <td class="detail-cell">
                                    <div class="detail-label">🎫 Ticket Type</div>
                                    <div class="detail-value">{{ $ticket['ticket_type'] }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td class="detail-cell">
                                    <div class="detail-label">👤 Attendee</div>
                                    <div class="detail-value">{{ $ticket['user_name'] }}</div>
                                </td>
                                <td class="detail-cell">
                                    <div class="detail-label">💰 Price</div>
                                    <div class="detail-value">${{ $ticket['ticket_price'] }}</div>
                                </td>
                            </tr>
                        </table>

                        <!-- Address -->
                        @if($ticket['event_address'] !== 'TBA')
                        <div class="address-box">
                            <div class="detail-label">🗺️ Full Address</div>
                            <div class="detail-value">{{ $ticket['event_address'] }}</div>
                        </div>
                        @endif
                    </td>
                    <td class="right-column">
                        <!-- QR Code -->
                        <div class="qr-box">
                            <div class="qr-inner">
                                <img src="{{ $ticket['qr_code'] }}" alt="QR Code">
                            </div>
                            <div class="qr-label">Scan at Entrance</div>
                            <div class="qr-code-text">{{ $ticket['qr_code_text'] }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="ticket-footer">
            <div class="footer-note">
                <strong>Important Instructions:</strong>
                • Please arrive 30 minutes before the event starts<br>
                • Present this ticket at the entrance<br>
                • QR code will be scanned for verification<br>
                • This ticket is non-transferable and valid for one person only<br>
                • Booked on: {{ $ticket['booking_date'] }}
            </div>
        </div>
    </div>
</body>
</html>
