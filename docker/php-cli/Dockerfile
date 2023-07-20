FROM php:8.2-cli-alpine

WORKDIR /var/www/app

COPY composer.json /var/www/app

# composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN composer install --no-dev --ignore-platform-reqs --no-scripts
