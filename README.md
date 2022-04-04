# CURSO-ANGULAR-PHP

Contenedor de desarollo para stak LEMP utilizando LARAVEL.

CREAR PROYECTO LARAVEL
composer create-project laravel/laravel api-rest-laravel "8.*" --prefer-dist

Si da errores de permisos añadir estos
chmod -R ugo+rw www/api-rest-laravel/storage/

PAGINAS CON INFO
https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-20-04
https://www.digitalocean.com/community/books/sysadmin-ebook-making-servers-work-de-es
https://github.com/do-community/travellist-laravel-demo
https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-20-04-es

Crear un controlador.
php artisan make:controller PruebasController

Crear un modelo
php artisan make:model Post

Crear un controlador
php artisan  make:controller UserController

Lista rutas
php artisan route:list

Crear Middelware
php artisan make:middleware ApiAuthMiddleware

Configurar array de discos
filesystems.php


///ANGULAR
ng new---crea nuevo proyecto
ng serve---monta server