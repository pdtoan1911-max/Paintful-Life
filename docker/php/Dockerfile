# ======================
# Stage 1: Build Vite
# ======================
FROM node:20-alpine AS node

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build


# ======================
# Stage 2: PHP
# ======================
FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Copy Vite build từ stage node
COPY --from=node /app/public/build /var/www/public/build

RUN composer install --no-interaction --prefer-dist

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache
