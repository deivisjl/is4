@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                  <div class="card-header-custom">
                      <strong>Ciclo escolar</strong>
                      <a href="{{ route('ciclo-escolar.create') }}" class="btn btn-primary float-right btn-sm">Nuevo registro</a>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Nombre</th>
                              <th>Estado</th>                   
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
            'url': '/ciclo-escolar/show',
            'type': 'GET'
          },
          
          "columns":[
              {'data': 'id', 'visible':false},
              {'data': 'nombre'},
              {'data': 'activo', "render":function ( data, type, row, meta ) {
                                if(data == 1){return '<a href="" class="btn-success btn-xs disabled"> Activo</a>';}
                                else{return '<a href="" class="editar btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Seleccionar ciclo"> Inactivo</a>';}
                               }, "orderable":false
              }
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

             Swal.fire({
                  title: '¿Está seguro de activar este ciclo escolar?',
                  //text: 'Confirmar',
                  icon: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      axios.get('/ciclo-escolar-activar/'+id)
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