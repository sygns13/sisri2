<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Locales</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Local</button>
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
            <h3 class="box-title" id="tituloAgregar">Nuevo Local</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">


              <div class="col-md-12">
                  <div class="form-group">
                    <label for="cbuPais" class="col-sm-2 control-label">País:*</label>
                    <div class="col-sm-4">
                      <select class="form-control" id="cbuPais" name="cbuPais" v-model="paise_id" @change="selectPais">
                        <option value="0" disabled>Seleccione un país</option>
                        <option v-for="pais in paises" v-bind:value="pais.id">@{{pais.nombre}}</option>
                      </select>
                    </div>
                  </div>
                </div>


                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
                      <label for="cbuDepartamento" class="col-sm-2 control-label">Departamento:*</label>
                      <div class="col-sm-4">
                        <select class="form-control" id="cbuDepartamento" name="cbuDepartamento" v-model="departamento_id" @change="selectDepartamento">
                          <option value="0" disabled>Seleccione un Departamento</option>
                          <option v-for="departamento in departamentos" v-bind:value="departamento.id">@{{departamento.nombre}}</option>
                        </select>
                      </div>
                    </div>
                  </div>


                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
                        <label for="buProvincia" class="col-sm-2 control-label">Provincia:*</label>
                        <div class="col-sm-4">
                          <select class="form-control" id="buProvincia" name="buProvincia" v-model="provincia_id" @change="selectProvincia">
                            <option value="0" disabled>Seleccione una Provincia</option>
                            <option v-for="provincia in provincias" v-bind:value="provincia.id">@{{provincia.nombre}}</option>
                          </select>
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="cbuDistrito" class="col-sm-2 control-label">Distrito:*</label>
                          <div class="col-sm-4">
                            <select class="form-control" id="cbuDistrito" name="cbuDistrito" v-model="distrito_id">
                              <option value="0" disabled>Seleccione un Distrito</option>
                              <option v-for="distrito in distritos" v-bind:value="distrito.id">@{{distrito.nombre}}</option>
                            </select>
                          </div>
                        </div>
                      </div>




      
            <div class="col-md-12" style="padding-top: 15px;">
      
              <div class="form-group">
                <label for="txtnom" class="col-sm-2 control-label">Nombre:*</label>
      
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtnom" name="txtnom" placeholder="Nombre" maxlength="500" autofocus v-model="newlocal" >
                </div>
              </div>
            </div>
      
            <div class="col-md-12" >
      
              <div class="form-group" style="padding-top: 15px;">
                <label for="txtdir" class="col-sm-2 control-label">Dirección:*</label>
      
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtdir" name="txtdir" placeholder="Dirección"  maxlength="2000"  v-model="newDir">
                </div>
              </div>
            </div>
      
      
      
            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>
                <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="newEstado">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
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
          <h3 class="box-title">Listado de Locales</h3>
      
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
              <th style="border:1px solid #ddd;padding: 5px; width: 3%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Nombre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Dirección</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 13%;">País</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 12%;">Departamento</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 12%;">Provincia</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 12%;">Distrito</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
            </tr>
            <tr v-for="local, key in locals">
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.direccion }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.pais }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.departamento }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.provincia }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ local.distrito }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="local.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="local.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">
      <center>
               <a href="#" v-if="local.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajalocal(local)" data-placement="top" data-toggle="tooltip" title="Desactivar local"><i class="fa fa-arrow-circle-down"></i></a>
      
               <a href="#" v-if="local.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altalocal(local)" data-placement="top" data-toggle="tooltip" title="Activar local"><i class="fa fa-check-circle"></i></a>
      
      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editlocal(local)" data-placement="top" data-toggle="tooltip" title="Editar local"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarlocal(local)" data-placement="top" data-toggle="tooltip" title="Borrar local"><i class="fa fa-trash"></i></a>
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
      
      <form method="post" v-on:submit.prevent="updateLocal(fillLocal.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR LOCAL</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Local:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
                      


                        <div class="col-md-12">
                            <div class="form-group">
                              <label for="cbuPaisE" class="col-sm-2 control-label">País:*</label>
                              <div class="col-sm-4">
                                <select class="form-control" id="cbuPaisE" name="cbuPaisE" v-model="paise_idE" @change="selectPaisE">
                                  <option value="0" disabled>Seleccione un país</option>
                                  <option v-for="pais in paisesE" v-bind:value="pais.id">@{{pais.nombre}}</option>
                                </select>
                              </div>
                            </div>
                          </div>
          
          
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                                <label for="cbuDepartamentoE" class="col-sm-2 control-label">Departamento:*</label>
                                <div class="col-sm-4">
                                  <select class="form-control" id="cbuDepartamentoE" name="cbuDepartamentoE" v-model="departamento_idE" @change="selectDepartamentoE">
                                    <option value="0" disabled>Seleccione un Departamento</option>
                                    <option v-for="departamento in departamentosE" v-bind:value="departamento.id">@{{departamento.nombre}}</option>
                                  </select>
                                </div>
                              </div>
                            </div>
          
          
                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="form-group">
                                  <label for="buProvinciaE" class="col-sm-2 control-label">Provincia:*</label>
                                  <div class="col-sm-4">
                                    <select class="form-control" id="buProvinciaE" name="buProvinciaE" v-model="provincia_idE" @change="selectProvinciaE">
                                      <option value="0" disabled>Seleccione una Provincia</option>
                                      <option v-for="provincia in provinciasE" v-bind:value="provincia.id">@{{provincia.nombre}}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
          
          
                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">
                                    <label for="cbuDistritoE" class="col-sm-2 control-label">Distrito:*</label>
                                    <div class="col-sm-4">
                                      <select class="form-control" id="cbuDistritoE" name="cbuDistritoE" v-model="fillLocal.distrito_id">
                                        <option value="0" disabled>Seleccione un Distrito</option>
                                        <option v-for="distrito in distritosE" v-bind:value="distrito.id">@{{distrito.nombre}}</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>



                    <div class="col-md-12">
                      <div class="form-group" style="padding-top: 15px;">
                        <label for="txtnomE" class="col-sm-2 control-label">Nombre:*</label>
      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtnomE" name="txtnomE" placeholder="Descripción" maxlength="500" autofocus v-model="fillLocal.nombre" required>
                        </div>
                      </div>
                    </div>
      
                    <div class="col-md-12" >
      
                      <div class="form-group" style="padding-top: 15px;">
                        <label for="txtdirE" class="col-sm-2 control-label">Dirección:*</label>
      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtdirE" name="txtdirE" placeholder="Código" required maxlength="2000"  v-model="fillLocal.direccion">
                        </div>
                      </div>
                    </div>
      

      
      
                    <div class="col-md-12" style="padding-top: 15px;">
      
                      <div class="form-group">
                        <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
      
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillLocal.activo">
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                          </select>
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
      