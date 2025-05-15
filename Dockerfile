FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

CMD ["php-fpm"]