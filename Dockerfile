FROM php:8.2-apache

# 1. Install ekstensi PHP & library pendukung
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    zip \
    unzip \
    && docker-php-ext-install intl mysqli pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. FIX PERMANEN: Hapus paksa konfigurasi MPM lain agar tidak bentrok
RUN rm -f /etc/apache2/mods-enabled/mpm_event.load /etc/apache2/mods-enabled/mpm_event.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_worker.load /etc/apache2/mods-enabled/mpm_worker.conf \
    && a2enmod mpm_prefork rewrite

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

# 7. Sesuaikan Port Apache (Railway dynamic port)
RUN sed -i "s/Listen 80/Listen \${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/<VirtualHost \*:80>/<VirtualHost *:\${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# 8. Jalankan Apache
CMD ["apache2-foreground"]


