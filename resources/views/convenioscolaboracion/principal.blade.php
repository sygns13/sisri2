<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Convenios de Colaboración</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Convenio de Colaboración</button>


            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'convenioscolaboracion/exportarExcel3?busca='+buscar+'&tipo='+tipogen" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>


          </div>
      
      

      
          </div>
      
        </div>
      
        <div class="box box-success" v-if="divNuevo" style="border: 1px solid #00a65a;">
          <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
            <h3 class="box-title" id="tituloAgregar">Nuevo Convenio de Colaboración</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">
      
            <div class="col-md-12" >
      
              <div class="form-group">
                <label for="txtnombre" class="col-sm-2 control-label">Nombre:*</label>
      
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Nombre" maxlength="500" autofocus v-model="nombre" >
                </div>
              </div>
            </div>    

            <div class="col-md-12" style="padding-top:15px;">
      
              <div class="form-group">
                <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:*</label>
      
                <div class="col-sm-10">

                  <textarea name="txtdescripcion" id="txtdescripcion" rows="4" placeholder="Descripción de Convenio" v-model="descripcion" style="width:100%;"></textarea>
                </div>
              </div>
            </div>  

            <div class="col-md-12" style="padding-top:15px;" >
      
                <div class="form-group">
                  <label for="txtinstitucion" class="col-sm-2 control-label">Institución:*</label>
        
                  <div class="col-sm-10">

                    <input type="text" class="form-control" id="txtinstitucion" name="txtinstitucion" placeholder="Institución con la que se Firmó el Convenio" maxlength="500" autofocus v-model="institucion" >
                  </div>
                </div>
              </div>  

              <div class="col-md-12" style="padding-top:15px;" >
      
                  <div class="form-group">
                    <label for="txtresolucion" class="col-sm-2 control-label">Resolución:*</label>
          
                    <div class="col-sm-10">
  
                      <input type="text" class="form-control" id="txtresolucion" name="txtresolucion" placeholder="Resolución de firma del Convenio" maxlength="500" autofocus v-model="resolucion" >
                    </div>
                  </div>
                </div>  


                <div class="col-md-12" style="padding-top:15px;" >
      
                    <div class="form-group">
                      <label for="txtobjetivo" class="col-sm-2 control-label">Objetivo:*</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtobjetivo" name="txtobjetivo" placeholder="Objetivo del Convenio" maxlength="500" autofocus v-model="objetivo" >
                      </div>
                    </div>
                  </div> 


                  <div class="col-md-12" style="padding-top:15px;" >
                      <div class="form-group">
                        <label for="txtobligaciones" class="col-sm-2 control-label">Obligaciones:*</label>
                        <div class="col-sm-10">
                          <textarea name="txtobligaciones" id="txtobligaciones" rows="4" placeholder="Obligaciones del Convenio" v-model="obligaciones" style="width:100%;"></textarea>
                        </div>
                      </div>
                    </div>  


                    <div class="col-md-12" style="padding-top:15px;" >
                        <div class="form-group">

                          <label for="txtfechainicio" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechainicio" name="txtfechainicio" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fechainicio" >
                          </div>

                          <label for="txtfechafinal" class="col-sm-2 control-label">Fecha Final:*</label>
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechafinal" name="txtfechafinal" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fechafinal" >
                          </div>

                        </div>
                      </div> 




      
            <div class="col-md-12" style="padding-top:15px;">
              <div class="form-group">
                <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>
                <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="estado">
                    <option value="1">Vigente</option>
                    <option value="0">Finalizado</option>
                  </select>
                </div>
              </div>
            </div>
      
          </div>
      
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>
      
            <button type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormNuevo()">Cancelar</button>
      
            <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormNuevo()">Cerrar</button>
      
            <div class="sk-circle" v-show="divloaderNuevo">
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
      
      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Convenios de Colaboración</h3>
      
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
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 15%;">Nombre</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 17%;">Descripción</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 15%;">Institución con la que se Firmó el Convenio</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Resolución de Convenio</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Fecha de Inicio de Convenio</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Fecha de Finalización de Convenio</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Estado</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Gestión</th>
            </tr>
            <tr v-for="convenio, key in convenios">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.descripcion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.institucion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.resolucion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.fechainicio | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ convenio.fechafinal | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <span v-if="parseInt(convenio.estado)==1">Vigente</span>
                <span v-if="parseInt(convenio.estado)==0">Finalizado</span>
              </td>
             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>
         
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(convenio)" data-placement="top" data-toggle="tooltip" title="Editar convenio"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(convenio)" data-placement="top" data-toggle="tooltip" title="Borrar convenio"><i class="fa fa-trash"></i></a>
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
      











      <form method="post" v-on:submit.prevent="update(fillconvenio.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR CONVENIO de Colaboración</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Convenio de Colaboración:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                     
      
       
                        <div class="col-md-12"  >
      
                            <div class="form-group">
                              <label for="txtnombreE" class="col-sm-2 control-label">Nombre:*</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtnombreE" name="txtnombreE" placeholder="Nombre" maxlength="500" autofocus v-model="fillconvenio.nombre" >
                              </div>
                            </div>
                          </div>    
              
                          <div class="col-md-12" style="padding-top:15px;">
                    
                            <div class="form-group">
                              <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:*</label>
                    
                              <div class="col-sm-10">
              
                                <textarea name="txtdescripcionE" id="txtdescripcionE" rows="4" placeholder="Descripción de Convenio" v-model="fillconvenio.descripcion" style="width:100%;"></textarea>
                              </div>
                            </div>
                          </div>  
              
                          <div class="col-md-12" style="padding-top:15px;">
                    
                              <div class="form-group">
                                <label for="txtinstitucionE" class="col-sm-2 control-label">Institución:*</label>
                      
                                <div class="col-sm-10">
              
                                  <input type="text" class="form-control" id="txtinstitucionE" name="txtinstitucionE" placeholder="Institución con la que se Firmó el Convenio" maxlength="500" autofocus v-model="fillconvenio.institucion" >
                                </div>
                              </div>
                            </div>  
              
                            <div class="col-md-12" style="padding-top:15px;">
                    
                                <div class="form-group">
                                  <label for="txtresolucionE" class="col-sm-2 control-label">Resolución:*</label>
                        
                                  <div class="col-sm-10">
                
                                    <input type="text" class="form-control" id="txtresolucionE" name="txtresolucionE" placeholder="Resolución de firma del Convenio" maxlength="500" autofocus v-model="fillconvenio.resolucion" >
                                  </div>
                                </div>
                              </div>  
              
              
                              <div class="col-md-12" style="padding-top:15px;">
                    
                                  <div class="form-group">
                                    <label for="txtobjetivoE" class="col-sm-2 control-label">Objetivo:*</label>
                                    <div class="col-sm-10">
                                      <input type="text" class="form-control" id="txtobjetivoE" name="txtobjetivoE" placeholder="Objetivo del Convenio" maxlength="500" autofocus v-model="fillconvenio.objetivo" >
                                    </div>
                                  </div>
                                </div> 
              
              
                                <div class="col-md-12" style="padding-top:15px;">
                                    <div class="form-group">
                                      <label for="txtobligacionesE" class="col-sm-2 control-label">Obligaciones:*</label>
                                      <div class="col-sm-10">
                                        <textarea name="txtobligacionesE" id="txtobligacionesE" rows="4" placeholder="Obligaciones del Convenio" v-model="fillconvenio.obligaciones" style="width:100%;"></textarea>
                                      </div>
                                    </div>
                                  </div>  
              
              
                                  <div class="col-md-12" style="padding-top:15px;">
                                      <div class="form-group">
              
                                        <label for="txtfechainicioE" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                                        <div class="col-sm-2">
                                          <input type="date" class="form-control" id="txtfechainicioE" name="txtfechainicioE" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fillconvenio.fechainicio" >
                                        </div>
              
                                        <label for="txtfechafinalE" class="col-sm-2 control-label">Fecha Final:*</label>
                                        <div class="col-sm-2">
                                          <input type="date" class="form-control" id="txtfechafinalE" name="txtfechafinalE" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fillconvenio.fechafinal" >
                                        </div>
              
                                      </div>
                                    </div> 
              
              
              
              
                    
                          <div class="col-md-12" style="padding-top: 15px;" >
                            <div class="form-group">
                              <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
                              <div class="col-sm-4">
                                <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillconvenio.estado">
                                  <option value="1">Vigente</option>
                                  <option value="0">Finalizado</option>
                                </select>
                              </div>
                            </div>
                          </div>
                    
                        </div>
      
      
      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
      
                  <button type="button" id="btnCancelE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
                  <div class="sk-circle" v-show="divloaderEdit">
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
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
      