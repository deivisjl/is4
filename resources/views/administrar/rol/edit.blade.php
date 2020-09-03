@extends('layouts.app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3 offset-md-3">
            <h3>Editar registro</h3>
          </div><!-- /.col -->
          <div class="col-sm-3">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
              <li class="breadcrumb-item active">Editar</li>
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
            <div class="col-md-6 offset-md-3">
                <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ url('roles', [$rol->id]) }}" method="POST">
                            <input name="_method" type="hidden" value="PUT">
                      @csrf
                      <div class="form-group">
                          <label for="">Nombre</label>
                          <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ $rol->nombre }}">
                          @if ($errors->has('nombre'))
                                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
                                  @endif
                      </div>
                      <div class="form-group">
                          <label for="">Descripción</label>
                          <textarea name="descripcion" class="form-control {{ $errors->has('descripcion') ? ' is-invalid' : '' }}">{{ $rol->descripcion }}</textarea>
                          @if ($errors->has('descripcion'))
                                        <p class="text-danger">{{ $errors->first('descripcion') }}</p>
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