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
    Route::get('departamentoacademicos','DepartamentoacademicoController@index1');
    Route::get('datosfacultad/{id}','DatosfacultadController@index1');
    Route::get('modalidadadmision','ModalidadadmisionController@index1');
    Route::get('postulantespregrado','PostulanteController@index1');
    Route::get('alumnospregrado','AlumnoController@index1');
    Route::get('alumnosegresadospregrado','AlumnoController@index2');
    Route::get('postulantespostgrado','PostulanteController@index2');
    Route::get('alumnospostgrado','AlumnoController@index3');
    Route::get('alumnosegresadospostgrado','AlumnoController@index4');
    Route::get('docentes','DocenteController@index1');
    Route::get('bachilleres','GraduadoController@index1');
    Route::get('titulados','GraduadoController@index2');
    Route::get('maestros','GraduadoController@index3');
    Route::get('doctores','GraduadoController@index4');
    Route::get('tesisinfo','TesisController@index1');
    Route::get('revistaspublicaciones','RevistapublicacionController@index1');
    Route::get('administrativos','AdministrativoController@index1');
    Route::get('locacionservicios','AdminlocacionController@index1');
    Route::get('beneficiarioscomedor','BeneficiarioscomedorController@index1');
    Route::get('beneficiariosgym','BeneficiariosgymController@index1');
    Route::get('beneficiariostalleresdeportivos','BeneficiariostalldeportivoController@index1');
    Route::get('pasantiasalumnos','PasantiaController@index1');
    Route::get('pasantiadocentes','PasantiaController@index2');
    Route::get('pasantiaadministrativos','PasantiaController@index3');
    Route::get('pasantiallegaron','PasantiaController@index4');
    Route::get('conveniosmarco','ConvenioController@index1');
    Route::get('conveniosespecificos','ConvenioController@index2');
    Route::get('convenioscolaboracion','ConvenioController@index3');
    Route::get('programassalud','ProgramassaludController@index1');
    Route::get('campadbu','ProgramassaludController@index2');
    Route::get('medicos/{idprogramasalud}','MedicoController@index1');
    Route::get('beneficiarios/{idprogramasalud}','BeneficiarioController@index1');
    Route::get('atencionsalud/{idprogramasalud}','AtencionController@index1');
    Route::get('proyectos','ProyectoController@index1');
    Route::get('eventosculturales','EventoculturalController@index1');
    Route::get('talleresparticipantes/{idprogramasalud}','TalleresparticipanteController@index1');
    Route::get('talleres','TallerController@index1');
    Route::get('participantes/{idtaller}','ParticipanteController@index1');
    Route::get('presentaciones/{idtaller}','PresentacionController@index1');
    Route::get('investigadores','InvestigadorController@index1');
    Route::get('investigaciones','InvestigacionController@index1');
    Route::get('usuarios','UserController@index1');
    Route::get('miperfil','UserController@index2');
    Route::get('condicion','CondicionsocioeconomicaController@index1');
    Route::get('actividades','ActividadesController@index1');
    Route::get('programacion','ProgramacionController@index1');
    Route::get('prorrogas','ProrrogaController@index1');
    
    
    Route::resource('semestre','SemestreController');
    Route::resource('local','LocalController');
    Route::resource('pais','PaiseController');
    Route::resource('facultad','FacultadController');
    Route::resource('escuela','EscuelaController');
    Route::resource('departamentoacademico','DepartamentoacademicoController');
    Route::resource('datosfacultad','DatosfacultadController');
    Route::resource('modadmision','ModalidadadmisionController');
    Route::resource('postulantes','PostulanteController');
    Route::resource('alumnopregrado','AlumnoController');
    Route::resource('docente','DocenteController');
    Route::resource('graduado','GraduadoController');
    
    Route::resource('administrativo','AdministrativoController');
    Route::resource('locacionservicio','AdminlocacionController');
    
    Route::resource('benefcomedor','BeneficiarioscomedorController');
    Route::resource('benefgym','BeneficiariosgymController');
    Route::resource('beneftalldep','BeneficiariostalldeportivoController');
    
    Route::resource('pasantia','PasantiaController');
    Route::resource('convenio','ConvenioController');
    
    Route::resource('programasalud','ProgramassaludController');
    Route::resource('medico','MedicoController');
    Route::resource('beneficiario','BeneficiarioController');
    Route::resource('atencion','AtencionController');
    Route::resource('proyecto','ProyectoController');
    Route::resource('evento','EventoculturalController');
    Route::resource('talleresparticipante','TalleresparticipanteController');
    Route::resource('taller','TallerController');
    Route::resource('participante','ParticipanteController');
    Route::resource('presentacion','PresentacionController');
    
    Route::resource('investigador','InvestigadorController');
    Route::resource('investigacions','InvestigacionController');
    
    Route::resource('usuario','UserController');
    Route::resource('permiso','PermisoController');
    Route::resource('detalleInvestigacion','DetalleinvestigacionController');
    Route::resource('publicacion','PublicacionController');
    Route::resource('tesisresource','TesisController');
    Route::resource('revistasPubli','RevistapublicacionController');
    Route::resource('autor','AutorController');

    Route::resource('condicioneconomica','CondicionsocioeconomicaController');
    Route::resource('actividad','ActividadesController');
    Route::resource('programacions','ProgramacionController');
    Route::resource('prorroga','ProrrogaController');
    
    
    
    
    
    Route::get('semestre/activar/{id}/{var}','SemestreController@activar');
    Route::get('local/altabaja/{id}/{var}','LocalController@altabaja');
    Route::get('local/cambiarPais/{var}','LocalController@cambiarPais');
    Route::get('local/cambiarDepartamento/{var}','LocalController@cambiarDepartamento');
    Route::get('local/cambiarProvincia/{var}','LocalController@cambiarProvincia');
    Route::get('facultad/altabaja/{id}/{var}','FacultadController@altabaja');
    Route::get('escuela/altabaja/{id}/{var}','EscuelaController@altabaja');
    Route::get('departamentoacademico/altabaja/{id}/{var}','DepartamentoacademicoController@altabaja');
    Route::get('modadmision/altabaja/{id}/{var}','ModalidadadmisionController@altabaja');
    Route::get('permisoDelete/{id1}/{id2}/{var}/{var2}','PermisoController@delete');

    Route::get('investigadores/obtenerDatos','InvestigadorController@obtenerDatos');
    Route::get('investigaciones/obtenerAutors/{var}','InvestigacionController@obtenerAutors');
    Route::get('investigaciones/obtenerPublicacion/{var}','InvestigacionController@obtenerPublicacion');
    Route::get('personas/obtenerDatos','PersonaController@obtenerDatos');
    Route::get('personas/obtenerAutors/{var}','PersonaController@obtenerAutors');

    Route::get('programacion/altabaja/{id}/{var}','ProgramacionController@altabaja');
    



    Route::post('persona/buscarDNI','PersonaController@buscarDNI');
    Route::get('postulantes/imprimirExcel/{var1}','PostulanteController@imprimirExcel');

    Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
    Route::get('usuario/verpersona/{dni}','UserController@verpersona');
    Route::post('usuario/miperfil','UserController@miperfil');
    Route::post('usuario/modificarclave','UserController@modificarclave');


    Route::post('postulantespregrado/importardata','PostulanteController@importarArchivo');
    Route::post('alumnopregradoR/importardata1','AlumnoController@importarArchivo1');
    Route::post('alumnopregradoR/importardata2','AlumnoController@importarArchivo2');
    Route::post('postulantesR/importardata','PostulanteController@importarArchivo2');
    Route::post('alumnopostgradoR/importardata1','AlumnoController@importarArchivo3');
    Route::post('alumnopostgradoR/importardata2','AlumnoController@importarArchivo4');
    Route::post('docentes/importardata','DocenteController@importarArchivo');
    Route::post('bachiller/importardata1','GraduadoController@importarArchivo1');
    Route::post('titulado/importardata2','GraduadoController@importarArchivo2');
    Route::post('maestro/importardata3','GraduadoController@importarArchivo3');
    Route::post('doctor/importardata4','GraduadoController@importarArchivo4');
    Route::post('administrativoR/importardata1','AdministrativoController@importarArchivo1');
    Route::post('locacionservicioR/importardata1','AdminlocacionController@importarArchivo1');






    Route::get('postulantespregrado/exportarExcel','PostulanteController@descargarExcel');
    Route::get('docentes/exportarExcel','DocenteController@descargarExcel');
    Route::get('alumnopregradoR/exportarExcel','AlumnoController@descargarExcel');
    Route::get('alumnopregradoR/exportarExcel2','AlumnoController@descargarExcel2');
    Route::get('postulantesR/exportarExcel','PostulanteController@descargarExcel2');
    Route::get('alumnopostgradoR/exportarExcel','AlumnoController@descargarExcel3');
    Route::get('alumnopostgradoR/exportarExcel2','AlumnoController@descargarExcel4');
    Route::get('bachilleres/exportarExcel','GraduadoController@descargarExcel');
    Route::get('titulados/exportarExcel2','GraduadoController@descargarExcel2');
    Route::get('maestros/exportarExcel3','GraduadoController@descargarExcel3');
    Route::get('doctores/exportarExcel4','GraduadoController@descargarExcel4');
    Route::get('investigadores/exportarExcel','InvestigadorController@descargarExcel');
    Route::get('investigaciones/exportarExcel','InvestigacionController@descargarExcel');
    Route::get('tesisinfo/exportarExcel','TesisController@descargarExcel');
    Route::get('revistaspublicaciones/exportarExcel','RevistapublicacionController@descargarExcel');
    Route::get('administrativos/exportarExcel','AdministrativoController@descargarExcel');
    Route::get('locacionservicios/exportarExcel','AdminlocacionController@descargarExcel');
    Route::get('beneficiarioscomedor/exportarExcel','BeneficiarioscomedorController@descargarExcel');
    Route::get('beneficiariosgym/exportarExcel','BeneficiariosgymController@descargarExcel');
    Route::get('beneficiariostalleresdeportivos/exportarExcel','BeneficiariostalldeportivoController@descargarExcel');
    Route::get('programassalud/exportarExcel','ProgramassaludController@descargarExcel');
    Route::get('medicosR/exportarExcel','MedicoController@descargarExcel');
    Route::get('beneficiariosR/exportarExcel','BeneficiarioController@descargarExcel');
    Route::get('atencionsaludR/exportarExcel','AtencionController@descargarExcel');
    Route::get('campadbu/exportarExcel','ProgramassaludController@descargarExcel2');
    Route::get('proyectos/exportarExcel','ProyectoController@descargarExcel');
    Route::get('eventosculturales/exportarExcel','EventoculturalController@descargarExcel');
    Route::get('talleresparticipantesR/exportarExcel','TalleresparticipanteController@descargarExcel');
    Route::get('talleres/exportarExcel','TallerController@descargarExcel');
    Route::get('participantesR/exportarExcel','ParticipanteController@descargarExcel');
    Route::get('presentacionesR/exportarExcel','PresentacionController@descargarExcel');
    Route::get('conveniosmarco/exportarExcel','ConvenioController@descargarExcel');
    Route::get('conveniosespecificos/exportarExcel2','ConvenioController@descargarExcel2');
    Route::get('convenioscolaboracion/exportarExcel3','ConvenioController@descargarExcel3');
    Route::get('pasantiasalumnos/exportarExcel','PasantiaController@descargarExcel');
    Route::get('pasantiadocentes/exportarExcel2','PasantiaController@descargarExcel2');
    Route::get('pasantiaadministrativos/exportarExcel3','PasantiaController@descargarExcel3');
    Route::get('pasantiallegaron/exportarExcel4','PasantiaController@descargarExcel4');

    Route::get('semestres/exportarExcel','SemestreController@descargarExcel');
    Route::get('locales/exportarExcel','LocalController@descargarExcel');
    Route::get('facultades/exportarExcel','FacultadController@descargarExcel');
    Route::get('escuelas/exportarExcel','EscuelaController@descargarExcel');
    Route::get('departamentoacademicos/exportarExcel','DepartamentoacademicoController@descargarExcel');
    Route::get('modalidadadmision/exportarExcel','ModalidadadmisionController@descargarExcel');
    Route::get('condicion/exportarExcel','CondicionsocioeconomicaController@descargarExcel');
    Route::get('actividades/exportarExcel','ActividadesController@descargarExcel');
    
 
});
