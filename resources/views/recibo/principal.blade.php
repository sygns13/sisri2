<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Emisión de Recibos</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>

        <div class="box-body" style="border: 1px solid #3c8dbc;">
          
        
          <div class="col-md-6 no-print" style="border-right: solid 1px #ccc;">
            <h4 class="" style="background-color:#3c8dbc; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;color: white;">
                Emisión de Recibos
            </h4>

              <div class="panel-body" style="padding-top: 0px;">

                    <form v-on:submit.prevent="create">

                        <div class="col-md-12">

                                <div class="row">
                         
                                    <div class="col-xs-4">
                                         {{-- <b class="">Nro</b> --}}
                                        <input type="text" class="form-control " style="text-align: left;padding-left: 5px;padding-right: 5px;background-color: #eeeeee00;border:1px solid #ccc0;box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0.075);font-weight: bold;" name="codigo" id="codigo"  readonly v-bind:value="year+'-'+numgen">
                                        {{--v-model="year+'-'+numgen"--}}
                                    </div>

                                    <div class="col-xs-3">
                                       {{-- <b class="">Fecha</b> --}}
                                        <input class="form-control  pull-right" style="text-align: left;padding-right: 5px;padding-left: 5px;background-color: #eeeeee00;border:1px solid #ccc0;box-shadow: inset 0 0px 0px rgba(0, 0, 0, 0.075);font-weight: bold;" id="fechaM" name="fechaM" v-bind:value="fecha | fecha" readonly>
                                    </div>

                                </div>

                                <hr class="hrr " style="margin-top: 10px;">

                                <b class="">Persona (DNI/RUC)</b>
                                    <!-- <hr> -->
                                <div class="row">
                                    <div class="col-xs-12">
                                      <input class="form-control " id="dni_ruc" placeholder="DNI/RUC" name="dni_ruc" maxlength="11" v-model="newDNI" onkeypress="return soloNumeros(event);" @keydown="$event.keyCode === 13 ? pasarenter() : false">
                                    </div>
                                </div>

                                <div v-if="noNombre">
                                <b class="">Nombres</b>
                                    <!-- <hr> -->
                                <div class="row">
                                    <div class="col-xs-12">
                                      <input class="form-control " id="nonombre" placeholder="Apellidos y Nombres" name="nombre" maxlength="1000" v-model="newNombre" @keydown="$event.keyCode === 13 ? pasarenter2() : false">
                                    </div>
                                </div>
                              </div>


                                <div id="persona">
                                    <br><div class="form-group has-success" style="margin-bottom: 0px;"><input type="text" class="form-control " style="background-color: #00a65a;color: white;" id="persona_id" v-model="newNombreZ" disabled></div>
                                </div>

                                <hr class="hrr " style="margin-top: 5px;border-top: 1px solid #3c8dbc">

                                <b class="">Concepto</b>
                                
                                    <div class="row" v-show="clearselect">
                                        <div class="col-xs-12">

                                        <select id="precio_id" class="form-control" style="padding-top: 4px; font-family: Arial;" onchange="cambiardato()">
                                        <option disabled value="">Seleccione</option>
                                        <option v-for="precio, key in precios" v-bind:value="key">(@{{precio.codigo.replace(".", "" )}}) @{{precio.descripcion}} S/. (@{{parseFloat(precio.monto).toFixed(2)}})</option>
                                      </select>
                                        </div>
                                      </div>

                                      <div id="deta">
                                          
                                      </div>

                                

                                <hr class="hrr " style="margin-top: 10px;">
                                
                                <b class="">Monto Establecido en el Tarifario de Pagos(S/)</b>
                                <input class="form-control " id="monto" placeholder="Monto" name="monto" disabled  v-model="newmontoU">
                                <br>

                                <b class="">Cantidad</b>
                                <input class="form-control " id="cantidad" placeholder="Cantidad" name="cantidad" onKeyPress="return soloNumeros(event)" v-model="newcant" @keydown="$event.keyCode === 13 ? pasarrecibo() : false" @keyup="$event.keyCode != 13 ? calcular() : false">
                                <br>

                                <b class="">Monto Total(S/)</b>
                                <input class="form-control " id="monto" placeholder="Monto Total" name="monto" disabled  v-model="newmontoT">
                                <br>
                                <br>
                                <br>

                                
                                <button type="button" class="btn btn-primary" id="guardar" @click.prevent="modalpagar()"> <i class="fa fa-credit-card"></i>  Pagar</button> 
                              
                                <button type="reset" class="btn btn-danger" id="btnCancelF" @click="cancelFormNuevo()"><i class="fa fa-times" aria-hidden="true"></i>  Cancelar</button>

                                <a  type="button" class="btn btn-success" href="{{URL::to('recibosemitidos')}}"><i class="fa fa-file-text-o" aria-hidden="true"></i> 
                                    Ver Recibos Emitidos</a>

                            

                        </div>

                            <div class="modal" id="modalPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                              <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                   
                                    <h4 class="modal-title" id="exampleModalLabel" style="font-weight: bold;">Pagar (S/)</h4>

                                  </div>
                                  <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Monto a Pagar:</label>
                                            <input type="text" class="form-control" id="montoPagar" readonly v-model="importerecibo2">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Efectivo:</label>
                                            <input type="text" class="form-control" id="efectivoFinal" onKeyPress="return soloNumeros(event)" v-model="newmontoP" autofocus @keydown="$event.keyCode === 13 ? pagarRecibo() : false" @keyup="$event.keyCode != 13 ? calcular2() : false">
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="control-label">Vuelto:</label>
                                            <input type="text" class="form-control" id="vueltoFinal" readonly v-model="newmontoV">
                                        </div>
                                    </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnCancel">Cancelar</button>
                                    <button type="button" class="btn btn-success" @click.prevent="pagarRecibo()" id="btnGuardar">Pagar (S/)</button>

                                   

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


                    </form>

              </div>

          </div>











































          <div class="col-md-6" style="border-left: solid 1px #ccc0;">
            <h4 class="no-print" style="background-color:#f39c12; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;color: white;">
                Vista Previa
            </h4>

            <div class="panel-body">
                
                  <div class="col-md-12" id="vistaPrevia" style="text-align: center;">
                        
                            <div id="recib" style="width: 9.5cm;padding-left: 0px;border: 2px;border-style: solid;margin: 0 auto;border-radius: 5px" class="">
                                <div style="width: 9.5cm">
                                    
                                   <div style="width: 9.5cm;">

                                   <!-- ........................CABECERA......................... -->

                                   <div style="width: 9.5cm;height: 4.7cm">
                                       

                                    <div style="width: 9.5cm;">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    
                                                    <td style="width: 0.4cm; text-align: center;padding-top: 20px;">
                                                    </td>

                                                    <td style="width: 8.7cm;;text-align: center;padding-top: 20px;">

                                                        <img class="" style="width: 8.7cm" src="{{ asset('/img/logofinal.jpg') }}">
                                                        
                                                    </td>
                                                   <td style="width: 0.4cm; text-align: center;padding-top: 20px;">
                                                    </td> 
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <hr style="margin-top: 10px;margin-bottom: 10px;">

                                    <div style="width: 9.5cm;text-align: center;">
                                        
                                    <p style="margin-bottom: 0px;font-size: 17px;"><strong>RECIBO DE INGRESO @{{year}}</strong></p>
                                                                               
                                    </div>
                                    
                                        
                                    <div style="width: 9.5cm;"> 
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 9.5cm;text-align: center;padding-bottom: 7px;padding-top: 7px;">
                                                        <p style="margin-bottom: 0px;font-size: 15px;"><strong>Nro: @{{year}} - @{{numgen}}</strong></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                   </div> 

                                   <!-- ................................. -->

                                   <!-- ........................NOMBRES Y MONTO......................... -->

                                  
                                    <div style="width: 9.4cm;height: 3.3cm;border-top: solid 1px;border-bottom: solid 1px;">

                                        <div style="width: 9.5cm;padding-top: 10px;padding-bottom: 4px;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 2cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>Recibí de</strong></p>
                                                        </td>
                                                        
                                                        <td style="width: 0.1cm; text-align: left;">
                                                        <p style="margin-bottom: 0px;font-size: 10px;padding-left: 10px;"><b>:</b></p>
                                                        </td>

                                                        <td style="width: 7.4cm; text-align: left;">
                                                            <div id="nombresVP">
                                                           <p style="    margin-bottom: 0px;
                                                           font-size: 11px;
                                                           padding-left: 10px;
                                                           padding-right: 10px;"><b>
                                                           @{{nombrerecibo}}</b>
                                                               </p>         
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div style="width: 9.5cm;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 2cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>Importe</strong></p>
                                                        </td>
                                                        <td style="width: 0.1cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 10px;padding-left: 10px;"><b>:</b></p>
                                                        </td>
                                                        <td style="width: 7.5cm; text-align: left;">
                                                            <div id="montoVP">
                                                                <p style="margin-bottom: 0px;font-size: 12px;padding-left: 10px;"> @{{importerecibo}} </p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div style="width: 9.5cm;padding-top: 4px;padding-bottom: 10px;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 2cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>Importe en letras</strong></p>
                                                        </td>
                                                        <td style="width: 0.1cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 10px;padding-left: 10px;"><b>:</b></p>
                                                        </td>
                                                        <td style="width: 5.5cm; text-align: left;">
                                                            <div id="montoLetras">
                                                                <p style="margin-bottom: 0px;font-size: 12px;padding-left: 10px;"> 
                                                                @{{importeletras}}</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                    <!-- ........................ADVERTENCIA......................... -->

                                    <div style="width: 9.5cm;height: 1.4cm"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 9.5cm; text-align: center;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;padding-top: 7px;padding-right: 10px;padding-bottom: 7px;"><strong>VERIFIQUE SU PAGO, NO SE ACEPTAN DEVOLUCIONES</strong></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                    <!-- ........................ADVERTENCIA......................... -->
                                    <!-- ........................CONCEPTO FECHA NRO......................... -->
                                    
                                    <div style="width: 9.4cm;border-top: solid 1px;border-bottom: solid 1px">
                                        
                                       {{--  <div style="width: 9.5cm;padding-top: 10px;padding-bottom: 7px;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 2.5cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>Recibo Nro</strong></p>
                                                        </td>
                                                        <td style="width: 0.1cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 10px;padding-left: 10px;"><b>:</b></p>
                                                        </td>
                                                        <td style="width: 7cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 12px;padding-left: 10px;">$anio - nummax</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> --}}


                                        <div style="width: 9.5cm;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 9.5cm; text-align: justify;">
                                                            <div id="conceptoVPCabe">
                                                                <table id="dds" class="" style="width: 9.3cm;margin-left: 1px;margin-right: 3px;border-right-width: 1px;background: #e5e4e4;">
                                                                    <thead>
                                                                    <tr >
                                                                        <th style="text-align: center;font-size: 9px;width: 7cm;padding-right: 0px;padding-top: 3px;padding-bottom: 3px;border-bottom: solid 1px;">Producto</th>
                                                                        <th style="text-align: center;font-size: 9px;width: 1.2cm;padding-right: 0px;padding-top: 3px;padding-bottom: 3px;border-bottom: solid 1px;">P.Uni.</th>
                                                                        <th style="text-align: center;font-size: 9px;width: 1.1cm;padding-right: 0px;padding-top: 3px;padding-bottom: 3px;border-bottom: solid 1px;">Cant</th>
                                                                        <th style="text-align: center;font-size: 9px;width: 1.2cm;padding-right: 0px;padding-top: 3px;padding-bottom: 3px;border-bottom: solid 1px;">Total</th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                            <div id="conceptoVP">
                                                                <table style="width: 9.4cm;margin-left: 0px;margin-right: 0px;border-right-width: 1px;margin-top: 4px;margin-bottom: 4px;">
                                                                        <thead>
                                                                            <tr  v-for="dt, key in detallerecibo">
                                                                                <th style="text-align: left;font-size: 9px;width: 7cm;padding-right: 2px;padding-left: 5px;">
                                                                                <button type="button" data-dismiss="alert" style="font-family: Arial;font-size: 8px;text-align: left;background-color: #0000;border: solid 1px #ccc0;padding-left: 3px;" v-on:click.prevent="quitarEle(key)">@{{dt.concepto}}</button>
                                                                                </th>
                                                                                <th style="text-align: center;font-size: 8px;width: 1.2cm;padding-right: 2px;">
                                                                                    @{{dt.precioU}}</th>
                                                                                <th style="text-align: center;font-size: 8px;width: 1.1cm;padding-right: 2px;">
                                                                                    @{{dt.cant}}</th>
                                                                                <th style="text-align: center;font-size: 8px;width: 1.2cm;padding-right: 0px;">
                                                                                    @{{dt.precioT}}</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th colspan="4" style="font-size: 10px;padding-left: 5px;"> 
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                    </table>

                                                                </table>
                       
                                                            </div>
                                                            <div id="conceptoVPCabe">
                                                                <table id="dds" class="" style="width: 9.3cm;margin-left: 1px;margin-right: 3px;border-right-width: 1px;background: #e5e4e4;">
                                                                    <thead>
                                                                    <tr >
                                                                        <th colspan="3" style="text-align: right;font-size: 9px;width: 9.4cm;padding-right: 4px;padding-top: 3px;padding-bottom: 3px;border-top: solid 1px;">Total (S/)</th>
                                                                        <th style="text-align: center;font-size: 9px;width: 1cm;padding-right: 0px;padding-top: 3px;padding-bottom: 3px;border-top: solid 1px;"><div id="totalDetalle" style="text-align: center;">@{{importerecibo2}} </div></th>
                                                                    </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div style="width: 9.5cm;padding-top: 10px;padding-bottom: 10px;"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                        <td style="width: 2.5cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>Fecha</strong></p>
                                                        </td>
                                                        <td style="width: 0.1cm; text-align: left;">
                                                            <p style="margin-bottom: 0px;font-size: 10px;padding-left: 10px;"><b>:</b></p>
                                                        </td>
                                                        <td style="width: 7cm; text-align: left;">
                                                        <p style="margin-bottom: 0px;font-size: 12px;padding-left: 10px;">@{{fecha  | fecha}}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                        <div style="width: 9.5cm;height: 2.3cm"> 
                                            <table>
                                                <tbody>
                                                    <tr style="">
                                                       {{--  <td style="width: 4.68cm; text-align: center;height: 2.3cm;border-right: solid 1px;">
                                                            <p style="margin-bottom: 0px;font-size: 14px;padding-left: 10px;"><strong>
                                                                <img id="barcode1" style="height: 80px;width: 150px;" />
                                                                <script>JsBarcode("#barcode1", "$anio - nummax");</script>
                                                            </strong></p>
                                                        </td> --}}
                                                        <td style="width: 4.68cm; text-align: center;height: 2.3cm;border-left: solid 1px;">
                                                            <p style="margin-bottom: 0px;font-size: 10px;padding-left: 0px;padding-top: 70px;"><strong>Firma y Sello</strong></p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>

            </div>

      
          </div>
        </div>
      
      