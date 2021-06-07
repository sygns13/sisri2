<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Solicitudes de Prórroga</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('programacion')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver a Programaciones de Módulos</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
         {{--  <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Banco</button>
          </div>
      
      
      
           
            <div class="box-footer">
              <button type="button" class="btn btn-primary" onclick="enviarMSj();" id="btnEnviarMsj"><i class="fa fa-envelope-o" aria-hidden="true" ></i> Enviar Mensaje</button>
              <div id="divCarga0" style="display: inline-block;"><div id="dcarga0" style="display: none;"><img src="{{ asset('/img/ajax-loader.gif')}}"/></div></div>
            </div>
            --}}
      
          </div>
      
        </div>
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Programaciones Registradas</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Módulo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Submódulo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Título de Programación</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Inicio Programada</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Fin Programada</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha Fin Ampliada  <br>(Solo será diferente a la fecha Fin Programada si se aceptaron solicitudes de prórroga)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Cuenta con Solicitud de Prórroga</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Atender Solicitud</th>
            </tr>
            <tr v-for="programacion, key in programaciones">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+1}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.modulo }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.submodulo }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.titulo }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.fechaini | pasfechaVista }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.fechafin | pasfechaVista }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ programacion.fechafinSubmodulo | pasfechaVista }}</td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
<center>
              <span class="label label-success"  v-if="programacion.idProrroga != '0'"> Si</span>
              <span class="label label-default"  v-else> No</span>
</center>

              </td>

             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>
    <a href="#" v-if="programacion.idProrroga != '0'" class="btn btn-success btn-sm" v-on:click.prevent="atenderSolicitud(programacion)" data-placement="top" data-toggle="tooltip" title="Atender Solicitud"><i class="fa fa-check-square-o"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
      </div>

      
      
      <form method="post" v-on:submit.prevent="procesarSolicitud(fillprogramacion.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">ATENDER SOLICITUD DE PRÓRROGA DE AMPLIACIÓN DE PLAZO</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Solicitud:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="txtmodulo" class="col-sm-2 control-label">Módulo:</label>
        
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtmodulo" name="txtmodulo" placeholder="Modulo"   v-model="fillprogramacion.modulo"  readonly>
                          </div>
                        </div>
                      </div>


                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txtsubmodulo" class="col-sm-2 control-label">Submodulo:</label>
        
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtsubmodulo" name="txtsubmodulo" placeholder="Submodulo"   v-model="fillprogramacion.submodulo" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txttitulo" class="col-sm-2 control-label">Programación:</label>
        
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Titulo"   v-model="fillprogramacion.titulo" readonly>
                          </div>
                        </div>
                      </div>


                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txtfechaini" class="col-sm-2 control-label">Fecha de Inicio Programada:</label>
        
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechaini" name="txtfechaini" v-model="fillprogramacion.fechaini" readonly>
                          </div>

                          <label for="txtfechafin" class="col-sm-2 control-label">Fecha de Finalización Programada:</label>
        
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechafin" name="txtfechafin" v-model="fillprogramacion.fechafin" readonly>
                          </div>

                          <label for="txtfechafin" class="col-sm-2 control-label">Fecha Ampliada con solicitudes previas:</label>
        
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechafin" name="txtfechafin" v-model="fillprogramacion.fechafinSubmodulo" readonly>
                          </div>
                        </div>
                      </div>


                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txtusuarioProrroga" class="col-sm-2 control-label">Usuario que Solicita la Prórroga:</label>
        
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtusuarioProrroga" name="txtusuarioProrroga" placeholder=""   v-model="fillprogramacion.usuarioProrroga" readonly>
                          </div>
                        </div>
                      </div>


                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txtnumeroProrroga" class="col-sm-2 control-label">N° de solicitud para este periodo de prórroga:</label>
        
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtnumeroProrroga" name="txtnumeroProrroga" placeholder=""   v-model="fillprogramacion.numeroProrroga" readonly>
                          </div>

                          <label for="txtfechaProrroga" class="col-sm-2 control-label">Fecha de Solicitud:</label>
        
                          <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechaProrroga" name="txtfechaProrroga" v-model="fillprogramacion.fechaProrroga" readonly>
                          </div>

                          <label for="txthoraProrroga" class="col-sm-2 control-label">Hora de Solicitud:</label>
        
                          <div class="col-sm-2">
                            <input type="text" class="form-control" id="txthoraProrroga" name="txthoraProrroga" placeholder=""   v-model="fillprogramacion.horaProrroga" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
                          <label for="txtmotivoProrroga" class="col-sm-2 control-label">Sustento de Solicitud:</label>
        
                          <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="txtmotivoProrroga" name="txtmotivoProrroga" placeholder="Indique el Motivo de Solicitud de Prórroga de Ampliación" maxlength="5000"  v-model="fillprogramacion.motivoProrroga" readonly></textarea>
                          </div>
                        </div>

                    </div>

                    <div class="col-md-12">    
      <hr style="border: 1 px solid gray;">
                    </div>
       
                    <div class="col-md-12">
      
                      <div class="form-group">
                        <label for="cbuatencion" class="col-sm-2 control-label">Atención de la Solicitud (Administrador):</label>
      
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuatencion" name="cbuatencion" v-model="fillprogramacion.atencion">
                            <option value="2">Aceptar Solicitud</option>
                            <option value="0">Rechazar Solicitud</option>
                          </select>
                        </div>
                      </div>
      
                    </div>

                    <div class="col-md-12" style="padding-top: 15px;" v-if="fillprogramacion.atencion == '2'">
                      <div class="form-group">
            
       
                        <label for="txtnuevaFecha" class="col-sm-2 control-label">Fecha Fin de Ampliación:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtnuevaFecha" name="txtnuevaFecha" placeholder="dd/mm/aaaa"
                            maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillprogramacion.nuevaFecha">
                        </div>
                        <div class="col-sm-8">
                          <div style="color:red;"><b>Nota: La fecha de ampliación puede ser máximo de 7 días de plazo contando como día 1 el día de mañana</b></div>
                        </div>
            
            
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;">
      
                      <div class="form-group">
                        <label for="txtmotivoatencion" class="col-sm-2 control-label">Sustento de la Atención de la Solicitud (Administrador):</label>
      
                        <div class="col-sm-10">
                          <textarea type="text" class="form-control" id="txtmotivoatencion" name="txtmotivoatencion" placeholder="Indique el Motivo de Atención de la Solicitud" maxlength="5000" autofocus v-model="fillprogramacion.motivoatencion" ></textarea>
                        </div>
                      </div>
                    </div>
      
                  </div>
      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar Atención</button>
      
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