<?php

namespace App\Http\Controllers;

use App\Pasantia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facultad;
use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Alumno;
use App\Persona;
use App\Tipouser;
use App\User;

use App\Exports\PlantillaPostulanteExport;
use Maatwebsite\Excel\Facades\Excel;

class PasantiaController extends Controller
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

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="pasantiaalumnos";
            return view('pasantiaalumnos.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre'));
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

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $facultads=Facultad::where('activo','1')->where('borrado','0')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="pasantiadocentes";
            return view('pasantiadocentes.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre','facultads'));
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

            $escuelas = DB::table('escuelas')
            ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')
            ->where('escuelas.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('escuelas.nombre')
            ->select('escuelas.id','escuelas.nombre','escuelas.activo','escuelas.borrado','escuelas.facultad_id','facultads.nombre as facultad')
            ->get();

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $facultads=Facultad::where('activo','1')->where('borrado','0')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="pasantiaadministrativos";
            return view('pasantiaadministrativos.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre','facultads'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index4()
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

            $semestres=Semestre::where('activo','1')->where('borrado','0')->orderBy('fechafin','desc')->get();

            $facultads=Facultad::where('activo','1')->where('borrado','0')->get();

            $semestresel="0";
            $contse=0;
            $semestreNombre="";
            foreach ($semestres as $key => $dato) {
                $contse++;
                if($dato->estado="1"){
                    $semestresel=$dato->id;
                    $semestreNombre=$dato->nombre;
                    break;
                }
            }


            $modulo="pasantiallegaron";
            return view('pasantiallegaron.index',compact('tipouser','modulo','escuelas','semestres','semestresel','contse','semestreNombre','facultads'));
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

     $alumnos="";


    if(intval($tipo)==1){

    
     $alumnos = DB::table('pasantias')
     ->join('personas', 'personas.id', '=', 'pasantias.persona_id')
     ->join('escuelas', 'escuelas.id', '=', 'pasantias.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')

     ->where('pasantias.borrado','0')
     ->where('pasantias.tipo',$tipo)

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','pasantias.id',
     
     'pasantias.persona_id','pasantias.escuela_id','pasantias.modalidads','pasantias.concepto','pasantias.paispasantia','pasantias.institucionpasantia','pasantias.fechainicio','pasantias.fechafinal','pasantias.monto','pasantias.resolucions','pasantias.activo','pasantias.tipo','pasantias.dependencia','pasantias.observaciones','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','pasantias.facultad_id')
     ->paginate(50);
    }


    elseif(intval($tipo)==2){

    
        $alumnos = DB::table('pasantias')
        ->join('personas', 'personas.id', '=', 'pasantias.persona_id')
        ->join('facultads', 'facultads.id', '=', 'pasantias.facultad_id')
        ->leftjoin('escuelas', 'escuelas.id', '=', 'pasantias.escuela_id')
   
        ->where('pasantias.borrado','0')
        ->where('pasantias.tipo',$tipo)
   
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
   
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','pasantias.id',
        
        'pasantias.persona_id','pasantias.escuela_id','pasantias.modalidads','pasantias.concepto','pasantias.paispasantia','pasantias.institucionpasantia','pasantias.fechainicio','pasantias.fechafinal','pasantias.monto','pasantias.resolucions','pasantias.activo','pasantias.tipo','pasantias.dependencia','pasantias.observaciones','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','pasantias.facultad_id')
        ->paginate(50);
       }

       elseif(intval($tipo)==3){

    
        $alumnos = DB::table('pasantias')
        ->join('personas', 'personas.id', '=', 'pasantias.persona_id')

   
        ->where('pasantias.borrado','0')
        ->where('pasantias.tipo',$tipo)
   
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
   
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','pasantias.id',
        
        'pasantias.persona_id','pasantias.escuela_id','pasantias.modalidads','pasantias.concepto','pasantias.paispasantia','pasantias.institucionpasantia','pasantias.fechainicio','pasantias.fechafinal','pasantias.monto','pasantias.resolucions','pasantias.activo','pasantias.tipo','pasantias.dependencia','pasantias.observaciones')
        ->paginate(50);
       }


       elseif(intval($tipo)>3){

    
        $alumnos = DB::table('pasantias')
        ->join('personas', 'personas.id', '=', 'pasantias.persona_id')
        ->join('facultads', 'facultads.id', '=', 'pasantias.facultad_id')
        ->leftjoin('escuelas', 'escuelas.id', '=', 'pasantias.escuela_id')
   
        ->where('pasantias.borrado','0')
        ->where('pasantias.tipo','>','3')
   
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
   
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','pasantias.id',
        
        'pasantias.persona_id','pasantias.escuela_id','pasantias.modalidads','pasantias.concepto','pasantias.paispasantia','pasantias.institucionpasantia','pasantias.fechainicio','pasantias.fechafinal','pasantias.monto','pasantias.resolucions','pasantias.activo','pasantias.tipo','pasantias.dependencia','pasantias.observaciones','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','pasantias.facultad_id')
        ->paginate(50);
       }


   
  

     return [
        'pagination'=>[
            'total'=> $alumnos->total(),
            'current_page'=> $alumnos->currentPage(),
            'per_page'=> $alumnos->perPage(),
            'last_page'=> $alumnos->lastPage(),
            'from'=> $alumnos->firstItem(),
            'to'=> $alumnos->lastItem(),
        ],
        'alumnos'=>$alumnos
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

        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
        $genero=$request->genero;
        $estadocivil=$request->estadocivil;
        $fechanac=$request->fechanac;
        $esdiscapacitado=$request->esdiscapacitado;
        $discapacidad=$request->discapacidad;
        $pais=$request->pais;
        $departamento=$request->departamento;
        $provincia=$request->provincia;
        $distrito=$request->distrito;
        $direccion=$request->direccion;
        $email=$request->email;
        $telefono=$request->telefono;

        $persona_id=$request->persona_id;
        $facultad_id=$request->facultad_id;
        $escuela_id=$request->escuela_id;
        $modalidads=$request->modalidads;
        $concepto=$request->concepto;
        $paispasantia=$request->paispasantia;
        $institucionpasantia=$request->institucionpasantia;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $monto=$request->monto;
        $resolucions=$request->resolucions;
        $tipo=$request->tipo;
        $dependencia=$request->dependencia;
        $observaciones=$request->observaciones;
       


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }




        $result='1';
        $msj='';
        $selector='';


        $input1  = array('tipodoc' => $tipodoc);
        $reglas1 = array('tipodoc' => 'required');

        $input2  = array('doc' => $doc);
        $reglas2 = array('doc' => 'required');

        $input3  = array('nombres' => $nombres);
        $reglas3 = array('nombres' => 'required');

        $input4  = array('apellidopat' => $apellidopat);
        $reglas4 = array('apellidopat' => 'required');

        $input5  = array('apellidomat' => $apellidomat);
        $reglas5 = array('apellidomat' => 'required');

        $input6  = array('genero' => $genero);
        $reglas6 = array('genero' => 'required');

        $input7  = array('estadocivil' => $estadocivil);
        $reglas7 = array('estadocivil' => 'required');

        $input8  = array('fechanac' => $fechanac);
        $reglas8 = array('fechanac' => 'required');

        $input9  = array('esdiscapacitado' => $esdiscapacitado);
        $reglas9 = array('esdiscapacitado' => 'required');

        $input10  = array('pais' => $pais);
        $reglas10 = array('pais' => 'required');

        $input11  = array('departamento' => $departamento);
        $reglas11 = array('departamento' => 'required');

        $input12  = array('provincia' => $provincia);
        $reglas12 = array('provincia' => 'required');

        $input13  = array('distrito' => $distrito);
        $reglas13 = array('distrito' => 'required');

        $input14  = array('direccion' => $direccion);
        $reglas14 = array('direccion' => 'required');

        $input15  = array('modalidads' => $modalidads);
        $reglas15 = array('modalidads' => 'required');

        $input16  = array('concepto' => $concepto);
        $reglas16 = array('concepto' => 'required');

        $input17  = array('paispasantia' => $paispasantia);
        $reglas17 = array('paispasantia' => 'required');

        $input18  = array('institucionpasantia' => $institucionpasantia);
        $reglas18 = array('institucionpasantia' => 'required');

        $input19  = array('fechainicio' => $fechainicio);
        $reglas19 = array('fechainicio' => 'required');

        $input20  = array('fechafinal' => $fechafinal);
        $reglas20 = array('fechafinal' => 'required');

        $input21  = array('monto' => $monto);
        $reglas21 = array('monto' => 'required');

        $input22  = array('resolucions' => $resolucions);
        $reglas22 = array('resolucions' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);


 
        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad';
            $selector='txtDNI';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido';
            $selector='txtDNI';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el alumno es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el alumno es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección';
            $selector='txtDir';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese la modalidad de la pasantía';
            $selector='txtmodalidad';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el concepto de la pasantía';
            $selector='txtconcepto';
        }
        elseif ($validator17->fails() && intval($tipo)!=4) {
            $result='0';
            $msj='Ingrese el País de destino de la pasantía ';
            $selector='txtpaisdestino';
        }
        elseif ($validator17->fails() && intval($tipo)>3) {
            $result='0';
            $msj='Ingrese el País del que Proviene el Alumno que llega a la UNASAM por Pasantía';
            $selector='txtpaisdestino';
        }
        elseif ($validator18->fails() && intval($tipo)!=4) {
            $result='0';
            $msj='Ingrese la Institución de destino de la pasantía';
            $selector='txtinstitucion';
        }
        elseif ($validator18->fails() && intval($tipo)>3) {
            $result='0';
            $msj='Ingrese la Institución  del que Proviene el Alumno que llega a la UNASAM por Pasantía';
            $selector='txtinstitucion';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio de la pasantía';
            $selector='txtfechainicio';
        }

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fecha de finalización de la pasantía';
            $selector='txtfechafinal';
        }



        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese el monto asignado para la pasantía';
            $selector='txtmonto';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la resolución de la pasantía';
            $selector='txtresolucion';
        }
        elseif (intval($facultad_id)==0 && (intval($tipo)==2)) {
            $result='0';
            $msj='Seleccione una Facultad Adscrita al Docente';
            $selector='cbufacultad';
        }
        elseif (intval($escuela_id)==0 && (intval($tipo)==1)) {
            $result='0';
            $msj='Seleccione la Escuela Profesional del alumno';
            $selector='cbuescuela';
        }
        elseif (strlen($dependencia)==0 && (intval($tipo)==3)) {
            $result='0';
            $msj='Ingrese la dependencia donde labora el personal administrativo';
            $selector='txtdependencia';
        }

    
      
        else{



        if(intval($persona_id)!=0)
        {
            $editPersona =Persona::find($persona_id);
            $editPersona->tipodoc=$tipodoc;
            $editPersona->doc=$doc;
            $editPersona->nombres=$nombres;
            $editPersona->apellidopat=$apellidopat;
            $editPersona->apellidomat=$apellidomat;
            $editPersona->genero=$genero;
            $editPersona->estadocivil=$estadocivil;
            $editPersona->fechanac=$fechanac;
            $editPersona->esdiscapacitado=$esdiscapacitado;
            $editPersona->discapacidad=$discapacidad;
            $editPersona->pais=$pais;
            $editPersona->departamento=$departamento;
            $editPersona->provincia=$provincia;
            $editPersona->distrito=$distrito;
            $editPersona->direccion=$direccion;
            $editPersona->email=$email;
            $editPersona->telefono=$telefono;

            $editPersona->save();
        }
        else{
            $newPersona = new Persona();
            $newPersona->tipodoc=$tipodoc;
            $newPersona->doc=$doc;
            $newPersona->nombres=$nombres;
            $newPersona->apellidopat=$apellidopat;
            $newPersona->apellidomat=$apellidomat;
            $newPersona->genero=$genero;
            $newPersona->estadocivil=$estadocivil;
            $newPersona->fechanac=$fechanac;
            $newPersona->esdiscapacitado=$esdiscapacitado;
            $newPersona->discapacidad=$discapacidad;
            $newPersona->pais=$pais;
            $newPersona->departamento=$departamento;
            $newPersona->provincia=$provincia;
            $newPersona->distrito=$distrito;
            $newPersona->direccion=$direccion;
            $newPersona->email=$email;
            $newPersona->telefono=$telefono;
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }

        if(intval($tipo)<4)
        {
        $newPasantia = new Pasantia();
        $newPasantia->persona_id=$persona_id;
        $newPasantia->facultad_id=$facultad_id;
        $newPasantia->escuela_id=$escuela_id;
        $newPasantia->modalidads=$modalidads;
        $newPasantia->concepto=$concepto;
        $newPasantia->paispasantia=$paispasantia;
        $newPasantia->institucionpasantia=$institucionpasantia;
        $newPasantia->fechainicio=$fechainicio;
        $newPasantia->fechafinal=$fechafinal;
        $newPasantia->monto=$monto;
        $newPasantia->resolucions=$resolucions;
        $newPasantia->tipo=$tipo;
        $newPasantia->dependencia=$dependencia;
        $newPasantia->observaciones=$observaciones;

        $newPasantia->activo='1';
        $newPasantia->borrado='0';

        $newPasantia->save();

        }

        elseif(intval($tipo)>=4)
        {
            $newPasantia = new Pasantia();
            $newPasantia->persona_id=$persona_id;
            $newPasantia->facultad_id=$facultad_id;
            $newPasantia->escuela_id=$escuela_id;
            $newPasantia->modalidads=$modalidads;
            $newPasantia->concepto=$concepto;
            $newPasantia->paispasantia=$paispasantia;
            $newPasantia->institucionpasantia=$institucionpasantia;
            $newPasantia->fechainicio=$fechainicio;
            $newPasantia->fechafinal=$fechafinal;
            $newPasantia->monto=$monto;
            $newPasantia->resolucions=$resolucions;
            $newPasantia->tipo=$tipo;
            $newPasantia->dependencia=$dependencia;
            $newPasantia->observaciones=$observaciones;
    
            $newPasantia->activo='1';
            $newPasantia->borrado='0';
    
            $newPasantia->save();

        }
        

           

            $msj='Nuevo Registro de Pasantía e Intercambio registrado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pasantia  $pasantia
     * @return \Illuminate\Http\Response
     */
    public function show(Pasantia $pasantia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pasantia  $pasantia
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasantia $pasantia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pasantia  $pasantia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipodoc=$request->tipodoc;
        $doc=$request->doc;
        $nombres=$request->nombres;
        $apellidopat=$request->apellidopat;
        $apellidomat=$request->apellidomat;
        $genero=$request->genero;
        $estadocivil=$request->estadocivil;
        $fechanac=$request->fechanac;
        $esdiscapacitado=$request->esdiscapacitado;
        $discapacidad=$request->discapacidad;
        $pais=$request->pais;
        $departamento=$request->departamento;
        $provincia=$request->provincia;
        $distrito=$request->distrito;
        $direccion=$request->direccion;
        $email=$request->email;
        $telefono=$request->telefono;

        $persona_id=$request->persona_id;
        $facultad_id=$request->facultad_id;
        $escuela_id=$request->escuela_id;
        $modalidads=$request->modalidads;
        $concepto=$request->concepto;
        $paispasantia=$request->paispasantia;
        $institucionpasantia=$request->institucionpasantia;
        $fechainicio=$request->fechainicio;
        $fechafinal=$request->fechafinal;
        $monto=$request->monto;
        $resolucions=$request->resolucions;
        $tipo=$request->tipo;
        $dependencia=$request->dependencia;
        $observaciones=$request->observaciones;
       


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }




        $result='1';
        $msj='';
        $selector='';


        $input1  = array('tipodoc' => $tipodoc);
        $reglas1 = array('tipodoc' => 'required');

        $input2  = array('doc' => $doc);
        $reglas2 = array('doc' => 'required');

        $input3  = array('nombres' => $nombres);
        $reglas3 = array('nombres' => 'required');

        $input4  = array('apellidopat' => $apellidopat);
        $reglas4 = array('apellidopat' => 'required');

        $input5  = array('apellidomat' => $apellidomat);
        $reglas5 = array('apellidomat' => 'required');

        $input6  = array('genero' => $genero);
        $reglas6 = array('genero' => 'required');

        $input7  = array('estadocivil' => $estadocivil);
        $reglas7 = array('estadocivil' => 'required');

        $input8  = array('fechanac' => $fechanac);
        $reglas8 = array('fechanac' => 'required');

        $input9  = array('esdiscapacitado' => $esdiscapacitado);
        $reglas9 = array('esdiscapacitado' => 'required');

        $input10  = array('pais' => $pais);
        $reglas10 = array('pais' => 'required');

        $input11  = array('departamento' => $departamento);
        $reglas11 = array('departamento' => 'required');

        $input12  = array('provincia' => $provincia);
        $reglas12 = array('provincia' => 'required');

        $input13  = array('distrito' => $distrito);
        $reglas13 = array('distrito' => 'required');

        $input14  = array('direccion' => $direccion);
        $reglas14 = array('direccion' => 'required');

        $input15  = array('modalidads' => $modalidads);
        $reglas15 = array('modalidads' => 'required');

        $input16  = array('concepto' => $concepto);
        $reglas16 = array('concepto' => 'required');

        $input17  = array('paispasantia' => $paispasantia);
        $reglas17 = array('paispasantia' => 'required');

        $input18  = array('institucionpasantia' => $institucionpasantia);
        $reglas18 = array('institucionpasantia' => 'required');

        $input19  = array('fechainicio' => $fechainicio);
        $reglas19 = array('fechainicio' => 'required');

        $input20  = array('fechafinal' => $fechafinal);
        $reglas20 = array('fechafinal' => 'required');

        $input21  = array('monto' => $monto);
        $reglas21 = array('monto' => 'required');

        $input22  = array('resolucions' => $resolucions);
        $reglas22 = array('resolucions' => 'required');



        $validator1 = Validator::make($input1, $reglas1);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);
        $validator4 = Validator::make($input4, $reglas4);
        $validator5 = Validator::make($input5, $reglas5);
        $validator6 = Validator::make($input6, $reglas6);
        $validator7 = Validator::make($input7, $reglas7);
        $validator8 = Validator::make($input8, $reglas8);
        $validator9 = Validator::make($input9, $reglas9);
        $validator10 = Validator::make($input10, $reglas10);
        $validator11 = Validator::make($input11, $reglas11);
        $validator12 = Validator::make($input12, $reglas12);
        $validator13 = Validator::make($input13, $reglas13);
        $validator14 = Validator::make($input14, $reglas14);
        $validator15 = Validator::make($input15, $reglas15);
        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);


 
        if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad';
            $selector='txtDNIE';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido';
            $selector='txtDNIE';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el alumno es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el alumno es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección';
            $selector='txtDirE';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese la modalidad de la pasantía';
            $selector='txtmodalidadE';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el concepto de la pasantía';
            $selector='txtconceptoE';
        }
        elseif ($validator17->fails() && intval($tipo)!=4) {
            $result='0';
            $msj='Ingrese el País de destino de la pasantía ';
            $selector='txtpaisdestinoE';
        }
        elseif ($validator17->fails() && intval($tipo)>3) {
            $result='0';
            $msj='Ingrese el País del que Proviene el Alumno que llega a la UNASAM por Pasantía';
            $selector='txtpaisdestinoE';
        }
        elseif ($validator18->fails() && intval($tipo)!=4) {
            $result='0';
            $msj='Ingrese la Institución de destino de la pasantía';
            $selector='txtinstitucionE';
        }
        elseif ($validator18->fails() && intval($tipo)>3) {
            $result='0';
            $msj='Ingrese la Institución  del que Proviene el Alumno que llega a la UNASAM por Pasantía';
            $selector='txtinstitucionE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha de inicio de la pasantía';
            $selector='txtfechainicioE';
        }

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fecha de finalización de la pasantía';
            $selector='txtfechafinalE';
        }



        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese el monto asignado para la pasantía';
            $selector='txtmontoE';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la resolución de la pasantía';
            $selector='txtresolucionE';
        }

        elseif (intval($facultad_id)==0 && (intval($tipo)==2)) {
            $result='0';
            $msj='Seleccione una Facultad Adscrita al Docente';
            $selector='cbufacultadE';
        }
        elseif (intval($escuela_id)==0 && (intval($tipo)==1)) {
            $result='0';
            $msj='Seleccione la Escuela Profesional del alumno';
            $selector='cbuescuelaE';
        }

        elseif (strlen($dependencia)==0 && (intval($tipo)==3)) {
            $result='0';
            $msj='Ingrese la dependencia donde labora el personal administrativo';
            $selector='txtdependenciaE';
        }

    
      
        else{



            $editPersona =Persona::find($persona_id);
            $editPersona->tipodoc=$tipodoc;
            $editPersona->doc=$doc;
            $editPersona->nombres=$nombres;
            $editPersona->apellidopat=$apellidopat;
            $editPersona->apellidomat=$apellidomat;
            $editPersona->genero=$genero;
            $editPersona->estadocivil=$estadocivil;
            $editPersona->fechanac=$fechanac;
            $editPersona->esdiscapacitado=$esdiscapacitado;
            $editPersona->discapacidad=$discapacidad;
            $editPersona->pais=$pais;
            $editPersona->departamento=$departamento;
            $editPersona->provincia=$provincia;
            $editPersona->distrito=$distrito;
            $editPersona->direccion=$direccion;
            $editPersona->email=$email;
            $editPersona->telefono=$telefono;

            $editPersona->save();
       

        if(intval($tipo)<4)
        {
        $newPasantia =Pasantia::find($id);

        $newPasantia->facultad_id=$facultad_id;
        $newPasantia->escuela_id=$escuela_id;
        $newPasantia->modalidads=$modalidads;
        $newPasantia->concepto=$concepto;
        $newPasantia->paispasantia=$paispasantia;
        $newPasantia->institucionpasantia=$institucionpasantia;
        $newPasantia->fechainicio=$fechainicio;
        $newPasantia->fechafinal=$fechafinal;
        $newPasantia->monto=$monto;
        $newPasantia->resolucions=$resolucions;

        $newPasantia->dependencia=$dependencia;
        $newPasantia->observaciones=$observaciones;


        $newPasantia->save();

        }

        elseif(intval($tipo)>=4)
        {
            $newPasantia =Pasantia::find($id);
            $newPasantia->persona_id=$persona_id;
            $newPasantia->facultad_id=$facultad_id;
            $newPasantia->escuela_id=$escuela_id;
            $newPasantia->modalidads=$modalidads;
            $newPasantia->concepto=$concepto;
            $newPasantia->paispasantia=$paispasantia;
            $newPasantia->institucionpasantia=$institucionpasantia;
            $newPasantia->fechainicio=$fechainicio;
            $newPasantia->fechafinal=$fechafinal;
            $newPasantia->monto=$monto;
            $newPasantia->resolucions=$resolucions;
            $newPasantia->tipo=$tipo;
            $newPasantia->dependencia=$dependencia;
            $newPasantia->observaciones=$observaciones;
    
            $newPasantia->save();

        }
        

           

            $msj='Registro de Pasantía e Intercambio modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pasantia  $pasantia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Pasantia::destroy($id);
        //$task->delete();


        $msj='Registro de Pasantía Seleccionada eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
