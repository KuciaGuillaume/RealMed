FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    zip \
    postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql pgsql intl mbstring zip

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload --optimize

# Créer les répertoires nécessaires et ajuster les permissions pour www-data
RUN mkdir -p /var/www/html/var/cache /var/www/html/var/log \
    && chown -R www-data:www-data /var/www/html/var /var/www/html/vendor \
    && chmod -R 775 /var/www/html/var

EXPOSE 80

CMD ["apache2-foreground"]
