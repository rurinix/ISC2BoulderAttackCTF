FROM php:8.3-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS \
    && docker-php-ext-install mysqli \
    && apk del $PHPIZE_DEPS