FROM php:7.4-apache

# Copiar los archivos de tu aplicación a la carpeta htdocs de Apache
COPY . /var/www/html/
