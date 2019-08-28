<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Rubro;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class RubroController extends Controller
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


            $modulo="rubro";
            return view('rubro.index',compact('tipouser','modulo'));
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


            $modulo="reprubros";
            return view('reprubros.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $rubros = DB::table('rubros')
     ->join('categorias', 'categorias.id', '=', 'rubros.categoria_id')
     ->where('rubros.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('rubros.descripcion','like','%'.$buscar.'%');
        $query->orWhere('rubros.code','like','%'.$buscar.'%');
        $query->orWhere('categorias.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('rubros.descripcion')
     ->select('rubros.id','rubros.descripcion','rubros.code','rubros.estado','rubros.borrado','rubros.categoria_id','categorias.descripcion as categoria','categorias.code as codcategoria')
     ->paginate(30);

     $categorias=Categoria::where('borrado','0')->where('activo','1')->orderBy('descripcion')->get();

     return [
        'pagination'=>[
            'total'=> $rubros->total(),
            'current_page'=> $rubros->currentPage(),
            'per_page'=> $rubros->perPage(),
            'last_page'=> $rubros->lastPage(),
            'from'=> $rubros->firstItem(),
            'to'=> $rubros->lastItem(),
        ],
        'rubros'=>$rubros,
        'categorias'=>$categorias
    ];
    }


    public function buscarDatosImp(Request $request)
    {   
     $buscar=$request->busca;

     $rubros = DB::table('rubros')
     ->join('categorias', 'categorias.id', '=', 'rubros.categoria_id')
     ->where('rubros.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('rubros.descripcion','like','%'.$buscar.'%');
        $query->orWhere('rubros.code','like','%'.$buscar.'%');
        $query->orWhere('categorias.descripcion','like','%'.$buscar.'%');
        })
     ->orderBy('rubros.descripcion')
     ->select('rubros.id','rubros.descripcion','rubros.code','rubros.estado','rubros.borrado','rubros.categoria_id','categorias.descripcion as categoria','categorias.code as codcategoria')
     ->get();



     return [

        'dataimp'=>$rubros
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
        $estado=$request->estado;
        $categoria_id=$request->categoria_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:rubros,descripcion'.',1,borrado');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:rubros,code'.',1,borrado');

        $input5 = array('categoria_id' => $categoria_id);
        $reglas5 = array('categoria_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el descripción del Rubro';
            $selector='txtdesc';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el Código del Rubro';
            $selector='txtcod';
        }
        elseif (1==2) {
            $result='0';
            $msj='Ingrese otra descripción del Rubro, la descripción seleccionada ya se encuentra registrada.';
            $selector='txtdesc';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese otro código del Rubro, el código seleccionado ya se encuentra registrado.';
            $selector='txtcod';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione una Categoría Válido.';
            $selector='cbsCategoria';
        }
        else{

            $newRubro = new Rubro();
            $newRubro->descripcion=$descripcion;
            $newRubro->code=$code;
            $newRubro->estado=$estado;
            $newRubro->borrado='0';
            $newRubro->categoria_id=$categoria_id;

            $newRubro->save();

            $msj='Nuevo Rubro registrado con éxito';
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
        $estado=$request->estado;
        $categoria_id=$request->categoria_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2 = array('code' => $code);
        $reglas2 = array('code' => 'required');

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'unique:rubros,descripcion'.',1,borrado');

        $input4  = array('code' => $code);
        $reglas4 = array('code' => 'unique:rubros,code'.',1,borrado');

        $input5 = array('categoria_id' => $categoria_id);
        $reglas5 = array('categoria_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el descripción del Rubro';
            $selector='txtdescE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Complete el Código del Rubro';
            $selector='txtcodE';
        }
        elseif (1==2) {
            $result='0';
            $msj='Ingrese otra descripción del Rubro, la descripción seleccionada ya se encuentra registrada.';
            $selector='txtdescE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese otro código del Rubro, el código seleccionado ya se encuentra registrado.';
            $selector='txtcodE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione una Categoría Válido.';
            $selector='cbsCategoriaE';
        }
        else{

            $newRubro = Rubro::findOrFail($id);
            $newRubro->descripcion=$descripcion;
            $newRubro->code=$code;
            $newRubro->estado=$estado;
            $newRubro->borrado='0';
            $newRubro->categoria_id=$categoria_id;

            $newRubro->save();

            $msj='Rubro modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Rubro::findOrFail($id);
        $update->estado=$estado;
        $update->save();

        if(strval($estado)=="0"){
            $msj='El Rubro fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Rubro fue Activado exitosamente';
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

        $consulta1=DB::table('precios')
                    ->join('rubros', 'precios.rubro_id', '=', 'rubros.id')
                    ->where('precios.borrado','0')
                    ->where('rubros.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='El Rubro Seleccionado no se puede eliminar debido a que cuenta con registros de Precios registrados en él';
        }else{
        
        $borrar = Rubro::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Rubro eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
