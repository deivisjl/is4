@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-12">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">Ciclo Escolar {{ $ciclo->nombre }}</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Inscripción de alumnos</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <inscripcion-component :registro="{{ $aulas }}"></inscripcion-component>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <!-- fin contenedor -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection