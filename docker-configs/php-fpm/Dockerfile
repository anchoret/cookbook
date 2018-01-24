FROM php:7.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg-dev \
    libpng-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql \
  && docker-php-ext-configure gd \
    --with-jpeg-dir=/usr/lib \
    --with-png-dir=/usr/lib \
    --with-freetype-dir=/usr/include/ \
  && docker-php-ext-install gd

ARG DATE_TIMEZONE=Europe/Moscow
RUN echo "cgi.fix_pathinfo=0\nexpose_php=0\n" > "${PHP_INI_DIR}/conf.d/secure.ini" \
  && echo "date.timezone=${DATE_TIMEZONE}\n" > "${PHP_INI_DIR}/conf.d/date_timezone.ini"

WORKDIR /app