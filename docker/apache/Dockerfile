ARG APACHE_VERSION=""
FROM httpd:${APACHE_VERSION:+${APACHE_VERSION}-}alpine
#FROM php:${PHP_VERISION}
RUN apk update; \
    apk upgrade;

# Copy apache vhost file to proxy php requests to php-fpm container
COPY host.apache.conf /usr/local/apache2/conf/host.apache.conf
COPY httpd-vhosts.conf /usr/local/apache2/conf/extra/httpd-vhosts.conf
RUN echo "Include /usr/local/apache2/conf/host.apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf



