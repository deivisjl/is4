<?php

namespace App\Http\Controllers\Nota;

use App\Nota;
use App\Bimestre;
use Carbon\Carbon;
use App\CicloEscolar;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NotaController extends Controller
{
    public function reporteNotaAlumnos($id)
    {
        $ciclo = CicloEscolar::where('activo',1)->first();

        $datos = array();

        $registros = DB::table('profesor_curso as pc')
                        ->join('aula as a','pc.aula_id','a.id')
                        ->join('inscrito as i','i.aula_id','a.id')
                        ->join('alumno as al','i.alumno_id','al.id')
                        ->join('persona as p','al.persona_id','p.id')
                        ->select('i.id','pc.pensum_id','al.sire_id',DB::raw('CONCAT_WS(" ",p.primer_nombre,"",p.segundo_nombre,"",p.tercer_nombre,"",p.primer_apellido,"",p.segundo_apellido) as nombre'))
                        ->where('pc.id',$id)
                        ->where('pc.ciclo_escolar_id',$ciclo->id)
                        ->get();

        $curso = DB::table('profesor_curso as pc')
                    ->join('aula as a','pc.aula_id','a.id')
                    ->join('plan as pl','a.plan_id','pl.id')
                    ->join('seccion as s','a.seccion_id','s.id')
                    ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                    ->join('carrera as ca','ca.id','cg.carrera_id')
                    ->join('grado as g','cg.grado_id','g.id')
                    ->join('pensum as p','pc.pensum_id','p.id')
                    ->join('curso as c','p.curso_id','c.id')
                    ->select('p.id','c.nombre','s.nombre as seccion','ca.nombre as carrera','g.nombre as grado','pl.nombre as plan')
                    ->where('pc.id',$id)
                    ->first();

        foreach ($registros as $index => $alumno) 
        {
            $notas = DB::table('nota as n')
                        ->leftJoin('bimestre as b','n.bimestre_id','b.id')
                        ->select('b.id as bimestre','n.nota')
                        ->where('n.pensum_id',$alumno->pensum_id)
                        ->where('n.inscrito_id',$alumno->id)
                        ->where('n.ciclo_escolar_id',$ciclo->id)
                        ->get();
            
            $datos['alumno'][$index] = (array)$alumno;

            $total = 0;
            foreach ($notas as $key => $item) {
                
                $total = $total + $item->nota;

                $datos['alumno'][$index]['bimestre_'.$item->bimestre] = $item->nota;
            }

            $datos['alumno'][$index]['total'] = $total;
        }

        //return response()->json(['data' => $curso]);
        $fecha = Carbon::now()->format('dmY_h:m:s');

        $reporte = \PDF::loadView('reporte.cuadro-curso',['curso' => $curso, 'datos' => $datos])->setPaper('letter','landscape');
            
        return $reporte->download('cuadro_'.$fecha.'.pdf');
    }
   public function notaAlumnos(Request $request)
   {
        try 
        {
            $rules = [
                'pensum_id'=>'required|min:1',
                'bimestre_id' => 'required|min:1',
                'notas' => 'required|array'
            ];

            $this->validate($request, $rules);

            return DB::transaction(function() use($request){

                $ciclo = CicloEscolar::where('activo',1)->first();

                foreach ($request->notas as $item) 
                {
                    $registro = new Nota();
                    $registro->pensum_id = $request->get('pensum_id');
                    $registro->bimestre_id = $request->get('bimestre_id');
                    $registro->inscrito_id = $item['id'];
                    $registro->nota = $item['nota'];
                    $registro->ciclo_escolar_id = $ciclo->id;
                    $registro->save();
                }

                return response()->json(['data' => 'Las notas fueron registradas con éxito'],200);
            });
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423); 
        }
   }

   public function obtenerAlumnos($id)
   {
        try 
        {
            $ciclo = CicloEscolar::where('activo',1)->first();

            $alumnos = DB::table('profesor_curso as pc')
                        ->join('aula as a','pc.aula_id','a.id')
                        ->join('inscrito as i','i.aula_id','a.id')
                        ->join('alumno as al','i.alumno_id','al.id')
                        ->join('persona as p','al.persona_id','p.id')
                        ->select('i.id','al.sire_id',DB::raw('CONCAT_WS(" ",primer_nombre,"",segundo_nombre,"",tercer_nombre,"",primer_apellido,"",segundo_apellido) as nombre'))
                        ->where('pc.id',$id)
                        ->where('a.ciclo_escolar_id',$ciclo->id)
                        ->get();

            return response()->json(['data' => $alumnos],200);
        } 
        catch (\Exception $ex) 
        {
            return response()->json(['error' => $ex->getMessage()],423); 
        }
   }

   public function bimestre()
   {
       try 
       {
           $bimestres = Bimestre::all();

           return response()->json(['data' => $bimestres],200);
       } 
       catch (\Exception $ex) 
       {
           return response()->json(['error' => $ex->getMessage()],423);
       }
   }
   public function validarBimestre(Request $request)
   {
       try 
       {

           $ciclo = CicloEscolar::where('activo',1)->first();
        
           $registro = DB::table('nota as n')
                            ->join('inscrito as i','n.inscrito_id','i.id')
                            ->select('n.id')
                            ->where('n.pensum_id',$request->pensum_id)
                            ->where('n.bimestre_id',$request->bimestre_id)
                            ->where('i.aula_id',$request->aula_id)
                            ->where('n.ciclo_escolar_id',$ciclo->id)
                            ->first();
            
            if($registro)
            {
                throw new \Exception("Este bimestre ya se ha calificado");
                
            }
            return response()->json(['data' => 'El bimestre fue validado con éxito'],200);
       } 
       catch (\Exception $ex) 
       {
        return response()->json(['error' => $ex->getMessage()],423);
       }
   }
}
