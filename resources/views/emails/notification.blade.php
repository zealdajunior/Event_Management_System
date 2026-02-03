<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f1f5f9;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .notification-type {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .type-info { background: #dbeafe; color: #1d4ed8; }
        .type-success { background: #d1fae5; color: #059669; }
        .type-warning { background: #fef3c7; color: #d97706; }
        .type-error { background: #fecaca; color: #dc2626; }
        .content {
            margin: 20px 0;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
        }
        .message {
            font-size: 16px;
            line-height: 1.7;
            color: #4b5563;
            margin-bottom: 25px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 0;
        }
        .btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <span>⭐</span>
                EventHub
            </div>
            <span class="notification-type type-{{ $type }}">{{ ucfirst($type) }}</span>
        </div>

        <div class="content">
            <div class="title">{{ $title }}</div>
            <div class="message">{{ $message }}</div>

            @if(isset($data['action_url']) && $data['action_url'])
                <a href="{{ $data['action_url'] }}" class="btn">
                    {{ $data['action_text'] ?? 'View Details' }}
                </a>
            @endif
        </div>

        <div class="footer">
            <p>You received this notification from EventHub. If you no longer wish to receive these emails, you can update your notification preferences in your account settings.</p>
            <p>&copy; {{ date('Y') }} EventHub. All rights reserved.</p>
        </div>
    </div>
</body>
</html>