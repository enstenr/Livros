# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libssl-dev \
    pkg-config \
    && pecl install mongodb-2.0.0 \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && apt-get purge -y libssl-dev pkg-config \
    && apt-get autoremove -y && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy composer.json first and install dependencies
COPY composer.json ./
RUN composer install --prefer-dist --no-interaction --no-scripts --no-progress

# Copy the rest of the app
COPY . .

# Set safe Git config (fixes "dubious ownership" warnings)
RUN git config --global --add safe.directory /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
