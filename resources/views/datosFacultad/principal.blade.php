<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Gestión de Datos de la Facultad: <b>{{$facultad->nombre}}</b></h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('facultades')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
{{--       <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
             <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>
          </div> 
      
      
      
          {{--  
            <div class="box-footer">
              <button type="button" class="btn btn-primary" onclick="enviarMSj();" id="btnEnviarMsj"><i class="fa fa-envelope-o" aria-hidden="true" ></i> Enviar Mensaje</button>
              <div id="divCarga0" style="display: inline-block;"><div id="dcarga0" style="display: none;"><img src="{{ asset('/img/ajax-loader.gif')}}"/></div></div>
            </div>
            
      
          </div> --}}
      
        </div>
      
      
      
      
      @foreach ($tipodato as $dato)
            
      
      @if(intval($dato->tipo)==1)
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">{{$dato->titulo}}</h3>

        <button type="button" class="btn btn-success" id="btnCrear" @click.prevent="nuevo({{intval($dato->tipo)}},'{{$dato->titulo}}',{{$dato->id}})"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>
      
         </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              {{-- <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th> --}}
              <th style="border:1px solid #ddd;padding: 5px; width: 40%;">Semestre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 30%;">{{$dato->descripcion}}</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
          <tr v-for="datos, key in datosfacultad" v-if="parseInt(datos.tipodato_id)=={{intval($dato->id)}}">
           {{--    <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+1}}</td> --}}
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.semestre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.cantidad }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="datos.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="datos.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(datos,1)" data-placement="top" data-toggle="tooltip" title="Editar Registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(datos,1)" data-placement="top" data-toggle="tooltip" title="Borrar Registro"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
      </div>


      @elseif(intval($dato->tipo)==2)

      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">{{$dato->titulo}}</h3>
          
        <button type="button" class="btn btn-success" id="btnCrear" @click.prevent="nuevo({{intval($dato->tipo)}},'{{$dato->titulo}}',{{$dato->id}})"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

         </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              {{-- <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th> --}}
              <th style="border:1px solid #ddd;padding: 5px; width: 25%;">Semestre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 25;">{{$dato->descripcion}}</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">N° de Computadoras Promedio por Centro de Cómputo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="datos, key in datosfacultad" v-if="parseInt(datos.tipodato_id)=={{intval($dato->id)}}">
         {{--      <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td> --}}
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.semestre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.cantidad }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.cantidad2 }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="datos.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="datos.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(datos,2)" data-placement="top" data-toggle="tooltip" title="Editar Registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(datos,2)" data-placement="top" data-toggle="tooltip" title="Borrar Registro"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
      </div>


      @elseif(intval($dato->tipo)==3)

      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">{{$dato->titulo}}</h3>
          
        <button type="button" class="btn btn-success" id="btnCrear" @click.prevent="nuevo({{intval($dato->tipo)}},'{{$dato->titulo}}',{{$dato->id}})"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

         </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 25%;">Semestre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 25;">Descripción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Cantidad</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="datos, key in datosfacultad" v-if="parseInt(datos.tipodato_id)=={{intval($dato->id)}}">
            {{--   <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td> --}}
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.semestre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.cantidad }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="datos.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="datos.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(datos,3)" data-placement="top" data-toggle="tooltip" title="Editar Registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(datos,3)" data-placement="top" data-toggle="tooltip" title="Borrar Registro"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
      </div>

      @elseif(intval($dato->tipo)==4)

      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">{{$dato->titulo}}</h3>
          
        <button type="button" class="btn btn-success" id="btnCrear" @click.prevent="nuevo({{intval($dato->tipo)}},'{{$dato->titulo}}',{{$dato->id}})"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

         </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 25%;">Semestre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 45;">Descripción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="datos, key in datosfacultad" v-if="parseInt(datos.tipodato_id)=={{intval($dato->id)}}">
              {{-- <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td> --}}
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.semestre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ datos.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="datos.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="datos.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(datos,4)" data-placement="top" data-toggle="tooltip" title="Editar Registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(datos,4)" data-placement="top" data-toggle="tooltip" title="Borrar Registro"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
      </div>

      @endif

      @endforeach









      <form method="post" v-on:submit.prevent="create">
        <div class="modal bs-example-modal-lg" id="modalGuardar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desGuardarTitulo" style="font-weight: bold;text-decoration: underline;">Nuevo Registro</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTituloN">Tipo de Dato:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
                        <label for="cbuSemestre" class="col-sm-2 control-label">Semestre:*</label>
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuSemestre" name="cbuSemestre" v-model="semestre_id">
                            <option value="0" disabled>Seleccione un Semestre...</option>
                            @foreach($semestres as $dato)
                            <option value="{{$dato->id}}">{{$dato->nombre}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>


      
      
                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)>2">
      
                      <div class="form-group">
                        <label for="txtdesc" class="col-sm-2 control-label">Descripción:*</label>
              
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtdesc" name="txtdesc" placeholder="Descripción" maxlength="500" autofocus v-model="nombre" >
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)<4">
      
                      <div class="form-group">
                        <label for="txtcant" class="col-sm-2 control-label">Cantidad:*</label>
              
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="txtcant" name="txtcant" placeholder="Cantidad" maxlength="20"  v-model="cantidad" onKeyPress="return soloNumeros(event)" >
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)==2">
      
                      <div class="form-group">
                        <label for="txtcant2" class="col-sm-2 control-label">N° de Computadoras Promedio por centro de Cómputo:*</label>
              
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="txtcant2" name="txtcant2" placeholder="Cantidad" maxlength="20"  v-model="cantidad2" onKeyPress="return soloNumeros(event)" >
                        </div>
                      </div>
                    </div>
        
        
             
      
      
      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btnGuardar" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
      
                  <button type="button" id="btnCancel" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
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
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>













































      
      
      <form method="post" v-on:submit.prevent="update(fillDatosfacultad.id)">
        <div class="modal bs-example-modal-lg" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">EDITAR FACULTAD</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTitulo">Tipo de Dato:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="col-md-12" style="padding-top: 15px;">
                      <div class="form-group">
                        <label for="cbuSemestreE" class="col-sm-2 control-label">Semestre:*</label>
                        <div class="col-sm-4">
                          <select class="form-control" id="cbuSemestreE" name="cbuSemestreE" v-model="fillDatosfacultad.semestre_id">
                            <option value="0" disabled>Seleccione un Semestre...</option>
                            @foreach($semestres as $dato)
                            <option value="{{$dato->id}}">{{$dato->nombre}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>


      
      
                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)>2">
      
                      <div class="form-group">
                        <label for="txtdescE" class="col-sm-2 control-label">Descripción:*</label>
              
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="txtdescE" name="txtdescE" placeholder="Descripción" maxlength="500" autofocus v-model="fillDatosfacultad.nombre" >
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)<4">
      
                      <div class="form-group">
                        <label for="txtcantE" class="col-sm-2 control-label">Cantidad:*</label>
              
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="txtcantE" name="txtcantE" placeholder="Cantidad" maxlength="20"  v-model="fillDatosfacultad.cantidad" onKeyPress="return soloNumeros(event)" >
                        </div>
                      </div>
                    </div>


                    <div class="col-md-12" style="padding-top: 15px;" v-if="parseInt(tiporeg)==2">
      
                      <div class="form-group">
                        <label for="txtcant2E" class="col-sm-2 control-label">N° de Computadoras Promedio por centro de Cómputo:*</label>
              
                        <div class="col-sm-4">
                          <input type="text" class="form-control" id="txtcant2E" name="txtcant2E" placeholder="Cantidad" maxlength="20"  v-model="fillDatosfacultad.cantidad2" onKeyPress="return soloNumeros(event)" >
                        </div>
                      </div>
                    </div>

      
                  
      
      
      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btnSaveE"><i class="fa fa-floppy-o" aria-hidden="true"></i> Modificar</button>
      
                  <button type="button" id="btnCancelE" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
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
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
      