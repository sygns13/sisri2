<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Investigaciones</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">



            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'investigaciones/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>

          </div>     
          </div>
      
</div>
      
 <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Investigación
    </h3>
  </div>
  @include('investigacions.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Registro de Investigación: @{{ fillinvestigacion.titulo }}


    </h3>
  </div>

  @include('investigacions.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Investigaciones</h3>
      
          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">
      
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
              </div>
      
      
            </div>
          </div>
        </div>
        <!-- /.box-header  table-bordered table-dark table-condensed table-striped -->
        <div class="box-body table-responsive">
          <table class="table table-hover " >
            <tbody><tr>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10px;">#</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Facultad</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Escuela</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 250px;">Título de Investigación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 30px;">Autores</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Descripción</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Publicaciones</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Archivo</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Resolución de Aprobación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Clasificación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 150px;">Línea de Investigación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Tipo de Financiamiento</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Presupuesto Asignado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Presupuesto Ejecutado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Fecha de Inicio</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Fecha de Término</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Horas Dedicadas</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Patentado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Estado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Avance</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Gestión de Investigacines</th>
            </tr>
            <tr v-for="investigacion, key in investigacions">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ investigacion.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.escuela }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.titulo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
               <center> <a href="#" class="btn btn-primary btn-sm" v-on:click.prevent="gestautores(investigacion)" data-placement="top" data-toggle="tooltip" title="Gestionar Autories"><i class="fa fa-users"></i></a></center>

                <template v-for="autor, in autores" v-if="investigacion.id==autor.investigacion_id">
                  -<b>@{{ autor.tipoAutor }}</b> @{{ autor.doc }} @{{ autor.apellidopat }} @{{ autor.apellidomat }} @{{ autor.nombres }} <br>
                </template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.descripcion }} </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                  <center><a href="#" class="btn btn-info btn-sm" v-on:click.prevent="getPublicaciones(investigacion)" data-placement="top" data-toggle="tooltip" title="Gestionar Publicaciones"><i class="fa fa-book"></i></a></center>

                <template v-for="publicacion, in publicaciones" v-if="investigacion.id==publicacion.investigacion_id">
                  -@{{ publicacion.fecha | fecha }}: @{{ publicacion.nombre }}<br>
                </template>

              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"><a v-bind:href="'investigacion/'+investigacion.rutadocumento" v-bind:download="investigacion.archivonombre">@{{ investigacion.archivonombre }}</a>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.resolucionAprobacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.clasificacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.lineainvestigacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.financiamiento }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">S/. @{{ parseFloat(investigacion.presupuestoAsignado).toFixed(2) }} </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">S/. @{{ parseFloat(investigacion.presupuestoEjecutado).toFixed(2) }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.fechaInicio | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.fechaTermino | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigacion.horas }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <template v-if="parseInt(investigacion.patentado)==0">No</template>
                <template v-if="parseInt(investigacion.patentado)==1">Si</template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <template v-if="parseInt(investigacion.estado)==0">Finalizado</template>
                <template v-if="parseInt(investigacion.estado)==1">En Ejecución</template>
                <template v-if="parseInt(investigacion.estado)==2">Cancelado</template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;width: 300px;">@{{ investigacion.avance }}%</td>
  
                
      
          {{--     
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <center><span v-if="investigacion.estado=='1'">---------</span></center>
              <center>
               <span class="label label-success" v-if="investigacion.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="investigacion.estado=='0'">Finalizado</span>
              </center>
              </td> --}}

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(investigacion)" data-placement="top" data-toggle="tooltip" title="Editar Investigación"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(investigacion)" data-placement="top" data-toggle="tooltip" title="Borrar Investigación"><i class="fa fa-trash"></i></a>
      </center>
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




















        <div class="modal bs-example-modal-lg" id="modalAutores" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desAutoresTitulo" style="font-weight: bold;text-decoration: underline;">GESTIONAR AUTORES DE INVESTIGACIÓN</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTituloInvest">Investigación:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="form-group form-primary">
                        <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevoAutor()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Agregar Autor</button>
                      </div>



                      <div class="box box-success" v-if="divNuevoAutor" style="border: 1px solid #00a65a;">
                        <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
                          <h3 class="box-title" id="tituloAgregar">Agregar Autor:</h3>
                        </div>
                    
                        <form v-on:submit.prevent="createAutor">
                         <div class="box-body">

                            <div class="col-md-12"  >
                                <div class="form-group">
                                  <label for="cbsinvestigador" class="col-sm-2 control-label">Investigador:*</label>
                                  <div class="col-sm-10">
                                    <select name="cbsinvestigador" id="cbsinvestigador" class="form-control">
                                        <option disabled value="0">Seleccione un Investigador</option>
                                    <option v-for="investigador, key in investigadors" v-bind:value="investigador.id">@{{investigador.doc}} - @{{investigador.apellidopat}}  @{{investigador.apellidomat}},  @{{investigador.nombres}}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>


                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">
                                    <label for="cbutipoAutor" class="col-sm-2 control-label">Tipo de Investigador:*</label>
                                    <div class="col-sm-4">
                                      <select class="form-control" id="cbutipoAutor" name="cbutipoAutor" v-model="tipoAutor">
                                        <option value="AUTOR">AUTOR</option>
                                        <option value="COAUTOR">COAUTOR</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                    
                          <div class="col-md-12" style="padding-top: 5px;">
                    
                            <div class="form-group">
                              <label for="txtcargo" class="col-sm-2 control-label">Cargo:</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtcargo" name="txtcargo" placeholder="Ingrese Dato Opcionalmente" maxlength="500" v-model="cargo" >
                              </div>
                            </div>
                          </div>
              
                        </div>
                    
                        <!-- /.box-body -->
                        <div class="box-footer">
                          <button type="submit" class="btn btn-info" id="btnGuardarAutor">Guardar</button>
                    
                          <button type="reset" class="btn btn-warning" id="btnCancelAutor" @click="cancelFormNuevoAutor()">Cancelar</button>
                    
                          <button type="button" class="btn btn-default" id="btnCloseAutor" @click.prevent="cerrarFormNuevoAutor()">Cerrar</button>
                    
                          <div class="sk-circle" v-show="divloaderNuevoAutor">
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
                        <!-- /.box-footer -->
                    
                      </form>
                    </div>

      
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
                          <tbody><tr>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10%;">DNI</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 35%;">Apellidos y Nombres</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Clasificación</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10%;">Tipo de Autor</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Cargo</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Gestión</th>
                          </tr>
                          <tr v-for="investigador, key in investigadorsRegis">
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+1}}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ investigador.doc }}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;"> @{{investigador.apellidopat}}  @{{investigador.apellidomat}},  @{{investigador.nombres}}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ investigador.clasificacion }}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ investigador.tipoAutor }}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ investigador.cargo }}</td>
                            <td  style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
                                <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarAutor(investigador)" data-placement="top" data-toggle="tooltip" title="Borrar Autor"><i class="fa fa-trash"></i></a>
                            </td>
                         </tr>
                    
                       </tbody></table>
                    
                     </div>

      
      
      
                  </div>
                </div>
                <div class="modal-footer">
      
                  <button type="button" id="btnCancelEA" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>



















      
      <div class="modal bs-example-modal-lg" id="modalPublicaciones" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #f39c12;">
              <div class="modal-header" style="border: 1px solid #f39c12;background-color: #f39c12; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desPublicacionesTitulo" style="font-weight: bold;text-decoration: underline;">GESTIONAR PUBLICACIONES DE INVESTIGACIÓN</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTituloPublicacion">Investigación:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="form-group form-primary">
                        <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevaPublicacion()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Agregar Publicación</button>
                      </div>



                      <div class="box box-success" v-if="divNuevaPublicacion" style="border: 1px solid #00a65a;">
                        <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
                          <h3 class="box-title" id="tituloAgregar">Agregar Publicación:</h3>
                        </div>
                    
                        <form v-on:submit.prevent="createPublicacion">
                         <div class="box-body">


                    
                          <div class="col-md-12" style="padding-top: 5px;">
                    
                            <div class="form-group">
                              <label for="txtnombre" class="col-sm-2 control-label">Publicación:</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Publicación" maxlength="500" v-model="nombre" >
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">

                                  <label for="txtdetalles" class="col-sm-2 control-label">Detalles:</label>
                                  <div class="col-sm-10">
