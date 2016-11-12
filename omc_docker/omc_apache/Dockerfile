FROM eboraas/apache-php

MAINTAINER merkl@proudsourcing.de

ENV DEBIAN_FRONTEND noninteractive
ENV HOME /root

# timezone / date   
RUN echo "Europe/Berlin" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

# install packages
RUN apt-get update && \
	apt-get -y upgrade --fix-missing && \
	apt-get install -y --force-yes \
		less vim wget unzip rsync git \
		openjdk-7-jdk mysql-client \
		php-pear php5-cli php5-cgi php5-common php5-curl php5-gd php5-imap php5-xmlrpc php5-dev php5-memcache php5-mcrypt \
		jpegoptim optipng \
		postfix && \
	apt-get clean && \
	echo "export TERM=xterm" >> /root/.bashrc

# use own vhost configuration
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# enable apache modules
RUN /usr/sbin/a2enmod rewrite && /usr/sbin/a2enmod headers && /usr/sbin/a2enmod expires

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]