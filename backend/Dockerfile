# Use the official PHP 8.1 image as the base
FROM php:8.1-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libhiredis-dev \
    cron \
    vim

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy only the composer files to a temporary directory
#COPY composer.json ./

# Install project dependencies
#RUN composer install --optimize-autoloader --no-dev

# Copy the entire project to the working directory
COPY ./storage ./storage
COPY ./bootstrap/cache ./bootstrap/cache
COPY ./crontab/cron /etc/cron.d/container_cronjob

# Set permissions for Laravel directories
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# Generate the Laravel application key
#RUN php artisan key:generate

# Set the command to run when the container starts
#CMD php artisan serve --host=0.0.0.0
#ENTRYPOINT ./start.sh
# Expose port 8000
EXPOSE 8000
