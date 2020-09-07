<?php

namespace App\Http\Controllers\Administrar;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.plan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.plan.create');
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
            'nombre' => 'required|string|max:100',
        ];            

        $this->validate($request, $rules);

        $plan = new Plan();
        $plan->nombre = $request->get('nombre');
        $plan->save();

        return redirect()->route('planes.index')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("id","nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $planes = DB::table('plan')                
                ->select('id','nombre') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('plan')                
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $planes,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plane)
    {
        return view('administrar.plan.edit',['plane' => $plane]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plane)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
        ];            

        $this->validate($request, $rules);

        $plane->nombre = $request->get('nombre');
        $plane->save();

        return redirect()->route('planes.index')->with(['mensaje' => 'Registro actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plane)
    {
        try 
        {
            $plane->delete();

            return response()->json(['data' => 'El registro fue borrado con éxito'],200);
        } 
        catch (\Exception $ex) 
        {
            if ($ex instanceof QueryException) {
                $codigo = $ex->errorInfo[1];
    
                if ($codigo == 1451) {
                    return  response()->json(['error' => 'No se puede eliminar el registro porque está relacionado'],423);
                }
            }
            return response()->json(['error' => $ex->getMessage()],423);
        }
    }
}
