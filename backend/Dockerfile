# backend/Dockerfile
FROM php:8.2-apache

# Dependências do sistema (PHP + Node para o build)
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libonig-dev libzip-dev zip libpng-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl gd zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia código
COPY . .

# Permissões básicas
RUN chown -R www-data:www-data storage bootstrap/cache

# Instala dependências e build frontend
RUN composer install --no-dev --optimize-autoloader \
 && npm install \
 && npm run build \
 && php artisan storage:link || true \
 && php artisan config:cache && php artisan route:cache && php artisan view:cache

# Apache já expõe porta 80
EXPOSE 80

CMD ["apache2-foreground"]
