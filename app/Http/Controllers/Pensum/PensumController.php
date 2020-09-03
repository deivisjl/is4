<?php

namespace App\Http\Controllers\Pensum;

use App\Pensum;
use App\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PensumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registros = array();

        $carreras = Carrera::with('carrera_grado.grado','carrera_grado.pensum.curso')
                    ->get();

        return view('pensum.index',['carreras' => $carreras]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function show(Pensum $pensum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function edit(Pensum $pensum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pensum $pensum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pensum  $pensum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pensum $pensum)
    {
        //
    }
}
