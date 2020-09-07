<?php

namespace App\Http\Controllers\Administrar;

use App\Plan;
use App\Horario;
use App\PlanHorario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class PlanHorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.plan-horario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $planes = Plan::all();
        $horarios = Horario::all();
        
        return view('administrar.plan-horario.create',['planes' => $planes, 'horarios' => $horarios]);
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
            'plan' => 'required|numeric|min:1',
            'horario' => 'required|numeric|min:1'
        ];            

        $this->validate($request, $rules);

        $registro = new PlanHorario();
        $registro->plan_id = $request->get('plan');
        $registro->horario_id = $request->get('horario');
        $registro->save();

        return redirect()->route('planes-horarios.index')->with(['mensaje' => 'Registro exitoso']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlanHorario  $planHorario
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ordenadores = array("ph.id","p.nombre","h.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $registros = DB::table('plan_horario as ph')  
                ->join('plan as p','p.id','=','ph.plan_id')              
                ->join('horario as h','h.id','=','ph.horario_id')              
                ->select('ph.id','p.nombre as plan','h.nombre as horario') 
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('plan_horario as ph')  
                ->join('plan as p','p.id','=','ph.plan_id')              
                ->join('horario as h','h.id','=','ph.horario_id')                          
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $registros,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlanHorario  $planHorario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registro = PlanHorario::findOrfail($id);
        $planes = Plan::all();
        $horarios = Horario::all();

        return view('administrar.plan-horario.edit',['registro' => $registro, 'planes' => $planes, 'horarios' => $horarios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlanHorario  $planHorario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'plan' => 'required|numeric|min:1',
            'horario' => 'required|numeric|min:1'
        ];            

        $this->validate($request, $rules);

        $registro = PlanHorario::findOrFail($id);
        $registro->plan_id = $request->get('plan');
        $registro->horario_id = $request->get('horario');
        $registro->save();

        return redirect()->route('planes-horarios.index')->with(['mensaje' => 'Registro actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlanHorario  $planHorario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try 
        {
            $registro = PlanHorario::findOrFail($id);
            $registro->delete();

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
