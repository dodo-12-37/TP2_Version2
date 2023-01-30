# Dockerfile
# Creer une image pour notre serveur Apache

FROM httpd:alpine
# Utilise une petite image

RUN apk update; \ 
    apk upgrade;
# Met a jour le serveur

RUN mkdir /srv/htdocs
# Ajouter le repertoire pour les documents HTML

EXPOSE 80 443
# Exposer les ports 80 et 443

WORKDIR /usr/local/apache2/conf
# Change dans le repertoire de configuration

COPY ./conf/httpd.conf httpd.conf
# Remplacer httpd.conf par le mien

#COPY ./conf/httpd-vhosts.conf extra/httpd-vhosts.conf

#COPY ./conf/httpd-ssl.conf extra/httpd-ssl.conf
# Remplacer httpd-ssl.conf par le mien

#COPY ./certs/server.* ./
# COPY ./certs/server.key server.key
# COPY ./certs/server.crt server.crt
# Remplacer/Ajouter server.crt et server.key par les miens