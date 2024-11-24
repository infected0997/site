FROM php:8.1-apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN docker-php-ext-install mysqli
EXPOSE 80