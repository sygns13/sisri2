<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
use App\Facultad;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class FacultadController extends Controller
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


            $modulo="facultad";
            return view('facultad.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $facultads = DB::table('facultads')
     ->join('locals', 'locals.id', '=', 'facultads.local_id')
     ->where('facultads.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('facultads.nombre','like','%'.$buscar.'%');
        $query->orWhere('locals.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.nombre')
     ->select('facultads.id','facultads.nombre','facultads.activo','facultads.borrado','facultads.local_id','locals.nombre as local','locals.direccion')
     ->paginate(30);

     $locals=Local::where('borrado','0')->where('activo','1')->orderBy('nombre')->get();

     return [
        'pagination'=>[
            'total'=> $facultads->total(),
            'current_page'=> $facultads->currentPage(),
            'per_page'=> $facultads->perPage(),
            'last_page'=> $facultads->lastPage(),
            'from'=> $facultads->firstItem(),
            'to'=> $facultads->lastItem(),
        ],
        'facultads'=>$facultads,
        'locals'=>$locals
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
        $local_id=$request->local_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:facultads,nombre'.',1,borrado');

        $input3  = array('local_id' => $local_id);
        $reglas3 = array('local_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Facultad';
            $selector='txtfac';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Facultad, la Facultad ingresada ya se encuentra registrada';
            $selector='txtfac';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione un Local';
            $selector='cbslocal';
        }
       
        else{

            $newFacultad = new Facultad();
            $newFacultad->nombre=$nombre;
            $newFacultad->activo=$activo;
            $newFacultad->borrado='0';
            $newFacultad->local_id=$local_id;

            $newFacultad->save();

            $msj='Nueva Facultad registrada con éxito';
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
        $local_id=$request->local_id;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:facultads,nombre,'.$id.',id,borrado,0');
        //$reglas4 = array('codigo' => 'unique:dependencias,cod_sis,'.$id.',id,borrado,0');

        $input3  = array('local_id' => $local_id);
        $reglas3 = array('local_id' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);


        if ($validator1->fails())
        {
            $result='0';
            $msj='Complete el nombre de la Facultad';
            $selector='txtfacE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese otro nombre de Facultad, la Facultad ingresada ya se encuentra registrada';
            $selector='txtfacE';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Seleccione un Local';
            $selector='cbslocalE';
        }
       
        else{

            $editFacultad = Facultad::findOrFail($id);
            $editFacultad->nombre=$nombre;
            $editFacultad->activo=$activo;
            $editFacultad->local_id=$local_id;

            $editFacultad->save();

            $msj='Facultad Modificada con éxito';
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

        $update = Facultad::findOrFail($id);
        $update->activo=$activo;
        $update->save();

        if(strval($activo)=="0"){
            $msj='La Facultad fue Desactivada exitosamente';
        }elseif(strval($activo)=="1"){
            $msj='La Facultad fue Activada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('escuelas')
                    ->join('facultads', 'escuelas.facultad_id', '=', 'facultads.id')
                    ->where('escuelas.borrado','0')
                    ->where('facultads.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='La Facultad Seleccionada no se puede eliminar debido a que cuenta con registros de Escuelas Profesionales registrados en ella';
        }else{
        
        $borrar = Facultad::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Facultad eliminada exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;


        Excel::create('Facultades de la UNASAM', function($excel) use($buscar)  {
            $excel->sheet('Base de Datos Facultades', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:F3');
                $sheet->cells('A3:F3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:F3', 'thin');
                $sheet->cells('A3:F3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:E4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

                $sheet->cells('F4:F4', function($cells)
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
                'D'=>'50',
                'E'=>'20',
                'F'=>'40'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS FACULTADES DE LA UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:E4', 'thin');
                array_push($data, array('N°','NOMBRE','LOCAL','DIRECCIÓN','ESTADO','CÓDIGO PARA IMPORTACIÓN DE DATOS'));

                $cont=5;
                $cont2=5;

				$facultads = DB::table('facultads')
     ->join('locals', 'locals.id', '=', 'facultads.local_id')
     ->where('facultads.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('facultads.nombre','like','%'.$buscar.'%');
        $query->orWhere('locals.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.nombre')
     ->select('facultads.id','facultads.nombre','facultads.activo','facultads.borrado','facultads.local_id','locals.nombre as local','locals.direccion')
     ->get();

        foreach ($facultads as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':E'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
		   $dato->nombre,
		   $dato->local,
		   $dato->direccion,
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
