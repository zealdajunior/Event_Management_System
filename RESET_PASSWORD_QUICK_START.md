# Quick Start - Password Reset Testing

## What's New ✨

Your password reset feature now has a **modern, code-based flow** instead of token links:

```
Forgot Password → Enter Email → Get 6-Digit Code via Email → Verify Code → Enter New Password → Done!
```

## Quick Setup (5 minutes)

### 1. Choose Email Provider
Pick the easiest for your setup:
- **Gmail** ← Easiest if you have a Gmail account
- **Mailtrap** ← Best for development/testing
- **Mailgun** ← Best for production

See `EMAIL_SETUP.md` for detailed instructions.

### 2. Update `.env` File
Example for Gmail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="EventMaster"
```

### 3. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

## Testing the Flow

1. **Start the app**
   ```bash
   php artisan serve
   ```

2. **Go to Forgot Password**
   - URL: `http://localhost:8000/forgot-password`
   - Enter an email of an existing user

3. **Check Your Email**
   - You'll receive a code like: **123456**
   - Code expires in 15 minutes

4. **Enter the Code**
   - You'll be redirected to verification page
   - Enter the 6-digit code

5. **Set New Password**
   - Form switches to password entry
   - Enter and confirm your new password

6. **Login**
   - Go to `/login`
   - Use your email and new password

## Files Changed

| File | What Changed |
|------|--------------|
| `app/Mail/PasswordResetCode.php` | Now sends the code to email |
| `routes/auth.php` | Added `/verify-reset-code` route |
| `resources/views/livewire/pages/auth/forgot-password.blade.php` | New design, sends codes |
| `resources/views/livewire/pages/auth/verify-reset-code.blade.php` | NEW - Verify code & reset password |

## Database

Already exists and ready to use:
- Table: `password_reset_codes`
- Stores: email, 6-digit code, expiration time

## Configuration Options

### For Development (Test Mode)
```env
MAIL_MAILER=log  # Logs emails to storage/logs/laravel.log
```
To see emails: `tail -f storage/logs/laravel.log`

### For Testing with Real Emails (Recommended)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
# ... other Mailtrap credentials
```

### For Production
```env
MAIL_MAILER=mailgun  # or sendgrid, resend, etc.
# ... provider credentials
```

## Customization

### Change Code Expiration Time
Edit: `app/Models/PasswordResetCode.php` line 28
```php
'expires_at' => Carbon::now()->addMinutes(15), // Change 15 to your desired minutes
```

### Customize Email Template
Edit: `resources/views/emails/password-reset-code.blade.php`

### Change Email Subject
Edit: `app/Mail/PasswordResetCode.php` line 22
```php
subject: 'Your Password Reset Code', // Change this
```

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Emails not received | Check `.env` - ensure MAIL_MAILER is not 'log' |
| "Invalid credentials" | Verify API keys/passwords in `.env` are correct |
| "SMTP connection failed" | Check MAIL_HOST and MAIL_PORT are correct |
| Code expired | Codes last 15 min - regenerate by requesting new one |
| User not found | Ensure user exists in database with that email |

## Next Steps

1. ✅ Update `.env` with email configuration
2. ✅ Run `php artisan config:clear`
3. ✅ Test the password reset flow at `/forgot-password`
4. ✅ Check email for the 6-digit code
5. ✅ Complete the reset process
6. ✅ Login with new password

**That's it! Your password reset feature is ready to use!** 🎉

---

For more details, see:
- `PASSWORD_RESET_GUIDE.md` - Complete implementation guide
- `EMAIL_SETUP.md` - Detailed email provider setup
