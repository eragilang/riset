release: npm install && npm run build && php artisan migrate:fresh --seed && php artisan permission:create-permission-routes
web: vendor/bin/heroku-php-apache2 public/
