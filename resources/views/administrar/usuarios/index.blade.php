@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-6">
               
            </div>
        </div>
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-12">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">Usuarios</h5>
                      <a href="{{ route('usuarios.create') }}" class="btn btn-primary float-right btn-sm">Nuevo registro</a>
                  </div>
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
              {'defaultContent':'<a href="" class="editar btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-pencil-alt"></i> Editar</a> <a href="" class="borrar btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });
    }
</script>
@endsection