FROM php:8.3-fpm

# PHP kengaytmalari
RUN docker-php-ext-install pdo pdo_mysql

# Composer o‘rnatish
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Loyihani yuklash
WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

CMD ["php-fpm"]
