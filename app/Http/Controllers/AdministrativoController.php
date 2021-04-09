<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Administrativo;
use App\Escuela;
use App\Facultad;
use App\Local;

use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use Excel;
set_time_limit(600);

class AdministrativoController extends Controller
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

            $facultads=Facultad::where('activo','1')->where('borrado','0')->orderBy('nombre')->get();
            $locals=Local::where('activo','1')->where('borrado','0')->orderBy('nombre')->get();


            $modulo="administrativos";
            return view('administrativos.index',compact('tipouser','modulo','escuelas','facultads','locals'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
     
     $administrativos = DB::table('administrativos')
     ->join('personas', 'personas.id', '=', 'administrativos.persona_id')
     ->join('locals', 'locals.id', '=', 'administrativos.local_id')

     ->where('administrativos.borrado','0')
     ->where('administrativos.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','administrativos.id', 'personas.correoinstitucional',
     
     'administrativos.persona_id','administrativos.local_id','administrativos.tipoDependencia','administrativos.dependencia','administrativos.facultad','administrativos.escuela','administrativos.cargo','administrativos.descripcionCargo','administrativos.grado','administrativos.descripcionGrado','administrativos.esTitulado','administrativos.descripcionTitulo','administrativos.lugarGrado','administrativos.paisGrado','administrativos.fechaIngreso','administrativos.observaciones','administrativos.estado','administrativos.condicion','administrativos.fechaSalida','administrativos.id','locals.id as idlocal','locals.nombre as local')
     ->paginate(50);

     return [
        'pagination'=>[
            'total'=> $administrativos->total(),
            'current_page'=> $administrativos->currentPage(),
            'per_page'=> $administrativos->perPage(),
            'last_page'=> $administrativos->lastPage(),
            'from'=> $administrativos->firstItem(),
            'to'=> $administrativos->lastItem(),
        ],
        'administrativos'=>$administrativos
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
        $correoinstitucional=$request->correoinstitucional;

        $persona_id=$request->persona_id;
        $local_id=$request->local_id;
        $tipoDependencia=$request->tipoDependencia;
        $dependencia=$request->dependencia;
        $facultad=$request->facultad;
        $escuela=$request->escuela;
        $cargo=$request->cargo;
        $descripcionCargo=$request->descripcionCargo;
        $grado=$request->grado;
        $descripcionGrado=$request->descripcionGrado;
        $esTitulado=$request->esTitulado;
        $descripcionTitulo=$request->descripcionTitulo;
        $lugarGrado=$request->lugarGrado;
        $paisGrado=$request->paisGrado;
        $fechaIngreso=$request->fechaIngreso;
        $observaciones=$request->observaciones;
        $estado=$request->estado;
        $condicion=$request->condicion;
        $fechaSalida=$request->fechaSalida;
     


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($tipoDependencia)==9)
        {
            $dependencia=$facultad;
        } 
        elseif(intval($tipoDependencia)==10)
        {
            $dependencia=$escuela;
        }

        if($grado=="0")
        {
            $descripcionGrado="";
            $esTitulado="0";
            $descripcionTitulo="";
            $lugarGrado="";
            $paisGrado="";
        }
        elseif($lugarGrado=="Nacional")
        {
            $paisGrado="PERÚ";
        }

        if(intval($esTitulado)==0)
        {
            $descripcionTitulo="";
        }

        if(intval($estado)==1)
        {
            $fechaSalida=null;
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



        $input15  = array('local_id' => $local_id);
        $reglas15 = array('local_id' => 'required');

        $input16  = array('tipoDependencia' => $tipoDependencia);
        $reglas16 = array('tipoDependencia' => 'required');

        $input17  = array('dependencia' => $dependencia);
        $reglas17 = array('dependencia' => 'required');

        $input18  = array('descripcionCargo' => $descripcionCargo);
        $reglas18 = array('descripcionCargo' => 'required');

        $input19  = array('fechaIngreso' => $fechaIngreso);
        $reglas19 = array('fechaIngreso' => 'required');

        $input20  = array('fechaSalida' => $fechaSalida);
        $reglas20 = array('fechaSalida' => 'required');

        $input21  = array('correoinstitucional' => $correoinstitucional);
        $reglas21 = array('correoinstitucional' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Personal Administrativo';
            $selector='txtDNI';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido, mínimo 08 dígitos';
            $selector='txtDNI';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Personal Administrativo';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Personal Administrativo';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Personal Administrativo';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Personal Administrativo';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Personal Administrativo';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Personal Administrativo';
            $selector='txtfechanac';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el personal administrativo es Discapacitado';
            $selector='cbugenero';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el personal administrativo es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidad';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Personal Administrativo';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Personal Administrativo';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Personal Administrativo';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Personal Administrativo';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Personal Administrativo';
            $selector='txtDir';
        }
        elseif ($validator21->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Personal Administrativo';
            $selector='txtcorreoinstitucional';
        }
        elseif ($validator15->fails() || $local_id=="0") {
            $result='0';
            $msj='Seleccione un Local Válido';
            $selector='cbulocal';
        }
        elseif ($validator16->fails() || $tipoDependencia=="0") {
            $result='0';
            $msj='Seleccione un Tipo de Dependencia válida';
            $selector='cbutipodependencia';
        }
        elseif ($validator17->fails() && intval($tipoDependencia)<9) {
            $result='0';
            $msj='Ingrese el nombre de la Dependencia ';
            $selector='txtdependencia';
        }

        elseif (intval($tipoDependencia)==9 && $facultad=="0") {
            $result='0';
            $msj='Seleccione la Facultad donde labora el Personal Administrativo';
            $selector='cbufacultad';
        }

        elseif (intval($tipoDependencia)==10 && $escuela=="0") {
            $result='0';
            $msj='Seleccione la Escuela profesional donde labora el Personal Administrativo';
            $selector='cbucarrera';
        }

        elseif ($cargo=="0") {
            $result='0';
            $msj='Seleccione un cargo válido';
            $selector='cbucarrera';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Nombre exacto del cargo';
            $selector='txtdesccargo';
        }

        elseif ($grado!="0" && strlen($descripcionGrado)==0) {
            $result='0';
            $msj='Ingrese la Descripción de su máximo grado alcanzado';
            $selector='txtdescGrado';
        }

        elseif (intval($esTitulado)==1 && strlen($descripcionTitulo)==0) {
            $result='0';
            $msj='Ingrese el nombre del título Universitario';
            $selector='txttitulouniv';
        }

        elseif ($grado!="0" && strlen($paisGrado)==0 && $lugarGrado=="Internacional") {
            $result='0';
            $msj='Ingrese el País donde consiguió su máximo grado académico';
            $selector='txtpaismaxgrado';
        }



        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador ingresó a su cargo';
            $selector='txtfechaingreso';
        }

        elseif ($validator20->fails() && intval($estado)==0) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finalizó su cargo laboral';
            $selector='txtfechasalida';
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
            $newPersona->activo='1';
            $newPersona->borrado='0';

            $newPersona->save();

            $persona_id=$newPersona->id;
        }

     
        $newAdministrativo = new Administrativo();
        $newAdministrativo->persona_id=$persona_id;
        $newAdministrativo->local_id=$local_id;
        $newAdministrativo->tipoDependencia=$tipoDependencia;
        $newAdministrativo->dependencia=$dependencia;
        $newAdministrativo->facultad=$facultad;
        $newAdministrativo->escuela=$escuela;
        $newAdministrativo->cargo=$cargo;
        $newAdministrativo->descripcionCargo=$descripcionCargo;
        $newAdministrativo->grado=$grado;
        $newAdministrativo->descripcionGrado=$descripcionGrado;
        $newAdministrativo->esTitulado=$esTitulado;
        $newAdministrativo->descripcionTitulo=$descripcionTitulo;
        $newAdministrativo->lugarGrado=$lugarGrado;
        $newAdministrativo->paisGrado=$paisGrado;
        $newAdministrativo->fechaIngreso=$fechaIngreso;
        $newAdministrativo->observaciones=$observaciones;
        $newAdministrativo->estado=$estado;
        $newAdministrativo->condicion=$condicion;
        $newAdministrativo->fechaSalida=$fechaSalida;

        $newAdministrativo->activo='1';
        $newAdministrativo->borrado='0';

        $newAdministrativo->save();


            $msj='Nuevo Personal Administrativo registrado con éxito';
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
        $correoinstitucional=$request->correoinstitucional;

        $persona_id=$request->persona_id;
        $local_id=$request->local_id;
        $tipoDependencia=$request->tipoDependencia;
        $dependencia=$request->dependencia;
        $facultad=$request->facultad;
        $escuela=$request->escuela;
        $cargo=$request->cargo;
        $descripcionCargo=$request->descripcionCargo;
        $grado=$request->grado;
        $descripcionGrado=$request->descripcionGrado;
        $esTitulado=$request->esTitulado;
        $descripcionTitulo=$request->descripcionTitulo;
        $lugarGrado=$request->lugarGrado;
        $paisGrado=$request->paisGrado;
        $fechaIngreso=$request->fechaIngreso;
        $observaciones=$request->observaciones;
        $estado=$request->estado;
        $condicion=$request->condicion;
        $fechaSalida=$request->fechaSalida;
     


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        if(intval($tipoDependencia)==9)
        {
            $dependencia=$facultad;
        } 
        elseif(intval($tipoDependencia)==10)
        {
            $dependencia=$escuela;
        }

        if($grado=="0")
        {
            $descripcionGrado="";
            $esTitulado="0";
            $descripcionTitulo="";
            $lugarGrado="";
            $paisGrado="";
        }
        elseif($lugarGrado=="Nacional")
        {
            $paisGrado="PERÚ";
        }

        if(intval($esTitulado)==0)
        {
            $descripcionTitulo="";
        }

        if(intval($estado)==1)
        {
            $fechaSalida=null;
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



        $input15  = array('local_id' => $local_id);
        $reglas15 = array('local_id' => 'required');

        $input16  = array('tipoDependencia' => $tipoDependencia);
        $reglas16 = array('tipoDependencia' => 'required');

        $input17  = array('dependencia' => $dependencia);
        $reglas17 = array('dependencia' => 'required');

        $input18  = array('descripcionCargo' => $descripcionCargo);
        $reglas18 = array('descripcionCargo' => 'required');

        $input19  = array('fechaIngreso' => $fechaIngreso);
        $reglas19 = array('fechaIngreso' => 'required');

        $input20  = array('fechaSalida' => $fechaSalida);
        $reglas20 = array('fechaSalida' => 'required');

        $input21  = array('correoinstitucional' => $correoinstitucional);
        $reglas21 = array('correoinstitucional' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Personal Administrativo';
            $selector='txtDNIE';

        }
        elseif (strlen($doc)<8)
        {
            $result='0';
            $msj='Complete un N° de Documento de Identidad Válido, mínimo 08 dígitos';
            $selector='txtDNIE';

        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Personal Administrativo';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Personal Administrativo';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Personal Administrativo';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Personal Administrativo';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Personal Administrativo';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Personal Administrativo';
            $selector='txtfechanacE';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el personal administrativo es Discapacitado';
            $selector='cbugeneroE';
        }
        elseif (intval($esdiscapacitado)==1 && strlen($discapacidad)==0) {
            $result='0';
            $msj='Si ha indicado que el personal administrativo es discapacitado, ingrese la discapacidad que padece';
            $selector='txtdiscapacidadE';
        }

        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Personal Administrativo';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Personal Administrativo';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Personal Administrativo';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Personal Administrativo';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Personal Administrativo';
            $selector='txtDirE';
        }
        elseif ($validator21->fails()) {
            $result='0';
            $msj='ingrese el correo institucional del Personal Administrativo';
            $selector='txtcorreoinstitucionalE';
        }
        elseif ($validator15->fails() || $local_id=="0") {
            $result='0';
            $msj='Seleccione un Local Válido';
            $selector='cbulocalE';
        }
        elseif ($validator16->fails() || $tipoDependencia=="0") {
            $result='0';
            $msj='Seleccione un Tipo de Dependencia válida';
            $selector='cbutipodependenciaE';
        }
        elseif ($validator17->fails() && intval($tipoDependencia)<9) {
            $result='0';
            $msj='Ingrese el nombre de la Dependencia ';
            $selector='txtdependenciaE';
        }

        elseif (intval($tipoDependencia)==9 && $facultad=="0") {
            $result='0';
            $msj='Seleccione la Facultad donde labora el Personal Administrativo';
            $selector='cbufacultadE';
        }

        elseif (intval($tipoDependencia)==10 && $escuela=="0") {
            $result='0';
            $msj='Seleccione la Escuela profesional donde labora el Personal Administrativo';
            $selector='cbucarreraE';
        }

        elseif ($cargo=="0") {
            $result='0';
            $msj='Seleccione un cargo válido';
            $selector='cbucarreraE';
        }

        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Nombre exacto del cargo';
            $selector='txtdesccargoE';
        }

        elseif ($grado!="0" && strlen($descripcionGrado)==0) {
            $result='0';
            $msj='Ingrese la Descripción de su máximo grado alcanzado';
            $selector='txtdescGradoE';
        }

        elseif (intval($esTitulado)==1 && strlen($descripcionTitulo)==0) {
            $result='0';
            $msj='Ingrese el nombre del título Universitario';
            $selector='txttitulounivE';
        }

        elseif ($grado!="0" && strlen($paisGrado)==0 && $lugarGrado=="Internacional") {
            $result='0';
            $msj='Ingrese el País donde consiguió su máximo grado académico';
            $selector='txtpaismaxgradoE';
        }



        elseif ($validator19->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador ingresó a su cargo';
            $selector='txtfechaingresoE';
        }

        elseif ($validator20->fails() && intval($estado)==0) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finalizó su cargo laboral';
            $selector='txtfechasalidaE';
        }
   

      else {

     
       
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

            $editPersona->save();
     

     
            $newAdministrativo = Administrativo::find($id);
            $newAdministrativo->persona_id=$persona_id;
            $newAdministrativo->local_id=$local_id;
            $newAdministrativo->tipoDependencia=$tipoDependencia;
            $newAdministrativo->dependencia=$dependencia;
            $newAdministrativo->facultad=$facultad;
            $newAdministrativo->escuela=$escuela;
            $newAdministrativo->cargo=$cargo;
            $newAdministrativo->descripcionCargo=$descripcionCargo;
            $newAdministrativo->grado=$grado;
            $newAdministrativo->descripcionGrado=$descripcionGrado;
            $newAdministrativo->esTitulado=$esTitulado;
            $newAdministrativo->descripcionTitulo=$descripcionTitulo;
            $newAdministrativo->lugarGrado=$lugarGrado;
            $newAdministrativo->paisGrado=$paisGrado;
            $newAdministrativo->fechaIngreso=$fechaIngreso;
            $newAdministrativo->observaciones=$observaciones;
            $newAdministrativo->estado=$estado;
            $newAdministrativo->condicion=$condicion;
            $newAdministrativo->fechaSalida=$fechaSalida;


            $newAdministrativo->save();

            $msj='Personal Administrativo modificado con éxito';
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

   
        
        $borrar = Administrativo::destroy($id);
        //$task->delete();


        $msj='Personal Administrativo Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;

     


        Excel::create('Personal Administrativo', function($excel) use($buscar)  {
            $excel->sheet('BD de Administrativos', function($sheet) use($buscar){

                $sheet->setAutoSize(true);
                /* $sheet->mergeCells('B1:D1');
                $sheet->mergeCells('B2:H2'); */

                $sheet->mergeCells('A3:AB3');
                $sheet->cells('A3:AB3',function($cells)
                {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->setBorder('A3:AB3', 'thin');
                $sheet->cells('A3:AB3', function($cells)
                {
                    $cells->setBackground('#0C73E8');
                    $cells->setFontColor('#FFFFFF');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontSize(15);

                    #Borders
                });
                
                $sheet->cells('A4:AB4', function($cells)
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
                'J'=>'22',
                'K'=>'40',
                'L'=>'45',
                'M'=>'35',
                'N'=>'45',
                'O'=>'45',
                'P'=>'45',
                'Q'=>'20',
                'R'=>'35',
                'S'=>'45',
                'T'=>'22',
                'U'=>'45',
                'V'=>'35',
                'W'=>'30',
                'X'=>'25',
                'Y'=>'26',
                'Z'=>'33',
                'AA'=>'65', // Correo Institucional
                'AB'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS PERSONAL ADMINSITRATIVO UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AB4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO','DESCRIPCIÓN DEL CARGO','CONDICIÓN LABORAL','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO','ESTADO DE CONTRATO','FECHA DE INICIO DE LABORES','FECHA DE FINALIZACIÓN DE LABORES', 'CORREO INSTITUCIONAL', 'OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $administrativos = DB::table('administrativos')
     ->join('personas', 'personas.id', '=', 'administrativos.persona_id')
     ->join('locals', 'locals.id', '=', 'administrativos.local_id')

     ->where('administrativos.borrado','0')
     ->where('administrativos.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','administrativos.id', 'personas.correoinstitucional', 
     'administrativos.persona_id','administrativos.local_id','administrativos.tipoDependencia','administrativos.dependencia','administrativos.facultad','administrativos.escuela','administrativos.cargo','administrativos.descripcionCargo','administrativos.grado','administrativos.descripcionGrado','administrativos.esTitulado','administrativos.descripcionTitulo','administrativos.lugarGrado','administrativos.paisGrado','administrativos.fechaIngreso','administrativos.observaciones','administrativos.estado','administrativos.condicion','administrativos.fechaSalida','administrativos.id','locals.id as idlocal','locals.nombre as local')
     ->get();

        foreach ($administrativos as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AB'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');
/*
 array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO','DESCRIPCIÓN DEL CARGO','CONDICIÓN LABORAL','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO','ESTADO DE CONTRATO','FECHA DE INICIO DE LABORES','FECHA DE FINALIZACIÓN DE LABORES','OBSERVACIONES'));
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
           $dato->local,
           tipoDependenciaAdmin($dato->tipoDependencia),
           $dato->dependencia,
           $dato->cargo,
           $dato->descripcionCargo,
           $dato->condicion,
           gradoAdmin($dato->grado),
           $dato->descripcionGrado,
           SiUnoNoCero($dato->esTitulado),
           $dato->descripcionTitulo,
           $dato->lugarGrado,
           $dato->paisGrado,
           estadoContrato($dato->estado),
           pasFechaVista($dato->fechaIngreso),
           pasFechaVista($dato->fechaSalida),
           $dato->correoinstitucional,
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
