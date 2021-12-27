FROM php:8.1-fpm



RUN apt-get update && apt-get install -y \
		libfreetype6-dev


# Install MySql
RUN docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql


# Install PostgreSql
#RUN apt-get install -y \
#        libpq-dev \
#	&& docker-php-ext-install -j$(nproc) pdo pgsql pdo_pgsql


# Install gd
RUN apt-get install -y \
		libjpeg62-turbo-dev \
		libpng-dev \
	 &&   docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
     &&   docker-php-ext-install gd


# Install zip
RUN apt-get install -y \
        zip \
        libzip-dev \
    #&& docker-php-ext-configure zip --with-libzip \      (для php >= 7.4 расширения отключить)
    && docker-php-ext-install zip


#install dlib python
RUN apt install -y python3 python3-pip build-essential cmake pkg-config \
    && pip install dlib==19.9.0 scikit-image


# Install xdebug
RUN pecl install xdebug-3.1.2 && docker-php-ext-enable  xdebug



COPY *.ini /usr/local/etc/php/conf.d/