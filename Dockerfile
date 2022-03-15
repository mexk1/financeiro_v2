FROM php:8.1

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD . /app

WORKDIR /app

RUN rm .env

EXPOSE 8080
ENTRYPOINT [ "/bin/bash", "/app/entrypoint.sh" ]
