FROM php:7.2-fpm

RUN apt-get update && \
	apt-get install -y \ 
		# git \
		# libzip-dev \
		# libc-client-dev \
		# libkrb5-dev \
		# libpng-dev \
		# libjpeg-dev \
		# libwebp-dev \
		# libfreetype6-dev \
		# libkrb5-dev \
		# libicu-dev \
		# zlib1g-dev \
		# zip \
		mariadb-client \
		vim

# RUN docker-php-ext-configure gd \
#    --with-webp-dir=/usr/include/ \
#    --with-freetype-dir=/usr/include/ \
#    --with-jpeg-dir=/usr/include/
# RUN docker-php-ext-install gd

# RUN docker-php-ext-configure imap \
#    --with-kerberos \
#    --with-imap-ssl
# RUN docker-php-ext-install imap

# RUN docker-php-ext-configure zip \
#    --with-libzip
# RUN docker-php-ext-install zip

# RUN docker-php-ext-configure intl
# RUN docker-php-ext-install intl

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install exif

RUN pecl install xdebug
RUN docker-php-ext-enable  xdebug

# Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR "/var/www/html/public"

# RUN mkdir /web/download/file
# RUN mkdir /web/download/export
# RUN mkdir /web/download/downloads
# RUN mkdir /web/file
# RUN mkdir /assets

# COPY ./public/composer.json .
# COPY ./public/composer.lock .
# WORKDIR "/var/www/html/"

# VOLUME ./public .

# RUN composer clear-cache
# RUN composer update 

# WORKDIR "/var/www/html/public"
# RUN cp -r /app/vendor .

# WORKDIR "/var/www/html/"
# VOLUME ./public .

