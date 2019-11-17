<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Tesis</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro de Tesis</button>


            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'tesisinfo/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>










          </div>

         
      
      
      
          {{--  
            <div class="box-footer">
              <button type="button" class="btn btn-primary" onclick="enviarMSj();" id="btnEnviarMsj"><i class="fa fa-envelope-o" aria-hidden="true" ></i> Enviar Mensaje</button>
              <div id="divCarga0" style="display: inline-block;"><div id="dcarga0" style="display: none;"><img src="{{ asset('/img/ajax-loader.gif')}}"/></div></div>
            </div>
            --}}
      
          </div>
      
        </div>
      
        <div class="box box-success" v-if="divNuevo" style="border: 1px solid #00a65a;">
          <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
            <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Tesis</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">
      
            <div class="col-md-12" >
      
              <div class="form-group">
                <label for="txtnombreProyecto" class="col-sm-2 control-label">Nombre del Proyecto:*</label>
      
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtnombreProyecto" name="txtnombreProyecto" placeholder="Tesis" maxlength="500" autofocus v-model="nombreProyecto" >
                </div>
              </div>
            </div>


            <div class="col-md-12" >
                <div class="form-group" style="padding-top: 15px;">
        
        
                    <label for="cbufacultad" class="col-sm-2 control-label">Facultad:*</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="cbufacultad" name="cbufacultad" v-model="facultad_id" @change="cambiarFacultad">
                            <option value="0" disabled>Seleccione una Facultad...</option>
                          @foreach ($facultads as $dato)
                          <option value="{{$dato->id}}">{{$dato->nombre}}</option>     
                          @endforeach                   
                        </select>
                      </div>
        
                  </div>
                </div>

            
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
            
            
                        <label for="cbuescuela" class="col-sm-2 control-label">Escuela:*</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="cbuescuela" name="cbuescuela" v-model="escuela_id">
                                <option value="0">Seleccione una Escuela Profesional...</option>
      
                              @foreach ($escuelas as $dato)
                              <template v-if="facultad_id=='{{$dato->facultad_id}}'">
                                <option value="{{$dato->id}}">{{$dato->nombre}}</option>  
                              </template>   
                              @endforeach                   
                            </select>
                          </div>
            
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;">
      
                        <div class="form-group">
                          <label for="txtautor" class="col-sm-2 control-label">Autor:*</label>
                
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtautor" name="txtautor" placeholder="Autor" maxlength="500" v-model="autor" >
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" style="padding-top: 15px;">
      
                          <div class="form-group">
                            <label for="txtautor2" class="col-sm-2 control-label">Segundo Autor:*</label>
                  
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txtautor2" name="txtautor2" placeholder="Dejar en Blanco si solo tiene un autor" maxlength="500" v-model="autor2" >
                            </div>
                          </div>
                        </div>
      
                        <div class="col-md-12" style="padding-top: 15px;">
      
                            <div class="form-group">
                              <label for="txtfuenteFinanciamiento" class="col-sm-2 control-label">Fuente de Financiamiento:*</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtfuenteFinanciamiento" name="txtfuenteFinanciamiento" placeholder="Fuente de Financiamiento" maxlength="500" v-model="fuenteFinanciamiento" >
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
          <h3 class="box-title">Listado de Proyectos de Tesis</h3>
      
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
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 17%;">Facultad</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 17%;">Escuela</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 20%;">Nombre de Proyecto</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 17%;">Autores</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 15%;">Fuente de Financiamiento</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
            </tr>
            <tr v-for="tesi, key in tesis">
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ tesi.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ tesi.escuela }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ tesi.nombreProyecto }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">- @{{ tesi.autor }} <br> 
                <template v-if="String(tesi.autor2).trim().length>0 && String(tesi.autor2)!='null'">- @{{ tesi.autor2 }}</template></td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ tesi.fuenteFinanciamiento }}</td>
             <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">
      <center> 
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(tesi)" data-placement="top" data-toggle="tooltip" title="Editar Tesis"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(tesi)" data-placement="top" data-toggle="tooltip" title="Borrar Tesis"><i class="fa fa-trash"></i></a>
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
      



      <form method="post" v-on:submit.prevent="update(filltesis.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR TESIS</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Tesis:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                        <div class="col-md-12" >
      
                            <div class="form-group">
                              <label for="txtnombreProyecto" class="col-sm-2 control-label">Nombre del Proyecto:*</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtnombreProyecto" name="txtnombreProyecto" placeholder="Tesis" maxlength="500" autofocus v-model="filltesis.nombreProyecto">
                              </div>
                            </div>
                          </div>
              
              
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                      
                      
                                  <label for="cbufacultadE" class="col-sm-2 control-label">Facultad:*</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" id="cbufacultadE" name="cbufacultadE" v-model="filltesis.facultad_id" @change="cambiarFacultadE">
                                          <option value="0" disabled>Seleccione una Facultad...</option>
                                        @foreach ($facultads as $dato)
                                        <option value="{{$dato->id}}">{{$dato->nombre}}</option>     
                                        @endforeach                   
                                      </select>
                                    </div>
                      
                                </div>
                              </div>
              
                          
                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">
                          
                          
                                      <label for="cbuescuelaE" class="col-sm-2 control-label">Escuela:*</label>
                                      <div class="col-sm-10">
                                          <select class="form-control" id="cbuescuelaE" name="cbuescuelaE" v-model="filltesis.escuela_id">
                                              <option value="0">Seleccione una Escuela Profesional...</option>
                                            @foreach ($escuelas as $dato)
                                            <template v-if="filltesis.facultad_id=='{{$dato->facultad_id}}'">
                                              <option value="{{$dato->id}}">{{$dato->nombre}}</option>  
                                            </template>   
                                            @endforeach                   
                                          </select>
                                        </div>
                          
                                    </div>
                                  </div>
              
              
                                  <div class="col-md-12" style="padding-top: 15px;">
                    
                                      <div class="form-group">
                                        <label for="txtautorE" class="col-sm-2 control-label">Autor:*</label>
                              
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="txtautorE" name="txtautorE" placeholder="Autor" maxlength="500" v-model="filltesis.autor" >
                                        </div>
                                      </div>
                                    </div>
              
                                    <div class="col-md-12" style="padding-top: 15px;">
                    
                                        <div class="form-group">
                                          <label for="txtautor2E" class="col-sm-2 control-label">Segundo Autor:*</label>
                                
                                          <div class="col-sm-10">
                                            <input type="text" class="form-control" id="txtautor2E" name="txtautor2E" placeholder="Dejar en Blanco si solo tiene un autor" maxlength="500" v-model="filltesis.autor2" >
                                          </div>
                                        </div>
                                      </div>
                    
                                      <div class="col-md-12" style="padding-top: 15px;">
                    
                                          <div class="form-group">
                                            <label for="txtfuenteFinanciamientoE" class="col-sm-2 control-label">Fuente de Financiamiento:*</label>
                                  
                                            <div class="col-sm-10">
                                              <input type="text" class="form-control" id="txtfuenteFinanciamientoE" name="txtfuenteFinanciamientoE" placeholder="Fuente de Financiamiento" maxlength="500" v-model="filltesis.fuenteFinanciamiento" >
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
      