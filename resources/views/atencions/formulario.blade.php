<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

   
    <template v-if="formularioCrear">

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                  <label for="txtanio" class="col-sm-2 control-label">Año:*</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" id="txtanio" name="txtanio" placeholder="" onkeypress="return soloNumeros(event);"
                        maxlength="4" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="anio">
                    </div>

                    <label for="cbumes" class="col-sm-2 control-label">Mes:*</label>

                    <div class="col-sm-2">
                        <select class="form-control" id="cbumes" name="cbumes" v-model="mes">
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


                    <label for="cbutipobeneficiario" class="col-sm-2 control-label">Tipo de Beneficiario:*</label>

                    <div class="col-sm-2">
                        <select class="form-control" id="cbutipobeneficiario" name="cbutipobeneficiario" v-model="tipobeneficiario">
                          <option value="1">Alumno</option>
                          <option value="2">Docente</option>
                          <option value="3">Personal Administrativo</option>
                       </select>
                      </div>


    
                      <label for="txtcantidad" class="col-sm-2 control-label">Cantida de Atenciones:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtcantidad" name="txtcantidad" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="cantidad">
                        </div>
    
                     
    
             
    
                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">

                        <label for="txtobs" class="col-sm-2 control-label">Observaciones:</label>
                        <div class="col-sm-10">
<textarea name="txtobs" id="txtobs" rows="6" v-model="observaciones" style="width:100%;"></textarea>


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