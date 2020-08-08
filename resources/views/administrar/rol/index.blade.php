@extends('layouts.app')

@section('content')
  <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Roles</h3>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
              <li class="breadcrumb-item active">Roles</li>
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
                <a href="{{ route('roles.create') }}" class="btn btn-primary float-right">Nuevo registro</a>
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
                          <th>Id</th>
                          <th>Nombre</th>                   
                          <th>Descripcion</th>
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
            'url': '/roles/show',
            'type': 'GET'
          },
          
          "columns":[
              {'data': 'id', 'visible':false},
              {'data': 'nombre'},
              {'data': 'descripcion'},
              {'defaultContent':'<a href="" class="editar badge bg-green"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-pencil-alt"></i> Editar</a> <a href="" class="borrar badge bg-danger"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });

         obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.editar",function(e){
            e.preventDefault();
          var data = table.row($(this).parents("tr")).data();
          
          var id = data.id;
           window.location.href = "/roles/" + id + "/edit";
        });

         $(tbody).on("click","a.borrar",function(e){
             e.preventDefault();
            var data = table.row($(this).parents("tr")).data();
            
            var id = data.id;

             $swal.fire({
                  title: '¿Está seguro de eliminar este registro?',
                  //text: 'Confirmar',
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      axios.delete('/roles/'+id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                                $('#listar').DataTable().ajax.reload();
                              
                          })
                          .catch(error => {
                              if (error.response) {
                                  Toastr.error(error.response.data.error,''); 
                              }else{
                                  Toastr.error('Ocurrió un error: ' + error,'Error');
                              }
                          });
                   }
                    
                });
             
          });
      }
</script>
@endsection