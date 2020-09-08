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
                        <li class="breadcrumb-item"><a href="{{ route('pensum.index') }}">Pensum</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pensum-editar',$registro->id) }}">Listado</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                      </ol>
                  </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form action="{{ route('pensum.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="form-group">
                          <label for="">Nombre del curso</label>
                          <input type="hidden" name="registro" value="{{ $registro->id }}">
                          <select name="curso" id="curso" class="form-control">
                              <option value="0">-- Seleccione una opción --</option>
                              @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nombre }}</option>
                              @endforeach
                          </select>
                          @if ($errors->has('curso'))
                                <p class="text-danger">{{ $errors->first('curso') }}</p>
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