FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    zip \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install pgsql \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN a2enmod rewrite

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

# Ajuster les permissions avant l'installation de Composer
RUN mkdir -p /var/www/html/var/log /var/www/html/var/cache \
    && chown -R www-data:www-data /var/www/html/var \
    && chmod -R 777 /var/www/html/var/log /var/www/html/var/cache

COPY . .

# Installer les dépendances Composer après avoir copié tous les fichiers
RUN composer install

# Ajuster les permissions après l'installation
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/vendor \
    && chmod -R 777 /var/www/html/var

# Nettoyer le cache Symfony
RUN php bin/console cache:clear --no-warmup

# Regénérer l'autoload optimisé
RUN composer require nelmio/cors-bundle
RUN composer dump-autoload --optimize
RUN chown -R www-data:www-data /var/www/html/var/log /var/www/html/var/cache


EXPOSE 80

# Lancer Apache au démarrage du conteneur
CMD ["apache2-foreground"]
