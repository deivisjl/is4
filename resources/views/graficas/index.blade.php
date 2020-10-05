@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Ingresos por mes <small>(Cifras expresadas en quetzales)</small></div>
                <div class="card-body">                    
                    <ingreso-mes-component></ingreso-mes-component>
                </div>
            </div>           
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Ingresos por carrera <small>(Cifras expresadas en quetzales)</small></div>
                <div class="card-body">                    
                    <ingreso-carrera-component></ingreso-carrera-component>
                </div>
            </div>           
        </div>
    </div>
</div>
@endsection
