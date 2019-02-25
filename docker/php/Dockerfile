FROM php:7.0.30-fpm

RUN \
 apt-get update && \
 apt-get install -y vim git curl zip unzip

# Install composer system-wide
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer && \
    chown www-data:www-data /usr/local/bin/composer

# Setup environment
ENV DEV=1
RUN mkdir -p /var/www/game_of_life
RUN chmod -R 755 /var/www/game_of_life

WORKDIR /var/www/game_of_life
