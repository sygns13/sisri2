<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Banco;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class BancoController extends Controller
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


            $modulo="banco";
            return view('banco.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $bancos = Banco::where('borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        })
     ->orderBy('id')->paginate(30);

     return [
        'pagination'=>[
            'total'=> $bancos->total(),
            'current_page'=> $bancos->currentPage(),
            'per_page'=> $bancos->perPage(),
            'last_page'=> $bancos->lastPage(),
            'from'=> $bancos->firstItem(),
            'to'=> $bancos->lastItem(),
        ],
        'bancos'=>$bancos
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
        $activo=$request->activo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');


        $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del Banco';
            $selector='txtnom';

        }
        else{

            $newBanco = new Banco();
            $newBanco->nombre=$nombre;
            $newBanco->activo=$activo;
            $newBanco->borrado='0';

            $newBanco->save();

            $msj='Nuevo Banco registrado con éxito';
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
        $nombre=$request->nombre;
        $activo=$request->activo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
 

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre del Banco';
            $selector='txtnomE';

        }
        else{

            $editBanco = Banco::findOrFail($id);
            $editBanco->nombre=$nombre;
            $editBanco->activo=$activo;

            $editBanco->save();

            $msj='El Banco ha sido modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$activo)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Banco::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='El Banco fue Desactivado exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='El Banco fue Activado exitosamente';
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

        $consulta1=DB::table('depositos')
                    ->join('bancos', 'depositos.banco_id', '=', 'bancos.id')
                    ->where('bancos.id',$id)->count();


        if($consulta1>0) {
            $result='0';
            $msj='El Banco Seleccionado no se puede eliminar debido a que cuenta con registros de depósitos registrados en el';
        }else{
        
        $borrar = Banco::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Banco eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
