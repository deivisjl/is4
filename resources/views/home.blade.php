@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="text-primary">Instituto Guillermo Putseys Alvarez</h5>
                </div>
                <div class="card-body">
                    <img src="{{ asset('img/user.png') }}" alt="" style="display: block; margin: 0 auto">
                    <div class="row justify-content-center">
                        <div class="col-md-12 text-center">
                            <h5>{{ Auth::user()->persona->primer_nombre }} {{ Auth::user()->persona->segundo_nombre }} {{ Auth::user()->persona->tercer_nombre }} {{ Auth::user()->persona->primer_apellido }} {{ Auth::user()->persona->segundo_apellido }}</h5>
                        </div>
                        <div class="col-md-12 text-center">
                            <h5>{{ Auth::user()->email }}</h5>
                        </div>
                        <div class="col-md-12 text-center">
                            <h5>{{ Auth::user()->rol->nombre }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
