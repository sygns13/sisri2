<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facultad;
use App\Escuela;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);
class EscuelaController extends Controller
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


            $modulo="escuela";
            return view('escuela.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $escuelas = DB::table('escuelas')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->where('escuelas.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.nombre')
     ->orderBy('escuelas.nombre')
     ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
     ->paginate(30);

     $facultads=Facultad::where('borrado','0')->where('activo','1')->orderBy('nombre')->get();

     return [
        'pagination'=>[
            'total'=> $escuelas->total(),
            'current_page'=> $escuelas->currentPage(),
            'per_page'=> $escuelas->perPage(),
            'last_page'=> $escuelas->lastPage(),
            'from'=> $escuelas->firstItem(),
            'to'=> $escuelas->lastItem(),
        ],
        'escuelas'=>$escuelas,
        'facultads'=>$facultads
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
        $facultad_id=$request->facultad_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:escuelas,nombre'.',1,borrado');

        $input3  = array('facultad_id' => $facultad_id);
        $reglas3 = array('facultad_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Escuela';
            $selector='txtesc';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Escuela, la Escuela ingresada ya se encuentra registrada';
            $selector='txtesc';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione una Facultad';
            $selector='cbsFacultad';
        }
       
        else{

            $newEscuela = new Escuela();
            $newEscuela->nombre=$nombre;
            $newEscuela->activo=$activo;
            $newEscuela->borrado='0';
            $newEscuela->facultad_id=$facultad_id;

            $newEscuela->save();

            $msj='Nueva Escuela registrada con éxito';
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
        $facultad_id=$request->facultad_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:escuelas,nombre,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input3  = array('facultad_id' => $facultad_id);
        $reglas3 = array('facultad_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Escuela';
            $selector='txtescE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Escuela, la Escuela ingresada ya se encuentra registrada';
            $selector='txtescE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione una Facultad';
            $selector='cbsFacultadE';
        }
       
        else{

            $editEscuela = Escuela::findOrFail($id);
            $editEscuela->nombre=$nombre;
            $editEscuela->activo=$activo;
            $editEscuela->facultad_id=$facultad_id;

            $editEscuela->save();

            $msj='Escuela modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function altabaja($id,$activo)
    {
        $result='1';
        $msj='';
        $selector='';

        $update = Escuela::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='La Escuela fue Desactivada exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='La Escuela fue Activada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('alumnos')
                    ->join('escuelas', 'alumnos.escuela_id', '=', 'escuelas.id')
                    ->where('alumnos.borrado','0')
                    ->where('escuelas.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='La Escuela Profesional Seleccionada no se puede eliminar debido a que cuenta con registros de Alumnos registrados en ella';
        }else{
        
        $borrar = Escuela::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Escuela Profesional eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;


        Excel::create('Escuelas Profesionales de la UNASAM', function($excel) use($buscar)  {
            $excel->sheet('Base de Datos Escuelas', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:E3');
                $sheet->cells('A3:E3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:E3', 'thin');
                $sheet->cells('A3:E3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:D4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });
                $sheet->cells('E4:E4', function($cells)
                {
                    $cells->setBackground('#E02F2F');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'50',
                'C'=>'50',
                'D'=>'20',
                'E'=>'40'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS ESCUELAS PROFESIONALES DE LA UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:D4', 'thin');
                array_push($data, array('N°','ESCUELA PROFESIONAL','FACULTAD','ESTADO','CÓDIGO PARA IMPORTACIÓN DE DATOS'));

                $cont=5;
                $cont2=5;

				$escuelas = DB::table('escuelas')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->where('escuelas.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.nombre')
     ->orderBy('escuelas.nombre')
     ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
     ->get();

        foreach ($escuelas as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':E'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
		   $dato->nombre,
		   $dato->facultad,
           activoInactivo($dato->activo),
           $dato->id   
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }



}
