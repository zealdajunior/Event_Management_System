# Password Reset Implementation - Complete Guide

## Overview
The password reset functionality has been completely redesigned with a code-based flow instead of token-based links.

## What Was Changed

### 1. **Mail Class** - [PasswordResetCode.php](app/Mail/PasswordResetCode.php)
- ✅ Updated to accept and pass the reset code to the email template
- ✅ Now properly sends the code to users

### 2. **Database** - [password_reset_codes table](database/migrations/2025_12_24_235601_create_password_reset_codes_table.php)
- ✅ Already exists with: `id`, `email`, `code`, `expires_at`, `created_at`, `updated_at`
- ✅ Code is 6 digits, expires in 15 minutes

### 3. **Model** - [PasswordResetCode.php](app/Models/PasswordResetCode.php)
- ✅ Already has all necessary methods:
  - `generateCode()` - generates random 6-digit code
  - `createForEmail()` - creates a code record with 15-minute expiration
  - Scopes for querying: `valid()`, `byEmail()`, `byCode()`

### 4. **Email Template** - [password-reset-code.blade.php](resources/views/emails/password-reset-code.blade.php)
- ✅ Already exists with professional styling
- ✅ Displays the 6-digit code
- ✅ Shows expiration warning

### 5. **Routes** - [auth.php](routes/auth.php)
- ✅ Added new route: `/verify-reset-code` (password.verify-code)
- ✅ Forgot password route still exists at `/forgot-password` (password.request)

### 6. **Forgot Password Page** - [forgot-password.blade.php](resources/views/livewire/pages/auth/forgot-password.blade.php)
- ✅ Redesigned with better UI
- ✅ Creates reset code
- ✅ Sends code to user email
- ✅ Redirects to verify-code page

### 7. **Verify Code Page** - [verify-reset-code.blade.php](resources/views/livewire/pages/auth/verify-reset-code.blade.php) [NEW]
- ✅ Users enter 6-digit code from email
- ✅ After verification, enter new password
- ✅ Beautiful two-step form

## How It Works

```
1. User clicks "Forgot Password"
   ↓
2. Enters email address
   ↓
3. System creates random 6-digit code in database (15-min expiration)
   ↓
4. Code is sent to user's email
   ↓
5. User redirected to verify-code page
   ↓
6. User enters the 6-digit code they received
   ↓
7. If valid, form switches to password entry
   ↓
8. User enters new password
   ↓
9. Password is updated and code is deleted
   ↓
10. User redirected to login page
```

## Configuration Required

### To Actually Send Emails

The `.env` file currently has:
```
MAIL_MAILER=log
```

This logs emails instead of sending them. To send real emails, change this based on your provider:

#### Option A: SMTP (Gmail, Office365, etc.)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Event Master"
```

#### Option B: Mailgun
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-api-key
MAIL_FROM_ADDRESS=noreply@your-domain.mailgun.org
MAIL_FROM_NAME="Event Master"
```

#### Option C: SendGrid
```env
MAIL_MAILER=sendgrid
SENDGRID_API_KEY=your-sendgrid-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Event Master"
```

#### Option D: Resend (Recommended for APIs)
```env
MAIL_MAILER=resend
RESEND_API_KEY=your-resend-api-key
MAIL_FROM_ADDRESS=onboarding@resend.dev
MAIL_FROM_NAME="Event Master"
```

### Testing Locally

If you want to test without sending emails, keep `MAIL_MAILER=log` and check the logs in `storage/logs/laravel.log` to see the emails that would be sent.

Alternatively, use a service like **Mailtrap**:
```env
MAIL_MAILER=smtp
MAIL_HOST=live.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Event Master"
```

## Testing the Flow

1. **Start the app**: `php artisan serve`
2. **Go to**: `http://localhost:8000/forgot-password`
3. **Enter an email** of an existing user
4. **Check logs** (if using `log` driver):
   - `tail -f storage/logs/laravel.log`
5. **Copy the 6-digit code** from the logged email
6. **Enter the code** on the verify-code page
7. **Set new password** and confirm
8. **Login** with new password

## Files Modified

- ✅ [app/Mail/PasswordResetCode.php](app/Mail/PasswordResetCode.php) - Updated mail class
- ✅ [routes/auth.php](routes/auth.php) - Added verify-code route
- ✅ [resources/views/livewire/pages/auth/forgot-password.blade.php](resources/views/livewire/pages/auth/forgot-password.blade.php) - Redesigned forgot password
- ✅ [resources/views/livewire/pages/auth/verify-reset-code.blade.php](resources/views/livewire/pages/auth/verify-reset-code.blade.php) - New verify code page

## Database Migrations

To apply changes:
```bash
php artisan migrate
```

The `password_reset_codes` table migration was already created and should be in your migrations directory.

## Next Steps

1. Configure your email provider in `.env`
2. Run the app and test the password reset flow
3. Monitor logs to ensure emails are being sent/received
4. Adjust email template if needed in [password-reset-code.blade.php](resources/views/emails/password-reset-code.blade.php)

## Troubleshooting

- **Emails not sending?** Check your `.env` MAIL_MAILER setting
- **Code expired?** Codes expire after 15 minutes - modify in [PasswordResetCode.php](app/Models/PasswordResetCode.php) line 28
- **Wrong email format?** Check [password-reset-code.blade.php](resources/views/emails/password-reset-code.blade.php)
