<div class="col-md-12" style="border-left: solid 1px #ccc0;">
            <h4 class="no-print" style="background-color:#f39c12; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;color: white;">
                Vista Previa
            </h4>

            <div class="panel-body">
                
                  <div class="col-md-12" id="vistaPrevia2" style="text-align: center;">
                        
                            <div id="recib2" style="width: 9.5cm;padding-left: 0px;border: 2px;border-style: solid;margin: 0 auto;border-radius: 5px" class="">
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
                                                        <p style="margin-bottom: 0px;font-size: 15px;"><strong>Nro:  @{{numgen}}</strong></p>
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
                                                            <div id="nombresVP2">
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
                                                            <div id="montoVP2">
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
                                                            <div id="montoLetras2">
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
                                                            <div id="conceptoVPCabe2">
                                                                <table id="dds2" class="" style="width: 9.3cm;margin-left: 1px;margin-right: 3px;border-right-width: 1px;background: #e5e4e4;">
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
                                                            <div id="conceptoVP2">
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
                                                            <div id="conceptoVPCabe2">
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