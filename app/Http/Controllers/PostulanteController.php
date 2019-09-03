<?php

namespace App\Http\Controllers;

use App\Postulante;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



use App\Escuela;
use App\Modalidadadmision;
use App\Semestre;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

class PostulanteController extends Controller
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
            $modalidadAdmision=Modalidadadmision::where('activo','1')->where('borrado','0')->get();

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


            $modulo="postulantes";
            return view('postulantes.index',compact('tipouser','modulo','escuelas','semestres','modalidadAdmision','semestresel','contse','semestreNombre'));
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

     $postulantes = DB::table('postulantes')
     ->join('personas', 'personas.id', '=', 'postulantes.persona_id')
     ->join('semestres', 'semestres.id', '=', 'postulantes.semestre_id')
     ->join('modalidadadmisions', 'modalidadadmisions.id', '=', 'postulantes.modalidadadmision_id')
     ->leftjoin('escuelas as escuela1', 'escuela1.id', '=', 'postulantes.escuela_id')
     ->leftjoin('escuelas as escuela2', 'escuela2.id', '=', 'postulantes.escuela_id2')
     ->leftjoin('escuelas as escuelaing', 'escuelaing.id', '=', 'postulantes.escuela_ingreso')
     ->where('postulantes.borrado','0')
     ->where('postulantes.tipo','1')
     ->where('semestres.id',$semestre_id)
     ->where(function($query) use ($buscar){
        $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
        $query->orWhere('postulantes.codigo','like','%'.$buscar.'%');
        })
     ->orderBy('facultads.nombre')
     ->orderBy('postulantes.nombre')
     ->select('personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.email','personas.telefono','postulantes.id','postulantes.codigo','postulantes.semestre_id','postulantes.escuela_id','postulantes.colegio','postulantes.modalidadadmision_id','postulantes.modalidadestudios','postulantes.puntaje','postulantes.estado','postulantes.opcioningreso','postulantes.persona_id','postulantes.observaciones','postulantes.tipo','postulantes.email','postulantes.escuela_id2','postulantes.tipogestioncolegio','postulantes.escuela_ingreso','semestres.nombre as semestre','modalidadadmisions.id as idmodadmi','modalidadadmisions.nombre as modalidadadmision','escuela1.nombre as escuela1','escuela2.nombre as escuela2','escuelaing.nombre as escuelaing')
     ->paginate(50);


     return [
        'pagination'=>[
            'total'=> $postulantes->total(),
            'current_page'=> $postulantes->currentPage(),
            'per_page'=> $postulantes->perPage(),
            'last_page'=> $postulantes->lastPage(),
            'from'=> $postulantes->firstItem(),
            'to'=> $postulantes->lastItem(),
        ],
        'postulantes'=>$postulantes
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

        /*

        this.tipodoc=1;
    this.doc='';
    this.nombres='';
    this.apellidopat='';
    this.apellidomat='';
    this.genero='M';
    this.estadocivil=1;
    this.fechanac='';
    this.esdiscapacitado=0;
    this.discapacidad='';
    this.pais='PERÚ';
    this.departamento='ANCASH';
    this.provincia='HUARAZ';
    this.distrito='HUARAZ';
    this.direccion='';
    this.email='';
    this.telefono='';
    this.codigo='';
    this.semestre_id={{$semestresel}};
    this.escuela_id=0;
    this.colegio='';
    this.modalidadadmision_id=0;
    this.modalidadestudios=1;
    this.puntaje='';
    this.estado=0;
    this.opcioningreso=0;
    this.observaciones='';
    this.escuela_id2=0;
    this.tipogestioncolegio=1;
    persona_id*/


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
        $codigo=$request->codigo;
        $semestre_id=$request->semestre_id;
        $escuela_id=$request->escuela_id;
        $colegio=$request->colegio;
        $modalidadadmision_id=$request->modalidadadmision_id;
        $modalidadestudios=$request->modalidadestudios;
        $puntaje=$request->puntaje;
        $estado=$request->estado;
        $opcioningreso=$request->opcioningreso;
        $observaciones=$request->observaciones;
        $escuela_id2=$request->escuela_id2;
        $tipogestioncolegio=$request->tipogestioncolegio;
        $persona_id=$request->persona_id;




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

        $input15  = array('codigo' => $codigo);
        $reglas15 = array('codigo' => 'required');

        $input16  = array('semestre_id' => $semestre_id);
        $reglas16 = array('semestre_id' => 'required');

        $input17  = array('escuela_id' => $escuela_id);
        $reglas17 = array('escuela_id' => 'required');

        $input18  = array('colegio' => $colegio);
        $reglas18 = array('colegio' => 'required');

        $input19  = array('modalidadadmision_id' => $modalidadadmision_id);
        $reglas19 = array('modalidadadmision_id' => 'required');

        $input20  = array('modalidadestudios' => $modalidadestudios);
        $reglas20 = array('modalidadestudios' => 'required');

        $input21  = array('puntaje' => $puntaje);
        $reglas21 = array('puntaje' => 'required');

        $input22  = array('estado' => $estado);
        $reglas22 = array('estado' => 'required');

        $input23  = array('tipogestioncolegio' => $tipogestioncolegio);
        $reglas23 = array('tipogestioncolegio' => 'required');



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
            $selector='cbstipopersona';
        }
        elseif ($validator2->fails())
        {
            $result='0';
            $msj='Complete el Documento de Identidad del Postulante';
            $selector='txtnom';

        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese los nombres del Postulante';
            $selector='txtdni';
        }
        elseif ($validator4->fails()) {
            $result='0';
            $msj='Ingrese el apellido paterno del Postulante';
            $selector='txtdni';
        }
        elseif ($validator5->fails()) {
            $result='0';
            $msj='Ingrese el apellido materno del Postulante';
            $selector='txtdni';
        }
        elseif ($validator6->fails()) {
            $result='0';
            $msj='Seleccione el Género del Postulante';
            $selector='txtdni';
        }
        elseif ($validator7->fails()) {
            $result='0';
            $msj='Seleccione el Estado Civil del Postulante';
            $selector='txtdni';
        }
        elseif ($validator8->fails()) {
            $result='0';
            $msj='Ingrese la Fecha de Nacimiento del Postulante';
            $selector='txtdni';
        }
        elseif ($validator9->fails()) {
            $result='0';
            $msj='Seleccione si el Postulante es Discapacitado';
            $selector='txtdni';
        }
        elseif ($validator10->fails()) {
            $result='0';
            $msj='Ingrese el País de procedencia del Postulante';
            $selector='txtdni';
        }
        elseif ($validator11->fails()) {
            $result='0';
            $msj='Ingrese el Departamento de procedencia del Postulante';
            $selector='txtdni';
        }
        elseif ($validator12->fails()) {
            $result='0';
            $msj='Ingrese la Provincia de procedencia del Postulante';
            $selector='txtdni';
        }
        elseif ($validator13->fails()) {
            $result='0';
            $msj='Ingrese el Distrito de procedencia del Postulante';
            $selector='txtdni';
        }
        elseif ($validator14->fails()) {
            $result='0';
            $msj='Ingrese la Dirección del Postulante';
            $selector='txtdni';
        }
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Código del Postulante';
            $selector='txtdni';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Seleccione el Semestre de Postulación del Postulante';
            $selector='txtdni';
        }
        elseif ($validator17->fails()) {
            $result='0';
            $msj='Seleccione el Programa Profesional de primera opción del postulante';
            $selector='txtdni';
        }
        elseif ($validator18->fails()) {
            $result='0';
            $msj='Ingrese el Colegio de Procedencia del Postulante';
            $selector='txtdni';
        }
        elseif ($validator19->fails()) {
            $result='0';
            $msj='Seleccione la Modalidad de Admisión del Postulante';
            $selector='txtdni';
        }
        elseif ($validator20->fails()) {
            $result='0';
            $msj='Seleccione la Modalidad de Estudios del Postulante';
            $selector='txtdni';
        }

        elseif ($validator21->fails()) {
            $result='0';
            $msj='Ingrese el Puntaje que obtuvo el postulante';
            $selector='txtdni';
        }
        elseif ($validator22->fails()) {
            $result='0';
            $msj='Ingrese el estado de Ingreso del postulante';
            $selector='txtdni';
        }
        elseif ($validator23->fails()) {
            $result='0';
            $msj='Seleccione el tipo de Gestión Administrativa del Colegio de Procedencia del Postulante';
            $selector='txtdni';
        }
       
        else{

            $newPersona = new Persona();
            $newPersona->nombre=$nombre;
            $newPersona->dni_ruc=$dni_ruc;
            $newPersona->codigo_alumno=$codigo_alumno;
            $newPersona->direccion=$direccion;
            $newPersona->activo=$activo;
            $newPersona->borrado='0';
            $newPersona->escuela_id=$escuela_id;
            $newPersona->tipopersona_id=$tipopersona_id;

            $newPersona->save();

            $msj='Nueva Persona registrada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function show(Postulante $postulante)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function edit(Postulante $postulante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Postulante $postulante)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postulante  $postulante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Postulante $postulante)
    {
        //
    }
}
