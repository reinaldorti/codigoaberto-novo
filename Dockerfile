FROM php:8.3-apache

LABEL maintainer="Carlos da Paixão"

ARG NODE_VERSION=20

# COPY ./config/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN docker-php-ext-install pdo
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update && \
    apt-get install -y \
    libicu-dev\
    libzip-dev\
    libpng-dev\
    libonig-dev\
    zlib1g-dev\
    libcap2-bin  \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install intl

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    openssl

RUN apt-get update && \
    apt-get install -y \
    zlib1g-dev libicu-dev

RUN apt-get update -y \
    && apt-get install -y \
    git\
    curl\
    nano\
    zip\
    wget\
    # python2
   && apt-get clean -y \
#
RUN apt-get install -y unzip\
       openssl\
RUN docker-php-ext-install -j$(nproc) gd; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j$(nproc) intl
#
## Install PHP extensions
RUN  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install xdebug  \
    && docker-php-ext-enable xdebug \
    && echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.remote_host=host.docker.internal' >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo 'xdebug.remote_port=9000' >>  /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update \
    && apt-get install -y \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-install -j$(nproc) \
    gd \
    && apt-get purge -y \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev

RUN apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd bcmath

RUN curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt update \
    && apt install yarn -y
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN docker-php-ext-install mysqli && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install gettext && \
    docker-php-ext-install calendar
RUN docker-php-ext-install exif

# Install Freetype
RUN apt-get -y update && \
    # apt-get --no-install-recommends install -y libfreetype6-dev \
    # libjpeg62-turbo-dev \
    # libpng-dev \
    # && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd
RUN docker-php-ext-install zip

RUN docker-php-ext-install exif
# RUN apt-get update && apt-get install -y yarn
RUN docker-php-ext-enable pdo_mysql bcmath gd intl
# # Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite && service apache2 restart