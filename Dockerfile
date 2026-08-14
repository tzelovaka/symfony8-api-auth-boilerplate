FROM dunglas/frankenphp:1-php8.4-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

RUN install-php-extensions \
    intl \
    pdo_pgsql \
    redis \
    amqp-stable \
    mongodb-stable

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV FRANKENPHP_CONFIG="worker ./public/index.php"

WORKDIR /app

