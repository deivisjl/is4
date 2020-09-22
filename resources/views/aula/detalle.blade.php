@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-10 offset-md-1">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">{{ $aulas->plan }}, {{ $aulas->aula }}, Sección {{ $aulas->seccion }}</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('aulas.index') }}">Aulas</a></li>
                        <li class="breadcrumb-item active">Inscritos</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <aula-detalle-component :registro={{ $aulas->id }}></aula-detalle-component>
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