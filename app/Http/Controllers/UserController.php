<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipopersona;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Tipouser;
use App\User;

use App\Modulo;
use App\Submodulo;
use App\Permisomodulo;
use App\Permisossubmodulo;


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;

use stdClass;


class UserController extends Controller     
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        if(accesoUser([1])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="usuario";
            $tipousers=Tipouser::orderBy('id')->where('borrado','0')->get();
            $modulos=Modulo::orderBy('id')->where('borrado','0')->get();
            $submodulos=Submodulo::orderBy('id')->where('borrado','0')->get();

            return view('usuario.index',compact('tipouser','modulo','tipousers','modulos','submodulos'));
        }
        else
        {
            return redirect('home');    
        }
    }

    public function index2()
    {
        if(accesoUser([1,2,3,4,5])){


            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);


            $modulo="miperfil";
            return view('miperfil.index',compact('tipouser','modulo'));
        }
        else
        {
            return redirect('home');           
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;

        $usuarios = DB::table('users')
        ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')

        ->where('users.borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('personas.nombres','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidopat','like','%'.$buscar.'%');
        $query->orWhere('personas.apellidomat','like','%'.$buscar.'%');
        $query->orWhere('personas.doc','like','%'.$buscar.'%');
            $query->orWhere('users.name','like','%'.$buscar.'%');
            })
        ->orderBy('tipousers.id')
        ->orderBy('personas.apellidopat')
        ->orderBy('personas.apellidomat')
        ->orderBy('personas.nombres')
        ->select('users.id as id','users.name','users.email','users.activo','users.borrado','users.token2','users.persona_id','users.tipouser_id',
        'personas.id as idpersona','personas.tipodoc','personas.doc','personas.nombres','personas.apellidopat','personas.apellidomat','personas.genero','personas.estadocivil','personas.fechanac','personas.esdiscapacitado','personas.discapacidad','personas.pais','personas.departamento','personas.provincia','personas.distrito','personas.direccion','personas.telefono','tipousers.id as idtipouser','tipousers.nombre as tipouser')
        ->paginate(30);

        $users=$usuarios->items();

        $permisoModulos = array();
        $permisoSubModulos = array();

        foreach ($users as $key => $dato) {

            $permod=DB::table('permisomodulos')
            ->join('modulos', 'modulos.id', '=', 'permisomodulos.modulo_id')
            ->where('permisomodulos.activo','1')
            ->where('permisomodulos.borrado','0')
            ->where('permisomodulos.user_id',$dato->id)
            ->select('permisomodulos.id','permisomodulos.modulo_id','permisomodulos.user_id','permisomodulos.tipo','modulos.id as idmodulo','modulos.modulo')
            ->get();

            foreach ($permod as $key2 => $dato2) {

            $newobj = new stdClass();

            $newobj->id=$dato2->id;
            $newobj->modulo_id=$dato2->modulo_id;
            $newobj->user_id=$dato2->user_id;
            $newobj->tipo=$dato2->tipo;
            $newobj->idmodulo=$dato2->idmodulo;
            $newobj->modulo=$dato2->modulo;

            $permisoModulos[]=$newobj;

            }


            $persubmod=DB::table('permisossubmodulos')
            ->join('submodulos', 'submodulos.id', '=', 'permisossubmodulos.submodulo_id')
            ->where('permisossubmodulos.activo','1')
            ->where('permisossubmodulos.borrado','0')
            ->where('permisossubmodulos.user_id',$dato->id)
            ->select('permisossubmodulos.id','permisossubmodulos.submodulo_id','permisossubmodulos.user_id','submodulos.id as idsubmodulo','submodulos.submodulo','submodulos.modulo_id')
            ->get();

            foreach ($persubmod as $key3 => $dato3) {

                $newobj2 = new stdClass();
    
                $newobj2->id=$dato3->id;
                $newobj2->submodulo_id=$dato3->modulo_id;
                $newobj2->user_id=$dato3->user_id;
                $newobj2->modulo_id=$dato3->modulo_id;
                $newobj2->idsubmodulo=$dato3->idsubmodulo;
                $newobj2->submodulo=$dato3->submodulo;
    
                $permisoSubModulos[]=$newobj2;
    
                }
        }

          return [
            'pagination'=>[
                'total'=> $usuarios->total(),
                'current_page'=> $usuarios->currentPage(),
                'per_page'=> $usuarios->perPage(),
                'last_page'=> $usuarios->lastPage(),
                'from'=> $usuarios->firstItem(),
                'to'=> $usuarios->lastItem(),
            ],
            'usuarios'=>$usuarios,
            'permisoModulos'=>$permisoModulos,
            'permisoSubModulos'=>$permisoSubModulos
        ];
    }



    public function miperfil(Request $request)
    {
        //$buscar=$request->busca;

        $usuario = DB::table('users')
        ->join('tipousers', 'tipousers.id', '=', 'users.tipouser_id')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->join('tipopersonas', 'tipopersonas.id', '=', 'personas.tipopersona_id')
        ->leftjoin('entidads', 'entidads.id', '=', 'users.entidad_id')
        ->where('users.id',Auth::user()->id)

        ->orderBy('users.id')
        ->select('users.id as idUser','users.name as username','users.email','users.activo','users.borrado','personas.id as idPer','personas.nombre','personas.dni_ruc','personas.direccion','tipousers.id as idtipouser','tipousers.tipo as tipouser','tipousers.codigo','tipopersonas.tipo as tipoPer','tipopersonas.id as idtipoPer','entidads.id as entidad_id', 'entidads.descripcion as entidad','entidads.code as codeentidad')
        ->first();




        return [
            'usuario'=>$usuario
        ];
    }

    public function modificarclave(Request $request)
    {
        $result='1';
        $msj='';
        $selector='';

        $pswa=$request->pswa;
        $pswn1=$request->pswn1;
        $pswn2=$request->pswn2;

        $iduser=Auth::user()->id;
     

        $input1  = array('clave' => $pswa);
        $reglas1 = array('clave' => 'required');

        $input2  = array('ncalve1' => $pswn1);
        $reglas2 = array('ncalve1' => 'required');

        $input3  = array('ncalve2' => $pswn2);
        $reglas3 = array('ncalve2' => 'required');



        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);


          if ($validator1->fails())
        {
            $result='0';
            $msj='Ingrese la Contraseña Actual de la Cuenta';
            $selector='txtdato2';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese la Nueva Contraseña de la Cuenta';
            $selector='txtdato3';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese nuevamente la Nueva Contraseña de la Cuenta';
            $selector='txtdato4';
        }elseif (!Hash::check($pswa, Auth::user()->password)) {
            $result='0';
            $msj='La Contraseña Actual Ingresada No es Correcta, Ingrése una Contraseña Correcta';
            $selector='txtdato2';
        }elseif (strval($pswn1)!=strval($pswn2)) {
            $result='0';
            $msj='Las Nuevas Contraseñas Indicadas son Diferentes, Por favor Ingrese Correctamente las Contraseñas';
            $selector='txtdato3';
        }elseif (Hash::check($pswn1, Auth::user()->password)) {
            $result='0';
            $msj='La Contraseña Actual y La Nueva Contraseña Son Iguales, Debe Ingresar una Nueva Contraseña Diferente';
            $selector='txtdato3';
        }
        else{

                            $editUser = User::findOrFail($iduser);

                                $editUser->password=bcrypt($pswn1);          


                            $editUser->save();


                            $msj='Contraseña de Usuario modificado con éxito';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
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
        $result='1';
        $msj='';
        $selector='';

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

        $name=$request->name;
        $password=$request->password;
        $tipouser_id=$request->tipouser_id;
        $persona_id=$request->persona_id;
        $activo=$request->activo;


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        
        $regla0=DB::table('users')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('users.borrado','0')
        ->where('personas.doc',$doc)->count();

        $regla02=User::where('name',$name)->where('borrado','0')->count();
        $regla03=User::where('email',$email)->where('borrado','0')->count();
     
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


            $input15  = array('name' => $name);
            $reglas15 = array('name' => 'required');

            $input16  = array('password' => $password);
            $reglas16 = array('password' => 'required');



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


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Tipo y Documento de Identidad ingresado';
            $selector='txtDNI';
        }

        elseif($regla02>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Username ingresado';
            $selector='txtname';
        }

        elseif($regla03>0){
            $result='0';
            $msj='Ya se encuentra registrado un email con el Username ingresado';
            $selector='txtemail';
        }

        elseif($validator1->fails()){
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
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtname';
        }
        elseif ($validator16->fails()) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpassword';
        }
        elseif (intval($tipouser_id)==0) {
            $result='0';
            $msj='Seleccione el Tipo de Usuario';
            $selector='cbutipouser_id';
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
        
                    $newUser = new User();
                    $newUser->name=$name;
                    $newUser->email=$email;
                    $newUser->password=bcrypt($password);
                    $newUser->persona_id=$persona_id;
                    $newUser->tipouser_id=$tipouser_id;
                    $newUser->activo=$activo;
                    $newUser->token2=$password;
                    $newUser->borrado='0';                   

                    $newUser->save();
        
    

                    $msj='Nuevo Usuario del Sistema registrado con éxito';

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
        
        $result='1';
        $msj='';
        $selector='';

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

        $modifpassword=$request->modifpassword;

        $name=$request->name;
        $password=$request->password;
        $tipouser_id=$request->tipouser_id;
        $persona_id=$request->persona_id;
        $activo=$request->activo;


        if(intval($esdiscapacitado)==0)
        {
            $discapacidad="";
        }

        
        $regla0=DB::table('users')
        ->join('personas', 'personas.id', '=', 'users.persona_id')
        ->where('personas.tipodoc',$tipodoc)
        ->where('users.borrado','0')
        ->where('users.id','<>',$id)
        ->where('personas.doc',$doc)->count();

        $regla02=User::where('name',$name)->where('users.id','<>',$id)->where('borrado','0')->count();
        $regla03=User::where('email',$email)->where('users.id','<>',$id)->where('borrado','0')->count();
     
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


            $input15  = array('name' => $name);
            $reglas15 = array('name' => 'required');

            $input16  = array('password' => $password);
            $reglas16 = array('password' => 'required');



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


        if($regla0>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Tipo y Documento de Identidad ingresado';
            $selector='txtDNIE';
        }

        elseif($regla02>0){
            $result='0';
            $msj='Ya se encuentra registrado un Usuario con el Username ingresado';
            $selector='txtnameE';
        }

        elseif($regla03>0){
            $result='0';
            $msj='Ya se encuentra registrado un email con el Username ingresado';
            $selector='txtemailE';
        }

        elseif($validator1->fails()){
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
        elseif ($validator15->fails()) {
            $result='0';
            $msj='Ingrese el Username del Usuario';
            $selector='txtnameE';
        }
        elseif ($validator16->fails() && intval($modifpassword)==2) {
            $result='0';
            $msj='Ingrese el Password del usuario';
            $selector='txtpasswordE';
        }
        elseif (intval($tipouser_id)==0) {
            $result='0';
            $msj='Seleccione el Tipo de Usuario';
            $selector='cbutipouser_idE';
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
             
                if(intval($modifpassword)==2){

                    $newUser = User::find($id);;
                    $newUser->name=$name;
                    $newUser->email=$email;
                    $newUser->password=bcrypt($password);
                    $newUser->persona_id=$persona_id;
                    $newUser->tipouser_id=$tipouser_id;
                    $newUser->activo=$activo;
                    $newUser->token2=$password;    
                    
                    $newUser->save();
                }
                else{
                    $newUser = User::find($id);;
                    $newUser->name=$name;
                    $newUser->email=$email;
                    $newUser->persona_id=$persona_id;
                    $newUser->tipouser_id=$tipouser_id;
                    $newUser->activo=$activo;

                    $newUser->save();
                }
                    

          $msj='Usuario modificado con éxito';


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

        $borrarUsuario = User::findOrFail($id);
        //$task->delete();

        $borrarUsuario->borrado='1';

        $borrarUsuario->save();

        $msj='Usuario seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateUsuario = User::findOrFail($id);
        $updateUsuario->activo=$estado;
        $updateUsuario->save();

        if(strval($estado)=="0"){
            $msj='El Usuario fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Usuario fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function verpersona($dni)
    {
       $persona=Persona::where('dni_ruc',$dni)->get();

       $id="0";
       $idUser="0";

        foreach ($persona as $key => $dato) {
          $id=$dato->id;
        }

        $user=User::where('persona_id',$id)->where('borrado','0')->get();

        foreach ($user as $key => $dato) {
            $idUser=$dato->id;
        }


      return response()->json(["persona"=>$persona, "id"=>$id, "user"=>$user , "idUser"=>$idUser]);

    }
}
