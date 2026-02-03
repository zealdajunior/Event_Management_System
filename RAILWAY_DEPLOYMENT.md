# 🚀 Deploy to Railway - Easy Steps

## Step 1: Create Railway Account
1. Go to https://railway.app
2. Click "Start a New Project"
3. Sign up with GitHub (free)

## Step 2: Connect Your Project
1. Click "New Project"
2. Select "Deploy from GitHub repo"
3. OR use "Empty Project" and deploy from local

## Step 3: Add MySQL Database
1. In your Railway project, click "+ New"
2. Select "Database" → "Add MySQL"
3. Railway will auto-create the database

## Step 4: Configure Environment Variables
In Railway dashboard, go to your app → Variables, add:

```
APP_NAME="Event Management System"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-app.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MYSQL_HOST}}
DB_PORT=${{MYSQL_PORT}}
DB_DATABASE=${{MYSQL_DATABASE}}
DB_USERNAME=${{MYSQL_USER}}
DB_PASSWORD=${{MYSQL_PASSWORD}}

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=zealdajunior4@gmail.com
MAIL_PASSWORD=your-gmail-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=zealdajunior4@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Step 5: Deploy
1. Railway will auto-detect Laravel
2. It will build and deploy automatically
3. You'll get a URL like: `https://your-app.railway.app`

## Alternative: Manual Deploy (No Git)

If you don't want to use Git:

### Use Railway CLI:
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Initialize
railway init

# Deploy
railway up
```

## 🎯 Your App Will Be Live!
After deployment, your app will be accessible at:
`https://your-app-name.railway.app`

## 💡 Free Tier:
- Railway gives you $5 free credit monthly
- Enough for small projects
- No credit card required initially

## Need Help?
Railway has excellent docs: https://docs.railway.app
