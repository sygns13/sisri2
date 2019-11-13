<form v-on:submit.prevent="create">
  <div class="box-body" style="font-size: 14px;">

    

    <template v-if="formularioCrear">


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbuescuela_id" class="col-sm-2 control-label">Escuela Profesional:*</label>
            <div class="col-sm-10">
                <select class="form-control" id="cbuescuela_id" name="s" v-model="escuela_id">
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

              <label for="txttipoPublicacion" class="col-sm-2 control-label">Tipo de Publicación:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txttipoPublicacion" name="txttipoPublicacion" placeholder="Título de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="tipoPublicacion">
              </div>

              <label for="txtnumero" class="col-sm-2 control-label">N° de Publicación:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtnumero" name="txtnumero" placeholder="N° de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="numero">
              </div>

            </div>
          </div>

            <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

              <label for="txttitulo" class="col-sm-2 control-label">Título:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txttitulo" name="txttitulo" placeholder="Título de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="tituloR">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtdescripcion" class="col-sm-2 control-label">Descripción:</label>
                <div class="col-sm-10">
<textarea name="txtdescripcion" id="txtdescripcion" rows="4" v-model="descripcion" style="width:100%;" placeholder="Descripción de la Revista o Publicación"></textarea>


              </div>
            </div>
          </div>

          <div class="col-md-12" style="padding-top: 15px;">

            <div class="form-group">
              <label for="txtrutadoc" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtrutadoc" name="txtrutadoc" placeholder="Nombre del Archivo" maxlength="500" v-model="archivonombre">
              </div>

              <div class="col-sm-8">
                 <input v-if="uploadReady" name="archivo2" type="file" id="archivo2" class="archivo form-control" @change="getArchivo" 
      accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

     

  
               </div>
            </div>

        </div>



        <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtfechaPublicado" class="col-sm-2 control-label">Fecha de Publicación:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaPublicado" name="txtfechaPublicado" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fechaPublicado">
                </div>

              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                 
                  <label for="cbuindexada" class="col-sm-2 control-label">Se encuentra Indexada:*</label>
                  <div class="col-sm-2">
                      <select class="form-control" id="cbuindexada" name="cbuindexada" v-model="indexada">
                        <option value="1">Si</option>
                        <option value="0">No</option>
     
                      </select>
                    </div>

                <template v-if="parseInt(indexada)==1">

                <label for="txtlugarIndexada" class="col-sm-2 control-label">Lugar de Indexación:</label>
                <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtlugarIndexada" name="txtlugarIndexada" placeholder="Lugar de Indexación"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="lugarIndexada">



              </div>

                </template>
  
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