FROM php:7.3-fpm

RUN docker-php-ext-install pdo_mysql
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install -j$(nproc) pdo

RUN apt-get install -y nginx  supervisor && \
    rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
WORKDIR /var/www/html

RUN rm /etc/nginx/sites-enabled/default

COPY /docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf

ADD https://getcomposer.org/download/2.0.8/composer.phar /usr/bin/composer
RUN chmod +rx /usr/bin/composer

RUN composer install

RUN cp .env.example .env
RUN php artisan key:generate

RUN chmod +x ./entrypoint

ENTRYPOINT ["./entrypoint"]

EXPOSE 80
