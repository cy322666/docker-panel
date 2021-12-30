FROM php:8.0-fpm

# Set working directory
WORKDIR /app

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libfreetype6-dev \
    locales \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get -y --no-install-recommends install g++ zlib1g-dev

# Install extensions
RUN docker-php-ext-install pdo_pgsql exif pcntl
RUN docker-php-ext-install -j$(nproc) opcache

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions

COPY --chown=www:www . /var/www
COPY --chown=www:www ./start.sh /
RUN chmod +x /start.sh

EXPOSE 9000

ENTRYPOINT ["/start.sh"]