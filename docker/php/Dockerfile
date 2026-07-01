FROM php:8.4-fpm

# 필요한 패키지 설치
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# PHP 확장 설치
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 업로드 한도 설정 추가
COPY docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Composer 설치
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 작업 디렉토리
WORKDIR /var/www/html

# 권한 설정
RUN chown -R www-data:www-data /var/www/html