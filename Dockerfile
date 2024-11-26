# Base da imagem com PHP e Apache
FROM php:8.1-apache

# Copiar o código da aplicação para o diretório padrão do Apache
COPY . /var/www/html/

# Ajustar permissões dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Instalar extensões PHP necessárias
RUN docker-php-ext-install mysqli

# Configurar o ServerName para evitar warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expor a porta 80 para o tráfego web
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]
