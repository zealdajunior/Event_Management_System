<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset Code</title>
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6; 
            color: #333;
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%);
            margin: 0;
            padding: 20px;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(37, 99, 235, 0.15);
        }
        .header { 
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white; 
            padding: 40px 30px; 
            text-align: center;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 28px;
            font-weight: 800;
        }
        .header p {
            margin: 0;
            font-size: 16px;
            opacity: 0.95;
        }
        .content { 
            padding: 40px 30px;
            background: white;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message {
            color: #4b5563;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .code-container {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 3px solid #3b82f6;
        }
        .code-label {
            font-size: 14px;
            color: #2563eb;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }
        .code { 
            font-size: 42px; 
            font-weight: 900; 
            color: #1e40af;
            letter-spacing: 12px;
            font-family: 'Courier New', monospace;
            margin: 0;
        }
        .warning { 
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #92400e;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            font-size: 14px;
        }
        .warning strong {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            color: #78350f;
        }
        .info-box {
            background: #f0f9ff;
            border-left: 4px solid #0284c7;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            font-size: 14px;
            color: #075985;
        }
        .footer { 
            text-align: center; 
            padding: 30px;
            color: #6b7280;
            font-size: 14px;
            background: #f9fafb;
        }
        .footer p {
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            margin: 20px 0;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 EventMaster</h1>
            <p>Password Reset Request</p>
        </div>

        <div class="content">
            <p class="greeting">Hello there! 👋</p>

            <p class="message">
                We received a request to reset your password for your <strong>EventMaster</strong> account. 
                To proceed with the password reset, please use the verification code below:
            </p>

            <div class="code-container">
                <div class="code-label">Your Verification Code</div>
                <div class="code">{{ $code }}</div>
            </div>

            <div class="warning">
                <strong>⚠️ Important Security Notice</strong>
                This code will expire in <strong>15 minutes</strong> for your security. If you did not request this password reset, please ignore this email and your password will remain unchanged.
            </div>

            <div class="divider"></div>

            <div class="info-box">
                <strong>💡 Security Tips:</strong><br>
                • Never share this code with anyone<br>
                • EventMaster will never ask for your password via email<br>
                • Make sure to use a strong, unique password
            </div>

            <p class="message">
                If you're having trouble or didn't request this reset, please contact our support team immediately.
            </p>

            <p class="message" style="margin-top: 30px;">
                Best regards,<br>
                <strong>The EventMaster Team</strong> 🎊
            </p>
        </div>

        <div class="footer">
            <p><strong>This is an automated message. Please do not reply to this email.</strong></p>
            <p>&copy; {{ date('Y') }} EventMaster. All rights reserved.</p>
            <p style="margin-top: 15px; font-size: 12px;">Secured by EventMaster Security System 🔒</p>
        </div>
    </div>
</body>
</html>
