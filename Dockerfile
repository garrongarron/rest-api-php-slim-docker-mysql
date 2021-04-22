FROM php:fpm-stretch

RUN apt-get update 
RUN apt-get install -y --no-install-recommends \
    git \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    zip \
    intl \
    mysqli \
    pdo pdo_mysql 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version \

WORKDIR /var/www/html

# FROM php:7-fpm-alpine 

# RUN apk --no-cache update \
#     && apk --no-cache upgrade \
#     && apk add --no-cache php7-mysqli