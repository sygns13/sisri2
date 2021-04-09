<form method="post" v-on:submit.prevent="update(fillactividaddes.id)">
  <div class="box-body" style="font-size: 14px;">

    <template v-if="1==1">

      <div class="col-md-12">
        <hr style="border-top: 3px solid #1b5f43;">
      </div>

      <center>
        <h4>Datos del Formulario</h4>
      </center>

      <div class="col-md-12">
        <div class="form-group">
          <p><b>Nota:</b> Los campos marcadosco <spam style="color:red;">*</spam> son obligatorios</p>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtactividadE" class="col-sm-2 control-label">Actividad:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtactividadE" name="txtactividadE" placeholder="Nombre de Actividad"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillactividaddes.actividad">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción de la Actividad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
            <textarea name="txtdescripcionE" id="txtdescripcionE" rows="6" v-model="fillactividaddes.descripcion" style="width:100%;"  @keydown="$event.keyCode === 13 ? $event.preventDefault() : false"></textarea>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtoficinasE" class="col-sm-2 control-label">Oficinas de apoyo:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtoficinasE" name="txtoficinasE" placeholder="Oficinas de Apoyo"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillactividaddes.oficinas">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtlugarE" class="col-sm-2 control-label">Lugar:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtlugarE" name="txtlugarE" placeholder="Lugar donde se desarrolló la actividad"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillactividaddes.lugar">
          </div>
        </div>
      </div>

  <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">

          <label for="txtbeneficiariosE" class="col-sm-2 control-label">Cantidad de Beneficiarios:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtbeneficiariosE" name="txtbeneficiariosE" placeholder=""
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="fillactividaddes.beneficiarios">
                </div>

                <label for="txtorganizadoresE" class="col-sm-2 control-label">Cantidad de Organizadores:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtorganizadoresE" name="txtorganizadoresE" placeholder="" onkeypress="return soloNumeros(event);"
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillactividaddes.organizadores">
                </div>

                <label for="txtfechaE" class="col-sm-2 control-label">Fecha de Actividad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechaE" name="txtfechaE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillactividaddes.fecha">
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