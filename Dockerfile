# Use an official PHP image with Apache
FROM php:7.4-apache

# Enable PDO and PDO_MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy application code into the container
COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

