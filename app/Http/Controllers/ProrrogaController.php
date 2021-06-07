<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tipopersona;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use App\Modulo;
use App\Submodulo;
use App\Programacion;
use App\Prorroga;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

use stdClass;
use DateTime;

class ProrrogaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="prorroga";
            $tipousers=Tipouser::orderBy('id')->where('borrado','0')->get();
            $modulos=Modulo::orderBy('id')->where('borrado','0')->where('id','>','1')->get();
            $submodulos=Submodulo::orderBy('id')->where('borrado','0')->where('modulo_id','>','1')->get();

            return view('prorroga.index',compact('tipouser','modulo','tipousers','modulos','submodulos'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index(Request $request)
    {

        $programaciones = DB::table('programacions')
            ->join('submodulos', 'submodulos.id', '=', 'programacions.submodulo_id')    
            ->join('modulos', 'modulos.id', '=', 'submodulos.modulo_id')    
            ->leftJoin('prorrogas', function($join)
            {
                $join->on('programacions.id', '=', 'prorrogas.programacion_id')
                ->where('prorrogas.estado', '=', '1')
                ->where('prorrogas.activo', '=', '1')
                ->where('prorrogas.borrado', '=', '0');
            })
            ->where('programacions.borrado','0')
            ->orderBy('modulos.id')
            ->orderBy('submodulos.id')
            ->orderBy('programacions.id')

            ->select('programacions.id as id', 'programacions.titulo','programacions.fechaini','programacions.fechafin', 'programacions.descripcion',
                'modulos.id as idModulo','modulos.modulo',
            'submodulos.id as idSubmodulo','submodulos.submodulo', 'submodulos.estado as estadoSubmodulo',
            DB::Raw('IFNULL( `submodulos`.`fechaini` , "" ) as fechainiSubmodulo'),
            DB::Raw('IFNULL( `submodulos`.`fechafin` , "" ) as fechafinSubmodulo'),
            DB::Raw('IFNULL( `prorrogas`.`id` , "0" ) as idProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`titulo` , "" ) as tituloProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`descripcion` , "" ) as descripcionProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`numero` , 0 ) as numeroProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`motivo` , "" ) as motivoProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`nombre_user` , "" ) as usuarioProrroga'),
            DB::Raw("IFNULL( DATE_FORMAT(`prorrogas`.created_at, '%Y-%m-%d') , '' ) as fechaProrroga") ,
            DB::Raw("IFNULL( DATE_FORMAT(`prorrogas`.created_at, '%H:%i:%s') , '' ) as horaProrroga"),
            DB::Raw('IFNULL( `prorrogas`.`estado` , "" ) as estadoProrroga'),
            DB::Raw('IFNULL( `prorrogas`.`activo` , "" ) as activoProrroga')
            
            )
            ->get();

       

          return [
            'programaciones'=>$programaciones
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

        $idSubmodulo=$request->idSubmodulo;
        $motivoProrroga=$request->motivoProrroga;



        $result='1';
        $msj='';
        $selector='txtmotivoProrroga';

        $input1  = array('idSubmodulo' => $idSubmodulo);
        $reglas1 = array('idSubmodulo' => 'required');

        $input2  = array('motivoProrroga' => $motivoProrroga);
        $reglas2 = array('motivoProrroga' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);

        


        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe de Remitir el Módulo de Prórroga';
            $selector='txtmotivoProrroga';

        }elseif($validator2->fails())
        {
            $result='0';
            $msj='Debe de Consignar el motivo de la solicitud de Prórroga de ampliación de plazo';
            $selector='txtmotivoProrroga';

        }
        else{

            $programacion = Programacion::where('activo','1')->where('borrado','0')->where('submodulo_id',$idSubmodulo)->get();

            $b = false;

            foreach ($programacion as $key => $dato) {
                $b = true;

                $prorroga = Prorroga::where('estado','1')->where('activo','1')->where('borrado','0')->where('programacion_id',$dato->id)->where('user_id_solicita',Auth::user()->id)->get();

                if($prorroga != null && $prorroga->count() > 0){

                    $fecha = $prorroga[0]->created_at;
                    $fechaMsj = "";
                    $horaMsj = "";

                    if($fecha != null){

                        $horaMsj = substr($fecha, -8,8);
                        $fechaMsj = substr($fecha, 0,10);

                        $fechaMsj = pasFechaVista($fechaMsj);

                    }

                    $result='0';
                    $msj='Ya registró una solicitud de ampliación de prórroga para este módulo de fecha: '.$fechaMsj.' y hora:'.$horaMsj;
                    $selector='txtmotivoProrroga';
                    break;
                }
                else{

                    $prorrogaContar = Prorroga::where('activo','1')->where('borrado','0')->where('programacion_id',$dato->id)->where('user_id_solicita',Auth::user()->id)->count();

                    if($prorrogaContar != null && $prorrogaContar >=5){
                        $result='0';
                        $msj='Ya registró 05 solicitudes de ampliación de prórroga para este módulo antes, ya no puede solicitar más, de requerir registrar datos, favor comunicarse con el administrador del Sistema o con la OGTISE';
                        $selector='txtmotivoProrroga';
                        break;
                    }
                    else{

                        $numero = intval($prorrogaContar) + 1;
                        $submodulo = Submodulo::find($idSubmodulo);

                        $persona = Persona::find(Auth::user()->persona_id);
                        $nombrePersona = "";

                        if($persona != null){
                            if($persona->nombres != null){
                                $nombrePersona .= " ".$persona->nombres;
                            }
                            if($persona->apellidopat != null){
                                $nombrePersona .= " ".$persona->apellidopat;
                            }
                            if($persona->apellidomat != null){
                                $nombrePersona .= " ".$persona->apellidomat;
                            }
                        }

                        $nombrePersona = trim($nombrePersona);

                        $newSolicProrroga = new Prorroga();
                        $newSolicProrroga->titulo = "Solicitud de Prórroga N° ".$idSubmodulo."-".$dato->id."-".$numero;
                        $newSolicProrroga->descripcion = "Solicitud de Prórroga del SubMódulo ".$submodulo->submodulo;
                        $newSolicProrroga->programacion_id = $dato->id;
                        $newSolicProrroga->numero = $numero;
                        $newSolicProrroga->activo='1';
                        $newSolicProrroga->borrado='0';
                        $newSolicProrroga->estado='1'; //Iniciado
                        $newSolicProrroga->motivo=$motivoProrroga;
                        $newSolicProrroga->user_id_solicita = Auth::user()->id;
                        $newSolicProrroga->nombre_user = $nombrePersona;

                        $newSolicProrroga->save();

                        $msj='La Solicitud de Prórroga '.$newSolicProrroga->titulo.' ha sido registrada con éxito, por favor espere hasta que el Administrador del sistema revise la solicitud y pueda aprobarla';
                        break;

                    }
                   
                }

            }
            if(!$b){
                $result='0';
                $msj='Ocurrió un error en el procesamiento de datos, por favor comunicarse con el Administrador del Sistema o con la OGTISE';
                $selector='txtmotivoProrroga';
            }
            
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
        $idSubmodulo=$request->idSubmodulo;
        $idProrroga=$request->idProrroga;

        $atencion=$request->atencion;
        $motivoatencion=$request->motivoatencion;
        $nuevaFecha=$request->nuevaFecha;


        $result='1';
        $msj='';
        $selector='txtmotivoatencion';

        $input1  = array('atencion' => $atencion);
        $reglas1 = array('atencion' => 'required');

        $input2  = array('motivoatencion' => $motivoatencion);
        $reglas2 = array('motivoatencion' => 'required');

        $input3  = array('nuevaFecha' => $nuevaFecha);
        $reglas3 = array('nuevaFecha' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

  
        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe de Remitir la opción de Atención de la Solicitud';
            $selector='cbuatencion';

        }elseif($validator2->fails())
        {
            $result='0';
            $msj='Debe de Consignar el motivo de la atención de la solicitud';
            $selector='txtmotivoatencion';
        }
        elseif($validator3->fails() && $atencion == '2')
        {
            $result='0';
            $msj='Debe de Consignar la fecha de ampliación de prórroga';
            $selector='txtnuevaFecha';
        }
        else{

            if($atencion == '2'){

                $h=Date('Y-m-d');
                $hoy = new DateTime($h);
                $cast = new DateTime($nuevaFecha);

                $interval = $cast->diff($hoy);

                $dias = intval($interval->format('%a'));

                if($cast <= $hoy){
                    $result='0';
                    $msj='La fecha de ampliación de prórroga no puede ser igual o menor a la fecha actual '.$dias;
                    $selector='txtnuevaFecha';
                }else{

                    $interval = $cast->diff($hoy);

                    $dias = intval($interval->format('%a'));

                    if($dias<=0 || $dias > 7){
                        $result='0';
                        $msj='La fecha de ampliación de prórroga no puede ser mayor a 7 días después del día de hoy '.$dias;
                        $selector='txtnuevaFecha';
                    }
                    else{

                        $h=Date('Y-m-d');
                        $prorroga = Prorroga::find($idProrroga);

                        $prorroga->motivoatencion = $motivoatencion;
                        $prorroga->estado = $atencion;
                        $prorroga->fechainicio = $h;
                        $prorroga->fechafin = $nuevaFecha;
                        $prorroga->user_id_atiende = Auth::user()->id;

                        $prorroga->save();

                        $submodulo = Submodulo::find($idSubmodulo);
                        $submodulo->fechafin = $nuevaFecha;
                        $submodulo->save();

                        $msj='La Solicitud de Prórroga '.$prorroga->titulo.' ha sido aceptada con éxito, se amplió la fecha programada hasta el'.pasFechaVista($nuevaFecha).' Comunicar a los usuarios';
                    }
                }
            } else{

                $prorroga = Prorroga::find($idProrroga);

                $prorroga->motivoatencion = $motivoatencion;
                $prorroga->estado = $atencion;
                $prorroga->user_id_atiende = Auth::user()->id;

                $prorroga->save();

                $msj='La Solicitud de Prórroga '.$prorroga->titulo.' ha sido rechazada con éxito, no se modificó ni se amplió la fecha programada';
            } 

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
        //
    }
}
