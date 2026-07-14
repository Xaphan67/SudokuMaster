FROM php:8.3-cli

RUN docker-php-ext-install sockets

WORKDIR /var/www/html
COPY app/wsServer.php /var/www/html/wsServer.php

CMD ["php", "wsServer.php"]
