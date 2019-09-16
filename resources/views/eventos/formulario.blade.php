<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">



    <template v-if="formularioCrear">




      <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

              <label for="txtnombre" class="col-sm-2 control-label">Nombre:*</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txtnombre" name="txtnombre" placeholder="Nombre del Evento Cultural"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="nombre">
              </div>
          </div>
        </div>


        <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">
                <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:</label>
                <div class="col-sm-10">
<textarea name="txtdescripcion" id="txtdescripcion" rows="6" v-model="descripcion" style="width:100%;" placeholder="Descripción del Evento Cultural"></textarea>
              </div>
            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                
                <label for="txtfechainicio" class="col-sm-2 control-label">Fecha de Inicio:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechainicio" name="txtfechainicio" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechainicio">
                </div>

                <label for="txtfechafinal" class="col-sm-2 control-label">Fecha de Término:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechafinal" name="txtfechafinal" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechafinal">
                </div>
    
              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
      
                    <label for="txtlugarpresentacion" class="col-sm-2 control-label">Lugar:*</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtlugarpresentacion" name="txtlugarpresentacion" placeholder="Lugar de Presentación del Evento Cultural"
                        maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="lugarpresentacion">
                    </div>
                </div>
              </div>


              <div class="col-md-12" style="padding-top: 15px;">
                  <div class="form-group">
        
                      <label for="txtentidad" class="col-sm-2 control-label">Entidad Asoiada:*</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="txtentidad" name="txtentidad" placeholder="Entidad asociada en el Evento Cultural"
                          maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="entidad">
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