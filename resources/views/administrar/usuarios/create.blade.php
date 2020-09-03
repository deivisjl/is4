@extends('layouts.app')

@section('content')
  <div class="content-header"></div>
  <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                  <div class="card-header-custom">
                       <strong>Nuevo registro</strong>
                       <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ route('usuarios.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="row">
                           <div class="col-md-6">
                              <h5>Datos personales</h5>
                              <div class="form-group">
                                  <label for="">Primer nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('primer_nombre') ? ' is-invalid' : '' }}" name="primer_nombre" value="{{ old('primer_nombre') }}">
                                   @if ($errors->has('primer_nombre'))
                                        <p class="text-danger">{{ $errors->first('primer_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_nombre') ? ' is-invalid' : '' }}" name="segundo_nombre" value="{{ old('segundo_nombre') }}">
                                  @if ($errors->has('segundo_nombre'))
                                        <p class="text-danger">{{ $errors->first('segundo_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Tercer nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('tercer_nombre') ? ' is-invalid' : '' }}" name="tercer_nombre" value="{{ old('tercer_nombre') }}">
                                  @if ($errors->has('tercer_nombre'))
                                        <p class="text-danger">{{ $errors->first('tercer_nombre') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Primer apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('primer_apellido') ? ' is-invalid' : '' }}" name="primer_apellido" value="{{ old('primer_apellido') }}">
                                  @if ($errors->has('primer_apellido'))
                                        <p class="text-danger">{{ $errors->first('primer_apellido') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_apellido') ? ' is-invalid' : '' }}" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
                                  @if ($errors->has('segundo_apellido'))
                                        <p class="text-danger">{{ $errors->first('segundo_apellido') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Género</label>
                                  <select name="genero" id="" class="form-control {{ $errors->has('genero') ? ' is-invalid' : '' }}" >
                                      <option value="0"> --Seleccione una opción-- </option>
                                      <option value="M">Masculino</option>
                                      <option value="F">Femenino</option>
                                  </select>
                                  @if ($errors->has('genero'))
                                        <p class="text-danger">{{ $errors->first('genero') }}</p>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Dirección</label>
                                  <textarea name="direccion" id="" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}">{{ old('direccion') }}</textarea>
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
                                          <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rol'))
                                        <p class="text-danger">{{ $errors->first('rol') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">DPI</label>
                                  <input type="numeric" class="form-control {{ $errors->has('dpi') ? ' is-invalid' : '' }}" name="dpi" value="{{ old('dpi') }}">
                                  @if ($errors->has('dpi'))
                                        <p class="text-danger">{{ $errors->first('dpi') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Correo electrónico</label>
                                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                                  @if ($errors->has('email'))
                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Contraseña</label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                  @if ($errors->has('password'))
                                        <p class="text-danger">{{ $errors->first('password') }}</p>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Repita la contraseña</label>
                                  <input type="password" class="form-control" name="password_confirmation">
                               </div>
                           </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6 offset-md-6">
                              <div class="form-group float-right">
                                  <button type="submit" class="btn btn-primary btn-lg">Guardar</button>
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
