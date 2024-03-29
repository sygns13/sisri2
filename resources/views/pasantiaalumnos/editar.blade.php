<form method="post" v-on:submit.prevent="update(fillalumnos.id)">
  <div class="box-body" style="font-size: 14px;">

   
    <div class="col-md-12">

      <div class="form-group">

          <label for="cbutipodocE" class="col-sm-1 control-label">Tipo de Doc:*</label>

          <div class="col-sm-2">
              <select class="form-control" id="cbutipodocE" name="cbutipodocE" v-model="fillalumnos.tipodoc">
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
        <h4>Datos Personales del Alumno</h4>
      </center>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtapepatE" class="col-sm-2 control-label">Apellido Paterno:*</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="txtapepatE" name="txtapepatE" placeholder="Apellido Paterno"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.apellidopat">
          </div>

          <label for="txtapematE" class="col-sm-2 control-label">Apellido Materno:*</label>
          <div class="col-sm-4">
              <input type="text" class="form-control" id="txtapematE" name="txtapematE" placeholder="Apellido Materno"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.apellidomat">
            </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">
          <label for="txtnombresE" class="col-sm-2 control-label">Nombres:*</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="txtnombresE" name="txtnombresE" placeholder="Nombres"
              maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.nombres">
          </div>
        </div>
      </div>

      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">
            <label for="cbugeneroE" class="col-sm-2 control-label">Género:*</label>
            <div class="col-sm-2">
              <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillalumnos.genero">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>

            <label for="txtfechanacE" class="col-sm-2 control-label">Fecha de Nacimiento:*</label>
            <div class="col-sm-2">
                <input type="date" class="form-control" id="txtfechanacE" name="txtfechanacE" placeholder="dd/mm/aaaa"
                maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.fechanac">
            </div>

            <label for="cbuestadocivilE" class="col-sm-2 control-label">Estado Civil:*</label>
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

                <label for="cbugeneroE" class="col-sm-2 control-label">Sufre Discapacidad:*</label>
                <div class="col-sm-2">
                  <select class="form-control" id="cbugeneroE" name="cbugeneroE" v-model="fillalumnos.esdiscapacitado">
                    <option value="0">No</option>
                    <option value="1">Si</option>
                  </select>
                </div>

                <template v-if="fillalumnos.esdiscapacitado=='1'">
                <label for="txtdiscapacidadE" class="col-sm-2 control-label">Discapacidad que Padece:*</label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="txtdiscapacidadE" name="txtdiscapacidadE" placeholder="Discapacidad"
                maxlength="225" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.discapacidad">
            </div>
          </template>
            </div>
          </div>

    
        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtpaisE" class="col-sm-2 control-label">Pais de Procedencia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtpaisE" name="txtpaisE" placeholder="Pais"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.pais">
                </div>

                <label for="txtdepE" class="col-sm-2 control-label">Departamento:*</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtdepE" name="txtdepE" placeholder="Departamento"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.departamento">
              </div>

            </div>
          </div>

        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtprovE" class="col-sm-2 control-label">Provincia:*</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" id="txtprovE" name="txtprovE" placeholder="Provincia"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.provincia">
                </div>

                <label for="txtdistE" class="col-sm-2 control-label">Distrito:*</label>
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
  
                  <label for="txtfonoE" class="col-sm-2 control-label">Teléfono:*</label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" id="txtfonoE" name="txtfonoE" placeholder="Telef / Cell"
                      maxlength="50" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.telefono">
                  </div>
  
 
              </div>
            </div>




      <div class="col-md-12">
        <hr>
      </div>

      <center>
        <h4>Datos de la Pasantía</h4>
      </center>


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbucarreraE" class="col-sm-2 control-label">Escuela Profesional:*</label>
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
  
                  <label for="txtmodalidadE" class="col-sm-2 control-label">Modalidad:*</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtmodalidadE" name="txtmodalidadE" placeholder="Ingrese Modalidad"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.modalidads">
                  </div>
  
 
              </div>
            </div>

            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">

                  <label for="txtconceptoE" class="col-sm-2 control-label">Concepto:</label>
                  <div class="col-sm-10">
<textarea name="txtconceptoE" id="txtconceptoE" rows="4" v-model="fillalumnos.concepto" style="width:100%;" placeholder="Indique Concepto de la Pasantía"></textarea>


                </div>
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;" >
              <div class="form-group">
  
                  <label for="txtpaisdestinoE" class="col-sm-2 control-label">País:*</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtpaisdestinoE" name="txtpaisdestinoE" placeholder="Ingrese País a Donde Fue a Realizar la Pasantía"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.paispasantia">
                  </div>
  
 
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;" >
              <div class="form-group">
  
                  <label for="txtinstitucionE" class="col-sm-2 control-label">Institución:*</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="txtinstitucionE" name="txtinstitucionE" placeholder="Ingrese Institución a Donde Fue a Realizar la Pasantía"
                      maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.institucionpasantia">
                  </div>
  
 
              </div>
            </div>



            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                
    
                <label for="txtfechainicioE" class="col-sm-2 control-label">Fecha de Inicio de Pasantía:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechainicioE" name="txtfechainicioE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.fechainicio">
                </div>

                <label for="txtfechafinalE" class="col-sm-2 control-label">Fecha de Final de Pasantía:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechafinalE" name="txtfechafinalE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.fechafinal">
                </div>
    
    
            
              </div>
            </div>








            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">


                      <label for="txtmontoE" class="col-sm-2 control-label">Monto Asignado:*</label>
                      <div class="col-sm-2">
                          <input type="text" class="form-control" id="txtmontoE" name="txtmontoE" placeholder="" onkeypress="return soloNumeros(event);"
                            maxlength="20" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.monto">
                        </div>

                        <label for="txtresolucionE" class="col-sm-1 control-label">Resolución:*</label>
                      <div class="col-sm-7">
                          <input type="text" class="form-control" id="txtresolucionE" name="txtresolucionE" placeholder="Resolución de Pasantía" 
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillalumnos.resolucions">
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