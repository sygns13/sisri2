<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Auditoría de Recibos</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>

        <div class="box-body" style="border: 1px solid #3c8dbc;">
          
        
          <div class="col-md-12 no-print" style="border-right: solid 1px #ccc;">
            <h4 class="" style="background-color:#3c8dbc; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;color: white;">
                Búsqueda de Recibo
            </h4>

              <div class="panel-body" style="padding-top: 0px;">

                    <form>

                        <div class="col-md-12">

                                <div class="row">
                         
                                    <div class="col-xs-4">
                                         {{-- <b class="">Nro</b> --}}
                                        <input type="text" class="form-control " style="text-align: left;padding-left: 5px;padding-right: 5px;background-color: #eeeeee00;border:1px solid #ccc0;box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0.075);font-weight: bold;" name="codigo" id="codigo"  readonly v-bind:value="labelfecha">
                                        {{--v-model="year+'-'+numgen"--}}
                                    </div>

                                    <div class="col-xs-3">
                                       {{-- <b class="">Fecha</b> --}}
                                        <input class="form-control  pull-right" style="text-align: left;padding-right: 5px;padding-left: 5px;background-color: #eeeeee00;border:1px solid #ccc0;box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0.075);font-weight: bold;" id="fechaM" name="fechaM" v-bind:value="fecha | fecha" readonly>
                                    </div>

                                </div>

                                <hr class="hrr " style="margin-top: 10px;">

                                <b class="">Ingrese el código del Recibo</b> (Código Completo y con el número de caracteres exacto sin espacios Ej. 2019-00000001) 
                                    <!-- <hr> -->
                                <div class="row">
                                    <div class="col-xs-12">
                                      <input class="form-control " id="codRecibo" placeholder="2019-00000001" name="codRecibo" maxlength="13" v-model="codRbo"  @keydown="$event.keyCode === 13 ? buscarRecibo() : false">
                                    </div>
                                </div>


                                <hr class="hrr " style="margin-top: 10px;">

                                <div style="width:100%; paddig-top:15px;">
                                    

                                            
                                <button type="button" class="btn btn-primary" id="guardar" @click.prevent="buscarRecibo()"> <i class="fa fa-search"></i>  Realizar Búsqueda</button> 
                              
                                <button type="reset" class="btn btn-danger" id="btnCancelF" @click="cancelFormNuevo()"><i class="fa fa-times" aria-hidden="true"></i>  Cancelar</button>

                                    
                                </div>

                                <div v-show="divloaderNuevo" style="padding-top: 100px;">

                                    <div class="sk-circle" >
                          
                                       
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
                              <center><h3 style="color:red"><b>Cargando Datos, Por Favor Espere un momento ...</b></h3></center>
                            </div>

                            

                        </div>

                          

                    </form>

              </div>

          </div>

            </div>

      
          </div>
        </div>
      
      


        <div class="box box-primary panel-group" v-if="mostrarRecibo">
            <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
              <h3 class="box-title">Reporte Completo de Recibo</h3>

              <button type="button" class="btn btn-success" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
            </div>
          
          <div class="box-body" style="border: 1px solid #3c8dbc;" >

            <div id="divImp"> 
              
          <div class="col-md-12">


              <center>  <h3 style="text-decoration:underline;"><b>Auditoría de Recibos - SISCTES<b></h3> </center>

          <center>  <h4><b>Información Principal del Recibo<b></h4> </center>
            
            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Código:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{recibo.codigo}}</label>
                    </div>
            </div>



            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Fecha Registrado:</label>
                      <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{recibo.fecha | fecha}}</label>

                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Hora Registrado:</label>
                      <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{recibo.hora_pagada}}</label>
                    </div>
            </div>

            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Estado:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.borrado==1">Recibo Borrado</label>

                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.borrado==0 && recibo.estado==1">Recibo Inicializado: (No Procesado)</label>

                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.borrado==0 && recibo.estado==2">Recibo Pagado - No Extornado</label>

                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.borrado==0 && recibo.estado==3">Recibo Pagado - Extornado</label>

                    
                    </div>
            </div>


            <div class="col-md-12" v-if="recibo.borrado==0 && recibo.estado==3">
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Fecha Extorno:</label>
                      <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{recibo.fechaextorno | fecha}}</label>

                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Hora Extorno:</label>
                      <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{recibo.horaextorno}}</label>
                    </div>
            </div>




            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Monto Total:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">S/.@{{ parseFloat(recibo.total).toFixed(2) }}</label>
                    </div>
            </div>

            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Monto Pagado:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">S/.@{{ parseFloat(recibo.efectivo).toFixed(2) }}</label>
                    </div>
            </div>

            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Monto Vuelto:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">S/.@{{ parseFloat(recibo.vuelto).toFixed(2) }}</label>
                    </div>
            </div>
            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Tipo de Pago:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.tipopago_id==1">Pago en Ventanilla</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.tipopago_id==2">Depósito Bancario</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="recibo.tipopago_id==3">Pago Virtual con Tarjeta</label>
                    </div>
            </div>



            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Persona Pagadora:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{ cliente.nombre }}</label>
                    </div>
            </div>
            <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">DNI - RUC:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{ cliente.dni_ruc }}</label>
                    </div>
            </div>




            <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
                      <tbody>
                          <tr>
                              <th style="border:1px solid #ddd;padding: 5px; width: 5%;" colspan="7">
                                  <center> 
                                  Eventos de Proceso Ejecutados por Usuarios con el Recibo de Pago  @{{recibo.codigo}}
                                </center>
                              </th>
                          </tr>
                        
                        <tr>
                        <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Hora</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 21%;">Evento</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 17%;">Usuario</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 22%;">Nombres y Apellidos</th>
                        <th style="border:1px solid #ddd;padding: 5px; width: 15%;">tipo de Usuario</th>
                      </tr>
                      <tr v-for="prorecibo, key in procesosRecibo">
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.fecha | fecha }}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.hora }}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.accion }}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.name }}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.nombre }}</td>
                        <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ prorecibo.tipo }}</td>

                     </tr>
                
                   </tbody></table>
                
                 </div>


                 <div class="col-md-12" style="padding-top:50px;">
                    <center>  <h4><b>Detalles de Conceptos de Pago del Recibo<b></h4> </center>
                 </div>

                 <div v-for="detalleRecibo, key in detalleRecibos" class="col-md-12" style="padding-top:25px;">


                    <div class="col-md-12" >
      
                        <div class="form-group">
                          <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">@{{key+1}}.- Concepto de Pago:</label>
                          <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{detalleRecibo.concepto}}</label>
                        </div>
                </div>


                <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Entidad:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{detalleRecibo.entidad}}</label>
                    </div>
            </div>

            <div class="col-md-12" >
      
                <div class="form-group">
                  <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Categoría:</label>
                  <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{detalleRecibo.categoria}}</label>
                </div>
        </div>

        <div class="col-md-12" >
      
            <div class="form-group">
              <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Rubro:</label>
              <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{detalleRecibo.rubro}}</label>
            </div>
    </div>



                <div class="col-md-12" >
      
                    <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Estado:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="detalleRecibo.estado==1">Concepto Pagado no Procesado</label>

                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;" v-if="detalleRecibo.estado==2">Concepto Pagado Procesado</label>

                    </div>
            </div>




            <div class="col-md-12" v-if="detalleRecibo.estado==2">
      
                <div class="form-group">
                  <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Fecha Procesado:</label>
                  <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{detalleRecibo.fecha_usado | fecha}}</label>

                  <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Hora Procesado:</label>
                  <label for="txtnom" class="col-sm-5 control-label" style="font-weight:normal;width: 30%;">@{{detalleRecibo.hora_usado}}</label>
            </div>

           </div>

            <div class="col-md-12" >
  
                <div class="form-group">
                  <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Monto Unitario:</label>
                  <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">S/.@{{ parseFloat(detalleRecibo.precioUnitario).toFixed(2) }}</label>
                </div>

                <div class="form-group">
                    <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Cantidad:</label>
                    <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">@{{ parseInt(detalleRecibo.cantidad) }}</label>
                  </div>

                  <div class="form-group">
                      <label for="txtnom" class="col-sm-1 control-label" style="margin-left:0px;margin-right:0px; paddding-left:0px;padding-right:0px;width: 13%;">Monto Total:</label>
                      <label for="txtnom" class="col-sm-11 control-label" style="font-weight:normal;width: 85%;">S/.@{{ parseFloat(detalleRecibo.precioTotal).toFixed(2) }}</label>
                    </div>


        </div>



<template v-if="parseInt(detalleRecibo.contProcesos)>0">
        <div class="box-body table-responsive">
            <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
              <tbody>
                  <tr>
                      <th style="border:1px solid #ddd;padding: 5px; width: 5%;" colspan="7">
                          <center> 
                          Eventos de Proceso Ejecutados por Usuarios con el Concepto de Pago  @{{detalleRecibo.concepto}}
                        </center>
                      </th>
                  </tr>
                
                <tr>
                <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Fecha</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Hora</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 21%;">Evento</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 17%;">Usuario</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 22%;">Nombres y Apellidos</th>
                <th style="border:1px solid #ddd;padding: 5px; width: 15%;">tipo de Usuario</th>
              </tr>
              <tr v-for="detalleProceso, key2 in detalleProcesos" v-if="detalleRecibo.id==detalleProceso.id">

                <template >
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key2+1}}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.fecha | fecha }}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.hora }}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.accion }}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.name }}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.nombre }}</td>
                <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ detalleProceso.tipo }}</td>
              </template>
             </tr>
        
           </tbody></table>
        
         </div>
</template>



  </div>




                 </div>


            
          </div>
          </div>
              </div>
          
            </div>