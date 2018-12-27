FROM php:5.6-apache
RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql mysqli

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install unzip
RUN apt-get install -y unzip