# PHP 8.2 asosida image
FROM php:8.1-cli


# MySQL va boshqa kerakli extensionlarni o‘rnatish
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Composer o‘rnatish
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Loyiha fayllarini konteynerga ko‘chirish
WORKDIR /app
COPY . .

# Composer install
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizatsiyasi
RUN php artisan config:cache
RUN php artisan route:cache

# Web serverni ishga tushirish
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
