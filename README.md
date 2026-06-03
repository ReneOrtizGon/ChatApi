<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Introducción
Este repositorio ha sido creado para mostrar el funcionamiento de un API en Laravel.

## Se entrega
* Un API Rest utilizando Laravel 13
* Método de autenticación requerido con JWT
* Copia de código en Gitlab
* Documentación del proyecto en este archivo
* Base de datos utilizada MySQL

## Indicaciónes
* Descargar Docker
* Tener descargador composer en tu equipo
* Clonar el código en tu local
* Instalar todos los paquetes de composer con: ```composer install```
* Una vez descargador ejecutar el entorno de desarrollo con sail: ```./vendor/bin/sail up```
* En otra terminal ejecutar los siguientes comandos:
* Ejecutar el siguiente comando para crear una alias y ejecutar solo sail: ```alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'```
* Migración a la base de datos: ```sail artisan migrate```

### Especificaciones
1. El sistema tiene dos tipos de usuarios normales y administradores. ("user", "admin")
2. El sistema tiene 3 entidades usuario,libros y categoria de libros.
3. Solo el rol **administrador** puede listar, crear, editar y eliminar usuarios ("admin")
4. **La actualización de un usuario** puede ser parcial, es decir solo enviar un campo o todos
5. Un usuario puede tener mas de un libro en mas de una categoria.
6. Un libro puede pertenecer a mas de una categoria.
7. Los usaurios deben tener un identificador unico no siendo el indice autoincrementable de la tabla.
8. Los libros deben tener un codigo unico.
9. No puede haber libros duplicados.
10. Se debe contar con un middleware que guarde en un log fisico toda llamada(entrada) a la API.
11. Se debe contar con un un metodo de autentificacion via cabaceras con la llave especifica Api-Key. (Falto)
12. Solo los usuarios logeados pueden interactuar con el sistema salvo los puntos de entrada registrar y login.

### Endpoints
# Autenticación
```
Route::controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout');
});
```

# Authentication
```
Route::controller(AuthController::class)
    ->middleware('auth:sanctum', 'role:admin')
    ->group(function () {
        Route::post('register', 'register');
});
```

# Users
```
Route::controller(UserController::class)
    ->middleware('auth:sanctum', 'role:admin')
    ->group(function () {
        Route::post('/user', 'store');
        Route::get('/user/{id}', 'show');
        Route::put('/user/{id}', 'update');
        Route::delete('/user/{id}', 'destroy');
        Route::get('/user', 'index');
});
```

# Category
```
Route::controller(CategoryController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/category', 'store');
        Route::get('/category/{id}', 'show');
        Route::put('/category/{id}', 'update');
        Route::delete('/category/{id}', 'destroy');
        Route::get('/category', 'index');
});
```

# Book
```
Route::controller(BookController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/book', 'store');
        Route::get('/book/{id}', 'show');
        Route::put('/book/{id}', 'update');
        Route::delete('/book/{id}', 'destroy');
        Route::get('/book', 'index');
});
```

