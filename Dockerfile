FROM nimmis/apache:14.04

# disable interactive functions
ENV DEBIAN_FRONTEND noninteractive

# php5-mysqlnd
RUN apt-get update && \
    apt-get install -y php5 libapache2-mod-php5  \
    php5-fpm php5-cli php5-mysql php5-pgsql php5-sqlite php5-redis \
    php5-apcu php5-intl php5-imagick php5-mcrypt php5-json php5-gd php5-curl && \
    php5enmod mcrypt && \
    rm -rf /var/lib/apt/lists/* && \
    cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN a2enmod rewrite
# RUN cat /etc/apache2/sites-available/000-default.conf

# RUN wget https://github.com/golang-migrate/migrate/releases/download/v4.15.2/migrate.linux-amd64.deb && \
#     dpkg -i migrate.linux-amd64.deb \
#     && rm -rf migrate.linux-amd64.deb

# COPY ./migrations /migrations
COPY ./public /var/www/html

RUN rm -f /var/www/html/index.html