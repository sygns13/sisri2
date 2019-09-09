<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodoc" class="col-sm-1 control-label">Tipo de Doc:*</label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodoc" name="cbutipodoc" v-model="tipodoc">
                <option value="1">DNI</option>
                <option value="2">RUC</option>
                <option value="3">Carnet de Extranjería</option>
                <option value="4">Pasaporte</option>
                <option value="5">Partida de Nacimiento</option>
              </select>
            </div>



        <label for="txtDNI" class="col-sm-1 control-label">Documento:*</label>

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
        <h4>Datos Personales del Postulante</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepat" class="col-sm-2 control-label">Apellido Paterno:*</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepat" name="txtapepat" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidopat">
          </div>

          <label for="txtapemat" class="col-sm-2 control-label">Apellido Materno:*</label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapemat" name="txtapemat" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombres" class="col-sm-2 control-label">Nombres:*</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugenero" class="col-sm-2 control-label">Género:*</label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugenero" name="cbugenero" v-model="genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanac" class="col-sm-2 control-label">Fecha de Nacimiento:*</label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanac" name="txtfechanac" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechanac">
            </div>

            <label for="cbuestadocivil" class="col-sm-2 control-label">Estado Civil:*</label>
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

                <label for="cbugenero" class="col-sm-2 control-label">Sufre Discapacidad:*</label>
                <div class="col-sm-2">
                  <select class="form-control" id="cbugenero" name="cbugenero" v-model="esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="esdiscapacitado=='1'">
                <label for="txtdiscapacidad" class="col-sm-2 control-label">Discapacidad que Padece:*</label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidad" name="txtdiscapacidad" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpais" class="col-sm-2 control-label">Pais de Procedencia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpais" name="txtpais" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="pais">
                </div>

                <label for="txtdep" class="col-sm-2 control-label">Departamento:*</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdep" name="txtdep" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprov" class="col-sm-2 control-label">Provincia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprov" name="txtprov" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="provincia">
                </div>

                <label for="txtdist" class="col-sm-2 control-label">Distrito:*</label>
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
  
                  <label for="txtfono" class="col-sm-2 control-label">Teléfono:*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfono" name="txtfono" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="telefono">
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


            <label for="cbucarrera" class="col-sm-2 control-label">Escuela Profesional:*</label>
            <div class="col-sm-10">
                <select class="form-control" id="cbucarrera" name="cbucarrera" v-model="escuela_id">
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

              <label for="txtcodigo" class="col-sm-2 control-label">Código del Alumno:</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="txtcodigo" name="txtcodigo" placeholder="Código"
                  maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="codigo">
              </div>

            </div>
          </div>




            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">


                      <label for="txtpromedioponderado" class="col-sm-2 control-label">Promedio Ponderado:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtpromedioponderado" name="txtpromedioponderado" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="promedioPonderado">
                        </div>

                        <label for="txtpromediosemestre" class="col-sm-2 control-label">Promedio del Semestre:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtpromediosemestre" name="txtpromediosemestre" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="promedioSemestre">
                        </div>


                  </div>
                </div>



                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
                      

          <label for="cbusemestreingreso" class="col-sm-2 control-label">Semestre de Ingreso a la Universidad:*</label>
          <div class="col-sm-3">
              <select class="form-control" id="cbusemestreingreso" name="cbusemestreingreso" v-model="periodoIngreso">
                <option value="0" disabled>Seleccione un Semestre...</option>
                @foreach ($semestres as $dato)
                <option value="{{$dato->id}}" selected>{{$dato->nombre}}</option>                        
                @endforeach
              </select>
            </div>

                          

    
            <label for="cbuprimersemestre" class="col-sm-2 control-label">Primer Semestre de Matrícula:*</label>
                <div class="col-sm-3">
                    <select class="form-control" id="cbuprimersemestre" name="cbuprimersemestre" v-model="primerPeriodoMatricula">
                      <option value="0" disabled>Seleccione un Semestre...</option>
                      @foreach ($semestres as $dato)
                      <option value="{{$dato->id}}" selected>{{$dato->nombre}}</option>                        
                      @endforeach
                    </select>
                  </div>


                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
                      <label for="cbuegresadoOtraCarrera" class="col-sm-2 control-label">Es egresado de Otra Carrera:*</label>
                      <div class="col-sm-2">
                          <select class="form-control" id="cbuegresadoOtraCarrera" name="cbuegresadoOtraCarrera" v-model="egresadoOtraCarrera">
                              <option value="0">No</option>                        
                              <option value="1">Si</option>                                           
                            </select>
                          </div>
        
        
                    </div>
                  </div>

              <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(egresadoOtraCarrera)!=0">
                  <div class="form-group">
      
                      <label for="txtotracarrera" class="col-sm-3 control-label">Ingrese su Otra Carrera de Egreso:*</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtotracarrera" name="txtotracarrera" placeholder=""
                          maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="otraCarrera">
                      </div>

                  </div>
                </div>



                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
                        <label for="cbutituladootracarrera" class="col-sm-2 control-label">Es Titulado de Otra Carrera:*</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="cbutituladootracarrera" name="cbutituladootracarrera" v-model="tituladoOtraCarrera">
                                <option value="0">No</option>                        
                                <option value="1">Si</option>                                           
                              </select>
                            </div>
          
          
                      </div>
                    </div>
  
                <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tituladoOtraCarrera)!=0">
                    <div class="form-group">
        
                        <label for="txttitulootracarrera" class="col-sm-3 control-label">Ingrese el Título de su Otra Carrera:*</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txttitulootracarrera" name="txttitulootracarrera" placeholder=""
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="otrotitulo">
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