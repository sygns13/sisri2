<form method="post" v-on:submit.prevent="update(fillrevista.id)">
  <div class="box-body" style="font-size: 14px;">

   
   

    <template v-if="1==1">


      <div class="col-md-12" style="padding-top: 15px;">
        <div class="form-group">


            <label for="cbuescuela_idE" class="col-sm-2 control-label">Escuela Profesional:*</label>
            <div class="col-sm-10">
                <select class="form-control" id="cbuescuela_idE" name="cbuescuela_idE" v-model="fillrevista.escuela_id">
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

              <label for="txttipoPublicacionE" class="col-sm-2 control-label">Tipo de Publicación:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txttipoPublicacionE" name="txttipoPublicacionE" placeholder="Título de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillrevista.tipoPublicacion">
              </div>

              <label for="txtnumeroE" class="col-sm-2 control-label">N° de Publicación:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="txtnumeroE" name="txtnumeroE" placeholder="N° de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillrevista.numero">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
          <div class="form-group">

              <label for="txttituloE" class="col-sm-2 control-label">Título:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="txttituloE" name="txttituloE" placeholder="Título de la Revista o Publicación"
                  maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillrevista.titulo">
              </div>

            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">
            <div class="form-group">

                <label for="txtdescripcionE" class="col-sm-2 control-label">Descripción:</label>
                <div class="col-sm-10">
<textarea name="txtdescripcionE" id="txtdescripcionE" rows="4" v-model="fillrevista.descripcion" style="width:100%;" placeholder="Descripción de la Revista o Publicación"></textarea>


              </div>
            </div>
          </div>


          <div class="col-md-12" style="padding-top: 15px;">

            <div class="form-group">
              <label for="txtArchivoAdjuntoE" class="col-sm-2 control-label">Archivo Adjunto: (Opcional: pdf, docx, xlsx, pptx)</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="txtArchivoAdjuntoE" name="txtArchivoAdjuntoE" placeholder="Nombre del Archivo" maxlength="500"  v-model="fillrevista.archivonombre">
              </div>

              <div class="col-sm-8" v-if="uploadReadyE">
                 <input  name="archivo2E" type="file" id="archivo2E" class="archivo form-control" @change="getArchivoE" 
      accept=".pdf, .doc, .docx, .xls, .xlsx, ppt, .pptx, .PDF, .DOC, .DOCX, .XLS, .XLSX, .PPT, .PTTX"/>

     

  
               </div>
            </div>

        </div>  


        <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                  <label for="txtfechaPublicadoE" class="col-sm-2 control-label">Fecha de Publicación:*</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="txtfechaPublicadoE" name="txtfechaPublicadoE" placeholder="dd/mm/aaaa"
                    maxlength="10" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillrevista.fechaPublicado">
                </div>

              </div>
            </div>


            <div class="col-md-12" style="padding-top: 15px;">
                <div class="form-group">
                 
                  <label for="cbuindexadaE" class="col-sm-2 control-label">Se encuentra Indexada:*</label>
                  <div class="col-sm-2">
                      <select class="form-control" id="cbuindexadaE" name="cbuindexadaE" v-model="fillrevista.indexada">
                        <option value="1">Si</option>
                        <option value="0">No</option>
     
                      </select>
                    </div>

                <template v-if="parseInt(fillrevista.indexada)==1">

                <label for="txtlugarIndexadaE" class="col-sm-2 control-label">Lugar de Indexación:</label>
                <div class="col-sm-6">

                    <input type="text" class="form-control" id="txtlugarIndexadaE" name="txtlugarIndexadaE" placeholder="Lugar de Indexación"
                    maxlength="500" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false" v-model="fillrevista.lugarIndexada">



              </div>

                </template>
  
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