FROM php:8.0-fpm-bullseye

RUN apt-get update && docker-php-ext-install pdo_mysql \
     && docker-php-ext-install bcmath

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /system-prototype