#!/bin/bash

if [ $APP_ENV == "PROD" ]; then
	mv .env.prod .env

	sed -i.bak 's/80/8080/' /etc/apache2/ports.conf
	sed -i.bak 's/443/8443/' /etc/apache2/ports.conf

	sed -i.bak 's/80/8080/' /etc/apache2/sites-enabled/000-default.conf
	sed -i.bak 's/80/8080/' /etc/apache2/sites-enabled/app.conf
	sed -i.bak 's/443/8443/' /etc/apache2/sites-enabled/app.conf
fi


# php artisan db:make
php artisan app:setup
php artisan storage:link

chown -R www-data:www-data ./storage
chmod 600 ./storage/oauth-public.key
chmod -Rf 0777 storage


#Last Item to run!!!!
/usr/sbin/apache2ctl -D FOREGROUND
