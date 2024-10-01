FROM nginx:1.23

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
