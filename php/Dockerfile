# Dockerfile
FROM php:fpm-alpine
# Utilise une petite image

RUN apk update; \
    apk upgrade;
# Met a jour le serveur

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-enable pdo_mysql
# Install mysqli

#WORKDIR /usr/local/apache2/htdocs/
#WORKDIR /srv/htdocs/
#WORKDIR /var/www/html/
# Change dans le repertoire de configuration