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
                      <h5 class="float-left">Nuevo registro</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ciclo-escolar.index') }}">Ciclo escolar</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ route('ciclo-escolar.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="form-group">
                          <label for="">Nombre</label>
                          <input type="text" class="form-control {{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ old('nombre') }}">
                          @if ($errors->has('nombre'))
                                        <p class="text-danger">{{ $errors->first('nombre') }}</p>
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