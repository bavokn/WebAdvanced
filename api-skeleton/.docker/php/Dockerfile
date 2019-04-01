FROM php:7.3-fpm

LABEL maintainer="Ghlen Nagels <ghlen@pm.me>"


# Global configuration & installation fase: configure everything needed to have the programs run effectively

RUN apt-get -yqq update \
    && apt-get install -yqq --no-install-recommends libzip-dev zip unzip libicu-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql opcache zip intl bcmath \
    && pecl install xdebug-2.7.0RC2 \
    && pecl install redis-4.2.0 \
    && docker-php-ext-enable xdebug redis

COPY .docker/composer-installer.sh .
RUN chmod +x composer-installer.sh \
    && bash composer-installer.sh \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer

COPY .docker/php/php.ini /usr/local/etc/php/php.ini
COPY .docker/php/conf.d/* /usr/local/etc/php/conf.d/

#apperently the home directory of www-data is not owned by www-data.. only $home/html is owned by www-data
RUN mkdir /var/www/logs $(eval echo "~www-data")/.composer \
    && chown www-data:www-data /var/www/logs $(eval echo "~www-data")/.composer

USER www-data:www-data

RUN composer global require hirak/prestissimo --no-plugins --no-scripts \
    && mkdir caching api


WORKDIR caching
COPY composer.json composer.loc[k] ./
RUN composer install \
        --no-interaction \
        --prefer-dist \
        --no-progress \
        --no-scripts \
        --profile \
        --no-autoloader

WORKDIR /var/www/html/api/
COPY --chown=www-data:www-data src/ src/
COPY --chown=www-data:www-data public/ public/
COPY --chown=www-data:www-data logs/ logs/
COPY --chown=www-data:www-data composer.json composer.loc[k] .env phpunit.xml phpunit-printer.yml ./

RUN composer install \
        --no-interaction \
        --prefer-dist \
        --no-progress \
        --no-scripts \
        --profile \
    && composer dumpautoload
