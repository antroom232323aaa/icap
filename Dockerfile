FROM php:8.2-apache

# 安裝 Laravel 所需套件
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    ca-certificates \
    libsqlite3-dev \
    libzip-dev \
    libonig-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install \
    pdo_sqlite \
    mbstring \
    bcmath \
    zip \
    && rm -rf /var/lib/apt/lists/*

# 啟用 Apache rewrite
RUN a2enmod rewrite

# Laravel 使用 public 作為網站根目錄
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 複製專案
COPY . .

# 安裝 PHP 套件
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# 安裝前端套件並建立 Vite
RUN npm install && npm run build

# Laravel 權限
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache \
    database

# Apache 對外服務
EXPOSE 80

CMD ["sh", "-c", "php artisan optimize:clear && apache2-foreground"]