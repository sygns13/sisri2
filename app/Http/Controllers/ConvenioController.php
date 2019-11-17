<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Convenio;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);
class ConvenioController extends Controller
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


            $modulo="conveniosmarco";
            return view('conveniosmarco.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function index2()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="conveniosespecificos";
            return view('conveniosespecificos.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }

    public function index3()
    {
        if(accesoUser([1,2])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="convenioscolaboracion";
            return view('convenioscolaboracion.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');          
        }
    }



    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $tipo=$request->tipo;

     $convenios = Convenio::where('borrado','0')
     ->where('activo','1')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        $query->orwhere('institucion','like','%'.$buscar.'%');
        $query->orwhere('resolucion','like','%'.$buscar.'%');
        $query->orwhere('objetivo','like','%'.$buscar.'%');
        $query->orwhere('obligaciones','like','%'.$buscar.'%');
        })
     ->orderBy('id')->paginate(30);

     return [
        'pagination'=>[
            'total'=> $convenios->total(),
            'current_page'=> $convenios->currentPage(),
            'per_page'=> $convenios->perPage(),
            'last_page'=> $convenios->lastPage(),
            'from'=> $convenios->firstItem(),
            'to'=> $convenios->lastItem(),
        ],
        'convenios'=>$convenios
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
        $descripcion=$request->descripcion;
        $institucion=$request->institucion;
        $resolucion=$request->resolucion;
        $objetivo=$request->objetivo;
        $obligaciones=$request->obligaciones;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $estado=$request->estado;
        $tipo=$request->tipo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('institucion' => $institucion);
        $reglas2 = array('institucion' => 'required');

        $input3  = array('resolucion' => $resolucion);
        $reglas3 = array('resolucion' => 'required');

        $input4  = array('objetivo' => $objetivo);
        $reglas4 = array('objetivo' => 'required');

        $input5  = array('obligaciones' => $obligaciones);
        $reglas5 = array('obligaciones' => 'required');

        $input6  = array('fechainicio' => $fechainicio);
        $reglas6 = array('fechainicio' => 'required');

        $input7  = array('fechafinal' => $fechafinal);
        $reglas7 = array('fechafinal' => 'required');

        $input8  = array('estado' => $estado);
        $reglas8 = array('estado' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);


        if ($validator1->fails())
        {
            $result='0';
            $msj='ingrese el nombre del convenio';
            $selector='txtnombre';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='ingrese la Institución con la que se firmó el convenio';
            $selector='txtinstitucion';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='ingrese la Resolución que Oficializa el convenio';
            $selector='resolucion';
        }
        elseif ($validator4->fails())
        {
            $result='0';
            $msj='ingrese el objetivo del convenio';
            $selector='objetivo';
        }
        elseif ($validator5->fails())
        {
            $result='0';
            $msj='ingrese las obligaciones del convenio';
            $selector='txtobligaciones';
        }
        elseif ($validator6->fails())
        {
            $result='0';
            $msj='ingrese la fecha de inicio del convenio';
            $selector='txtfechainicio';
        }
        elseif ($validator7->fails())
        {
            $result='0';
            $msj='ingrese la fecha de finalización del convenio';
            $selector='fechafinal';
        }
        elseif ($validator8->fails())
        {
            $result='0';
            $msj='ingrese el estado del convenio';
            $selector='cbuestado';
        }
        else{

            $newConvenio = new Convenio();
            $newConvenio->nombre=$nombre;
            $newConvenio->descripcion=$descripcion;
            $newConvenio->institucion=$institucion;
            $newConvenio->resolucion=$resolucion;
            $newConvenio->objetivo=$objetivo;
            $newConvenio->obligaciones=$obligaciones;
            $newConvenio->fechainicio=$fechainicio;
            $newConvenio->fechafinal=$fechafinal;
            $newConvenio->estado=$estado;
            $newConvenio->tipo=$tipo;
            $newConvenio->activo='1';
            $newConvenio->borrado='0';

            $newConvenio->save();

            $msj='Nuevo Convenio registrado con éxito';
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
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $institucion=$request->institucion;
        $resolucion=$request->resolucion;
        $objetivo=$request->objetivo;
        $obligaciones=$request->obligaciones;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $estado=$request->estado;
        $tipo=$request->tipo;



        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('institucion' => $institucion);
        $reglas2 = array('institucion' => 'required');

        $input3  = array('resolucion' => $resolucion);
        $reglas3 = array('resolucion' => 'required');

        $input4  = array('objetivo' => $objetivo);
        $reglas4 = array('objetivo' => 'required');

        $input5  = array('obligaciones' => $obligaciones);
        $reglas5 = array('obligaciones' => 'required');

        $input6  = array('fechainicio' => $fechainicio);
        $reglas6 = array('fechainicio' => 'required');

        $input7  = array('fechafinal' => $fechafinal);
        $reglas7 = array('fechafinal' => 'required');

        $input8  = array('estado' => $estado);
        $reglas8 = array('estado' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);


        if ($validator1->fails())
        {
            $result='0';
            $msj='ingrese el nombre del convenio';
            $selector='txtnombreE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='ingrese la Institución con la que se firmó el convenio';
            $selector='txtinstitucionE';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='ingrese la Resolución que Oficializa el convenio';
            $selector='resolucionE';
        }
        elseif ($validator4->fails())
        {
            $result='0';
            $msj='ingrese el objetivo del convenio';
            $selector='objetivoE';
        }
        elseif ($validator5->fails())
        {
            $result='0';
            $msj='ingrese las obligaciones del convenio';
            $selector='txtobligacionesE';
        }
        elseif ($validator6->fails())
        {
            $result='0';
            $msj='ingrese la fecha de inicio del convenio';
            $selector='txtfechainicioE';
        }
        elseif ($validator7->fails())
        {
            $result='0';
            $msj='ingrese la fecha de finalización del convenio';
            $selector='fechafinalE';
        }
        elseif ($validator8->fails())
        {
            $result='0';
            $msj='ingrese el estado del convenio';
            $selector='cbuestadoE';
        }
        else{

            $newConvenio = Convenio::find($id);
            $newConvenio->nombre=$nombre;
            $newConvenio->descripcion=$descripcion;
            $newConvenio->institucion=$institucion;
            $newConvenio->resolucion=$resolucion;
            $newConvenio->objetivo=$objetivo;
            $newConvenio->obligaciones=$obligaciones;
            $newConvenio->fechainicio=$fechainicio;
            $newConvenio->fechafinal=$fechafinal;
            $newConvenio->estado=$estado;


            $newConvenio->save();

            $msj='Convenio modificado con éxito';
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

  
        
        $borrar = Convenio::destroy($id);


        $msj='Convenio eliminado exitosamente';
 

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }








    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;



        Excel::create('Convenios Marco - UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('BD Convenios', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:J3');
                $sheet->cells('A3:J3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:J3', 'thin');
                $sheet->cells('A3:J3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:J4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'45',
                'C'=>'65',
                'D'=>'45',
                'E'=>'30',
                'F'=>'65',
                'G'=>'85',
                'H'=>'25',
                'I'=>'25',
                'J'=>'20',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS CONVENIOS MARCO - UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:J4', 'thin');
                array_push($data, array('N°','NOMBRE', 'DESCRIPCIÓN','INSTITUCIÓN','RESOLUCIÓN','OBJETIVO','OBLIGACIONES','FECHA DE INICIO','FECHA DE FINALIZACIÓN','ESTADO'));

                $cont=5;
                $cont2=5;

    $convenios = Convenio::where('borrado','0')
     ->where('activo','1')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        $query->orwhere('institucion','like','%'.$buscar.'%');
        $query->orwhere('resolucion','like','%'.$buscar.'%');
        $query->orwhere('objetivo','like','%'.$buscar.'%');
        $query->orwhere('obligaciones','like','%'.$buscar.'%');
        })
     ->orderBy('id')->get();

        foreach ($convenios as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':J'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->descripcion,
           $dato->institucion,
           $dato->resolucion,
           $dato->objetivo,
           $dato->obligaciones,
           pasFechaVista($dato->fechainicio),
           pasFechaVista($dato->fechafinal),
           estadoConvenio($dato->estado)
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }








    public function descargarExcel2(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;



        Excel::create('Convenios Específicos - UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('BD Convenios', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:J3');
                $sheet->cells('A3:J3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:J3', 'thin');
                $sheet->cells('A3:J3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:J4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'45',
                'C'=>'65',
                'D'=>'45',
                'E'=>'30',
                'F'=>'65',
                'G'=>'85',
                'H'=>'25',
                'I'=>'25',
                'J'=>'20',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS CONVENIOS ESPECÍFICOS - UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:J4', 'thin');
                array_push($data, array('N°','NOMBRE', 'DESCRIPCIÓN','INSTITUCIÓN','RESOLUCIÓN','OBJETIVO','OBLIGACIONES','FECHA DE INICIO','FECHA DE FINALIZACIÓN','ESTADO'));

                $cont=5;
                $cont2=5;

    $convenios = Convenio::where('borrado','0')
     ->where('activo','1')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        $query->orwhere('institucion','like','%'.$buscar.'%');
        $query->orwhere('resolucion','like','%'.$buscar.'%');
        $query->orwhere('objetivo','like','%'.$buscar.'%');
        $query->orwhere('obligaciones','like','%'.$buscar.'%');
        })
     ->orderBy('id')->get();

        foreach ($convenios as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':J'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->descripcion,
           $dato->institucion,
           $dato->resolucion,
           $dato->objetivo,
           $dato->obligaciones,
           pasFechaVista($dato->fechainicio),
           pasFechaVista($dato->fechafinal),
           estadoConvenio($dato->estado)
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }







    public function descargarExcel3(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;



        Excel::create('Convenios de Colaboración - UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('BD Convenios', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:J3');
                $sheet->cells('A3:J3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:J3', 'thin');
                $sheet->cells('A3:J3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:J4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'45',
                'C'=>'65',
                'D'=>'45',
                'E'=>'30',
                'F'=>'65',
                'G'=>'85',
                'H'=>'25',
                'I'=>'25',
                'J'=>'20',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS CONVENIOS DE COLABORACIÓN - UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:J4', 'thin');
                array_push($data, array('N°','NOMBRE', 'DESCRIPCIÓN','INSTITUCIÓN','RESOLUCIÓN','OBJETIVO','OBLIGACIONES','FECHA DE INICIO','FECHA DE FINALIZACIÓN','ESTADO'));

                $cont=5;
                $cont2=5;

    $convenios = Convenio::where('borrado','0')
     ->where('activo','1')
     ->where('tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('nombre','like','%'.$buscar.'%');
        $query->orwhere('descripcion','like','%'.$buscar.'%');
        $query->orwhere('institucion','like','%'.$buscar.'%');
        $query->orwhere('resolucion','like','%'.$buscar.'%');
        $query->orwhere('objetivo','like','%'.$buscar.'%');
        $query->orwhere('obligaciones','like','%'.$buscar.'%');
        })
     ->orderBy('id')->get();

        foreach ($convenios as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':J'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');


           array_push($data, array($key+1,
           $dato->nombre,
           $dato->descripcion,
           $dato->institucion,
           $dato->resolucion,
           $dato->objetivo,
           $dato->obligaciones,
           pasFechaVista($dato->fechainicio),
           pasFechaVista($dato->fechafinal),
           estadoConvenio($dato->estado)
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }




}
