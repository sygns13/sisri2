<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipopersona;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use App\Modulo;
use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

use stdClass;

class PermisoController extends Controller
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

        $idmodulo=$request->idmodulo;
        $idsubmodulo=$request->idsubmodulo;
        $id=$request->id;


        $permisomodulos=Permisomodulo::where('modulo_id',$idmodulo)->where('user_id',$id)->get();
        $permisossubmodulo=Permisossubmodulo::where('submodulo_id',$idsubmodulo)->where('user_id',$id)->get();

        //$permisomodulos=Permisomodulo::where('modulo_id',$idmodulo)->where('user_id',$id)->count();
        $badnera1=true;
        $aux=false;


        foreach ($permisomodulos as $key => $dato) {    
            $aux=true;
            if(intval($dato->tipo)==2)
            {
                $result='0';
                $msj='Permiso ya asignado, para Acceso Total del Módulo, no se puede asignar el mismo permiso o un permiso de submódulo';
                $selector='cbumodulo';
                $badnera1=false;
                break;
                
                
            }
            else{


                    foreach($permisossubmodulo as $key2 => $dato2) {
                        if($idsubmodulo==$dato2->submodulo_id)
                        {
                            $result='0';
                            $msj='Permiso ya asignado, no se puede asignar nuevamente';
                            $selector='cbumodulo';
                            $badnera1=false;
                            break;
                        }
                        
                    }
             


            }
        }

        if($badnera1)
        {
            $bandera2=true;
            if($aux==true &&  $idsubmodulo==0)
            {
                foreach ($permisomodulos as $key => $dato) {

                    
                    $submoduloBorrarPermiso=Submodulo::where('modulo_id',$dato->modulo_id)->get();
                    foreach($submoduloBorrarPermiso as $submod)
                    {
                        $borrar = Permisossubmodulo::where('submodulo_id',$submod->id)->delete();
                        
                        //destroy($id);
                    }   
                    
                
            }
            $borrar = Permisomodulo::where('modulo_id',$idmodulo)->delete();

            }
            
            elseif($aux==true)
            {
                $bandera2=false;

            }

            $tipo=1;

            if($idsubmodulo==0){
                $tipo=2;

            }

            if($bandera2==true)
{


                    $newPermisoModulo = new Permisomodulo();
                    $newPermisoModulo->activo='1';
                    $newPermisoModulo->borrado='0';
                    $newPermisoModulo->modulo_id=$idmodulo;
                    $newPermisoModulo->user_id=$id;
                    $newPermisoModulo->tipo=$tipo;

                    $newPermisoModulo->save();
                }
                    if($tipo==1){
                    
                    $newPermisoSubModulo = new Permisossubmodulo();
                    $newPermisoSubModulo->activo='1';
                    $newPermisoSubModulo->borrado='0';
                    $newPermisoSubModulo->submodulo_id=$idsubmodulo;
                    $newPermisoSubModulo->user_id=$id;

                    $newPermisoSubModulo->save();
                    }


                    $msj='Credencial de Acceso registrado con éxito';


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

   
        
        $borrar = Permisomodulo::destroy($id);
        //$task->delete();


        $msj='Credencial de Acceso Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function delete($id1, $id2, $idMod,$iduser)
    {
        $result='1';
        $msj='1';

        $permisos=0;
        $submodulos=Submodulo::where('modulo_id',$idMod)->get();

        foreach ($submodulos as $key => $dato) {
            
            $permisos=$permisos+Permisossubmodulo::where('submodulo_id',$dato->id)->where('user_id',$iduser)->count();
        }

        

       
        if($permisos==1){
            $borrar = Permisomodulo::destroy($id1);
        }
        
        $borrar = Permisossubmodulo::destroy($id2);
        //$task->delete();


        $msj='Credencial de Acceso Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
