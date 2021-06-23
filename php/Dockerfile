FROM php:8.0.2-fpm-alpine

WORKDIR /var/www/html/devolon

RUN docker-php-ext-install pdo pdo_mysql

RUN apk add composer

ADD FreshMigrations.sh /tmp/FreshMigrations.sh

ADD RunTests.sh /tmp/RunTests.sh

ADD Prepration.sh /tmp/Prepration.sh

ADD ComposerInstall.sh /tmp/ComposerInstall.sh
