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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['register' => false, 'reset' => false]);


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/logout','Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

/* Catalogos */
Route::resource('/usuarios', 'Administrar\UsuarioController');

Route::resource('/roles', 'Administrar\RolController');

Route::resource('carreras','Administrar\CarreraController');

Route::resource('grados','Administrar\GradoController');

Route::resource('secciones','Administrar\SeccionController');

Route::resource('cursos','Administrar\CursoController');

Route::resource('carrera-grado','Administrar\CarreraGradoController');

/* Pensum */
Route::get('pensum','Pensum\PensumController@index')->name('pensum.index');
Route::get('pensum/show','Pensum\PensumController@show');
Route::get('pensum/create/{id}','Pensum\PensumController@create')->name('pensum.create');
Route::post('pensum','Pensum\PensumController@store')->name('pensum.store');
Route::get('pensum-editar/{id}','Pensum\PensumController@detalle')->name('pensum-editar');
Route::delete('pensum/{id}','Pensum\PensumController@destroy');
