FROM php:8.1.12-fpm
RUN apt update && apt upgrade -y && apt install -y nginx
# installing PDO
RUN docker-php-ext-install pdo pdo_mysql
# installing xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
# configuring nginx
COPY ./docker/php/nginx.conf /etc/nginx/nginx.conf
# create system user ("learning_sf_step3" with uid 1000)
RUN useradd -G www-data,root -u 1000 -d /home/learning_sf_step3 learning_sf_step3
RUN mkdir /home/learning_sf_step3 && \
    chown -R learning_sf_step3:learning_sf_step3 /home/learning_sf_step3
# copy existing application directory contents
WORKDIR /var/www
COPY . .
# shared PHP conf
RUN mv /var/www/docker/php/shared.ini /usr/local/etc/php/conf.d/shared.ini
# error reporting is suitable for DEV here
RUN mv /var/www/docker/php/dev.ini /usr/local/etc/php/conf.d/dev.ini
# copy existing application directory permissions
COPY --chown=learning_sf_step3:learning_sf_step3 ./ /var/www
ENTRYPOINT ["sh", "-c", "php-fpm -D \ 
    && chgrp www-data -R /var/www/var \
    && chmod -R g+rwx /var/www/var \
    && nginx -g 'daemon off;'"]