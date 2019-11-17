<?php

namespace App\Http\Controllers;

use App\Tesis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;
use App\Facultad;
use App\Escuela;
use Validator;

use Excel;
set_time_limit(600);

class TesisController extends Controller
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


            $modulo="tesis";
            $facultads=Facultad::where('activo','1')->where('borrado','0')->get();

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

            return view('tesis.index',compact('tipouser','modulo','facultads','escuelas'));
        }
        else
        {
            return redirect('home');          
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;

     $tesis = DB::table('tesis')
     ->join('escuelas', 'escuelas.id', '=', 'tesis.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->where('tesis.borrado','0')
     ->where(function($query) use ($buscar){
        $query->where('tesis.nombreProyecto','like','%'.$buscar.'%');
        $query->orWhere('tesis.autor','like','%'.$buscar.'%');
        $query->orWhere('tesis.autor2','like','%'.$buscar.'%');
        $query->orWhere('tesis.fuenteFinanciamiento','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.id')
     ->orderBy('escuelas.id')
     ->orderBy('tesis.nombreProyecto')
     ->select('tesis.id','tesis.nombreProyecto','tesis.autor','tesis.fuenteFinanciamiento','tesis.autor2','tesis.escuela_id','escuelas.nombre as escuela','facultads.nombre as facultad', 'facultads.id as facultad_id')->paginate(50);


     return [
        'pagination'=>[
            'total'=> $tesis->total(),
            'current_page'=> $tesis->currentPage(),
            'per_page'=> $tesis->perPage(),
            'last_page'=> $tesis->lastPage(),
            'from'=> $tesis->firstItem(),
            'to'=> $tesis->lastItem(),
        ],
        'tesis'=>$tesis
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
        $nombreProyecto=$request->nombreProyecto;
        $autor=$request->autor;
        $fuenteFinanciamiento=$request->fuenteFinanciamiento;
        $autor2=$request->autor2;
        $escuela_id=$request->escuela_id;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombreProyecto' => $nombreProyecto);
        $reglas1 = array('nombreProyecto' => 'required');

        $input2  = array('autor' => $autor);
        $reglas2 = array('autor' => 'required');

        $input3  = array('fuenteFinanciamiento' => $fuenteFinanciamiento);
        $reglas3 = array('fuenteFinanciamiento' => 'required');

        $input4  = array('escuela_id' => $escuela_id);
        $reglas4 = array('escuela_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);


        if ($validator1->fails())
        {
            $result='0';
            $msj='ingrese el título del Proyecto';
            $selector='txtnombreProyecto';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='ingrese el Autor del Proyecto';
            $selector='txtautor';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='ingrese la Fuente de Financiamiento';
            $selector='txtfuenteFinanciamiento';
        }
        elseif ($validator4->fails() || intval($escuela_id)==0)
        {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='cbuescuela';
        }
        else{

            $newTesis = new Tesis();
            $newTesis->nombreProyecto=$nombreProyecto;
            $newTesis->autor=$autor;
            $newTesis->fuenteFinanciamiento=$fuenteFinanciamiento;
            $newTesis->autor2=$autor2;
            $newTesis->escuela_id=$escuela_id;
            $newTesis->activo='1';
            $newTesis->borrado='0';

            $newTesis->save();

            $msj='Nueva Tesis registrada con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function show(Tesis $tesis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function edit(Tesis $tesis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $nombreProyecto=$request->nombreProyecto;
        $autor=$request->autor;
        $fuenteFinanciamiento=$request->fuenteFinanciamiento;
        $autor2=$request->autor2;
        $escuela_id=$request->escuela_id;

        $result='1';
        $msj='';
        $selector='';

        $input1  = array('nombreProyecto' => $nombreProyecto);
        $reglas1 = array('nombreProyecto' => 'required');

        $input2  = array('autor' => $autor);
        $reglas2 = array('autor' => 'required');

        $input3  = array('fuenteFinanciamiento' => $fuenteFinanciamiento);
        $reglas3 = array('fuenteFinanciamiento' => 'required');

        $input4  = array('escuela_id' => $escuela_id);
        $reglas4 = array('escuela_id' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);


        if ($validator1->fails())
        {
            $result='0';
            $msj='ingrese el título del Proyecto';
            $selector='txtnombreProyectoE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='ingrese el Autor del Proyecto';
            $selector='txtautorE';
        }
        elseif ($validator3->fails())
        {
            $result='0';
            $msj='ingrese la Fuente de Financiamiento';
            $selector='txtfuenteFinanciamientoE';
        }
        elseif ($validator4->fails() || intval($escuela_id)==0)
        {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='cbuescuelaE';
        }
        else{

            $newTesis = Tesis::find($id);
            $newTesis->nombreProyecto=$nombreProyecto;
            $newTesis->autor=$autor;
            $newTesis->fuenteFinanciamiento=$fuenteFinanciamiento;
            $newTesis->autor2=$autor2;
            $newTesis->escuela_id=$escuela_id;

            $newTesis->save();

            $msj='Tesos modificada con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tesis  $tesis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

  
        
        $borrar = Tesis::destroy($id);
        $msj='Tesis eliminada exitosamente';

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;

        Excel::create('Tesis UNASAM', function($excel) use($buscar)  {
            $excel->sheet('BD de Tesis', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:G3');
                $sheet->cells('A3:G3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:G3', 'thin');
                $sheet->cells('A3:G3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:G4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'65',
                'C'=>'65',
                'D'=>'65',
                'E'=>'65',
                'F'=>'65',
                'G'=>'65'

                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DE TESIS - UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:G4', 'thin');
                array_push($data, array('N°','FACULTAD', 'ESCUELA PROFESIONAL','TÍTULO DEL PROYECTO','AUTOR 1','AUTOR 2','FUENTE DE FINANCIAMIENTO'));

                $cont=5;
                $cont2=5;

                $tesis = DB::table('tesis')
                ->join('escuelas', 'escuelas.id', '=', 'tesis.escuela_id')
                ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
                ->where('tesis.borrado','0')
                ->where(function($query) use ($buscar){
                   $query->where('tesis.nombreProyecto','like','%'.$buscar.'%');
                   $query->orWhere('tesis.autor','like','%'.$buscar.'%');
                   $query->orWhere('tesis.autor2','like','%'.$buscar.'%');
                   $query->orWhere('tesis.fuenteFinanciamiento','like','%'.$buscar.'%');
                   })
                ->orderBy('facultads.id')
                ->orderBy('escuelas.id')
                ->orderBy('tesis.nombreProyecto')
                ->select('tesis.id','tesis.nombreProyecto','tesis.autor','tesis.fuenteFinanciamiento','tesis.autor2','tesis.escuela_id','escuelas.nombre as escuela','facultads.nombre as facultad', 'facultads.id as facultad_id')->get();

        foreach ($tesis as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':G'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
array_push($data, array('N°','FACULTAD', 'ESCUELA PROFESIONAL','TÍTULO DEL PROYECTO','AUTORES','FUENTE DE FINANCIAMIENTO'));
*/


           array_push($data, array($key+1,
           $dato->facultad,
           $dato->escuela,
           $dato->nombreProyecto,
           $dato->autor,
           $dato->autor2,
           $dato->fuenteFinanciamiento
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }

}
