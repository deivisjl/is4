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


Auth::routes(['register' => false, 'reset' => false]);

Route::get('/logout','Auth\LoginController@logout');

Route::group(['middleware' =>['auth']],function(){

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/home', 'HomeController@index')->name('home');

    /* Catalogos */
    Route::resource('/usuarios', 'Administrar\UsuarioController');

    Route::resource('/roles', 'Administrar\RolController');

    Route::resource('carreras','Administrar\CarreraController');

    Route::resource('grados','Administrar\GradoController');

    Route::resource('secciones','Administrar\SeccionController');

    Route::resource('cursos','Administrar\CursoController');

    Route::resource('carrera-grado','Administrar\CarreraGradoController');

    Route::resource('planes','Administrar\PlanController');

    Route::resource('horarios','Administrar\HorarioController');

    Route::resource('planes-horarios','Administrar\PlanHorarioController');

    Route::resource('ciclo-escolar','Administrar\CicloEscolarController');
    Route::get('ciclo-escolar-activar/{id}','Administrar\CicloEscolarController@activar');

    /* Pensum */
    Route::get('pensum','Pensum\PensumController@index')->name('pensum.index');
    Route::get('pensum/show','Pensum\PensumController@show');
    Route::get('pensum/create/{id}','Pensum\PensumController@create')->name('pensum.create');
    Route::post('pensum','Pensum\PensumController@store')->name('pensum.store');
    Route::get('pensum-editar/{id}','Pensum\PensumController@detalle')->name('pensum-editar');
    Route::delete('pensum/{id}','Pensum\PensumController@destroy');

    /* Aulas */
    Route::resource('aulas','Aula\AulaController');

    /* Alumno */
    Route::resource('alumnos','Alumno\AlumnoController');

    /* Docentes */
    Route::get('docentes','Docentes\DocenteController@index')->name('docente.index');
    Route::get('docente-detalle/{id}','Docentes\DocenteController@detalle')->name('docente.detalle');

    /* Curso docente */
    Route::get('curso-docente','Pensum\CursoDocenteController@index')->name('curso.docente');
    Route::get('curso-docente-aulas/{id}','Pensum\CursoDocenteController@aulas');
    Route::get('curso-docente-pensum/{id}','Pensum\CursoDocenteController@cursos');
    Route::get('curso-docente-profesores/','Pensum\CursoDocenteController@profesores');
    Route::post('curso-docente','Pensum\CursoDocenteController@asignar');

    /* Inscrito */
    Route::get('inscripciones','Inscrito\InscritoController@index')->name('inscripciones.index');
    Route::get('inscripciones-alumnos','Inscrito\InscritoController@alumnos');
    Route::post('inscripciones','Inscrito\InscritoController@inscribir_alumnos');

});
