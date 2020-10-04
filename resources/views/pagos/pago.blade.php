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
                      <h5 class="float-left">Pago de <strong>{{ $inscrito->alumno->persona->primer_nombre }} {{ $inscrito->alumno->persona->segundo_nombre }} {{ $inscrito->alumno->persona->tercer_nombre }} {{ $inscrito->alumno->persona->primer_apellido }} {{ $inscrito->alumno->persona->segundo_apellido }}</strong></h5>
                      <input type="hidden" name="registro" id="registro" value="{{ $inscrito->id }}">
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li> 
                        <li class="breadcrumb-item"><a href="{{ route('pagos.index') }}">Pagos</a></li>                        
                        <li class="breadcrumb-item active">Registrar</li>
                      </ol>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <pago-component :registro="{{ $inscrito }}"></pago-component>
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

