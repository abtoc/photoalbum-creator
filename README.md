# PhotoAlbum-Creator

## Project Deplow

```
cd /var/www
sudo -u www-data git clone https://github.com/abtoc/photoalbum-creator.git pac
cd /var/www/pac
sudo -u www-data cp .env.example .env
sudo -u www-data vi .env
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data php artisan key:generate
sudo -u www-data php artisan migrate
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan admin:register <name> <email>
```

## Update

```
cd /var/www/pac
sudo -u www-data php artisan down
sudo -u www-data git pull origin main
sudo -u www-data composer install --optimize-autoloader --no-dev
sudo -u www-data php artisan migrate
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data npm run prod
sudo systemctl restart pac-queue
sudo systemctl restart pac-schedule
sudo -u www-data php artisan up
```