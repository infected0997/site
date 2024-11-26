# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Define o diretório de trabalho no container
WORKDIR /var/www/html

# Copia os arquivos do site para o diretório de trabalho
COPY . /var/www/html

# Concede permissões ao diretório
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Instala extensões PHP adicionais, se necessário (exemplo: mysqli)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expondo a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
