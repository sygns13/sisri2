<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">



    <template v-if="formularioCrear">


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
          <label for="txtactividad" class="col-sm-2 control-label">Actividad:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtactividad" name="txtactividad" placeholder="Nombre de Actividad"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="actividad">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtdescripcion" class="col-sm-2 control-label">Descripción de la Actividad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
            <textarea name="txtdescripcion" id="txtdescripcion" rows="6" v-model="descripcion" style="width:100%;"  @keydown="$event.keyCode === 13 ? $event.preventDefault() : false"></textarea>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtoficinas" class="col-sm-2 control-label">Oficinas de apoyo:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtoficinas" name="txtoficinas" placeholder="Oficinas de Apoyo"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="oficinas">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtlugar" class="col-sm-2 control-label">Lugar:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtlugar" name="txtlugar" placeholder="Lugar donde se desarrolló la actividad"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="lugar">
          </div>
        </div>
      </div>

  <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">

          <label for="txtbeneficiarios" class="col-sm-2 control-label">Cantidad de Beneficiarios:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtbeneficiarios" name="txtbeneficiarios" placeholder=""
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="beneficiarios">
                </div>

                <label for="txtorganizadores" class="col-sm-2 control-label">Cantidad de Organizadores:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtorganizadores" name="txtorganizadores" placeholder="" onkeypress="return soloNumeros(event);"
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="organizadores">
                </div>

                <label for="txtfecha" class="col-sm-2 control-label">Fecha de Actividad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfecha" name="txtfecha" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fecha">
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