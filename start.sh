#!/bin/bash
# Railway deployment script

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --no-interaction
fi

# Clear and cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Start the application
php artisan serve --host=0.0.0.0 --port=$PORT