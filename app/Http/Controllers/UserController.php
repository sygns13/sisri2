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


use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator as LaravelValidator;


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
            return view('usuario.index',compact('tipouser','modulo'));
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
        ->join('tipopersonas', 'tipopersonas.id', '=', 'personas.tipopersona_id')
        ->leftjoin('entidads', 'entidads.id', '=', 'users.entidad_id')
        ->where('users.borrado','0')
        ->where(function($query) use ($buscar){
            $query->where('personas.nombre','like','%'.$buscar.'%');
            $query->orWhere('users.name','like','%'.$buscar.'%');
            })
        ->orderBy('users.id')
        ->select('users.id as idUser','users.name as username','users.email','users.activo','users.borrado','personas.id as idPer','personas.nombre','personas.dni_ruc','personas.direccion','tipousers.id as idtipouser','tipousers.tipo as tipouser','tipousers.codigo','tipopersonas.tipo as tipoPer','tipopersonas.id as idtipoPer','entidads.id as entidad_id', 'entidads.descripcion as entidad','entidads.code as codeentidad')
        ->paginate(30);

        $tipopersonas=Tipopersona::orderBy('id')->get();
        
        $tipousers=Tipouser::orderBy('id')->where('id','<',6)->get();

        //$entidads=Entidad::where('borrado','0')->where('estado','1')->orderBy('descripcion')->get();


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
            'tipopersonas'=>$tipopersonas,
            'tipousers'=>$tipousers
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

        $idPersona=$request->idPersona;
        $idUser=$request->idUser;

        $newDNI=$request->newDNI;
        $newNombres=$request->newNombres;
        $newDireccion=$request->newDireccion;

        $newUsername=$request->newUsername;
        $newEmail=$request->newEmail;
        $newPassword=$request->newPassword;

        $newEstado=$request->newEstado;
        $newTipoUser=$request->newTipoUser;
        $newTipoPersona=$request->newTipoPersona;
        $identidad=$request->identidad;


        if(strlen($newDireccion)==0)
        {
            $newDireccion="";
        }

        

     
            $input1  = array('dni_ruc' => $newDNI);
            $reglas1 = array('dni_ruc' => 'required');

            $input2  = array('nombre' => $newNombres);
            $reglas2 = array('nombre' => 'required');

            $input3  = array('name' => $newUsername);
            $reglas3 = array('name' => 'required');

            $input4  = array('password' => $newPassword);
            $reglas4 = array('password' => 'required');

            $input5  = array('email' => $newEmail);
            $reglas5 = array('email' => 'required');

            $input6  = array('name' => $newUsername);
            $reglas6 = array('name' => 'unique:users,name'.',1,borrado');

            $input7  = array('email' => $newEmail);
            $reglas7 = array('email' => 'unique:users,email'.',1,borrado');


            $validator1 = Validator::make($input1, $reglas1);
            $validator2 = Validator::make($input2, $reglas2);
            $validator3 = Validator::make($input3, $reglas3);
            $validator4 = Validator::make($input4, $reglas4);
            $validator5 = Validator::make($input5, $reglas5);
            $validator6 = Validator::make($input6, $reglas6);
            $validator7 = Validator::make($input7, $reglas7);


            if ($validator1->fails())
            {
                $result='0';
                $msj='Debe ingresar el DNI del usuario';
                $selector='txtDNI';
            }elseif ($validator2->fails()) {
                $result='0';
                $msj='Debe ingresar los nombres del usuario';
                $selector='txtnombres';
            }elseif ($validator3->fails()) {
                $result='0';
                $msj='Debe ingresar el Username del usuario';
                $selector='txtuser';
            }elseif ($validator4->fails()) {
                $result='0';
                $msj='Debe ingresar el password del usuario';
                $selector='txtclave';
            }elseif ($validator5->fails()) {
                $result='0';
                $msj='Debe ingresar el email del usuario';
                $selector='txtmail';
            }elseif (strlen($newTipoPersona)==0) {
                $result='0';
                $msj='Debe seleccionar un tipo de persona';
                $selector='cbuTipoPersona';
            }elseif (strlen($newTipoUser)==0) {
                $result='0';
                $msj='Debe seleccionar un tipo de usuario';
                $selector='cbuTipoUser';
            }elseif ($validator6->fails()) {
                $result='0';
                $msj='Debe ingresar otro Username, el que ha ingresado ya se encuentra registrado';
                $selector='txtuser';
            }
            elseif ($validator7->fails()) {
                $result='0';
                $msj='Debe ingresar otro Email, el que ha ingresado ya se encuentra registrado';
                $selector='txtmail';
            }
            elseif (intval($newTipoUser)==4 && $identidad=="") {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidad';
            }elseif (intval($newTipoUser)==4 && $identidad==null) {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidad';
            }elseif (intval($newTipoUser)==4 && strval($identidad)=="null") {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidad';
            }
            else{

             
                        //$idPersona
                 if($idPersona=="0"){

                    $newPersona = new Persona();

                    $newPersona->dni_ruc=$newDNI;
                    $newPersona->nombre=$newNombres;
                    $newPersona->codigo_alumno="";
                    $newPersona->direccion=$newDireccion;
                    $newPersona->tipopersona_id=$newTipoPersona;
                    $newPersona->activo='1';
                    $newPersona->borrado='0';

                    $newPersona->save();

                    if(intval($newTipoUser)==4 ){
                        $newUser = new User();

                    $newUser->name=$newUsername;
                    $newUser->email=$newEmail;
                    $newUser->password=bcrypt($newPassword);
                    $newUser->persona_id=$newPersona->id;
                    $newUser->tipouser_id=$newTipoUser;
                    $newUser->entidad_id=$identidad;
                    $newUser->activo=$newEstado;
                    $newUser->borrado='0';                   

                    $newUser->save();
                    }
                    else{
                        $newUser = new User();

                    $newUser->name=$newUsername;
                    $newUser->email=$newEmail;
                    $newUser->password=bcrypt($newPassword);
                    $newUser->persona_id=$newPersona->id;
                    $newUser->tipouser_id=$newTipoUser;
                    $newUser->activo=$newEstado;
                    $newUser->borrado='0';                   

                    $newUser->save();
                    }

                    

                    $msj='Nuevo Usuario del Sistema registrado con éxito';

                }
                else{
                       
                    $editPersona = Persona::findOrFail($idPersona);

                    $editPersona->nombre=$newNombres;
                    $editPersona->direccion=$newDireccion;
                    $editPersona->tipopersona_id=$newTipoPersona;
                    $editPersona->activo='1';
                    $editPersona->borrado='0';

                    $editPersona->save();


                    if(intval($newTipoUser)==4 ){

                        $newUser = new User();

                    $newUser->name=$newUsername;
                    $newUser->email=$newEmail;
                    $newUser->password=bcrypt($newPassword);
                    $newUser->persona_id=$idPersona;
                    $newUser->tipouser_id=$newTipoUser;
                    $newUser->entidad_id=$identidad;
                    $newUser->activo=$newEstado;
                    $newUser->borrado='0';                    

                    $newUser->save();

                    }
                    else{
                        $newUser = new User();

                    $newUser->name=$newUsername;
                    $newUser->email=$newEmail;
                    $newUser->password=bcrypt($newPassword);
                    $newUser->persona_id=$idPersona;
                    $newUser->tipouser_id=$newTipoUser;
                    $newUser->activo=$newEstado;
                    $newUser->borrado='0';                    

                    $newUser->save();
                    }
                 
                    

                    $msj='Nuevo Usuario del Sistema registrado con éxito';
                

            }

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

       $idPersona=$request->idPersona;
       $idUser=$request->idUser;

       $editDNI=$request->editDNI;
       $editNombres=$request->editNombres;
       $editDireccion=$request->editDireccion;
       $editTipoPersona=$request->editTipoPersona;


       $editUsername=$request->editUsername;
       $editEmail=$request->editEmail;
       $editPassword=$request->editPassword;

       $idtipo=$request->idtipo;
       $activo=$request->activo;

       $modifpassword=$request->modifpassword;

       $identidad=$request->identidad;


        $input1  = array('dni' => $editDNI);
        $reglas1 = array('dni' => 'required');

        $input0  = array('dni' => $editDNI);
        $reglas0 = array('dni' => 'unique:personas,dni_ruc,'.$id.',id,borrado,0');

        $input2  = array('nombres' => $editNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('direccion' => $editDireccion);
        $reglas3 = array('direccion' => 'required');

        $validator1 = Validator::make($input1, $reglas1);
        $validator0 = Validator::make($input0, $reglas0);
        $validator2 = Validator::make($input2, $reglas2);
        $validator3 = Validator::make($input3, $reglas3);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del usuario';
            $selector='txtDNIE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del usuario';
            $selector='txtnombresE';
        }elseif (1==2) {
            $result='0';
            $msj='Debe ingresar la Dirección del usuario';
            $selector='txtdireccionE';
        }elseif (strlen($editTipoPersona)==0) {
            $result='0';
            $msj='Debe seleccionar un tipo de persona';
            $selector='cbuTipoPersonaE';
        }
        else{

            $input7  = array('username' => $editUsername);
            $reglas7 = array('username' => 'required');

            $input8  = array('username' => $editUsername);
            $reglas8 = array('username' => 'unique:users,name,'.$idUser.',id,borrado,0');

            $input9  = array('email' => $editEmail);
            $reglas9 = array('email' => 'required');

            $input10  = array('email' => $editEmail);
            $reglas10 = array('email' => 'unique:users,email,'.$idUser.',id,borrado,0');

            $validator7 = Validator::make($input7, $reglas7);
            $validator8 = Validator::make($input8, $reglas8);
            $validator9 = Validator::make($input9, $reglas9);
            $validator10 = Validator::make($input10, $reglas10);

            if(strlen($idtipo)==0){
                $result='0';
                $msj='Debe seleccionar el tipo de usuario';
                $selector='cbuTipoUserE';
            }
            elseif ($validator7->fails())
            {
                $result='0';
                $msj='Debe ingresar un Username válido';
                $selector='txtuserE';
            }elseif ($validator8->fails()) {
                $result='0';
                $msj='El username ya se encuentra registrado, consigne otro';
                $selector='txtuserE';
            }elseif ($validator9->fails()) {
                $result='0';
                $msj='Debe ingresar el email del usuario';
                $selector='txtmailE';
            }elseif ($validator10->fails()) {
                $result='0';
                $msj='El email del usuario ya se encuentra registrado, consigne otro';
                $selector='txtmailE';
            }
            elseif (intval($idtipo)==4 && $identidad=="") {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidadE';
            }elseif (intval($idtipo)==4 && $identidad==null) {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidadE';
            }elseif (intval($idtipo)==4 && strval($identidad)=="null") {
                $result='0';
                $msj='Debe seleccionar la entidad del usuario verificador';
                $selector='cbsEntidadE';
            }
            else
            {

                $editPersona = Persona::findOrFail($idPersona);

                $editPersona->dni_ruc=$editDNI;
                $editPersona->nombre=$editNombres;
                $editPersona->direccion=$editDireccion;
                $editPersona->tipopersona_id=$editTipoPersona;

                $editPersona->save();


                $editUser = User::findOrFail($idUser);

            if(intval($modifpassword)!=2){
                

                if(intval($idtipo)==4){
                    $editUser->name=$editUsername;
                $editUser->email=$editEmail;
                $editUser->activo=$activo;
                $editUser->tipouser_id=$idtipo;
                $editUser->entidad_id=$identidad;

                $editUser->save();
                }
                else{
                    $editUser->name=$editUsername;
                $editUser->email=$editEmail;
                $editUser->activo=$activo;
                $editUser->tipouser_id=$idtipo;
                $editUser->entidad_id=null;

                $editUser->save();
                }

                


            }else{


                if(intval($idtipo)==4){
                    $editUser->name=$editUsername;
              $editUser->email=$editEmail;
              $editUser->password=bcrypt($editPassword);          
              $editUser->activo=$activo;
              $editUser->tipouser_id=$idtipo;
              $editUser->entidad_id=$identidad;

              $editUser->save();
                }
                else{
                    $editUser->name=$editUsername;
              $editUser->email=$editEmail;
              $editUser->password=bcrypt($editPassword);          
              $editUser->activo=$activo;
              $editUser->tipouser_id=$idtipo;
              $editUser->entidad_id=null;

              $editUser->save();
                }
              
          }

          $msj='Usuario modificado con éxito';

      }

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
