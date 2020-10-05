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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' =>['auth','digitador']],function(){

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
    Route::get('aulas-detalle/{id}','Aula\AulaController@detalleAula');
    Route::get('listar-alumnos-aula/{id}','Aula\AulaController@listarAlumnoAula');
    Route::delete('eliminar-inscrito/{id}','Aula\AulaController@eliminarInscrito');

    /* Alumno */
    Route::resource('alumnos','Alumno\AlumnoController');

    /* Docentes */
    Route::get('docentes','Docentes\DocenteController@index')->name('docente.index');
    Route::get('docente-detalle/{id}','Docentes\DocenteController@detalle')->name('docente.detalle');

    /* Curso docente */
    Route::get('curso-docente','Pensum\CursoDocenteController@index')->name('curso.docente');
    Route::get('curso-docente-aulas','Pensum\CursoDocenteController@aulas');//refactorizado
    Route::get('curso-docente-pensum/{id}','Pensum\CursoDocenteController@cursos');
    Route::get('curso-docente-profesores/','Pensum\CursoDocenteController@profesores');
    Route::post('curso-docente','Pensum\CursoDocenteController@asignar');

    /* Inscrito */
    Route::get('inscripciones','Inscrito\InscritoController@index')->name('inscripciones.index');
    Route::get('inscripciones-alumnos','Inscrito\InscritoController@alumnos');
    Route::post('inscripciones','Inscrito\InscritoController@inscribir_alumnos');

    /* Pagos */
    Route::resource('pagos','Pago\PagoController',['only'=>['index','show']]);
    Route::get('pagos-historial/{id}','Pago\PagoController@historial');
    Route::get('pagos-historial-detalle/{request}','Pago\PagoController@detalleHistorial');
    Route::get('pagos-registrar/{id}','Pago\PagoController@registrarPago')->name('registrar.pago');
    Route::get('pagos-historial-meses/{id}','Pago\PagoController@historialMeses');
    Route::post('pagos-registrar','Pago\PagoController@pagar');

    /* Reportes */
    Route::get('reporte-notas','Reporte\ReporteController@notas')->name('notas.index');
    Route::get('reporte-notas-alumnos/{id}','Reporte\ReporteController@detalleAula');
    Route::get('reporte-notas-imprimir/{id}','Reporte\ReporteController@imprimirNotas');

});

Route::group(['middleware' =>['auth','profesor']],function(){
    Route::resource('profesores','Profesor\ProfesorController');
    Route::get('bimestres','Nota\NotaController@bimestre');
    Route::post('bimestre-validar','Nota\NotaController@validarBimestre');
    Route::get('alumnos-curso/{id}','Nota\NotaController@obtenerAlumnos');
    Route::post('alumnos-curso-nota','Nota\NotaController@notaAlumnos');
    Route::get('alumnos-curso-reporte/{id}','Nota\NotaController@reporteNotaAlumnos');
});

Route::group(['middleware' =>['auth','admin']],function(){

    /* Graficas */
    Route::get('graficos-ingresos','Reporte\GraficaController@index')->name('grafico.index');
    Route::get('grafico-ingreso-mes','Reporte\GraficaController@ingresoMes');
    Route::get('grafico-ingreso-carrera','Reporte\GraficaController@ingresoCarrera');

    Route::get('graficos-academicos','Reporte\GraficaController@indexAcademico')->name('alumno.index');
    Route::get('cursos-profesor','Reporte\GraficaController@cursoProfesor');
    Route::get('alumnos-carrera','Reporte\GraficaController@alumnoCarrera');
    Route::get('alumnos-genero','Reporte\GraficaController@inscritoGenero');
});
