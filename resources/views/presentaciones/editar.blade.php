<form method="post" v-on:submit.prevent="update(fillpresentacions.id)">
  <div class="box-body" style="font-size: 14px;">

   
  

    <template v-if="1==1">

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">


                <label for="txtfechaE" class="col-sm-2 control-label">Fecha:*</label>
                <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechaE" name="txtfechaE" placeholder=" " maxlength="10"  v-model="fillpresentacions.fecha">
              </div>
            </div>
          </div>
        
              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">

                      <label for="txtdetalleE" class="col-sm-2 control-label">Detalles:</label>
                      <div class="col-sm-10">
<textarea name="txtdetalleE" id="txtdetalleE" rows="6" v-model="fillpresentacions.detalle" style="width:100%;" placeholder="Detalles de la Presentación"></textarea>


                    </div>
                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">

                  <label for="txtasistentesE" class="col-sm-2 control-label">Cantidad de Asistentes:*</label>
                  <div class="col-sm-2">
                      <input type="text" class="form-control" id="txtasistentesE" name="txtasistentesE" placeholder="" onkeypress="return soloNumeros(event);"
                        maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpresentacions.asistentes">
                    </div>


              </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">

                    <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                    <div class="col-sm-10">
<textarea name="txtobsE" id="txtobsE" rows="6" v-model="fillpresentacions.observaciones" style="width:100%;"></textarea>


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