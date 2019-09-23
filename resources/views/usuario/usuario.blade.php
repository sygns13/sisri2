<div class="panel panel-primary" v-if="mostrarPalenIni">
  <div class="panel-heading" style="padding-bottom: 15px;">
    <h3 class="panel-title">Gestión de Usuarios <a style="float: right; padding: all; color: black;" type="button" class="btn btn-default btn-sm" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
    Volver</a></h3>
    
  </div>

  <div class="panel-body">
    <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-sm" id="btncrearusuario" style="font-size: 14px;" @click.prevent="nuevoUsuario()"><i class="fa fa-plus-circle" aria-hidden="true" ></i> Nuevo Usuario</button>
      </div>
    </div>
  </div>
</div>



<div class="box box-success" v-if="divNuevoUsuario">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Usuario
    </h3>
  </div>
  @include('usuario.formulario')  
</div>


<div class="box box-warning" v-if="divEditUsuario">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Usuario: @{{ filluser.nombres }} @{{ filluser.apellidopat }} @{{ filluser.apellidomat }}


    </h3>
  </div>

  @include('usuario.editar')  

</div>

<div class="box box-info" >
  <div class="box-header">
    <h3 class="box-title">Listado de Usuarios del Sistema
    </h3>

    <div class="box-tools">
      <div class="input-group input-group-sm" style="width: 300px;">
        <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">

        <div class="input-group-btn">
          <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
        </div>


      </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body table-responsive">
    <table class="table table-hover table-bordered" >
      <tbody><tr>
        <th style="padding: 5px; width: 5%;">#</th>
        <th style="padding: 5px; width: 10%;">Tipo de Usuario</th>
        <th style="padding: 5px; width: 15%;">Apellidos y Nombres</th>
        <th style="padding: 5px; width: 7%;">DNI</th>
        <th style="padding: 5px; width: 10%;">Usuario</th> 
        <th style="padding: 5px; width: 15%;">Email</th> 
        <th style="padding: 5px; width: 19%;">Credenciales de Acceso</th> 
        <th style="padding: 5px; width: 6%;">Estado</th>
        <th style="padding: 5px; width: 13%;">Gestión</th>
      </tr>
      <tr v-for="usuario, key in usuarios">
        <td style="font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
        <td style="font-size: 11px; padding: 5px;">@{{ usuario.tipouser }}</td>
        <td style="font-size: 11px; padding: 5px;">@{{ usuario.apellidopat }} @{{ usuario.apellidomat }}, @{{ usuario.nombres }}</td>
        <td style="font-size: 11px; padding: 5px;">@{{ usuario.doc }}</td>
        <td style="font-size: 11px; padding: 5px;">@{{ usuario.name }}</td>
        <td style="font-size: 11px; padding: 5px;">@{{ usuario.email }}</td>
        <td style="font-size: 11px; padding: 5px;">

            
          <template v-if="parseInt(usuario.tipouser_id)==1"><b>Acceso Total</b></template>


          <template v-if="parseInt(usuario.tipouser_id)==2">
              <button type="button" class="btn btn-info btn-sm" id="btncrearusuario" style="font-size: 10px;padding: 2px 10px;" @click.prevent="gestionCredenciales(usuario)"><i class="fa fa-codepen" aria-hidden="true" ></i> Gestión de Credenciales</button> <br>
            </template>

        <template v-for="(perModulo, index) in permisoModulos" v-if="parseInt(perModulo.user_id)==parseInt(usuario.id)">
          <b>Módulo: @{{perModulo.modulo}}</b> <br>
          <template v-if="parseInt(perModulo.tipo)==2">
            - Acceso a Todos los Submódulos <br>
          </template>
          
          <template v-if="parseInt(perModulo.tipo)==1">
            <template v-for="(perSubModulo, index) in permisoSubModulos" v-if="parseInt(perSubModulo.user_id)==parseInt(usuario.id) && parseInt(perSubModulo.modulo_id)==parseInt(perModulo.idmodulo)">
                - Acceso al Submódulo:  @{{perSubModulo.submodulo}} <br>
            </template>
          </template>

        </template>

        </td>
        <td style="font-size: 11px; padding: 5px; text-align: center;">
         <span class="label label-success" v-if="usuario.activo=='1'">Activo</span>
         <span class="label label-warning" v-if="usuario.activo=='0'">Inactivo</span>
       </td>
       <td style="font-size: 11px; padding: 5px;">

   {{--      <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="impFicha(usuario)" data-placement="top" data-toggle="tooltip" title="Imprimir Ficha de Usuario"><i class="fa fa-print"></i></a>
 --}}

        <a href="#" v-if="usuario.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Desactivar Usuario"><i class="fa fa-arrow-circle-down"></i></a>

        <a href="#" v-if="usuario.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altaUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Activar Usuario"><i class="fa fa-check-circle"></i></a>


        <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Editar usuario"><i class="fa fa-edit"></i></a>
        <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarUsuario(usuario)" data-placement="top" data-toggle="tooltip" title="Borrar usuario"><i class="fa fa-trash"></i></a>
      </td>
    </tr>

  </tbody></table>

