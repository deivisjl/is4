@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- contenedor -->
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                  <div class="card-header">
                      <h5 class="float-left">Historial de pagos de <strong>{{ $inscrito->alumno->persona->primer_nombre }} {{ $inscrito->alumno->persona->segundo_nombre }} {{ $inscrito->alumno->persona->tercer_nombre }} {{ $inscrito->alumno->persona->primer_apellido }} {{ $inscrito->alumno->persona->segundo_apellido }}</strong></h5>
                      <input type="hidden" name="registro" id="registro" value="{{ $inscrito->id }}">
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="listar" class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>Mes</th>
                              <th>Monto Q.</th>                   
                              <th>Ciclo escolar</th>
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
                'url': '/pagos-historial-detalle/show',
                'type': 'GET',
                'data': {
                    'buscar': params
                }
            },
            
            "columns":[
                {'data': 'id', 'visible':false},
                {'data': 'mes'},
                {'data': 'monto'},
                {'data': 'nombre'}
            ],
            "language": idioma_spanish,
            "order": [[ 3, "desc" ]]
            });
        }
      
</script>
@endsection