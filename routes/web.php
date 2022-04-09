<?php

use Illuminate\Support\Facades\Route;

//////////////////////////Rutas para borrar la caché y limpiar configuración
//acceder a la ruta /clear-cache para ejecutarlo
use Illuminate\Support\Facades\Artisan;
Route::get('/clear-cache', function () {
    echo Artisan::call('config:clear');
    echo Artisan::call('cache:clear');
    echo Artisan::call('route:clear');
    echo Artisan::call('config:cache');
    echo "<br>Caché borrada, Configuración limpia!!";
 });
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('home');
});
*/

Route::get('/', 'PedidoController@index')->name('pedidos.index');
Route::get('/{pedido}', 'PedidoController@show')->name('pedidos.show');
Route::get('/crear', 'RecursoController@create')->name('pedidos.create');
Route::post('/', 'RecursoController@store')->name('pedidos.store');