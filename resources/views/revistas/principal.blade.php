<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Revistas y Publicaciones</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">



            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'revistaspublicaciones/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>

          </div>     
          </div>
      
</div>
      
 <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Revista o Publicación
    </h3>
  </div>
  @include('revistas.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Registro de Revista o Publicación: @{{ fillrevista.titulo }}


    </h3>
  </div>

  @include('revistas.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Revistas y Publicaciones</h3>
      
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
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Tipo de Publicación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Tìtulo</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 150px;">Número</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 250px;">Autores</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Descripción</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Fecha de Publicación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Indexada</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Lugar de Indexación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Archivo</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Gestión de Revistas y Publicaciones</th>
            </tr>
            <tr v-for="revista, key in revistas">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ revista.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.escuela }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.tipoPublicacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.titulo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.numero }}</td>

              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
               <center> <a href="#" class="btn btn-primary btn-sm" v-on:click.prevent="gestautores(revista)" data-placement="top" data-toggle="tooltip" title="Gestionar Autories"><i class="fa fa-users"></i></a></center>

                <template v-for="autor, in autoresRevistas" v-if="revista.id==autor.revistaspublicacion_id">
                  -<b>@{{ autor.cargo }}</b> @{{ autor.doc }} @{{ autor.apellidopat }} @{{ autor.apellidomat }} @{{ autor.nombres }} <br>
                </template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.descripcion }} </td>
              
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.fechaPublicado | fecha }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
              <template v-if="parseInt(revista.indexada)==1">Si</template>
              <template v-if="parseInt(revista.indexada)==0">No</template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ revista.lugarIndexada }}
                  <center><template v-if="parseInt(revista.indexada)==0">------------</template></center>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"><a v-bind:href="'revistas/'+revista.rutadoc" v-bind:download="revista.archivonombre">@{{ revista.archivonombre }}</a>

                <center><template v-if="String(revista.archivonombre).length==0">------------</template></center>
              </td>
  
                

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(revista)" data-placement="top" data-toggle="tooltip" title="Editar Revista o Publicación"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(revista)" data-placement="top" data-toggle="tooltip" title="Borrar Revista o Publicación"><i class="fa fa-trash"></i></a>
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
                <h4 class="modal-title" id="desAutoresTitulo" style="font-weight: bold;text-decoration: underline;">GESTIONAR AUTORES DE REVISTAS Y PUBLICACIONES</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTituloInvest">Revista o Publicación:</h3>
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
                                  <label for="cbsautor" class="col-sm-2 control-label">Autor:*</label>
                                  <div class="col-sm-10">
                                    <select name="cbsautor" id="cbsautor" class="form-control">
                                        <option disabled value="0">Seleccione un Autor</option>
                                    <option v-for="autor, key in autores" v-bind:value="autor.id">@{{autor.doc}} - @{{autor.apellidopat}}  @{{autor.apellidomat}},  @{{autor.nombres}}</option>
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
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 15%;">DNI</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 40%;">Apellidos y Nombres</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Cargo</th>
                            <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Gestión</th>
                          </tr>
                          <tr v-for="autor, key in autoresRegis">
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+1}}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ autor.doc }}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;"> @{{autor.apellidopat}}  @{{autor.apellidomat}},  @{{autor.nombres}}</td>
                            <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ autor.cargo }}</td>
                            <td  style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
                                <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarAutor(autor)" data-placement="top" data-toggle="tooltip" title="Borrar Autor"><i class="fa fa-trash"></i></a>
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


















      {{-- 
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
      --}}