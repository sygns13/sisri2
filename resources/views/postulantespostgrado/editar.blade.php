<form method="post" v-on:submit.prevent="update(fillpostulantes.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:<spam style="color:red;">*</spam></label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="fillpostulantes.tipodoc">
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
            autofocus v-model="fillpostulantes.doc" required
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

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepatE" class="col-sm-2 control-label">Apellido Paterno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepatE" name="txtapepatE" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:<spam style="color:red;">*</spam></label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:<spam style="color:red;">*</spam></label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillpostulantes.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:<spam style="color:red;">*</spam></label>
            <div class="col-sm-2">
                <select class="form-control" id="cbuestadocivilE" name="cbuestadocivilE" v-model="fillpostulantes.estadocivil">
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
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillpostulantes.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="fillpostulantes.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:<spam style="color:red;">*</spam></label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:<spam style="color:red;">*</spam></label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:<spam style="color:red;">*</spam></label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdistE" name="txtdistE" placeholder="Distrito"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.distrito">
              </div>

            </div>
          </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtDirE" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtDirE" name="txtDirE" placeholder="Av. Jr. Psje."
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.direccion">
                </div>
  
                <label for="txtemailE" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" id="txtemailE" name="txtemailE" placeholder="example@domain.com"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.email">
                </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.telefono">
                  </div>
  
 
              </div>
            </div>



      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos de Postulación</h4>
      </center>



      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">


                <label for="cbugradoE" class="col-sm-2 control-label">Grado de Postulación:<spam style="color:red;">*</spam></label>
                <div class="col-sm-2">
                <select class="form-control" id="cbugradoE" name="cbugradoE" v-model="fillpostulantes.grado">
                    <option value="3">Maestría</option>                        
                    <option value="4">Doctorado</option>                                               
                  </select>
                </div>

                <label for="txtgradoE" class="col-sm-2 control-label">Denominación de Grado y Mensión:<spam style="color:red;">*</spam></label>

                <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtgradoE" name="txtgradoE" placeholder="Nombre de Grado y Mensión"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.nombreGrado">
                  </div>

            </div>
          </div>


      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
              <label for="txtcodigoE" class="col-sm-2 control-label">Código de Postulante:</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" id="txtcodigoE" name="txtcodigoE" placeholder="Código"
                  maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.codigo">
              </div>
            </div>
          </div>


 

          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
  
                  <label for="txtuniversidadterminoestudiosE" class="col-sm-2 control-label">Universidad Donde Culminó sus Estudios:<spam style="color:red;">*</spam></label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtuniversidadterminoestudiosE" name="txtuniversidadterminoestudiosE" placeholder="Nombre de Universidad"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.universidadCulminoPregrado">
                  </div>
  
 
              </div>
            </div>


                  <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
        
                          <label for="cbumodalidadadmisionE" class="col-sm-2 control-label">Modalidad de Admisión:<spam style="color:red;">*</spam></label>
                          <div class="col-sm-4">
                              <select class="form-control" id="cbumodalidadadmisionE" name="cbumodalidadadmisionE" v-model="fillpostulantes.modalidadadmision_id">
                                  <option value="0" disabled>Seleccione una Modalidad de Admisión...</option>
                                @foreach ($modalidadAdmision as $dato)
                                <option value="{{$dato->id}}">{{$dato->nombre}}</option>                        
                                @endforeach
                              </select>
                            </div>

                            <label for="cbumodalidadestudiosE" class="col-sm-2 control-label">Modalidad de Estudios:<spam style="color:red;">*</spam></label>
                            <div class="col-sm-4">
                            <select class="form-control" id="cbumodalidadestudiosE" name="cbumodalidadestudiosE" v-model="fillpostulantes.modalidadestudios">
                                <option value="1">Presencial</option>                        
                                <option value="2">Semipresencial</option>                        
                                <option value="3">Virtual</option>                        
                              </select>
                            </div>
            
                        </div>
                      </div>



                      <div class="col-md-12" style="padding-top: 15px;">
                          <div class="form-group">
            
                              <label for="cbuestadoingresoE" class="col-sm-2 control-label">Estado de Ingreso:<spam style="color:red;">*</spam></label>
                              <div class="col-sm-2">
                                  <select class="form-control" id="cbuestadoingresoE" name="cbuestadoingresoE" v-model="fillpostulantes.estado">
                                    <option value="1">Ingresó</option>
                                    <option value="0">No Ingresó</option>
     
                                  </select>
                                </div>

                                <label for="txtpuntajeE" class="col-sm-2 control-label">Puntaje Obtenido:<spam style="color:red;">*</spam></label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="txtpuntajeE" name="txtpuntajeE" placeholder="" onkeypress="return soloNumeros(event);"
                                      maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillpostulantes.puntaje">
                                  </div>
                            </div>
                          </div>


         

                              <div class="col-md-12" style="padding-top: 15px;">
                                  <div class="form-group">

                                      <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                      <div class="col-sm-10">
<textarea name="txtobsE" id="txtobsE" rows="6" v-model="fillpostulantes.observaciones" style="width:100%;"></textarea>

  
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