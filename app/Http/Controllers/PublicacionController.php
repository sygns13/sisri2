<?php

namespace App\Http\Controllers;

use App\Publicacion;
use App\Investigacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicacionController extends Controller
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
        $nombre=$request->nombre;
        $detalles=$request->detalles;
        $fecha=$request->fecha;




           if (strlen(trim($nombre))==0) {
                $result='0';
                $msj='Ingrese un nombre de Publicación';
                $selector='txtnombre';
            }
            elseif (strlen(trim($fecha))==0) {
                $result='0';
                $msj='Ingrese una fecha válida';
                $selector='fecha';
            }
            else{

    
                    $newPublicacion = new Publicacion();

                    $newPublicacion->nombre=$nombre;
                    $newPublicacion->detalles=$detalles;
                    $newPublicacion->fecha=$fecha;
                    $newPublicacion->investigacion_id=$investigacion_id;
                    $newPublicacion->activo='1';
                    $newPublicacion->borrado='0';                   

                    $newPublicacion->save();

                    $msj='Nuevo Registro de Publicación de Investigación registrado con éxito';
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


        $borrar = Publicacion::destroy($id);


        $msj='Publicación eliminada exitosamente';
     

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
