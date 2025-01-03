# Gunakan base image PHP dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-fpm

# Instal dependencies sistem
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    supervisor \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip

# Instal Node.js dan NPM
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy aplikasi Laravel ke dalam Docker container
COPY . /var/www

# Instal dependencies aplikasi
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run production

# Set permissions untuk Laravel storage dan cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Copy file konfigurasi Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Expose port Laravel
EXPOSE 8000

# Set Supervisor sebagai entrypoint
CMD ["/usr/bin/supervisord"]
