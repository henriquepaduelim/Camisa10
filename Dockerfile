# Use a imagem base do PHP 8.2 com Apache
FROM php:8.2-apache

# Instala dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libonig-dev libzip-dev zip libpng-dev \
    libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_mysql pdo_pgsql intl gd zip \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia todo o contexto do projeto para o contêiner
COPY . /var/www/html

# Define o diretório de trabalho para a raiz do projeto Laravel
WORKDIR /var/www/html/backend

# Remove hotfile do Vite (evita apontar para dev server em produção)
RUN rm -f public/hot

# Configura o Apache para apontar para a pasta public do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/backend/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
 && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}/../!g' /etc/apache2/apache2.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN printf "\n<Directory /var/www/html/backend/public>\n    AllowOverride All\n    DirectoryIndex index.php\n</Directory>\n" >> /etc/apache2/apache2.conf

# Define as permissões corretas para as pastas do Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Instala dependências, compila assets e otimiza a aplicação
RUN composer install --no-dev --optimize-autoloader \
 && npm install \
 && npm run build \
 && php artisan adminlte:install --only=assets --force || true \
 && php artisan storage:link || true \
 && php artisan config:clear && php artisan route:clear && php artisan view:clear
RUN chmod -R 775 storage bootstrap/cache

# Expõe a porta 80, que o Apache usa
EXPOSE 80

# Comando de inicialização: executa migrações e inicia o Apache
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
