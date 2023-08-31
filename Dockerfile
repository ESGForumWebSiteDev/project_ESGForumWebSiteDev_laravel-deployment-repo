FROM bitnami/laravel:10-debian-11

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

RUN composer install

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "9000"]