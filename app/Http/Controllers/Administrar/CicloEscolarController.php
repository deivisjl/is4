<?php

namespace App\Http\Controllers\Administrar;

use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CicloEscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.ciclo-escolar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.ciclo-escolar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|numeric|unique:ciclo_escolar',
        ];            

        $this->validate($request, $rules);

        $ciclo = new CicloEscolar();
        $ciclo->nombre = $request->get('nombre');
        $ciclo->save();

        return redirect()->route('ciclo-escolar.index')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CicloEscolar  $cicloEscolar
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $ciclos = DB::table('ciclo_escolar')                
                ->select('id','nombre','activo') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('ciclo_escolar')                
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $ciclos,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CicloEscolar  $cicloEscolar
     * @return \Illuminate\Http\Response
     */
    public function edit(CicloEscolar $cicloEscolar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CicloEscolar  $cicloEscolar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CicloEscolar $cicloEscolar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CicloEscolar  $cicloEscolar
     * @return \Illuminate\Http\Response
     */
    public function destroy(CicloEscolar $cicloEscolar)
    {
        //
    }

    public function activar($id)
    {
        try 
        {
            return DB::transaction(function () use($id) {
                $registro = CicloEscolar::where('activo',1)->first();
                $registro->activo = 0;
                $registro->save();

                $registro = CicloEscolar::findOrFail($id);
                $registro->activo = 1;
                $registro->save();

                return response()->json(['data' => 'Registro actualizado con éxito'],200);
            });
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
