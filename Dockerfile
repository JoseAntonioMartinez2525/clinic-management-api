# Usa una imagen base de PHP oficial con Apache (php:8.2-apache está bien)
FROM php:8.2-apache

# Instala las extensiones de PHP necesarias para Laravel y MySQL
# Eliminamos libpq-dev (PostgreSQL) y pdo_pgsql
RUN apt-get update && apt-get install -y \
    libmysqlclient-dev \ # ¡CAMBIO: Para MySQL!
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip # ¡CAMBIO: Solo pdo_mysql!

# Habilita el módulo rewrite de Apache para URL amigables de Laravel
RUN a2enmod rewrite

# Instala Composer (el gestor de dependencias de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copia los archivos de tu aplicación Laravel al contenedor
COPY . .

# Configura los permisos para el storage y bootstrap/cache (necesario para Laravel)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Elimina la generación de la clave de la aplicación de aquí.
# ¡CRÍTICO! APP_KEY SIEMPRE debe ser una variable de entorno en Render.
# NO la generes en el Dockerfile porque cambiaría con cada build.
# Si ya la tienes en tu .env local, Render la usará de tu configuración de variables.
# DELETE THE FOLLOWING LINE:
# RUN php artisan key:generate

# NOTA sobre migraciones:
# Es mejor ejecutar 'php artisan migrate --force' como parte del Start Command o un Deploy Hook en Render,
# en lugar de durante el build del Dockerfile. Si se ejecuta durante el build,
# cualquier cambio en la DB requiere un rebuild de la imagen, y si la DB no está disponible
# durante el build, fallará.
# POR AHORA, LO DEJAREMOS AQUÍ PARA SIMPLICIDAD, PERO TENLO EN MENTE PARA EL FUTURO.
RUN php artisan migrate --force

# Expone el puerto 80, que es el puerto por defecto de Apache
EXPOSE 80

# Comando para iniciar el servidor Apache y servir la aplicación Laravel desde el directorio 'public'
CMD ["apache2-foreground"]