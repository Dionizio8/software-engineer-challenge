FROM php:7.4-fpm

# Installing dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    locales \
    zip \
    libonig-dev \
    jpegoptim optipng pngquant gifsicle

# Installing extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl bcmath opcache mysqli

# Installing composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Setting locales
RUN echo fr_FR.UTF-8 UTF-8 > /etc/locale.gen && locale-gen

