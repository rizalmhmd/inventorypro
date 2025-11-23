# Multi-stage Dockerfile for Laravel + Vite

# 1) Build frontend assets with Node
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci --silent || npm install --silent
COPY . .
RUN npm run build

# 2) Install PHP dependencies with composer
FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
COPY . .
RUN composer dump-autoload --optimize

# 3) Final image (php-fpm + nginx)
FROM php:8.2-fpm-alpine
RUN apk add --no-cache nginx bash shadow sudo libpng-dev libzip-dev oniguruma-dev git curl build-base autoconf zip zlib-dev
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

WORKDIR /var/www/html

# Copy application code and vendor
COPY --from=composer_builder /app /var/www/html

# Copy built assets
COPY --from=node_builder /app/public/build /var/www/html/public/build

# Copy nginx config and start script
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

EXPOSE 80
CMD ["/start.sh"]
