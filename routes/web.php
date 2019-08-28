<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('login');
});



Route::group(['middleware' => 'auth'], function () {
   
 /*   Route::get('send','mailController@send');
    Route::get('sendSMS','SmsController@sendSms');*/


    Route::get('salir', function () {
        //return view('welcome');
        Auth::logout();
        return redirect('login');
    });


    Route::get('semestres','SemestreController@index1');
    Route::get('locales','LocalController@index1');
    Route::get('facultades','FacultadController@index1');
    Route::get('escuelas','EscuelaController@index1');
    Route::get('datosfacultad/{id}','DatosfacultadController@index1');
    Route::get('modalidadadmision','ModalidadadmisionController@index1');
    Route::get('postulantespregrado','PostulanteController@index1');



    Route::resource('semestre','SemestreController');
    Route::resource('local','LocalController');
    Route::resource('pais','PaiseController');
    Route::resource('facultad','FacultadController');
    Route::resource('escuela','EscuelaController');
    Route::resource('datosfacultad','DatosfacultadController');
    Route::resource('modadmision','ModalidadadmisionController');
    Route::resource('postulantes','PostulanteController');



    Route::get('semestre/activar/{id}/{var}','SemestreController@activar');
    Route::get('local/altabaja/{id}/{var}','LocalController@altabaja');
    Route::get('local/cambiarPais/{var}','LocalController@cambiarPais');
    Route::get('local/cambiarDepartamento/{var}','LocalController@cambiarDepartamento');
    Route::get('local/cambiarProvincia/{var}','LocalController@cambiarProvincia');
    Route::get('facultad/altabaja/{id}/{var}','FacultadController@altabaja');
    Route::get('escuela/altabaja/{id}/{var}','EscuelaController@altabaja');
    Route::get('modadmision/altabaja/{id}/{var}','ModalidadadmisionController@altabaja');
    Route::get('postulantes/altabaja/{id}/{var}','PostulanteController@altabaja');


    
 /*    
    Route::get('entidades','EntidadController@index1');
    
   
    Route::get('bancos','BancoController@index1');
    Route::get('categorias','CategoriaController@index1');
    Route::get('rubros','RubroController@index1');
    Route::get('precios','PrecioController@index1');
    Route::get('personas','PersonaController@index1');
    Route::get('recibos','ReciboController@index1');
    Route::get('recibosemitidos','Detalle_reciboController@index1');
    Route::get('reportesgenerales','ReporteGeneralController@index1');
    Route::get('reportedestallados','ReporteDetalladoController@index1');
    Route::get('usuarios','UserController@index1');
    Route::get('reporteslocales','LocalController@index2');
    Route::get('reportesentidades','EntidadController@index2');
    Route::get('reportescategorias','CategoriaController@index2');
    Route::get('reportesrubros','RubroController@index2');
    Route::get('reportesprecios','PrecioController@index2');
    Route::get('reportespersonas','PersonaController@index2');
    Route::get('miperfil','UserController@index2');
    Route::get('procesar','ReciboController@index2');
    Route::get('recibosprocesados','ReporteDetalladoController@index2');
    Route::get('auditarrecibos','ReciboController@indexAudi');


    
    Route::resource('entidad','EntidadController');
    
   
    Route::resource('banco','BancoController');
    Route::resource('categoria','CategoriaController');
    Route::resource('rubro','RubroController');
    Route::resource('precio','PrecioController');
    Route::resource('persona','PersonaController');
    Route::resource('recibo','ReciboController');
    Route::resource('reciboemitido','Detalle_reciboController');
    Route::resource('reportegeneral','ReporteGeneralController');
    Route::resource('reportedetallado','ReporteDetalladoController');
    Route::resource('usuario','UserController');
    Route::resource('proceso','DetalleReciboController');
    


    
    Route::get('entidad/altabaja/{id}/{var}','EntidadController@altabaja');
    
    
    Route::get('banco/altabaja/{id}/{var}','BancoController@altabaja');
    Route::get('categoria/altabaja/{id}/{var}','CategoriaController@altabaja');
    Route::get('rubro/altabaja/{id}/{var}','RubroController@altabaja');
    Route::get('precio/altabaja/{id}/{var}','PrecioController@altabaja');
    Route::get('persona/altabaja/{id}/{var}','PersonaController@altabaja');
    Route::get('reciboemitido/altabaja/{id}/{var}','Detalle_reciboController@altabaja');
    Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
    Route::get('usuario/verpersona/{dni}','UserController@verpersona');
    Route::get('reportedetallado/cambiarlocal/{var}','ReporteDetalladoController@cambiarlocal');
    Route::get('reportedetallado/cambiarcategoria/{var}','ReporteDetalladoController@cambiarcategoria');
    Route::get('reportedetallado/cambiarrubro/{var}','ReporteDetalladoController@cambiarrubro');
    Route::get('proceso/altabaja/{id}/{var}','DetalleReciboController@altabaja');
    Route::get('procesogetinfo','DetalleReciboController@getinfo');


    Route::post('recibo/buscarpersona','ReciboController@buscarpersona');
    Route::post('reciboemitido/buscarrecibo','Detalle_reciboController@buscarrecibo');
    Route::post('reportegeneral/buscarDatos','ReporteGeneralController@buscarDatos');
    Route::post('reportegeneral/buscarDatosImp','ReporteGeneralController@buscarDatosImp');
    Route::post('reportedetallado/buscarDatos','ReporteDetalladoController@buscarDatos');
    Route::post('reportedetallado/buscarDatosImp','ReporteDetalladoController@buscarDatosImp');
    Route::post('local/buscarDatosImp','LocalController@buscarDatosImp');
    Route::post('entidad/buscarDatosImp','EntidadController@buscarDatosImp');
    Route::post('categoria/buscarDatosImp','CategoriaController@buscarDatosImp');
    Route::post('precio/buscarDatosImp','PrecioController@buscarDatosImp');
    Route::post('persona/buscarDatosImp','PersonaController@buscarDatosImp');
    Route::post('usuario/miperfil','UserController@miperfil');
    Route::post('usuario/modificarclave','UserController@modificarclave');

    Route::post('proceso/buscarDatos','DetalleReciboController@buscarDatos');
    Route::post('proceso/buscarDatosImp','DetalleReciboController@buscarDatosImp');
    Route::post('auditarrecibo','ReciboController@auditarrecibo'); */
});
