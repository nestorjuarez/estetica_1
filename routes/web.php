<?php

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

Route::get('/', function () {
    return view('contenido.contenido');
});


Route::put('categorias/activar/{id}','CategoriasController@activar');
Route::put('categorias/desactivar/{id}','CategoriasController@desactivar');
Route::get('categorias/selectCategoria','CategoriasController@selectCategoria');// aca llamo 
Route::resource('categorias','CategoriasController');


Route::put('articulos/activar/{id}','ArticuloController@activar');
Route::put('articulos/desactivar/{id}','ArticuloController@desactivar');
Route::resource('articulos','ArticuloController');

Route::put('pacientes/activar/{id}','PacienteController@activar');
Route::put('pacientes/desactivar/{id}','PacienteController@desactivar');
Route::resource('pacientes','PacienteController');

Route::get('tratamientos/seleccionar','TratamientoController@selectratamiento');
Route::resource('tratamientos','TratamientoController');

Route::resource('ventas','VentrataController');
Route::resource('detalles','DetalleTrataController');

Route::get('servicios','ServicioController@index');
Route::delete('servicios/{id}','ServicioController@destroy');

Route::get('eventos/listar','EventosController@index');
Route::post('eventos', 'EventosController@store');