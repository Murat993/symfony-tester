FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    wget \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html

COPY . /var/www/html

RUN set -eux; \
    mkdir -p var/cache var/log; \
    composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader; \
    composer clear-cache

RUN chown -R www-data:www-data var public

EXPOSE 9000

CMD ["php-fpm"]
