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
        <h4>Datos Personales del Postulante</h4>
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
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillalumnos.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivilE" name="cbuestadocivilE" v-model="fillalumnos.estadocivil">
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
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillalumnos.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="fillalumnos.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:<spam style="color:red;">*</spam></label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdistE" name="txtdistE" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDirE" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.direccion">
                </div>
  
                <label for="txtemailE" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.telefono">
                  </div>
  
 
              </div>
            </div>


        <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
              <label for="txtcorreoinstitucionalE" class="col-sm-2 control-label">Correo Institucional:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
          <input type="text" class="form-control" id="txtcorreoinstitucionalE" name="txtcorreoinstitucionalE" placeholder="Correo Institucional"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.correoinstitucional">
            </div>
  
              <label for="txtidentidadetnicaE" class="col-sm-2 control-label">Identidad Étnica:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
          <input type="text" class="form-control" id="txtidentidadetnicaE" name="txtidentidadetnicaE" placeholder="Identidad Étnica"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.identidadetnica">
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
  
  
              <label for="cbucarreraE" class="col-sm-2 control-label">Escuela Profesional:<spam style="color:red;">*</spam></label>
              <div class="col-sm-10">
                  <select class="form-control" id="cbucarreraE" name="cbucarreraE" v-model="fillalumnos.escuela_id">
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
  
                <label for="txtcodigoE" class="col-sm-2 control-label">Código del Alumno:</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control" id="txtcodigoE" name="txtcodigoE" placeholder="Código"
                    maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.codigo">
                </div>
  

  
  
              </div>
            </div>
  

  
  
              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
  
  
                        <label for="txtpromedioponderadoE" class="col-sm-2 control-label">Promedio Ponderado:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpromedioponderadoE" name="txtpromedioponderadoE" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.promedioPonderado">
                          </div>
  
                          <label for="txtpromediosemestreE" class="col-sm-2 control-label">Promedio del Semestre:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="txtpromediosemestreE" name="txtpromediosemestreE" placeholder="" onkeypress="return soloNumeros(event);"
                              maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.promedioSemestre">
                          </div>
  
  
                    </div>
                  </div>
  
  
  
                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
      
            <label for="cbusemestreingresoE" class="col-sm-2 control-label">Semestre de Ingreso a la Universidad:<spam style="color:red;">*</spam></label>
            <div class="col-sm-3">
                <select class="form-control" id="cbusemestreingresoE" name="cbusemestreingresoE" v-model="fillalumnos.periodoIngreso">
                  <option value="0" disabled>Seleccione un Semestre...</option>
                  @foreach ($semestres as $dato)
                  <option value="{{$dato->id}}" selected>{{$dato->nombre}}</option>                        
                  @endforeach
                </select>
              </div>



              <label for="cbuprimersemestreE" class="col-sm-2 control-label">Primer Semestre de Matrícula:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-3">
                      <select class="form-control" id="cbuprimersemestreE" name="cbuprimersemestreE" v-model="fillalumnos.primerPeriodoMatricula">
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
                        <label for="cbuegresadoOtraCarreraE" class="col-sm-2 control-label">Es egresado de Otra Carrera:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-2">
                            <select class="form-control" id="cbuegresadoOtraCarreraE" name="cbuegresadoOtraCarreraE" v-model="fillalumnos.egresadoOtraCarrera">
                                <option value="0">No</option>                        
                                <option value="1">Si</option>                                           
                              </select>
                            </div>
          
          
                      </div>
                    </div>
  
                <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(fillalumnos.egresadoOtraCarrera)!=0">
                    <div class="form-group">
        
                        <label for="txtotracarreraE" class="col-sm-2 control-label">Ingrese su Otra Carrera de Egreso:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="txtotracarreraE" name="txtotracarreraE" placeholder=""
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.otraCarrera">
                        </div>
  
                    </div>
                  </div>
  
  
  
                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
                          <label for="cbutituladootracarreraE" class="col-sm-2 control-label">Es Titulado de Otra Carrera:<spam style="color:red;">*</spam></label>
                          <div class="col-sm-2">
                              <select class="form-control" id="cbutituladootracarreraE" name="cbutituladootracarreraE" v-model="fillalumnos.tituladoOtraCarrera">
                                  <option value="0">No</option>                        
                                  <option value="1">Si</option>                                           
                                </select>
                              </div>
            
            
                        </div>
                      </div>
    
                  <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(fillalumnos.tituladoOtraCarrera)!=0">
                      <div class="form-group">
          
                          <label for="txttitulootracarreraE" class="col-sm-2 control-label">Ingrese el Título de su Otra Carrera:<spam style="color:red;">*</spam></label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" id="txttitulootracarreraE" name="txttitulootracarreraE" placeholder=""
                              maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.otrotitulo">
                          </div>
    
                      </div>
                    </div>
  
  
  
  
  
  
  
  
                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-group">
  
                                        <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                        <div class="col-sm-10">
  <textarea name="txtobsE" id="txtobsE" rows="6" v-model="fillalumnos.observaciones" style="width:100%;"></textarea>
  
    
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