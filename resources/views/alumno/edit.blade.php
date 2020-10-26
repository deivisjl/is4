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
                      <h5 class="float-left">Editar registro</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('alumnos.index') }}">Alumnos</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ url('alumnos', [$alumno->id]) }}" method="POST" autocomplete="off">
                      <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="form-group">
                        <label for="">Primer nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control {{ $errors->has('primer_nombre') ? ' is-invalid' : '' }}" name="primer_nombre" value="{{ $alumno->persona->primer_nombre }}">
                        @if ($errors->has('primer_nombre'))
                          <p class="text-danger">{{ $errors->first('primer_nombre') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                      <label for="">Segundo nombre</label>
                      <input type="text" class="form-control {{ $errors->has('segundo_nombre') ? ' is-invalid' : '' }}" name="segundo_nombre" value="{{$alumno->persona->segundo_nombre }}">
                      @if ($errors->has('segundo_nombre'))
                        <p class="text-danger">{{ $errors->first('segundo_nombre') }}</p>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="">Tercer nombre</label>
                    <input type="text" class="form-control {{ $errors->has('tercer_nombre') ? ' is-invalid' : '' }}" name="tercer_nombre" value="{{ $alumno->persona->tercer_nombre }}">
                    @if ($errors->has('tercer_nombre'))
                      <p class="text-danger">{{ $errors->first('tercer_nombre') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                      <label for="">Primer apellido <span class="text-danger">*</span></label>
                      <input type="text" class="form-control {{ $errors->has('primer_apellido') ? ' is-invalid' : '' }}" name="primer_apellido" value="{{ $alumno->persona->primer_apellido }}">
                      @if ($errors->has('primer_apellido'))
                        <p class="text-danger">{{ $errors->first('primer_apellido') }}</p>
                      @endif
                  </div>
                  <div class="form-group">
                      <label for="">Segundo apellido</label>
                      <input type="text" class="form-control {{ $errors->has('segundo_apellido') ? ' is-invalid' : '' }}" name="segundo_apellido" value="{{ $alumno->persona->segundo_apellido }}">
                      @if ($errors->has('segundo_apellido'))
                        <p class="text-danger">{{ $errors->first('segundo_apellido') }}</p>
                      @endif
                  </div>
                  <div class="form-group">
                    <label for="">Código SIRE</label>
                    <input type="text" class="form-control {{ $errors->has('codigo_sire') ? ' is-invalid' : '' }}" name="codigo_sire" value="{{ $alumno->sire_id }}">
                    @if ($errors->has('codigo_sire'))
                      <p class="text-danger">{{ $errors->first('codigo_sire') }}</p>
                    @endif
                  </div>
                  <div class="form-group">
                      <label for="">Género <span class="text-danger">*</span></label>
                      <select name="genero" id="genero" class="form-control">
                        <option value="0">-- Seleccione una opción --</option>
                        <option value="1"
                        @if($alumno->persona->genero == 'M')
                          selected="selected"
                        @endif
                        >
                            Masculino
                          </option>
                        <option value="2"
                        @if($alumno->persona->genero == 'F')
                          selected="selected"
                        @endif
                        >
                            Femenino
                        </option>
                      </select>
                      @if ($errors->has('genero'))
                        <p class="text-danger">{{ $errors->first('genero') }}</p>
                      @endif
                  </div>
                  <div class="form-group">
                      <label for="">Dirección <span class="text-danger">*</span></label>
                      <textarea class="form-control" name="direccion">{{ $alumno->persona->direccion }}</textarea>
                  </div>
                  @if ($errors->has('direccion'))
                    <p class="text-danger">{{ $errors->first('direccion') }}</p>
                  @endif
                      <div class="form-group">
                          <button class="btn btn-success float-sm-right" type="submit">Editar</button>
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