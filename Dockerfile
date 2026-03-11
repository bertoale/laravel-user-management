# ---------- Stage 1: Composer dependencies ----------
FROM composer:2 AS vendor

WORKDIR /app

# Copy composer files saja dulu (cache build lebih efisien)
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

# Copy seluruh project
COPY . .

# Generate optimized autoload
RUN composer dump-autoload --optimize


# ---------- Stage 2: PHP + Apache runtime ----------
FROM php:8.2-apache-alpine

# Install dependencies yang dibutuhkan Laravel
RUN apk add --no-cache \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    zip \
    unzip \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        exif \
        bcmath \
        gd

# Enable Apache rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project dari stage vendor
COPY --from=vendor /app /var/www/html

# Set permission Laravel
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    && chmod -R 775 \
    storage \
    bootstrap/cache

# Apache config untuk Laravel public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/httpd.conf

EXPOSE 80

CMD ["httpd-foreground"]