</div>
<!-- /.box-body -->
<div style="padding: 15px;">
 <div><h5>Registros por Página: @{{ pagination.per_page }}</h5></div>
 <nav aria-label="Page navigation example">
   <ul class="pagination">
    <li class="page-item" v-if="pagination.current_page>1">
     <a class="page-link" href="#" @click.prevent="changePage(1)">
      <span><b>Inicio</b></span>
    </a>
  </li>

  <li class="page-item" v-if="pagination.current_page>1">
   <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
    <span>Atras</span>
  </a>
</li>
<li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
 <a class="page-link" href="#" @click.prevent="changePage(page)">
  <span>@{{ page }}</span>
</a>
</li>
<li class="page-item" v-if="pagination.current_page< pagination.last_page">
 <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
  <span>Siguiente</span>
</a>
</li>
<li class="page-item" v-if="pagination.current_page< pagination.last_page">
 <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
  <span><b>Ultima</b></span>
</a>
</li>
</ul>
</nav>
<div><h5>Registros Totales: @{{ pagination.total }}</h5></div>
</div>
</div>



<form  v-on:submit.prevent="Imprimir()">
  <div class="modal fade bs-example-modal-lg" id="modalFicha" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document"  id="modaltamanio1">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">IMPRIMIR FICHA DE USUARIO</h4>

        </div> 
        <div class="modal-body">


          <div class="row">

            <div class="box" id="o" style="border:0px; box-shadow:none;" >
              <div class="box-header with-border">
                <h3 class="box-title" id="boxTituloAgre"></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div id="FichaUsuario"> 
            {{--    @include('usuario.ficha')    --}}

             </div>
           </div>



         </div>
         <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="btnImprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Ficha</button>

          <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>



        </div>
      </div>
    </div>
  </div>
