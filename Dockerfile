FROM php:8.1.3-cli

RUN apt-get update && apt-get upgrade -y \
    git \
    libzip-dev \
    unzip

COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions ffi mbstring

RUN mkdir /app
RUN groupadd -r php-user && useradd -m -g php-user php-user
RUN chown -R php-user /app

COPY . /app

USER php-user

WORKDIR /app

RUN composer install
