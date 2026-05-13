FROM php:8.2-cli

# 1. Install ekstensi PHP & library pendukung
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mysqli pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Copy semua file project
COPY . /var/www/html
WORKDIR /var/www/html

# 3. Install composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 4. Set permission untuk folder writable
RUN chown -R www-data:www-data /var/www/html/writable && chmod -R 777 /var/www/html/writable

# 5. Jalankan server bawaan CodeIgniter 4
# Kita gunakan variable $PORT yang diberikan oleh Railway secara dinamis
CMD ["sh", "-c", "php spark serve --host 0.0.0.0 --port ${PORT:-8080}"]
