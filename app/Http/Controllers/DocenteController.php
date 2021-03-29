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


            $modulo="docentes";
            return view('docentes.index',compact('tipouser','modulo','departamentoacademicos','semestres','facultads','semestresel','contse','semestreNombre'));
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

        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese la descripción del Máximo Grado Obtenido';
            $selector='txtdescGrado';
        }
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
           $dato->cargogeneral,
           $dato->descripcioncargo,
           $dato->maximogrado,
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
}
