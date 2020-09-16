@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-6 offset-md-3">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">Docente, Ciclo Escolar {{ $ciclo->nombre }}</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('docente.index') }}">Docentes</a></li>
                        <li class="breadcrumb-item active">Detalle</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul class="list-unstyled">
                  @foreach($registros as $registro)
                        <li><strong>{{ $registro['aula']['grado'] }}, Sección {{$registro['aula']['seccion']}}</strong></li>
                        <ul>
                            @foreach($registro['aula']['cursos'] as $curso)
                            <li>{{ $curso->nombre }}</li>
                            @endforeach
                        </ul>
                  @endforeach
                </ul>
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