FROM labengine/ubuntu-upstart
MAINTAINER Fusengine <info@fusengine.ch>

RUN figlet Fusengine php7
# Udapte Ubuntu to add repos
RUN rm /etc/apt/sources.list.d/php7.list
RUN apt-get -y install software-properties-common
RUN apt-get install -y language-pack-en-base
RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php

RUN curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash -

# Install php7
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y \
            php7.0 \
            php7.0-curl \
            php7.0-gd \
            php7.0-intl \
            php7.0-mbstring \
            php7.0-mysql \
            php7.0-xml \
            php7.0-json \
            php7.0-opcache \
            php-redis \
            php-xdebug \
            php-amqp \
            apache2 \
            libapache2-mod-php7.0 \
            acl \
            mysql-client \
            nodejs

RUN a2enmod php7.0
RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer
RUN npm install -g bower gulp

# Cleanup
RUN apt-get clean

# Add image configuration and scripts
COPY apache.sh /
COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN chmod 755 /*.sh
RUN usermod -u 1000 www-data
#RUN chmod -R 777 /var/www

# Expose EXPOSE
EXPOSE 80

#start apache2
CMD ["/apache.sh"]
