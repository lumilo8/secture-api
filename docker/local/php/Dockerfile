FROM ubuntu:18.04

ENV TZ=Europe/Madrid
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get upgrade -y && apt-get install -y apt-utils vim curl git unzip
RUN apt-get update && apt-get upgrade -y && apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update && apt-get upgrade -y && apt-get install -y php7.3 php7.3-fpm php7.3-xml php7.3-curl php7.3-mbstring php7.3-mysql php7.3-zip
RUN apt-get update && apt-get upgrade -y && apt-get install -y nodejs

ADD etc/php/7.3/fpm/conf.d/ /etc/php/7.3/fpm/conf.d/
ADD etc/php/7.3/cli/conf.d/ /etc/php/7.3/cli/conf.d/
ADD etc/php/7.3/fpm/pool.d/www.conf /etc/php/7.3/fpm/pool.d/

RUN mkdir /run/php

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

EXPOSE 9000

WORKDIR /home/app

CMD ["php-fpm7.3", "-F"]