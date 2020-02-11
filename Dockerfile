FROM alpine:3.10

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-xmlwriter php7-tokenizer php7-ctype php7-session \
    php7-mbstring php7-gd nginx supervisor curl composer

# Configure nginx
COPY config/randomquotes.conf /etc/nginx/conf.d/randomquotes.conf
# Remove the default site
RUN rm /etc/nginx/conf.d/default.conf
# Add the location for the PID file
RUN mkdir /run/nginx

# Configure PHP-FPM
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf

# Configure supervisord
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www/html

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/tmp/nginx && \
  chown -R nobody.nobody /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html
COPY --chown=nobody public/ /var/www/html/public
COPY --chown=nobody routes/ /var/www/html/routes
COPY --chown=nobody composer.json /var/www/html
RUN composer install -vvv

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping