# Use the official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    && apt-get install -y libjpeg-dev \
    && apt-get install -y libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mbstring pdo pdo_mysql tokenizer xml ctype json bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y software-properties-common \
    && add-apt-repository universe \
    && apt-get update
