<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

   
    <template v-if="formularioCrear">



     


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">


                    <label for="txtfecha" class="col-sm-2 control-label">Fecha:*</label>
                    <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfecha" name="txtfecha" placeholder=" " maxlength="10"  v-model="fecha">
                  </div>

                </div>
              </div>


                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
  
                          <label for="txtdetalle" class="col-sm-2 control-label">Detalles:</label>
                          <div class="col-sm-10">
  <textarea name="txtdetalle" id="txtdetalle" rows="6" v-model="detalle" style="width:100%;" placeholder="Detalles de la Presentación"></textarea>
  
  
                        </div>
                      </div>
                    </div>

                   
 <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
              
                      <label for="txtasistentes" class="col-sm-2 control-label">Cantidad de Asistentes:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtasistentes" name="txtasistentes" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="asistentes">
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