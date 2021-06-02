<form method="post" v-on:submit.prevent="update(filladminlocaservs.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:<spam style="color:red;">*</spam></label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="filladminlocaservs.tipodoc">
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
            autofocus v-model="filladminlocaservs.doc" required
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
      <h4>Datos Personales del Personal Administrativo</h4>
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
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filladminlocaservs.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivilE" name="cbuestadocivilE" v-model="filladminlocaservs.estadocivil">
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

                <label for="cbugeneroE" class="col-sm-2 control-label">Sufre Discapacidad:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filladminlocaservs.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="filladminlocaservs.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:<spam style="color:red;">*</spam></label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdistE" name="txtdistE" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDirE" class="col-sm-2 control-label">Dirección:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.direccion">
                </div>
  
                <label for="txtemailE" class="col-sm-2 control-label">Email:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.telefono">
                  </div>
  
 
              </div>
            </div>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
            <label for="txtcorreoinstitucionalE" class="col-sm-2 control-label">Correo Institucional:<spam style="color:red;">*</spam></label>
            <div class="col-sm-4">
        <input type="text" class="form-control" id="txtcorreoinstitucionalE" name="txtcorreoinstitucionalE" placeholder="Correo Institucional"
                maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.correoinstitucional">
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
    
                <label for="cbulocalE" class="col-sm-2 control-label">Local:<spam style="color:red;">*</spam></label>
                <div class="col-sm-10">
                    <select class="form-control" id="cbulocalE" name="cbulocalE" v-model="filladminlocaservs.local_id">
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
               
                <label for="cbutipodependenciaE" class="col-sm-2 control-label">Tipo de Dependencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-10">
                    <select class="form-control" id="cbutipodependenciaE" name="cbutipodependenciaE" v-model="filladminlocaservs.tipoDependencia">
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


            <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(filladminlocaservs.tipoDependencia)<9">
          <div class="form-group">

              <label for="txtdependenciaE" class="col-sm-2 control-label">Dependencia:<spam style="color:red;">*</spam></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtdependenciaE" name="txtdependenciaE" placeholder="Nombre de la Dependencia"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.dependencia">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(filladminlocaservs.tipoDependencia)==9">
        <div class="form-group">

            <label for="cbufacultadE" class="col-sm-2 control-label">Facultad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
                <select class="form-control" id="cbufacultadE" name="cbufacultadE" v-model="filladminlocaservs.facultad">
                    <option value="0" disabled>Seleccione una Facultad..</option>
                  @foreach ($facultads as $dato)
                  <option value="{{$dato->nombre}}">{{$dato->nombre}}</option>     
                  @endforeach                   
                </select>
              </div>

          </div>
        </div>





      <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(filladminlocaservs.tipoDependencia)==10">
        <div class="form-group">


            <label for="cbucarreraE" class="col-sm-2 control-label">Escuela Profesional:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
                <select class="form-control" id="cbucarreraE" name="cbucarreraE" v-model="filladminlocaservs.escuela">
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
  
                <label for="cbucargoE" class="col-sm-2 control-label">Cargo:<spam style="color:red;">*</spam></label>
  
                <div class="col-sm-4">
                  <select class="form-control" id="cbucargoE" name="cbucargoE" v-model="filladminlocaservs.cargo">
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

              <label for="txtdesccargoE" class="col-sm-2 control-label">Descripción del Cargo:<spam style="color:red;">*</spam></label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtdesccargoE" name="txtdesccargoE" placeholder="Nombre del Cargo"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.descripcionCargo">
              </div>

            </div>
        </div>
           


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
                <label for="txtcondicionE" class="col-sm-2 control-label">Condición Laboral:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtcondicionE" name="txtcondicionE" placeholder="Condición Laboral"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.condicionLaboral">
                  </div>

                  <label for="txtregimenE" class="col-sm-2 control-label">Régimen Laboral:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="txtregimenE" name="txtregimenE" placeholder="Régimen Laboral"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.regimenLaboral">
                    </div>

                </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
    
      
                      <label for="cbumaxgradoE" class="col-sm-2 control-label">Máximo Grado Académico:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-4">
                        <select class="form-control" id="cbumaxgradoE" name="cbumaxgradoE" v-model="filladminlocaservs.grado">
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

                <div class="col-md-12" style="padding-top: 15px;" v-if="filladminlocaservs.grado!='0'">
                    <div class="form-group">
                        <label for="txtdescGradoE" class="col-sm-2 control-label">Descripción del Máximo Grado:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtdescGradoE" name="txtdescGradoE" placeholder="Grado Académico"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.descripcionGrado">
                      </div>
                    </div>
                  </div>


                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
          
                          <label for="cbutitulounivE" class="col-sm-2 control-label">Título Universitario:<spam style="color:red;">*</spam></label>
                          <div class="col-sm-4">
                              <select class="form-control" id="cbutitulounivE" name="cbutitulounivE" v-model="filladminlocaservs.esTitulado">
                                <option value="1">Si</option>
                                <option value="0">No</option>
          
                              </select>
                            </div>
                        </div>
                      </div>
    
    
                      <template v-if="parseInt(filladminlocaservs.esTitulado)==1">
    
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                                  <label for="txttitulounivE" class="col-sm-2 control-label">Descripción del Título Universitario:<spam style="color:red;">*</spam></label>
                                  <div class="col-sm-10">
                              <input type="text" class="form-control" id="txttitulounivE" name="txttitulounivE" placeholder="Nombre del Título Universitario"
                                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.descripcionTitulo">
                                </div>
                              </div>
                            </div>
    
    
                        </template>


            <div class="col-md-12" style="padding-top: 15px;" v-if="filladminlocaservs.grado!='0'">
                <div class="form-group">
    
                    <label for="cbulugarmaxgradoE" class="col-sm-2 control-label">Lugar del Máximo Grado:<spam style="color:red;">*</spam></label>
                    <div class="col-sm-4">
                        <select class="form-control" id="cbulugarmaxgradoE" name="cbulugarmaxgradoE" v-model="filladminlocaservs.lugarGrado">
                          <option value="Nacional">Nacional</option>
                          <option value="Internacional">Internacional</option>
    
                        </select>
                      </div>
                      
                      <template v-if="filladminlocaservs.lugarGrado=='Internacional'">
                      <label for="txtpaismaxgradoE" class="col-sm-2 control-label">País donde Obtuvo el Grado:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="txtpaismaxgradoE" name="txtpaismaxgradoE" placeholder="Pais"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.paisGrado">
                        </div>
                      </template>
    
                  </div>
                </div>


                <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               

                <label for="txtfechacontratoE" class="col-sm-2 control-label">Fecha de Inicio de Contrato:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechacontratoE" name="txtfechacontratoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.fechaInicioContrato">
                </div>



                  <label for="txtfechaingresoE" class="col-sm-2 control-label">Fecha de Ingreso al Cargo:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaingresoE" name="txtfechaingresoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.fechaIngreso">
                </div>


                <label for="txtfechafinalContratoE" class="col-sm-2 control-label">Fecha Final de Contrato:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechafinalContratoE" name="txtfechafinalContratoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filladminlocaservs.fechaFinContrato">
                </div>
                
              </div>
            </div>


                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">

                                      <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                      <div class="col-sm-10">
<textarea name="txtobsE" id="txtobsE" rows="6" v-model="filladminlocaservs.observaciones" style="width:100%;"></textarea>
    

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