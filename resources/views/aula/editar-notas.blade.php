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
                      @if($alumno)
                        <h5 class="float-left">{{ $alumno->inscrito->alumno->persona->primer_nombre }} {{ $alumno->inscrito->alumno->persona->primer_apellido }}</h5>
                      @else

                      @endif
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        @if($alumno)
                        <li class="breadcrumb-item"><a href="/aulas-detalle/{{ $alumno->inscrito->aula_id }}">Aula</a></li>
                        @endif
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{--  --}}
                @if(sizeof($datos) > 0)
                    @foreach($datos as $index => $item)
                        <div class="card card-default {{ $index > 0 ? 'collapsed-card' : '' }}">
                            <div class="card-header-custom">
                                <button type="button" class="btn btn-outlined-default float-left" data-card-widget="collapse">
                                    <strong class="text-danger">{{ $item['curso'] }}</strong>
                                </button>
                            </div>
                                
                            <div class="card-body">
                              @if(sizeof($item['notas']) > 0)
                                  <actualizar-nota-component :registro="{{ $item['notas'] }}"></actualizar-nota-component>
                              @else
                              <div class="callout callout-warning">
                                  <p>No hay notas en este curso.</p>
                                </div>   
                              @endif
                            </div>
                        </div>
                    @endforeach
                @else
                <div class="callout callout-info">
                  <h5>No hay registros para mostrar!</h5>
                  <p>Debe de calificar cursos para visualizar la información</p>
                </div>
                @endif
                {{--  --}}
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