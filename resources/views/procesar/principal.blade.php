<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Procesar Recibos</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            


          </div>
      
          @if(accesoUser([4]))
        <h3 v-for="entidad, key in entidads">Entidad  @{{entidad.code}} - @{{entidad.descripcion}}</h3>
          @endif
      
          </div>
      
        </div>
      
        
      
      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Recibos</h3>
      
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
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 3%;">#</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Código de Recibo</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Categoría</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Rubro</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Concepto de Pago</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Entidad</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Costo Unitario (S/.)</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 5%;">Cantidad</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Costo Total (S/.)</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Persona</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha Pagado</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha Procesado</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Cajero</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 5%;">Estado</th>
                  <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 5%;">Gestión</th>
                </tr>
                <tr v-for="recibo, key in recibos">
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.codigo }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.categoria }}</td>
        
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.rubro }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.concepto }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.entidad }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px; "><label style="float:right;">@{{ parseFloat(recibo.precioUnitario).toFixed(2) }}</label></td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.cantidad }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"><label style="float:right;">@{{ parseFloat(recibo.precioTotal).toFixed(2) }}</label></td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.persona }}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;" v-if="recibo.estadodetalle=='1'"> <center>----</center></td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;" v-if="recibo.estadodetalle=='2'">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ recibo.nomcajero }}</td>
        
                  <td style="border:1px solid #ddd;font-size: 11px; padding: 5px; vertical-align: middle;">
                    <center>
                 <span class="label label-primary" v-if="recibo.estado=='2' && recibo.estadodetalle=='1'">Pagado No Usado</span>
                 <span class="label label-success" v-if="recibo.estado=='2'  && recibo.estadodetalle=='2'">Pagado Usado</span>
        
                 <span class="label label-danger" v-if="recibo.estado=='3'">Extornado</span>
                </center>
               </td>
               <td style="vertical-align:middle;">
                 <center> 

                  <a v-if="recibo.estado=='2' && recibo.estadodetalle=='1'" href="#" class="btn btn-success btn-sm" v-on:click.prevent="procesarRecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Procesar Recibo"><i class="fa fa-cogs"></i></a>

                  <a v-if="recibo.estado=='2' && recibo.estadodetalle=='2'" href="#" class="btn btn-danger btn-sm" v-on:click.prevent="quitarProcesoRecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Cancelar Procesamiento del Recibo"><i class="fa fa-times"></i></a>

                </center>
               </td>
        
               </tr>
          
             </tbody>
           </table>
      
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
      
          