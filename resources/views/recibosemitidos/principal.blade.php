<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Gestión de Recibos del día @{{fecha | fecha}}</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}

            <a  type="button" class="btn btn-primary" href="{{URL::to('recibos')}}"><i class="fa fa-money" aria-hidden="true"></i> 
              Nuevo Recibo</a>
          </div>
      
      
      
          {{--  
            <div class="box-footer">
              <button type="button" class="btn btn-primary" onclick="enviarMSj();" id="btnEnviarMsj"><i class="fa fa-envelope-o" aria-hidden="true" ></i> Enviar Mensaje</button>
              <div id="divCarga0" style="display: inline-block;"><div id="dcarga0" style="display: none;"><img src="{{ asset('/img/ajax-loader.gif')}}"/></div></div>
            </div>
            --}}
      
          </div>
      
        </div>
      
      {{--   <div class="box box-success" v-if="divNuevo" style="border: 1px solid #00a65a;">
          <div class="box-header with-border" style="border: 1px solid #00a65a;background-color: #00a65a; color: white;">
            <h3 class="box-title" id="tituloAgregar">Nuevo Banco</h3>
          </div>
      
          <form v-on:submit.prevent="create">
           <div class="box-body">
      
            <div class="col-md-12" >
      
              <div class="form-group">
                <label for="txtnom" class="col-sm-2 control-label">Nombre:*</label>
      
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="txtnom" name="txtnom" placeholder="Nombre" maxlength="500" autofocus v-model="newbanco" >
                </div>
              </div>
            </div>    
      
            <div class="col-md-12" style="padding-top: 15px;">
              <div class="form-group">
                <label for="cbuestado" class="col-sm-2 control-label">Estado:*</label>
                <div class="col-sm-4">
                  <select class="form-control" id="cbuestado" name="cbuestado" v-model="newactivo">
                    <option value="1">Activado</option>
                    <option value="0">Desactivado</option>
                  </select>
                </div>
              </div>
            </div>
      
          </div>
      
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-info" id="btnGuardar">Guardar</button>
      
            <button type="reset" class="btn btn-warning" id="btnCancel" @click="cancelFormNuevo()">Cancelar</button>
      
            <button type="button" class="btn btn-default" id="btnClose" @click.prevent="cerrarFormNuevo()">Cerrar</button>
      
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
      </div> --}}
      
      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Recibos Emitidos</h3>
      
          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">
      
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
              </div>
      
      
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Código de Recibo</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Monto (S/.)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Persona</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Pagado (S/.)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Vuelto (S/.)</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Fecha</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 7%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="recibo, key in recibos">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ recibo.codigo }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; "><label style="float:right;">@{{ parseFloat(recibo.total).toFixed(2) }}</label></td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ recibo.persona }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;"><label style="float:right;">@{{ parseFloat(recibo.efectivo).toFixed(2) }}</label></td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;"  v-if="recibo.estado=='2'"><label style="float:right;">@{{ parseFloat(recibo.vuelto).toFixed(2) }}</label></td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;"  v-if="recibo.estado=='3'"><label style="float:right;">@{{ parseFloat(recibo.efectivo).toFixed(2) }}</label></td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="recibo.estado=='2'">Pagado</span>
               <span class="label label-danger" v-if="recibo.estado=='3'">Extornado</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
      <center>

        <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="verRecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Ver Recibo"><i class="fa fa-eye"></i></a>

          <a href="#" class="btn btn-info btn-sm" v-on:click.prevent="impRecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Imprimir Recibo"><i class="fa fa-print"></i></a>

               <a href="#" v-if="recibo.estado=='2'" class="btn bg-navy btn-sm" v-on:click.prevent="bajarecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Realizar Extorno"><i class="fa fa-download"></i></a>
      
               <a href="#" v-if="recibo.estado=='3'" class="btn btn-success btn-sm" v-on:click.prevent="altarecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Cancelar Extorno"><i class="fa fa-upload"></i></a>
  
               {{-- <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="editrecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Editar recibo"><i class="fa fa-edit"></i></a> --}}
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarrecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Eliminar recibo"><i class="fa fa-trash"></i></a>
      </center>
             </td>
           </tr>
      
         </tbody></table>
      
       </div>
       <!-- /.box-body -->
       <div style="padding: 15px;">
         <div><h5>Registros por Página: @{{ pagination.per_page }}</h5></div>
         <nav aria-label="Page navigation example">
           <ul class="pagination">
            <li class="page-item" v-if="pagination.current_page>1">
             <a class="page-link" href="#" @click.prevent="changePage(1)">
              <span><b>Inicio</b></span>
            </a>
          </li>
      
          <li class="page-item" v-if="pagination.current_page>1">
           <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page-1)">
            <span>Atras</span>
          </a>
        </li>
        <li class="page-item" v-for="page in pagesNumber" v-bind:class="[page=== isActived ? 'active' : '']">
         <a class="page-link" href="#" @click.prevent="changePage(page)">
          <span>@{{ page }}</span>
        </a>
      </li>
      <li class="page-item" v-if="pagination.current_page< pagination.last_page">
       <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page+1)">
        <span>Siguiente</span>
      </a>
      </li>
      <li class="page-item" v-if="pagination.current_page< pagination.last_page">
       <a class="page-link" href="#" @click.prevent="changePage(pagination.last_page)">
        <span><b>Ultima</b></span>
      </a>
      </li>
      </ul>
      </nav>
      <div><h5>Registros Totales: @{{ pagination.total }}</h5></div>
      </div>
      </div>


      @include('recibosemitidos.reciboimprimir')
      





        <div class="modal bs-example-modal-lg" id="modalVisualizar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanio">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTitulo" style="font-weight: bold;text-decoration: underline;">VER RECIBO DE PAGO</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idServicio" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                    <h3 class="box-title" id="boxTitulo">Recibo N° : @{{numgen}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      


                      @include('recibosemitidos.recibovista')
      
      
      
                  </div>
                </div>
                <div class="modal-footer">
                 
      
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
     
      