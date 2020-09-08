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
                      <h5 class="float-left">Nuevo registro</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('aulas.index') }}">Aulas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ route('aulas.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="form-group">
                          <label for="">Grado</label>
                          <select name="carrera" id="carrera" class="form-control">
                              <option value="0">-- Seleccione una opción --</option>
                              @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}">{{ $carrera->grado->nombre }}, {{ $carrera->carrera->nombre}}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('carrera'))
                                <p class="text-danger">{{ $errors->first('carrera') }}</p>
                          @endif
                      </div>
                      <div class="form-group">
                        <label for="">Sección</label>
                        <select name="seccion" id="seccion" class="form-control">
                            <option value="0">-- Seleccione una opción --</option>
                            @foreach($secciones as $seccion)
                              <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('seccion'))
                              <p class="text-danger">{{ $errors->first('seccion') }}</p>
                        @endif
                    </div>
                      <div class="form-group">
                          <button class="btn btn-primary float-sm-right" type="submit">Guardar</button>
                      </div>
                  </form>
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