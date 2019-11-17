<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Adminlocacion;
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


class AdminlocacionController extends Controller
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


            $modulo="adminlocacion";
            return view('adminlocacion.index',compact('tipouser','modulo','escuelas','facultads','locals'));
        }
        else
        {
            return redirect('home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
     
     $adminlocacions = DB::table('adminlocacions')
     ->join('personas', 'personas.id', '=', 'adminlocacions.persona_id')
     ->join('locals', 'locals.id', '=', 'adminlocacions.local_id')

     ->where('adminlocacions.borrado','0')
     ->where('adminlocacions.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','adminlocacions.id',
     
     'adminlocacions.persona_id','adminlocacions.local_id','adminlocacions.tipoDependencia','adminlocacions.dependencia','adminlocacions.facultad','adminlocacions.escuela','adminlocacions.cargo','adminlocacions.descripcionCargo','adminlocacions.grado','adminlocacions.descripcionGrado','adminlocacions.esTitulado','adminlocacions.descripcionTitulo','adminlocacions.lugarGrado','adminlocacions.paisGrado','adminlocacions.fechaIngreso','adminlocacions.observaciones','adminlocacions.estado','adminlocacions.condicionLaboral','adminlocacions.fechaFinContrato','adminlocacions.id','locals.id as idlocal','locals.nombre as local','adminlocacions.fechaInicioContrato','adminlocacions.regimenLaboral')
     ->paginate(50);

     return [
        'pagination'=>[
            'total'=> $adminlocacions->total(),
            'current_page'=> $adminlocacions->currentPage(),
            'per_page'=> $adminlocacions->perPage(),
            'last_page'=> $adminlocacions->lastPage(),
            'from'=> $adminlocacions->firstItem(),
            'to'=> $adminlocacions->lastItem(),
        ],
        'adminlocacions'=>$adminlocacions
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
        $condicionLaboral=$request->condicionLaboral;
        $regimenLaboral=$request->regimenLaboral;
        $fechaInicioContrato=$request->fechaInicioContrato;
        $fechaFinContrato=$request->fechaFinContrato;
     


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

        $input20  = array('fechaInicioContrato' => $fechaInicioContrato);
        $reglas20 = array('fechaInicioContrato' => 'required');

        $input21  = array('fechaFinContrato' => $fechaFinContrato);
        $reglas21 = array('fechaFinContrato' => 'required');

        $input22  = array('regimenLaboral' => $regimenLaboral);
        $reglas22 = array('regimenLaboral' => 'required');

        $input23  = array('condicionLaboral' => $condicionLaboral);
        $reglas23 = array('condicionLaboral' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodoc';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del alumno';
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
            $msj='Ingrese los nombres del alumno';
            $selector='txtnombres';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del alumno';
            $selector='txtapepat';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del alumno';
            $selector='txtapemat';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del alumno';
            $selector='cbugenero';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del alumno';
            $selector='cbuestadocivil';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del alumno';
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
            $msj='Ingrese el País de procedencia del alumno';
            $selector='txtpais';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del alumno';
            $selector='txtdep';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del alumno';
            $selector='txtprov';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del alumno';
            $selector='txtdist';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del alumno';
            $selector='txtDir';
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

        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese la Condición Laboral del Trabajador';
            $selector='txtcondicion';
        }

        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el Régimen Laboral del Trabajador';
            $selector='txtregimen';
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

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador inició su contrato';
            $selector='txtfechacontrato';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finaliza su contrato';
            $selector='txtfechafinalContrato';
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

     
        $newAdministrativo = new Adminlocacion();
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
        $newAdministrativo->condicionLaboral=$condicionLaboral;
        $newAdministrativo->regimenLaboral=$regimenLaboral;
        $newAdministrativo->fechaInicioContrato=$fechaInicioContrato;
        $newAdministrativo->fechaFinContrato=$fechaFinContrato;

        $newAdministrativo->activo='1';
        $newAdministrativo->borrado='0';

        $newAdministrativo->save();


            $msj='Nuevo Personal Administrativo por Locación de Servicios registrado con éxito';
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
        $condicionLaboral=$request->condicionLaboral;
        $regimenLaboral=$request->regimenLaboral;
        $fechaInicioContrato=$request->fechaInicioContrato;
        $fechaFinContrato=$request->fechaFinContrato;
     


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

        $input20  = array('fechaInicioContrato' => $fechaInicioContrato);
        $reglas20 = array('fechaInicioContrato' => 'required');

        $input21  = array('fechaFinContrato' => $fechaFinContrato);
        $reglas21 = array('fechaFinContrato' => 'required');

        $input22  = array('regimenLaboral' => $regimenLaboral);
        $reglas22 = array('regimenLaboral' => 'required');

        $input23  = array('condicionLaboral' => $condicionLaboral);
        $reglas23 = array('condicionLaboral' => 'required');

    


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




       if($validator1->fails()){
            $result='0';
            $msj='Seleccione un tipo de Documento Válido';
            $selector='cbutipodocE';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del alumno';
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
            $msj='Ingrese los nombres del alumno';
            $selector='txtnombresE';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del alumno';
            $selector='txtapepatE';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del alumno';
            $selector='txtapematE';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del alumno';
            $selector='cbugeneroE';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del alumno';
            $selector='cbuestadocivilE';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del alumno';
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
            $msj='Ingrese el País de procedencia del alumno';
            $selector='txtpaisE';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del alumno';
            $selector='txtdepE';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del alumno';
            $selector='txtprovE';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del alumno';
            $selector='txtdistE';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del alumno';
            $selector='txtDirE';
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

        elseif ($validator23->fails()) {
            $result='0';
            $msj='Ingrese la Condición Laboral del Trabajador';
            $selector='txtcondicionE';
        }

        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el Régimen Laboral del Trabajador';
            $selector='txtregimenE';
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

        elseif ($validator20->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador inició su contrato';
            $selector='txtfechacontratoE';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese la fecha en que el trabajador finaliza su contrato';
            $selector='txtfechafinalContratoE';
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
     
          
   

     
        $editAdministrativo = Adminlocacion::find($id);
        $editAdministrativo->persona_id=$persona_id;
        $editAdministrativo->local_id=$local_id;
        $editAdministrativo->tipoDependencia=$tipoDependencia;
        $editAdministrativo->dependencia=$dependencia;
        $editAdministrativo->facultad=$facultad;
        $editAdministrativo->escuela=$escuela;
        $editAdministrativo->cargo=$cargo;
        $editAdministrativo->descripcionCargo=$descripcionCargo;
        $editAdministrativo->grado=$grado;
        $editAdministrativo->descripcionGrado=$descripcionGrado;
        $editAdministrativo->esTitulado=$esTitulado;
        $editAdministrativo->descripcionTitulo=$descripcionTitulo;
        $editAdministrativo->lugarGrado=$lugarGrado;
        $editAdministrativo->paisGrado=$paisGrado;
        $editAdministrativo->fechaIngreso=$fechaIngreso;
        $editAdministrativo->observaciones=$observaciones;
        $editAdministrativo->estado=$estado;
        $editAdministrativo->condicionLaboral=$condicionLaboral;
        $editAdministrativo->regimenLaboral=$regimenLaboral;
        $editAdministrativo->fechaInicioContrato=$fechaInicioContrato;
        $editAdministrativo->fechaFinContrato=$fechaFinContrato;


        $editAdministrativo->save();


            $msj='Personal Administrativo por Locación de Servicios modificado con éxito';
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

   
        
        $borrar = Adminlocacion::destroy($id);
        //$task->delete();


        $msj='Personal Administrativo por Locación de Servicios Seleccionado eliminado exitosamente';
   

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }




    public function descargarExcel(Request $request)
    {   
        $buscar=$request->busca;

     


        Excel::create('Personal Locación de Servicios', function($excel) use($buscar)  {
            $excel->sheet('BD Locación de Servicios', function($sheet) use($buscar){

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
                'Q'=>'35',
                'R'=>'45',
                'S'=>'45',
                'T'=>'30',
                'U'=>'25',
                'V'=>'45',
                'W'=>'25',
                'X'=>'25',
                'Y'=>'32',
                'Z'=>'28',
                'AA'=>'33',
                'AB'=>'65',
                )
                );

                $sheet->setHeight(array
                (
                '3'=>'24'
                )
                );

                $titulo='BASE DE DATOS PERSONAL LOCADOR DE SERVICIOS UNASAM';

                array_push($data, array(''));
                array_push($data, array(''));
                array_push($data, array($titulo));

                $sheet->setBorder('A4:AB4', 'thin');
                array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO GENERAL','DESCRIPCIÓN DEL CARGO','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO', 'TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','CONDICIÓN LABORAL','RÉGIMEN LABORAL', 'FECHA DE INGRESO A LA INSTITUCIÓN','FECHA DE INICIO DE CONTRATO','FECHA DE FINALIZACIÓN DE CONTRATO','OBSERVACIONES'));

                $cont=5;
                $cont2=5;

                $adminlocacions = DB::table('adminlocacions')
     ->join('personas', 'personas.id', '=', 'adminlocacions.persona_id')
     ->join('locals', 'locals.id', '=', 'adminlocacions.local_id')

     ->where('adminlocacions.borrado','0')
     ->where('adminlocacions.activo','1')

     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        })

     ->orderBy('personas.apellidopat')
     ->orderBy('personas.apellidomat')
     ->orderBy('personas.nombres')

     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','adminlocacions.id',
     
     'adminlocacions.persona_id','adminlocacions.local_id','adminlocacions.tipoDependencia','adminlocacions.dependencia','adminlocacions.facultad','adminlocacions.escuela','adminlocacions.cargo','adminlocacions.descripcionCargo','adminlocacions.grado','adminlocacions.descripcionGrado','adminlocacions.esTitulado','adminlocacions.descripcionTitulo','adminlocacions.lugarGrado','adminlocacions.paisGrado','adminlocacions.fechaIngreso','adminlocacions.observaciones','adminlocacions.estado','adminlocacions.condicionLaboral','adminlocacions.fechaFinContrato','adminlocacions.id','locals.id as idlocal','locals.nombre as local','adminlocacions.fechaInicioContrato','adminlocacions.regimenLaboral')
     ->get();

        foreach ($adminlocacions as $key => $dato) {
            $rango='A'.strval((intval($cont)+intval($key))).':AB'.strval((intval($cont)+intval($key)));
            $sheet->setBorder($rango, 'thin');
/*
array_push($data, array('N°','TIPO DE DOCUMENTO', 'NÚMERO DE DOCUMENTO', 'APELLIDO PATERNO', 'APELLIDO MATERNO','NOMBRES','GÉNERO','FECHA DE NACIMIENTO','ESTADO CIVIL','SUFRE DISCAPACIDAD','DISCAPACIDAD QUE PADECE','LOCAL','TIPO DE DEPENDENCIA','DEPENDENCIA','CARGO GENERAL','DESCRIPCIÓN DEL CARGO','MÁXIMO GRADO ACADÉMICO','DESCRIPCIÓN DEL MÁXIMO GRADO ACADÉMICO','LUGAR DEL MÁXIMO GRADO','PAÍS DEL MÁXIMO GRADO', 'TÍTULO UNIVERSITARIO','DESCRIPCIÓN DEL TÍTULO UNIVERSITARIO','CONDICIÓN LABORAL','RÉGIMEN LABORAL', 'FECHA DE INGRESO A LA INSTITUCIÓN','FECHA DE INICIO DE CONTRATO','FECHA DE FINALIZACIÓN DE CONTRATO','OBSERVACIONES'));
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
           gradoAdmin($dato->grado),
           $dato->descripcionGrado,
           $dato->lugarGrado,
           $dato->paisGrado,
           SiUnoNoCero($dato->esTitulado),
           $dato->descripcionTitulo,
           $dato->condicionLaboral,
           $dato->regimenLaboral,
           pasFechaVista($dato->fechaIngreso),
           pasFechaVista($dato->fechaInicioContrato),
           pasFechaVista($dato->fechaFinContrato),
           $dato->observaciones,
        
        ));
            
            $cont2++;
        }



                $sheet->fromArray($data, null, 'A1', false, false);
            
            });
            })->download('xlsx');  
   

        return response()->json(["buscar"=>$buscar,'tipo'=>$tipo]);
    }
}
