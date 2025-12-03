FROM mariadb:latest

ARG TIMEZONE="Europe/Madrid"

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

#ARG USER_ID=1000
#ARG GROUP_ID=1000

# Arguments for the system user and group
#ARG SYSTEM_USER="mario"
#ARG SYSTEM_GROUP="mario"

# Asigna grupo y usuario en contenedor para no tener que estar cambiando propietario a los archivos creados desde el contenedor
#RUN addgroup --gid ${GROUP_ID} ${SYSTEM_GROUP}
#RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid ${GROUP_ID} ${SYSTEM_USER}

#RUN chown -R ${SYSTEM_USER}:${SYSTEM_GROUP} /var/lib/mysql

# Set working directory
WORKDIR /var/lib/mysql

COPY autogest.sql /var/lib/mysql

#USER 1000

EXPOSE 3306