# Usar a imagem oficial do PHP com o servidor Apache
FROM php:8.2-apache

# Instalar as dependências do sistema e configurar as extensões PHP em um único passo para otimizar
RUN apt-get update && apt-get install -y \
        libpq-dev \
        libcurl4-openssl-dev \
        libzip-dev \
        unzip \
    && rm -rf /var/lib/apt/lists/* \
    # --- INÍCIO DA CORREÇÃO ADICIONAL ---
    # Configura a extensão pgsql, dizendo onde encontrar as ferramentas do PostgreSQL
    && docker-php-ext-configure pgsql -with-pgsql=/usr/include/postgresql \
    # --- FIM DA CORREÇÃO ADICIONAL ---
    # Agora, instala as extensões. O -j$(nproc) acelera o processo.
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql curl zip

# Copiar os arquivos do projeto para o diretório do servidor web no container
COPY . /var/www/html/

# Habilitar o mod_rewrite do Apache para URLs amigáveis (boa prática)
RUN a2enmod rewrite

# Definir as permissões corretas para os arquivos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html
