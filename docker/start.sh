#!/bin/sh
set -e

# Ensure permissions
chown -R www-data:www-data storage bootstrap/cache || true

# Generate APP_KEY if missing
if [ -z "$APP_KEY" ]; then
  php artisan key:generate || true
fi

# Optional automatic migrations
if [ "$MIGRATE_ON_START" = "true" ]; then
  php artisan migrate --force || true
fi

# Clear and cache config for production
php artisan config:clear || true
php artisan route:cache || true || true

# Start php-fpm and nginx
php-fpm -F &
nginx -g 'daemon off;'