<textarea name="txtdetalles" id="txtdetalles" rows="6" v-model="detalles" style="width:100%;" placeholder="Detalles de Publicación"></textarea>


                                </div>
                              </div>
                            </div>

                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="form-group">

                      
                                  <label for="txtfecha" class="col-sm-2 control-label">Fecha de Publicación:*</label>
                                  <div class="col-sm-4">
                                      <input type="date" class="form-control" id="txtfecha" name="txtfecha" placeholder="dd/mm/aaaa"
                                      maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fecha">
                                  </div>
        
                      
                                </div>
                              </div>

              
                        </div>
                    
                        <!-- /.box-body -->
                        <div class="box-footer">
                          <button type="submit" class="btn btn-info" id="btnGuardarPublicacion">Guardar</button>
                    
                          <button type="reset" class="btn btn-warning" id="btnCancelPublicacion" @click="cancelFormNuevoPublicacion()">Cancelar</button>
                    
                          <button type="button" class="btn btn-default" id="btnClosePublicacion" @click.prevent="cerrarFormNuevoPublicacion()">Cerrar</button>
                    
                          <div class="sk-circle" v-show="divloaderNuevoPublicacion">
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
                        <!-- /.box-footer -->
                    
                      </form>
                    </div>

      
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
                          <tbody><tr>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 35%;">Nombre</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 40%;">Detalles</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10%;">Fecha</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
                          </tr>
                          <tr v-for="publicacion, key in publicacionRegis">
                            <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{key+1}}</td>
                            <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ publicacion.nombre }}</td>
                            <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;"> @{{publicacion.detalles}}</td>
                            <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ publicacion.fecha | fecha}}</td>
                            <td  style="border:1px solid #ddd;font-size: 13px; padding: 5px;">
                                <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarPublicacion(publicacion)" data-placement="top" data-toggle="tooltip" title="Borrar Publicación"><i class="fa fa-trash"></i></a>
                            </td>
                         </tr>
                    
                       </tbody></table>
                    
                     </div>

      
      
      
                  </div>
                </div>
                <div class="modal-footer">
      
                  <button type="button" id="btnCancelEPub" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
