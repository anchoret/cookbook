FROM php:7.2-cli-alpine

COPY --from=composer:1.6 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install pdo_mysql

ARG DATE_TIMEZONE=Europe/Moscow
RUN echo "date.timezone=${DATE_TIMEZONE}\n" > "${PHP_INI_DIR}/conf.d/date_timezone.ini" \
  && echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini"

ARG  USER_GID
ARG  USER_UID
RUN addgroup -g ${USER_GID} laravel \
  && adduser -D -u ${USER_UID} -G laravel laravel

RUN touch crontab.tmp \
  && echo '* * * * * /usr/local/bin/php /app/artisan schedule:run' > crontab.tmp \
  && crontab -u laravel crontab.tmp \
  && rm -rf crontab.tmp

WORKDIR /app

ENTRYPOINT ["/usr/sbin/crond", "-f", "-d", "0"]