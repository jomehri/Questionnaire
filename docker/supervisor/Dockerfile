FROM php:8.1.0-fpm

RUN apt-get update && apt-get install -y supervisor

RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-enable pcntl

WORKDIR /var/www/html

COPY . .

CMD ["/usr/bin/supervisord"]