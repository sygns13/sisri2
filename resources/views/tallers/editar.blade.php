<form method="post" v-on:submit.prevent="update(filltalleres.id)">
  <div class="box-body" style="font-size: 14px;">
     

    <template v-if="1==1">


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
  
                <label for="txtnombreE" class="col-sm-2 control-label">Nombre:*</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtnombreE" name="txtnombreE" placeholder="Nombre del Taller"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="filltalleres.nombre">
                </div>
            </div>
          </div>
  
  
          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:</label>
                  <div class="col-sm-10">
  <textarea name="txtdescripcionE" id="txtdescripcionE" rows="6" v-model="filltalleres.descripcion" style="width:100%;" placeholder="Descripción del Taller"></textarea>
                </div>
              </div>
            </div>
  
  
            <div class="col-md-12" style="padding-top:15px;">
  
                <div class="form-group">
          
                    <label for="cbudocente_idE" class="col-sm-2 control-label">Docente a Cargo:*</label>
          
                    <div class="col-sm-10">
                        <select class="form-control" id="cbudocente_idE" name="cbudocente_idE" v-model="filltalleres.docente_id">
                          <option value="0" disabled>Seleccione Docente...</option>
                          
                        <option v-for="docente, key in docentes" v-bind:value="docente.id">@{{docente.doc}} @{{docente.nombres}} @{{docente.apellidopat}} @{{docente.apellidomat}}</option>
  
                        </select>
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