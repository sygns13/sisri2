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
          
            @if(accesoUser([1,2]))
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

         @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu2">
                <a href="#"><i class='fa fa-laptop'></i> <span>Gestión Académica</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="postulantespregrado"><i class='fa fa-gg'></i> Postulantes de Pregrado</a></li>
                    <li><a href="alumnospregrado"><i class='fa fa-gg'></i> Matriculados Pregrado</a></li>
                    <li><a href="alumnosegresadospregrado"><i class='fa fa-gg'></i> Egresados Pregrado</a></li>
                    <li><a href="postulantespostgrado"><i class='fa fa-gg'></i> Postulantes de Postgrado</a></li>
                    <li><a href="alumnospostgrado"><i class='fa fa-gg'></i> Matriculados Postgrado</a></li>
                    <li><a href="alumnosegresadospostgrado"><i class='fa fa-gg'></i> Egresados Posrgrado</a></li>
                    <li><a href="docentes"><i class='fa fa-gg'></i> Docentes</a></li>
                </ul>
            </li>
            @endif



            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu3">
                <a href="#"><i class='fa fa-graduation-cap'></i> <span>Grados y Títulos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="bachilleres"><i class='fa fa-gg'></i> Bachilleres</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Titulados</a></li>
                    <li><a href="maestros"><i class='fa fa-gg'></i> Maestros</a></li>
                    <li><a href="doctores"><i class='fa fa-gg'></i> Doctores</a></li>
                </ul>
            </li>
            @endif


            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu4">
                <a href="#"><i class='fa fa-rocket'></i> <span>Investigación</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="investigadores"><i class='fa fa-gg'></i> Investigadores</a></li>
                    <li><a href="investigaciones"><i class='fa fa-gg'></i> Investigaciones</a></li>
                    <li><a href="tesis"><i class='fa fa-gg'></i> Tesis</a></li>
                    <li><a href="revistas"><i class='fa fa-gg'></i> Revistas y Publicaciones</a></li>
                </ul>
            </li>
            @endif


            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu5">
                <a href="#"><i class='fa fa-users'></i> <span>Gestión y Soporte</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="bachilleres"><i class='fa fa-gg'></i> Administrativos</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Locación de Servicios</a></li>

                </ul>
            </li>
            @endif

            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu6">
                <a href="#"><i class='fa fa-plus-square'></i> <span>Bienestar Universitario</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="bachilleres"><i class='fa fa-gg'></i> Beneficiarios del Comedor</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Beneficiarios del GYM</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Beneficiarios de Talleres Deportivos</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Programas de Salud</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Campalas de DBU</a></li>

                </ul>
            </li>
            @endif

            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu7">
                <a href="#"><i class='fa fa-slideshare'></i> <span>Proyección Social</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="bachilleres"><i class='fa fa-gg'></i> Lista de Proyectos</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Eventos Culturales</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Talleres</a></li>
                </ul>
            </li>
            @endif

            @if(accesoUser([1,2]))
            <li class="treeview" v-bind:class="classMenu8">
                <a href="#"><i class='fa fa-suitcase'></i> <span>Convenios e Intercambio</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="bachilleres"><i class='fa fa-gg'></i> Convenios Marco</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Convenios Específicos</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Convenios de Colaboración</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Alumnos Pasantías</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Docentes Pasantías</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Administrativos Pasantías</a></li>
                    <li><a href="titulados"><i class='fa fa-gg'></i> Personas Llegaron UNASAM</a></li>
                </ul>
            </li>
            @endif


  {{--  
            @if(accesoUser([1,2,3]))
            <li class="treeview" v-bind:class="classMenu3">
                    <a href="#"><i class='fa fa-edit'></i> <span>Emisión</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="recibos"><i class='fa fa-gg'></i> Emitir Recibos</a></li>
                        <li><a href="recibosemitidos"><i class='fa fa-gg'></i> Ver Recibos Emitidos</a></li>
                    </ul>
                </li>
            @endif


            @if(accesoUser([1,2,4]))
            <li class="treeview" v-bind:class="classMenu7">
                    <a href="#"><i class='fa fa-cogs'></i> <span>Procesar Recibos</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="procesar"><i class='fa fa-gg'></i> Procesar Recibos</a></li>
                        <li><a href="recibosprocesados"><i class='fa fa-gg'></i> Ver Recibos Procesados</a></li>
                    </ul>
                </li>
            @endif


            

            @if(accesoUser([1,2,5]))

            <li class="treeview" v-bind:class="classMenu4">
                <a href="#"><i class='fa fa-print'></i> <span>Reportes Principales</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="reportesgenerales"><i class='fa fa-gg'></i>Reporte General</a></li>
                    <li><a href="reportedestallados"><i class='fa fa-gg'></i> Reporte Detallado</a></li>
                </ul>
            </li>


            @endif

           

           


            @if(accesoUser([1,2,3,4,5]))
            <li class="treeview" v-bind:class="classMenu6">
                <a href="#"><i class='fa fa-print'></i> <span>Reportes Tablas Base</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                
                    <li><a href="reporteslocales"><i class='fa fa-gg'></i> Reporte de Locales</a></li>
                    <li><a href="reportesentidades"><i class='fa fa-gg'></i> Reporte de Entidades</a></li>
                    <li><a href="reportescategorias"><i class='fa fa-gg'></i> Reporte de Categorías</a></li>
                    <li><a href="reportesrubros"><i class='fa fa-gg'></i> Reporte de Rubros</a></li>
                    <li><a href="reportesprecios"><i class='fa fa-gg'></i> Reporte de Precios</a></li>
                    <li><a href="reportespersonas"><i class='fa fa-gg'></i> Reporte de Personas</a></li>
                </ul>
            </li>

            @endif



            @if(accesoUser([1,2,3,4,5]))
            <li class="treeview" v-bind:class="classMenu5">
                <a href="#"><i class='fa fa-cogs'></i> <span>Configuraciones</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                        @if(accesoUser([1]))<li><a href="usuarios"><i class='fa fa-gg'></i> Gestión de Usuarios</a></li>@endif
                    <li><a href="miperfil"><i class='fa fa-gg'></i> Mi Perfil</a></li>
                    <li><a href="salir" ><i class='fa fa-gg'></i> <b>Cerrar Sesión</b></a></li>
                </ul>
            </li>
            @endif


            @if(accesoUser([1]))
            <li class="treeview" v-bind:class="classMenu8">
                <a href="#"><i class='fa fa-search-plus'></i> <span>Auditoría de Recibos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                        @if(accesoUser([1]))<li><a href="auditarrecibos"><i class='fa fa-gg'></i> Auditoría de Recibos</a></li>@endif
                </ul>
            </li>
            @endif --}}



            {{-- <li><a href="#"><i class='fa fa-link'></i> <span>Link 1</span></a></li> --}}
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
