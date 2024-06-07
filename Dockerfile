FROM php:8.3-fpm

RUN apt-get update && apt-get upgrade -y &&  \
    apt-get install -y libonig-dev && \
    docker-php-ext-install pdo pdo_mysql exif && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
