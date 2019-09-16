<form method="post" v-on:submit.prevent="update(fillevento.id)">
  <div class="box-body" style="font-size: 14px;">
     

    <template v-if="1==1">


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
                <label for="txtnombreE" class="col-sm-2 control-label">Nombre:*</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtnombreE" name="txtnombreE" placeholder="Nombre del Evento Cultural"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillevento.nombre">
                </div>
            </div>
          </div>
  
  
          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:</label>
                  <div class="col-sm-10">
  <textarea name="txtdescripcionE" id="txtdescripcionE" rows="6" v-model="fillevento.descripcion" style="width:100%;" placeholder="Descripción del Evento Cultural"></textarea>
                </div>
              </div>
            </div>
  
  
            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                  
                  <label for="txtfechainicioE" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                  <div class="col-sm-2">
                      <input type="date" class="form-control" id="txtfechainicioE" name="txtfechainicioE" placeholder="dd/mm/aaaa"
                      maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillevento.fechainicio">
                  </div>
  
                  <label for="txtfechafinalE" class="col-sm-2 control-label">Fecha de Término:*</label>
                  <div class="col-sm-2">
                      <input type="date" class="form-control" id="txtfechafinalE" name="txtfechafinalE" placeholder="dd/mm/aaaa"
                      maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillevento.fechafinal">
                  </div>
      
                </div>
              </div>
  
  
              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
        
                      <label for="txtlugarpresentacionE" class="col-sm-2 control-label">Lugar:*</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtlugarpresentacionE" name="txtlugarpresentacionE" placeholder="Lugar de Presentación del Evento Cultural"
                          maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillevento.lugarpresentacion">
                      </div>
                  </div>
                </div>
  
  
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="form-group">
          
                        <label for="txtentidadE" class="col-sm-2 control-label">Entidad Asoiada:*</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="txtentidadE" name="txtentidadE" placeholder="Entidad asociada en el Evento Cultural"
                            maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillevento.entidad">
                        </div>
                    </div>
                  </div>
  
  
                                <div class="col-md-12" style="padding-top: 15px;">
                                    <div class="form-group">
  
                                        <label for="txtobsE" class="col-sm-2 control-label">Observaciones:</label>
                                        <div class="col-sm-10">
  <textarea name="txtobsE" id="txtobsE" rows="6" v-model="fillevento.observaciones" style="width:100%;"></textarea>
  
    
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