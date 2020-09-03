@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                @foreach($carreras as $index => $carrera)
                        <div class="card card-default {{ $index > 0 ? 'collapsed-card' : '' }}">
                            <div class="card-header-custom">
                                <button type="button" class="btn btn-outlined-default float-left" data-card-widget="collapse">
                                    <strong class="text-danger">{{ $carrera->nombre }}</strong>
                                </button>
                            </div>
                                
                            <div class="card-body">
                                @foreach ($carrera->carrera_grado as $item)
                                    <div class="card">
                                        <div class="card-header-custom">
                                            <span>{{ $item->grado->nombre }}</span>
                                            <a href="#" class="btn btn-success btn-sm float-right">Editar pensum</a>
                                        </div>
                                        <div class="card-body">
                                            @if(sizeof($item->pensum) < 1)
                                                <span class="text-info">No hay cursos asignados :(</span>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
            <!-- /.card -->
            </div>
            <!-- fin contenedor -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection
