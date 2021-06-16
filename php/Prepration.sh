cd /var/www/html/devolon
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan db:seed --class=UserSeeder
