FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-install gd zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
