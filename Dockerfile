# Usar a imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache

# Habilitar as extensões necessárias para o projeto (PostgreSQL e cURL)
RUN docker-php-ext-install pdo pdo_pgsql curl

# Copiar os arquivos do projeto para o diretório do servidor web no container
COPY . /var/www/html/

# Habilitar o mod_rewrite do Apache para URLs amigáveis (boa prática)
RUN a2enmod rewrite

# Definir as permissões corretas para os arquivos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html