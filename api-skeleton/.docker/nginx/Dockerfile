FROM nginx:latest

LABEL maintainer="Ghlen Nagels <ghlen@pm.me>"

RUN rm /etc/nginx/conf.d/default.conf

COPY public /srv/app/public/
COPY --chown=nginx:nginx node/public /srv/app/node/public/
COPY .docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY .docker/nginx/conf.d/*.conf /etc/nginx/conf.d/

