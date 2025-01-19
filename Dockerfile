# Base PHP 8.3 com Apache
FROM php:8.3-apache

# Instale dependências necessárias
RUN apt-get update && apt-get install -y \
    libicu-dev libpq-dev libzip-dev unzip git \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql zip

# Instale o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crie o diretório de trabalho e ajuste permissões
WORKDIR /var/www
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Copie os arquivos do projeto para o container
COPY . /var/www

# Ajuste permissões para o diretório do projeto
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Configure variáveis de ambiente obrigatórias
ENV APP_ENV=dev

# Instale dependências do Composer como o usuário padrão (www-data)
USER www-data
RUN composer install

# Configure cache e assets
RUN php bin/console assets:install public

# Exponha a porta 8080
EXPOSE 8080

# Comando inicial do container
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
