FROM php:7.2-fpm

RUN apt-get update && \
	apt-get install -y \ 
		mariadb-client \
		vim

RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install exif

RUN pecl install xdebug
RUN docker-php-ext-enable  xdebug

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN install-php-extensions ldap

WORKDIR "/var/www/html/public"

