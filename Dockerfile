FROM dockerlemp:latest
RUN apt-get update &&  apt-get -y install sudo &&  apt-get -y install nodejs &&  apt-get -y install npm 
RUN npm install -g npm@latest && npm cache clean --force && npm set audit false && npm install -g @angular/cli
RUN npm install -g n && n stable
RUN useradd -m docker && echo "docker:docker" | chpasswd && adduser docker sudo
USER root
# RUN apt install php-cli unzip -y
RUN apt install curl -y
RUN cd ~ && curl -sS https://getcomposer.org/installer -o /home/docker/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /home/docker/composer-setup.php --install-dir=/usr/local/bin --filename=composer

# RUN chmod -R ugo+rw api-rest-laravel/storage/
WORKDIR /phpApp
# COPY . /www
# RUN apt-get install nginx -y
# RUN service nginx start
# CMD /bin/bash

