<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function (Request $r) {
    return response()->ok([
        'success' => true,
        'message' => "API V 0.1"
    ]);
});
Route::post('/', function (Request $r) {
    return response()->ok([
        'success' => true,
        'message' => "API V 0.1"
    ]);
});

/*
|--------------------------------------------------------------------------
| AUTH Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'Login']);
Route::get('/user', [UserController::class, 'GetUser'])->middleware('jwt.verify');
Route::get('/logout', [AuthController::class, 'Logout'])->middleware('jwt.verify');
Route::get('/refresh', [AuthController::class, 'Refresh'])->middleware('jwt.verify');

// Users
Route::controller(UserController::class)
    ->middleware('jwt.verify')
    ->prefix('user')
    ->group(function () {
        Route::get('/all', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
});

// Chats
Route::controller(ChatController::class)
    ->middleware('jwt.verify')
    ->prefix('threads')
    ->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/{id}', 'responseMessage');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
});
