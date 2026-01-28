# 🔐 Gmail App Password Required

## ⚠️ Current Issue

Gmail is rejecting your password because you're using your **regular Gmail password**. 

**Error:**
```
Username and Password not accepted. For more information, go to
https://support.google.com/mail/?p=BadCredentials
```

---

## ✅ Solution: Create a Gmail App Password

Gmail requires a special **App Password** for SMTP authentication. Here's how to get it:

### Step 1: Enable 2-Step Verification

1. Go to your **Google Account**: https://myaccount.google.com/
2. Click **Security** (left sidebar)
3. Find **2-Step Verification** and click it
4. Follow the prompts to enable it (you'll need your phone)

### Step 2: Generate App Password

1. After enabling 2-Step Verification, go back to **Security**
2. Click **App passwords** (you might need to scroll down)
   - Direct link: https://myaccount.google.com/apppasswords
3. Select **Mail** as the app
4. Select **Windows Computer** as the device
5. Click **Generate**
6. **Copy the 16-character password** (looks like: `abcd efgh ijkl mnop`)

### Step 3: Update Your .env File

Replace your current password with the App Password:

1. Open `.env` file
2. Find this line:
   ```env
   MAIL_PASSWORD=673176872As@#
   ```
3. Replace with your new App Password (remove spaces):
   ```env
   MAIL_PASSWORD=abcdefghijklmnop
   ```

### Step 4: Clear Config Cache

Run this command:
```bash
php artisan config:clear
```

---

## 🚀 Quick Alternative: Use Mailtrap (Recommended for Development)

If you don't want to deal with Gmail App Passwords, use **Mailtrap** instead:

### 1. Sign Up (Free)
- Go to: https://mailtrap.io/
- Create a free account

### 2. Get Credentials
- Click on your inbox
- Copy the SMTP credentials

### 3. Update .env
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@eventmaster.com"
MAIL_FROM_NAME="EventMaster"
```

### 4. Clear Cache
```bash
php artisan config:clear
```

---

## 📧 After Setup

Once you've updated your password, test again:

1. Visit: http://localhost:8000/forgot-password
2. Enter your email
3. Click "Send Reset Code"
4. ✅ Success! Check your inbox

---

## 💡 Why This Happens

Google disabled "less secure apps" access in May 2022. Now you **must** use:
- App Passwords (if 2-Step Verification is enabled), OR
- OAuth2 (complex setup), OR
- A third-party service like Mailtrap

---

## 🎯 My Recommendation

For **development/testing**: Use **Mailtrap** (easier, no Gmail setup needed)

For **production**: Use **SendGrid** or **Mailgun** (more reliable, free tier available)

---

## ❓ Need Help?

If you continue having issues:
1. Check `storage/logs/laravel.log` for errors
2. Make sure 2-Step Verification is enabled
3. Make sure you copied the App Password correctly (no spaces)
4. Clear config cache after every .env change

---

**Let me know which option you prefer, and I can help you set it up!** 🚀
