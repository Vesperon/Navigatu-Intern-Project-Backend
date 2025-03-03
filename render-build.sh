#!/usr/bin/env bash

# Install PHP and required extensions
apt-get update && apt-get install -y \
    php-cli php-mbstring php-xml php-bcmath php-tokenizer \
    php-curl php-zip php-pdo php-mysql unzip curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
composer install --no-dev --optimize-autoloader

# Set application key and run migrations
php artisan key:generate
php artisan migrate --force
