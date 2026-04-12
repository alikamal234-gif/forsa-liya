FROM php:8.4-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev npm

RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN mkdir -p database
RUN touch database/database.sqlite

RUN composer install --no-dev --optimize-autoloader

RUN php artisan migrate --force

RUN chmod -R 777 storage bootstrap/cache

RUN npm install && npm run build

RUN php artisan config:clear && \
    php artisan view:clear && \
    php artisan cache:clear
    
EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=$PORT