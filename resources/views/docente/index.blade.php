@extends('layouts.app')

@section('content')
    <!-- Main content -->
    @if(sizeof($docentes) < 1)
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="callout callout-info">
                    <h5>No hay docentes para mostrar.</h5>
                </div>
            </div>
        </div>
    @else
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-12">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">Docentes, Ciclo Escolar {{ $ciclo->nombre }}</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Docentes</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <div class="row">
                      @foreach($docentes as $key => $docente)
                        <div class="col-md-3">
                            <div class="card card-default">
                                <div class="card-header-custom text-center">
                                    <strong>{{ $docente->nombre }}</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <span>Cursos asignados </span><span class="float-right badge bg-success">{{ $docente->cursos}}</span>
                                    </div>
                                </div>
                                <div class="card-footer">                                    
                                    <a href="{{ route('docente.detalle',$docente->id) }}" class="btn btn-info btn-block">Ver cursos</a>
                                </div>
                            </div>
                        </div>
                      @endforeach
                  </div>
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
    @endif
@endsection