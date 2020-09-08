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
                        <li class="breadcrumb-item"><a href="{{ route('carrera-grado.index') }}">Carreras y grados</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('carrera-grado', [$registro->id]) }}" method="POST" autocomplete="off">
                    <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="form-group">
                          <label for="">Grado</label>
                          <select name="grado" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}">
                              <option value="0">--Seleccione una opción--</option>
                              @foreach($grados as $grado)
                                <option value="{{ $grado->id }}"
                                    @if($grado->id == $registro->grado_id)
                                        selected = "selected"
                                    @endif
                                    >{{ $grado->nombre }}</option>
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
                              <option value="{{ $carrera->id }}"
                                @if($carrera->id = $registro->carrera_id)
                                    selected = "selected"
                                @endif
                                >{{ $carrera->nombre }}</option>
                            @endforeach
                         </select>
                        @if ($errors->has('carrera'))
                              <p class="text-danger">{{ $errors->first('carrera') }}</p>
                         @endif
                    </div>
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