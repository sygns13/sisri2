<?php

namespace App\Http\Controllers;

use App\Eventocultural;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Semestre;
use App\Administrativo;
use App\Escuela;
use App\Facultad;
use App\Local;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use App\Exports\PlantillaPostulanteExport;
use Maatwebsite\Excel\Facades\Excel;

class EventoculturalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="eventos";
            return view('eventos.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $semestre_id=$request->semestre_id;

    
     $eventos = DB::table('eventoculturals')
     ->join('semestres as semestre', 'semestre.id', '=', 'eventoculturals.semestre_id')

     ->where('eventoculturals.borrado','0')
     ->where('semestre.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('eventoculturals.nombre','like','%'.$buscar.'%');
        $query->orwhere('eventoculturals.descripcion','like','%'.$buscar.'%');
        $query->orwhere('eventoculturals.entidad','like','%'.$buscar.'%');
        $query->orwhere('eventoculturals.lugarpresentacion','like','%'.$buscar.'%');

        })

     ->orderBy('eventoculturals.fechainicio')
     ->orderBy('eventoculturals.fechafinal')
     ->orderBy('eventoculturals.id')

     ->select('eventoculturals.id',
     'eventoculturals.nombre','eventoculturals.descripcion','eventoculturals.lugarpresentacion','eventoculturals.fechainicio','eventoculturals.fechafinal','eventoculturals.semestre_id','eventoculturals.entidad','eventoculturals.observaciones')
     ->paginate(50);

   


     return [
        'pagination'=>[
            'total'=> $eventos->total(),
            'current_page'=> $eventos->currentPage(),
            'per_page'=> $eventos->perPage(),
            'last_page'=> $eventos->lastPage(),
            'from'=> $eventos->firstItem(),
            'to'=> $eventos->lastItem(),
        ],
        'eventos'=>$eventos
    ];
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

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $lugarpresentacion=$request->lugarpresentacion;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $semestre_id=$request->semestre_id;
        $entidad=$request->entidad;
        $observaciones=$request->observaciones;
       


        $result='1';
        $msj='';
        $selector='';

     

        

        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');

        $input16  = array('descripcion' => $descripcion);
        $reglas16 = array('descripcion' => 'required');

        $input17  = array('fechainicio' => $fechainicio);
        $reglas17 = array('fechainicio' => 'required');

        $input18  = array('fechafinal' => $fechafinal);
        $reglas18 = array('fechafinal' => 'required');

        $input19  = array('lugarpresentacion' => $lugarpresentacion);
        $reglas19 = array('lugarpresentacion' => 'required');
   
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);


     if ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del Evento Cultural';
            $selector='txtnombre';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del Evento Cultural';
            $selector='txtdescripcion';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio del Evento Cultural';
            $selector='txtfechainicio';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese la fecha de culminación del Evento Cultural';
            $selector='txtfechafinal';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Lugar de presentación del Evento Cultural';
            $selector='txtlugarpresentacion';
        }


        else{



        $newEvento = new Eventocultural();
        $newEvento->nombre=$nombre;
        $newEvento->descripcion=$descripcion;
        $newEvento->lugarpresentacion=$lugarpresentacion;
        $newEvento->fechainicio=$fechainicio;
        $newEvento->fechafinal=$fechafinal;
        $newEvento->semestre_id=$semestre_id;
        $newEvento->entidad=$entidad;
        $newEvento->observaciones=$observaciones;

        $newEvento->activo='1';
        $newEvento->borrado='0';

        $newEvento->save();

           

            $msj='Nuevo Evento Cultural registrado con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Eventocultural  $eventocultural
     * @return \Illuminate\Http\Response
     */
    public function show(Eventocultural $eventocultural)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Eventocultural  $eventocultural
     * @return \Illuminate\Http\Response
     */
    public function edit(Eventocultural $eventocultural)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Eventocultural  $eventocultural
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $lugarpresentacion=$request->lugarpresentacion;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $semestre_id=$request->semestre_id;
        $entidad=$request->entidad;
        $observaciones=$request->observaciones;
       


        $result='1';
        $msj='';
        $selector='';

     

        

        $input15  = array('nombre' => $nombre);
        $reglas15 = array('nombre' => 'required');

        $input16  = array('descripcion' => $descripcion);
        $reglas16 = array('descripcion' => 'required');

        $input17  = array('fechainicio' => $fechainicio);
        $reglas17 = array('fechainicio' => 'required');

        $input18  = array('fechafinal' => $fechafinal);
        $reglas18 = array('fechafinal' => 'required');

        $input19  = array('lugarpresentacion' => $lugarpresentacion);
        $reglas19 = array('lugarpresentacion' => 'required');
   
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);


     if ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el nombre del Evento Cultural';
            $selector='txtnombreE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del Evento Cultural';
            $selector='txtdescripcionE';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio del Evento Cultural';
            $selector='txtfechainicioE';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese la fecha de culminación del Evento Cultural';
            $selector='txtfechafinalE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese el Lugar de presentación del Evento Cultural';
            $selector='txtlugarpresentacionE';
        }


        else{



        $newEvento =Eventocultural::find($id);
        $newEvento->nombre=$nombre;
        $newEvento->descripcion=$descripcion;
        $newEvento->lugarpresentacion=$lugarpresentacion;
        $newEvento->fechainicio=$fechainicio;
        $newEvento->fechafinal=$fechafinal;
        $newEvento->semestre_id=$semestre_id;
        $newEvento->entidad=$entidad;
        $newEvento->observaciones=$observaciones;

        $newEvento->save();

           

            $msj='Evento Cultural modificado con éxito';
        }


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Eventocultural  $eventocultural
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('talleresparticipantes')
                    ->join('eventoculturals', 'talleresparticipantes.eventocultural_id', '=', 'eventoculturals.id')
                    ->where('eventoculturals.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='El Evento cultural no puede ser eliminado pues cuenta con registros de participantes de talleres asociados a él. Elimine todos los registros de participantes de talleres para poder eliminar el Evento Cultural';
        }
        else{
        
        $borrar = Eventocultural::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Evento Cultural eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
