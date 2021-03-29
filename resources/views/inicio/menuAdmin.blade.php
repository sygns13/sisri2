<div class="box box-primary panel-group">

    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Menú Principal</h3>

      </div>

      <div class="box-body" style="border: 1px solid #3c8dbc;">

<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MENÚ PRINCIPAL</li>
    <!-- Optionally, you can add icons to the links -->

    
    <li v-bind:class="classMenu0"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Inicio</span></a></li>
  
    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu1">
        <a href="#"><i class='fa fa-list-alt'></i> <span>Tablas Base</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('semestres')}}"><i class='fa fa-gg'></i> Gestión de Semestres</a></li>
            <li><a href="{{URL::to('locales')}}"><i class='fa fa-gg'></i> Gestión de Locales</a></li>
          {{--   <li><a href="entidades"><i class='fa fa-gg'></i> Gestión de Entidades</a></li> --}}
            <li><a href="{{URL::to('facultades')}}"><i class='fa fa-gg'></i> Gestión de Facultades</a></li>
            <li><a href="{{URL::to('escuelas')}}"><i class='fa fa-gg'></i> Gestión de Escuelas</a></li> 
            <li><a href="{{URL::to('departamentoacademicos')}}"><i class='fa fa-gg'></i> Gestión de Departamentos Académicos</a></li> 
            <li><a href="{{URL::to('modalidadadmision')}}"><i class='fa fa-gg'></i> Modalidades de Admisión</a></li> 
         {{--    <li><a href="bancos"><i class='fa fa-gg'></i> Gestión de Bancos</a></li>  --}}{{-- Anio - proveido - prioridad --}}
            {{-- Anio - proveido - prioridad --}}
        </ul>
    </li>
    @endif


 @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu2">
        <a href="#"><i class='fa fa-laptop'></i> <span>Gestión Académica</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('postulantespregrado')}}"><i class='fa fa-gg'></i> Postulantes de Pregrado</a></li>
            <li><a href="{{URL::to('alumnospregrado')}}"><i class='fa fa-gg'></i> Matriculados Pregrado</a></li>
            <li><a href="{{URL::to('alumnosegresadospregrado')}}"><i class='fa fa-gg'></i> Egresados Pregrado</a></li>
            <li><a href="{{URL::to('postulantespostgrado')}}"><i class='fa fa-gg'></i> Postulantes de Postgrado</a></li>
            <li><a href="{{URL::to('alumnospostgrado')}}"><i class='fa fa-gg'></i> Matriculados Postgrado</a></li>
            <li><a href="{{URL::to('alumnosegresadospostgrado')}}"><i class='fa fa-gg'></i> Egresados Posrgrado</a></li>
            <li><a href="{{URL::to('docentes')}}"><i class='fa fa-gg'></i> Docentes</a></li>
        </ul>
    </li>
    @endif



    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu3">
        <a href="'#"><i class='fa fa-graduation-cap'></i> <span>Grados y Títulos</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('bachilleres')}}"><i class='fa fa-gg'></i> Bachilleres</a></li>
            <li><a href="{{URL::to('titulados')}}"><i class='fa fa-gg'></i> Titulados</a></li>
            <li><a href="{{URL::to('maestros')}}"><i class='fa fa-gg'></i> Maestros</a></li>
            <li><a href="{{URL::to('doctores')}}"><i class='fa fa-gg'></i> Doctores</a></li>
        </ul>
    </li>
    @endif


    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu4">
        <a href="#"><i class='fa fa-rocket'></i> <span>Investigación</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('investigadores')}}"><i class='fa fa-gg'></i> Investigadores</a></li>
            <li><a href="{{URL::to('investigaciones')}}"><i class='fa fa-gg'></i> Investigaciones</a></li>
            <li><a href="{{URL::to('tesis')}}"><i class='fa fa-gg'></i> Tesis</a></li>
            <li><a href="{{URL::to('revistas')}}"><i class='fa fa-gg'></i> Revistas y Publicaciones</a></li>
        </ul>
    </li>
    @endif


    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu5">
        <a href="'#"><i class='fa fa-users'></i> <span>Gestión y Soporte</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('administrativos')}}"><i class='fa fa-gg'></i> Administrativos</a></li>
            <li><a href="{{URL::to('locacionservicios')}}"><i class='fa fa-gg'></i> Locación de Servicios</a></li>

        </ul>
    </li>
    @endif

    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu6">
        <a href="#"><i class='fa fa-plus-square'></i> <span>Bienestar Universitario</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('beneficiarioscomedor')}}"><i class='fa fa-gg'></i> Beneficiarios del Comedor</a></li>
            <li><a href="{{URL::to('beneficiariosgym')}}"><i class='fa fa-gg'></i> Beneficiarios del GYM</a></li>
            <li><a href="{{URL::to('beneficiariostalleresdeportivos')}}"><i class='fa fa-gg'></i> Benef Talleres Deportivos</a></li>
            <li><a href="{{URL::to('programassalud')}}"><i class='fa fa-gg'></i> Programas de Salud</a></li>
            <li><a href="{{URL::to('campadbu')}}"><i class='fa fa-gg'></i> Campañas de DBU</a></li>

        </ul>
    </li>
    @endif

    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu7">
        <a href="#"><i class='fa fa-slideshare'></i> <span>Proyección Social</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('proyectos')}}"><i class='fa fa-gg'></i> Camp Itinerantes y Proyectos</a></li>
            <li><a href="{{URL::to('eventosculturales')}}"><i class='fa fa-gg'></i> Eventos Culturales</a></li>
            <li><a href="{{URL::to('talleres')}}"><i class='fa fa-gg'></i> Talleres</a></li>
        </ul>
    </li>
    @endif

    @if(accesoUser([1]))
    <li class="treeview" v-bind:class="classMenu8">
        <a href="#"><i class='fa fa-suitcase'></i> <span>Convenios e Intercambio</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
            <li><a href="{{URL::to('conveniosmarco')}}"><i class='fa fa-gg'></i> Convenios Marco</a></li>
            <li><a href="{{URL::to('conveniosespecificos')}}"><i class='fa fa-gg'></i> Convenios Específicos</a></li>
            <li><a href="{{URL::to('convenioscolaboracion')}}"><i class='fa fa-gg'></i> Convenios de Colaboración</a></li>
            <li><a href="{{URL::to('pasantiasalumnos')}}"><i class='fa fa-gg'></i> Alumnos Pasantías</a></li>
            <li><a href="{{URL::to('pasantiadocentes')}}"><i class='fa fa-gg'></i> Docentes Pasantías</a></li>
            <li><a href="{{URL::to('pasantiaadministrativos')}}"><i class='fa fa-gg'></i> Administrativos Pasantías</a></li>
            <li><a href="{{URL::to('pasantiallegaron')}}"><i class='fa fa-gg'></i> Personas Llegaron UNASAM</a></li>
        </ul>
    </li>
    @endif













    @if(accesoUser([2]))
    @foreach ($permisoModulos as $permisoMod)

    @if($permisoMod->modulo_id==1)
    <li class="treeview" v-bind:class="classMenu1">
            <a href="#"><i class='fa fa-list-alt'></i> <span>Tablas Base</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

            @if($permisoMod->tipo==2)
            <li><a href="{{URL::to('semestres')}}"><i class='fa fa-gg'></i> Gestión de Semestres</a></li>
            <li><a href="{{URL::to('locales')}}"><i class='fa fa-gg'></i> Gestión de Locales</a></li>
            <li><a href="{{URL::to('facultades')}}"><i class='fa fa-gg'></i> Gestión de Facultades</a></li>
            <li><a href="{{URL::to('escuelas')}}"><i class='fa fa-gg'></i> Gestión de Escuelas</a></li> 
            <li><a href="{{URL::to('departamentoacademicos')}}"><i class='fa fa-gg'></i> Gestión de Departamentos Académicos</a></li> 
            <li><a href="{{URL::to('modalidadadmision')}}"><i class='fa fa-gg'></i> Modalidades de Admisión</a></li> 
            @else

            @foreach ($permisoSubModulos as $permiso2)
                @if($permiso2->submodulo_id==1)
                    <li><a href="{{URL::to('semestres')}}"><i class='fa fa-gg'></i> Gestión de Semestres</a></li>
                @endif

                @if($permiso2->submodulo_id==2)
                    <li><a href="{{URL::to('locales')}}"><i class='fa fa-gg'></i> Gestión de Locales</a></li>
                @endif

                @if($permiso2->submodulo_id==3)
                <li><a href="{{URL::to('facultades')}}"><i class='fa fa-gg'></i> Gestión de Facultades</a></li>
                @endif

                @if($permiso2->submodulo_id==4)
                <li><a href="{{URL::to('escuelas')}}"><i class='fa fa-gg'></i> Gestión de Escuelas</a></li> 
                @endif

                @if($permiso2->submodulo_id==6)
                <li><a href="{{URL::to('departamentoacademicos')}}"><i class='fa fa-gg'></i> Gestión de Departamentos Académicos</a></li> 
                @endif

                @if($permiso2->submodulo_id==5)
                <li><a href="{{URL::to('modalidadadmision')}}"><i class='fa fa-gg'></i> Modalidades de Admisión</a></li> 
                @endif
            @endforeach

            @endif

                </ul>
            </li>


    @endif

    @if($permisoMod->modulo_id==2)
    <li class="treeview" v-bind:class="classMenu2">
            <a href="#"><i class='fa fa-laptop'></i> <span>Gestión Académica</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)
                    <li><a href="{{URL::to('postulantespregrado')}}"><i class='fa fa-gg'></i> Postulantes de Pregrado</a></li>
                    <li><a href="{{URL::to('alumnospregrado')}}"><i class='fa fa-gg'></i> Matriculados Pregrado</a></li>
                    <li><a href="{{URL::to('alumnosegresadospregrado')}}"><i class='fa fa-gg'></i> Egresados Pregrado</a></li>
                    <li><a href="{{URL::to('postulantespostgrado')}}"><i class='fa fa-gg'></i> Postulantes de Postgrado</a></li>
                    <li><a href="{{URL::to('alumnospostgrado')}}"><i class='fa fa-gg'></i> Matriculados Postgrado</a></li>
                    <li><a href="{{URL::to('alumnosegresadospostgrado')}}"><i class='fa fa-gg'></i> Egresados Posrgrado</a></li>
                    <li><a href="{{URL::to('docentes')}}"><i class='fa fa-gg'></i> Docentes</a></li>

                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==6)
                        <li><a href="{{URL::to('postulantespregrado')}}"><i class='fa fa-gg'></i> Postulantes de Pregrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==7)
                        <li><a href="{{URL::to('alumnospregrado')}}"><i class='fa fa-gg'></i> Matriculados Pregrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==8)
                        <li><a href="{{URL::to('alumnosegresadospregrado')}}"><i class='fa fa-gg'></i> Egresados Pregrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==9)
                        <li><a href="{{URL::to('postulantespostgrado')}}"><i class='fa fa-gg'></i> Postulantes de Postgrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==10)
                        <li><a href="{{URL::to('alumnospostgrado')}}"><i class='fa fa-gg'></i> Matriculados Postgrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==11)
                        <li><a href="{{URL::to('alumnosegresadospostgrado')}}"><i class='fa fa-gg'></i> Egresados Posrgrado</a></li>
                        @endif

                        @if($permiso2->submodulo_id==12)
                        <li><a href="{{URL::to('docentes')}}"><i class='fa fa-gg'></i> Docentes</a></li>
                        @endif
                    @endforeach

                    @endif

            </ul>
    </li>


    @endif
    
    @if($permisoMod->modulo_id==3)
    <li class="treeview" v-bind:class="classMenu3">
            <a href="'#"><i class='fa fa-graduation-cap'></i> <span>Grados y Títulos</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)
                    <li><a href="{{URL::to('bachilleres')}}"><i class='fa fa-gg'></i> Bachilleres</a></li>
                    <li><a href="{{URL::to('titulados')}}"><i class='fa fa-gg'></i> Titulados</a></li>
                    <li><a href="{{URL::to('maestros')}}"><i class='fa fa-gg'></i> Maestros</a></li>
                    <li><a href="{{URL::to('doctores')}}"><i class='fa fa-gg'></i> Doctores</a></li>
                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==13)
                        <li><a href="{{URL::to('bachilleres')}}"><i class='fa fa-gg'></i> Bachilleres</a></li>
                        @endif

                        @if($permiso2->submodulo_id==14)
                        <li><a href="{{URL::to('titulados')}}"><i class='fa fa-gg'></i> Titulados</a></li>
                        @endif

                        @if($permiso2->submodulo_id==15)
                        <li><a href="{{URL::to('maestros')}}"><i class='fa fa-gg'></i> Maestros</a></li>
                        @endif

                        @if($permiso2->submodulo_id==16)
                        <li><a href="{{URL::to('doctores')}}"><i class='fa fa-gg'></i> Doctores</a></li>
                        @endif


                    @endforeach

                    @endif

            </ul>
        </li>
    @endif

    @if($permisoMod->modulo_id==4)
    <li class="treeview" v-bind:class="classMenu4">
            <a href="#"><i class='fa fa-rocket'></i> <span>Investigación</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)
                    <li><a href="{{URL::to('investigadores')}}"><i class='fa fa-gg'></i> Investigadores</a></li>
                    <li><a href="{{URL::to('investigaciones')}}"><i class='fa fa-gg'></i> Investigaciones</a></li>
                    <li><a href="{{URL::to('tesis')}}"><i class='fa fa-gg'></i> Tesis</a></li>
                    <li><a href="{{URL::to('revistas')}}"><i class='fa fa-gg'></i> Revistas y Publicaciones</a></li>
                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==17)
                        <li><a href="{{URL::to('investigadores')}}"><i class='fa fa-gg'></i> Investigadores</a></li>
                        @endif

                        @if($permiso2->submodulo_id==18)
                        <li><a href="{{URL::to('investigaciones')}}"><i class='fa fa-gg'></i> Investigaciones</a></li>
                        @endif

                        @if($permiso2->submodulo_id==19)
                        <li><a href="{{URL::to('tesis')}}"><i class='fa fa-gg'></i> Tesis</a></li>
                        @endif

                        @if($permiso2->submodulo_id==20)
                        <li><a href="{{URL::to('revistas')}}"><i class='fa fa-gg'></i> Revistas y Publicaciones</a></li>
                        @endif


                    @endforeach

                    @endif



            </ul>
        </li>
    @endif

    @if($permisoMod->modulo_id==5)
    <li class="treeview" v-bind:class="classMenu5">
            <a href="'#"><i class='fa fa-users'></i> <span>Gestión y Soporte</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)

                    <li><a href="{{URL::to('administrativos')}}"><i class='fa fa-gg'></i> Administrativos</a></li>
                    <li><a href="{{URL::to('locacionservicios')}}"><i class='fa fa-gg'></i> Locación de Servicios</a></li>
                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==21)
                        <li><a href="{{URL::to('administrativos')}}"><i class='fa fa-gg'></i> Administrativos</a></li>
                        @endif

                        @if($permiso2->submodulo_id==22)
                        <li><a href="{{URL::to('locacionservicios')}}"><i class='fa fa-gg'></i> Locación de Servicios</a></li>
                        @endif



                    @endforeach

                    @endif

            </ul>
        </li>
    @endif

    @if($permisoMod->modulo_id==6)
    <li class="treeview" v-bind:class="classMenu6">
            <a href="#"><i class='fa fa-plus-square'></i> <span>Bienestar Universitario</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">


                    @if($permisoMod->tipo==2)

                    <li><a href="{{URL::to('beneficiarioscomedor')}}"><i class='fa fa-gg'></i> Beneficiarios del Comedor</a></li>
                    <li><a href="{{URL::to('beneficiariosgym')}}"><i class='fa fa-gg'></i> Beneficiarios del GYM</a></li>
                    <li><a href="{{URL::to('beneficiariostalleresdeportivos')}}"><i class='fa fa-gg'></i> Benef Talleres Deportivos</a></li>
                    <li><a href="{{URL::to('programassalud')}}"><i class='fa fa-gg'></i> Programas de Salud</a></li>
                    <li><a href="{{URL::to('campadbu')}}"><i class='fa fa-gg'></i> Campañas de DBU</a></li>

                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==23)
                        <li><a href="{{URL::to('beneficiarioscomedor')}}"><i class='fa fa-gg'></i> Beneficiarios del Comedor</a></li>
                        @endif

                        @if($permiso2->submodulo_id==24)
                        <li><a href="{{URL::to('beneficiariosgym')}}"><i class='fa fa-gg'></i> Beneficiarios del GYM</a></li>
                        @endif

                        @if($permiso2->submodulo_id==25)
                        <li><a href="{{URL::to('beneficiariostalleresdeportivos')}}"><i class='fa fa-gg'></i> Benef Talleres Deportivos</a></li>
                        @endif

                        @if($permiso2->submodulo_id==26)
                        <li><a href="{{URL::to('programassalud')}}"><i class='fa fa-gg'></i> Programas de Salud</a></li>
                        @endif

                        @if($permiso2->submodulo_id==27)
                        <li><a href="{{URL::to('campadbu')}}"><i class='fa fa-gg'></i> Campañas de DBU</a></li>
                        @endif



                    @endforeach

                    @endif


                    


            </ul>
        </li>
    @endif

    @if($permisoMod->modulo_id==7)
    <li class="treeview" v-bind:class="classMenu7">
            <a href="#"><i class='fa fa-slideshare'></i> <span>Proyección Social</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)

                    <li><a href="{{URL::to('proyectos')}}"><i class='fa fa-gg'></i> Camp Itinerantes y Proyectos</a></li>
                    <li><a href="{{URL::to('eventosculturales')}}"><i class='fa fa-gg'></i> Eventos Culturales</a></li>
                    <li><a href="{{URL::to('talleres')}}"><i class='fa fa-gg'></i> Talleres</a></li>

                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==28)
                        <li><a href="{{URL::to('proyectos')}}"><i class='fa fa-gg'></i> Camp Itinerantes y Proyectos</a></li>
                        @endif

                        @if($permiso2->submodulo_id==29)
                        <li><a href="{{URL::to('eventosculturales')}}"><i class='fa fa-gg'></i> Eventos Culturales</a></li>
                        @endif

                        @if($permiso2->submodulo_id==30)
                        <li><a href="{{URL::to('talleres')}}"><i class='fa fa-gg'></i> Talleres</a></li>
                        @endif

                    @endforeach

                    @endif



            </ul>
        </li>
    @endif

    @if($permisoMod->modulo_id==8)
    <li class="treeview" v-bind:class="classMenu8">
            <a href="#"><i class='fa fa-suitcase'></i> <span>Convenios e Intercambio</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">

                    @if($permisoMod->tipo==2)

                    <li><a href="{{URL::to('conveniosmarco')}}"><i class='fa fa-gg'></i> Convenios Marco</a></li>
                    <li><a href="{{URL::to('conveniosespecificos')}}"><i class='fa fa-gg'></i> Convenios Específicos</a></li>
                    <li><a href="{{URL::to('convenioscolaboracion')}}"><i class='fa fa-gg'></i> Convenios de Colaboración</a></li>
                    <li><a href="{{URL::to('pasantiasalumnos')}}"><i class='fa fa-gg'></i> Alumnos Pasantías</a></li>
                    <li><a href="{{URL::to('pasantiadocentes')}}"><i class='fa fa-gg'></i> Docentes Pasantías</a></li>
                    <li><a href="{{URL::to('pasantiaadministrativos')}}"><i class='fa fa-gg'></i> Administrativos Pasantías</a></li>
                    <li><a href="{{URL::to('pasantiallegaron')}}"><i class='fa fa-gg'></i> Personas Llegaron UNASAM</a></li>

                    @else

                    @foreach ($permisoSubModulos as $permiso2)
                        @if($permiso2->submodulo_id==31)
                        <li><a href="{{URL::to('conveniosmarco')}}"><i class='fa fa-gg'></i> Convenios Marco</a></li>
                        @endif

                        @if($permiso2->submodulo_id==32)
                        <li><a href="{{URL::to('conveniosespecificos')}}"><i class='fa fa-gg'></i> Convenios Específicos</a></li>
                        @endif

                        @if($permiso2->submodulo_id==33)
                        <li><a href="{{URL::to('convenioscolaboracion')}}"><i class='fa fa-gg'></i> Convenios de Colaboración</a></li>
                        @endif

                        @if($permiso2->submodulo_id==34)
                        <li><a href="{{URL::to('pasantiasalumnos')}}"><i class='fa fa-gg'></i> Alumnos Pasantías</a></li>
                        @endif

                        @if($permiso2->submodulo_id==35)
                        <li><a href="{{URL::to('pasantiadocentes')}}"><i class='fa fa-gg'></i> Docentes Pasantías</a></li>
                        @endif

                        @if($permiso2->submodulo_id==36)
                        <li><a href="{{URL::to('pasantiaadministrativos')}}"><i class='fa fa-gg'></i> Administrativos Pasantías</a></li>
                        @endif

                        @if($permiso2->submodulo_id==37)
                        <li><a href="{{URL::to('pasantiallegaron')}}"><i class='fa fa-gg'></i> Personas Llegaron UNASAM</a></li>
                        @endif

                    @endforeach

                    @endif



            </ul>
        </li>
    @endif

        
    @endforeach
    @endif


    <li class="treeview" v-bind:class="classMenu9">
        <a href="#"><i class='fa fa-cogs'></i> <span>Configuraciones</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
                @if(accesoUser([1]))<li><a href="usuarios"><i class='fa fa-gg'></i> Gestión de Usuarios</a></li>@endif
            <li><a href="miperfil"><i class='fa fa-gg'></i> Mi Perfil</a></li>
            <li><a href="salir" ><i class='fa fa-gg'></i> <b>Cerrar Sesión</b></a></li>
        </ul>
    </li>



