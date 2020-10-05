@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Alumnos por carrera</small></div>
                <div class="card-body">                    
                    <alumno-carrera-component></alumno-carrera-component>
                </div>
            </div>           
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Género de alumnos</div>
                <div class="card-body">                    
                    <inscrito-genero-component></inscrito-genero-component>
                </div>
            </div>           
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cursos por profesor</div>
                <div class="card-body">
                    <profesor-curso-component></profesor-curso-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
