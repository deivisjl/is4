@extends('layouts.app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4 offset-md-2">
            <h3>Nuevo registro</h3>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
              <li class="breadcrumb-item active">Nuevo</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                <div class="card">
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
                                        <span class="error invalid-feedback">{{ $errors->first('primer_nombre') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_nombre') ? ' is-invalid' : '' }}" name="segundo_nombre" value="{{ old('segundo_nombre') }}">
                                  @if ($errors->has('segundo_nombre'))
                                        <span class="error invalid-feedback">{{ $errors->first('segundo_nombre') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Tercer nombre</label>
                                  <input type="text" class="form-control {{ $errors->has('tercer_nombre') ? ' is-invalid' : '' }}" name="tercer_nombre" value="{{ old('tercer_nombre') }}">
                                  @if ($errors->has('tercer_nombre'))
                                        <span class="error invalid-feedback">{{ $errors->first('tercer_nombre') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Primer apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('primer_apellido') ? ' is-invalid' : '' }}" name="primer_apellido" value="{{ old('primer_apellido') }}">
                                  @if ($errors->has('primer_apellido'))
                                        <span class="error invalid-feedback">{{ $errors->first('primer_apellido') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Segundo apellido</label>
                                  <input type="text" class="form-control {{ $errors->has('segundo_apellido') ? ' is-invalid' : '' }}" name="segundo_apellido" value="{{ old('segundo_apellido') }}">
                                  @if ($errors->has('segundo_apellido'))
                                        <span class="error invalid-feedback">{{ $errors->first('segundo_apellido') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Genéro</label>
                                  <select name="genero" id="" class="form-control {{ $errors->has('genero') ? ' is-invalid' : '' }}" >
                                      <option value="0"> --Seleccione una opción-- </option>
                                      <option value="M">Masculino</option>
                                      <option value="F">Femenino</option>
                                  </select>
                                  @if ($errors->has('genero'))
                                        <span class="error invalid-feedback">{{ $errors->first('genero') }}</span>
                                  @endif
                              </div>
                              <div class="form-group">
                                  <label for="">Dirección</label>
                                  <textarea name="direccion" id="" class="form-control {{ $errors->has('direccion') ? ' is-invalid' : '' }}">{{ old('direccion') }}</textarea>
                                  @if ($errors->has('direccion'))
                                        <span class="error invalid-feedback">{{ $errors->first('direccion') }}</span>
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
                                        <span class="error invalid-feedback">{{ $errors->first('rol') }}</span>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">DPI</label>
                                  <input type="numeric" class="form-control {{ $errors->has('dpi') ? ' is-invalid' : '' }}" name="dpi" value="{{ old('dpi') }}">
                                  @if ($errors->has('dpi'))
                                        <span class="error invalid-feedback">{{ $errors->first('dpi') }}</span>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Correo electrónico</label>
                                  <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
                                  @if ($errors->has('email'))
                                        <span class="error invalid-feedback">{{ $errors->first('email') }}</span>
                                  @endif
                               </div>
                               <div class="form-group">
                                  <label for="">Contraseña</label>
                                 <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                  @if ($errors->has('password'))
                                        <span class="error invalid-feedback">{{ $errors->first('password') }}</span>
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
