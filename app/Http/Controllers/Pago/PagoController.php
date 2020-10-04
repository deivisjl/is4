<?php

namespace App\Http\Controllers\Pago;

use App\Mes;
use App\Pago;
use App\Inscrito;
use Carbon\Carbon;
use App\CicloEscolar;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pagos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $ciclo = CicloEscolar::where('activo',1)->first();
        
        $ordenadores = array("i.id","al.sire_id","p.primer_nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];


        $alumnos = DB::table('inscrito as i')
                ->join('aula as a','i.aula_id','a.id')
                ->join('seccion as s','a.seccion_id','s.id')
                ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                ->join('carrera as c','cg.carrera_id','c.id')
                ->join('grado as g','cg.grado_id','g.id')                
                ->join('alumno as al','i.alumno_id','al.id')
                ->join('persona as p','al.persona_id','p.id')
                ->select('i.id','al.sire_id',DB::raw('CONCAT_WS(" ",p.primer_nombre,"",p.segundo_nombre,"",p.tercer_nombre,"",p.primer_apellido,"",p.segundo_apellido) as alumno'),DB::raw('CONCAT(g.nombre," ",s.nombre,", ",c.nombre) as grado')) 
                ->where('i.ciclo_escolar_id',$ciclo->id)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
              
        $count = DB::table('inscrito as i')
                ->join('aula as a','i.aula_id','a.id')
                ->join('seccion as s','a.seccion_id','s.id')
                ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                ->join('carrera as c','cg.carrera_id','c.id')
                ->join('grado as g','cg.grado_id','g.id')                
                ->join('alumno as al','i.alumno_id','al.id')
                ->join('persona as p','al.persona_id','p.id')
                ->where('i.ciclo_escolar_id',$ciclo->id)                
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
               
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $alumnos,
        );

        return response()->json($data, 200);
    }

    public function historial($id)
    {
        $inscrito = Inscrito::findOrFail($id);

        return view('pagos.historial',['inscrito' => $inscrito]);
    }

   public function detalleHistorial(Request $request)
   {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $ordenadores = array("p.id","m.nombre","p.monto","ce.nombre");

        $columna = $request['order'][0]["column"];
        
        $criterio = $request['search']['value'];

        $registro = $request['buscar'][0]['registro'];

        $pagos = DB::table('pago as p')
                ->join('inscrito as i','p.inscrito_id','i.id')
                ->join('mes as m','p.mes_id','m.id')
                ->join('ciclo_escolar as ce','p.ciclo_escolar_id','ce.id')
                ->select('p.id','m.nombre as mes','p.monto','ce.nombre') 
                ->where('i.id',$registro)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->orderBy($ordenadores[$columna], $request['order'][0]["dir"])
                ->skip($request['start'])
                ->take($request['length'])
                ->get();
            
        $count = DB::table('pago as p')
                ->join('inscrito as i','p.inscrito_id','i.id')
                ->join('mes as m','p.mes_id','m.id')
                ->join('ciclo_escolar as ce','p.ciclo_escolar_id','ce.id')
                ->select('p.id','m.nombre as mes','p.monto','ce.nombre as ciclo') 
                ->where('i.id',$registro)
                ->where($ordenadores[$columna], 'LIKE', '%' . $criterio . '%')
                ->count();
            
        $data = array(
        'draw' => $request->draw,
        'recordsTotal' => $count,
        'recordsFiltered' => $count,
        'data' => $pagos,
        );

        return response()->json($data, 200);
   }

   public function registrarPago($id)
   {
        $inscrito = Inscrito::findOrFail($id);

        return view('pagos.pago',['inscrito' => $inscrito]);
   }

   public function historialMeses($id)
   {
        try 
        {
                $ciclo = CicloEscolar::where('activo','=',1)->first();

                $meses = Mes::all();
                
                $mes_pagado = Pago::where('ciclo_escolar_id','=',$ciclo->id)
                                        ->where('inscrito_id','=',$id)
                                        ->get(['mes_id'])
                                        ->toArray();

                $pagar = DB::table('mes')
                        ->select('id','nombre')
                        ->whereNotIn('id',$mes_pagado)
                        ->get();        
                
                return response()->json(['data' => $pagar],200);
        } 
        catch (\Exception $ex) 
        {
                return response()->json(['error' => $ex->getMessage()],423);
        }
   }

   public function pagar(Request $request)
   {
        $rules = [
             'mes'=>'required|numeric',
             'monto'=>'required|numeric',
             'inscrito' => 'required|numeric',   
        ];

        $this->validate($request, $rules);

        $ciclo = CicloEscolar::where('activo','=',1)->first();

        try 
        {
             return DB::transaction(function () use($request, $ciclo){
                
                $pago = new Pago();
                $pago->inscrito_id = $request->get('inscrito');
                $pago->mes_id = $request->get('mes');
                $pago->monto = $request->get('monto');
                $pago->ciclo_escolar_id = $ciclo->id;
                $pago->save();

                $inscrito = Inscrito::findOrFail($pago->inscrito_id);

                $fecha = Carbon::now()->format('d-m-Y');

                $boleta = \PDF::loadView('pagos.pago-imprimir',['inscrito' => $inscrito, 'pago' => $pago, 'fecha' => $fecha])->setPaper('half-letter','landscape');
                        
                return $boleta->download('boleta_pago_'.$fecha.'.pdf');
             });
        } 
        catch (\Exception $ex) 
        {
             return response()->json(['data' => $ex->getMessage()]);
        }
   }
}
