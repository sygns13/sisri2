<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Reportes Generales de Recibos Emitidos</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbuFecha" class="col-sm-1 control-label">Fecha:*</label>
           <div class="col-sm-3">
<select class="form-control input-xs" id="cbuFecha" name="cbuFecha" v-model="cbufec" @change="cambiarfiltro">
<option value="0">Diario</option>
                 <option value="1">Mensual</option>
                 <option value="2">Anual</option>
                 <option value="3">Rango de Fecha</option>
   </select>


          </div>
          </div>


        </div>


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
            <div v-if="cbufec==3">
              <label for="txtfechai" class="col-sm-1 control-label">Desde:*</label>
               <div class="col-sm-3">
                    <input type="date" name="txtfechai" id="txtfechai" v-model="fechai" class="form-control input-xs" @change="cambiarfiltro">
              </div>
              <label for="txtfechaf" class="col-sm-1 control-label">hasta:*</label>
               <div class="col-sm-3">
                    <input type="date" name="txtfechaf" id="txtfechaf" v-model="fechaf" class="form-control input-xs" @change="cambiarfiltro">
              </div>
            </div>
            <div v-if="cbufec==2 || cbufec==1">
                  <label for="cbuAnio" class="col-sm-1 control-label">Año:*</label>
           <div class="col-sm-3">
