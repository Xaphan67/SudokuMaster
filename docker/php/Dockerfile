FROM php:8.3-apache

# Dépendances système nécessaires pour compiler certaines extensions PHP + dézipper les paquets Composer
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Autorise le .htaccess de l'application
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>' > /etc/apache2/conf-available/z-app.conf \
    && a2enconf z-app

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY app/ /var/www/html/

RUN composer install --no-dev --optimize-autoloader
