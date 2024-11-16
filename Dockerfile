FROM php:8.2-apache

ARG TIMEZONE

ARG USER_ID=1000
ARG GROUP_ID=1000

COPY / /var/www/

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Asigna grupo y usuario en contenedor para no tener que estar cambiando propietario a los archivos creados desde el contenedor
RUN addgroup --gid ${GROUP_ID} mario
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid ${GROUP_ID} mario

# Install system dependencies
RUN apt update && apt install -y libicu-dev && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y git unzip zlib1g-dev libpng-dev

# Install PHP extensions Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo_mysql intl gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Symfony-cli
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

# Configure virtual host
RUN mv /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf.old
RUN mv /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf.old
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Set working directory
WORKDIR /var/www

USER 1000
