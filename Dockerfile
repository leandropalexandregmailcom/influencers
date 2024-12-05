FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Copy the application files
COPY . .

# Install dependencies via Composer
RUN composer install

# Expose the port for PHP-FPM
EXPOSE 9000

# Entrypoint to ensure that the necessary PHP-FPM service is started
CMD ["php-fpm"]
