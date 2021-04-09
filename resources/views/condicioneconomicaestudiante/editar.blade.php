<form method="post" v-on:submit.prevent="update(fillalumnos.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:<spam style="color:red;">*</spam></label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="fillalumnos.tipodoc">
                <option value="1">DNI</option>
                <option value="2">RUC</option>
                <option value="3">Carnet de Extranjería</option>
                <option value="4">Pasaporte</option>
                <option value="5">Partida de Nacimiento</option>
              </select>
            </div>



        <label for="txtDNIE" class="col-sm-1 control-label">Documento:<spam style="color:red;">*</spam></label>

        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtDNIE" name="txtDNIE" placeholder="N° de Doc" maxlength="20"
            autofocus v-model="fillalumnos.doc" required
            @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" :disabled="validated == 1"
           >
        </div>

      </div>



    </div>

    <template v-if="1==1">


      <div class="col-md-12">
        <hr style="border-top: 3px solid rgb(208, 211, 51);">
      </div>

      <center>
        <h4>Datos Formulario</h4>
      </center>

      <div class="col-md-12">
        <div class="form-group">
          <p><b>Nota:</b> Los campos marcadosco <spam style="color:red;">*</spam> son obligatorios</p>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepatE" class="col-sm-2 control-label">Apellido Paterno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepatE" name="txtapepatE" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.nombres">
          </div>
        </div>
      </div>


    <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">

            <label for="txtcodigoE" class="col-sm-2 control-label">Código del Alumno:</label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="txtcodigoE" name="txtcodigoE" placeholder="Código"
                maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.codigo">
            </div>


            <label for="txtnumhermanosE" class="col-sm-2 control-label">Nro de hermanos(as):<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtnumhermanosE" name="txtnumhermanosE" placeholder=""
                      maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="fillalumnos.numhermanos">
                  </div>
  
                  <label for="txtnumhermanosunasamE" class="col-sm-2 control-label">Nro de hermanos(as) que estudian en la UNASAM:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtnumhermanosunasamE" name="txtnumhermanosunasamE" placeholder="" onkeypress="return soloNumeros(event);"
                      maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.numhermanosunasam">
                  </div>
            </div>
          </div>
  
          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
              <label for="txtpuestopadreE" class="col-sm-2 control-label">Puesto Laboral que desempeña el Padre u Apoderado:<spam style="color:red;">*</spam></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtpuestopadreE" name="txtpuestopadreE" placeholder="Puesto Laboral del Padre o Apoderado"
                  maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.puestopadre">
              </div>
            </div>
          </div>
  
          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
              <label for="txtpuestomadreE" class="col-sm-2 control-label">Puesto Laboral que desempeña la Madre u Apoderado:<spam style="color:red;">*</spam></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtpuestomadreE" name="txtpuestomadreE" placeholder="Puesto Laboral de la Madre o Apoderado"
                  maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.puestomadre">
              </div>
            </div>
          </div>
  
  
  
        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
                <label for="txtingresomensualfamiliar" class="col-sm-2 control-label">Ingreso Económico Mensual Familiar:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtingresomensualfamiliar" name="txtingresomensualfamiliar" placeholder="0.00"
                      maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="fillalumnos.ingresomensualfamiliar">
                  </div>
  
                  <label for="txtcondicionviiviendaE" class="col-sm-2 control-label">Condición de la Vivienda:<spam style="color:red;">*</spam></label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="txtcondicionviiviendaE" name="txtcondicionviiviendaE" placeholder="Condición de la Vivienda"
                  maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.condicionviivienda">
                  </div>
            </div>
          </div>
  
  
          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
              <label for="cbutieneseguroE" class="col-sm-2 control-label">¿El estudiante cuenta con seguro de salud?:<spam style="color:red;">*</spam></label>
  
              <div class="col-sm-2">
                <select class="form-control" id="cbutieneseguroE" name="cbutieneseguroE" v-model="fillalumnos.tieneseguro">
                    <option value="0">No</option>                        
                    <option value="1">Si</option>                                           
                  </select>
                </div>
            
                <template v-if="fillalumnos.tieneseguro!='0'">
                    <label for="txtnombreseguroE" class="col-sm-2 control-label">Nombre del Seguro:<spam style="color:red;">*</spam></label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="txtnombreseguroE" name="txtnombreseguroE" placeholder="Nombre del Seguro de Salud del Estudiante"
                        maxlength="200" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.nombreseguro">
                    </div>
                  </template>
    
                </div>
              </div>
  
  
              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
      
                  <label for="cbuestalaborandoE" class="col-sm-2 control-label">¿El estudiante se encuentra laborando actualmente?:<spam style="color:red;">*</spam></label>
      
                  <div class="col-sm-2">
                    <select class="form-control" id="cbuestalaborandoE" name="cbuestalaborandoE" v-model="fillalumnos.estalaborando">
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