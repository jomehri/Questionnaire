FROM php:7.4-fpm-alpine

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS autoconf  libtool

RUN apk add --no-cache zip libzip-dev

RUN apk --update --no-cache add pcre-dev ${PHPIZE_DEPS} \
    autoconf \
    g++ \
    make \
    libxml2-dev \
    wget \
    php-soap \
    supervisor \
    freetype-dev \
    ca-certificates \
    git \
    freetds-dev \
    unixodbc-dev \
    openssh

RUN apk --update --no-cache add unixodbc;

RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring tokenizer zip gd pdo_dblib bcmath pcntl

RUN pecl channel-update pecl.php.net \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del pcre-dev ${PHPIZE_DEPS}

RUN mkdir -p /var/www && \
    mkdir -p /var/www/html

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php composer-setup.php && \
	mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Change current user to www
USER www-data
