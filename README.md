<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Introducción
Este repositorio ha sido creado para mostrar el funcionamiento de un API en Laravel(Prueba Tecnica Backend Senior).

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
* Generacion documentacióm swagger: ```sail artisan l5-swagger:generate```

### Especificaciones
1. El sistema tiene caragdo varios usuarios 
    * jhon@chat.com | alice@chat.com | bob@chat.com | charly@chat.com 
    * El password para todos es "password"
2. El sistema tiene 3 entidades usuario,chat(thread) y mensajes.
    se relacionan via dos pivotes chat_has_message y chat_members
3. Los chats se pueen paginar, viene lainformacion en el resource response.
4. Se construyo en patron repository
5. se agrego autenticacioon con jwt vya passport y con un middleware para checarel token y su valides.
6. Se crearo notifcaciones basicas.
7. Se pueden crear dos tipos de conversaciones uno a uno o grupal.
8. las validaciones en endpoint se fue mediante Form Request
9. Los responses se usaron laravel responses.


### Endpoints
# ***PREFIX api***
# Autenticación
```
Route::post('/login', [AuthController::class, 'Login']); //Login del sistema
Route::get('/logout', [AuthController::class, 'Logout'])->middleware('jwt.verify'); //Logout del sistema
Route::get('/refresh', [AuthController::class, 'Refresh'])->middleware('jwt.verify'); //Refresca el token del usuario
```

# Users
```
Route::get('/user', [UserController::class, 'GetUser'])->middleware('jwt.verify');
Route::controller(UserController::class)
    ->middleware('jwt.verify')
    ->prefix('user')
    ->group(function () {
        Route::get('/all', 'index'); //Trae todos los usaurios del sistema
        Route::get('/{id}', 'show'); //trae un usuario en concreto
        Route::post('/', 'store'); //registra un usuario
        Route::put('/{id}', 'update'); //edita un usuario
        Route::delete('/{id}', 'destroy'); //elimina un usuaio
});
```
# Threads
```
Route::controller(ChatController::class)
    ->middleware('jwt.verify')
    ->prefix('threads')
    ->group(function () {
        Route::get('/{page?}', 'index'); //Trae las conversaciones del usuario autenticado.
        Route::get('/{id}', 'show'); //Trae una conversacion especifica con sus mensajes
        Route::post('/', 'store'); //Permite crear una nueva conversacion con un mensaje inicial
        Route::post('/{id}/messages', 'responseMessage'); //Permite responder a una conversacion
        Route::put('/{id}', 'update'); // Permite editar una conversacion 
        Route::delete('/{id}', 'destroy'); //Permite eliminar una conversacion
});
```
# Notications
```
Route::controller(NotificationController::class)
    ->middleware('jwt.verify')
    ->prefix('notifications')
    ->group(function () {
        Route::get('/', 'index'); //Permite obtener las notificaciones de un usuario
        Route::get('/{id}', 'show'); //Permite obtener una notificacion concreta
        Route::put('/{id}', 'markAsRead'); //Permite marcar una notificacin como leida
        Route::delete('/{id}', 'destroy'); //Permite eliminar una notificacion.
});
```
*** Para el uso concreto de cada endpoint se puede consultar el archuvo api.yaml en la carpeta documentatin de la raiz del proyecto(coleccion postman) y en la documentacin de swagger generada ***
