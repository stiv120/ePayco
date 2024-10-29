# Usamos la imagen base de PHP 8.2 con FPM
FROM php:8.2-fpm

# Copiamos los archivos composer.lock y composer.json
COPY composer*.json /var/www/

# Establecemos el directorio de trabajo
WORKDIR /var/www

# Instalamos las dependencias necesarias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev

# Limpiamos la caché de apt-get
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos las extensiones de PHP necesarias
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-configure gd --with-external-gd
RUN docker-php-ext-install gd

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Creamos un grupo y usuario para la aplicación Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copiamos todo el contenido de nuestra aplicación
COPY . /var/www

# Copiamos los permisos de la aplicación existente
COPY --chown=www:www . /var/www

# Copiamos el archivo de configuración .env
COPY .env.example /var/www/.env

# Cambiamos al usuario www
USER www

# Exponemos el puerto 9000 para PHP-FPM
EXPOSE 9000
