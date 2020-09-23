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
                      <h5 class="float-left">Aulas asignadas</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                @if(sizeof($registros) < 1)
                <div class="callout callout-info">
                  <h5>No hay registros asociados</h5>
                </div>
                @else
                    @foreach($registros as $index => $registro)
                      <div class="card card-default {{ $index > 0 ? 'collapsed-card' : '' }}">
                          <div class="card-header-custom">
                              <button type="button" class="btn btn-outlined-default float-left" data-card-widget="collapse">
                                  <strong class="text-danger">{{ $registro['aulas']['carrera'] }}</strong>
                              </button>
                          </div>
                              
                          <div class="card-body">
                              @foreach($registro['aulas']['grados'] as $item)
                              <div class="card">
                                <div class="footer p-0">
                                    <ul class="nav flex-column">
                                      <li class="nav-item">
                                          <a href="{{ route('profesores.show',$item->id) }}" class="nav-link">
                                              {{ $item->grado }}, Seccion {{ $item->seccion }}
                                              <div style="vertical-align:middle; margin-right: 10px; margin-bottom:5px; border-radius:50%; background-color:#28a745; color:#fff; width:35px;height:35px;align-items:center;display:inline-flex;float:left">
                                                  <i class="fas fa-book-open fa-1x" style="text-align:center;margin:auto"></i>
                                              </div>
                                          </a>
                                      </li>
                                    </ul>
                                </div>
                              </div>
                              @endforeach
                          </div>
                      </div>
                  @endforeach
                @endif
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

