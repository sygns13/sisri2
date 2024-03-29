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
        <h4>Datos Personales del Alumno</h4>
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
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugenero" class="col-sm-2 control-label">Género:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugenero" name="cbugenero" v-model="genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanac" class="col-sm-2 control-label">Fecha de Nacimiento:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanac" name="txtfechanac" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechanac">
            </div>

            <label for="cbuestadocivil" class="col-sm-2 control-label">Estado Civil:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivil" name="cbuestadocivil" v-model="estadocivil">
                  <option value="1">Soltero (a)</option>
                  <option value="2">Casado (a)</option>
                  <option value="3">Viudo (a)</option>
                  <option value="4">Divorsiado (a)</option>
                </select>
              </div>

          </div>
        </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="cbugenero" class="col-sm-2 control-label">Sufre Discapacidad:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                  <select class="form-control" id="cbugenero" name="cbugenero" v-model="esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="esdiscapacitado=='1'">
                <label for="txtdiscapacidad" class="col-sm-2 control-label">Discapacidad que Padece:<spam style="color:red;">*</spam></label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidad" name="txtdiscapacidad" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpais" class="col-sm-2 control-label">Pais de Procedencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpais" name="txtpais" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="pais">
                </div>

                <label for="txtdep" class="col-sm-2 control-label">Departamento:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdep" name="txtdep" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprov" class="col-sm-2 control-label">Provincia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprov" name="txtprov" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="provincia">
                </div>

                <label for="txtdist" class="col-sm-2 control-label">Distrito:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdist" name="txtdist" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDir" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDir" name="txtDir" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="direccion">
                </div>
  
                <label for="txtemail" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfono" class="col-sm-2 control-label">Teléfono:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="telefono">
                  </div>
  
 
              </div>
            </div>


        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
              <label for="txtcorreoinstitucional" class="col-sm-2 control-label">Correo Institucional:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
          <input type="text" class="form-control" id="txtcorreoinstitucional" name="txtcorreoinstitucional" placeholder="Correo Institucional"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="correoinstitucional">
            </div>

              <label for="txtidentidadetnica" class="col-sm-2 control-label">Identidad Étnica: </label>
              <div class="col-sm-4">
          <input type="text" class="form-control" id="txtidentidadetnica" name="txtidentidadetnica" placeholder="Identidad Étnica"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="identidadetnica">
            </div>
          </div>
        </div>



      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos Académicos</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">


                <label for="cbugrado" class="col-sm-2 control-label">Grado:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                <select class="form-control" id="cbugrado" name="cbugrado" v-model="grado">
                    <option value="3">Maestría</option>                        
                    <option value="4">Doctorado</option>                                               
                  </select>
                </div>

                <label for="txtgrado" class="col-sm-2 control-label">Denominación de Grado y Mensión:<spam style="color:red;">*</spam></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtgrado" name="txtgrado" placeholder="Nombre de Grado y Mensión"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombreGrado">
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

              <label for="cbuEscalaPago" class="col-sm-2 control-label">Escala de Pago:<spam style="color:red;">*</spam></label>
              <div class="col-sm-3">
                  <select class="form-control" id="cbuEscalaPago" name="cbuEscalaPago" v-model="escalaPago">
                      <option value="0">Ninguna</option>                        
                      <option value="1">Si Cuenta con Escala de Pago</option>                                           
                    </select>
                  </div>


            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(escalaPago)!=0">
              <div class="form-group">
  
                  <label for="txtEsclaPago" class="col-sm-2 control-label">Describa su Escala de Pago:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtEsclaPago" name="txtEsclaPago" placeholder="Escala de Pago"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="escalaPagodesc">
                  </div>
  
 
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">


                      <label for="txtpromedioponderado" class="col-sm-2 control-label">Promedio Ponderado:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtpromedioponderado" name="txtpromedioponderado" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="promedioPonderado">
                        </div>

                        <label for="txtpromediosemestre" class="col-sm-2 control-label">Promedio del Semestre:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtpromediosemestre" name="txtpromediosemestre" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="promedioSemestre">
                        </div>


                  </div>
                </div>



          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
                <label for="cbumaxgrado" class="col-sm-2 control-label">Máximo Grado Académico:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <select class="form-control" id="cbumaxgrado" name="cbumaxgrado" v-model="maximogrado">
                      <option value="0">Sin grado</option>                        
                      <option value="Primaria completa">Primaria completa</option>                        
                      <option value="Secundaria completa">Secundaria completa</option>                        
                      <option value="Técnico">Técnico</option>                        
                      <option value="Bachiller">Bachiller</option>                        
                      <option value="Maestro">Maestro</option>                        
                      <option value="Doctor">Doctor</option>                                             
                    </select>
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