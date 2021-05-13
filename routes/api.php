<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route:group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function($router){
    Route::get('users', 'Seguridad/logincontroller@users');
    
});
*/

Route::post('login', [App\Http\Controllers\Seguridad\LoginController::class, 'login']);
Route::get('refresh', [App\Http\Controllers\Seguridad\LoginController::class, 'refresh']);
Route::get('logout', [App\Http\Controllers\Seguridad\LoginController::class, 'logout']);
Route::get('users', [App\Http\Controllers\Seguridad\LoginController::class, 'users']);
Route::post('register', [App\Http\Controllers\Seguridad\RegisterController::class, 'register']);
Route::post('modifySaldo', [App\Http\Controllers\Seguridad\ModificarSaldoController::class, 'modificarSaldo']);
Route::post('registerClient', [App\Http\Controllers\Seguridad\RegistrarClienteController::class, 'register']);
