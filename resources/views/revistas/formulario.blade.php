<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

    

    <template v-if="formularioCrear">


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbuescuela_id" class="col-sm-2 control-label">Escuela Profesional:*</label>
            <div class="col-sm-10">
                <select class="form-control" id="cbuescuela_id" name="cbuescuela_id" v-model="escuela_id">
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

              <label for="txttitulo" class="col-sm-2 control-label">Título:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Título de la Investigación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="tituloI">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:</label>
                <div class="col-sm-10">
<textarea name="txtdescripcion" id="txtdescripcion" rows="4" v-model="descripcion" style="width:100%;" placeholder="Descripción de la Investigación"></textarea>


              </div>
            </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">

            <div class="form-group">
              <label for="txtArchivoAdjunto" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtArchivoAdjunto" name="txtArchivoAdjunto" placeholder="Nombre del Archivo" maxlength="500" v-model="newNombreArchivo">
              </div>

              <div class="col-sm-8">
                 <input v-if="uploadReady" name="archivo2" type="file" id="archivo2" class="archivo form-control" @change="getArchivo" 
      accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

     

  
               </div>
            </div>

        </div>
           

        
          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
                <label for="txtresolucionAprobacion" class="col-sm-2 control-label">Resolución:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtresolucionAprobacion" name="txtresolucionAprobacion" placeholder="Resolución de Aprobación"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="resolucionAprobacion">
                </div>
  
              </div>
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                  <label for="txtclasificacion" class="col-sm-2 control-label">Clasificación:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtclasificacion" name="txtclasificacion" placeholder="Clasificación de la Investigación"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="clasificacion">
                  </div>

                  <label for="txtlineainvestigacion" class="col-sm-2 control-label">Línea de Investigación:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtlineainvestigacion" name="txtlineainvestigacion" placeholder="Línea de la Investigación"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="lineainvestigacion">
                  </div>
    
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
      
                    <label for="txtfinanciamiento" class="col-sm-2 control-label">Financiamiento:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtfinanciamiento" name="txtfinanciamiento" placeholder="Financiamiento de la Investigación"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="financiamiento">
                    </div>

                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
  
  
                        <label for="txtpresupuestoAsignado" class="col-sm-2 control-label">Presupuesto Asignado (S/.):*</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpresupuestoAsignado" name="txtpresupuestoAsignado" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="presupuestoAsignado">
                          </div>
  
                          <label for="txtpresupuestoEjecutado" class="col-sm-2 control-label">Presupuesto Ejecutado (S/.):*</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpresupuestoEjecutado" name="txtpresupuestoEjecutado" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="presupuestoEjecutado">
                          </div>
  
  
                    </div>
                  </div>

           

                <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
                <label for="cbuestado" class="col-sm-2 control-label">Estado de Investigación:*</label>
                <div class="col-sm-2">
                    <select class="form-control" id="cbuestado" name="cbuestado" v-model="estado">
                      <option value="1">En Ejecución</option>
                      <option value="0">Finalizado</option>
                      <option value="2">Cancelado</option>
   
                    </select>
                  </div>


                  <label for="txtfechaInicio" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaInicio" name="txtfechaInicio" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaInicio">
                </div>

<template v-if="parseInt(estado)!=1">  
                <label for="txtfechaTermino" class="col-sm-2 control-label">Fecha de Término:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaTermino" name="txtfechaTermino" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaTermino">
                </div>
                </template>    
              </div>
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">


                    <label for="txthoras" class="col-sm-2 control-label">Horas Dedicadas a la Investigación:*</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="txthoras" name="txthoras" placeholder="" onkeypress="return soloNumeros(event);"
                          maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="horas">
                      </div>

                      <label for="txtavance" class="col-sm-2 control-label">Porcentaje de Avance (%):*</label>
                    <div class="col-sm-2">
                      <input type="text" class="form-control" id="txtavance" name="txtavance" placeholder="" onkeypress="return soloNumeros(event);"
                          maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="avance">
                      </div>


                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                 
                  <label for="cbuestado" class="col-sm-2 control-label">Se encuentra Patentado:*</label>
                  <div class="col-sm-2">
                      <select class="form-control" id="cbuestado" name="cbuestado" v-model="patentado">
                        <option value="1">Si</option>
                        <option value="0">No</option>
     
                      </select>
                    </div>
  
                </div>
              </div>


                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">

                                      <label for="txtobservaciones" class="col-sm-2 control-label">Observaciones:</label>
                                      <div class="col-sm-10">
<textarea name="txtobservaciones" id="txtobservaciones" rows="4" v-model="observaciones" style="width:100%;"></textarea>

  
                                    </div>
                                  </div>
                                </div>

    </template>

  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button v-if="formularioCrear" type="submit" class="btn btn-info" id="btnGuardar"><span
        class="fa fa-floppy-o"></span> Guardar</button>

    <button v-if="formularioCrear" type="reset" class="btn btn-warning" id="btnCancel"
      @click="cancelFormNuevo()"><span class="fa fa-rotate-left"></span> Cancelar</button>

    <button type="button" class="btn btn-danger" id="btnClose" @click.prevent="cerrarFormNuevo()"><span
        class="fa fa-power-off"></span> Cerrar</button>

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