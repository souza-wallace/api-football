FROM php:8.3-fpm

WORKDIR /var/www

# ARG VAR

# RUN echo "VAR=$VAR" >> .env && \

# RUN cat .env

RUN ls

# dependências recomendadas de desenvolvido para ambiente linux
RUN apt-get update && apt-get install -y \
    apt-utils \
    supervisor \
    libzip-dev \
    unzip 

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer require flightphp/core

COPY . /var/www/
COPY ./docker/supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./docker/php/extra-php.ini "$PHP_INI_DIR/99_extra.ini"
COPY ./docker/php/extra-php-fpm.conf /etc/php8/php-fpm.d/www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

RUN rm -rf /usr/local/etc/php/php.ini-production
RUN rm -rf /usr/local/etc/php/php.ini-development
RUN ls -la /usr/local/etc/php

RUN cat /usr/local/etc/php/php.ini

RUN chown www-data:www-data /var/www

COPY --chown=www-data:www-data ./ .
RUN rm -rf vendor
RUN composer update
RUN composer install --no-interaction

RUN apt-get install nginx -y
RUN rm -rf /etc/nginx/sites-enabled/* && rm -rf /etc/nginx/sites-available/*
COPY ./docker/nginx/sites.conf /etc/nginx/sites-enabled/default.conf
COPY ./docker/nginx/error.html /var/www/html/error.html

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt update -y && apt install nano git -y

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]