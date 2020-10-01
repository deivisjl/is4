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
                      <h5 class="float-left">Impresión de notas, Aulas, ciclo escolar {{ $ciclo->nombre }}</h5>
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
          ],
          "language": idioma_spanish,
          "order": [[ 0, "asc" ]]
        });

         obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){

        $(tbody).on("click","a.alumnos",function(e){
            e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));
          
            var id = data.id;
            window.location.href = "/reporte-notas-alumnos/" + id;
        });
      }
</script>
@endsection