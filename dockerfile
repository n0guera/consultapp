# 1. Imagen Base
# Usamos una imagen de PHP FPM (FastCGI Process Manager) para servir la aplicación.
# Sustituye 8.3 con tu versión de PHP, por ejemplo: 8.2-fpm.
FROM php:8.4-fpm-alpine

# 2. Instalar dependencias del sistema y extensiones de PHP
# alpine/edge incluye paquetes más recientes.
# La instalación de dependencias como 'icu-dev', 'libzip-dev' son necesarias
# antes de instalar las extensiones 'intl' y 'zip'.
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    icu-dev \
    libzip-dev \
    nodejs \
    npm \
    nginx \
    git

# Este paso instala las dos extensiones que te faltaban: intl y zip.
# intl es necesaria para Filament/Support.
# zip es necesaria para OpenSpout.
RUN docker-php-ext-install pdo_mysql intl zip

# 3. Configuración de Composer
# Instala Composer globalmente para usarlo.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Configuración del Servidor Web (Nginx)
# Crea un directorio para la configuración de Nginx
RUN mkdir -p /etc/nginx/conf.d

# Copia la configuración de Nginx (definida más abajo)
COPY .docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# 5. Configuración de la Aplicación
# Establece el directorio de trabajo
WORKDIR /app

# Copia el código fuente
COPY . /app

# Instalar dependencias de PHP y JavaScript
# --optimize-autoloader y --no-dev son importantes para entornos de producción.
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install && npm run build # Asume que tienes un paso 'build'

# 6. Permisos y Entorno
# Establece permisos para que Laravel pueda escribir en los directorios de caché y logs
RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/bootstrap/cache

# 7. Exponer el puerto
EXPOSE 8000

# 8. Comando de inicio
# Este comando inicia FPM y Nginx
CMD ["sh", "-c", "php-fpm && nginx -g 'daemon off;'"]