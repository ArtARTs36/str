FROM php:7.3-alpine

RUN apk add --update git zip gcc libc-dev autoconf make && rm -rf /var/cache/apk/*

RUN pecl install pcov && docker-php-ext-enable pcov

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

WORKDIR /app
