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
                        <li class="breadcrumb-item"><a href="{{ route('planes-horarios.index') }}">Habilitar horarios</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('planes-horarios', [$registro->id]) }}" method="POST" autocomplete="off">
                    <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="form-group">
                          <label for="">Plan</label>
                          <select name="plan" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('nombre') }}">
                              <option value="0">--Seleccione una opción--</option>
                              @foreach($planes as $plan)
                                <option value="{{ $plan->id }}"
                                    @if($plan->id == $registro->plan_id)
                                        selected = "selected"
                                    @endif
                                    >{{ $plan->nombre }}</option>
                              @endforeach
                           </select>
                          @if ($errors->has('plan'))
                                <p class="text-danger">{{ $errors->first('plan') }}</p>
                           @endif
                      </div>
                      <div class="form-group">
                        <label for="">Horario</label>
                        <select name="horario" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" value="{{ old('nombre') }}">
                            <option value="0">--Seleccione una opción--</option>
                            @foreach($horarios as $horario)
                              <option value="{{ $horario->id }}"
                                @if($horario->id = $registro->horario_id)
                                    selected = "selected"
                                @endif
                                >{{ $horario->nombre }}</option>
                            @endforeach
                         </select>
                        @if ($errors->has('horario'))
                              <p class="text-danger">{{ $errors->first('horario') }}</p>
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