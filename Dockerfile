# Stage 1 : build frontend
FROM node:18-alpine AS frontend

WORKDIR /app

# Copier les fichiers package.json et package-lock.json
COPY cesizen/package*.json ./

# Installer les dépendances
RUN npm install

# Copier le code source frontend
COPY cesizen/ .

# Build pour production
RUN npm run build

# Stage 2 : backend Laravel
FROM php:8.2-fpm

# Installer les dépendances système et PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libicu-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql bcmath intl mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copier le build frontend depuis le stage 1
COPY --from=frontend /app/public ./public

# Copier le backend Laravel
COPY cesizen/ .

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Copier le fichier .env et générer la clé
RUN cp .env.example .env && php artisan key:generate

# Exposer le port
EXPOSE 8000

# Commande pour lancer Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
