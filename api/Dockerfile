FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libzip-dev \
    # Explicitly install libzip for zip extension\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip \
    && docker-php-ext-enable zip

# Set the working directory
WORKDIR /var/www/html

# Copy Composer from the official composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the composer.json file
COPY ./composer.json /var/www/html/composer.json

# Copy the PHP source files
COPY ./src /var/www/html

# Install Composer dependencies
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Expose port 8000 and start the PHP built-in server
CMD php -S 0.0.0.0:8000
