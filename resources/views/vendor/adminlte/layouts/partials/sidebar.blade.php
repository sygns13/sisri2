<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

            <div class="no-print user-panel-unasam">
                    <div class="no-print image" style="text-align: center;">
                        <img src="{{asset('/img/unasam.png')}}"  alt="User Image" style="margin-top: 15px;height: 60px;" />
                        <ul class="no-print sidebar-menu">
                        <li class="no-print stroke treeview" style="font-family: Monotype Corsiva;font-size: 21px;color: #f9c52c;margin-top: 5px;">"Una Nueva Universidad<br>Para el Desarrollo"</li>
                        </ul>
                    </div>
                </div>

                <hr style="border-top: 1px solid #4d4d4d;">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
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
                    <li><a href="{{URL::to('tesisinfo')}}"><i class='fa fa-gg'></i> Tesis</a></li>
                    <li><a href="{{URL::to('revistaspublicaciones')}}"><i class='fa fa-gg'></i> Revistas y Publicaciones</a></li>
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
                            <li><a href="{{URL::to('tesisinfo')}}"><i class='fa fa-gg'></i> Tesis</a></li>
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
                                <li><a href="{{URL::to('tesisinfo')}}"><i class='fa fa-gg'></i> Tesis</a></li>
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
       


        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
