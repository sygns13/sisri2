<?php

namespace App\Http\Controllers;

use App\Detalleinvestigacion;
use App\Investigacion;
use App\Investigador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Storage;
use stdClass;

class DetalleinvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        $result='1';
        $msj='';
        $selector='';

        $investigacion_id=$request->investigacion_id;
        $cargo=$request->cargo;
        $tipoAutor=$request->tipoAutor;
        $investigador_id=$request->investigador_id;


        $validar=Detalleinvestigacion::where('investigacion_id',$investigacion_id)->where('investigador_id',$investigador_id)->where('activo','1')->where('borrado','0')->count();


           if (intval($investigador_id)==0) {
                $result='0';
                $msj='Seleccione un Investigador a Registrar';
                $selector='cbsinvestigador';
            }
            elseif ($validar>0) {
                $result='0';
                $msj='Seleccione Otro Investigador a Registrar, Investigador ya registrado';
                $selector='cbsinvestigador';
            }
            else{

    
                    $newdetalleInvestigadcion = new Detalleinvestigacion();

                    $newdetalleInvestigadcion->investigacion_id=$investigacion_id;
                    $newdetalleInvestigadcion->cargo=$cargo;
                    $newdetalleInvestigadcion->tipoAutor=$tipoAutor;
                    $newdetalleInvestigadcion->investigador_id=$investigador_id;
                    $newdetalleInvestigadcion->activo='1';
                    $newdetalleInvestigadcion->borrado='0';                   

                    $newdetalleInvestigadcion->save();

                    $msj='Nuevo Registro de Autor de Investigación registrado con éxito';
                }
            


    return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Detalleinvestigacion  $detalleinvestigacion
     * @return \Illuminate\Http\Response
     */
    public function show(Detalleinvestigacion $detalleinvestigacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detalleinvestigacion  $detalleinvestigacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Detalleinvestigacion $detalleinvestigacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detalleinvestigacion  $detalleinvestigacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detalleinvestigacion $detalleinvestigacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detalleinvestigacion  $detalleinvestigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';


        $borrar = Detalleinvestigacion::destroy($id);


        $msj='Autor eliminado exitosamente';
     

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
