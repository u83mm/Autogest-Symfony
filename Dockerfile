FROM php:8.2-apache

ARG TIMEZONE="Europe/Madrid"

ARG USER_ID=1000
ARG GROUP_ID=1000

# Arguments for the system user and group
ARG SYSTEM_USER="mario"
ARG SYSTEM_GROUP="mario"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini

# Asigna grupo y usuario en contenedor para no tener que estar cambiando propietario a los archivos creados desde el contenedor
RUN groupadd --gid ${GROUP_ID} mario && \
    useradd --uid ${USER_ID} --gid ${GROUP_ID} -m mario && \
    usermod -aG www-data mario

# Install system dependencies
RUN apt update && apt install -y libicu-dev \
    git unzip zlib1g-dev libpng-dev libjpeg-dev \ 
    libfreetype6-dev libwebp-dev && rm -rf /var/lib/apt/lists/*

# Configure GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

# Install Xdebug
RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

# Install PHP extensions Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo_mysql intl gd
RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

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

# Set permissions
RUN chown -R mario:mario /var/www && \
    chmod -R 755 /var/www

# Set working directory
WORKDIR /var/www

USER ${USER_ID}

# Copy application code (with proper ownership)
COPY --chown=mario:mario . .
