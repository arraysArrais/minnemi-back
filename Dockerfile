# Imagem base
FROM php:8.1-apache

# Atualiza repositórios, instala dependências e limpa pacotes baixados
RUN apt-get update \
    && apt-get -y install curl git zip zlib1g-dev libzip-dev \
    && apt-get clean

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo_mysql zip

# Variável de ambiente para o diretório raiz do Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Atualiza configurações do Apache para usar o diretório raiz especificado
RUN find /etc/apache2 -type f -exec sed -i "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" {} +

# Volume para armazenar logs fora do contêiner
VOLUME ["/var/www/html/storage/logs"]

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do aplicativo
COPY . .

# Copia o composer.json, o composer.lock e instala as dependências do Composer
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-scripts

# Executa os comandos Artisan e ajustes de permissões
RUN php artisan cache:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan key:generate

# Define permissões de escrita para o diretório de armazenamento
RUN chmod 777 -R storage
RUN chown -R www-data:www-data storage

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Expõe a porta 80, se necessário mudar
EXPOSE 80