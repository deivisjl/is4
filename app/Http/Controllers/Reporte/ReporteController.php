<?php

namespace App\Http\Controllers\Reporte;

use App\Aula;
use App\Inscrito;
use Carbon\Carbon;
use App\CicloEscolar;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notas()
    {
        $ciclo = CicloEscolar::where('activo',1)->first();
        
        return view('reporte.nota.index',['ciclo' => $ciclo]);
    }

    public function detalleAula($id)
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $aulas = DB::table('aula as a')
                ->join('plan as p','a.plan_id','p.id')                
                ->join('seccion as s','s.id','a.seccion_id')
                ->join('carrera_grado as cg','cg.id','a.carrera_grado_id')
                ->join('carrera as c','c.id','cg.carrera_id')
                ->join('grado as g','g.id','cg.grado_id')
                ->select('a.id',DB::raw('CONCAT(g.nombre,", ",c.nombre) as aula'), 's.nombre as seccion','p.nombre as plan') 
                ->where('a.ciclo_escolar_id',$ciclo->id)
                ->where('a.id',$id)
                ->first();
        
        return view('reporte.nota.alumnos',['aulas' => $aulas]);
    }

    public function imprimirNotas($id)
    {
        try 
        {
            $ciclo = CicloEscolar::where('activo',1)->first();
        
            $alumno = Inscrito::findOrfail($id);

            $cursos = DB::table('aula as a')
                        ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                        ->join('pensum as p','p.carrera_grado_id','cg.id')
                        ->join('curso as c','p.curso_id','c.id')
                        ->select('p.id','c.nombre')
                        ->where('a.ciclo_escolar_id',$ciclo->id)
                        ->where('a.id',$alumno->aula_id)
                        ->get();
            
            $notas = array();
            $pts = array();

            foreach ($cursos as $key => $item) 
            {
                $punteos = DB::table('nota as n')
                                ->join('bimestre as b','n.bimestre_id','b.id')
                                ->select('b.id','b.nombre as nombre','n.nota')
                                ->where('n.ciclo_escolar_id',$ciclo->id)
                                ->where('n.inscrito_id',$alumno->id)
                                ->where('n.pensum_id',$item->id)
                                ->get();

                $notas['notas'][$key] = (array)$item;
                $notas['notas'][$key]['punteo'] = $punteos;    
            }

            foreach ($notas['notas'] as $key => $registro) 
            {
                $pts[$key]['nombre'] = $registro['nombre'];
                
                $total = 0;

                if(count($registro['punteo']) < 1)
                {
                    $pts[$key]['bimestre_1'] = 'N/A';
                    $pts[$key]['bimestre_2'] = 'N/A';
                    $pts[$key]['bimestre_3'] = 'N/A';
                    $pts[$key]['bimestre_4'] = 'N/A';
                }

                foreach ($registro['punteo'] as $index => $value) 
                {
                    $total = $total + $value->nota; 
                    $pts[$key]['bimestre_'.$value->id] = $value->nota;
                }

                $pts[$key]['total'] = $total;
            }

            //return response()->json(['data' => $pts]);
            $fecha = Carbon::now()->format('dmY_h:m:s');

            $reporte = \PDF::loadView('reporte.nota.imprimir-notas',['inscrito' => $alumno, 'pts' => $pts])->setPaper('letter','landscape');
                
            return $reporte->download('cuadro_notas_'.$fecha.'.pdf');
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error'=> $ex->getMessage()],423);
        }
        

    }

}
