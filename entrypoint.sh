#!/usr/bin/env bash
set -e

# Ajusta o Apache para escutar na porta fornecida pelo Render/ambiente.
PORT="${PORT:-80}"
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/:80>/:${PORT}>/" /etc/apache2/sites-enabled/000-default.conf

# Garante que as migrations rodem antes de subir o servidor.
php artisan migrate --force

# Inicia o Apache em primeiro plano.
exec apache2-foreground
