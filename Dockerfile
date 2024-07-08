# syntax=docker/dockerfile:1.4

# Stage 0, based on the official PHP image, add composer and Symfony CLI
FROM php:8.2-fpm AS app_base

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    zip \
    vim \
    wget \
    gnupg \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . .

# Install Symfony dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
