<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => true]);

//rutas protegidas
Route::group(['middleware' => ['auth', 'verified']], function(){

	Route::get('/vacantes', 'VacanteController@index')->name('vacantes.index');
	Route::get('/vacantes/create', 'VacanteController@create')->name('vacantes.create');
	Route::post('/vacantes', 'VacanteController@store')->name('vacantes.store');
	Route::delete('/vacantes/{vacante}', 'VacanteController@destroy')->name('vacantes.destroy');
	Route::get('/vacantes/{vacante}/edit', 'VacanteController@edit')->name('vacantes.edit');
	Route::put('/vacantes/{vacante}', 'VacanteController@update')->name('vacantes.update');

	//Subir imagenes
	Route::post('/vacantes/imagen', 'VacanteController@imagen')->name('vacantes.imagen');
	Route::post('/vacantes/borrarimagen', 'VacanteController@borrarimagen')->name('vacantes.borrar');

	//cambiar estado de vacante
	Route::post('/vacantes/{vacante}', 'VacanteController@estado')->name('vacantes.estado');

	//Notificaciones
	Route::get('/notificaciones', 'NotificacionesController')->name('notificaciones');
});

//pagina de inicio
Route::get('/', 'InicioController')->name('inicio');

//enviar datos para una vacante
Route::get('/candidatos/{id}', 'CandidatoController@index')->name('candidatos.index');
Route::post('/candidatos/store', 'CandidatoController@store')->name('candidatos.store');

//Muestra los trabajos en el front end sin autenticacion 
Route::get('/vacantes/{vacante}', 'VacanteController@show')->name('vacantes.show');
