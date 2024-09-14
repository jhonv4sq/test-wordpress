ARG PHP_VERSION
# append the value of php${PHP_VERSION}- if PHP_VERSION is provided, otherwise, leave it empty.
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

RUN apk add --no-cache fcgi bash linux-headers
# Enable php fpm status page
RUN set -xe && echo "pm.status_path = /status" >> /usr/local/etc/php-fpm.d/zzz-docker.conf

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd

RUN apk update && apk upgrade
RUN apk add tzdata musl-locales
RUN cp /usr/share/zoneinfo/Europe/Brussels /etc/localtime
RUN echo "Europe/Brussels" >  /etc/timezone
RUN apk del tzdata

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

# Set user according to UID and GID
RUN apk add shadow
ARG UNAME=www-data
ARG UGROUP=www-data
ARG UID=1000
ARG GID=1000
RUN usermod  --uid $UID $UNAME
RUN groupmod --gid $GID $UGROUP

# Install necessary packages
RUN apk add \
        git \
        mariadb-client \
        unzip \
        zip \
        freetype-dev \
        libpng-dev \
        jpeg-dev \
        libjpeg-turbo-dev \
        libwebp \
        libwebp-tools \
        libavif-dev \
        imagemagick

RUN install-php-extensions \
    bcmath \
    exif \
    mysqli \
    pdo_mysql \
    zip

# Install composer
RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

ARG PHP_EXTENSIONS=""
# ADD PHP EXTENSIONS
RUN  if [ "$PHP_EXTENSIONS" != "" ]; then install-php-extensions ${PHP_EXTENSIONS}; fi


# Install wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar
RUN mv wp-cli.phar /usr/local/bin/wp

# Set workdir
RUN mkdir -p /var/www/html
RUN chown -R $UID:$GID /var/www/html
WORKDIR /var/www/html
# Remove all scripts
RUN rm -rf /scripts

# Remove anti-logs config
RUN rm -f $PHP_INI_DIR/conf.d/docker-fpm.ini

USER www-data
