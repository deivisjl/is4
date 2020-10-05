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
                      <h5 class="float-left">Cambiar contraseña</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Cambiar contraseña</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="/usuario-credencial" method="post" autocomplete="off">
                      @csrf
                      <div class="form-group">
                        <label for="">Nueva contraseña</label>
                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}">
                        @if ($errors->has('password'))
                                      <p class="text-danger">{{ $errors->first('password') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="">Repita la contraseña</label>
                        <input type="password" class="form-control" name="password_confirmation">
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