FROM php:8.1-apache
#install php extensions requeried from the framework
RUN apt-get update && apt-get install -y \
    zlib1g-dev libzip-dev libicu-dev g++ unzip \
    && docker-php-ext-install zip mysqli pdo_mysql intl \ 
    && a2enmod rewrite && service apache2 restart

# -m -> create home
# -s -> shell acess
RUN useradd -ms /bin/bash app

USER app

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 80

# docker build -t  php:suggestron
# docker run --name app-suggestron -d -v $(pwd)/:/var/www/html -p 80:80 php:suggestron

# docker run --name sug_db \ 
#     -e MYSQL_ROOT_PASSWORD=secret \
#     -e MYSQL_DATABASE=suggestron \
#     -e MYSQL_USER=dev \
#     -e MYSQL_PASSWORD=secret \
#     -dp 3307:3306 mysql;


# NOTE verify which ip Address / host has the mysql container, you are not using docker compose
# usually: 172.17.0.3