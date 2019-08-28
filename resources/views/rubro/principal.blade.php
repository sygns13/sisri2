<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Rubros</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Rubro</button>
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
            <h3 class="box-title" id="tituloAgregar">Nuevo Rubro</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">
      
            <div class="col-md-12" >
      
              <div class="form-group">
                <label for="txtdesc" class="col-sm-2 control-label">Descripción:*</label>
      
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtdesc" name="txtdesc" placeholder="Descripción" maxlength="500" autofocus v-model="newRubro" >
                </div>
              </div>
            </div>
      
            <div class="col-md-12" >
      
              <div class="form-group" style="padding-top: 15px;">
                <label for="txtcod" class="col-sm-2 control-label">Código:*</label>
      
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtcod" name="txtcod" placeholder="Código"  maxlength="45"  v-model="newCodigo">
                </div>
              </div>
            </div>


            <div class="col-md-12"  style="padding-top: 15px;">
      
                <div class="form-group">
                  <label for="cbsCategoria" class="col-sm-2 control-label">Categoría:*</label>
        
                  <div class="col-sm-8">

                    <select name="cbsCategoria" id="cbsCategoria" class="form-control">

                        <option disabled value="">Seleccione una Categoría</option>
                    <option v-for="categoria, key in categorias" v-bind:value="categoria.id">@{{categoria.descripcion}}</option>
                    </select>
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
          <h3 class="box-title">Listado de Rubros</h3>
      
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
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 35%;">Descripción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Código</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 30%;">Categoría</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
            </tr>
            <tr v-for="rubro, key in rubros">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ rubro.descripcion }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ rubro.code }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ rubro.categoria }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="rubro.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="rubro.estado=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>
               <a href="#" v-if="rubro.estado=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="bajarubro(rubro)" data-placement="top" data-toggle="tooltip" title="Desactivar Rubro"><i class="fa fa-arrow-circle-down"></i></a>
      
               <a href="#" v-if="rubro.estado=='0'" class="btn btn-success btn-sm" v-on:click.prevent="altarubro(rubro)" data-placement="top" data-toggle="tooltip" title="Activar Rubro"><i class="fa fa-check-circle"></i></a>
      
      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editrubro(rubro)" data-placement="top" data-toggle="tooltip" title="Editar Rubro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarrubro(rubro)" data-placement="top" data-toggle="tooltip" title="Borrar Rubro"><i class="fa fa-trash"></i></a>
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
      
      <form method="post" v-on:submit.prevent="updateRubro(fillRubro.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR RUBRO</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Rubro:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="form-group">
                        <label for="txtdescE" class="col-sm-2 control-label">Descripción:*</label>
      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtdescE" name="txtdescE" placeholder="Descripción" maxlength="500" autofocus v-model="fillRubro.descripcion" required>
                        </div>
                      </div>
                    </div>

    
                    <div class="col-md-12" >
      
                      <div class="form-group" style="padding-top: 15px;">
                        <label for="txtcodE" class="col-sm-2 control-label">Código:*</label>
      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtcodE" name="txtcodE" placeholder="Código" required maxlength="45"  v-model="fillRubro.code">
                        </div>
                      </div>
                    </div>
      

      
                    <div class="col-md-12"  style="padding-top: 15px;">
      
                        <div class="form-group">
                          <label for="cbsCategoriaE" class="col-sm-2 control-label">Categoría:*</label>
                
                          <div class="col-sm-8">
        
                            <select name="cbsCategoriaE" id="cbsCategoriaE" class="form-control">
        
                                <option disabled value="">Seleccione una Categoría</option>
                            <option v-for="categoria, key in categorias" v-bind:value="categoria.id">@{{categoria.descripcion}}</option>
                            </select>
                          </div>
                        </div>
                      </div>


      
                    <div class="col-md-12" style="padding-top: 15px;">
      
                      <div class="form-group">
                        <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
      
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillRubro.estado">
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
      