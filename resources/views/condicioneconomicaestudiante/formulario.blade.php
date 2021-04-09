<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodoc" class="col-sm-1 control-label">Tipo de Doc:<spam style="color:red;">*</spam></label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodoc" name="cbutipodoc" v-model="tipodoc">
                <option value="1">DNI</option>
                <option value="2">RUC</option>
                <option value="3">Carnet de Extranjería</option>
                <option value="4">Pasaporte</option>
                <option value="5">Partida de Nacimiento</option>
              </select>
            </div>



        <label for="txtDNI" class="col-sm-1 control-label">Documento:<spam style="color:red;">*</spam></label>

        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtDNI" name="txtDNI" placeholder="N° de Doc" maxlength="20"
            autofocus v-model="doc" @keyup.enter="pressNuevoDNI()" required
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"
           >
        </div>
        <div class="col-sm-6">
          <a href="#" class="btn btn-success btn-sm" v-on:click.prevent="pressNuevoDNI()"><span
              class="  fa fa-check-square-o"></span> Validar</a>
        </div>
      </div>



    </div>

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
          <label for="txtapepat" class="col-sm-2 control-label">Apellido Paterno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepat" name="txtapepat" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidopat">
          </div>

          <label for="txtapemat" class="col-sm-2 control-label">Apellido Materno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapemat" name="txtapemat" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombres" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombres">
          </div>
        </div>
      </div>


  <div class="col-md-12" style="padding-top: 15px;">
      <div class="form-group">

          <label for="txtcodigo" class="col-sm-2 control-label">Código del Alumno:</label>
          <div class="col-sm-2">
            <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" placeholder="Código"
              maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="codigo">
          </div>

          <label for="txtnumhermanos" class="col-sm-2 control-label">Nro de hermanos(as):<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtnumhermanos" name="txtnumhermanos" placeholder=""
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="numhermanos">
                </div>

                <label for="txtnumhermanosunasam" class="col-sm-2 control-label">Nro de hermanos(as) que estudian en la UNASAM:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtnumhermanosunasam" name="txtnumhermanosunasam" placeholder="" onkeypress="return soloNumeros(event);"
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="numhermanosunasam">
                </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="txtpuestopadre" class="col-sm-2 control-label">Puesto Laboral que desempeña el Padre u Apoderado:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtpuestopadre" name="txtpuestopadre" placeholder="Puesto Laboral del Padre o Apoderado"
                maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="puestopadre">
            </div>
          </div>
        </div>

        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="txtpuestomadre" class="col-sm-2 control-label">Puesto Laboral que desempeña la Madre u Apoderado:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txtpuestomadre" name="txtpuestomadre" placeholder="Puesto Laboral de la Madre o Apoderado"
                maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="puestomadre">
            </div>
          </div>
        </div>



      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
              <label for="txtingresomensualfamiliar" class="col-sm-2 control-label">Ingreso Económico Mensual Familiar:<spam style="color:red;">*</spam></label>
              <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtingresomensualfamiliar" name="txtingresomensualfamiliar" placeholder="0.00"
                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="ingresomensualfamiliar">
                </div>

                <label for="txtcondicionviivienda" class="col-sm-2 control-label">Condición de la Vivienda:<spam style="color:red;">*</spam></label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="txtcondicionviivienda" name="txtcondicionviivienda" placeholder="Condición de la Vivienda"
                maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="condicionviivienda">
                </div>
          </div>
        </div>


        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

            <label for="cbutieneseguro" class="col-sm-2 control-label">¿El estudiante cuenta con seguro de salud?:<spam style="color:red;">*</spam></label>

            <div class="col-sm-2">
              <select class="form-control" id="cbutieneseguro" name="cbutieneseguro" v-model="tieneseguro">
                  <option value="0">No</option>                        
                  <option value="1">Si</option>                                           
                </select>
              </div>
          
              <template v-if="tieneseguro!='0'">
                  <label for="txtnombreseguro" class="col-sm-2 control-label">Nombre del Seguro:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtnombreseguro" name="txtnombreseguro" placeholder="Nombre del Seguro de Salud del Estudiante"
                      maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombreseguro">
                  </div>
                </template>
  
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                <label for="cbuestalaborando" class="col-sm-2 control-label">¿El estudiante se encuentra laborando actualmente?:<spam style="color:red;">*</spam></label>
    
                <div class="col-sm-2">
                  <select class="form-control" id="cbuestalaborando" name="cbuestalaborando" v-model="estalaborando">
                      <option value="0">No</option>                        
                      <option value="1">Si</option>                                           
                    </select>
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