FROM php:7.3-apache
RUN apt-get update -y \
  && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxslt-dev \
    libmagickwand-dev \
    mariadb-client \
  && apt-get clean -y

ADD ./apache2.conf /etc/apache2/apache2.conf

RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include --with-freetype-dir=/usr/include/

RUN docker-php-ext-install -j$(nproc) \
                           mysqli \
                           pdo \
                           pdo_mysql \
                           intl \
                           zip \
                           exif \
                           gd \
                           bcmath \
                           soap \
                           xsl \
                           sockets \
                           mbstring
# RUN pecl install xdebug-2.8.0 imagick
# RUN docker-php-ext-enable xdebug \
RUN pecl install imagick
RUN docker-php-ext-enable imagick

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini
# RUN echo "auto_prepend_file=/var/www/codecoverage/start_xdebug.php" >> /usr/local/etc/php/php.ini
# RUN echo "auto_prepend_file=/var/www/codecoverage/start_xdebug_reqbasedlogging.php" >> /usr/local/etc/php/php.ini
RUN echo "log_errors = On" >> /usr/local/etc/php/php.ini
RUN echo "error_log = /dev/stderr" >> /usr/local/etc/php/php.ini
RUN echo "session.gc_maxlifetime 86400" >> /usr/local/etc/php/php.ini
RUN a2enmod rewrite

# Disable stdout logging
RUN rm "/var/log/apache2/access.log"
