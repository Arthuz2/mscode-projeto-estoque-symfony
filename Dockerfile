# Base PHP 8.3 com Apache
FROM php:8.3-apache

# Instale dependências necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql zip

# Instale o Composer
COPY --from=composer:2.7.1 /usr/bin/composer /usr/bin/composer

# Crie o usuário não-root
RUN useradd -ms /bin/bash symfony

# Ajuste permissões do diretório de trabalho
WORKDIR /var/www
RUN chown -R symfony:symfony /var/www && chmod -R 775 /var/www

# Trocar para o usuário criado
USER symfony

# Copie o código do projeto
COPY . /var/www

# Certifique-se de que o diretório `vendor` existe
RUN mkdir -p /var/www/vendor

# Instale dependências do Composer
RUN composer install --optimize-autoloader --no-dev

# Configure cache e assets
RUN php bin/console cache:clear --env=prod
RUN php bin/console assets:install public

# Exponha a porta 8080
EXPOSE 8080

# Comando inicial do container
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
