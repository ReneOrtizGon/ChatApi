# Install the base image
FROM dunglas/frankenphp:php8.4.3-alpine
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install the required extensions
RUN install-php-extensions curl dom fileinfo iconv mbstring opcache openssl pcntl pdo pdo_pgsql phar tokenizer session zip
# Set the working directory
WORKDIR /var/www
# Copy the files
COPY . .
# Install composer for development
RUN composer install
# Composer production
# RUN composer install --no-dev --optimize-autoloader
# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache
# Start the server
ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--workers=1", "--max-requests=1"]
