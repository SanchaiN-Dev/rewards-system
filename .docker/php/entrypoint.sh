#!/bin/bash

# Run Composer install
composer install

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm
