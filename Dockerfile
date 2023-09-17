FROM composer:2 AS get-composer
FROM php:8.2-apache

RUN apt-get update \
 && apt-get install -y git libzip-dev libicu-dev \
 && docker-php-ext-install zip \
 && docker-php-ext-configure intl \
 && docker-php-ext-install intl \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

# Configurazione Xdebug
RUN pecl install xdebug \
   && docker-php-ext-enable xdebug \
   && echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
   && echo "xdebug.client_host = host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=get-composer /usr/bin/composer /usr/local/bin/composer



WORKDIR /var/www
