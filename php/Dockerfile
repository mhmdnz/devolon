FROM php:7.4-fpm-alpine

WORKDIR /var/www/html/devolon

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add composer

RUN apk add autoconf

RUN apk --update add gcc make g++ zlib-dev

RUN pecl install redis \
    && docker-php-ext-enable redis \
    && apk add curl openrc

ADD FreshMigrations.sh /tmp/FreshMigrations.sh
RUN chmod 777 /tmp/FreshMigrations.sh

ADD RunTests.sh /tmp/RunTests.sh
RUN chmod 777 /tmp/RunTests.sh

ADD Prepration.sh /tmp/Prepration.sh
RUN chmod 777 /tmp/Prepration.sh

ADD ComposerInstall.sh /tmp/ComposerInstall.sh
RUN chmod 777 /tmp/ComposerInstall.sh