</div>
</form>






















    <div class="modal fade bs-example-modal-lg" id="modalActualizarCredenciales" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document"  id="modaltamanio3">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="desActualizarCredenciales" style="font-weight: bold;text-decoration: underline;">Gestionar Credencciales de Acceso</h4>
  
          </div> 
          <div class="modal-body">
  
  
            <div class="row">
  
              <div class="box" id="o" style="border:0px; box-shadow:none;" >
                <div class="box-header with-border">
                <h3 class="box-title" id="boxTituloActCred">Usuario: @{{ filluser.nombres }} @{{ filluser.apellidopat }} @{{ filluser.apellidomat }}
                <br>Username: @{{ filluser.name }}
                </h3>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
                      <button type="button" class="btn btn-primary btn-sm" id="btnNuevoRegistro" style="font-size: 14px;" @click.prevent="nuevaCredencial()"><i class="fa fa-plus-circle" aria-hidden="true" ></i> Nuevo Registro</button>
                    </div>
                  </div>

                <div class="col-md-12" style="padding-top: 15px;" v-if="formularioCredenciales">

                    
                    <form v-on:submit.prevent="ActualizarCredenciales">
                    

                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="form-group">
                                  <label for="cbumodulo" class="col-sm-2 control-label">Módulo:*</label>
                                  <div class="col-sm-4">
                                    <select class="form-control" id="cbumodulo" name="cbumodulo" v-model="idmodulo"  @change="cambioModulo">
                                      <option disabled value="0">Seleccione un Módulo</option>
                                      @foreach ($modulos as $dato)
                                        <option value="{{$dato->id}}">{{$dato->modulo}}</option> 
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>


                              <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(idmodulo)>0">
                                  <div class="form-group">
                                    <label for="cbusubmodulo" class="col-sm-2 control-label">Submódulo:*</label>
                                    <div class="col-sm-4">
                                      <select class="form-control" id="cbusubmodulo" name="cbusubmodulo" v-model="idsubmodulo" >
                                        <option disabled value="0">Acceso a Todos los Submódulos</option>
                                        @foreach ($submodulos as $dato)
                                      <option value="{{$dato->id}}" v-if="parseInt(idmodulo)=={{$dato->modulo_id}}">{{$dato->submodulo}}</option> 
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                </div>


                              

                              <div class="col-md-12" style="padding-top: 15px;">
                                  <button type="submit" class="btn btn-info" id="btnGuardarCred"><span
                                    class="fa fa-floppy-o"></span> Guardar</button>
                              
                                <button type="reset" class="btn btn-warning" id="btnCancelCred" @click="cancelFormCred()"><span class="fa fa-rotate-left"></span> Cancelar</button>
                              
                                  <button type="button" class="btn btn-danger" id="btnCloseCred" @click.prevent="cerrarFormCred()"><span
                                      class="fa fa-power-off"></span> Cerrar</button>
                              
                                  <div class="sk-circle" v-show="divloaderCredencial">
                                    <div class="sk-circle1 sk-child"></div>
                                    <div class="sk-circle2 sk-child"></div>
                                    <div class="sk-circle3 sk-child"></div>
                                    <div class="sk-circle4 sk-child"></div>
                                    <div class="sk-circle5 sk-child"></div>
                                    <div class="sk-circle6 sk-child"></div>
                                    <div class="sk-circle7 sk-child"></div>
                                    <div class="sk-circle8 sk-child"></div>
                                    <div class="sk-circle9 sk-child"></div>
                                    <div class="sk-circle10 sk-child"></div>
                                    <div class="sk-circle11 sk-child"></div>
                                    <div class="sk-circle12 sk-child"></div>
                                  </div>
                              
                                </div>

                    </form>
                    
                    
                    
                  </div>
                    

                  <div class="col-md-12">
                      <hr style="border-top: 3px solid #1b5f43;">
                    </div>
                    
                    
                    
                  <div class="col-md-12" style="padding-top: 15px;">
                    
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered" >
                          <tbody><tr>   
                            <th style="padding: 5px; width: 40%;">Módulo</th>
                            <th style="padding: 5px; width: 45%;">Submódulos</th>
                            <th style="padding: 5px; width: 15%;">Gestión</th>
                          </tr>
                          <template v-for="(perModulo, index) in permisoModulos" v-if="parseInt(perModulo.user_id)==parseInt(filluser.id)">

                              <template v-if="parseInt(perModulo.tipo)==2">

                                <tr>
                                  <td style="font-size: 11px; padding: 5px;"> <b>Módulo: @{{perModulo.modulo}}</b></td>
                                  <td style="font-size: 11px; padding: 5px;"> - Acceso a Todos los Submódulos
                                    </td>

                                    <td style="font-size: 11px; padding: 5px;">
                                        <center>  <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarCredencial1(perModulo)" data-placement="top" data-toggle="tooltip" title="Borrar Credencial de Acceso"><i class="fa fa-trash"></i></a>
                                    </center>
                                   </td>
                                  </tr>
                                </template>

                                <template v-if="parseInt(perModulo.tipo)==1">
                                    <template v-for="(perSubModulo, index) in permisoSubModulos" v-if="parseInt(perSubModulo.user_id)==parseInt(filluser.id) && parseInt(perSubModulo.modulo_id)==parseInt(perModulo.idmodulo)">
                                        <tr>
                                        <td style="font-size: 11px; padding: 5px;"> <b>Módulo: @{{perModulo.modulo}}</b></td>
                                        <td style="font-size: 11px; padding: 5px;">  - Acceso al Submódulo:  @{{perSubModulo.submodulo}}  </td>
                                        <td style="font-size: 11px; padding: 5px;">
        <center> 
                                            <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarCredencial2(perModulo,perSubModulo)" data-placement="top" data-toggle="tooltip" title="Borrar Credencial de Acceso"><i class="fa fa-trash"></i></a>
                                          </center>
                                          </td>
                                        </tr>
                                    </template>
                                  </template>

    
                          </template>
                      
                        </tbody></table>
                      
                      </div>


                  </div>
                






             </div>
           </div>
           <div class="modal-footer">
          {{--   <button type="submit" class="btn btn-primary" id="btnImprimir"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Ficha</button> --}}
  
            <button type="button" id="btnCancelFoto" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
  
  
  
          </div>
        </div>
      </div>
    </div>
  </div>

  