<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Eventocultural;
use App\Talleresparticipante;
use App\Http\Controllers\Controller;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class TalleresparticipanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idevento)
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            $evento=Eventocultural::find($idevento);
            $modulo="talleresparticipantes";

            return view('talleresparticipantes.index',compact('tipouser','modulo','evento'));

            
        }
        else
        {
            return redirect('home');          
        }
    }



    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $evento=$request->evento;

      
     $talleresparticipantes = DB::table('talleresparticipantes')
     ->join('eventoculturals', 'eventoculturals.id', '=', 'talleresparticipantes.eventocultural_id')

     ->where('eventoculturals.id',$evento)
     ->where('talleresparticipantes.borrado','0')

     ->orderBy('talleresparticipantes.fecha')
     ->orderBy('talleresparticipantes.nombre')
     ->orderBy('talleresparticipantes.id')

     ->select('talleresparticipantes.id','talleresparticipantes.nombre','talleresparticipantes.fecha','talleresparticipantes.participantes','talleresparticipantes.eventocultural_id','talleresparticipantes.observaciones')
     ->paginate(50);




     return [
        'pagination'=>[
            'total'=> $talleresparticipantes->total(),
            'current_page'=> $talleresparticipantes->currentPage(),
            'per_page'=> $talleresparticipantes->perPage(),
            'last_page'=> $talleresparticipantes->lastPage(),
            'from'=> $talleresparticipantes->firstItem(),
            'to'=> $talleresparticipantes->lastItem(),
        ],
        'talleresparticipantes'=>$talleresparticipantes
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
        $fecha=$request->fecha;
        $participantes=$request->participantes;
        $eventocultural_id=$request->eventocultural_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($nombre)==0)
        {
            $result='0';
            $msj='Ingrese un taller válido';
            $selector='txtnombre';

        }
        elseif (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfecha';

        }

        elseif (intval($participantes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de participantes válida mayor o igual a cero';
            $selector='txtparticipantes';

        }

        else{

            $talleresparticipantes = new Talleresparticipante();
            $talleresparticipantes->nombre=$nombre;
            $talleresparticipantes->fecha=$fecha;
            $talleresparticipantes->participantes=intval($participantes);
            $talleresparticipantes->eventocultural_id=$eventocultural_id;
            $talleresparticipantes->observaciones=$observaciones;

            $talleresparticipantes->activo='1';
            $talleresparticipantes->borrado='0';

            $talleresparticipantes->save();

            $msj='Nuevo Registro de Talleres Participantes registrado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombre=$request->nombre;
        $fecha=$request->fecha;
        $participantes=$request->participantes;
        $eventocultural_id=$request->eventocultural_id;
        $observaciones=$request->observaciones;

        $result='1';
        $msj='';
        $selector='';

        if (strlen($nombre)==0)
        {
            $result='0';
            $msj='Ingrese un taller válido';
            $selector='txtnombreE';

        }
        elseif (strlen($fecha)==0)
        {
            $result='0';
            $msj='Ingrese una fecha válida';
            $selector='txtfechaE';

        }

        elseif (intval($participantes)<0)
        {
            $result='0';
            $msj='Ingrese una cantidad de participantes válida mayor o igual a cero';
            $selector='txtparticipantesE';

        }

        else{

            $talleresparticipantes =Talleresparticipante::find($id);
            $talleresparticipantes->nombre=$nombre;
            $talleresparticipantes->fecha=$fecha;
            $talleresparticipantes->participantes=intval($participantes);
            $talleresparticipantes->eventocultural_id=$eventocultural_id;
            $talleresparticipantes->observaciones=$observaciones;

            $talleresparticipantes->activo='1';
            $talleresparticipantes->borrado='0';

            $talleresparticipantes->save();

            $msj='Registro de Talleres Participantes modificado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Talleresparticipante::destroy($id);
        //$task->delete();


        $msj='Registro Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
