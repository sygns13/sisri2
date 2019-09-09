<form method="post" v-on:submit.prevent="update(filldocente.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:*</label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="filldocente.tipodoc">
                <option value="1">DNI</option>
                <option value="2">RUC</option>
                <option value="3">Carnet de Extranjería</option>
                <option value="4">Pasaporte</option>
                <option value="5">Partida de Nacimiento</option>
              </select>
            </div>



        <label for="txtDNIE" class="col-sm-1 control-label">Documento:*</label>

        <div class="col-sm-2">
          <input type="text" class="form-control" id="txtDNIE" name="txtDNIE" placeholder="N° de Doc" maxlength="20"
            autofocus v-model="filldocente.doc" required
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
        <h4>Datos Personales del Docente</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepatE" class="col-sm-2 control-label">Apellido Paterno:*</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepatE" name="txtapepatE" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:*</label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:*</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:*</label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filldocente.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:*</label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:*</label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivilE" name="cbuestadocivilE" v-model="filldocente.estadocivil">
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

                <label for="cbugeneroE" class="col-sm-2 control-label">Sufre Discapacidad:*</label>
                <div class="col-sm-2">
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filldocente.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="filldocente.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:*</label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:*</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:*</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdistE" name="txtdistE" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDirE" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.direccion">
                </div>
  
                <label for="txtemailE" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.telefono">
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
          
          
                      <label for="cbufacultadE" class="col-sm-2 control-label">Facultad:*</label>
                      <div class="col-sm-10">
                          <select class="form-control" id="cbufacultadE" name="cbufacultadE" v-model="filldocente.facultad_id">
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
              
              
                          <label for="cbuescuelaE" class="col-sm-2 control-label">Escuela:*</label>
                          <div class="col-sm-10">
                              <select class="form-control" id="cbuescuelaE" name="cbuescuelaE" v-model="filldocente.escuela_id">
                                  <option value="0" disabled>No adscrito a una Escuela Profesional</option>
        
                                @foreach ($escuelas as $dato)
                                <template v-if="filldocente.facultad_id=='{{$dato->facultad_id}}'">
                                  <option value="{{$dato->id}}">{{$dato->nombre}}</option>  
                                </template>   
                                @endforeach                   
                              </select>
                            </div>
              
                        </div>
                      </div>
        
        
                      
                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
          
                        <label for="cbucargoE" class="col-sm-2 control-label">Cargo General:*</label>
          
                        <div class="col-sm-3">
                          <select class="form-control" id="cbucargoE" name="cbucargoE" v-model="filldocente.cargogeneral">
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
                      
                          <template v-if="filldocente.cargogeneral!='0'">
                              <label for="txtdependenciaE" class="col-sm-2 control-label">Dependencia de Cargo:*</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="txtdependenciaE" name="txtdependenciaE" placeholder="Dependencia"
                                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.dependencia">
                              </div>
                            </template>
              
                          </div>
                        </div>
        
                        
                  <div class="col-md-12" style="padding-top: 15px;" v-if="filldocente.cargogeneral!='0'">
                      <div class="form-group">
                          <label for="txtdescCargoE" class="col-sm-2 control-label">Descripción del Cargo:</label>
                          <div class="col-sm-10">
                      <textarea name="txtdescCargoE" id="txtdescCargoE" rows="4" v-model="filldocente.descripcioncargo" style="width:100%;"></textarea>
                        </div>
                      </div>
                    </div>
        
        
                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
            
                            <label for="cbuPersonalAcademicoE" class="col-sm-2 control-label">Personal Académico:*</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="cbuPersonalAcademicoE" name="cbuPersonalAcademicoE" v-model="filldocente.personalacademico">
                                  <option value="Docente">Docente</option>
                                  <option value="Jefe de Práctica">Jefe de Práctica</option>
            
                                </select>
                              </div>
            
                              <label for="cbumaxgradoE" class="col-sm-2 control-label">Máximo Grado Académico:*</label>
                              <div class="col-sm-4">
                                <select class="form-control" id="cbumaxgradoE" name="cbumaxgradoE" v-model="filldocente.maximogrado">
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
                                <label for="txtdescGradoE" class="col-sm-3 control-label">Descripción del Máximo Grado:</label>
                                <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtdescGradoE" name="txtdescGradoE" placeholder="Grado Académico"
                                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.descmaximogrado">
                              </div>
                            </div>
                          </div>
              
                          <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="txtunivmaxgradoE" class="col-sm-3 control-label">Universidad Donde Obtuvo el Máximo Grado:*</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtunivmaxgradoE" name="txtunivmaxgradoE" placeholder="Universidad"
                                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.universidadgrado">
                                </div>
                
               
                            </div>
                          </div>
              
        
                          
                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="form-group">
            
                            <label for="cbulugarmaxgradoE" class="col-sm-2 control-label">Lugar del Máximo Grado:*</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="cbulugarmaxgradoE" name="cbulugarmaxgradoE" v-model="filldocente.lugarmaximogrado">
                                  <option value="Nacional">Nacional</option>
                                  <option value="Internacional">Internacional</option>
            
                                </select>
                              </div>
                              
                              <template v-if="filldocente.lugarmaximogrado=='Internacional'">
                              <label for="txtpaismaxgradoE" class="col-sm-2 control-label">País donde Obtuvo el Grado:*</label>
                              <div class="col-sm-4">
                                <input type="text" class="form-control" id="txtpaismaxgradoE" name="txtpaismaxgradoE" placeholder="Pais"
                                maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.paismaximogrado">
                                </div>
                              </template>
            
                          </div>
                        </div>
        
        
                        <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="cbuestadootrogradoE" class="col-sm-2 control-label">Tuvo Otro grado Académico:*</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="cbuestadootrogradoE" name="cbuestadootrogradoE" v-model="filldocente.estadootrogrado">
                                      <option value="No">No</option>
                                      <option value="Si">Si</option>
                
                                    </select>
                                  </div>
                
                
                
                              </div>
                            </div>
            
            
                            
                            <template v-if="filldocente.estadootrogrado=='Si'">
            
                            
            
            
                          <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                                <label for="txtdescGrado2E" class="col-sm-3 control-label">Otro Grado Académico:</label>
                                <div class="col-sm-9">
                            <input type="text" class="form-control" id="txtdescGrado2E" name="txtdescGrado2E" placeholder="Otro Grado Académico"
                                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.otrogrado">
                              </div>
                            </div>
                          </div>
            
                          <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="txtunivmaxgrado2E" class="col-sm-3 control-label">Universidad Donde Obtuvo el Otro Grado:*</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="txtunivmaxgrado2E" name="txtunivmaxgrado2E" placeholder="Universidad donde obtuvo el otro grado acaémico"
                                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.univotrogrado">
                                </div>
                
               
                            </div>
                          </div>
            
            
                          <div class="col-md-12" style="padding-top: 15px;">
                            <div class="form-group">
                
                                <label for="cbulugarmaxgrado2E" class="col-sm-2 control-label">Lugar Donde Obtivo el Otro Grado:*</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="cbulugarmaxgrado2E" name="cbulugarmaxgrado2E" v-model="filldocente.lugarotrogrado">
                                      <option value="Nacional">Nacional</option>
                                      <option value="Internacional">Internacional</option>
                
                                    </select>
                                  </div>
                                  
                                  <template v-if="filldocente.lugarotrogrado=='Internacional'">
                                  <label for="txtpaismaxgrado2E" class="col-sm-2 control-label">País donde Obtuvo el Otro Grado:*</label>
                                  <div class="col-sm-4">
                                    <input type="text" class="form-control" id="txtpaismaxgrado2E" name="txtpaismaxgrado2E" placeholder="Pais"
                                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.paisotrogrado">
                                    </div>
                                  </template>
                
                              </div>
                            </div>
            
                          </template>
            
            
                  
                          <div class="col-md-12" style="padding-top: 15px;">
                              <div class="form-group">
                  
                                  <label for="cbutitulounivE" class="col-sm-2 control-label">Título Universitario:*</label>
                                  <div class="col-sm-4">
                                      <select class="form-control" id="cbutitulounivE" name="cbutitulounivE" v-model="filldocente.titulo">
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                  
                                      </select>
                                    </div>
                                </div>
                              </div>
            
            
                              <template v-if="filldocente.titulo=='Si'">
            
                                  <div class="col-md-12" style="padding-top: 15px;">
                                      <div class="form-group">
                                          <label for="txttitulounivE" class="col-sm-3 control-label">Descripción del Título Universitario:</label>
                                          <div class="col-sm-9">
                                      <input type="text" class="form-control" id="txttitulounivE" name="txttitulounivE" placeholder="Título Universitario"
                                              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.descripciontitulo">
                                        </div>
                                      </div>
                                    </div>
            
            
                                </template>
            
            
            
            
                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-group">
                        
                                        <label for="cbuclaseE" class="col-sm-2 control-label">Clase Condición:*</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="cbuclaseE" name="cbuclaseE" v-model="filldocente.condicion">
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
            
                                            <label for="cbucategoriaE" class="col-sm-2 control-label">Categoría:*</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="cbucategoriaE" name="cbucategoriaE" v-model="filldocente.categoria">
                                                  <option value="Auxiliar">Auxiliar</option>
                                                  <option value="Asociado">Asociado</option>
                                                  <option value="Principal">Principal</option>
                                                </select>
                                          </div>
                                      </div>
                                    </div>
            
            
            
            
            <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-group">
                        
                                        <label for="cburegimenE" class="col-sm-2 control-label">Régimen de Dedicación:*</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="cburegimenE" name="cburegimenE" v-model="filldocente.regimen">
                                              <option value="Tiempo completo">Tiempo completo</option>
                                              <option value="Tiempo parcial">Tiempo parcial</option>
                                              <option value="Dedicación exclusiva">Dedicación exclusiva</option>
                                            </select>
                                          </div>
                                          
                                            <label for="cbuInvestigadorE" class="col-sm-2 control-label">Es Investigador:*</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="cbuInvestigadorE" name="cbuInvestigadorE" v-model="filldocente.investigador">
                                                  <option value="1">Si</option>
                                                  <option value="0">No</option>
                                                </select>
                                          </div>
                                      </div>
                                    </div>
            
            
            
                                    <div class="col-md-12" style="padding-top: 15px;">
                                        <div class="form-group">
                            
                                            <label for="cbudocpregradoE" class="col-sm-2 control-label">Es Docente de Pregrado:*</label>
                                            <div class="col-sm-2">
                                                <select class="form-control" id="cbudocpregradoE" name="cbudocpregradoE" v-model="filldocente.pregrado">
                                                  <option value="1">Si</option>
                                                  <option value="0">No</option>
                                                </select>
                                              </div>
                                              
                                              <label for="cbudocentepostgradoE" class="col-sm-2 control-label">Es Docente de Postgrado:*</label>
                                              <div class="col-sm-2">
                                                  <select class="form-control" id="cbudocentepostgradoE" name="cbudocentepostgradoE" v-model="filldocente.postgrado">
                                                    <option value="0">No</option>
                                                    <option value="1">Si</option>
                                                  </select>
                                                </div>
            
                                                <label for="cbuDocenteDestacadoE" class="col-sm-2 control-label">Es Docente Destacado:*</label>
                                              <div class="col-sm-2">
                                                  <select class="form-control" id="cbuDocenteDestacadoE" name="cbuDocenteDestacadoE" v-model="filldocente.esdestacado">
                                                    <option value="1">Si</option>
                                                    <option value="0">No</option>
                                                  </select>
                                                </div>
            
                                          </div>
                                        </div>
                
            
            
                                        <div class="col-md-12" style="padding-top: 15px;">
                                            <div class="form-group">
                              
                  
                                                  <label for="txthorasLectivasE" class="col-sm-2 control-label">Horas Lectivas:*</label>
                                                  <div class="col-sm-2">
                                                      <input type="text" class="form-control" id="txthorasLectivasE" name="txthorasLectivasE" placeholder="" onkeypress="return soloNumeros(event);"
                                                        maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.horaslectivas">
                                                    </div>
            
                                                    <label for="txthorasNoLectivasE" class="col-sm-2 control-label">Horas No Lectivas:*</label>
                                                  <div class="col-sm-2">
                                                      <input type="text" class="form-control" id="txthorasNoLectivasE" name="txthorasNoLectivasE" placeholder="" onkeypress="return soloNumeros(event);"
                                                        maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.horasnolectivas">
                                                    </div>
            
                                                    <label for="txthorasInvestE" class="col-sm-2 control-label">Horas de Investigación:*</label>
                                                  <div class="col-sm-2">
                                                      <input type="text" class="form-control" id="txthorasInvestE" name="txthorasInvestE" placeholder="" onkeypress="return soloNumeros(event);"
                                                        maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.horasinvestigacion">
                                                    </div>
            
            
                                              </div>
                                            </div>
            
            
                                            <div class="col-md-12" style="padding-top: 15px;">
                                                <div class="form-group">
                                  
                      
                                                      <label for="txthorasdedicacionE" class="col-sm-2 control-label">Horas de Dedicación:*</label>
                                                      <div class="col-sm-2">
                                                          <input type="text" class="form-control" id="txthorasdedicacionE" name="txthorasdedicacionE" placeholder="" onkeypress="return soloNumeros(event);"
                                                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.horasdedicacion">
                                                        </div>  
                                                        
                                                        
                        <label for="txtfechaingresoE" class="col-sm-2 control-label">Fecha de Ingreso a la Universidad:*</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechaingresoE" name="txtfechaingresoE" placeholder="dd/mm/aaaa"
                            maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.fechaingreso">
                        </div>
            
                
                                                  </div>
                                                </div>
            
            
            
                                                <div class="col-md-12" style="padding-top: 15px;">
                                                    <div class="form-group">
                                      
                          
                            <label for="txtmodalidadingresoE" class="col-sm-2 control-label">Modalidad de Ingreso:*</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="txtmodalidadingresoE" name="txtmodalidadingresoE" placeholder="Modalidad"
                                  maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filldocente.modalidadingreso">
                              </div>  
                                                            
                
                    
                                                      </div>
                                                    </div>
                
                                                    <div class="col-md-12" style="padding-top: 15px;">
                                                        <div class="form-group">
                      
                                                            <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                                            <div class="col-sm-10">
                      <textarea name="txtobsE" id="txtobsE" rows="6" v-model="filldocente.observaciones" style="width:100%;"></textarea>
                      
                        
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