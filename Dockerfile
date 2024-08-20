FROM php:7.3.14

RUN apt-get update \
     && apt-get install -y git libzip-dev

RUN docker-php-ext-install zip bcmath
