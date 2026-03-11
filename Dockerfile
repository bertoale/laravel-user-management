FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . /var/www

# Set permission
RUN chown -R www-data:www-data /var/www

# Enable apache rewrite
RUN a2enmod rewrite

# Apache config
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80