<?php

namespace App\Http\Controllers;

use App\Docente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Facultad;
use App\Escuela;
use App\Departamentoacademico;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;


use Excel;
set_time_limit(600);

use Storage;
use DateTime;

use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;

class DocenteController extends Controller
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

            $departamentoacademicos = DB::table('departamentoacademicos')
            ->join('facultads', 'facultads.id', '=', 'departamentoacademicos.facultad_id')
            ->where('departamentoacademicos.borrado','0')
  
            ->orderBy('facultads.nombre')
            ->orderBy('departamentoacademicos.nombre')
            ->select('departamentoacademicos.id','departamentoacademicos.nombre','departamentoacademicos.activo','departamentoacademicos.borrado','departamentoacademicos.facultad_id','facultads.nombre as facultad')
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

            $submodulo=Submodulo::find(12);
            $activoModulo = 0; //Estado Cerrado sin Importar la Programacion

            if($submodulo->estado == '1'){
                $activoModulo = 1; //Estado Abierto sin Importar la Programacion
            }
            elseif($submodulo->estado == '2'){

                $h=Date('Y-m-d');
                $hoy = new DateTime($h);

                $fechaini = new DateTime($submodulo->fechaini);
                $fechafin = new DateTime($submodulo->fechafin);

                if($fechaini >$hoy){
                    $activoModulo = 2; //Estado Programado: La fecha de programacion aun no inicia
                }
                elseif($hoy >=$fechaini && $hoy<=$fechafin){
                    $activoModulo = 3; //Estado Programado: La fecha de programacion esta vigente
                }
                elseif($hoy>$fechafin){
                    $activoModulo = 4; //Estado Programado: La fecha de programacion ya finalizo
                }
            }

            $permisoModulos=Permisomodulo::where('user_id',Auth::user()->id)->get();
            $permisoSubModulos=Permisossubmodulo::where('user_id',Auth::user()->id)->get();


            $modulo="docentes";
            return view('docentes.index',compact('tipouser','modulo','departamentoacademicos','semestres','facultads','semestresel','contse','semestreNombre','submodulo','activoModulo','permisoModulos','permisoSubModulos'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {   
     $buscar=$request->busca;
     $semestre_id=$request->semestre_id;

     $docentes = DB::table('docentes')
     ->join('personas', 'personas.id', '=', 'docentes.persona_id')
     ->join('semestres', 'semestres.id', '=', 'docentes.semestre_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'docentes.facultad_id')
     ->leftjoin('departamentoacademicos', 'departamentoacademicos.id', '=', 'docentes.departamentoacademico_id')
     ->where('docentes.borrado','0')
     ->where('semestres.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        $query->orWhere('departamentoacademicos.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion', 'personas.identidadetnica', 'personas.correoinstitucional',  'personas.email','personas.telefono','docentes.id',
    'docentes.personalacademico','docentes.cargogeneral','docentes.descripcioncargo','docentes.maximogrado','docentes.descmaximogrado','docentes.universidadgrado','docentes.lugarmaximogrado','docentes.paismaximogrado','docentes.otrogrado','docentes.estadootrogrado','docentes.univotrogrado','docentes.lugarotrogrado','docentes.paisotrogrado','docentes.titulo','docentes.descripciontitulo','docentes.condicion','docentes.categoria','docentes.regimen','docentes.investigador','docentes.pregrado','docentes.postgrado','docentes.esdestacado','docentes.fechaingreso','docentes.modalidadingreso','docentes.observaciones','docentes.persona_id','docentes.horaslectivas','docentes.horasnolectivas','docentes.horasinvestigacion','docentes.horasdedicacion','docentes.departamentoacademico_id','docentes.facultad_id', 'docentes.dependencia','docentes.semestre_id','semestres.nombre as semestre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `departamentoacademicos`.`nombre` , '' ) as departamentoacademico"), 'docentes.hizointercambio', 'docentes.universidadintercambio', 'docentes.eslicencia')->paginate(50);


     return [
        'pagination'=>[
            'total'=> $docentes->total(),
            'current_page'=> $docentes->currentPage(),
            'per_page'=> $docentes->perPage(),
            'last_page'=> $docentes->lastPage(),
            'from'=> $docentes->firstItem(),
            'to'=> $docentes->lastItem(),
        ],
        'docentes'=>$docentes
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
        $identidadetnica=$request->identidadetnica;
        $correoinstitucional=$request->correoinstitucional;
        
        $personalacademico=$request->personalacademico;
        $semestre_id=$request->semestre_id;
        $cargogeneral=$request->cargogeneral;
        $descripcioncargo=$request->descripcioncargo;
        $maximogrado=$request->maximogrado;
        $descmaximogrado=$request->descmaximogrado;
        $universidadgrado=$request->universidadgrado;
        $lugarmaximogrado=$request->lugarmaximogrado;
        $paismaximogrado=$request->paismaximogrado;
        $otrogrado=$request->otrogrado;
        $estadootrogrado=$request->estadootrogrado;
        $univotrogrado=$request->univotrogrado;
        $lugarotrogrado=$request->lugarotrogrado;
        $paisotrogrado=$request->paisotrogrado;
        $tituloUniv=$request->tituloUniv;
        $descripciontitulo=$request->descripciontitulo;
        $condicion=$request->condicion;
        $categoria=$request->categoria;
        $regimen=$request->regimen;
        $investigador=$request->investigador;
        $pregrado=$request->pregrado;
        $postgrado=$request->postgrado;
        $esdestacado=$request->esdestacado;
        $fechaingreso=$request->fechaingreso;
        $modalidadingreso=$request->modalidadingreso;
        $observaciones=$request->observaciones;
        $horaslectivas=$request->horaslectivas;
        $horasnolectivas=$request->horasnolectivas;
        $horasinvestigacion=$request->horasinvestigacion;
        $horasdedicacion=$request->horasdedicacion;
        $departamentoacademico_id=$request->departamentoacademico_id;
        $facultad_id=$request->facultad_id;
        $dependencia=$request->dependencia;
        $hizointercambio=$request->hizointercambio;
        $universidadintercambio=$request->universidadintercambio;
        $eslicencia=$request->eslicencia;


        $persona_id=$request->persona_id;

        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }


        if($lugarmaximogrado=="Nacional")
        {
            $paismaximogrado="PERÚ";  
        }

        if($lugarotrogrado=="Nacional")
        {
            $paisotrogrado="PERÚ";  
        }

        if($estadootrogrado=="No")
        {
            $otrogrado="";  
            $univotrogrado="";  
            $lugarotrogrado="";  
            $paisotrogrado="";  
        }

        if($tituloUniv=="No")
        {
            $descripciontitulo="";
        }

        if(intval($hizointercambio)==0)
        {
            $universidadintercambio="";
        }



        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('docentes')
        ->join('personas', 'personas.id', '=', 'docentes.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('docentes.semestre_id',$semestre_id)->count();

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

        $input15  = array('facultad_id' => $facultad_id);
        $reglas15 = array('facultad_id' => 'required');

        $input16  = array('descmaximogrado' => $descmaximogrado);
        $reglas16 = array('descmaximogrado' => 'required');

        $input17  = array('universidadgrado' => $universidadgrado);
        $reglas17 = array('universidadgrado' => 'required');

        $input18  = array('horaslectivas' => $horaslectivas);
        $reglas18 = array('horaslectivas' => 'required');

        $input19  = array('horasnolectivas' => $horasnolectivas);
        $reglas19 = array('horasnolectivas' => 'required');

        $input20  = array('horasinvestigacion' => $horasinvestigacion);
        $reglas20 = array('horasinvestigacion' => 'required');

        $input21  = array('horasdedicacion' => $horasdedicacion);
        $reglas21 = array('horasdedicacion' => 'required');

        $input22  = array('correoinstitucional' => $correoinstitucional);
        $reglas22 = array('correoinstitucional' => 'required');

        $input23  = array('eslicencia' => $eslicencia);
        $reglas23 = array('eslicencia' => 'required');

        $input24  = array('departamentoacademico_id' => $departamentoacademico_id);
        $reglas24 = array('departamentoacademico_id' => 'required');



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
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Docente con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
            $selector='txtDNI';
        }
        elseif($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Docente';
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
            $msj='Ingrese los nombres del Docente';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Docente';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Docente';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Docente';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Docente';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Docente';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Docente es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Docente es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Docente';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Docente';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Docente';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Docente';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Docente';
            $selector='txtDir';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Docente';
            $selector='txtcorreoinstitucional';
        }
        elseif ($validator15->fails() || intval($facultad_id)==0) {
            $result='0';
            $msj='Seleccione una Facultad Válida';
            $selector='facultad_id';
        }
        elseif ($validator24->fails() || intval($departamentoacademico_id)==0) {
            $result='0';
            $msj='Seleccione un Departaménto Académico Válido';
            $selector='cbudepartamentoacademico';
        }
        elseif ($validator23->fails() || intval($eslicencia) < 0 || intval($eslicencia) > 1 ) {
            $result='0';
            $msj='ingrese un valor válido de Licencia';
            $selector='cbueslicencia';
        }
        elseif($cargogeneral!='0' && strlen($dependencia)==0){
            $result='0';
            $msj='Si Seleccionó un Cargo Ocupado, ingrese la Dependencia donde ejerce dicho cargo';
            $selector='txtdependencia';
        }
        elseif($cargogeneral!='0' && strlen($descripcioncargo)==0){
            $result='0';
            $msj='Si Seleccionó un Cargo Ocupado, ingrese la descripción del cargo ocupado';
            $selector='txtdescCargo';
        }

        /*elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del Máximo Grado Obtenido';
            $selector='txtdescGrado';
        }*/
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la universidad del Máximo Grado Obtenido';
            $selector='txtunivmaxgrado';
        }
        elseif($lugarmaximogrado=='Internacional' && strlen($paismaximogrado)==0){
            $result='0';
            $msj='Si Seleccionó el Lugar de Obtención Internacional, ingrese el país donde obtuvo su máximo grado';
            $selector='txtpaismaxgrado';
        }

        elseif($estadootrogrado=='Si' && strlen($otrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado, ingrese la descripción del segundo grado académico';
            $selector='txtdescGrado2';
        }

        elseif($estadootrogrado=='Si' && strlen($univotrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado, ingrese la Universidad del segundo grado académico';
            $selector='txtunivmaxgrado2';
        }

        elseif($lugarotrogrado=='Internacional' && $estadootrogrado=='Si' && strlen($paisotrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado de un Lugar Internacional, ingrese el País donde obtuvo su segundo grado académico';
            $selector='txtpaismaxgrado2';
        }

        elseif($tituloUniv=='Si' && strlen($descripciontitulo)==0){
            $result='0';
            $msj='Si Seleccionó la Opción de contar con Título Profesional, ingrese la descripción del Título Profesional';
            $selector='txttitulouniv';
        }


        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese las Horas Lectivas de Clase';
            $selector='txthorasLectivas';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese las Horas No Lectivas de Clase';
            $selector='horasnolectivas';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese las Horas dedicadas a investigación';
            $selector='horasinvestigacion';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese las Horas de Dedicación';
            $selector='txthorasdedicacion';
        }
  

        elseif (strlen($fechaingreso)==0) {
            $result='0';
            $msj='Ingrese la Fecha de Ingreso a la Universidad';
            $selector='txtfechaingreso';
        }

        elseif (strlen($modalidadingreso)==0) {
            $result='0';
            $msj='Ingrese la Modalidad de Ingreso a la Universidad';
            $selector='txtmodalidadingreso';
        }

        elseif($hizointercambio!='0' && strlen($universidadintercambio)==0){
            $result='0';
            $msj='Si Seleccionó que realizó intercambio, ingrese la Universidad en la que lo realizó';
            $selector='txtuniversidadintercambio';
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
            $editPersona->correoinstitucional=$correoinstitucional;
            $editPersona->identidadetnica=$identidadetnica;

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
            $newPersona->correoinstitucional=$correoinstitucional;
            $newPersona->identidadetnica=$identidadetnica;
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }

        $newDocente = new Docente();

        $newDocente->personalacademico=$personalacademico;
        $newDocente->cargogeneral=$cargogeneral;
        $newDocente->descripcioncargo=$descripcioncargo;
        $newDocente->maximogrado=$maximogrado;
        $newDocente->descmaximogrado=$descmaximogrado;
        $newDocente->universidadgrado=$universidadgrado;
        $newDocente->lugarmaximogrado=$lugarmaximogrado;
        $newDocente->paismaximogrado=$paismaximogrado;
        $newDocente->otrogrado=$otrogrado;
        $newDocente->estadootrogrado=$estadootrogrado;
        $newDocente->univotrogrado=$univotrogrado;
        $newDocente->lugarotrogrado=$lugarotrogrado;
        $newDocente->paisotrogrado=$paisotrogrado;
        $newDocente->titulo=$tituloUniv;
        $newDocente->descripciontitulo=$descripciontitulo;
        $newDocente->condicion=$condicion;
        $newDocente->categoria=$categoria;
        $newDocente->regimen=$regimen;
        $newDocente->investigador=$investigador;
        $newDocente->pregrado=$pregrado;
        $newDocente->postgrado=$postgrado;
        $newDocente->esdestacado=$esdestacado;
        $newDocente->fechaingreso=$fechaingreso;
        $newDocente->modalidadingreso=$modalidadingreso;
        $newDocente->observaciones=$observaciones;
        $newDocente->persona_id=$persona_id;
        $newDocente->horaslectivas=$horaslectivas;
        $newDocente->horasnolectivas=$horasnolectivas;
        $newDocente->horasinvestigacion=$horasinvestigacion;
        $newDocente->horasdedicacion=$horasdedicacion;
        $newDocente->dependencia=$dependencia;
        $newDocente->departamentoacademico_id=$departamentoacademico_id;
        $newDocente->facultad_id=$facultad_id;
        $newDocente->semestre_id=$semestre_id;
        $newDocente->email=$email;
        $newDocente->hizointercambio=$hizointercambio;
        $newDocente->universidadintercambio=$universidadintercambio;
        $newDocente->eslicencia=$eslicencia;
        $newDocente->activo='1';
        $newDocente->borrado='0';
        $newDocente->save();

           

            $msj='Nuevo Docente registrado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function show(Docente $docente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function edit(Docente $docente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Docente  $docente
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
        $identidadetnica=$request->identidadetnica;
        $correoinstitucional=$request->correoinstitucional;
        
        $personalacademico=$request->personalacademico;
        $semestre_id=$request->semestre_id;
        $cargogeneral=$request->cargogeneral;
        $descripcioncargo=$request->descripcioncargo;
        $maximogrado=$request->maximogrado;
        $descmaximogrado=$request->descmaximogrado;
        $universidadgrado=$request->universidadgrado;
        $lugarmaximogrado=$request->lugarmaximogrado;
        $paismaximogrado=$request->paismaximogrado;
        $otrogrado=$request->otrogrado;
        $estadootrogrado=$request->estadootrogrado;
        $univotrogrado=$request->univotrogrado;
        $lugarotrogrado=$request->lugarotrogrado;
        $paisotrogrado=$request->paisotrogrado;
        $titulo=$request->titulo;
        $descripciontitulo=$request->descripciontitulo;
        $condicion=$request->condicion;
        $categoria=$request->categoria;
        $regimen=$request->regimen;
        $investigador=$request->investigador;
        $pregrado=$request->pregrado;
        $postgrado=$request->postgrado;
        $esdestacado=$request->esdestacado;
        $fechaingreso=$request->fechaingreso;
        $modalidadingreso=$request->modalidadingreso;
        $observaciones=$request->observaciones;
        $horaslectivas=$request->horaslectivas;
        $horasnolectivas=$request->horasnolectivas;
        $horasinvestigacion=$request->horasinvestigacion;
        $horasdedicacion=$request->horasdedicacion;
        $departamentoacademico_id=$request->departamentoacademico_id;
        $facultad_id=$request->facultad_id;
        $dependencia=$request->dependencia;
        $hizointercambio=$request->hizointercambio;
        $universidadintercambio=$request->universidadintercambio;
        $eslicencia=$request->eslicencia;


        $persona_id=$request->persona_id;

        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }


        if($lugarmaximogrado=="Nacional")
        {
            $paismaximogrado="PERÚ";  
        }

        if($lugarotrogrado=="Nacional")
        {
            $paisotrogrado="PERÚ";  
        }

        if($estadootrogrado=="No")
        {
            $otrogrado="";  
            $univotrogrado="";  
            $lugarotrogrado="";  
            $paisotrogrado="";  
        }

        if($titulo=="No")
        {
            $descripciontitulo="";
        }

        if(intval($hizointercambio)==0)
        {
            $universidadintercambio="";
        }



        $result='1';
        $msj='';
        $selector='';


        $regla0=DB::table('docentes')
        ->join('personas', 'personas.id', '=', 'docentes.persona_id')
        ->where('docentes.id','<>',$id)
        ->where('personas.tipodoc',$tipodoc)
        ->where('personas.doc',$doc)
        ->where('docentes.semestre_id',$semestre_id)->count();

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

        $input15  = array('facultad_id' => $facultad_id);
        $reglas15 = array('facultad_id' => 'required');

        $input16  = array('descmaximogrado' => $descmaximogrado);
        $reglas16 = array('descmaximogrado' => 'required');

        $input17  = array('universidadgrado' => $universidadgrado);
        $reglas17 = array('universidadgrado' => 'required');

        $input18  = array('horaslectivas' => $horaslectivas);
        $reglas18 = array('horaslectivas' => 'required');

        $input19  = array('horasnolectivas' => $horasnolectivas);
        $reglas19 = array('horasnolectivas' => 'required');

        $input20  = array('horasinvestigacion' => $horasinvestigacion);
        $reglas20 = array('horasinvestigacion' => 'required');

        $input21  = array('horasdedicacion' => $horasdedicacion);
        $reglas21 = array('horasdedicacion' => 'required');

        $input22  = array('correoinstitucional' => $correoinstitucional);
        $reglas22 = array('correoinstitucional' => 'required');

        $input23  = array('eslicencia' => $eslicencia);
        $reglas23 = array('eslicencia' => 'required');

        $input24  = array('departamentoacademico_id' => $departamentoacademico_id);
        $reglas24 = array('departamentoacademico_id' => 'required');




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
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Docente con el Tipo y Documento de Identidad ingresado, del semestre seleccionado';
            $selector='txtDNIE';
        }
        elseif($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Docente';
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
            $msj='Ingrese los nombres del Docente';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Docente';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Docente';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Docente';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Docente';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Docente';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Docente es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el Docente es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Docente';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Docente';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Docente';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Docente';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Docente';
            $selector='txtDirE';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Docente';
            $selector='txtcorreoinstitucionalE';
        }
        elseif ($validator15->fails() || intval($facultad_id)==0) {
            $result='0';
            $msj='Seleccione una Facultad Válida';
            $selector='facultad_idE';
        }
        elseif ($validator24->fails() || intval($departamentoacademico_id)==0) {
            $result='0';
            $msj='Seleccione un Departaménto Académico Válido';
            $selector='cbudepartamentoacademicoE';
        }
        elseif ($validator23->fails() || intval($eslicencia) < 0 || intval($eslicencia) > 1 ) {
            $result='0';
            $msj='ingrese un valor válido de Licencia';
            $selector='cbueslicenciaE';
        }
        elseif($cargogeneral!='0' && strlen($dependencia)==0){
            $result='0';
            $msj='Si Seleccionó un Cargo Ocupado, ingrese la Dependencia donde ejerce dicho cargo';
            $selector='txtdependenciaE';
        }
        elseif($cargogeneral!='0' && strlen($descripcioncargo)==0){
            $result='0';
            $msj='Si Seleccionó un Cargo Ocupado, ingrese la descripción del cargo ocupado';
            $selector='txtdescCargoE';
        }

        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del Máximo Grado Obtenido';
            $selector='txtdescGradoE';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Ingrese la universidad del Máximo Grado Obtenido';
            $selector='txtunivmaxgradoE';
        }
        elseif($lugarmaximogrado=='Internacional' && strlen($paismaximogrado)==0){
            $result='0';
            $msj='Si Seleccionó el Lugar de Obtención Internacional, ingrese el país donde obtuvo su máximo grado';
            $selector='txtpaismaxgradoE';
        }

        elseif($estadootrogrado=='Si' && strlen($otrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado, ingrese la descripción del segundo grado académico';
            $selector='txtdescGrado2E';
        }

        elseif($estadootrogrado=='Si' && strlen($univotrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado, ingrese la Universidad del segundo grado académico';
            $selector='txtunivmaxgrado2E';
        }

        elseif($lugarotrogrado=='Internacional' && $estadootrogrado=='Si' && strlen($paisotrogrado)==0){
            $result='0';
            $msj='Si Seleccionó la Opción Otro Grado de un Lugar Internacional, ingrese el País donde obtuvo su segundo grado académico';
            $selector='txtpaismaxgrado2E';
        }

        elseif($titulo=='Si' && strlen($descripciontitulo)==0){
            $result='0';
            $msj='Si Seleccionó la Opción de contar con Título Profesional, ingrese la descripción del Título Profesional';
            $selector='txttitulounivE';
        }


        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese las Horas Lectivas de Clase';
            $selector='txthorasLectivasE';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese las Horas No Lectivas de Clase';
            $selector='horasnolectivasE';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese las Horas dedicadas a investigación';
            $selector='horasinvestigacionE';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese las Horas de Dedicación';
            $selector='txthorasdedicacionE';
        }
  

        elseif (strlen($fechaingreso)==0) {
            $result='0';
            $msj='Ingrese la Fecha de Ingreso a la Universidad';
            $selector='txtfechaingresoE';
        }

        elseif (strlen($modalidadingreso)==0) {
            $result='0';
            $msj='Ingrese la Modalidad de Ingreso a la Universidad';
            $selector='txtmodalidadingresoE';
        }

        elseif($hizointercambio!='0' && strlen($universidadintercambio)==0){
            $result='0';
            $msj='Si Seleccionó que realizó intercambio, ingrese la Universidad en la que lo realizó';
            $selector='txtuniversidadintercambioE';
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
            $editPersona->correoinstitucional=$correoinstitucional;
            $editPersona->identidadetnica=$identidadetnica;

            $editPersona->save();
        
        $editDocente = Docente::find($id);

        $editDocente->personalacademico=$personalacademico;
        $editDocente->cargogeneral=$cargogeneral;
        $editDocente->descripcioncargo=$descripcioncargo;
        $editDocente->maximogrado=$maximogrado;
        $editDocente->descmaximogrado=$descmaximogrado;
        $editDocente->universidadgrado=$universidadgrado;
        $editDocente->lugarmaximogrado=$lugarmaximogrado;
        $editDocente->paismaximogrado=$paismaximogrado;
        $editDocente->otrogrado=$otrogrado;
        $editDocente->estadootrogrado=$estadootrogrado;
        $editDocente->univotrogrado=$univotrogrado;
        $editDocente->lugarotrogrado=$lugarotrogrado;
        $editDocente->paisotrogrado=$paisotrogrado;
        $editDocente->titulo=$titulo;
        $editDocente->descripciontitulo=$descripciontitulo;
        $editDocente->condicion=$condicion;
        $editDocente->categoria=$categoria;
        $editDocente->regimen=$regimen;
        $editDocente->investigador=$investigador;
        $editDocente->pregrado=$pregrado;
        $editDocente->postgrado=$postgrado;
        $editDocente->esdestacado=$esdestacado;
        $editDocente->fechaingreso=$fechaingreso;
        $editDocente->modalidadingreso=$modalidadingreso;
        $editDocente->observaciones=$observaciones;
        $editDocente->persona_id=$persona_id;
        $editDocente->horaslectivas=$horaslectivas;
        $editDocente->horasnolectivas=$horasnolectivas;
        $editDocente->horasinvestigacion=$horasinvestigacion;
        $editDocente->horasdedicacion=$horasdedicacion;
        $editDocente->dependencia=$dependencia;
        $editDocente->departamentoacademico_id=$departamentoacademico_id;
        $editDocente->facultad_id=$facultad_id;
        $editDocente->semestre_id=$semestre_id;
        $editDocente->email=$email;
        $editDocente->hizointercambio=$hizointercambio;
        $editDocente->universidadintercambio=$universidadintercambio;
        $editDocente->eslicencia=$eslicencia;

        $editDocente->save();

           

            $msj='Docente modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Docente  $docente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $borrar = Docente::destroy($id);
        //$task->delete();


        $msj='Docente Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {
        $buscar=$request->busca;
        $semestre_id=$request->semestre_id;   

        $semestre=Semestre::find($semestre_id);

        Excel::create('Docentes Registrados en el Semestre: '.$semestre->nombre, function($excel) use($buscar,$semestre)  {
            $excel->sheet('Base de Datos de Docentes', function($sheet) use($buscar,$semestre){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:AY3');
                $sheet->cells('A3:AY3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:AY3', 'thin');
                $sheet->cells('A3:AY3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:AY4', function($cells)
                {
                    $cells->setBackground('#B4B9E1');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');

                });

              

                

                $data=[];

                $sheet->setWidth(array
                (
                'A'=>'7',
                'B'=>'20',
                'C'=>'25',
                'D'=>'25',
                'E'=>'20',
                'F'=>'25',
                'G'=>'12',
                'H'=>'20',
                'I'=>'14',
                'J'=>'20',
                'K'=>'30',
                'L'=>'10',
                'M'=>'35',
                'N'=>'35',
                'O'=>'35',
                'P'=>'20',
                'Q'=>'30',
                'R'=>'30',
                'S'=>'25',
                'T'=>'35',
                'U'=>'42',
                'V'=>'40',
                'W'=>'40',
                'X'=>'30',
                'Y'=>'37',
                'Z'=>'40',
                'AA'=>'42',
                'AB'=>'40',
                'AC'=>'20',
                'AD'=>'40',
                'AE'=>'35',
                'AF'=>'25',
                'AG'=>'25',
                'AH'=>'20',
                'AI'=>'23',
                'AJ'=>'23',
                'AK'=>'20',
                'AL'=>'20',
                'AM'=>'33',
                'AN'=>'33',
                'AO'=>'25',
                'AP'=>'35',
                'AQ'=>'25',
                'AR'=>'33',
                'AS'=>'15',
                'AT'=>'33', //correo institucional
                'AU'=>'33',  //identidad etnica
                'AV'=>'25',  //hizo intercambio
                'AW'=>'40',  //universidad donde hizo el intercambio
                'AX'=>'25',  // esta de licencia
                'AY'=>'65'
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DOCENTES - SEMESTRE '.$semestre->nombre;

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AT4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL', 'SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','SEMESTRE','DEPENDENCIA','FACULTAD','DEPARTAMENTO ACADEMICO','PERSONAL ACADÉMICO','CARGO GENERAL','DESCRIPCIÓN DEL CARGO','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO','UNIVERSIDAD DONDE OBTUVO EL MÁXIMO GRADO','LUGAR DONDE OBTUVO EL MÁXIMO GRADO','PAÍS DONDE OBTUVO EL MÁXIMO GRADO','OTRO GRADO ACADÉMICO','SITUACIÓN DEL OTRO GRADO ACADÉMICO','UNIVERSIDAD DONDE OBTUVO EL OTRO GRADO','LUGAR DONDE OBTUVO EL OTRO GRADO','PAÍS DONDE OBTUVO EL OTRO GRADO','TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','CLASE CONDICIÓN DE DOCENTE','CATEGORÍA DOCENTE','RÉGIMEN DE DEDICACIÓN','ES INGESTIGADOR','ES DOCENTE PREGRADO','ES DOCENTE POSTGRADO','HORAS LECTIVAS','HORAS NO LECTIVAS','HORAS DE INVESTIGACIÓN SEMANAL','HORAS DE DEDICACIÓN SEMANAL','ES DOCENTE DESTACADO','FECHA DE INGRESO A LA UNIVERSIDAD','MODALIDAD DE INGRESO','CORREO PERSONAL','TELÉFONO', 'CORREO INSTITUCIONAL','IDENTIDAD ETNICA', 'HIZO INTERCAMBIO','UNIVERSIDAD DONDE HIZO INTERCAMBIO','ESTA DE LICENCIA', 'OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $docentes = DB::table('docentes')
     ->join('personas', 'personas.id', '=', 'docentes.persona_id')
     ->join('semestres', 'semestres.id', '=', 'docentes.semestre_id')
     ->leftjoin('facultads', 'facultads.id', '=', 'docentes.facultad_id')
     ->leftjoin('departamentoacademicos', 'departamentoacademicos.id', '=', 'docentes.departamentoacademico_id')
     ->where('docentes.borrado','0')
     ->where('semestres.id',$semestre->id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('facultads.nombre','like','%'.$buscar.'%');
        $query->orWhere('departamentoacademicos.nombre','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono', 'personas.correoinstitucional', 'personas.identidadetnica',
     'docentes.id',
    'docentes.personalacademico','docentes.cargogeneral','docentes.descripcioncargo',DB::Raw("if(`docentes`.`maximogrado`='0','SIN GRADO REGISTRADO',`docentes`.`maximogrado`) as maximogrado") ,'docentes.descmaximogrado','docentes.universidadgrado','docentes.lugarmaximogrado','docentes.paismaximogrado','docentes.otrogrado','docentes.estadootrogrado','docentes.univotrogrado','docentes.lugarotrogrado','docentes.paisotrogrado','docentes.titulo','docentes.descripciontitulo','docentes.condicion','docentes.categoria','docentes.regimen','docentes.investigador','docentes.pregrado','docentes.postgrado','docentes.esdestacado','docentes.fechaingreso','docentes.modalidadingreso','docentes.observaciones','docentes.persona_id','docentes.horaslectivas','docentes.horasnolectivas','docentes.horasinvestigacion','docentes.horasdedicacion','docentes.departamentoacademico_id','docentes.facultad_id', 'docentes.dependencia','docentes.semestre_id','semestres.nombre as semestre',DB::Raw("IFNULL( `facultads`.`nombre` , '' ) as facultad"),DB::Raw("IFNULL( `departamentoacademicos`.`nombre` , '' ) as departamentoacademico"), 'docentes.hizointercambio', 'docentes.universidadintercambio', 'docentes.eslicencia')->get();

        foreach ($docentes as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AT'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');



           array_push($data, array($key+1,
           tipoDoc($dato->tipodoc),
           $dato->doc,
           $dato->apellidopat,
           $dato->apellidomat,
           $dato->nombres,
           genero(strval($dato->genero)),
           pasFechaVista($dato->fechanac),
           estadoCivil($dato->estadocivil,$dato->genero),
           esDiscpacitado($dato->esdiscapacitado),
           $dato->discapacidad,
           $semestre->nombre,
           $dato->dependencia,
           $dato->facultad,
           $dato->departamentoacademico,
           $dato->personalacademico,
           cargoGeneral($dato->cargogeneral),
           $dato->descripcioncargo,
           maximoGrado($dato->maximogrado),
           $dato->descmaximogrado,
           $dato->universidadgrado,
           $dato->lugarmaximogrado,
           $dato->paismaximogrado,
           $dato->otrogrado,
           $dato->estadootrogrado,
           $dato->univotrogrado,
           $dato->lugarotrogrado,
           $dato->paisotrogrado,
           $dato->titulo,
           $dato->descripciontitulo,
           $dato->condicion,
           $dato->categoria,
           $dato->regimen,
           SiUnoNoCero($dato->investigador),
           SiUnoNoCero($dato->pregrado),
           SiUnoNoCero($dato->postgrado),
           $dato->horaslectivas,
           $dato->horasnolectivas,
           $dato->horasinvestigacion,
           $dato->horasdedicacion,
           SiUnoNoCero($dato->esdestacado),
           pasFechaVista($dato->fechaingreso),
           $dato->modalidadingreso,
           $dato->email,
           $dato->telefono,
           $dato->correoinstitucional,
           $dato->identidadetnica,
           SiUnoNoCero($dato->hizointercambio),
           $dato->universidadintercambio,
           SiUnoNoCero($dato->eslicencia),
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }



















    public function importarArchivo(Request $request)
    {
        ini_set('memory_limit','256M');

        ini_set('upload_max_filesize','128M');

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

       // $nombreArchivo="";

        $result='1';
        $msj='';
        $selector='';
        $errorColumna='';
        $errorFila='';

        if($request->hasFile('archivo')){



           /* $nombreArchivo=$request->nombreArchivo;*/

            $aux2='docente'.date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,51200');
            $validatorF = Validator::make($input2, $reglas2);

          /*  $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);*/

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene un tamaño no válido superior a los 5 MB, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo';
            }
          /*  elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }*/
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                //$subir2=Storage::disk('revistas')->put($nuevoNombre2, \File::get($file));
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

               

                if($extension2=="xls" || $extension2=="xlsx"  || $extension2=="XLS" || $extension2=="XLSX" )
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo';
                }
            }

        }

        if($segureFile==1){
            Storage::disk('infoFile')->delete($archivo);

            
        }
        else
        {

             $variablePrueba = "hola"; //si quieres meter una variable exterma al recorrido del excel

             $fecha=date("Y-m-d");

            $errorFila="";
            $errorColumna="";
            $detError="";
            $error=0;
            $msj="";
    
            $semestres=Semestre::where('activo','1')->where('borrado','0')->get();
            $departamentos=Departamentoacademico::where('activo','1')->where('borrado','0')->get();


                 Excel::load(public_path().'/archivosExcel/'.$archivo, function ($reader) use (&$errorFila,  &$errorColumna,  &$detError, &$error, $archivo, &$msj, $semestres, $departamentos, &$result, &$selector) { 

                    //$reader->first(); // Leer datos de la primera hoja

                   $resultado=$reader->skipRows(4)->first();


                   $error=0;

                   

                   foreach ($resultado as $key => $row) {

                    
                    // Validando c_sem

                    $bandera01=false;
                    foreach ($semestres as $key3 => $dato) {
                        if(intval($row->c_sem)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna SEMESTRE DE REGISTRO";
                        $detError="El Identificador de Semestre no corresponde a ninguno ingresado en la base de datos. Corrija la Columna B, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_depar_academico

                    $bandera01=false;
                    foreach ($departamentos as $key4 => $dato) {
                        if(intval($row->c_depar_academico)==$dato->id)
                        {
                            $bandera01=true;
                            break;
                        }
                    }
                    if($bandera01==false){
        
                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DEPARTAMENTO ACADÉMICO";
                        $detError="El Identificador de Departamento Académico no corresponde a ningun Departamento Académico registrado en la base de datos. Corrija la Columna C, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_tipodoc

                    $bandera01=false;
                    if(intval($row->c_tipodoc)==1 || intval($row->c_tipodoc)==2 || intval($row->c_tipodoc)==3 || intval($row->c_tipodoc)==4 || intval($row->c_tipodoc)==5){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna TIPO DE DOCUMENTO";
                        $detError="El código del Tipo de Documento no corresponde a los valores posibles de ser consignados (1: DNI, 2: RUC, 3: Carnet de Extranjería, 4: Pasaporte, 5: Partida de Nacimiento). Corrija la Columna D, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_numdoc

                    $bandera01=false;
                    if(strlen(trim($row->c_numdoc))>=8){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna NÚMERO DE DOCUMENTO";
                        $detError="El Número de Documento de Indentidad ingresado se encuentran en blanco o no cuenta con un formato correcto. Corrija la Columna E, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_apepat

                    $bandera01=false;
                    if(strlen(trim($row->c_apepat))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna APELLIDO PATERNO";
                        $detError="El Apellido ingresado se encuentran en blanco. Corrija la Columna F, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_noms

                    $bandera01=false;
                    if(strlen(trim($row->c_noms))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna NOMBRES";
                        $detError="Los Nombres ingresados se encuentran en blanco. Corrija la columna H, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_genero

                    $bandera01=false;
                    if((trim($row->c_genero)=="M") || (trim($row->c_genero)=="F") || (trim($row->c_genero)=="m") || (trim($row->c_genero)=="f")){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna GÉNERO";
                        $detError="Consideró un dato no identificado, indique M para másculino ó F para femenino, sin espacios en blanco. Corrija la Columna I, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_fechanac

                    if(strlen(trim($row->c_fechanac))==10){

                        if(checkdate(intval(substr($row->c_fechanac, -7,2)), intval(substr($row->c_fechanac, -10,2)), intval(substr($row->c_fechanac, -4)))){
                            $var=pasFechaBD($row->c_fechanac);
                            $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                            $fechanac=$dateTime->format('Y-m-d');
                            $bandera01=false;
                            if($fechanac != null){
                                $bandera01=true;
                                }
                                if($bandera01==false){
            
                                    $errorFila="Error en la Fila ".($key+6);
                                    $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                                    $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna J, Fila ".($key+6);
                                    $error=1;
                                    break 1;
            
                                }
                        }
                        else{
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna J, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    }
                    else{
                        if($row->c_fechanac != null && strlen($row->c_fechanac->format('Y-m-d')) != null){
                            $bandera01=true;
                        }
                        else{
                            $bandera01=false;
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE NACIMIENTO";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto dd/mm/aaaa. Corrija la Columna J, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_estadociv

                    $bandera01=false;
                    if(intval($row->c_estadociv)==1 || intval($row->c_estadociv)==2 || intval($row->c_estadociv)==3 || intval($row->c_estadociv)==4){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ESTADO CIVIL";
                        $detError="El código del Estado CIvil no corresponde a los valores posibles de ser consignados (1: Soltero (a), 2: Casado (a), 3: Viudo (a), ó 4: Divorsiado (a)). Corrija la Columna K, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_esdisca

                    $bandera01=false;
                    if(intval($row->c_esdisca)==1 || intval($row->c_esdisca)==0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna SUFRE DISCAPACIDAD";
                        $detError="El código de Condición de Discapacidad no corresponde a los valores posibles de ser consignados. Consigne 1 para SI o 0 para NO. Corrija la Columna L, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_disca

                    //var_dump($row);

                    if( intval($row->c_esdisca)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_disca))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DISCAPACIDAD QUE PADECE";
                            $detError="Si ha ingresado que el Alumno es Discapacitado, ingrese la Discapacidad que padece, no puede dejar el registro en blanco. Corrija la Columna M, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_identidad

                    $bandera01=false;
                    if(strlen(trim($row->c_identidad))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna IDENTIDAD ÉTNICA";
                        $detError="Los datos de identidad étnica se encuentran en blanco. Corrija la columna N, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_licencia

                    $bandera01=false;
                    if(intval($row->c_licencia)==1 || intval($row->c_licencia)==0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿SE ENCUENTRA DE LICENCIA?";
                        $detError="El código de si se cuenta  de Licencia no corresponde a los valores posibles de ser consignados. Consigne 1 para SI ó 0 para NO. Corrija la Columna O, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_cargo

                    $bandera01=false;
                    if(intval($row->c_cargo)==0 || intval($row->c_cargo)==1 || intval($row->c_cargo)==2 || intval($row->c_cargo)==3 || intval($row->c_cargo)==4 ||
                    intval($row->c_cargo)==5 || intval($row->c_cargo)==6 || intval($row->c_cargo)==7 || intval($row->c_cargo)==8 || intval($row->c_cargo)==9 ||
                    intval($row->c_cargo)==10 || intval($row->c_cargo)==11 || intval($row->c_cargo)==12 || intval($row->c_cargo)==13 || intval($row->c_cargo)==14                    
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CARGO GENERAL";
                        $detError="El código de Cargo General no corresponde a los valores posibles a ser consignados, no puede dejar el registro en blanco. Corrija la Columna P, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_dependencia

                    if( intval($row->c_cargo)!=0){
                        $bandera01=false;
                        if(strlen(trim($row->c_dependencia))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DEPENDENCIA DE CARGO";
                            $detError="Si consignó que el docente ocupa un cargo general en este semestre, debe de ingresar la dependencia en la que desempeña sus funciones del cargo. Corrija la Columna Q, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_tipo_per

                    $bandera01=false;
                    if(intval($row->c_tipo_per)==1 || intval($row->c_tipo_per)==2){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿TIPO DE PERSONAL ACADÉMICO?";
                        $detError="El código de Tipo de Personal Académico no corresponde a los valores posibles a ser consignados, indique 1 para Docente o 2 para Jefe de Práctica. Corrija la Columna S, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_max_grado

                    $bandera01=false;
                    if(intval($row->c_max_grado)==0 || intval($row->c_max_grado)==1 || intval($row->c_max_grado)==2 || intval($row->c_max_grado)==3 || intval($row->c_max_grado)==4 ||
                    intval($row->c_max_grado)==5 || intval($row->c_max_grado)==6                
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna MAXIMO GRADO ACADÉMICO";
                        $detError="El valor ingresado no corresponde a ninguno de los valores posibles. Corrija la Columna T, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_desc_max_grado

                    $bandera01=false;
                    if(strlen(trim($row->c_desc_max_grado))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO";
                        $detError="Debe de ingresar la descripción del máximo grado académico del Docente. Corrija la Columna U, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                     // Validando c_univ_max_grado

                     $bandera01=false;
                     if(strlen(trim($row->c_univ_max_grado))>0){
                         $bandera01=true;
                         }
                     if($bandera01==false){
 
                         $errorFila="Error en la Fila ".($key+6);
                         $errorColumna="Error en la Columna UNIVERSIDAD DEL MÁXIMO GRADO ACADÉMICO";
                         $detError="Debe de ingresar la descripción de la Universidad del máximo grado académico del Docente. Corrija la Columna V, Fila ".($key+6);
                         $error=1;
                         break 1;
                     }


                     // Validando c_lugar_max_grado

                    $bandera01=false;
                    if(intval($row->c_lugar_max_grado)==1 || intval($row->c_lugar_max_grado)==2){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna LUGAR DEL MÁXIMO GRADO ACADÉMICO";
                        $detError="El código de Lugar del Máximo grado académico solo debe de llevar valores de 1: Nacional o 2:Internacional. Corrija la Columna W, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_pais_max_grado

                    if( intval($row->c_lugar_max_grado)==2){
                        $bandera01=false;
                        if(strlen(trim($row->c_pais_max_grado))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna PAÍS DONDE OBTUVO EL MÁXIMO GRADO ACADÉMICO";
                            $detError="Si ha indicado que el lugar donde obtuvo su máximo grado es internacional: Debe de ingresar la descripción del país donde el Docente obtuvo su máximo grado académico. Corrija la Columna X, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_tiene_otrogrado

                    $bandera01=false;
                    if(intval($row->c_tiene_otrogrado)==0 || intval($row->c_tiene_otrogrado)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿TIENE OTRO GRADO ACADÉMICO?";
                        $detError="El código de ¿Tiene Otro grado Académico? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna Y, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_otrogrado

                    if( intval($row->c_tiene_otrogrado)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_otrogrado))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna OTRO GRADO ACADÉMICO";
                            $detError="Si ha ingresado que el docente tiene otro grado académico, Debe de ingresar la descripción del Otro grado académico del Docente. Corrija la Columna Z, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_univ_otrogrado

                    if( intval($row->c_tiene_otrogrado)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_univ_otrogrado))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna UNIVERSIDAD DONDE OBTUVO EL OTRO GRADO ACADÉMICO";
                            $detError="Si ha ingresado que el docente tiene otro grado académico, Debe de ingresar la universidad donde el Docente obtuvo este grado académico. Corrija la Columna AA, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_lugar_otrogrado

                    if( intval($row->c_tiene_otrogrado)==1){
                        $bandera01=false;
                        if(intval($row->c_lugar_otrogrado)==1 || intval($row->c_lugar_otrogrado)==2){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna LUGAR DONDE OBTUVO EL OTRO GRADO ACADÉMICO";
                            $detError="Si ha ingresado que el docente tiene otro grado académico, Debe de ingresar correctamente el código de Lugar donde el docente obtuvo el otro grado académico: solo debe de llevar valores de 1: Nacional o 2:Internacional. Corrija la Columna AB, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_pais_otrogrado

                    if( intval($row->c_tiene_otrogrado)==1 && intval($row->c_lugar_otrogrado)==2){
                        $bandera01=false;
                        if(strlen(trim($row->c_pais_otrogrado))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna PAÍS DONDE OBTUVO EL OTRO GRADO ACADÉMICO";
                            $detError="Si ha ingresado que el docente tiene otro grado académico y si ha indicado que el lugar donde lo obtuvo es internacional: Debe de ingresar la descripción del país donde el Docente obtuvo su máximo grado académico. Corrija la Columna AC, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }


                    // Validando c_tiene_titulo

                    $bandera01=false;
                    if(intval($row->c_tiene_titulo)==0 || intval($row->c_tiene_titulo)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿TIENE TÍTULO UNIVERSITARIO?";
                        $detError="El código de ¿Tiene Título Universitario? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AD, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_titulo

                    if( intval($row->c_tiene_titulo)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_titulo))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO";
                            $detError="Si indicó que el Docente tiene título Universitario: Debe de ingresar la descripción del título Universitario del Docente. Corrija la Columna AE, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_clase

                    $bandera01=false;
                    if(intval($row->c_clase)==0 || intval($row->c_clase)==1 || intval($row->c_clase)==2 || intval($row->c_clase)==3 || intval($row->c_clase)==4 ||
                    intval($row->c_clase)==5 || intval($row->c_clase)==6 || intval($row->c_clase)==7   || intval($row->c_clase)==8   || intval($row->c_clase)==9                  
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CLASE O CONDICIÓN";
                        $detError="El código de Clase o Condición de Docente no corresponde a los valores posibles a ser consignados, no puede dejar el registro en blanco. Corrija la Columna AF, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_categoria

                    $bandera01=false;
                    if(intval($row->c_categoria)==1 || intval($row->c_categoria)==2 || intval($row->c_categoria)==3            
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CATEGORÍA";
                        $detError="El código de Categoría de Docente no corresponde a los valores posibles a ser consignados, Indique 1:Auxiliar, 2:Asociado o 3:Principal. No puede dejar el registro en blanco. Corrija la Columna AG, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_regimen

                    $bandera01=false;
                    if(intval($row->c_regimen)==1 || intval($row->c_regimen)==2 || intval($row->c_regimen)==3            
                    ){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna RÉGIMEN DE DEDICACIÓN";
                        $detError="El código de Régimen de Dedicación del Docente no corresponde a los valores posibles a ser consignados, Indique 1:Tiempo Completo, 2:Tiempo Parcial o 3:Dedicación Exclusiva. No puede dejar el registro en blanco. Corrija la Columna AH, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_es_investigador

                    $bandera01=false;
                    if(intval($row->c_es_investigador)==0 || intval($row->c_es_investigador)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿ES INVESTIGADOR?";
                        $detError="El código de ¿Es Investigador? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AI, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_es_pregrado

                    $bandera01=false;
                    if(intval($row->c_es_pregrado)==0 || intval($row->c_es_pregrado)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿ES DOCENTE DE PREGRADO?";
                        $detError="El código de ¿Es Docente Pregrado? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AJ, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_es_postgrado

                    $bandera01=false;
                    if(intval($row->c_es_postgrado)==0 || intval($row->c_es_postgrado)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿ES DOCENTE DE POSTGRADO?";
                        $detError="El código de ¿Es Docente Postgrado? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AK, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_es_destacado

                    $bandera01=false;
                    if(intval($row->c_es_destacado)==0 || intval($row->c_es_destacado)==1){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿ES DOCENTE DESTACADO?";
                        $detError="El código de ¿Es Docente Destacado? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AL, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_horas_lectivas

                    $bandera01=true;
                    if(intval($row->c_horas_lectivas)<0){
                        $bandera01=false;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna HORAS LECTIVAS";
                        $detError="El dato consignado no es correcto debe de ingresar un dato númerico. Corrija la Columna AM, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_horas_no_lectivas

                    $bandera01=true;
                    if(intval($row->c_horas_no_lectivas)<0){
                        $bandera01=false;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna HORAS NO LECTIVAS";
                        $detError="El dato consignado no es correcto debe de ingresar un dato númerico. Corrija la Columna AN, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_horas_investigacion

                    $bandera01=true;
                    if(intval($row->c_horas_investigacion)<0){
                        $bandera01=false;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna HORAS DE INVESTIGACIÓN";
                        $detError="El dato consignado no es correcto debe de ingresar un dato númerico. Corrija la Columna AO, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_horas_dedicacion

                    $bandera01=true;
                    if(intval($row->c_horas_dedicacion)<0){
                        $bandera01=false;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna HORAS DE DEDICACIÓN";
                        $detError="El dato consignado no es correcto debe de ingresar un dato númerico. Corrija la Columna AP, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_fecha_ingreso

                    if(strlen(trim($row->c_fecha_ingreso))==10){

                        if(checkdate(intval(substr($row->c_fecha_ingreso, -7,2)), intval(substr($row->c_fecha_ingreso, -10,2)), intval(substr($row->c_fecha_ingreso, -4)))){
                            $var=pasFechaBD($row->c_fecha_ingreso);
                            $dateTime = DateTime::createFromFormat('Y-m-d', $var);  //pasar a datetime
                            $fechanac=$dateTime->format('Y-m-d');
                            $bandera01=false;
                            if($fechanac != null){
                                $bandera01=true;
                                }
                                if($bandera01==false){
            
                                    $errorFila="Error en la Fila ".($key+6);
                                    $errorColumna="Error en la Columna FECHA DE INGRESO A LA UNIVERISAD";
                                    $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna AQ, Fila ".($key+6);
                                    $error=1;
                                    break 1;
            
                                }
                        }
                        else{
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE INGRESO A LA UNIVERISAD";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna AQ, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }

                    }
                    else{
                        if($row->c_fecha_ingreso != null && strlen($row->c_fecha_ingreso->format('Y-m-d')) != null){
                            $bandera01=true;
                        }
                        else{
                            $bandera01=false;
                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna FECHA DE INGRESO A LA UNIVERISAD";
                            $detError="EL dato ingresado se encuentran en blanco o no tiene un formato correcto. Corrija la Columna AQ, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_modalidad_ingreso

                    $bandera01=false;
                    if(strlen(trim($row->c_modalidad_ingreso))>0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna MODALIDAD DE INGRESO";
                        $detError="Debe de ingresar la descripción de la modalidad de Ingreso del Docente a la Universidad. Corrija la Columna AR, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }



                    // Validando c_hizo_intercambio

                    $bandera01=false;
                    if(intval($row->c_hizo_intercambio)==1 || intval($row->c_hizo_intercambio)==0){
                        $bandera01=true;
                        }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna ¿REALIZÓ INTERCAMBIO?";
                        $detError="El código de ¿Realizó Intercambio? solo debe de llevar valores de 0 ó vacío para NO ó 1 para SI. Corrija la Columna AS, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_univ_intercambio

                    if( intval($row->c_hizo_intercambio)==1){
                        $bandera01=false;
                        if(strlen(trim($row->c_univ_intercambio))>0){
                            $bandera01=true;
                            }
                        if($bandera01==false){

                            $errorFila="Error en la Fila ".($key+6);
                            $errorColumna="Error en la Columna UNIVERSIDAD DONDE REALIZÓ INTERCAMBIO";
                            $detError="Si ha ingresado que el Docente realizóIntercambio, ingrese el Nombre de la Universidad donde lo realizó, no puede dejar el registro en blanco. Corrija la Columna AT, Fila ".($key+6);
                            $error=1;
                            break 1;
                        }
                    }



                    // Validando c_pais

                    $bandera01=false;
                    if(strlen(trim($row->c_pais))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PAÍS DE PROCEDENCIA";
                        $detError="El País de Procedencia ingresado se encuentran en blanco. Corrija la Columna AU, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_depar

                    $bandera01=false;
                    if(strlen(trim($row->c_depar))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DEPARTAMENTO DE PROCEDENCIA";
                        $detError="El Departamento de Procedencia ingresado se encuentran en blanco. Corrija la Columna AV, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_prov

                    $bandera01=false;
                    if(strlen(trim($row->c_prov))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna PROVINCIA DE PROCEDENCIA";
                        $detError="La Provincia de Procedencia ingresado se encuentran en blanco. Corrija la Columna AW, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_dist

                    $bandera01=false;
                    if(strlen(trim($row->c_dist))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DISTRITO DE PROCEDENCIA";
                        $detError="El Distrito de Procedencia ingresado se encuentran en blanco. Corrija la Columna AX, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_mail_insti

                    $bandera01=false;
                    if(strlen(trim($row->c_mail_insti))>0 && is_valid_email(trim($row->c_mail_insti))){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CORREO ELECTRÓNICO INSTITUCIONAL";
                        $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna AY, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_direc   

                    $bandera01=false;
                    if(strlen(trim($row->c_direc))>0){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna DIRECCIÓN DEL DOCENTE";
                        $detError="El Valor ingresado se encuentran en blanco. Corrija la Columna AZ, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }


                    // Validando c_email 

                    $bandera01=false;
                    if(strlen(trim($row->c_email))>0 && is_valid_email(trim($row->c_email))){
                    $bandera01=true;
                    }
                    if($bandera01==false){

                        $errorFila="Error en la Fila ".($key+6);
                        $errorColumna="Error en la Columna CORREO ELECTRÓNICO PERSONAL";
                        $detError="El Valor ingresado se encuentran en blanco, o cuenta con un formato incorrecto. Corrija la Coumna BA, Fila ".($key+6);
                        $error=1;
                        break 1;
                    }

                    


                    }

                    if($error==1){
                    Storage::disk('infoFile')->delete($archivo);
                    $msj=$detError.' Por lo Que no se realizó la Importación de Datos.';
                    $result='0';
                    }
                    else{

                    $msj="Datos Importados Exitosamente";


                    
                    foreach ($resultado as $key => $row) {

                        $persona_id="0";
                        $idDocente="0";

                        $persona=Persona::where('doc',(trim($row->c_numdoc)))->where('tipodoc',intval($row->c_tipodoc))->get();

                        foreach ($persona as $key => $dato) {
                            $persona_id=$dato->id;
                        }
                        

                        $newGenero="M";
                        if(trim($row->c_genero)=="M" || trim($row->c_genero)=="m" )
                        {
                            $newGenero="M";
                        }elseif(trim($row->c_genero)=="F" || trim($row->c_genero)=="f")
                        {
                            $newGenero="F";
                        }

                        $discapacidad="";
                        if(intval($row->c_esdisca)==0)
                        {
                            $discapacidad="";
                        }else{
                            $discapacidad=trim($row->c_disca);
                        }

                        $fechanac= null;
                        if(strlen(trim($row->c_fechanac))==10){

                            $fechanac=pasFechaBD($row->c_fechanac);
                        }
                        else{
                            $fechanac=$row->c_fechanac->format('Y-m-d');
                        }


                        //Docente

                        $cargo = "0";
                        $dependencia = "";
                        $descCargo = "";
                        $tipoPersonal = "";
                        $maximoGrado = "";
                        $lugarMaximoGrado = "";
                        $paisMaximoGrado = "";
                        $tuvoOtroGrado = "No";
                        $otroGrado = "";
                        $UnivotroGrado = "";
                        $lugarOtroGrado = "";
                        $paisOtroGrado = "";
                        $tituloUniversitario= "";
                        $tuvoTitulo = "No";
                        $Titulo = "";
                        $clase = "";
                        $categoria = "";
                        $regimen = "";
                        $fechaIngreso = null;
                        $UniversidadIntercambio = "";
                        $idFacultad = 0;

                        

                        switch (intval($row->c_cargo)) {
                            case 0:
                                $cargo = "0";
                                break;
                            case 1:
                                $cargo = "Rector";
                                break;
                            case 2:
                                $cargo = "Vicerrector Académico";
                                break;
                            case 3:
                                $cargo = "Vicerrector de Investigación";
                                break;
                            case 4:
                                $cargo = "Vicerrector Administrativo";
                                break;
                            case 5:
                                $cargo = "Decano";
                                break;
                            case 6:
                                $cargo = "Director de Escuela";
                                break;
                            case 7:
                                $cargo = "Director de Oficina";
                                break;
                            case 8:
                                $cargo = "Jefe de Oficina";
                                break;
                            case 9:
                                $cargo = "Jefe de Departamento Académico";
                                break;
                            case 10:
                                $cargo = "Coordinador";
                                break;
                            case 11:
                                $cargo = "Asesor";
                                break;
                            case 12:
                                $cargo = "Asistente Administrativo";
                                break;
                            case 13:
                                $cargo = "Especialista";
                                break;
                            case 14:
                                $cargo = "Analista";
                                break;
                        }

                        if(intval($row->c_cargo)!=0){
                            $dependencia = trim($row->c_dependencia);
                            $descCargo = trim($row->c_desc_cargo);
                        }

                        if(intval($row->c_tipo_per)==1){
                            $tipoPersonal = "Docente";
                        }elseif(intval($row->c_tipo_per)==2){
                            $tipoPersonal = "Jefe de Práctica";
                        }

                        switch (intval($row->c_max_grado)) {
                            case 0:
                                $maximoGrado = "0";
                                break;
                            case 1:
                                $maximoGrado = "Primaria completa";
                                break;
                            case 2:
                                $maximoGrado = "Secundaria completa";
                                break;
                            case 3:
                                $maximoGrado = "Técnico";
                                break;
                            case 4:
                                $maximoGrado = "Bachiller";
                                break;
                            case 5:
                                $maximoGrado = "Maestro";
                                break;
                            case 6:
                                $maximoGrado = "Doctor";
                        }

                        if(intval($row->c_lugar_max_grado)==1){
                            $lugarMaximoGrado = "Nacional";
                            $paisMaximoGrado = "PERÚ";
                        }elseif(intval($row->c_lugar_max_grado)==2){
                            $lugarMaximoGrado = "Internacional";
                            $paisMaximoGrado = trim($row->c_pais_max_grado);
                        }

                        if( intval($row->c_tiene_otrogrado)==1){
                            $tuvoOtroGrado = "Si";
                            $otroGrado = trim($row->c_otrogrado);
                            $UnivotroGrado = trim($row->c_univ_otrogrado);

                            if(intval($row->c_lugar_otrogrado)==1){
                                $lugarOtroGrado = "Nacional";
                                $paisOtroGrado = "PERÚ";
                            }elseif(intval($row->c_lugar_otrogrado)==2){
                                $lugarOtroGrado = "Internacional";
                                $paisOtroGrado = trim($row->c_pais_otrogrado);
                            }
                        }


                        if( intval($row->c_tiene_titulo)==1){
                            $tuvoTitulo = "Si";
                            $Titulo = trim($row->c_titulo);
                        }


                        switch (intval($row->c_clase)) {
                            case 0:
                                $clase = "Ninguno";
                                break;
                            case 1:
                                $clase = "Nombrado";
                                break;
                            case 2:
                                $clase = "Ordinario";
                                break;
                            case 3:
                                $clase = "Contratado a plazo determinado";
                                break;
                            case 4:
                                $clase = "Contratado a plazo determinado –a";
                                break;
                            case 5:
                                $clase = "Contratado a plazo determinado –b";
                                break;
                            case 6:
                                $clase = "Contratado a plazo indeterminado";
                                break;
                            case 7:
                                $clase = "CAS";
                                break;
                            case 8:
                                $clase = "Locación de servicios";
                                break;
                            case 9:
                                $clase = "Extraordinario";
                                break;
                        }

                        switch (intval($row->c_categoria)) {
                            case 1:
                                $categoria = "Auxiliar";
                                break;
                            case 2:
                                $categoria = "Asociado";
                                break;
                            case 3:
                                $categoria = "Principal";
                                break;
                        }

                        switch (intval($row->c_regimen)) {
                            case 1:
                                $regimen = "Tiempo completo";
                                break;
                            case 2:
                                $regimen = "Tiempo parcial";
                                break;
                            case 3:
                                $regimen = "Dedicación exclusiva";
                                break;
                        }


                        if(strlen(trim($row->c_fecha_ingreso))==10){

                            $fechaIngreso=pasFechaBD($row->c_fecha_ingreso);
                        }
                        else{
                            $fechaIngreso=$row->c_fecha_ingreso->format('Y-m-d');
                        }


                        if( intval($row->c_hizo_intercambio)==1){
                            $UniversidadIntercambio = trim($row->c_univ_intercambio);
                        }


                        foreach ($departamentos as $key4 => $dato) {
                            if(intval($row->c_depar_academico)==$dato->id)
                            {
                                $idFacultad = $dato->facultad_id;
                                break;
                            }
                        }

                        
                        


                        if(intval($persona_id)!=0)
                        {
                            $editPersona =Persona::find($persona_id);

                            $editPersona->tipodoc = intval($row->c_tipodoc);
                            $editPersona->doc = trim($row->c_numdoc);
                            $editPersona->nombres = trim($row->c_noms);
                            $editPersona->apellidopat = trim($row->c_apepat);
                            $editPersona->apellidomat = trim($row->c_apemat);
                            $editPersona->genero = $newGenero;
                            $editPersona->estadocivil = intval($row->c_estadociv);
                            $editPersona->fechanac = $fechanac;
                            $editPersona->esdiscapacitado = intval($row->c_esdisca);
                            $editPersona->discapacidad = $discapacidad;
                            $editPersona->pais = trim($row->c_pais);
                            $editPersona->departamento = trim($row->c_depar);
                            $editPersona->provincia = trim($row->c_prov);
                            $editPersona->distrito = trim($row->c_dist);
                            $editPersona->direccion = trim($row->c_direc);
                            $editPersona->email = trim($row->c_email);
                            $editPersona->telefono = trim($row->c_telf);
                            $editPersona->correoinstitucional = trim($row->c_mail_insti);
                            $editPersona->identidadetnica = trim($row->c_identidad);
                
                            $editPersona->save();
                        }
                        else{
                            $newPersona = new Persona();
                            $newPersona->tipodoc = intval($row->c_tipodoc);
                            $newPersona->doc = trim($row->c_numdoc);
                            $newPersona->nombres = trim($row->c_noms);
                            $newPersona->apellidopat = trim($row->c_apepat);
                            $newPersona->apellidomat = trim($row->c_apemat);
                            $newPersona->genero = $newGenero;
                            $newPersona->estadocivil = intval($row->c_estadociv);
                            $newPersona->fechanac = $fechanac;
                            $newPersona->esdiscapacitado = intval($row->c_esdisca);
                            $newPersona->discapacidad = $discapacidad;
                            $newPersona->pais = trim($row->c_pais);
                            $newPersona->departamento = trim($row->c_depar);
                            $newPersona->provincia = trim($row->c_prov);
                            $newPersona->distrito = trim($row->c_dist);
                            $newPersona->direccion = trim($row->c_direc);
                            $newPersona->email = trim($row->c_email);
                            $newPersona->telefono = trim($row->c_telf);
                            $newPersona->correoinstitucional = trim($row->c_mail_insti);
                            $newPersona->identidadetnica = trim($row->c_identidad);
                            $newPersona->activo = '1';
                            $newPersona->borrado = '0';
                
                            $newPersona->save();
                
                            $persona_id=$newPersona->id;
                        }

                        $docentes=Docente::where('persona_id',$persona_id)->where('semestre_id',intval($row->c_sem))->get();
                        $idDocente=0;

                        

                        

                        foreach ($docentes as $key => $dato) {
                            $idDocente=$dato->id;
                        }
                
                        if(intval($idDocente)==0)
                        {

                            $newDocente = new Docente();

                            $newDocente->personalacademico=$tipoPersonal;
                            $newDocente->cargogeneral=$cargo;
                            $newDocente->descripcioncargo=$descCargo;
                            $newDocente->maximogrado=$maximoGrado;
                            $newDocente->descmaximogrado=trim($row->c_desc_max_grado);
                            $newDocente->universidadgrado=trim($row->c_univ_max_grado);
                            $newDocente->lugarmaximogrado=$lugarMaximoGrado;
                            $newDocente->paismaximogrado=$paisMaximoGrado;
                            $newDocente->otrogrado=$otroGrado;
                            $newDocente->estadootrogrado=$tuvoOtroGrado;
                            $newDocente->univotrogrado=$UnivotroGrado;
                            $newDocente->lugarotrogrado=$lugarOtroGrado;
                            $newDocente->paisotrogrado=$paisOtroGrado;
                            $newDocente->titulo=$tuvoTitulo;
                            $newDocente->descripciontitulo=$Titulo;
                            $newDocente->condicion=$clase;
                            $newDocente->categoria=$categoria;
                            $newDocente->regimen=$regimen;
                            $newDocente->investigador=intval($row->c_es_investigador);
                            $newDocente->pregrado=intval($row->c_es_pregrado);
                            $newDocente->postgrado=intval($row->c_es_postgrado);
                            $newDocente->esdestacado=intval($row->c_es_destacado);
                            $newDocente->fechaingreso=$fechaIngreso;
                            $newDocente->modalidadingreso=trim($row->c_modalidad_ingreso);
                            $newDocente->observaciones=trim($row->c_obs);
                            $newDocente->persona_id=$persona_id;
                            $newDocente->horaslectivas=intval($row->c_horas_lectivas);
                            $newDocente->horasnolectivas=intval($row->c_horas_no_lectivas);
                            $newDocente->horasinvestigacion=intval($row->c_horas_investigacion);
                            $newDocente->horasdedicacion=intval($row->c_horas_dedicacion);
                            $newDocente->dependencia=$dependencia;
                            $newDocente->departamentoacademico_id=intval($row->c_depar_academico);
                            $newDocente->facultad_id=$idFacultad;
                            $newDocente->semestre_id=intval($row->c_sem);
                            $newDocente->email=trim($row->c_email);
                            $newDocente->hizointercambio=intval($row->c_hizo_intercambio);
                            $newDocente->universidadintercambio=$UniversidadIntercambio;
                            $newDocente->eslicencia=intval($row->c_licencia);
                            $newDocente->activo='1';
                            $newDocente->borrado='0';

                            $newDocente->save();
    
                        } 
                        else
                        {

                            $editDocente = Docente::find($idDocente);

                            $editDocente->personalacademico=$tipoPersonal;
                            $editDocente->cargogeneral=$cargo;
                            $editDocente->descripcioncargo=$descCargo;
                            $editDocente->maximogrado=$maximoGrado;
                            $editDocente->descmaximogrado=trim($row->c_desc_max_grado);
                            $editDocente->universidadgrado=trim($row->c_univ_max_grado);
                            $editDocente->lugarmaximogrado=$lugarMaximoGrado;
                            $editDocente->paismaximogrado=$paisMaximoGrado;
                            $editDocente->otrogrado=$otroGrado;
                            $editDocente->estadootrogrado=$tuvoOtroGrado;
                            $editDocente->univotrogrado=$UnivotroGrado;
                            $editDocente->lugarotrogrado=$lugarOtroGrado;
                            $editDocente->paisotrogrado=$paisOtroGrado;
                            $editDocente->titulo=$tuvoTitulo;
                            $editDocente->descripciontitulo=$Titulo;
                            $editDocente->condicion=$clase;
                            $editDocente->categoria=$categoria;
                            $editDocente->regimen=$regimen;
                            $editDocente->investigador=intval($row->c_es_investigador);
                            $editDocente->pregrado=intval($row->c_es_pregrado);
                            $editDocente->postgrado=intval($row->c_es_postgrado);
                            $editDocente->esdestacado=intval($row->c_es_destacado);
                            $editDocente->fechaingreso=$fechaIngreso;
                            $editDocente->modalidadingreso=trim($row->c_modalidad_ingreso);
                            $editDocente->observaciones=trim($row->c_obs);
                            $editDocente->persona_id=$persona_id;
                            $editDocente->horaslectivas=intval($row->c_horas_lectivas);
                            $editDocente->horasnolectivas=intval($row->c_horas_no_lectivas);
                            $editDocente->horasinvestigacion=intval($row->c_horas_investigacion);
                            $editDocente->horasdedicacion=intval($row->c_horas_dedicacion);
                            $editDocente->dependencia=$dependencia;
                            $editDocente->departamentoacademico_id=intval($row->c_depar_academico);
                            $editDocente->facultad_id=$idFacultad;
                            $editDocente->semestre_id=intval($row->c_sem);
                            $editDocente->email=trim($row->c_email);
                            $editDocente->hizointercambio=intval($row->c_hizo_intercambio);
                            $editDocente->universidadintercambio=$UniversidadIntercambio;
                            $editDocente->eslicencia=intval($row->c_licencia);

                            $editDocente->save();


                        }               
  
                    }

                }
                   

            })->get(); 
        
    }

        $errtitulo = $errorColumna.' '.$errorFila;
        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector, 'errtitulo'=>$errtitulo]);
   
    }

}
