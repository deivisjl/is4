@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                @if(sizeof($carreras) > 0)
                    <div class="callout callout-success">
                      <h5>Pensum de estudios</h5>
                    </div>
                    @foreach($carreras as $index => $carrera)
                        <div class="card card-default {{ $index > 0 ? 'collapsed-card' : '' }}">
                            <div class="card-header-custom">
                                <button type="button" class="btn btn-outlined-default float-left" data-card-widget="collapse">
                                    <strong class="text-danger">{{ $carrera->nombre }}</strong>
                                </button>
                            </div>
                                
                            <div class="card-body">
                                @if(sizeof($carrera->carrera_grado) > 0)
                                    @foreach ($carrera->carrera_grado as $item)
                                        <div class="card">
                                            <div class="card-header-custom">
                                                <span>{{ $item->grado->nombre }}</span>
                                                <a href="{{ route('pensum-editar', $item->id) }}" class="btn btn-success btn-sm float-right">Editar pensum</a>
                                            </div>
                                            <div class="card-body">
                                                @if(sizeof($item->pensum) < 1)
                                                    <span class="text-info">No hay cursos asignados</span>
                                                @else
                                                    <ul style="list-style: none">
                                                        @foreach($item->pensum as $index => $registro)
                                                            <li><strong>{{ $index + 1}}.</strong> {{ $registro->curso->nombre }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                <div class="callout callout-warning">
                                    <p>No hay grados en esta carrera.</p>
                                  </div>   
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                <div class="callout callout-info">
                  <h5>No hay registros para mostrar!</h5>
                  <p>Debe de habilitar carreras para asignar el pensum</p>
                </div>
                @endif
            <!-- /.card -->
            </div>
            <!-- fin contenedor -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection
