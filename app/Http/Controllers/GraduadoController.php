<?php

namespace App\Http\Controllers;

use App\Graduado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

use Excel;
set_time_limit(600);

class GraduadoController extends Controller
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


            $modulo="bachilleres";

            return view('bachilleres.index',compact('tipouser','modulo','escuelas'));
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


            $modulo="titulados";

            return view('titulados.index',compact('tipouser','modulo','escuelas'));
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

            $modulo="maestros";

            return view('maestros.index',compact('tipouser','modulo'));
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

            $modulo="doctores";

            return view('doctores.index',compact('tipouser','modulo'));
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

     $graduados ="";

     if($tipo==1 || $tipo==2)
     {    
     $graduados = DB::table('graduados')
     ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     ->join('escuelas', 'escuelas.id', '=', 'graduados.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')

     ->where('graduados.borrado','0')
     ->where('graduados.tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
     'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','graduados.trabajoinvestigacion')
     ->paginate(50);

    }

    elseif($tipo==3 || $tipo==4)
     {    
        $graduados = DB::table('graduados')
        ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     
        ->where('graduados.borrado','0')
        ->where('graduados.tipo',$tipo)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
        'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','graduados.trabajoinvestigacion')
        ->paginate(50);

    }


     return [
        'pagination'=>[
            'total'=> $graduados->total(),
            'current_page'=> $graduados->currentPage(),
            'per_page'=> $graduados->perPage(),
            'last_page'=> $graduados->lastPage(),
            'from'=> $graduados->firstItem(),
            'to'=> $graduados->lastItem(),
        ],
        'graduados'=>$graduados
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

        $escuela_id=$request->escuela_id;
        $nombreGrado=$request->nombreGrado;
        $programaEstudios=$request->programaEstudios;
        $fechaEgreso=$request->fechaEgreso;
        $idioma=$request->idioma;
        $modalidadObtencion=$request->modalidadObtencion;
        $numResolucion=$request->numResolucion;
        $fechaResol=$request->fechaResol;
        $numeroDiploma=$request->numeroDiploma;
        $autoridadRector=$request->autoridadRector;
        $fechaEmision=$request->fechaEmision;
        $observaciones=$request->observaciones;
        $persona_id=$request->persona_id;
        $tipo=$request->tipo;
        $trabajoinvestigacion=$request->trabajoinvestigacion;  



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

  

        $input16  = array('escuela_id' => $escuela_id);
        $reglas16 = array('escuela_id' => 'required');

        $input17  = array('nombreGrado' => $nombreGrado);
        $reglas17 = array('nombreGrado' => 'required');

        $input18  = array('programaEstudios' => $programaEstudios);
        $reglas18 = array('programaEstudios' => 'required');

        $input19  = array('fechaEgreso' => $fechaEgreso);
        $reglas19 = array('fechaEgreso' => 'required');

        $input20  = array('idioma' => $idioma);
        $reglas20 = array('idioma' => 'required');


        $input21  = array('modalidadObtencion' => $modalidadObtencion);
        $reglas21 = array('modalidadObtencion' => 'required');

        $input22  = array('numResolucion' => $numResolucion);
        $reglas22 = array('numResolucion' => 'required');

        $input23  = array('fechaResol' => $fechaResol);
        $reglas23 = array('fechaResol' => 'required');

        $input24  = array('numeroDiploma' => $numeroDiploma);
        $reglas24 = array('numeroDiploma' => 'required');

        $input25  = array('autoridadRector' => $autoridadRector);
        $reglas25 = array('autoridadRector' => 'required');

        $input26  = array('fechaEmision' => $fechaEmision);
        $reglas26 = array('fechaEmision' => 'required');

        $input27  = array('trabajoinvestigacion' => $trabajoinvestigacion);
        $reglas27 = array('trabajoinvestigacion' => 'required');


     



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

        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);
        $validator25 = Validator::make($input25, $reglas25);
        $validator26 = Validator::make($input26, $reglas26);
        $validator27 = Validator::make($input27, $reglas27);



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
            $msj='Seleccione si la persona es Discapacitada';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que es discapacitado, ingrese la discapacidad que padece';
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



        elseif ($validator16->fails() && ((intval($tipo)!=3) && (intval($tipo)!=4))) {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='cbucarrera';
        }

        elseif ($validator17->fails()) {
            $result='0';
            $msj='Registre el nombre del grado';
            $selector='txtgrado';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Registre el nombre del Programa de Estudios';
            $selector='txtprogramaestudios';
        }

        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingresela fecha de egreso';
            $selector='txtfechaegreso';
        }

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Seleccione el Idioma con que tramitó su grado';
            $selector='cbuidioma';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la Modalidad de  Obtención del grado';
            $selector='txtmodalidadObtencion';
        }

        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el Número de Resolución del grado';
            $selector='txtnumresol';
        }

        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Resolución del grado';
            $selector='txtfecharesol';
        }

        elseif ($validator24->fails()) {
            $result='0';
            $msj='Ingrese el número de diploma';
            $selector='txtnumdiploma';
        }

        elseif ($validator25->fails()) {
            $result='0';
            $msj='Ingrese la Autoridad - Rector que firmó el grado';
            $selector='txtautoridad';
        }


        elseif ($validator26->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Emisión del grado';
            $selector='txtfechaemision';
        }

        elseif ($validator27->fails() && ((intval($tipo)!=1) && (intval($tipo)!=2)))
        {
            $result='0';
            $msj='Ingrese el Trabajo de Investigación para la obtención del grado';
            $selector='txttrabajoinvestigacion';
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

        if($tipo==1 || $tipo==2)
        {
        $newGraduado = new Graduado();
        $newGraduado->escuela_id=$escuela_id;
        $newGraduado->nombreGrado=$nombreGrado;
        $newGraduado->programaEstudios=$programaEstudios;
        $newGraduado->fechaEgreso=$fechaEgreso;
        $newGraduado->idioma=$idioma;
        $newGraduado->modalidadObtencion=$modalidadObtencion;
        $newGraduado->numResolucion=$numResolucion;
        $newGraduado->fechaResol=$fechaResol;
        $newGraduado->numeroDiploma=$numeroDiploma;
        $newGraduado->autoridadRector=$autoridadRector;
        $newGraduado->fechaEmision=$fechaEmision;
        $newGraduado->observaciones=$observaciones;
        $newGraduado->persona_id=$persona_id;
        $newGraduado->tipo=$tipo;
        $newGraduado->trabajoinvestigacion=$trabajoinvestigacion;
        $newGraduado->activo='1';
        $newGraduado->borrado='0';

        $newGraduado->save();

        }

        if($tipo==3 || $tipo==4)
        {
            $newGraduado = new Graduado();

        $newGraduado->nombreGrado=$nombreGrado;
        $newGraduado->programaEstudios=$programaEstudios;
        $newGraduado->fechaEgreso=$fechaEgreso;
        $newGraduado->idioma=$idioma;
        $newGraduado->modalidadObtencion=$modalidadObtencion;
        $newGraduado->numResolucion=$numResolucion;
        $newGraduado->fechaResol=$fechaResol;
        $newGraduado->numeroDiploma=$numeroDiploma;
        $newGraduado->autoridadRector=$autoridadRector;
        $newGraduado->fechaEmision=$fechaEmision;
        $newGraduado->observaciones=$observaciones;
        $newGraduado->persona_id=$persona_id;
        $newGraduado->tipo=$tipo;
        $newGraduado->trabajoinvestigacion=$trabajoinvestigacion;
        $newGraduado->activo='1';
        $newGraduado->borrado='0';
    
            $newGraduado->save();

        }
        

           

            $msj='Registro guardado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Graduado  $graduado
     * @return \Illuminate\Http\Response
     */
    public function show(Graduado $graduado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Graduado  $graduado
     * @return \Illuminate\Http\Response
     */
    public function edit(Graduado $graduado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Graduado  $graduado
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

        $escuela_id=$request->escuela_id;
        $nombreGrado=$request->nombreGrado;
        $programaEstudios=$request->programaEstudios;
        $fechaEgreso=$request->fechaEgreso;
        $idioma=$request->idioma;
        $modalidadObtencion=$request->modalidadObtencion;
        $numResolucion=$request->numResolucion;
        $fechaResol=$request->fechaResol;
        $numeroDiploma=$request->numeroDiploma;
        $autoridadRector=$request->autoridadRector;
        $fechaEmision=$request->fechaEmision;
        $observaciones=$request->observaciones;
        $persona_id=$request->persona_id;
        $tipo=$request->tipo;
        $trabajoinvestigacion=$request->trabajoinvestigacion;  



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

  

        $input16  = array('escuela_id' => $escuela_id);
        $reglas16 = array('escuela_id' => 'required');

        $input17  = array('nombreGrado' => $nombreGrado);
        $reglas17 = array('nombreGrado' => 'required');

        $input18  = array('programaEstudios' => $programaEstudios);
        $reglas18 = array('programaEstudios' => 'required');

        $input19  = array('fechaEgreso' => $fechaEgreso);
        $reglas19 = array('fechaEgreso' => 'required');

        $input20  = array('idioma' => $idioma);
        $reglas20 = array('idioma' => 'required');


        $input21  = array('modalidadObtencion' => $modalidadObtencion);
        $reglas21 = array('modalidadObtencion' => 'required');

        $input22  = array('numResolucion' => $numResolucion);
        $reglas22 = array('numResolucion' => 'required');

        $input23  = array('fechaResol' => $fechaResol);
        $reglas23 = array('fechaResol' => 'required');

        $input24  = array('numeroDiploma' => $numeroDiploma);
        $reglas24 = array('numeroDiploma' => 'required');

        $input25  = array('autoridadRector' => $autoridadRector);
        $reglas25 = array('autoridadRector' => 'required');

        $input26  = array('fechaEmision' => $fechaEmision);
        $reglas26 = array('fechaEmision' => 'required');

        $input27  = array('trabajoinvestigacion' => $trabajoinvestigacion);
        $reglas27 = array('trabajoinvestigacion' => 'required');


     



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

        $validator16 = Validator::make($input16, $reglas16);
        $validator17 = Validator::make($input17, $reglas17);
        $validator18 = Validator::make($input18, $reglas18);
        $validator19 = Validator::make($input19, $reglas19);
        $validator20 = Validator::make($input20, $reglas20);
        $validator21 = Validator::make($input21, $reglas21);
        $validator22 = Validator::make($input22, $reglas22);
        $validator23 = Validator::make($input23, $reglas23);
        $validator24 = Validator::make($input24, $reglas24);
        $validator25 = Validator::make($input25, $reglas25);
        $validator26 = Validator::make($input26, $reglas26);
        $validator27 = Validator::make($input27, $reglas27);



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
            $msj='Seleccione si la persona es Discapacitada';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que es discapacitado, ingrese la discapacidad que padece';
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



        elseif ($validator16->fails() && ((intval($tipo)!=3) && (intval($tipo)!=4))) {
            $result='0';
            $msj='Seleccione la Escuela Profesional';
            $selector='cbucarreraE';
        }

        elseif ($validator17->fails()) {
            $result='0';
            $msj='Registre el nombre del grado';
            $selector='txtgradoE';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Registre el nombre del Programa de Estudios';
            $selector='txtprogramaestudiosE';
        }

        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingresela fecha de egreso';
            $selector='txtfechaegresoE';
        }

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Seleccione el Idioma con que tramitó su grado';
            $selector='cbuidiomaE';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la Modalidad de  Obtención del grado';
            $selector='txtmodalidadObtencionE';
        }

        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el Número de Resolución del grado';
            $selector='txtnumresolE';
        }

        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Resolución del grado';
            $selector='txtfecharesolE';
        }

        elseif ($validator24->fails()) {
            $result='0';
            $msj='Ingrese el número de diploma';
            $selector='txtnumdiplomaE';
        }

        elseif ($validator25->fails()) {
            $result='0';
            $msj='Ingrese la Autoridad - Rector que firmó el grado';
            $selector='txtautoridadE';
        }


        elseif ($validator26->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Emisión del grado';
            $selector='txtfechaemisionE';
        }


        elseif ($validator27->fails() && ((intval($tipo)!=1) && (intval($tipo)!=2))) {
            $result='0';
            $msj='Ingrese el Trabajo de Investigación para la obtención del grado';
            $selector='txttrabajoinvestigacionE';
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
     

        if($tipo==1 || $tipo==2)
        {
        $newGraduado = Graduado::find($id);
        $newGraduado->escuela_id=$escuela_id;
        $newGraduado->nombreGrado=$nombreGrado;
        $newGraduado->programaEstudios=$programaEstudios;
        $newGraduado->fechaEgreso=$fechaEgreso;
        $newGraduado->idioma=$idioma;
        $newGraduado->modalidadObtencion=$modalidadObtencion;
        $newGraduado->numResolucion=$numResolucion;
        $newGraduado->fechaResol=$fechaResol;
        $newGraduado->numeroDiploma=$numeroDiploma;
        $newGraduado->autoridadRector=$autoridadRector;
        $newGraduado->fechaEmision=$fechaEmision;
        $newGraduado->observaciones=$observaciones;
        $newGraduado->persona_id=$persona_id;
        $newGraduado->trabajoinvestigacion=$trabajoinvestigacion;


        $newGraduado->save();

        }

        if($tipo==3 || $tipo==4)
        {
            
            $newGraduado = Graduado::find($id);
            $newGraduado->nombreGrado=$nombreGrado;
            $newGraduado->programaEstudios=$programaEstudios;
            $newGraduado->fechaEgreso=$fechaEgreso;
            $newGraduado->idioma=$idioma;
            $newGraduado->modalidadObtencion=$modalidadObtencion;
            $newGraduado->numResolucion=$numResolucion;
            $newGraduado->fechaResol=$fechaResol;
            $newGraduado->numeroDiploma=$numeroDiploma;
            $newGraduado->autoridadRector=$autoridadRector;
            $newGraduado->fechaEmision=$fechaEmision;
            $newGraduado->observaciones=$observaciones;
            $newGraduado->persona_id=$persona_id;
            $newGraduado->trabajoinvestigacion=$trabajoinvestigacion;


            $newGraduado->save();

        }
        

           

            $msj='Registro modificado con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Graduado  $graduado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';

   
        
        $borrar = Graduado::destroy($id);
        //$task->delete();


        $msj='Registro Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }





    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;


        Excel::create('Bachilleres UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('Base de Datos de Bachilleres', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:X3');
                $sheet->cells('A3:X3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:X3', 'thin');
                $sheet->cells('A3:X3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:X4', function($cells)
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
                'F'=>'30',
                'G'=>'20',
                'H'=>'20',
                'I'=>'20',
                'J'=>'20',
                'K'=>'35',
                'L'=>'45',
                'M'=>'45',
                'N'=>'45',
                'O'=>'45',
                'P'=>'20',
                'Q'=>'20',
                'R'=>'35',
                'S'=>'35',
                'T'=>'22',
                'U'=>'30',
                'V'=>'35',
                'W'=>'25',
                'X'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS BACHILLERES UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:X4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','FACULTAD','ESCUELA PROFESIONAL','DENOMINACIÓN DEL GRADO','PROGRAMA DE ESTUDIOS','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $graduados = DB::table('graduados')
     ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     ->join('escuelas', 'escuelas.id', '=', 'graduados.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')

     ->where('graduados.borrado','0')
     ->where('graduados.tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
     'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','graduados.trabajoinvestigacion')
     ->get();

        foreach ($graduados as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':X'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','FACULTAD','ESCUELA PROFESIONAL','DENOMINACIÓN DEL GRADO','PROGRAMA DE ESTUDIOS','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));
                */

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
           $dato->facultad,
           $dato->escuela,
           $dato->nombreGrado,
           $dato->programaEstudios,
           pasFechaVista($dato->fechaEgreso),
           $dato->idioma,
           $dato->modalidadObtencion,
           $dato->numResolucion,
           pasFechaVista($dato->fechaResol),
           $dato->numeroDiploma,
           $dato->autoridadRector,
           pasFechaVista($dato->fechaEmision),
           $dato->observaciones
        
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


        Excel::create('Titulados UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('Base de Datos de Titulados', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:X3');
                $sheet->cells('A3:X3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:X3', 'thin');
                $sheet->cells('A3:X3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:X4', function($cells)
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
                'F'=>'30',
                'G'=>'20',
                'H'=>'20',
                'I'=>'20',
                'J'=>'20',
                'K'=>'35',
                'L'=>'45',
                'M'=>'45',
                'N'=>'45',
                'O'=>'45',
                'P'=>'20',
                'Q'=>'20',
                'R'=>'35',
                'S'=>'35',
                'T'=>'22',
                'U'=>'30',
                'V'=>'35',
                'W'=>'25',
                'X'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS TITULADOS UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:X4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','FACULTAD','ESCUELA PROFESIONAL','DENOMINACIÓN DEL GRADO','PROGRAMA DE ESTUDIOS','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $graduados = DB::table('graduados')
     ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     ->join('escuelas', 'escuelas.id', '=', 'graduados.escuela_id')
     ->join('facultads', 'facultads.id', '=', 'escuelas.facultad_id')

     ->where('graduados.borrado','0')
     ->where('graduados.tipo',$tipo)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })
     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
     'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','escuelas.id as idescuela','escuelas.nombre as escuela','facultads.id as idfacultad','facultads.nombre as facultad','graduados.trabajoinvestigacion')
     ->get();

        foreach ($graduados as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':X'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','FACULTAD','ESCUELA PROFESIONAL','DENOMINACIÓN DEL GRADO','PROGRAMA DE ESTUDIOS','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));
                */

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
           $dato->facultad,
           $dato->escuela,
           $dato->nombreGrado,
           $dato->programaEstudios,
           pasFechaVista($dato->fechaEgreso),
           $dato->idioma,
           $dato->modalidadObtencion,
           $dato->numResolucion,
           pasFechaVista($dato->fechaResol),
           $dato->numeroDiploma,
           $dato->autoridadRector,
           pasFechaVista($dato->fechaEmision),
           $dato->observaciones
        
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


        Excel::create('Maestros UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('Base de Datos de Maestros', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:W3');
                $sheet->cells('A3:W3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:W3', 'thin');
                $sheet->cells('A3:W3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:W4', function($cells)
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
                'F'=>'30',
                'G'=>'20',
                'H'=>'20',
                'I'=>'20',
                'J'=>'20',
                'K'=>'35',
                'L'=>'45',
                'M'=>'45',
                'N'=>'45',
                'O'=>'25',
                'P'=>'40',
                'Q'=>'45',
                'R'=>'35',
                'S'=>'35',
                'T'=>'22',
                'U'=>'40',
                'V'=>'25',
                'W'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS MAESTROS UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:W4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','GRADO','DENOMINACIÓN DEL GRADO','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NOMBRE DEL TRABAJO DE INVESTIGACIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $graduados = DB::table('graduados')
        ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     
        ->where('graduados.borrado','0')
        ->where('graduados.tipo',$tipo)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
        'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','graduados.trabajoinvestigacion')
        ->get();

        foreach ($graduados as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':W'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');

/*
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','GRADO','DENOMINACIÓN DEL GRADO','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NOMBRE DEL TRABAJO DE INVESTIGACIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));
                */

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
           $dato->nombreGrado,
           $dato->programaEstudios,
           pasFechaVista($dato->fechaEgreso),
           $dato->idioma,
           $dato->modalidadObtencion,
           $dato->trabajoinvestigacion,
           $dato->numResolucion,
           pasFechaVista($dato->fechaResol),
           $dato->numeroDiploma,
           $dato->autoridadRector,
           pasFechaVista($dato->fechaEmision),
           $dato->observaciones
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }

    public function descargarExcel4(Request $request)
    {   
        $buscar=$request->busca;
        $tipo=$request->tipo;


        Excel::create('Doctores UNASAM', function($excel) use($buscar,$tipo)  {
            $excel->sheet('Base de Datos de Doctores', function($sheet) use($buscar,$tipo){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:W3');
                $sheet->cells('A3:W3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:W3', 'thin');
                $sheet->cells('A3:W3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:W4', function($cells)
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
                'F'=>'30',
                'G'=>'20',
                'H'=>'20',
                'I'=>'20',
                'J'=>'20',
                'K'=>'35',
                'L'=>'45',
                'M'=>'45',
                'N'=>'45',
                'O'=>'25',
                'P'=>'40',
                'Q'=>'45',
                'R'=>'35',
                'S'=>'35',
                'T'=>'22',
                'U'=>'40',
                'V'=>'25',
                'W'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS DOCTORES UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:W4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','DENOMINACIÓN DEL GRADO','PROGRAMA DE ESTUDIOS','FECHA DE EGRESO','IDIOMA','MODALIDAD DE OBTENCIÓN','NOMBRE DEL TRABAJO DE INVESTIGACIÓN','NÚMERO DE RESOLUCIÓN','FECHA DE RESOLUCIÓN','NÚMERO DE DIPLOMA','AUTORIDAD - RECTOR','FECHA DE EMISIÓN','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $graduados = DB::table('graduados')
        ->join('personas', 'personas.id', '=', 'graduados.persona_id')
     
        ->where('graduados.borrado','0')
        ->where('graduados.tipo',$tipo)
        ->where(function($query) use ($buscar){
           $query->where('personas.nombres','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
           $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
           $query->orWhere('personas.doc','like','%'.$buscar.'%');
           })
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
   
        ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','graduados.id',
        'graduados.escuela_id','graduados.nombreGrado','graduados.programaEstudios','graduados.fechaEgreso','graduados.idioma','graduados.modalidadObtencion','graduados.numResolucion','graduados.fechaResol','graduados.numeroDiploma','graduados.autoridadRector','graduados.fechaEmision','graduados.observaciones','graduados.persona_id','graduados.tipo','graduados.trabajoinvestigacion')
        ->get();

        foreach ($graduados as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':W'.strval((intval($cont)+intval($key)));
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
           $dato->nombreGrado,
           $dato->programaEstudios,
           pasFechaVista($dato->fechaEgreso),
           $dato->idioma,
           $dato->modalidadObtencion,
           $dato->trabajoinvestigacion,
           $dato->numResolucion,
           pasFechaVista($dato->fechaResol),
           $dato->numeroDiploma,
           $dato->autoridadRector,
           pasFechaVista($dato->fechaEmision),
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
