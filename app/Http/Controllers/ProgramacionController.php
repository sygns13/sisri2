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


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

use stdClass;
use DateTime;

class ProgramacionController extends Controller
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


            $modulo="programacion";
            $tipousers=Tipouser::orderBy('id')->where('borrado','0')->get();
            $modulos=Modulo::orderBy('id')->where('borrado','0')->where('id','>','1')->get();
            $submodulos=Submodulo::orderBy('id')->where('borrado','0')->where('modulo_id','>','1')->get();

            return view('programacion.index',compact('tipouser','modulo','tipousers','modulos','submodulos'));
        }
        else
        {
            return redirect('home');    
        }
    }


    public function index(Request $request)
    {

        $submodulos = DB::table('submodulos')
            ->join('modulos', 'modulos.id', '=', 'submodulos.modulo_id')    
            ->leftJoin('programacions', function($join)
            {
                $join->on('submodulos.id', '=', 'programacions.submodulo_id')
                ->where('programacions.activo', '=', '1')
                ->where('programacions.borrado', '=', '0');
            })
            ->where('submodulos.borrado','0')
            ->where('submodulos.activo','1')
            ->where('modulos.id','>','1')
            ->orderBy('modulos.id')
            ->orderBy('submodulos.id')
  
            ->select(
                'modulos.id as idModulo','modulos.modulo',
            'submodulos.id as id','submodulos.submodulo', 'submodulos.estado',
            DB::Raw('IFNULL( `submodulos`.`fechaini` , "" ) as fechaini'),
            DB::Raw('IFNULL( `submodulos`.`fechafin` , "" ) as fechafin'),
            DB::Raw('IFNULL( `programacions`.`id` , "0" ) as idProgramacion'),
            DB::Raw('IFNULL( `programacions`.`titulo` , "" ) as tituloProgramacion'),
            DB::Raw('IFNULL( `programacions`.`descripcion` , "" ) as descripcionProgramacion'),
            DB::Raw('IFNULL( `programacions`.`fechaini` , 0 ) as fechainiProgramacion'),
            DB::Raw('IFNULL( `programacions`.`fechafin` , "" ) as fechafinProgramacion'),      
            DB::Raw('IFNULL( `programacions`.`activo` , "" ) as activoProgramacion')      
            )
            ->get();

            

       

          return [
            'submodulos'=>$submodulos
        ];
    }


    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Submodulo::findOrFail($id);
        $update->estado=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='El Módulo fue cerrado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Módulo fue abierto exitosamente';
        }elseif(strval($estado)=="2"){
            $msj='Se activó la programación del módulo exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

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
        $idmodulo=$request->idmodulo;
        $idsubmodulo=$request->idsubmodulo;
        $titulo=$request->titulo;
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;
        $descripcion=$request->descripcion;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('idmodulo' => $idmodulo);
        $reglas1 = array('idmodulo' => 'required');

        $input2  = array('idsubmodulo' => $idsubmodulo);
        $reglas2 = array('idsubmodulo' => 'required');

        $input3  = array('titulo' => $titulo);
        $reglas3 = array('titulo' => 'required');

        $input4  = array('fechaini' => $fechaini);
        $reglas4 = array('fechaini' => 'required');

        $input5  = array('fechafin' => $fechafin);
        $reglas5 = array('fechafin' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails() || $idmodulo == '0')
        {
            $result='0';
            $msj='Debe de Seleccionar un Módulo';
            $selector='cbumodulo';

        }elseif($validator2->fails())
        {
            $result='0';
            $msj='Debe de Seleccionar un SubMódulo';
            $selector='cbusubmodulo';

        }elseif($validator3->fails())
        {
            $result='0';
            $msj='Complete un Título de Programación';
            $selector='txttitulo';

        }elseif($validator4->fails())
        {
            $result='0';
            $msj='Indique la fecha de Inicio';
            $selector='txtfechaini';

        }elseif($validator5->fails())
        {
            $result='0';
            $msj='Indique la fecha de Finalización';
            $selector='txtfechafin';

        }
        else{

            $h=Date('Y-m-d');
            $hoy = new DateTime($h);
            $cast = new DateTime($fechaini);
            $cast2 = new DateTime($fechafin);

            if($cast > $cast2){
                $result='0';
                $msj='La fecha de Finalización no puede ser menor a la fecha de Inicio';
                $selector='txtfechafin';
            }
            elseif($hoy > $cast2)
            {
                $result='0';
                $msj='La fecha de Finalización no puede ser menor a la fecha actual';
                $selector='txtfechafin';

            }
            else{

                $submodulos = null;

                if($idsubmodulo == '0'){

                    $submodulos = Submodulo::where('modulo_id',$idmodulo)->where('borrado','0')->get();
                }
                else{
                    $submodulos = Submodulo::where('id',$idsubmodulo)->where('borrado','0')->get();
                }

                foreach ($submodulos as $key => $dato) {

                    $programacions = Programacion::where('submodulo_id',$dato->id)->where('activo','1')->where('borrado','0')->get();

                    foreach ($programacions as $key2 => $dato2){
                        $editProgramacion = Programacion::find($dato2->id);
                        $editProgramacion->activo='0';
                        $editProgramacion->save();
                    }

                    $editSubmodulo = Submodulo::find($dato->id);

                    $editSubmodulo->estado='2';
                    $editSubmodulo->fechaini=$fechaini;
                    $editSubmodulo->fechafin=$fechafin;

                    $editSubmodulo->save();



                    $newProgramacion = new Programacion();
                    $newProgramacion->titulo = $titulo;
                    $newProgramacion->descripcion = $descripcion;
                    $newProgramacion->submodulo_id = $dato->id;
                    $newProgramacion->fechaini = $fechaini;
                    $newProgramacion->fechafin = $fechafin;
                    $newProgramacion->user_id = Auth::user()->id;
                    $newProgramacion->activo='1';
                    $newProgramacion->borrado='0';
                    $newProgramacion->save();

                }

                $msj='Nueva Programación Registrada con Éxito';

            }
            
        }




       //Areaunasam::create($request->all());

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
        //
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
        $msj='';
        $selector='';

        $programacion = Programacion::where('submodulo_id',$id)->where('activo','1')->where('borrado','0')->get();

        foreach($programacion as $key => $dato){
            $programa = Programacion::find($dato->id);
            $programa->activo='0';
            $programa->borrado='1';
            $programa->save();
        }

        $update = Submodulo::findOrFail($id);
        $update->estado="0";
        $update->fechaini=null;
        $update->fechafin=null;
        $update->save();

        $msj='La Programación fue eliminada Exitosamente, y el Módulo fue cerrado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }
}
