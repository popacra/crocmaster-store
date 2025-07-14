FROM php:8.1-apache
RUN docket-php-ext-install mysqli pdo pdo_mysql
COPY . /var/www/html/
EXPOSE 80