# 1. Base image PHP + Apache
FROM php:8.2-apache

# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 3. Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www

# 6. Copy project files
COPY . /var/www

# 7. Install Composer dependencies (production)
RUN composer install --no-dev --optimize-autoloader

# 8. Set permissions Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 9. Enable Apache rewrite
RUN a2enmod rewrite

# 10. Apache config: point to Laravel public
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# 11. Expose port
EXPOSE 80

# 12. Start Apache in foreground
CMD ["apache2-foreground"]