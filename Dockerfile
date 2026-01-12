FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install mysqli

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy project to web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
