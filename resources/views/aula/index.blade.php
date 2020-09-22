@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-10 offset-md-1">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <h5 class="float-left">Aulas, ciclo escolar {{ $ciclo->nombre }}</h5>
                      <a href="{{ route('aulas.create') }}" class="btn btn-primary float-right btn-sm">Nuevo registro</a>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Plan</th> 
                              <th>Nombre</th>                   
                              <th>Sección</th>
                              <th>Inscritos</th>
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
            'url': '/aulas/show',
            'type': 'GET'
          },
          
          "columns":[
              {'data': 'id', 'visible':false},
              {'data': 'plan'},
              {'data': 'aula'},
              {'data': 'seccion'},
              {'defaultContent':'<a href="" class="alumnos btn-info btn-xs"  data-toggle="tooltip" data-placement="top" title="Ver alumnos"><i class="fas fa-user"></i> Alumnos</a>', "orderable":false},
              {'defaultContent':'<a href="" class="editar btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-pencil-alt"></i> Editar</a> <a href="" class="borrar btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });

         obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.editar",function(e){
            e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));
          
          var id = data.id;
           window.location.href = "/aulas/" + id + "/edit";
        });

        $(tbody).on("click","a.alumnos",function(e){
            e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));
          
            var id = data.id;
            window.location.href = "/aulas-detalle/" + id;
        });

         $(tbody).on("click","a.borrar",function(e){
             e.preventDefault();
             var data = table.fnGetData($(this).parents("tr"));
            
            var id = data.id;

             Swal.fire({
                  title: '¿Está seguro de eliminar este registro?',
                  //text: 'Confirmar',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      axios.delete('/aulas/'+id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                              table._fnAjaxUpdate()
                              
                          })
                          .catch(error => {
                              if (error.response.status === 423) {
                                  Toastr.error(error.response.data.error,'Error'); 
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