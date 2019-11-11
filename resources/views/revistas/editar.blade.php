<form method="post" v-on:submit.prevent="update(fillinvestigacion.id)">
  <div class="box-body" style="font-size: 14px;">

   
   

    <template v-if="1==1">


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbuescuela_idE" class="col-sm-2 control-label">Escuela Profesional:*</label>
            <div class="col-sm-10">
                <select class="form-control" id="cbuescuela_idE" name="cbuescuela_idE" v-model="fillinvestigacion.escuela_id">
                    <option value="0" disabled>Seleccione un Programa Profesional...</option>
                  @foreach ($escuelas as $dato)
                  <option value="{{$dato->id}}">{{$dato->nombre}}</option>     
                  @endforeach                   
                </select>
              </div>

          </div>
        </div>

            <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

              <label for="txttituloE" class="col-sm-2 control-label">Título:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txttituloE" name="txttituloE" placeholder="Título de la Investigación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.titulo">
              </div>

            </div>
          </div>




          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:</label>
                <div class="col-sm-10">
<textarea name="txtdescripcionE" id="txtdescripcionE" rows="4" v-model="fillinvestigacion.descripcion" style="width:100%;" placeholder="Descripción de la Investigación"></textarea>


              </div>
            </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">

            <div class="form-group">
              <label for="txtArchivoAdjuntoE" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtArchivoAdjuntoE" name="txtArchivoAdjuntoE" placeholder="Nombre del Archivo" maxlength="500"  v-model="fillinvestigacion.archivonombre">
              </div>

              <div class="col-sm-8" v-if="uploadReadyE">
                 <input  name="archivo2E" type="file" id="archivo2E" class="archivo form-control" @change="getArchivoE" 
      accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

     

  
               </div>
            </div>

        </div>  




          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
                <label for="txtresolucionAprobacionE" class="col-sm-2 control-label">Resolución:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtresolucionAprobacionE" name="txtresolucionAprobacionE" placeholder="Resolución de Aprobación"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.resolucionAprobacion">
                </div>
  
              </div>
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                  <label for="txtclasificacionE" class="col-sm-2 control-label">Clasificación:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtclasificacionE" name="txtclasificacionE" placeholder="Clasificación de la Investigación"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.clasificacion">
                  </div>

                  <label for="txtlineainvestigacionE" class="col-sm-2 control-label">Línea de Investigación:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtlineainvestigacionE" name="txtlineainvestigacionE" placeholder="Línea de la Investigación"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.lineainvestigacion">
                  </div>
    
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
      
                    <label for="txtfinanciamientoE" class="col-sm-2 control-label">Financiamiento:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtfinanciamientoE" name="txtfinanciamientoE" placeholder="Financiamiento de la Investigación"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.financiamiento">
                    </div>

                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
  
  
                        <label for="txtpresupuestoAsignadoE" class="col-sm-2 control-label">Presupuesto Asignado (S/.):*</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpresupuestoAsignadoE" name="txtpresupuestoAsignadoE" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.presupuestoAsignado">
                          </div>
  
                          <label for="txtpresupuestoEjecutadoE" class="col-sm-2 control-label">Presupuesto Ejecutado (S/.):*</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpresupuestoEjecutadoE" name="txtpresupuestoEjecutadoE" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.presupuestoEjecutado">
                          </div>
  
  
                    </div>
                  </div>

           

                <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
                <label for="cbuestadoE" class="col-sm-2 control-label">Estado de Investigación:*</label>
                <div class="col-sm-2">
                    <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillinvestigacion.estado">
                      <option value="1">En Ejecución</option>
                      <option value="0">Finalizado</option>
                      <option value="2">Cancelado</option>
   
                    </select>
                  </div>


                  <label for="txtfechaInicioE" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaInicioE" name="txtfechaInicioE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.fechaInicio">
                </div>

<template v-if="parseInt(fillinvestigacion.estado)!=1">  
                <label for="txtfechaTerminoE" class="col-sm-2 control-label">Fecha de Término:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaTerminoE" name="txtfechaTerminoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.fechaTermino">
                </div>
                </template>    
              </div>
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">


                    <label for="txthorasE" class="col-sm-2 control-label">Horas Dedicadas a la Investigación:*</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="txthorasE" name="txthorasE" placeholder="" onkeypress="return soloNumeros(event);"
                          maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.horas">
                      </div>

                      <label for="txtavanceE" class="col-sm-2 control-label">Porcentaje de Avance (%):*</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="txtavanceE" name="txtavanceE" placeholder="" onkeypress="return soloNumeros(event);"
                          maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillinvestigacion.avance">
                      </div>


                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                 
                  <label for="cbuestadoE" class="col-sm-2 control-label">Se encuentra Patentado:*</label>
                  <div class="col-sm-2">
                      <select class="form-control" id="cbuestadoE" name="cbuestadoE" v-model="fillinvestigacion.patentado">
                        <option value="1">Si</option>
                        <option value="0">No</option>
     
                      </select>
                    </div>
  
                </div>
              </div>


                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">

                                      <label for="txtobservacionesE" class="col-sm-2 control-label">Observaciones:</label>
                                      <div class="col-sm-10">
<textarea name="txtobservacionesE" id="txtobservacionesE" rows="4" v-model="fillinvestigacion.observaciones" style="width:100%;"></textarea>

  
                                    </div>
                                  </div>
                                </div>

    

    </template>


 

   




  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i>
      Modificar</button>

    <button type="button" class="btn btn-danger" id="btnCloseE" @click.prevent="cerrarFormE()"><span
      class="fa fa-power-off"></span> Cancelar</button>

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
  <!-- /.box-footer -->

</form>