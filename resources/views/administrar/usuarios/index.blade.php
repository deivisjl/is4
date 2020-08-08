@extends('layouts.app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Usuarios</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
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
            <div class="col-md-6 offset-md-6">
                <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-right">Nuevo registro</a>
            </div>
        </div>
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-12">
                <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="listar" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Correo electrónico</th>                   
                          <th>Usuario</th>
                          <th>Rol</th>
                          <th>DPI</th>
                          <th></th>
                        </tr>
                      </thead>
                  </table>
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

@section('js')
<script>
     $(document).ready(function() {
          listar();
      });
    var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/usuarios/show',
            'type': 'GET'
          },
          
          "columns":[
              {'data': 'email'},
              {'data': 'nombre'},
              {'data': 'rol'},
              {'data': 'dpi'},   
              {'defaultContent':'<a href="" class="editar badge bg-green"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-pencil-alt"></i> Editar</a> <a href="" class="borrar badge bg-danger"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });
    }
</script>
@endsection