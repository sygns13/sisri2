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
        <h4>Datos Personales del Docente</h4>
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
        <h4>Datos de Docencia</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
  
  
              <label for="cbufacultad" class="col-sm-2 control-label">Facultad:*</label>
              <div class="col-sm-10">
                  <select class="form-control" id="cbufacultad" name="cbufacultad" v-model="facultad_id">
                      <option value="0" disabled>Seleccione una Facultad...</option>
                    @foreach ($facultads as $dato)
                    <option value="{{$dato->id}}">{{$dato->nombre}}</option>     
                    @endforeach                   
                  </select>
                </div>
  
            </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
      
      
                  <label for="cbuescuela" class="col-sm-2 control-label">Escuela:*</label>
                  <div class="col-sm-10">
                      <select class="form-control" id="cbuescuela" name="cbuescuela" v-model="escuela_id">
                          <option value="0" disabled>No adscrito a una Escuela Profesional</option>

                        @foreach ($escuelas as $dato)
                        <template v-if="facultad_id=='{{$dato->facultad_id}}'">
                          <option value="{{$dato->id}}">{{$dato->nombre}}</option>  
                        </template>   
                        @endforeach                   
                      </select>
                    </div>
      
                </div>
              </div>


              
          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                <label for="cbucargo" class="col-sm-2 control-label">Cargo General:*</label>
  
                <div class="col-sm-3">
                  <select class="form-control" id="cbucargo" name="cbucargo" v-model="cargogeneral">
                      <option value="0">Ninguno</option>                        
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
                    </select>
                  </div>
              
                  <template v-if="cargogeneral!='0'">
                      <label for="txtdependencia" class="col-sm-2 control-label">Dependencia de Cargo:*</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="txtdependencia" name="txtdependencia" placeholder="Dependencia"
                          maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="dependencia">
                      </div>
                    </template>
      
                  </div>
                </div>

                
          <div class="col-md-12" style="padding-top: 15px;" v-if="cargogeneral!='0'">
              <div class="form-group">
                  <label for="txtdescCargo" class="col-sm-2 control-label">Descripción del Cargo:</label>
                  <div class="col-sm-10">
              <textarea name="txtdescCargo" id="txtdescCargo" rows="4" v-model="descripcioncargo" style="width:100%;"></textarea>
                </div>
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
    
                    <label for="cbuPersonalAcademico" class="col-sm-2 control-label">Personal Académico:*</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="cbuPersonalAcademico" name="cbuPersonalAcademico" v-model="personalacademico">
                          <option value="Docente">Docente</option>
                          <option value="Jefe de Práctica">Jefe de Práctica</option>
    
                        </select>
                      </div>
    
                      <label for="cbumaxgrado" class="col-sm-2 control-label">Máximo Grado Académico:*</label>
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
                        <label for="txtdescGrado" class="col-sm-3 control-label">Descripción del Máximo Grado:</label>
                        <div class="col-sm-9">
                    <input type="text" class="form-control" id="txtdescGrado" name="txtdescGrado" placeholder="Grado Académico"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="descmaximogrado">
                      </div>
                    </div>
                  </div>
      
                  <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
        
                        <label for="txtunivmaxgrado" class="col-sm-3 control-label">Universidad Donde Obtuvo el Máximo Grado:*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtunivmaxgrado" name="txtunivmaxgrado" placeholder="Universidad"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="universidadgrado">
                        </div>
        
       
                    </div>
                  </div>
      

                  
            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
    
                    <label for="cbulugarmaxgrado" class="col-sm-2 control-label">Lugar del Máximo Grado:*</label>
                    <div class="col-sm-4">
                        <select class="form-control" id="cbulugarmaxgrado" name="cbulugarmaxgrado" v-model="lugarmaximogrado">
                          <option value="Nacional">Nacional</option>
                          <option value="Internacional">Internacional</option>
    
                        </select>
                      </div>
                      
                      <template v-if="lugarmaximogrado=='Internacional'">
                      <label for="txtpaismaxgrado" class="col-sm-2 control-label">País donde Obtuvo el Grado:*</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="txtpaismaxgrado" name="txtpaismaxgrado" placeholder="Pais"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="paismaximogrado">
                        </div>
                      </template>
    
                  </div>
                </div>


                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
        
                        <label for="cbuestadootrogrado" class="col-sm-2 control-label">Tuvo Otro grado Académico:*</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="cbuestadootrogrado" name="cbuestadootrogrado" v-model="estadootrogrado">
                              <option value="No">No</option>
                              <option value="Si">Si</option>
        
                            </select>
                          </div>
        
        
        
                      </div>
                    </div>
    
    
                    
                    <template v-if="estadootrogrado=='Si'">
    
                    
    
    
                  <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
                        <label for="txtdescGrado2" class="col-sm-3 control-label">Otro Grado Académico:</label>
                        <div class="col-sm-9">
                    <input type="text" class="form-control" id="txtdescGrado2" name="txtdescGrado2" placeholder="Otro Grado Académico"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="otrogrado">
                      </div>
                    </div>
                  </div>
    
                  <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
        
                        <label for="txtunivmaxgrado2" class="col-sm-3 control-label">Universidad Donde Obtuvo el Otro Grado:*</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtunivmaxgrado2" name="txtunivmaxgrado2" placeholder="Universidad donde obtuvo el otro grado acaémico"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="univotrogrado">
                        </div>
        
       
                    </div>
                  </div>
    
    
                  <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
        
                        <label for="cbulugarmaxgrado2" class="col-sm-2 control-label">Lugar Donde Obtivo el Otro Grado:*</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="cbulugarmaxgrado2" name="cbulugarmaxgrado2" v-model="lugarotrogrado">
                              <option value="Nacional">Nacional</option>
                              <option value="Internacional">Internacional</option>
        
                            </select>
                          </div>
                          
                          <template v-if="lugarotrogrado=='Internacional'">
                          <label for="txtpaismaxgrado2" class="col-sm-2 control-label">País donde Obtuvo el Otro Grado:*</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="txtpaismaxgrado2" name="txtpaismaxgrado2" placeholder="Pais"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="paisotrogrado">
                            </div>
                          </template>
        
                      </div>
                    </div>
    
                  </template>
    
    
          
                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
          
                          <label for="cbutitulouniv" class="col-sm-2 control-label">Título Universitario:*</label>
                          <div class="col-sm-4">
                              <select class="form-control" id="cbutitulouniv" name="cbutitulouniv" v-model="tituloUniv">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
          
                              </select>
                            </div>
                        </div>
                      </div>
    
    
                      <template v-if="tituloUniv=='Si'">
    
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                                  <label for="txttitulouniv" class="col-sm-3 control-label">Descripción del Título Universitario:</label>
                                  <div class="col-sm-9">
                              <input type="text" class="form-control" id="txttitulouniv" name="txttitulouniv" placeholder="Título Universitario"
                                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="descripciontitulo">
                                </div>
                              </div>
                            </div>
    
    
                        </template>
    
    
    
    
                        <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="cbuclase" class="col-sm-2 control-label">Clase Condición:*</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="cbuclase" name="cbuclase" v-model="condicion">
                                      <option value="Nombrado">Nombrado</option>
                                      <option value="Ordinario">Ordinario</option>
                                      <option value="Contratado a plazo determinado">Contratado a plazo determinado</option>
                                      <option value="Contratado a plazo determinado –a">Contratado a plazo determinado –a</option>
                                      <option value="Contratado a plazo determinado –b">Contratado a plazo determinado –b</option>
                                      <option value="Contratado a plazo indeterminado">Contratado a plazo indeterminado</option>
                                      <option value="CAS">CAS</option>
                                      <option value="Locación de servicios">Locación de servicios</option>
                                      <option value="Extraordinario">Extraordinario</option>
                                      <option value="Ninguno">Ninguno</option>
                
                                    </select>
                                  </div>
    
                                    <label for="cbucategoria" class="col-sm-2 control-label">Categoría:*</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="cbucategoria" name="cbucategoria" v-model="categoria">
                                          <option value="Auxiliar">Auxiliar</option>
                                          <option value="Asociado">Asociado</option>
                                          <option value="Principal">Principal</option>
                                        </select>
                                  </div>
                              </div>
                            </div>
    
    
    
    
    <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="cburegimen" class="col-sm-2 control-label">Régimen de Dedicación:*</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="cburegimen" name="cburegimen" v-model="regimen">
                                      <option value="Tiempo completo">Tiempo completo</option>
                                      <option value="Tiempo parcial">Tiempo parcial</option>
                                      <option value="Dedicación exclusiva">Dedicación exclusiva</option>
                                    </select>
                                  </div>
                                  
                                    <label for="cbuInvestigador" class="col-sm-2 control-label">Es Investigador:*</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="cbuInvestigador" name="cbuInvestigador" v-model="investigador">
                                          <option value="1">Si</option>
                                          <option value="0">No</option>
                                        </select>
                                  </div>
                              </div>
                            </div>
    
    
    
                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="form-group">
                    
                                    <label for="cbudocpregrado" class="col-sm-2 control-label">Es Docente de Pregrado:*</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" id="cbudocpregrado" name="cbudocpregrado" v-model="pregrado">
                                          <option value="1">Si</option>
                                          <option value="0">No</option>
                                        </select>
                                      </div>
                                      
                                      <label for="cbudocentepostgrado" class="col-sm-2 control-label">Es Docente de Postgrado:*</label>
                                      <div class="col-sm-2">
                                          <select class="form-control" id="cbudocentepostgrado" name="cbudocentepostgrado" v-model="postgrado">
                                            <option value="0">No</option>
                                            <option value="1">Si</option>
                                          </select>
                                        </div>
    
                                        <label for="cbuDocenteDestacado" class="col-sm-2 control-label">Es Docente Destacado:*</label>
                                      <div class="col-sm-2">
                                          <select class="form-control" id="cbuDocenteDestacado" name="cbuDocenteDestacado" v-model="esdestacado">
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                          </select>
                                        </div>
    
                                  </div>
                                </div>
        
    
    
                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-group">
                      
          
                                          <label for="txthorasLectivas" class="col-sm-2 control-label">Horas Lectivas:*</label>
                                          <div class="col-sm-2">
                                              <input type="text" class="form-control" id="txthorasLectivas" name="txthorasLectivas" placeholder=""
                                                maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" onkeypress="return soloNumeros(event);"v-model="horaslectivas">
                                            </div>
    
                                            <label for="txthorasNoLectivas" class="col-sm-2 control-label">Horas No Lectivas:*</label>
                                          <div class="col-sm-2">
                                              <input type="text" class="form-control" id="txthorasNoLectivas" name="txthorasNoLectivas" placeholder="" onkeypress="return soloNumeros(event);"
                                                maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="horasnolectivas">
                                            </div>
    
                                            <label for="txthorasInvest" class="col-sm-2 control-label">Horas de Investigación:*</label>
                                          <div class="col-sm-2">
                                              <input type="text" class="form-control" id="txthorasInvest" name="txthorasInvest" placeholder="" onkeypress="return soloNumeros(event);"
                                                maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="horasinvestigacion">
                                            </div>
    
    
                                      </div>
                                    </div>
    
    
                                    <div class="col-md-12" style="padding-top: 15px;">
                                        <div class="form-group">
                          
              
                                              <label for="txthorasdedicacion" class="col-sm-2 control-label">Horas de Dedicación:*</label>
                                              <div class="col-sm-2">
                                                  <input type="text" class="form-control" id="txthorasdedicacion" name="txthorasdedicacion" placeholder="" onkeypress="return soloNumeros(event);"
                                                    maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="horasdedicacion">
                                                </div>  
                                                
                                                
                <label for="txtfechaingreso" class="col-sm-2 control-label">Fecha de Ingreso a la Universidad:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaingreso" name="txtfechaingreso" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaingreso">
                </div>
    
        
                                          </div>
                                        </div>
    
    
    
                                        <div class="col-md-12" style="padding-top: 15px;">
                                            <div class="form-group">
                              
                  
                    <label for="txtmodalidadingreso" class="col-sm-2 control-label">Modalidad de Ingreso:*</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtmodalidadingreso" name="txtmodalidadingreso" placeholder="Modalidad"
                          maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="modalidadingreso">
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