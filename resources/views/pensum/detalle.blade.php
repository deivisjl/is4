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
                      <strong>Cursos del pensum de {{ $registro->grado->nombre }}, {{ $registro->carrera->nombre }}</strong>
                      <a href="{{ route('pensum.create', $registro->id) }}" class="btn btn-primary float-right btn-sm">Nuevo registro</a>
                      <input type="hidden" name="registro" id="registro" value="{{ $registro->id }}">
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Nombre</th>                   
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
        var registro = $('#registro').val();
        
        if(registro > 0 && !isNaN(registro))
        {
            var data = {registro:registro};
            var params = new Array();
            params.push(data);  
            listar(params);
        }
      });
    var  listar = function(params){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/pensum/show',
            'type': 'GET',
            'data': {
                   'buscar': params
            }
          },
          
          "columns":[
              {'data': 'id', 'visible':false},
              {'data': 'nombre'},
              {'defaultContent':'<a href="" class="borrar btn-danger btn-xs"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });

         obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){

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
                      axios.delete('/pensum/'+id)
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