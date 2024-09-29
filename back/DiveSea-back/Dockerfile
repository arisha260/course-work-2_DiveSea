# Используем стабильный PHP образ
FROM php:8.2-fpm
LABEL authors="PC"

# Установка зависимостей PHP и дополнительных пакетов
RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

# Установка зависимостей Laravel
RUN composer install

CMD ["php-fpm"]

# Открываем порт для PHP-FPM
EXPOSE 9000
