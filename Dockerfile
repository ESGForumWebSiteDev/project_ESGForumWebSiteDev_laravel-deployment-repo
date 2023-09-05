FROM bitnami/laravel:10-debian-11

WORKDIR /app

COPY . .

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip

RUN composer install --no-dev --no-interaction --optimize-autoloader

RUN composer dump-autoload --optimize

CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "9000"]