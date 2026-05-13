FROM php:8.2-apache

# 1. Install ekstensi PHP yang dibutuhkan CI4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mysqli pdo_mysql zip gd

# 2. Aktifkan Apache mod_rewrite untuk URL CI4 (menghilangkan index.php)
RUN a2enmod rewrite

# 3. Ubah Document Root Apache ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Copy semua file project
COPY . /var/www/html

# 5. Install composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 6. Set permission untuk folder writable
RUN chown -R www-data:www-data /var/www/html/writable && chmod -R 777 /var/www/html/writable

# 7. Sesuaikan Port Apache dengan variable $PORT dari Railway
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# 8. Jalankan Apache
CMD ["apache2-foreground"]
