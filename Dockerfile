# Use a imagem oficial do PHP com Apache
FROM php:8.3.6-apache

# Instale as extensões necessárias para Symfony
RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql zip

# Instale o Composer
COPY --from=composer:2.7.1 /usr/bin/composer /usr/bin/composer

# Configure o Apache para o Symfony
RUN a2enmod rewrite
COPY ./public /var/www/html

# Copie o restante do projeto
COPY . /var/www
WORKDIR /var/www

# Instale dependências do Symfony
RUN composer install --optimize-autoloader --no-dev

# Configuração de cache
RUN mkdir -p var/cache var/log && chown -R www-data:www-data var

# Porta padrão do Symfony
EXPOSE 8080

# Comando para iniciar o servidor
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
