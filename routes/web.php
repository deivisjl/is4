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
Route::resource('pensum','Pensum\PensumController');
