# Imagem base
FROM php:8.1-apache

# Argumento de ambiente
ARG environment='teste'

# Atualiza repositórios, instala dependências e limpa pacotes baixados
RUN apt-get update \
    && apt-get -y install curl git zip zlib1g-dev libzip-dev \
    && apt-get clean

# Instala extensões PHP necessárias
RUN docker-php-ext-install mysqli pdo_mysql zip

# Instala o MySQL
RUN apt-get update \
    && apt-get -y install default-mysql-client

# Variável de ambiente para o diretório raiz do Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Atualiza configurações do Apache para usar o diretório raiz especificado
RUN find /etc/apache2 -type f -exec sed -i 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' {} +

# Volume para armazenar logs fora do contêiner
VOLUME ["/var/www/html/storage/logs"]

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Define permissão para o Composer ser executado como superusuário
ENV COMPOSER_ALLOW_SUPERUSER 1

# Ativa módulos SSL e Rewrite do Apache
RUN a2enmod ssl && a2enmod rewrite

# Renomeia arquivo de configuração do PHP para produção
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Aumenta o limite de memória, tamanho de post e upload do PHP
RUN echo 'memory_limit=1024M' >> /usr/local/etc/php/conf.d/docker-php-memory-limit.ini \
    && echo 'post_max_size=256M' >> /usr/local/etc/php/conf.d/docker-php-post-limit.ini \
    && echo 'upload_max_size=256M' >> /usr/local/etc/php/conf.d/docker-php-upload-limit.ini

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos do aplicativo
COPY . /var/www/html/.

# Define permissões de escrita para o diretório de armazenamento
RUN chmod o+w ./storage/ -R

# Instala dependências do Composer
RUN composer install

# Executa comandos Artisan e ajustes de permissões
RUN php artisan cache:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan key:generate \
    && chmod 777 -R /var/www/html/storage/ \
    && chown -R www-data:www-data /var/www/ \
    && a2enmod rewrite

# Expõe a porta 80
EXPOSE 80

#If necessary
#EXPOSE 443