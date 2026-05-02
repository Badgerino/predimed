FROM php:8.2-apache

# Install build dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) intl mysqli pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite headers

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Install PHP dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --no-dev 2>/dev/null || true

# Create VirtualHost config pointing to public folder using printf
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    ServerAdmin webmaster@localhost' \
    '    DocumentRoot /var/www/html/public' \
    '    <Directory /var/www/html/public>' \
    '        Options -Indexes +FollowSymLinks' \
    '        AllowOverride All' \
    '        Require all granted' \
    '        <IfModule mod_rewrite.c>' \
    '            RewriteEngine On' \
    '            RewriteBase /' \
    '            RewriteCond %{REQUEST_FILENAME} !-f' \
    '            RewriteCond %{REQUEST_FILENAME} !-d' \
    '            RewriteRule ^(.*)$ index.php/$1 [L]' \
    '        </IfModule>' \
    '    </Directory>' \
    '    <Directory /var/www/html>' \
    '        Require all denied' \
    '    </Directory>' \
    '    ErrorLog ${APACHE_LOG_DIR}/error.log' \
    '    CustomLog ${APACHE_LOG_DIR}/access.log combined' \
    '</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Set permissions to allow www-data to read volume-mounted files
RUN find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    chmod 777 /var/www/html/writable && \
    find /var/www/html/writable -type d -exec chmod 777 {} \; && \
    find /var/www/html/writable -type f -exec chmod 666 {} \;

EXPOSE 80

CMD ["apache2-foreground"]