<select class="form-control input-xs" id="cbuAnio" name="cbuAnio" v-model="anio" @change="cambiarfiltro">
<option v-for="yea, key in years" v:bind-value="yea.year">@{{yea.year}}</option>
   </select>
          </div>
        </div>
        <div v-if="cbufec==1">
           <label for="cbuMes" class="col-sm-1 control-label">Mes:*</label>
           <div class="col-sm-3">
                      <select class="form-control input-xs" id="cbuMes" name="cbuMes" v-model="mes" @change="cambiarfiltro">
     <option value="1">ENERO</option>
     <option value="2">FEBRERO</option>
     <option value="3">MARZO</option>
     <option value="4">ABRIL</option>
     <option value="5">MAYO</option>
     <option value="6">JUNIO</option>
     <option value="7">JULIO</option>
     <option value="8">AGOSTO</option>
     <option value="9">SETIEMBRE</option>
     <option value="10">OCTUBRE</option>
     <option value="11">NOVIEMBRE</option>
     <option value="12">DICIEMBRE</option>
   </select>
          </div>
        </div>
        <div v-if="cbufec==0">
          <label for="txtfecha0" class="col-sm-1 control-label">Día:*</label>
           <div class="col-sm-3">
                <input type="date" name="txtfecha0" id="txtfecha0" v-model="fecha0" class="form-control input-xs" @change="cambiarfiltro">
          </div>
        </div>
          </div>
          </div>


          <div class="col-md-12" style="    padding-top: 0px;">
            <hr style="border: 1px solid gray;"> 
          </div>


          <div class="col-md-12" style="padding-top: 10px;">
            <div class="form-group" style="font-size: 12px;">
              <label for="cbuTipo" class="col-sm-1 control-label">Tipo:*</label>
             <div class="col-sm-3">
  <select class="form-control input-xs" id="cbuTipo" name="cbuTipo" v-model="tipo" @change="cambiarfiltro">
  <option value="0">Todos</option>
      <option value="1">Pagados</option>
      <option value="2">Extornos</option>

     </select>
  
  
            </div>
            </div>
  
  
          </div>

          <div class="col-md-12" style="padding-top: 0px;">
            <hr style="border: 1px solid gray;"> 
          </div>



          <div class="col-md-12" style="padding-top: 10px;">
              <div class="form-group" style="font-size: 12px;">
                <label for="cbuCajero" class="col-sm-1 control-label">Cajero:*</label>
               <div class="col-sm-8">
    <select class="form-control input-xs" id="cbuCajero" name="cbuCajero" v-model="cajero" @change="cambiarcajero">
    <option value="0">Todos</option>
    <option v-for="cajero, key in cajeros" v-bind:value="cajero.id">@{{cajero.nombre}}</option>

  
       </select>
    
    
              </div>
              </div>
    
    
            </div>

            <div class="col-md-12" style="padding-top: 10px;">
      
                <div class="form-group"style="font-size: 12px;">
                  <label for="txtnom" class="col-sm-1 control-label">Cliente:*</label>
        
                  <div class="col-sm-8">
                    <input type="text" class="form-control input-xs" id="txtnom" name="txtnom" placeholder="Todos" maxlength="1000"  v-model="persona" readonly>
                    
                  </div>

                  <div class="col-sm-2">
                      <a href="#" class="btn btn-primary btn-sm" v-on:click.prevent="buscarpersonas()" data-placement="top" data-toggle="tooltip" title="Buscar Cliente"><i class="fa fa-search"></i></a>
                      <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="limpiarcliente()" data-placement="top" data-toggle="tooltip" title="Limpiar Filtro"><i class="fa fa-times"></i></a>
                  </div>
                </div>
              </div>  

          <div class="col-md-12" style="padding-top: 0px;">
              <hr style="border: 1px solid gray;"> 
            </div>


          <div class="col-md-12" style="padding-top: 15px;">
          <button type="button" class="btn btn-primary" id="btnCargarRep" @click.prevent="buscarDatos()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Cargar Reporte</button>

          

          <button type="button" class="btn btn-warning" id="btnLimpiar" @click.prevent="cancelFiltros()"><i class="fa fa-list" aria-hidden="true" ></i> Limpiar Filtros</button>
        
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
      </div>
    </div>
  

  
  
  
  <div class="box box-primary" style="border: 1px solid #3c8dbc;" v-if="mostrartabla">
    <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
      <h3 class="box-title">Reporte General de Recibos Emitidos</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-success" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>

      <input type="checkbox" id="checkModoImp" value="1" v-model="soloCabecera" class="form-group">
      <label for="checkModoImp">Imprimir. Solo Cabecera</label>


    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>



    <div class="col-md-6">
    <h5 v-if="cbufec==0"><b>Reporte Diario: @{{fecha0 | fecha}}</b></h5>
    <h5 v-if="cbufec==1"><b>Reporte Mensual: @{{mes | mescotejar}}  de @{{anio}}</b></h5>
    <h5 v-if="cbufec==2"><b>Reporte del Año: @{{anio}}</b></h5>
    <h5 v-if="cbufec==3"><b>Reporte Desde: @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
      </div>

      <div class="col-md-6">
        <h5 v-if="tipo==0"><b>Tipo: Todos (Pagados y Extornos)</b></h5>
        <h5 v-if="tipo==1"><b>Tipo: Solo Pagados</b></h5>
        <h5 v-if="tipo==2"><b>Tipo: Solo Extornos</b></h5>
      </div>  
      
      <div class="col-md-6">
      <h5 v-if="tipo==0 | tipo==1"><b>Monto Total Cobrado: S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>
        <h5 v-if="tipo==0 | tipo==2"><b>Monto Total Extornos: S/ @{{parseFloat(totalextornado).toFixed(2)}}</b></h5>
      </div>  

      <div class="col-md-6">
          <h5 v-if="tipo==0 | tipo==1"><b>Número de Recibos Cobrados: @{{numcobrados}}</b></h5>
            <h5 v-if="tipo==0 | tipo==2"><b>Número de Recibos Extornados: @{{numextornados}}</b></h5>
          </div>  


          <div class="col-md-12">
          <h5 v-if="cajero>0"><b>Cajero: @{{nombrecajero}} </b></h5>
          <h5 v-if="persona.length>0"><b>Cliente: @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
          </div>
   

    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
        <tbody><tr>
          <th style="border:1px solid #ddd;padding: 5px; width: 3%;">#</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Código de Recibo</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Monto (S/.)</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Persona</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Pagado (S/.)</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Vuelto (S/.)</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Fecha</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 20%;">Cajero</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 7%;">Estado</th>
          <th style="border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
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
          <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ recibo.nomcajero }}</td>
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

