FROM coreproc/laravel-php:8.2-fpm as php

# Set environment variables to non-interactive (this prevents some prompts)
ENV DEBIAN_FRONTEND=non-interactive

# Default environment variables
ENV DEFAULT_WEB_UID=1000
ENV DEFAULT_WEB_GID=1000
ENV DEFAULT_NODE_VERSION=18

# These variables can be overridden and falls back to default values if not set.
ARG WEB_UID=${DEFAULT_WEB_UID}
ARG WEB_GID=${DEFAULT_WEB_GID}
ARG NODE_VERSION=${DEFAULT_NODE_VERSION}

# Set environment variables
ENV PHP_OPCACHE_ENABLE=1
ENV PHP_OPCACHE_ENABLE_CLI=0
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS=0
ENV PHP_OPCACHE_REVALIDATE_FREQ=0

# Install curl, gpg, and other dependencies, then set up the NodeSource repository
RUN apt-get update -y \
    && apt-get install -y curl gnupg \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" > /etc/apt/sources.list.d/nodesource.list \
    && apt-get update \
    && apt-get install -y nodejs npm \
    && npm install -g npm \
    && mkdir /var/www/.npm \
    && chown -R www-data:www-data /var/www/.npm

# Check versions
RUN php -v
RUN node -v
RUN npm -v
RUN nginx -v

# Copy configuration files.
COPY ./docker/web/php/php.ini /usr/local/etc/php/php.ini
COPY ./docker/web/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini.disabled
COPY ./docker/web/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/web/nginx/nginx.conf /etc/nginx/nginx.conf

# Add crontab file in the cron directory
COPY ./docker/web/cron/laravel-scheduler /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler

# Create a directory for Supervisor configuration
RUN mkdir -p /etc/supervisor/conf.d
COPY ./docker/web/supervisor/horizon.conf /etc/supervisor/conf.d/horizon.conf

# Set working directory to ...
WORKDIR /app

# Change the user and group id of www-data to match the host user.
RUN usermod -u $WEB_UID www-data
RUN groupmod -g $WEB_GID www-data

# Copy files from current folder to container current folder (set in workdir).
COPY --chown=www-data:www-data ./ .

# Run the entrypoint file.
COPY ./docker/web/entrypoint /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

ENTRYPOINT ["entrypoint"]
