FROM mysql:8.0

ARG MYSQL_DATABASE=laravel
ARG MYSQL_USER=user
ARG MYSQL_PASSWORD=password
ARG MYSQL_ROOT_PASSWORD=password

ENV MYSQL_DATABASE=${MYSQL_DATABASE} \
  MYSQL_USER=${MYSQL_USER} \
  MYSQL_PASSWORD=${MYSQL_PASSWORD} \
  MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}

COPY ./my.cnf /etc/mysql/conf.d/my.cnf

# Fix permissions before starting MySQL
RUN chmod 755 /etc/mysql/conf.d/my.cnf && \
    mkdir -p /var/lib/mysql && \
    chown -R mysql:mysql /var/lib/mysql && \
    chmod -R 755 /var/lib/mysql

RUN mkdir -p /var/log/mysql && \
    touch /var/log/mysql/error.log && \
    chown -R mysql:mysql /var/log/mysql