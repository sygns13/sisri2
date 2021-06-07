<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión y Programación de Módulos</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nueva Programación</button>
            <a href="{{URL::to('prorrogas')}}"><button type="button" class="btn btn-danger" id="btnRevisarProrroga"><i class="fa fa-file-text-o" aria-hidden="true" ></i> Revisar Solicitudes de Prórroga</button></a>
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
            <h3 class="box-title" id="tituloAgregar">Nueva Programación</h3>
          </div>
      
          <form v-on:submit.prevent="programar">
           <div class="box-body">

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
                    <option disabled value="0">Todos los Submódulos</option>
                    @foreach ($submodulos as $dato)
                  <option value="{{$dato->id}}" v-if="parseInt(idmodulo)=={{$dato->modulo_id}}">{{$dato->submodulo}}</option> 
                    @endforeach
                  </select>
                </div>
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
      
              <div class="form-group">
                <label for="txttitulo" class="col-sm-2 control-label">Título o Nombre de la Programación:*</label>
      
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Título" maxlength="500" autofocus v-model="titulo" >
                </div>
              </div>
            </div>  


            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                <label for="txtfechaini" class="col-sm-2 control-label">Fecha de Inicio:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaini" name="txtfechaini" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaini">
                </div>

                <label for="txtfechafin" class="col-sm-2 control-label">Fecha de Finalización:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechafin" name="txtfechafin" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechafin">
                </div>
    
    
              </div>
            </div>

      
            <div class="col-md-12" style="padding-top: 15px;">
      
              <div class="form-group">
                <label for="txtdescripcion" class="col-sm-2 control-label">Descipción de la Programación (Opcional):</label>
      
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtdescripcion" name="txtdescripcion" placeholder="Descripcion" maxlength="500" autofocus v-model="descripcion" >
                </div>
              </div>
            </div>    
      

      
          </div>
      
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-info" id="btnGuardar">Programar</button>
      
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
          <h3 class="box-title">Listado de Módulos</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Módulo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Submódulo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Inicio Programada <br> (Solo aplica si el estado es Programación Activada)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Fin Programada  <br>(Solo aplica si el estado es Programación Activada)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Fin Ampliada  <br>(Solo será diferente a la fecha Fin Programada si se aceptaron solicitudes de prórroga)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
            </tr>
            <tr v-for="submodulo, key in submodulos">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+1}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ submodulo.modulo }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ submodulo.submodulo }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
               <span class="label label-success"  v-if="submodulo.estado=='1'">Abierto (Programación Inactiva)</span>
               <span class="label label-primary "  v-if="submodulo.estado=='2'">Programación Activada</span>
               <span class="label label-default  bg-navy"  v-if="submodulo.estado=='0'">Cerrado (Programación Inactiva)</span>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ submodulo.fechaini | pasfechaVista }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ submodulo.fechafinProgramacion | pasfechaVista }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ submodulo.fechafin | pasfechaVista }}</td>

             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>

         
    <a href="#" v-if="submodulo.estado=='1' || submodulo.estado=='2'" class="btn bg-navy btn-sm" v-on:click.prevent="baja(submodulo)" data-placement="top" data-toggle="tooltip" title="Cerrar Módulo"><i class="fa fa-arrow-circle-down"></i></a>
      
    <a href="#" v-if="submodulo.estado=='0' || submodulo.estado=='2'" class="btn btn-success btn-sm" v-on:click.prevent="alta(submodulo)" data-placement="top" data-toggle="tooltip" title="Abrir Módulo"><i class="fa fa-check-circle"></i></a>


    <a href="#" v-if="(submodulo.estado=='1' || submodulo.estado=='0')" class="btn btn-primary btn-sm" v-on:click.prevent="programada(submodulo)" data-placement="top" data-toggle="tooltip" title="Activar Programación"><i class="fa fa-calendar"></i></a>
      
      {{--
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editbanco(banco)" data-placement="top" data-toggle="tooltip" title="Editar Banco"><i class="fa fa-edit"></i></a>
        --}}
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(submodulo)" data-placement="top" data-toggle="tooltip" title="Eliminar Programación"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>

      </div>



      {{-- 
      
      <form method="post" v-on:submit.prevent="updateBanco(fillBanco.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR BANCO</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Banco:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="form-group">
                        <label for="txtnomE" class="col-sm-2 control-label">Nombre:*</label>
      
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtnomE" name="txtnomE" placeholder="Nombre" maxlength="500" autofocus v-model="fillBanco.nombre" required>
                        </div>
                      </div>
                    </div>
      
       
                    <div class="col-md-12" style="padding-top: 15px;">
      
                      <div class="form-group">
                        <label for="cbuestadoE" class="col-sm-2 control-label">Estado:*</label>
      
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillBanco.activo">
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
      --}}