FROM php:7.4-fpm

RUN apt-get update
RUN apt-get install -y \
        mc\
        libzip-dev \
        zip \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-configure pdo_mysql \
        && docker-php-ext-configure intl \
        && docker-php-ext-install intl \
        && docker-php-ext-configure zip \
        && docker-php-ext-install zip

WORKDIR /symfony
