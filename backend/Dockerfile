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

# Define o DocumentRoot para a pasta public do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}/../!g' /etc/apache2/apache2.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN printf "\n<Directory /var/www/html/public>\n    AllowOverride All\n    DirectoryIndex index.php\n</Directory>\n" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . .
RUN chown -R www-data:www-data storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader \
 && npm install \
 && npm run build \
 && php artisan storage:link || true \
 && php artisan config:clear && php artisan route:clear && php artisan view:clear


EXPOSE 80
CMD ["bash", "-lc", "php artisan migrate --force && apache2-foreground"]
