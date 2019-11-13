<?php

namespace App\Http\Controllers;

use App\Autor;
use App\Revistapublicacion;
use App\Persona;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Validator;
use Auth;
use DB;

use App\Tipouser;
use App\User;

use Storage;
use stdClass;

class AutorController extends Controller
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

        $revistaspublicacion_id=$request->revistaspublicacion_id;
        $cargo=$request->cargo;
        $persona_id=$request->persona_id;



           if (intval($persona_id)==0) {
                $result='0';
                $msj='Seleccione un Autor a Registrar';
                $selector='cbsautor';
            }

            else{

    
                    $newAutor = new Autor();

                    $newAutor->persona_id=$persona_id;
                    $newAutor->cargo=$cargo;
                    $newAutor->revistaspublicacion_id=$revistaspublicacion_id;
                    $newAutor->activo='1';
                    $newAutor->borrado='0';                   

                    $newAutor->save();

                    $msj='Nuevo Registro de Autor registrado con éxito';
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
        $msj='1';


        $borrar = Autor::destroy($id);


        $msj='Autor eliminado exitosamente';
     

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
