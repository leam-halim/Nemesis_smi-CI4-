FROM php:8.2-apache

# 1. Install ekstensi PHP yang dibutuhkan CI4 & library pendukung
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mysqli pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Perbaikan Error MPM: Pastikan hanya mpm_prefork yang aktif
RUN a2dismod mpm_event && a2enmod mpm_prefork

# 3. Aktifkan Apache mod_rewrite
RUN a2enmod rewrite

# 4. Ubah Document Root Apache ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Copy semua file project
COPY . /var/www/html

# 6. Install composer dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 7. Set permission untuk folder writable
RUN chown -R www-data:www-data /var/www/html/writable && chmod -R 777 /var/www/html/writable

# 8. Sesuaikan Port Apache dengan variable $PORT dari Railway secara aman
RUN sed -i "s/Listen 80/Listen \${PORT}/g" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost \*:80>/<VirtualHost *:\${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# 9. Jalankan Apache
CMD ["apache2-foreground"]

