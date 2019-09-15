<form method="post" v-on:submit.prevent="update(fillatenciones.id)">
  <div class="box-body" style="font-size: 14px;">

   
  

    <template v-if="1==1">

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                  <label for="txtanioE" class="col-sm-2 control-label">Año:*</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" id="txtanioE" name="txtanioE" placeholder="" onkeypress="return soloNumeros(event);"
                        maxlength="4" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillatenciones.anio">
                    </div>

                    <label for="cbumesE" class="col-sm-2 control-label">Mes:*</label>

                    <div class="col-sm-2">
                        <select class="form-control" id="cbumesE" name="cbumesE" v-model="fillatenciones.mes">
                          <option value="0" disabled>Seleccione un Mes de atención...</option>
                          <option value="1">Enero</option>
                          <option value="2">Febrero</option>
                          <option value="3">Marzo</option>
                          <option value="4">Abril</option>
                          <option value="5">Mayo</option>
                          <option value="6">Junio</option>
                          <option value="7">Julio</option>
                          <option value="8">Agosto</option>
                          <option value="9">Setiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>

                        </select>
                      </div>

              </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">


                    <label for="cbutipobeneficiarioE" class="col-sm-2 control-label">Tipo de Beneficiario:*</label>

                    <div class="col-sm-2">
                        <select class="form-control" id="cbutipobeneficiarioE" name="cbutipobeneficiarioE" v-model="fillatenciones.tipobeneficiario">
                          <option value="1">Alumno</option>
                          <option value="2">Docente</option>
                          <option value="3">Personal Administrativo</option>
                       </select>
                      </div>


    
                      <label for="txtcantidadE" class="col-sm-2 control-label">Cantida de Atenciones:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtcantidadE" name="txtcantidadE" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillatenciones.cantidad">
                        </div>
    
                     
    
             
    
                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">

                        <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                        <div class="col-sm-10">
<textarea name="txtobsE" id="txtobsE" rows="6" v-model="fillatenciones.observaciones" style="width:100%;"></textarea>


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