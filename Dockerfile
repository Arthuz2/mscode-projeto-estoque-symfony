# Base: PHP 8.3 com Apache
FROM php:8.3-apache

# Instale dependências necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql zip

# Instale o Composer 2.7.1
COPY --from=composer:2.7.1 /usr/bin/composer /usr/bin/composer

# Crie um usuário não-root para evitar problemas de permissões
RUN useradd -ms /bin/bash symfony
USER symfony
WORKDIR /var/www

# Copie os arquivos do projeto para o container
COPY . /var/www

# Instale dependências do Symfony com Composer
RUN composer install --optimize-autoloader --no-dev

# Configure cache e assets
RUN php bin/console cache:clear --env=prod
RUN php bin/console assets:install public

# Expor a porta 8080
EXPOSE 8080

# Inicie o servidor embutido do PHP
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
