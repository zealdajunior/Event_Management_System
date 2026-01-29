#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate app key if needed
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Cache configurations
php artisan config:cache
php artisan route:cache

# Start the server
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}