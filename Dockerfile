FROM php:8.3-fpm-alpine

RUN apk update \
    && apk add --no-cache \
        zlib-dev \
        git \
        icu-dev \
        libzip-dev \
        postgresql-dev \
        zip \
        autoconf \
        make \
        g++ \
        gcc \
        shadow \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql

RUN apk add --no-cache $PHPIZE_DEPS autoconf make gcc g++ \
    linux-headers \
    && pecl install xdebug pcov \
    && docker-php-ext-enable xdebug pcov

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/app

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN mkdir -p /var/www/app/storage /var/www/app/bootstrap/cache \
    && chown -R www-data:www-data /var/www/app \
    && chmod -R 775 /var/www/app/storage /var/www/app/bootstrap/cache

COPY --chown=www:www . /var/www

USER www

EXPOSE 9000
CMD ["php-fpm"]
