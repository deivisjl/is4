<?php

namespace App\Http\Controllers\Reporte;

use App\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GraficaController extends Controller
{
    public function index()
    {
        return view('graficas.index');
    }
    public function indexAcademico()
    {
        return view('graficas.academico');
    }
   public function ingresoMes()
   {
       try 
       {
            $ciclo = CicloEscolar::where('activo',1)->first();
        
            $resp = array();
    
            $ingreso = DB::table('pago as p')
                        ->join('mes as m','p.mes_id','m.id')
                        ->select(DB::raw('SUM(monto) as monto'),'m.nombre','m.id')
                        ->where('p.ciclo_escolar_id',$ciclo->id)
                        ->groupBy('m.id',"m.nombre")
                        ->get();
    
            foreach ($ingreso as $key => $item) 
            {
                $resp[$key] = [$item->nombre, (int)$item->monto];
            }
    
            return response()->json(['data' => $resp],200);
       } 
       catch (\Exception $ex) 
       {
           return response()->json(['error' => $ex->getMessage()],423);
       }
   }

   public function ingresoCarrera()
   {
      try 
      {
        $ciclo = CicloEscolar::where('activo',1)->first();
       
        $resp = array();
 
        $ingresos = DB::table('pago as p')
                     ->join('inscrito as i','p.inscrito_id','i.id')
                     ->join('aula as a','i.aula_id','a.id')
                     ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                     ->join('carrera as c','cg.carrera_id','c.id')
                     ->select(DB::raw('SUM(monto) as monto'),'c.nombre','c.id')
                     ->where('p.ciclo_escolar_id',$ciclo->id)
                     ->groupBy('c.id',"c.nombre")
                     ->get();
 
         foreach ($ingresos as $key => $item) 
         {
             $resp[$key] = [$item->nombre, (int)$item->monto];
         }
 
         return response()->json(['data' => $resp],200);
      } 
      catch (\Exception $ex) 
      {
          return response()->json(['error' => $ex->getMessage()],423);
      }
   }

   public function cursoProfesor()
   {
       try 
       {
           $ciclo = CicloEscolar::where('activo',1)->first();

           $cursos = DB::table('profesor_curso as pc')
                        ->join('pensum as p','pc.pensum_id','p.id')
                        ->join('users as u','pc.usuario_id','u.id')
                        ->join('persona as pe','u.persona_id','pe.id')
                        ->select(DB::raw('COUNT(p.id) as cursos'),DB::raw('CONCAT_WS(" ",pe.primer_nombre,"",pe.segundo_nombre,"",pe.tercer_nombre,"",pe.primer_apellido,"",pe.segundo_apellido) as profesor'),'pe.id')
                        ->where('pc.ciclo_escolar_id',$ciclo->id)
                        ->groupBy('pe.id','pe.primer_nombre','pe.segundo_nombre','pe.tercer_nombre','pe.primer_apellido','pe.segundo_apellido')
                        ->get();
            $resp = array();

            foreach ($cursos as $key => $item) 
            {
                $resp[$key] = [$item->profesor,(int) $item->cursos];
            }
            return response()->json(['data' => $resp],200);
       } 
       catch (\Exception $ex) 
       {
           return response()->json(['error' => $ex->getMessage()],423);
       }
   }

   public function alumnoCarrera()
   {
       try 
       {
            $ciclo = CicloEscolar::where('activo',1)->first();

            $registros = DB::table('inscrito as i')
                            ->join('aula as a','i.aula_id','a.id')
                            ->join('carrera_grado as cg','a.carrera_grado_id','cg.id')
                            ->join('carrera as c','cg.carrera_id','c.id')
                            ->select(DB::raw('COUNT(i.id) as alumnos'),'c.nombre','c.id')
                            ->where('i.ciclo_escolar_id',$ciclo->id)
                            ->groupBy('c.nombre','c.id')
                            ->get();
            
            $resp = array();

            foreach ($registros as $key => $item) 
            {
                $resp[$key] = [$item->nombre, $item->alumnos];
            }

            return response()->json(['data' => $resp]);
       }     
       catch (\Exception $ex) 
       {
            return response()->json(['error' => $ex->getMessage()],423);
       }
   }

   public function inscritoGenero()
   {
       try 
       {
            $ciclo = CicloEscolar::where('activo',1)->first();

            $registros = DB::table('inscrito as i')
                            ->join('alumno as a','i.alumno_id','i.id')
                            ->join('persona as p','a.persona_id','p.id')
                            ->select(DB::raw('COUNT(p.genero) as genero'),'p.genero as id')
                            ->where('i.ciclo_escolar_id',$ciclo->id)
                            ->groupBy('p.genero')
                            ->get();

            $resp = array();

            foreach ($registros as $key => $item) 
            {   
                $g = ($item->id === 'M') ? 'Masculino' : 'Femenino';

                $resp[$key] = [$g, $item->genero];
            }

            return response()->json(['data' => $resp]);
       } 
       catch (\Exception $ex) 
       {
            return response()->json(['error' => $ex->getMessage()],423);
       }
   }
}
