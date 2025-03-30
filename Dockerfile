# Usar a imagem base PHP com FPM
FROM php:8.1-fpm

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    libonig-dev \
    libzip-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Limpar o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
