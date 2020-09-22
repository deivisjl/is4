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
                        <li class="breadcrumb-item"><a href="{{ route('aulas.index') }}">Aulas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('aulas', [$aula->id]) }}" method="POST" autocomplete="off">
                    <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="form-group">
                        <label for="">Plan</label>
                        <select name="plan" id="plan" class="form-control">
                            <option value="0">-- Seleccione una opción --</option>
                            @foreach($planes as $plan)
                              <option value="{{ $plan->id }}" @if($plan->id == $aula->plan_id)selected = "selected" @endif>
                                  {{ $plan->nombre }}
                              </option>
                            @endforeach
                        </select>
                        @if ($errors->has('plan'))
                              <p class="text-danger">{{ $errors->first('plan') }}</p>
                        @endif
                    </div>
                      <div class="form-group">
                          <label for="">Grado</label>
                          <select name="carrera" id="carrera" class="form-control">
                              <option value="0">-- Seleccione una opción --</option>
                              @foreach($carreras as $carrera)
                                <option value="{{ $carrera->id }}" @if($carrera->id == $aula->carrera_grado_id)selected = "selected" @endif>
                                    {{ $carrera->grado->nombre }}, {{ $carrera->carrera->nombre}}
                                </option>
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
                              <option value="{{ $seccion->id }}" @if($seccion->id == $aula->seccion_id) selected = "selected" @endif>
                                {{ $seccion->nombre }}
                              </option>
                            @endforeach
                        </select>
                        @if ($errors->has('seccion'))
                              <p class="text-danger">{{ $errors->first('seccion') }}</p>
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