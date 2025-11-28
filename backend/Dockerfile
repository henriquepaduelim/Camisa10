FROM php:8.2-apache

# Dependências do sistema (inclui libpq-dev para pdo_pgsql)
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libonig-dev libzip-dev zip libpng-dev \
    libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl gd zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader \
 && npm install \
 && npm run build \
 && php artisan storage:link || true \
 && php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 80
CMD ["apache2-foreground"]
