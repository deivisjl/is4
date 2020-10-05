@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                  <div class="card-header-custom">
                       <h5 class="float-left">Editar registro</h5>
                       <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">Editar</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form action="{{ url('usuarios', [$usuario->id]) }}" method="POST" autocomplete="off">
                    <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="row">
                           <div class="col-md-6">
                              <h5>Datos personales</h5>
                              <div class="form-group">
                                  <label for="">Primer nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('primer_nombre') ? ' is-invalid' : '' }}" name="primer_nombre" value="{{ $usuario->persona->primer_nombre }}">
                                   @if ($errors->has('primer_nombre'))
                                        <p class="text-danger">{{ $errors->first('primer_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_nombre') ? ' is-invalid' : '' }}" name="segundo_nombre" value="{{ $usuario->persona->segundo_nombre }}">
                                  @if ($errors->has('segundo_nombre'))
                                        <p class="text-danger">{{ $errors->first('segundo_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Tercer nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('tercer_nombre') ? ' is-invalid' : '' }}" name="tercer_nombre" value="{{ $usuario->persona->tercer_nombre }}">
                                  @if ($errors->has('tercer_nombre'))
                                        <p class="text-danger">{{ $errors->first('tercer_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Primer apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('primer_apellido') ? ' is-invalid' : '' }}" name="primer_apellido" value="{{ $usuario->persona->primer_apellido }}">
                                  @if ($errors->has('primer_apellido'))
                                        <p class="text-danger">{{ $errors->first('primer_apellido') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_apellido') ? ' is-invalid' : '' }}" name="segundo_apellido" value="{{ $usuario->persona->segundo_nombre }}">
                                  @if ($errors->has('segundo_apellido'))
                                        <p class="text-danger">{{ $errors->first('segundo_apellido') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Género</label>
                                  <select name="genero" id="" class="form-control {{ $errors->has('genero') ? ' is-invalid' : '' }}" >
                                      <option value="0"> --Seleccione una opción-- </option>
                                      <option value="M"
                                      @if($usuario->persona->genero == 'M')
                                            selected = "selected"
                                      @endif
                                      >Masculino</option>
                                      <option value="F"
                                      @if($usuario->persona->genero == 'F')
                                            selected = "selected"
                                      @endif
                                      >Femenino</option>
                                  </select>
                                  @if ($errors->has('genero'))
                                        <p class="text-danger">{{ $errors->first('genero') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Dirección</label>
                                  <textarea name="direccion" id="" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}">{{ $usuario->persona->direccion }}</textarea>
                                  @if ($errors->has('direccion'))
                                        <p class="text-danger">{{ $errors->first('direccion') }}</p>
                                  @endif
                              </div>
                           </div>
                           <div class="col-md-6">
                               <h5>Datos de la cuenta</h5>
                               <div class="form-group">
                                    <label for="">Nombre del rol</label>
                                    <select name="rol" id="" class="form-control {{ $errors->has('rol') ? ' is-invalid' : '' }}">
                                        <option value="0"> --Seleccione una opción-- </option>
                                        @foreach($roles as $rol)
                                          <option value="{{ $rol->id }}"
                                            @if($rol->id == $usuario->rol_id)
                                                selected = "selected"
                                            @endif
                                            >{{ $rol->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rol'))
                                        <p class="text-danger">{{ $errors->first('rol') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">DPI</label>
                                  <input type="numeric" class="form-control {{ $errors->has('dpi') ? ' is-invalid' : '' }}" name="dpi" value="{{ $usuario->dpi }}">
                                  @if ($errors->has('dpi'))
                                        <p class="text-danger">{{ $errors->first('dpi') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Correo electrónico</label>
                                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $usuario->email }}">
                                  @if ($errors->has('email'))
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                  @endif
                               </div>
                           </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 offset-md-6">
                              <div class="form-group float-right">
                                  <button type="submit" class="btn btn-success btn-lg">Editar</button>
                               </div>
                          </div>
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
