FROM php:8.2-fpm-alpine

WORKDIR /var/www/app

# rename php.ini
# if err static --> extended output and http code always 200, only for local development
RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# create user
RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

# xdebug install (in dev)
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add --update linux-headers \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

# install redis
RUN apk --no-cache add pcre-dev $PHPIZE_DEPS \
      && pecl install redis \
      && docker-php-ext-enable redis \
      && apk del pcre-dev $PHPIZE_DEPS \
      && rm -rf /tmp/pear

USER app