{{--            <a href="#" v-if="recibo.estado=='2'" class="btn bg-navy btn-sm" v-on:click.prevent="bajarecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Realizar Extorno"><i class="fa fa-download"></i></a>
  
           <a href="#" v-if="recibo.estado=='3'" class="btn btn-success btn-sm" v-on:click.prevent="altarecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Cancelar Extorno"><i class="fa fa-upload"></i></a>

           <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrarrecibo(recibo)" data-placement="top" data-toggle="tooltip" title="Eliminar recibo"><i class="fa fa-trash"></i></a> --}}
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
















  <div class="box box-primary" style="display:none;">
    
      <div style="width: 100%; max-width: 30cm; height: auto; background-color: white; border: 1px solid white; margin-bottom:1cm!important;" id="divImp">
      <div style="padding-top: 0cm;;padding-left: 0cm; padding-right: 0cm;">

        <div id="titulo1" style="width:100%;">

          <div style="width:200px;position: absolute; font-size: 8px; float: left; text-align: left;">
            <b>UNIVERSIDAD NACIONAL SANTIAGO ANTÚNEZ DE MAYOLO<b> -
            UNIDAD DE TESORERÍA
          </div>
          <div style="width:50px; position: absolute; font-size: 8px; float: right; right: 50px; top:0mm!important;" class="logorep">
            <img src="{{ asset('/img/unasam.png')}}" class="img img-responsive">
          </div>
            <h3 class="box-title" style="padding-top:10px;font-size: 12px; text-align: center; font-weight: bold; width: 100%;    line-height: 2;"> 
              <center>REPORTE GENERAL DE RECIBOS EMITIDOS</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">
        
          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="cbufec==0"><b>Reporte Diario: @{{fecha0 | fecha}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==1"><b>Reporte Mensual: @{{mes | mescotejar}}  de @{{anio}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==2"><b>Reporte del Año: @{{anio}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==3"><b>Reporte Desde: @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
              </div>
        
              <div style="width:45%; display:inline-block;">
                <h5 style="font-size:11px;" v-if="tipo==0"><b>Tipo: Todos (Pagados y Extornos)</b></h5>
                <h5 style="font-size:11px;" v-if="tipo==1"><b>Tipo: Solo Pagados</b></h5>
                <h5 style="font-size:11px;" v-if="tipo==2"><b>Tipo: Solo Extornos</b></h5>  
              </div>  
              
              <div style="width:45%; display:inline-block;">
              <h5 style="font-size:11px;" v-if="tipo==0 | tipo==1"><b>Monto Total Cobrado: S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>
                <h5 style="font-size:11px;" v-if="tipo==0 | tipo==2"><b>Monto Total Extornos: S/ @{{parseFloat(totalextornado).toFixed(2)}}</b></h5>
              </div>  
        
              <div style="width:45%; display:inline-block;">
                  <h5 style="font-size:11px;" v-if="tipo==0 | tipo==1"><b>Número de Recibos Cobrados: @{{numcobrados}}</b></h5>
                    <h5 style="font-size:11px;" v-if="tipo==0 | tipo==2"><b>Número de Recibos Extornados: @{{numextornados}}</b></h5>
                  </div>  
        
        
                  <div style="width:100%;display:inline-block;">
                  <h5 style="font-size:11px;" v-if="cajero>0"><b>Cajero: @{{nombrecajero}} </b></h5>
                  <h5 style="font-size:11px;" v-if="persona.length>0"><b>Cliente: @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
                  </div>
   
                  
        </div>



        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 4%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 10%;">Código de Recibo</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Monto (S/.)</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 20%;">Persona</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Pagado (S/.)</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Vuelto (S/.)</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Fecha</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 20%;">Cajero</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 10%;">Estado</th>

            </tr>
            <tr v-for="recibo, key in recibosimp">
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+pagination.from}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.codigo }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px; "><label style="font-size:10px;float:right;">@{{ parseFloat(recibo.total).toFixed(2) }}</label></td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.persona }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;"><label style="font-size:10px;float:right;">@{{ parseFloat(recibo.efectivo).toFixed(2) }}</label></td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;"  v-if="recibo.estado=='2'"><label style="font-size:10px;float:right;">@{{ parseFloat(recibo.vuelto).toFixed(2) }}</label></td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;"  v-if="recibo.estado=='3'"><label style="font-size:10px;float:right;">@{{ parseFloat(recibo.efectivo).toFixed(2) }}</label></td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.nomcajero }}</td>
              <td style="font-size:10px;border:1px solid #000000; padding: 2px; vertical-align: middle;">
                  <center>
               <label  v-if="recibo.estado=='2'" style="font-size:10px;">Pagado</label>
               <label  v-if="recibo.estado=='3'" style="font-size:10px;">Extornado</label>
              </center>
             </td>

           </tr>
      
         </tbody></table>

        </div>


        

      </div>
      </div>
  </div>






























  
  
  <div class="box box-primary" style="display:none;">
    
    <div style="width: 100%; max-width: 30cm; height: auto; background-color: white; border: 1px solid white; margin-bottom:1cm!important;" id="divImp2">
    <div style="padding-top: 0cm;;padding-left: 0cm; padding-right: 0cm;">

      <div id="titulo2" style="width:100%;">

        <div style="width:200px;position: absolute; font-size: 8px; float: left; text-align: left;">
          <b>UNIVERSIDAD NACIONAL SANTIAGO ANTÚNEZ DE MAYOLO<b> -
          UNIDAD DE TESORERÍA
        </div>
        <div style="width:50px; position: absolute; font-size: 8px; float: right; right: 50px; top:0mm!important;" class="logorep">
          <img src="{{ asset('/img/unasam.png')}}" class="img img-responsive">
        </div>
          <h3 class="box-title" style="padding-top:10px;font-size: 12px; text-align: center; font-weight: bold; width: 100%;    line-height: 2;"> 
            <center>REPORTE GENERAL DE RECIBOS EMITIDOS</center>
          </h3>
      </div>


      <div id="cabecera2" style="width:100%;">
      
        <div style="width:45%; display:inline-block;">
          <h5 style="font-size:11px;" v-if="cbufec==0"><b>Reporte Diario: @{{fecha0 | fecha}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==1"><b>Reporte Mensual: @{{mes | mescotejar}}  de @{{anio}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==2"><b>Reporte del Año: @{{anio}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==3"><b>Reporte Desde: @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
            </div>
      
            <div style="width:45%; display:inline-block;">
              <h5 style="font-size:11px;" v-if="tipo==0"><b>Tipo: Todos (Pagados y Extornos)</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==1"><b>Tipo: Solo Pagados</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==2"><b>Tipo: Solo Extornos</b></h5>  
            </div>  
            
            <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="tipo==0 | tipo==1"><b>Monto Total Cobrado: S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==0 | tipo==2"><b>Monto Total Extornos: S/ @{{parseFloat(totalextornado).toFixed(2)}}</b></h5>
            </div>  
      
            <div style="width:45%; display:inline-block;">
                <h5 style="font-size:11px;" v-if="tipo==0 | tipo==1"><b>Número de Recibos Cobrados: @{{numcobrados}}</b></h5>
                  <h5 style="font-size:11px;" v-if="tipo==0 | tipo==2"><b>Número de Recibos Extornados: @{{numextornados}}</b></h5>
                </div>  
      
      
                <div style="width:100%;display:inline-block;">
                <h5 style="font-size:11px;" v-if="cajero>0"><b>Cajero: @{{nombrecajero}} </b></h5>
                <h5 style="font-size:11px;" v-if="persona.length>0"><b>Cliente: @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
                </div>
 
                
      </div>

    

    </div>
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
 
  




  <div class="modal bs-example-modal-lg" id="modalPeronas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-lg" role="document" id="modaltamanio3">
        <div class="modal-content" style="border: 1px solid #3c8dbc;">
          <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
            <h4 class="modal-title" id="derPersona" style="font-weight: bold;text-decoration: underline;">Seleccionar Personas Clientes</h4>
  
          </div> 
          <div class="modal-body">

  
            <div class="row">
  
              <div class="box" id="o" style="border:0px; box-shadow:none;" >
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <!-- form start -->
  
                <div class="box-body">
  


                    <div class="box box-primary" style="border: 1px solid #3c8dbc;">
                        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                          <h3 class="box-title">Listado de Personas</h3>
                      
                          <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 300px;">
                              <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn2()">
                      
                              <div class="input-group-btn">
                                <button type="submit" class="btn btn-default" @click.prevent="buscarBtn2()"><i class="fa fa-search"></i></button>
                              </div>
                      
                      
                            </div>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
                            <tbody><tr>
                              <th style="border:1px solid #ddd;padding: 5px; width: 5%;">#</th>
                              <th style="border:1px solid #ddd;padding: 5px; width: 38%;">Apellidos y Nombres</th>
                              <th style="border:1px solid #ddd;padding: 5px; width: 12%;">DNI / RUC</th>
                              <th style="border:1px solid #ddd;padding: 5px; width: 22%;">Tipo</th>
                              <th style="border:1px solid #ddd;padding: 5px; width: 13%;">Código Alumno</th>
                              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Gestión</th>
                            </tr>
                            <tr v-for="person, key in personas">
                              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination2.from}}</td>
                              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ person.nombre }}</td>
                              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ person.dni_ruc }}</td>
                              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ person.tipo }}</td>
                               <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ person.codigo_alumno }}</td>

                             <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">
                      <center>

                      
                               <a href="#"  class="btn btn-info btn-sm" v-on:click.prevent="selectpersona(person)" data-placement="top" data-toggle="tooltip" title="Seleccionar Cliente"><i class="fa fa-check-circle"></i></a>
 
                      </center>
                             </td>
                           </tr>
                      
                         </tbody></table>
                      
                       </div>
                       <!-- /.box-body -->
                       <div style="padding: 15px;">
                         <div><h5>Registros por Página: @{{ pagination2.per_page }}</h5></div>
                         <nav aria-label="Page navigation example">
                           <ul class="pagination">
                            <li class="page-item" v-if="pagination2.current_page>1">
                             <a class="page-link" href="#" @click.prevent="changePage2(1)">
                              <span><b>Inicio</b></span>
                            </a>
                          </li>
                      
                          <li class="page-item" v-if="pagination2.current_page>1">
                           <a class="page-link" href="#" @click.prevent="changePage2(pagination2.current_page-1)">
                            <span>Atras</span>
                          </a>
                        </li>
                        <li class="page-item" v-for="page in pagesNumber2" v-bind:class="[page=== isActived ? 'active' : '']">
                         <a class="page-link" href="#" @click.prevent="changePage2(page)">
                          <span>@{{ page }}</span>
                        </a>
                      </li>
                      <li class="page-item" v-if="pagination2.current_page< pagination2.last_page">
                       <a class="page-link" href="#" @click.prevent="changePage2(pagination.current_page+1)">
                        <span>Siguiente</span>
                      </a>
                      </li>
                      <li class="page-item" v-if="pagination2.current_page< pagination2.last_page">
                       <a class="page-link" href="#" @click.prevent="changePage2(pagination2.last_page)">
                        <span><b>Ultima</b></span>
                      </a>
                      </li>
                      </ul>
                      </nav>
                      <div><h5>Registros Totales: @{{ pagination2.total }}</h5></div>
                      </div>
                      </div>
  
  
  
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
 