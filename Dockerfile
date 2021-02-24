FROM php:7.4-fpm

#Copy files
COPY app/composer.lock app/composer.json .env /var/www/
#Set working dir
WORKDIR /var/www/
#install dependencies
RUN apt-get update && apt-get install -y \
        build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        libzip-dev \
        locales \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        unzip \
        git \
        curl
#Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/
#Install extensions php
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd
#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#Add user for application
RUN groupadd -g 1000 developer
RUN useradd -u 1000 -ms /bin/bash -g developer developer
#Copy existing contents
COPY ./app /var/www/
#Copy permissions
COPY --chown=developer:developer . /var/www
#Set user
USER developer

EXPOSE 9000
CMD ["php-fpm"]
