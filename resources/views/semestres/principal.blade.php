<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Semestres</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Semestre</button>

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'semestres/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>


          </div>
      
      

      
          </div>
      
        </div>
      
        <div class="box box-success" v-if="divNuevo" style="border: 1px solid #00a65a;">
          <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
            <h3 class="box-title" id="tituloAgregar">Nuevo Semestre</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">
      
            <div class="col-md-12" >
      
              <div class="col-md-12" >

                <div class="form-group">
                  <label for="txtciclo" class="col-sm-2 control-label">Nombre del Semestre:*</label>
          
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="txtciclo" name="txtciclo" placeholder="Nombre" maxlength="100" autofocus v-model="newCiclo">
                  </div>
                </div>
          
              </div>
          
              <div class="col-md-12" style="padding-top: 15px;">
          
                <div class="form-group">
                  <label for="txtfecIni" class="col-sm-2 control-label">Fecha de Inicio del Semestre:*</label>
          
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtfecIni" name="txtfecIni" placeholder="dd/mm/aaaa" maxlength="10"  v-model="newFecIni">
                  </div>
          
                  <label for="txtFecFin" class="col-sm-2 control-label">Fecha Final del Semestre:*</label>
          
                  <div class="col-sm-3">
                    <input type="date" class="form-control" id="txtFecFin" name="txtFecFin" placeholder="dd/mm/aaaa" maxlength="10"  v-model="newFecFin">
                  </div>
                </div>
          
          
          
              </div>
          
              <div class="col-md-12" style="padding-top: 15px;">
          
                <div class="form-group">
                  <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>
          
                  <div class="col-sm-4">
                    <select class="form-control" id="cbuestado" name="cbuestado" v-model="estadoCiclo">
                      <option value="1">Activado</option>
                      <option value="0">Desactivado</option>
                    </select>
                  </div>
          
          
                </div>
          
              </div>
          
              <div class="col-md-12" style="padding-top: 15px;">
                <p style="color:red"><b>Nota: </b>Si se crea un nuevo semestre academico activado, se desactivará automaticamente cualquier otro semestre que estuviera activado y el nuevo semestre se creará con el estado activado</p>
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
          <h3 class="box-title">Listado de Bancos</h3>
      
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
              <th style="padding: 5px; width: 5%;">#</th>
              <th style="padding: 5px; width: 25%;">Semestre Académico</th>
              <th style="padding: 5px; width: 13%;">Fecha Inicio</th>
              <th style="padding: 5px; width: 13%;">Fecha Final</th>
              <th style="padding: 5px; width: 15%;">Estado</th>
              <th style="padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="semestre, key in semestres">
              <td style="font-size: 12px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="font-size: 12px; padding: 5px;">@{{ semestre.nombre }}</td>
              <td style="font-size: 12px; padding: 5px;">@{{ semestre.fechainicio | pasfechaVista}}</td>
              <td style="font-size: 12px; padding: 5px;">@{{ semestre.fechafin | pasfechaVista}}</td>
              <td style="font-size: 12px; padding: 5px;">
               <span class="label label-success" v-if="semestre.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="semestre.estado=='0'">Inactivo</span>
             </td>
             <td style="font-size: 12px; padding: 5px;">
      
               <a href="#" v-if="semestre.estado=='0'" class="btn btn-success btn-sm" v-on:click.prevent="activar(semestre)" data-placement="top" data-toggle="tooltip" title="Activar Semestre"><i class="fa fa-check-circle"></i></a>
      
      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(semestre)" data-placement="top" data-toggle="tooltip" title="Editar Semestre"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(semestre)" data-placement="top" data-toggle="tooltip" title="Borrar Semestre"><i class="fa fa-trash"></i></a>
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
      









      <form method="post" v-on:submit.prevent="update(fillSemestre.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR SEMESTRE</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Semestre:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">

                        <div class="col-md-12" >
                            <div class="form-group">
                             <label for="txtcicloE" class="col-sm-2 control-label">Nombre del Semestre:*</label>
           
                             <div class="col-sm-8">
                               <input type="text" class="form-control" id="txtcicloE" name="txtcicloE" placeholder="Nombre" maxlength="100" autofocus v-model="fillSemestre.semestre">
                             </div>
                           </div>
                         </div>
           
                         <div class="col-md-12" style="padding-top: 15px;">
           
                           <div class="form-group">
                             <label for="txtfecIniE" class="col-sm-2 control-label">Fecha de Inicio del Semestre:*</label>
           
                             <div class="col-sm-3">
                               <input type="date" class="form-control" id="txtfecIniE" name="txtfecIniE" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fillSemestre.fechainicio">
                             </div>
           
                             <label for="txtFecFinE" class="col-sm-2 control-label">Fecha Final del Semestre:*</label>
           
                             <div class="col-sm-3">
                               <input type="date" class="form-control" id="txtFecFinE" name="txtFecFinE" placeholder="dd/mm/aaaa" maxlength="10"  v-model="fillSemestre.fechafin">
                             </div>
                           </div>
           
                         </div>
           
                         <div class="col-md-12" style="padding-top: 15px;">
                           <div class="form-group">
                             <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
           
                             <div class="col-sm-4">
                               <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillSemestre.estado">
                                 <option value="1">Activado</option>
                                 <option value="0">Desactivado</option>
                               </select>
                             </div>
                           </div>
                         </div>
                         <!-- /.box-body -->
           
                         <div class="col-md-12" style="padding-top: 15px;">
                           <p style="color:red"><b>Nota: </b>Si se crea un nuevo Semestre activado, se desactivará cualquier otro Semestre que estuviera activado y el nuevo Semestre se creará con el estado activado</p>
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
      