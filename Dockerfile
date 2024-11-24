# Imagem base do Laravel com PHP e Composer
FROM php:8.3-fpm

# Instala extensões necessárias para Laravel e SQLite
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# Instala Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do projeto para o container
COPY . .

# Instala dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Define as permissões corretas para o storage e o cache do Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Define o comando padrão para o container
CMD ["php-fpm"]

# Expõe a porta padrão do PHP-FPM
EXPOSE 9000
