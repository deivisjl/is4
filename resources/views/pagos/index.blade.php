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
                      <h5 class="float-left">Listado general de alumnos</h5>
                      <ol class="breadcrumb-custom float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>                        
                        <li class="breadcrumb-item active">Pagos</li>
                      </ol>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Código SIRE</th>
                              <th>Alumno</th>
                              <th>Grado</th>                   
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
            'url': '/pagos/show',
            'type': 'GET'
          },
          
          "columns":[
              {'data': 'id', 'visible':false},
              {'data':'sire_id'},
              {'data': 'alumno'},
              {'data':'grado'},
              {'defaultContent':'<a href="" class="pagar btn-primary btn-xs"  data-toggle="tooltip" data-placement="top" title="Pagar mensual"><i class="fas fa-money-check-alt"></i> Pagar</a> <a href="" class="historial btn-success btn-xs"  data-toggle="tooltip" data-placement="top" title="Historial de pagos"><i class="fas fa-edit"></i> Historial</a>', "orderable":false}
          ],
          "language": idioma_spanish,
          "order": [[ 2, "asc" ]]
        });

         obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.historial",function(e){
            e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));
          
          var id = data.id;
           window.location.href = "/pagos-historial/" + id ;
        });

        $(tbody).on("click","a.pagar",function(e){
            e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));
          
          var id = data.id;
          window.location.href = "/pagos-registrar/" + id ;
        });
      }
</script>
@endsection