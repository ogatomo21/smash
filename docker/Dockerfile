FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libonig-dev libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo_sqlite mbstring \
    && a2enmod rewrite

COPY php.ini /usr/local/etc/php/
COPY init.sql /docker-entrypoint-initdb.d/init.sql
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
