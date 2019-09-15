<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Campañas de Salud de DBU</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Campañas de Salud de DBU</button>
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
            <h3 class="box-title" id="tituloAgregar">Nueva Campañas de Salud de DBU</h3>
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
                  <label for="txtlugar" class="col-sm-2 control-label">Lugar:*</label>
        
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtlugar" name="txtlugar" placeholder="Nombre" maxlength="500" autofocus v-model="lugar" >
                  </div>
                </div>
              </div>   


            <div class="col-md-12" style="padding-top:15px;">
      
                <div class="form-group">
                  <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:*</label>
        
                  <div class="col-sm-10">
                    <textarea style="width:100%;" name="txtdescripcion" id="txtdescripcion"rows="6" placeholder="Descripción" v-model="descripcion"></textarea>
                  </div>
                </div>
              </div>  


              <div class="col-md-12" style="padding-top:15px;" >
                  <div class="form-group">

                    <label for="txtfechaini" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                    <div class="col-sm-2">
                      <input type="date" class="form-control" id="txtfechaini" name="txtfechaini" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fechaini" >
                    </div>

                    <label for="txtfechafin" class="col-sm-2 control-label">Fecha Final:*</label>
                    <div class="col-sm-2">
                      <input type="date" class="form-control" id="txtfechafin" name="txtfechafin" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fechafin" >
                    </div>

                  </div>
                </div> 

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
    
   
                          <label for="txtcantidadAtenciones" class="col-sm-2 control-label">Cantida de Atenciones:*</label>
                          <div class="col-sm-2">
                              <input type="text" class="form-control" id="txtcantidadAtenciones" name="txtcantidadAtenciones" placeholder="" onkeypress="return soloNumeros(event);"
                                maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="cantidadAtenciones">
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
          <h3 class="box-title">Listado de Campañas de Salud</h3>
      
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
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Nombre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Descripción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Lugar</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha de Inicio</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Final</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Cantidad de Atenciones</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Gestión</th>
            </tr>
            <tr v-for="programasalud, key in programassaluds">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.descripcion }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.lugar }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.fechaini }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.fechafin }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programasalud.cantidadAtenciones }}</td>

             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>
            <a v-bind:href="'{{URL::to('medicos')}}/'+programasalud.id"  class="btn btn-primary btn-sm"  data-placement="top" data-toggle="tooltip" title="Gestionar Médicos"><i class="fa fa-user-md"></i></a>


            <a v-bind:href="'{{URL::to('beneficiarios')}}/'+programasalud.id"  class="btn btn-info btn-sm"  data-placement="top" data-toggle="tooltip" title="Gestionar Beneficiarios"><i class="fa fa-users"></i></a>
      

           {{--  <a v-bind:href="'{{URL::to('atencionsalud')}}/'+programasalud.id"  class="btn btn-success btn-sm"  data-placement="top" data-toggle="tooltip" title="Gestionar Cantidades de Atenciones"><i class="fa fa-bar-chart-o"></i></a> --}}

      
      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editar(programasalud)" data-placement="top" data-toggle="tooltip" title="Editar Campaña de Salud"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(programasalud)" data-placement="top" data-toggle="tooltip" title="Borrar Campaña de Salud"><i class="fa fa-trash"></i></a>
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
      







      <form method="post" v-on:submit.prevent="update(fillprogramassalud.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR CAMPAÑA DE SALUD</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Campaña de Salud:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                        <div class="col-md-12" >
      
                            <div class="form-group">
                              <label for="txtnombreE" class="col-sm-2 control-label">Nombre:*</label>
                    
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtnombreE" name="txtnombreE" placeholder="Nombre" maxlength="500" autofocus v-model="fillprogramassalud.nombre" >
                              </div>
                            </div>
                          </div>    
              
              
                          <div class="col-md-12" style="padding-top:15px;">
                    
                              <div class="form-group">
                                <label for="txtlugarE" class="col-sm-2 control-label">Lugar:*</label>
                      
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="txtlugarE" name="txtlugarE" placeholder="Nombre" maxlength="500" autofocus v-model="fillprogramassalud.lugar" >
                                </div>
                              </div>
                            </div>   
              
              
                          <div class="col-md-12" style="padding-top:15px;">
                    
                              <div class="form-group">
                                <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:*</label>
                      
                                <div class="col-sm-10">
                                  <textarea style="width:100%;" name="txtdescripcionE" id="txtdescripcionE"rows="6" placeholder="Descripción" v-model="fillprogramassalud.descripcion"></textarea>
                                </div>
                              </div>
                            </div>  
              
              
                            <div class="col-md-12" style="padding-top:15px;" >
                                <div class="form-group">
              
                                  <label for="txtfechainiE" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                                  <div class="col-sm-2">
                                    <input type="date" class="form-control" id="txtfechainiE" name="txtfechainiE" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fillprogramassalud.fechaini" >
                                  </div>
              
                                  <label for="txtfechafinE" class="col-sm-2 control-label">Fecha Final:*</label>
                                  <div class="col-sm-2">
                                    <input type="date" class="form-control" id="txtfechafinE" name="txtfechafinE" placeholder="dd/mm/aaaa" maxlength="10" autofocus v-model="fillprogramassalud.fechafin" >
                                  </div>
              
                                </div>
                              </div> 
              
                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">
                  
                 
                                        <label for="txtcantidadAtencionesE" class="col-sm-2 control-label">Cantida de Atenciones:*</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="txtcantidadAtencionesE" name="txtcantidadAtencionesE" placeholder="" onkeypress="return soloNumeros(event);"
                                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillprogramassalud.cantidadAtenciones">
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
      