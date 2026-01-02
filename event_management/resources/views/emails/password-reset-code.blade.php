<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset Code</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 10px 10px; }
        .code { font-size: 32px; font-weight: bold; color: #667eea; text-align: center; letter-spacing: 5px; background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border: 2px solid #667eea; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EventMaster</h1>
            <h2>Password Reset Code</h2>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>You have requested to reset your password for your EventMaster account. Use the following code to complete the password reset process:</p>

            <div class="code">{{ $code }}</div>

            <div class="warning">
                <strong>Important:</strong> This code will expire in 15 minutes. If you did not request this password reset, please ignore this email.
            </div>

            <p>If you have any questions or need assistance, please contact our support team.</p>

            <p>Best regards,<br>The EventMaster Team</p>
        </div>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} EventMaster. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