</ul>


</div>
      
</div>
  {{--   @if(accesoUser([1,2,3]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Recibos</h3>

              <p>Emisión de Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
 			<i class="fa fa-credit-card"></i> 
            </div>
            <a href="recibos" id="recibosH" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->

        @if(accesoUser([1,2,3]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Recibos Emitidos</h3>

              <p>Listado de Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-newspaper-o"></i>
            </div>
		  <a href="recibosemitidos" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
		   </div>
        </div>
@endif



@if(accesoUser([1,2,4]))
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-purple" style="box-shadow: 0px 10px 30px 0px #8d8686;">
    <div class="inner">
      <h3 style="font-size: 30px">Procesar Recibos</h3>

      <p>Proceso de Recibos Emitidos</p>
    </div>
    <div class="icon" style="top: 7px;">
<i class="fa fa-cogs"></i> 
    </div>
    <a href="procesar" id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
  </div>
</div>

@endif


@if(accesoUser([1,2,4]))
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-Teal" style="box-shadow: 0px 10px 30px 0px #8d8686;">
    <div class="inner">
      <h3 style="font-size: 30px">Recibos Procesados</h3>

      <p>Listado de Recibos Procesados</p>
    </div>
    <div class="icon" style="top: 7px;">
<i class="fa fa-cogs"></i> 
    </div>
    <a href="recibosprocesados" id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
  </div>
</div>

@endif



@if(accesoUser([1]))

        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-yellow" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Usuarios</h3>

              <p>Gestión de Usuarios</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-fax"></i>
            </div>
			<a href="usuarios" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->

@if(accesoUser([1,2,5]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Reportes Generales</h3>

              <p>Ver Reportes </p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-file-pdf-o"></i>
            </div>
			<a href="reportesgenerales" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>
@endif

@if(accesoUser([1,2,5]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Reportes Específicos</h3>

              <p>Ver Reportes</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-print"></i>
            </div>
			<a href="reportedestallados" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->
 

@if(accesoUser([1]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-Navy" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Auditoría de Recibos</h3>

              <p>Auditar Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-search-plus"></i>
            </div>
			<a href="auditarrecibos" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif --}}