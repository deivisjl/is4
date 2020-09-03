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
                      <strong>Nuevo registro</strong>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('carrera-grado.index') }}">Carreras y grados</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ route('carrera-grado.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="form-group">
                          <label for="">Grado</label>
                          <select name="grado" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}">
                              <option value="0">--Seleccione una opción--</option>
                              @foreach($grados as $grado)
                                <option value="{{ $grado->id }}">{{ $grado->nombre }}</option>
                              @endforeach
                           </select>
                          @if ($errors->has('grado'))
                                <p class="text-danger">{{ $errors->first('grado') }}</p>
                           @endif
                      </div>
                      <div class="form-group">
                        <label for="">Carrera</label>
                        <select name="carrera" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}">
                            <option value="0">--Seleccione una opción--</option>
                            @foreach($carreras as $carrera)
                              <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                            @endforeach
                         </select>
                        @if ($errors->has('carrera'))
                              <p class="text-danger">{{ $errors->first('carrera') }}</p>
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