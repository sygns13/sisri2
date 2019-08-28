<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Categoria;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class CategoriaController extends Controller
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


            $modulo="categoria";
            return view('categoria.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4,5])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="repcategorias";
            return view('repcategorias.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $categorias = Categoria::where('borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('descripcion','like','%'.$buscar.'%');
        $query->orWhere('code','like','%'.$buscar.'%');
        })
     ->orderBy('descripcion')->paginate(30);

     return [
        'pagination'=>[
            'total'=> $categorias->total(),
            'current_page'=> $categorias->currentPage(),
            'per_page'=> $categorias->perPage(),
            'last_page'=> $categorias->lastPage(),
            'from'=> $categorias->firstItem(),
            'to'=> $categorias->lastItem(),
        ],
        'categorias'=>$categorias
    ];
    }


    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $categorias = Categoria::where('borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('descripcion','like','%'.$buscar.'%');
        $query->orWhere('code','like','%'.$buscar.'%');
        })
     ->orderBy('descripcion')->get();

     return [
        
        'dataimp'=>$categorias
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
        $descripcion=$request->descripcion;
        $code=$request->code;
        $activo=$request->activo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:categorias,descripcion'.',1,borrado');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:categorias,code'.',1,borrado');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete la descripción de la categoría';
            $selector='txtdesc';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el código de la categoría';
            $selector='txtcod';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='La Descripción de la Categoría Ingresada ya se encuentra Registrada';
            $selector='txtdesc';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='El Código Ingresado ya se encuentra Registrado';
            $selector='txtcod';
        }
        else{

            $newLocal = new Categoria();
            $newLocal->descripcion=$descripcion;
            $newLocal->code=$code;
            $newLocal->activo=$activo;
            $newLocal->borrado='0';

            $newLocal->save();

            $msj='Nueva Categoría registrada con éxito';
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
        $descripcion=$request->descripcion;
        $code=$request->code;
        $activo=$request->activo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:categorias,descripcion'.',1,borrado');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:categorias,code'.',1,borrado');

        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete la descripción de la categoría';
            $selector='txtdescE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el código de la categoría';
            $selector='txtcodE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='La Descripción de la Categoría Ingresada ya se encuentra Registrada';
            $selector='txtdescE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='El Código Ingresado ya se encuentra Registrado';
            $selector='txtcodE';
        }
        else{

            $newLocal =Categoria::findOrFail($id);
            $newLocal->descripcion=$descripcion;
            $newLocal->code=$code;
            $newLocal->activo=$activo;

            $newLocal->save();

            $msj='Categoría modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function altabaja($id,$activo)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Categoria::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='La Categoría fue Desactivada exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='La Categoría fue Activada exitosamente';
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

        $consulta1=DB::table('rubros')
                    ->join('categorias', 'rubros.categoria_id', '=', 'categorias.id')
                    ->where('rubros.borrado','0')
                    ->where('categorias.id',$id)->count();


        if($consulta1>0) {
            $result='0';
            $msj='La Categoría Seleccionada no se puede eliminar debido a que cuenta con registros de rubros registrados en ella';
        }
        else{
        
        $borrar = Categoria::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Categoría eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
