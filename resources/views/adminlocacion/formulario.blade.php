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
        <h4>Datos Personales del Personal Administrativo por Locación de Servicios</h4>
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
      </div>
    </div>

      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos Laborales del Personal Administrativo por Locación de Servicios</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                <label for="cbulocal" class="col-sm-2 control-label">Local:<spam style="color:red;">*</spam></label>
                <div class="col-sm-10">
                    <select class="form-control" id="cbulocal" name="cbulocal" v-model="local_id">
                      <option value="0" disabled>Seleccione Local...</option>
                      @foreach ($locals as $dato)
                        <option value="{{$dato->id}}">{{$dato->nombre}}</option>     
                      @endforeach 
                    </select>
                  </div>
    
              </div>
            </div>

        <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
                <label for="cbutipodependencia" class="col-sm-2 control-label">Tipo de Dependencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-10">
                    <select class="form-control" id="cbutipodependencia" name="cbutipodependencia" v-model="tipoDependencia">
                    <option value="0" disabled>Seleccione Tipo de Dependencia...</option>

                      <option value="0">Unidad orgánica</option>
                      <option value="1">Dirección general</option>
                      <option value="2">Consejo asesor</option>
                      <option value="3">Unidad académica</option>
                      <option value="4">Unidad de investigación</option>
                      <option value="5">Unidad de formación continua</option>
                      <option value="6">Área de administración</option>
                      <option value="7">Área de calidad o secretaria académica</option>
                      <option value="8">Unidad de bienestar y empleabilidad</option>
                      <option value="9">Facultad</option>
                      <option value="10">Escuela profesional</option>
                    </select>
                  </div>
    
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tipoDependencia)<9">
          <div class="form-group">

              <label for="txtdependencia" class="col-sm-2 control-label">Dependencia:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtdependencia" name="txtdependencia" placeholder="Nombre de la Dependencia"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="dependencia">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tipoDependencia)==9">
        <div class="form-group">

            <label for="cbufacultad" class="col-sm-2 control-label">Facultad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
                <select class="form-control" id="cbufacultad" name="cbufacultad" v-model="facultad">
                    <option value="0" disabled>Seleccione una Facultad..</option>
                  @foreach ($facultads as $dato)
                  <option value="{{$dato->nombre}}">{{$dato->nombre}}</option>     
                  @endforeach                   
                </select>
              </div>

          </div>
        </div>





      <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tipoDependencia)==10">
        <div class="form-group">


            <label for="cbucarrera" class="col-sm-2 control-label">Escuela Profesional:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
                <select class="form-control" id="cbucarrera" name="cbucarrera" v-model="escuela">
                    <option value="0" disabled>Seleccione una Escuela Profesional...</option>
                  @foreach ($escuelas as $dato)
                  <option value="{{$dato->nombre}}">{{$dato->nombre}}</option>     
                  @endforeach                   
                </select>
              </div>

          </div>
        </div>


        <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                <label for="cbucargo" class="col-sm-2 control-label">Cargo:<spam style="color:red;">*</spam></label>
  
                <div class="col-sm-4">
                  <select class="form-control" id="cbucargo" name="cbucargo" v-model="cargo">
                  <option value="0" disabled>Seleccione un Cargo...</option>                       
                      <option value="Rector">Rector</option>                        
                      <option value="Vicerrector Académico">Vicerrector Académico</option>       
                      <option value="Vicerrector de Investigación">Vicerrector de Investigación</option>     
                      <option value="Vicerrector Administrativo">Vicerrector Administrativo</option>          
                      <option value="Decano">Decano</option>                        
                      <option value="Director de Escuela">Director de Escuela</option>                        
                      <option value="Director de Oficina">Director de Oficina</option>                        
                      <option value="Jefe de Oficina">Jefe de Oficina</option>                        
                      <option value="Jefe de Departamento Académico">Jefe de Departamento Académico</option>
                      <option value="Coordinador">Coordinador</option>                        
                      <option value="Asesor">Asesor</option>                        
                      <option value="Asistente Administrativo">Asistente Administrativo</option>              
                      <option value="Especialista">Especialista</option>                        
                      <option value="Analista">Analista</option>                        
                      <option value="Otro">Otro</option>                        
                    </select>
                  </div>
              
     
                  </div>
                </div>


      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

              <label for="txtdesccargo" class="col-sm-2 control-label">Descripción del Cargo:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtdesccargo" name="txtdesccargo" placeholder="Nombre del Cargo"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="descripcionCargo">
              </div>

            </div>
        </div>
           


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
                <label for="txtcondicion" class="col-sm-2 control-label">Condición Laboral:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtcondicion" name="txtcondicion" placeholder="Condición Laboral"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="condicionLaboral">
                  </div>

                  <label for="txtregimen" class="col-sm-2 control-label">Régimen Laboral:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtregimen" name="txtregimen" placeholder="Régimen Laboral"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="regimenLaboral">
                    </div>

                </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
    
      
                      <label for="cbumaxgrado" class="col-sm-2 control-label">Máximo Grado Académico:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-4">
                        <select class="form-control" id="cbumaxgrado" name="cbumaxgrado" v-model="grado">
                            <option value="0">Sin grado</option>                        
                            <option value="1">Primaria completa</option>                        
                            <option value="2">Secundaria completa</option>                        
                            <option value="3">Técnico</option>                        
                            <option value="4">Bachiller</option>                        
                            <option value="5">Maestro</option>                        
                            <option value="6">Doctor</option>                                             
                          </select>
                        </div>
    
    
                  </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;" v-if="grado!='0'">
                    <div class="form-group">
                        <label for="txtdescGrado" class="col-2 control-label">Descripción del Máximo Grado:</label>
                        <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtdescGrado" name="txtdescGrado" placeholder="Grado Académico"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="descripcionGrado">
                      </div>
                    </div>
                  </div>


                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
          
                          <label for="cbutitulouniv" class="col-sm-2 control-label">Título Universitario:<spam style="color:red;">*</spam></label>
                          <div class="col-sm-4">
                              <select class="form-control" id="cbutitulouniv" name="cbutitulouniv" v-model="esTitulado">
                                <option value="1">Si</option>
                                <option value="0">No</option>
          
                              </select>
                            </div>
                        </div>
                      </div>
    
    
                      <template v-if="parseInt(esTitulado)==1">
    
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                                  <label for="txttitulouniv" class="col-sm-2 control-label">Descripción del Título Universitario:</label>
                                  <div class="col-sm-10">
                              <input type="text" class="form-control" id="txttitulouniv" name="txttitulouniv" placeholder="Nombre del Título Universitario"
                                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="descripcionTitulo">
                                </div>
                              </div>
                            </div>
    
    
                        </template>


            <div class="col-md-12" style="padding-top: 15px;" v-if="grado!='0'">
                <div class="form-group">
    
                    <label for="cbulugarmaxgrado" class="col-sm-2 control-label">Lugar del Máximo Grado:<spam style="color:red;">*</spam></label>
                    <div class="col-sm-4">
                        <select class="form-control" id="cbulugarmaxgrado" name="cbulugarmaxgrado" v-model="lugarGrado">
                          <option value="Nacional">Nacional</option>
                          <option value="Internacional">Internacional</option>
    
                        </select>
                      </div>
                      
                      <template v-if="lugarGrado=='Internacional'">
                      <label for="txtpaismaxgrado" class="col-sm-2 control-label">País donde Obtuvo el Grado:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="txtpaismaxgrado" name="txtpaismaxgrado" placeholder="Pais"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="paisGrado">
                        </div>
                      </template>
    
                  </div>
                </div>


                <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               

                <label for="txtfechacontrato" class="col-sm-2 control-label">Fecha de Inicio de Contrato:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechacontrato" name="txtfechacontrato" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaInicioContrato">
                </div>



                  <label for="txtfechaingreso" class="col-sm-2 control-label">Fecha de Ingreso al Cargo:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaingreso" name="txtfechaingreso" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaIngreso">
                </div>


                <label for="txtfechafinalContrato" class="col-sm-2 control-label">Fecha Final de Contrato:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechafinalContrato" name="txtfechafinalContrato" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaFinContrato">
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