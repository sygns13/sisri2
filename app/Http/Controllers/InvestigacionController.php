<?php

namespace App\Http\Controllers;

use App\Investigacion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facultad;
use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Storage;
use stdClass;

class InvestigacionController extends Controller
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

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();



            $modulo="investigacions";
            return view('investigacions.index',compact('tipouser','modulo','escuelas'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;


     $investigacions = DB::table('investigacions')

     ->leftjoin('escuelas', 'escuelas.id', '=', 'investigacions.escuela_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
     ->where('investigacions.borrado','0')

     ->where(function($query) use ($buscar){
        $query->where('investigacions.titulo','like','%'.$buscar.'%');
        $query->orWhere('investigacions.descripcion','like','%'.$buscar.'%');
        $query->orWhere('investigacions.resolucionAprobacion','like','%'.$buscar.'%');
        $query->orWhere('investigacions.clasificacion','like','%'.$buscar.'%');
        $query->orWhere('investigacions.lineainvestigacion','like','%'.$buscar.'%');
        $query->orWhere('escuelas.nombre','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        })
     ->select('investigacions.id',
    'investigacions.titulo','investigacions.descripcion','investigacions.resolucionAprobacion','investigacions.presupuestoAsignado','investigacions.presupuestoEjecutado','investigacions.horas','investigacions.fechaInicio','investigacions.fechaTermino','investigacions.clasificacion','investigacions.rutadocumento','investigacions.estado','investigacions.avance','investigacions.descripcionAvance','investigacions.escuela_id','investigacions.lineainvestigacion','investigacions.financiamiento','investigacions.patentado',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"), 'investigacions.observaciones','investigacions.archivonombre')->paginate(50); 

/* 
    $investigacions=Investigacion::paginate(50);
 */

 $invest=$investigacions->items();

 $autores = array();
 $publicaciones = array();

 foreach ($invest as $key => $dato) {
     
    $autors=DB::table('investigadors')
    ->join('personas', 'personas.id', '=', 'investigadors.persona_id')
    ->join('detalleinvestigacions', 'investigadors.id', '=', 'detalleinvestigacions.investigador_id')
    ->join('investigacions', 'investigacions.id', '=', 'detalleinvestigacions.investigacion_id')
    ->where('investigadors.borrado','0')
    ->where('investigacions.borrado','0')
    ->where('detalleinvestigacions.borrado','0')
    ->where('investigacions.id',$dato->id)

    ->select('investigacions.id',
    'detalleinvestigacions.id','detalleinvestigacions.investigacion_id','detalleinvestigacions.cargo','detalleinvestigacions.tipoAutor','detalleinvestigacions.investigador_id','personas.nombres','personas.apellidopat','personas.apellidomat','personas.tipodoc','personas.doc')->get(); 

    $publishs = DB::table('investigacions')
     ->join('publicaciones', 'investigacions.id', '=', 'publicaciones.investigacion_id')
     ->where('publicaciones.borrado','0')
     ->where('investigacions.id',$dato->id)

     ->orderBy('publicaciones.fecha')
     ->orderBy('publicaciones.nombre')

     ->select('publicaciones.id','publicaciones.nombre','publicaciones.detalles','publicaciones.fecha','publicaciones.investigacion_id')->get();

    foreach ($autors as $key2 => $value) {
        $autores[]= $value;
    }

    foreach ($publishs as $key3 => $value3) {
        $publicaciones[]= $value3;
    }

 }

     return [
        'pagination'=>[
            'total'=> $investigacions->total(),
            'current_page'=> $investigacions->currentPage(),
            'per_page'=> $investigacions->perPage(),
            'last_page'=> $investigacions->lastPage(),
            'from'=> $investigacions->firstItem(),
            'to'=> $investigacions->lastItem(),
        ],
        'investigacions'=>$investigacions,
        'invest'=>$invest,
        'autores'=>$autores,
        'publicaciones'=>$publicaciones
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
        ini_set('memory_limit','256M');

        $result='1';
        $msj='';
        $selector='';

        $titulo=$request->titulo;
        $descripcion=$request->descripcion;
        $resolucionAprobacion=$request->resolucionAprobacion;
        $presupuestoAsignado=$request->presupuestoAsignado;
        $presupuestoEjecutado=$request->presupuestoEjecutado;
        $horas=$request->horas;
        $fechaInicio=$request->fechaInicio;
        $fechaTermino=$request->fechaTermino;
        $clasificacion=$request->clasificacion;
        $estado=$request->estado;
        $avance=$request->avance;
        $escuela_id=$request->escuela_id;
        $lineainvestigacion=$request->lineainvestigacion;
        $financiamiento=$request->financiamiento;
        $patentado=$request->patentado;
        $observaciones=$request->observaciones;

        $nombreArchivo="";
        
        $archivo="";
        $file = $request->archivo;
        $segureFile=0;


        if(intval($estado)==1)
        {
            $fechaTermino=null;
        }



        if ($request->hasFile('archivo')) { 

            $nombreArchivo=$request->nombreArchivo;

            $input  = array('archivo' => $file) ;
            $reglas = array('archivo' => 'required|mimes:.pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX');
            $validator = Validator::make($input, $reglas);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

            if (1==2)
            {

                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }   

            else
            {   
                $fecha=Date('Y-m-d');
                $hora=Date('H-i-s');

                $nombre=$file->getClientOriginalName();
                $extension=$file->getClientOriginalExtension();
                $nuevoNombre=$nombre.$fecha.$hora.".".$extension;
                $subir=Storage::disk('investigacion')->put($nuevoNombre, \File::get($file));

                if($extension=="pdf" || $extension=="doc" || $extension=="docx" || $extension=="xls" || $extension=="xlsx" || $extension=="ppt" || $extension=="pptx" || $extension=="PDF" || $extension=="DOC" || $extension=="DOCX" || $extension=="XLS" || $extension=="XLSX" || $extension=="PPT" || $extension=="PTTX")
                {


                if($subir){
                    $archivo=$nuevoNombre;
                    $nombreArchivo=$nombreArchivo;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo2';
                }
            }
            else {
                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2';
            }
            }

        }

        if($segureFile==1){ 
            Storage::disk('investigacion')->delete($archivo);
        }
        else{

            $input1  = array('titulo' => $titulo);
            $reglas1 = array('titulo' => 'required');

            $input2  = array('descripcion' => $descripcion);
            $reglas2 = array('descripcion' => 'required');

            $input3  = array('resolucionAprobacion' => $resolucionAprobacion);
            $reglas3 = array('resolucionAprobacion' => 'required');

            $input4  = array('presupuestoAsignado' => $presupuestoAsignado);
            $reglas4 = array('presupuestoAsignado' => 'required');

            $input5  = array('presupuestoEjecutado' => $presupuestoEjecutado);
            $reglas5 = array('presupuestoEjecutado' => 'required');

            $input6  = array('horas' => $horas);
            $reglas6 = array('horas' => 'required');

            $input7  = array('fechaInicio' => $fechaInicio);
            $reglas7 = array('fechaInicio' => 'required');

            $input8  = array('clasificacion' => $clasificacion);
            $reglas8 = array('clasificacion' => 'required');

            $input9  = array('avance' => $avance);
            $reglas9 = array('avance' => 'required');


            $input11  = array('escuela_id' => $escuela_id);
            $reglas11 = array('escuela_id' => 'required');

            $input12  = array('lineainvestigacion' => $lineainvestigacion);
            $reglas12 = array('lineainvestigacion' => 'required');
            
            $input13  = array('financiamiento' => $financiamiento);
            $reglas13 = array('financiamiento' => 'required');

            $input14  = array('patentado' => $patentado);
            $reglas14 = array('patentado' => 'required');

            $input15  = array('fechaTermino' => $fechaTermino);
            $reglas15 = array('fechaTermino' => 'required');





               
            $validator1 = Validator::make($input1, $reglas1);
            $validator2 = Validator::make($input2, $reglas2);
            $validator3 = Validator::make($input3, $reglas3);
            $validator4 = Validator::make($input4, $reglas4);
            $validator5 = Validator::make($input5, $reglas5);
            $validator6 = Validator::make($input6, $reglas6);
            $validator7 = Validator::make($input7, $reglas7);
            $validator8 = Validator::make($input8, $reglas8);
            $validator9 = Validator::make($input9, $reglas9);

            $validator11 = Validator::make($input11, $reglas11);
            $validator12 = Validator::make($input12, $reglas12);
            $validator13 = Validator::make($input13, $reglas13);
            $validator14 = Validator::make($input14, $reglas14);
            $validator15 = Validator::make($input15, $reglas15);


         //$validator6 = Validator::make($input6, $reglas6);

            if ($validator1->fails())
            {
                $result='0';
                $msj='Ingrese el título de la investigación';
                $selector='txttitulo';
            }elseif ($validator2->fails()) {
                $result='0';
                $msj='Ingrese la descripción de la investigación';
                $selector='txtdescripcion';
            }elseif ($validator3->fails()) {
                $result='0';
                $msj='Ingrese la resolución de aprobación de la investigación';
                $selector='txtresolucionAprobacion';
            }
            elseif ($validator4->fails()) {
                $result='0';
                $msj='Ingrese el presupuesto asignado de la investigación';
                $selector='txtpresupuestoAsignado';
            }
            elseif ($validator5->fails()) {
                $result='0';
                $msj='Ingrese el presupuesto ejecutado de la investigación';
                $selector='txtpresupuestoEjecutado';
            }
            elseif ($validator6->fails()) {
                $result='0';
                $msj='Ingrese la cantidad de horas de la investigación';
                $selector='txthoras';
            }
            elseif ($validator7->fails()) {
                $result='0';
                $msj='Ingrese la fecha de inicio de la investigación';
                $selector='txtfechaInicio';
            }
            elseif ($validator8->fails()) {
                $result='0';
                $msj='Ingrese la clasificación de la investigación';
                $selector='txtclasificacion';
            }
            elseif ($validator9->fails()) {
                $result='0';
                $msj='Ingrese el avance de la investigación';
                $selector='txtavance';
            }


            elseif ($validator11->fails()) {
                $result='0';
                $msj='Ingrese la escuela profesional donde se desarrolla de la investigación';
                $selector='cbuescuela_id';
            }
            elseif ($validator12->fails()) {
                $result='0';
                $msj='Ingrese la línea de investigación de la investigación';
                $selector='txtlineainvestigacion';
            }
            elseif ($validator13->fails()) {
                $result='0';
                $msj='Ingrese el financiamiento de la investigación';
                $selector='txtfinanciamiento';
            }
            elseif ($validator14->fails()) {
                $result='0';
                $msj='Ingrese si la investigación ha sido patentada';
                $selector='txtpatentado';
            }
            elseif ($validator15->fails() && intval($estado)>3) {
                $result='0';
                $msj='Ingrese la fecha de término de la investigación';
                $selector='txtfechaTermino';
            }
            else{

    
                    $newInvestigacion = new Investigacion();

                    $newInvestigacion->titulo=$titulo;
                    $newInvestigacion->descripcion=$descripcion;
                    $newInvestigacion->resolucionAprobacion=$resolucionAprobacion;
                    $newInvestigacion->presupuestoAsignado=$presupuestoAsignado;
                    $newInvestigacion->presupuestoEjecutado=$presupuestoEjecutado;
                    $newInvestigacion->horas=$horas;
                    $newInvestigacion->fechaInicio=$fechaInicio;
                    $newInvestigacion->fechaTermino=$fechaTermino;
                    $newInvestigacion->clasificacion=$clasificacion;
                    $newInvestigacion->rutadocumento=$archivo;
                    $newInvestigacion->estado=$estado;
                    $newInvestigacion->avance=$avance;
                    $newInvestigacion->escuela_id=$escuela_id;
                    $newInvestigacion->lineainvestigacion=$lineainvestigacion;
                    $newInvestigacion->financiamiento=$financiamiento;
                    $newInvestigacion->patentado=$patentado;
                    $newInvestigacion->observaciones=$observaciones;
                    $newInvestigacion->archivonombre=$nombreArchivo;
      
                    $newInvestigacion->activo='1';
                    $newInvestigacion->borrado='0';                   

                    $newInvestigacion->save();

                    $msj='Nuevo Registro de Investigación registrado con éxito';
                }
            }


    return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Investigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function show(Investigacion $investigacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Investigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Investigacion $investigacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Investigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $result='1';
       $msj='';
       $selector='';

       $titulo=$request->titulo;
        $descripcion=$request->descripcion;
        $resolucionAprobacion=$request->resolucionAprobacion;
        $presupuestoAsignado=$request->presupuestoAsignado;
        $presupuestoEjecutado=$request->presupuestoEjecutado;
        $horas=$request->horas;
        $fechaInicio=$request->fechaInicio;
        $fechaTermino=$request->fechaTermino;
        $clasificacion=$request->clasificacion;
        $estado=$request->estado;
        $avance=$request->avance;
        $escuela_id=$request->escuela_id;
        $lineainvestigacion=$request->lineainvestigacion;
        $financiamiento=$request->financiamiento;
        $patentado=$request->patentado;
        $observaciones=$request->observaciones;

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo="";

        $oldFile=$request->oldfile;

       if(intval($estado)==1)
        {
            $fechaTermino=null;
        }

       if ($request->hasFile('archivo')) { 

        $nombreArchivo=$request->nombreArchivo;

        $input  = array('file' => $file) ;
        $reglas = array('file' => 'required|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE,doc,xls,ppt,pptx,pdf,txt,DOC,XLS,PPT,PPTX,PDF,TXT');
        $validator = Validator::make($input, $reglas);

        $inputNA  = array('archivonombre' => $nombreArchivo);
        $reglasNA = array('archivonombre' => 'required');
        $validatorNA = Validator::make($inputNA, $reglasNA);

        if (1==2)
        {

            $segureFile=1;
            $msj="El archivo ingresado no es válido, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2E';
        }

        elseif($validatorNA->fails()){
            $segureFile=1;
            $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
            $result='0';
            $selector='txtArchivoAdjuntoE';
        }

        else
        {   
                $fecha=Date('Y-m-d');
                $hora=Date('H-i-s');

            $nombre=$file->getClientOriginalName();
            $extension=$file->getClientOriginalExtension();
            $nuevoNombre=$nombre.$fecha.$hora.".".$extension;
            $subir=Storage::disk('investigacion')->put($nuevoNombre, \File::get($file));

            if($extension=="pdf" || $extension=="doc" || $extension=="docx" || $extension=="xls" || $extension=="xlsx" || $extension=="ppt" || $extension=="pptx" || $extension=="PDF" || $extension=="DOC" || $extension=="DOCX" || $extension=="XLS" || $extension=="XLSX" || $extension=="PPT" || $extension=="PTTX")
            {

            if($subir){
                $archivo=$nuevoNombre;

                if(strlen($oldFile)>0){
                    Storage::disk('investigacion')->delete($oldFile);
                }
            }
            else{
                $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo2E';
            }
        }
            else {
                $segureFile=1;
                $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                $result='0';
                $selector='archivo2E';
            }
        

        }
    }

    if($segureFile==1){ 
        Storage::disk('investigacion')->delete($archivo);
    }
    else
    {

        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $input3  = array('resolucionAprobacion' => $resolucionAprobacion);
        $reglas3 = array('resolucionAprobacion' => 'required');

        $input4  = array('presupuestoAsignado' => $presupuestoAsignado);
        $reglas4 = array('presupuestoAsignado' => 'required');

        $input5  = array('presupuestoEjecutado' => $presupuestoEjecutado);
        $reglas5 = array('presupuestoEjecutado' => 'required');

        $input6  = array('horas' => $horas);
        $reglas6 = array('horas' => 'required');

        $input7  = array('fechaInicio' => $fechaInicio);
        $reglas7 = array('fechaInicio' => 'required');

        $input8  = array('clasificacion' => $clasificacion);
        $reglas8 = array('clasificacion' => 'required');

        $input9  = array('avance' => $avance);
        $reglas9 = array('avance' => 'required');


        $input11  = array('escuela_id' => $escuela_id);
        $reglas11 = array('escuela_id' => 'required');

        $input12  = array('lineainvestigacion' => $lineainvestigacion);
        $reglas12 = array('lineainvestigacion' => 'required');
        
        $input13  = array('financiamiento' => $financiamiento);
        $reglas13 = array('financiamiento' => 'required');

        $input14  = array('patentado' => $patentado);
        $reglas14 = array('patentado' => 'required');

        $input15  = array('fechaTermino' => $fechaTermino);
        $reglas15 = array('fechaTermino' => 'required');


        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);

        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);


     //$validator6 = Validator::make($input6, $reglas6);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Ingrese el título de la investigación';
            $selector='txttituloE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese la descripción de la investigación';
            $selector='txtdescripcionE';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese la resolución de aprobación de la investigación';
            $selector='txtresolucionAprobacionE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el presupuesto asignado de la investigación';
            $selector='txtpresupuestoAsignadoE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el presupuesto ejecutado de la investigación';
            $selector='txtpresupuestoEjecutadoE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Ingrese la cantidad de horas de la investigación';
            $selector='txthorasE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio de la investigación';
            $selector='txtfechaInicioE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la clasificación de la investigación';
            $selector='txtclasificacionE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Ingrese el avance de la investigación';
            $selector='txtavanceE';
        }


        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese la escuela profesional donde se desarrolla de la investigación';
            $selector='cbuescuela_idE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la línea de investigación de la investigación';
            $selector='txtlineainvestigacionE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el financiamiento de la investigación';
            $selector='txtfinanciamientoE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese si la investigación ha sido patentada';
            $selector='txtpatentadoE';
        }
        elseif ($validator15->fails() && intval($estado)>3) {
            $result='0';
            $msj='Ingrese la fecha de término de la investigación';
            $selector='txtfechaTerminoE';
        }
            else
            {

                $newInvestigacion =Investigacion::find($id);

                $newInvestigacion->titulo=$titulo;
                $newInvestigacion->descripcion=$descripcion;
                $newInvestigacion->resolucionAprobacion=$resolucionAprobacion;
                $newInvestigacion->presupuestoAsignado=$presupuestoAsignado;
                $newInvestigacion->presupuestoEjecutado=$presupuestoEjecutado;
                $newInvestigacion->horas=$horas;
                $newInvestigacion->fechaInicio=$fechaInicio;
                $newInvestigacion->fechaTermino=$fechaTermino;
                $newInvestigacion->clasificacion=$clasificacion;
                $newInvestigacion->rutadocumento=$archivo;
                $newInvestigacion->estado=$estado;
                $newInvestigacion->avance=$avance;
                $newInvestigacion->escuela_id=$escuela_id;
                $newInvestigacion->lineainvestigacion=$lineainvestigacion;
                $newInvestigacion->financiamiento=$financiamiento;
                $newInvestigacion->patentado=$patentado;
                $newInvestigacion->observaciones=$observaciones;
                $newInvestigacion->archivonombre=$nombreArchivo;
                 

                $newInvestigacion->save();

          $msj='Registro de Investigación modificado con éxito';

      }

  }


return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Investigacion  $investigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta1=DB::table('detalleinvestigacions')
                    ->join('investigacions', 'detalleinvestigacions.investigacion_id', '=', 'investigacions.id')
                    ->where('investigacions.id',$id)->count();

        $consulta2=DB::table('publicaciones')
        ->join('investigacions', 'publicaciones.investigacion_id', '=', 'investigacions.id')
        ->where('investigacions.id',$id)->count();



        if($consulta1>0) {
            $result='0';
            $msj='La Investigación no se puede eliminar debido a que cuenta con registros de investigadores asociadas a ella, primero elimine el registro de investigadores de la investigación, para poder eliminarla';
        }
        elseif($consulta2>0) {
            $result='0';
            $msj='La Investigación no se puede eliminar debido a que cuenta con registros de publicaciones, primero elimine el registro de publicaciones de la investigación, para poder eliminarla';
        }
        else{
        
        $borrar = Investigacion::findOrFail($id);
        //$task->delete();

        $borrar->borrado='1';

        $borrar->save();

        $msj='Registro de Investigación eliminado exitosamente';
     }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function obtenerAutors($id)
    {   


     $investigadorsRegis = DB::table('investigadors')
     ->join('personas', 'personas.id', '=', 'investigadors.persona_id')
     ->join('detalleinvestigacions', 'investigadors.id', '=', 'detalleinvestigacions.investigador_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'investigadors.facultad_id')
     ->leftjoin('escuelas', 'escuelas.id', '=', 'investigadors.escuela_id')
     ->where('investigadors.borrado','0')
     ->where('detalleinvestigacions.investigacion_id',$id)

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','investigadors.id',
    'investigadors.persona_id','investigadors.escuela_id','investigadors.facultad_id','investigadors.observaciones','investigadors.clasificacion',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `escuelas`.`nombre` , '' ) as escuela"),'detalleinvestigacions.cargo','detalleinvestigacions.tipoAutor','detalleinvestigacions.id as idDetalle')->get();


     return [
        'investigadorsRegis'=>$investigadorsRegis
    ];
    }

    public function obtenerPublicacion($id)
    {   


     $publicacionRegis = DB::table('investigacions')
     ->join('publicaciones', 'investigacions.id', '=', 'publicaciones.investigacion_id')
     ->where('publicaciones.borrado','0')
     ->where('investigacions.id',$id)

     ->orderBy('publicaciones.fecha')
     ->orderBy('publicaciones.nombre')

     ->select('publicaciones.id','publicaciones.nombre','publicaciones.detalles','publicaciones.fecha','publicaciones.investigacion_id')->get();


     return [
        'publicacionRegis'=>$publicacionRegis
    ];
    }
}
