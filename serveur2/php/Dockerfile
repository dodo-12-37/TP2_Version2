# Dockerfile
FROM php:fpm-alpine
# Utilise une petite image

RUN apk update; \
    apk upgrade;
# Met a jour le serveur

RUN docker-php-ext-install mysqli
# Install mysqli

WORKDIR /srv/htdocs/