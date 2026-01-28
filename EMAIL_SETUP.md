# Email Configuration Setup Instructions

## Current Status
Your `.env` file currently has `MAIL_MAILER=log`, which means emails are logged to files instead of being sent.

## Step 1: Choose an Email Provider

Pick one of these options based on your needs:

### 🟢 Option 1: Gmail (Recommended for Testing)

1. Enable 2-Factor Authentication in your Google Account
2. Generate an App Password: https://myaccount.google.com/apppasswords
3. Update your `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="EventMaster"
```

### 🟢 Option 2: Mailtrap (Best for Development/Testing)

1. Sign up at https://mailtrap.io
2. Create a project and get your SMTP credentials
3. Update your `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="EventMaster"
```

### 🟡 Option 3: Mailgun (Great for Production)

1. Sign up at https://www.mailgun.com
2. Add a domain and get your API key
3. Update your `.env`:

```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.yourdomain.com
MAILGUN_SECRET=key-xxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="EventMaster"
```

### 🟡 Option 4: SendGrid

1. Sign up at https://sendgrid.com
2. Create an API key
3. Update your `.env`:

```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=SG.xxxxxxxxxxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="EventMaster"
```

### 🟡 Option 5: Resend (Modern API-First Email)

1. Sign up at https://resend.com
2. Get your API key from the dashboard
3. Update your `.env`:

```env
MAIL_MAILER=resend
RESEND_API_KEY=re_xxxxxxxxxxxxxxxxxxxxxxxxxxxx
MAIL_FROM_ADDRESS=onboarding@resend.dev
MAIL_FROM_NAME="EventMaster"
```

## Step 2: Verify Configuration

After updating `.env`, clear the config cache:

```bash
php artisan config:clear
php artisan cache:clear
```

## Step 3: Test Email Sending

Option A: Send a test email via Tinker
```bash
php artisan tinker
```

Then run:
```php
Mail::raw('Test email body', function ($message) {
    $message->to('test@example.com')->subject('Test Email');
});
exit
```

Option B: Test through the password reset flow
1. Go to `/forgot-password`
2. Enter your email
3. Check if you received the code email

## Important Notes

- 🔒 **Never commit your `.env` file** to version control
- 🔑 **Keep API keys secret** - treat them like passwords
- 📧 **MAIL_FROM_ADDRESS** must be a verified sender with your provider
- ⏰ **Some providers have rate limits** - check their documentation
- 💰 **Most services have free tiers** for testing

## Troubleshooting

### Emails not being sent?
1. Verify your credentials are correct
2. Check that your email domain is verified with the provider
3. Look at the Laravel logs: `tail -f storage/logs/laravel.log`
4. Check your provider's email log for delivery failures

### "Invalid credentials" error?
1. Copy credentials carefully - no extra spaces
2. Verify the API key hasn't expired
3. Check if 2FA is needed (Gmail, etc.)

### Using VPS/Server for Production?
Consider using Postmark or SendGrid as they have better deliverability rates and support for transactional emails.

## Next: Password Reset Testing

Once configured:

1. **Forgot Password**: Go to `/forgot-password`
2. **Enter Email**: Use an account that exists in your database
3. **Check Email**: Look for your reset code email
4. **Enter Code**: Copy the 6-digit code and enter it
5. **Reset Password**: Create your new password
6. **Login**: Sign in with your new password

---

**Questions?** Check the PASSWORD_RESET_GUIDE.md file for the complete implementation details.
