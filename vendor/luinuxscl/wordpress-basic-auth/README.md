# Wordpress Basic Auth

Package para autenticación básica y CRUD de posts en WordPress desde Laravel.

## Instalación
```sh
composer require luinuxscl/wordpress-basic-auth
php artisan migrate
```

## Uso
```sh
php artisan wordpress:store-credentials https://example.com admin password
php artisan wordpress:ping https://example.com
```

### Verificación de conexión automática
Cuando se almacenan credenciales, el sistema intentará hacer `ping` al WordPress y guardará si hay conexión o no.

## Uso del servicio WordpressPostService
```php
use Luinuxscl\WordpressBasicAuth\Services\WordpressPostService;

$service = new WordpressPostService();
$posts = $service->getPosts('https://example.com');
$post = $service->createPost('https://example.com', ['title' => 'Nuevo Post', 'content' => 'Contenido del post']);
$updatedPost = $service->updatePost('https://example.com', 1, ['title' => 'Título actualizado']);
$service->deletePost('https://example.com', 1);
```

## Pruebas
```sh
vendor/bin/phpunit
```