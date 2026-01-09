# === Dockerfile (Laravel + PHP 8.5 FPM) ===
# Multi-stage: first stage builds PHP app and Composer dependencies.
# Second stage (node-build) can be used to build frontend assets and copy them into final image for production.

# ---- Stage 1: PHP app ----
FROM php:8.5-fpm AS php-base

# Metadata / helpful labels
LABEL maintainer="you@example.com"
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

# Install system dependencies required for common PHP extensions and composer
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    ca-certificates \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    pkg-config \
    libssl-dev \
    zlib1g-dev \
    build-essential \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions commonly required by Laravel
# - pdo_sqlite for SQLite
# - gd for image operations
# - zip, bcmath, xml, intl, opcache
RUN docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
 && docker-php-ext-install -j$(nproc) pdo pdo_sqlite gd zip bcmath xml opcache \
 && pecl channel-update pecl.php.net || true

# Enable recommended PHP settings for development (can be adjusted for production)
RUN { \
        echo 'memory_limit=512M'; \
        echo 'display_errors=On'; \
    } > /usr/local/etc/php/conf.d/zz-custom.ini

# Install Composer (latest) - installed as /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (for caching)
COPY composer.json composer.lock ./

# Install PHP dependencies (dev included for development). Use preferred options.
RUN composer install --prefer-dist --no-interaction --no-progress --no-scripts || composer install --prefer-dist --no-interaction --no-progress

# Copy application code
COPY . .

# Ensure the SQLite database file exists (helpful for dev)
RUN mkdir -p database && touch database/database.sqlite && chmod -R 0777 database

# Run Laravel post-install scripts optionally (comment/uncomment as needed)
# RUN php artisan key:generate --ansi

# Expose a port for artisan serve (development)
EXPOSE 8000

# Default command for development:
# We use the built-in PHP server through artisan so we can access app via port 8000.
# For production you'd replace this with php-fpm + nginx.
CMD ["sh", "-c", "php artisan migrate --force || true; php artisan serve --host=0.0.0.0 --port=8000"]

# ---- Stage 2: node-build (optional, production asset build) ----
# If you prefer building assets inside the same Dockerfile for production, uncomment/enable the following stage.
# You can run: docker build --target=node-build -t my-app-with-assets .
#
# It uses a node image to install node_modules and run `npm run build` (Vite build),
# then copies the result to a new final image (not strictly required for dev compose).

FROM node:20 AS node-build
WORKDIR /build

# Copy package manifests first to leverage layer cache
COPY package*.json vite.config.* ./
# If you use pnpm/yarn, adapt accordingly

RUN npm ci --silent

# Copy app static source files (adjust path if your assets are under resources/js)
COPY resources resources
COPY public public

# Run production build (uses your package.json scripts)
RUN npm run build

# Example to copy built assets back to php image:
# From php-base, copy /build/dist (or your configured output) into public or resources as needed.
# This step is optional and scenario-dependent.

# ---- Final notes:
# - For development you can use the php-base image and run artisan serve (or configure nginx + php-fpm).
# - For production you'd likely want a separate nginx container and a production PHP image with built assets copied in.