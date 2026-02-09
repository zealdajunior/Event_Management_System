# 🚀 Deploy to Render - FREE Hosting

## Step 1: Create Render Account
1. Go to: **https://render.com**
2. Click **"Get Started"** 
3. Sign up with your **GitHub account** (FREE - no credit card needed!)

## Step 2: Deploy Your App
1. Once logged in, click **"New +"** → **"Web Service"**
2. Click **"Connect GitHub"** and authorize Render
3. Select **"Event_Management_System"** repository
4. Render will auto-detect your Laravel app!

## Step 3: Configure Settings
Fill in these details:

**Name:** `event-management-system`  
**Region:** Choose closest to you  
**Branch:** `main`  
**Root Directory:** Leave blank  
**Runtime:** `PHP`  
**Build Command:**
```bash
composer install --no-dev --optimize-autoloader && npm install && npm run build && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Start Command:**
```bash
php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

**Plan:** Select **FREE**

## Step 4: Add MySQL Database
1. Click **"New +"** → **"PostgreSQL"** (free)
   OR
2. Use **PlanetScale** MySQL (also free):
   - Go to https://planetscale.com
   - Create free database
   - Copy connection string

## Step 5: Set Environment Variables
In Render dashboard → Your service → **"Environment"**, add:

```
APP_KEY=base64:F+4L1u6Zc2aTvaBjBVxUDnyu5Rs6+Xk3fPBEeshSeLs=
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.onrender.com

DB_CONNECTION=mysql
DB_HOST=your-database-host
DB_PORT=3306
DB_DATABASE=event_management
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=zealdajunior4@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## Step 6: Deploy!
Click **"Create Web Service"**

Your app will be live at: `https://your-app-name.onrender.com`

## ✅ What You Get FREE:
- ✅ 750 hours/month (enough for 24/7)
- ✅ Auto-deploy from GitHub
- ✅ Free SSL certificate
- ✅ Custom domain support
- ✅ No credit card required
- ✅ Spins down after 15 min of inactivity (free tier)

## Alternative: InfinityFree (Even Easier!)
If Render doesn't work, try **InfinityFree**:

1. Go to: **https://infinityfree.net**
2. Sign up (100% free forever)
3. Create account
4. Upload your files via FTP or use their File Manager
5. Import your database
6. Done!

**InfinityFree Features:**
- ✅ Unlimited bandwidth
- ✅ Unlimited disk space
- ✅ Free MySQL databases
- ✅ PHP 8.x support
- ✅ No ads
- ✅ Free subdomain or use your own
