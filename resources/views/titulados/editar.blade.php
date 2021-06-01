<form method="post" v-on:submit.prevent="update(filltitulados.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:<spam style="color:red;">*</spam></label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="filltitulados.tipodoc">
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
            autofocus v-model="filltitulados.doc" required
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
        <h4>Datos Personales del Titulado</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepatE" class="col-sm-2 control-label">Apellido Paterno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepatE" name="txtapepatE" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filltitulados.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivilE" name="cbuestadocivilE" v-model="filltitulados.estadocivil">
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
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="filltitulados.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="filltitulados.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:<spam style="color:red;">*</spam></label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdistE" name="txtdistE" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDirE" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.direccion">
                </div>
  
                <label for="txtemailE" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.telefono">
                  </div>
  
 
              </div>
            </div>




      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos del Registro del Titulado</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbucarreraE" class="col-sm-2 control-label">Escuela Profesional:<spam style="color:red;">*</spam></label>
            <div class="col-sm-10">
                <select class="form-control" id="cbucarreraE" name="cbucarreraE" v-model="filltitulados.escuela_id">
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

              <label for="txtgradoE" class="col-sm-2 control-label">Nombre del Grado:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtgradoE" name="txtgradoE" placeholder="Nombre del Grado"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.nombreGrado">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
                <label for="txtprogramaestudiosE" class="col-sm-2 control-label">Programa de Estudios:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtprogramaestudiosE" name="txtprogramaestudiosE" placeholder="Nombre del Programa de Estudios"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.programaEstudios">
                </div>
  
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
               
    
                <label for="txtfechaegresoE" class="col-sm-2 control-label">Fecha de Egreso:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaegresoE" name="txtfechaegresoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.fechaEgreso">
                </div>
    
                <label for="cbuidiomaE" class="col-sm-1 control-label">Idioma:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                    <select class="form-control" id="cbuidiomaE" name="cbuidiomaE" v-model="filltitulados.idioma">
                      <option value="Inglés">Inglés</option>
                      <option value="Italiano">Italiano</option>
                      <option value="Francés">Francés</option>
                      <option value="Aleman">Aleman</option>
                      <option value="Quechua">Quechua</option>
                      <option value="Portugués">Portugués</option>
                    </select>
                  </div>
    
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
    
                  <label for="txtmodalidadObtencionE" class="col-sm-2 control-label">Modalidad de Obtención:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtmodalidadObtencionE" name="txtmodalidadObtencionE" placeholder="Modalidad de Obtención"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.modalidadObtencion">
                  </div>
    
                </div>
              </div>



              <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
      
                    <label for="txtnumresolE" class="col-sm-2 control-label">N° de Resolución de Grado:</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control" id="txtnumresolE" name="txtnumresolE" placeholder="N° de Resolución"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.numResolucion">
                    </div>

                    <label for="txtfecharesolE" class="col-sm-2 control-label">Fecha de Resolución:<spam style="color:red;">*</spam></label>
                    <div class="col-sm-2">
                        <input type="date" class="form-control" id="txtfecharesolE" name="txtfecharesolE" placeholder="dd/mm/aaaa"
                        maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.fechaResol">
                    </div>

                    <label for="txtnumdiplomaE" class="col-sm-1 control-label">N° de Diploma:</label>
                      <div class="col-sm-2">
                        <input type="text" class="form-control" id="txtnumdiplomaE" name="txtnumdiplomaE" placeholder="N° de Diploma"
                          maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.numeroDiploma">
                      </div>
      
                  </div>
                </div>



                <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">

  
                      <label for="txtautoridadE" class="col-sm-2 control-label">Nombre del Rector:<spam style="color:red;">*</spam></label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtautoridadE" name="txtautoridadE" placeholder="Autoridad Rector"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.autoridadRector">
                      </div>
        
                    </div>
                  </div>
  

                  <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
          

                        <label for="txtfechaemisionE" class="col-sm-2 control-label">Fecha de Emisión del Grado:<spam style="color:red;">*</spam></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="txtfechaemisionE" name="txtfechaemisionE" placeholder="dd/mm/aaaa"
                            maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltitulados.fechaEmision">
                        </div>
   
                      </div>
                    </div>



                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">

                                      <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                      <div class="col-sm-10">
<textarea name="txtobsE" id="txtobsE" rows="6" v-model="filltitulados.observaciones" style="width:100%;"></textarea>
    

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