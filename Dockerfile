# Use an official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PECL
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libssl-dev \
    pkg-config \
    && pecl install mongodb-2.0.0 \
    && docker-php-ext-enable mongodb \
    && apt-get purge -y libssl-dev pkg-config \
    && apt-get autoremove -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . /var/www/html/

# Install PHP dependencies with Composer
RUN composer install

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html
