<div class="box box-primary panel-group">
    <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
    <h3 class="box-title">Recibos Procesados</h3>
      <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
      Volver</a>
    </div>
  
  <div class="box-body" style="border: 1px solid #3c8dbc;">
      <div class="form-group form-primary">
        {{-- <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-money" aria-hidden="true" ></i> Nuevo Recibo</button> --}}


        @if(accesoUser([4]))
        <h3 v-for="entidad, key in entidads">Entidad  @{{entidad.code}} - @{{entidad.descripcion}}</h3>
          

        @else
        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbuLocal" class="col-sm-1 control-label">Local (Uso del Recibo):*</label>
           <div class="col-sm-8">
<select class="form-control input-xs" id="cbuLocal" name="cbuLocal" v-model="local" @change="cambiarlocal">
<option value="0">Todos</option>
<option v-for="local, key in locals" v-bind:value="local.id">@{{local.nombre}}</option>
   </select>
          </div>
          </div>
        </div>



        <div class="col-md-12" style="padding-top: 10px;" v-if="local>0">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbuEntidad" class="col-sm-1 control-label">Entidad  (Uso del Recibo):*</label>
           <div class="col-sm-8">
<select class="form-control input-xs" id="cbuEntidad" name="cbuEntidad" v-model="entidad" @change="cambiarentidad">
<option value="0">Todos</option>
<option v-for="entidad, key in entidads" v-bind:value="entidad.id">(@{{entidad.code}}) @{{entidad.descripcion}}</option>
   </select>
          </div>
          </div>
        </div>

        @endif


        <div class="col-md-12" style="padding-top: 0px;">
          <hr style="border: 1px solid gray;"> 
        </div>


        <div class="col-md-12" style="padding-top: 10px;">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbuCategoria" class="col-sm-1 control-label">Categoría:*</label>
           <div class="col-sm-8">
<select class="form-control input-xs" id="cbuCategoria" name="cbuCategoria" v-model="categoria" @change="cambiarcategoria">
<option value="0">Todos</option>
<option v-for="categoria, key in categorias" v-bind:value="categoria.id">(@{{categoria.code}}) @{{categoria.descripcion}}</option>


   </select>


          </div>
          </div>


        </div>


        <div class="col-md-12" style="padding-top: 10px;" v-if="categoria>0">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbuRubro" class="col-sm-1 control-label">Rubro:*</label>
           <div class="col-sm-8">
<select class="form-control input-xs" id="cbuRubro" name="cbuRubro" v-model="rubro" @change="cambiarrubro">
<option value="0">Todos</option>
<option v-for="rubro, key in rubros" v-bind:value="rubro.id">(@{{rubro.code}}) @{{rubro.descripcion}}</option>
   </select>
          </div>
          </div>
        </div>


        <div class="col-md-12" style="padding-top: 10px;" v-if="rubro>0">
          <div class="form-group" style="font-size: 12px;">
            <label for="cbsprecio" class="col-sm-1 control-label">Concepto de Pago:*</label>
           <div class="col-sm-8">
<select class="form-control input-xs" id="cbsprecio" name="cbsprecio" v-model="precio" @change="cambiarprecio">
<option value="0">Todos</option>
<option v-for="precio, key in precios" v-bind:value="precio.id">(@{{precio.codigo}}) @{{precio.descripcion}}</option>
   </select>
          </div>
          </div>
        </div>






        <div class="col-md-12" style="padding-top: 0px;">
          <hr style="border: 1px solid gray;"> 
        </div>


        <div class="col-md-12" >
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
      <option value="2">Procesados</option>
      <option value="1">No Procesados</option>

     </select>
  
  
            </div>
            </div>
  
  
          </div>

          <div class="col-md-12" style="padding-top: 0px;">
            <hr style="border: 1px solid gray;"> 
          </div>


          


      



          <div class="col-md-12" style="padding-top: 10px;" v-if="false">
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
      <h3 class="box-title">Reporte Detallado de Recibos Emitidos</h3>

    </div>


    <div class="col-md-12" style="padding-top: 15px;">
      <button type="button" class="btn btn-success" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>

      <input type="checkbox" id="checkModoImp" value="1" v-model="soloCabecera" class="form-group">
      <label for="checkModoImp">Imprimir. Solo Cabecera</label>


    </div>

    <div class="col-md-12" style="padding-top: 0px;">
      <hr style="border: 1px solid gray;"> 
    </div>

    <div class="col-md-12">
      <h5 v-if="local>0"><b><div style="display:inline-block; width:150px;">Local:</div> @{{nombrelocal}} </b></h5>
      <h5 v-if="local>0 && entidad>0"><b><div style="display:inline-block; width:150px;">Entidad:</div> @{{nombreentidad}}</b></h5>
    </div>

    <div class="col-md-12">
      <h5 v-if="categoria>0"><b><div style="display:inline-block; width:150px;">Categoria:</div> @{{nombrecategoria}} </b></h5>
      <h5 v-if="categoria>0 && rubro>0"><b><div style="display:inline-block; width:150px;">Rubro:</div> @{{nombrerubro}}</b></h5>
      <h5 v-if="categoria>0 && rubro>0 && precio>0"><b><div style="display:inline-block; width:150px;">Concepto de Pago:</div> @{{nombreprecio}}</b></h5>
    </div>


    <div class="col-md-6">
    <h5 v-if="cbufec==0"><b><div style="display:inline-block; width:150px;">Reporte Diario:</div> @{{fecha0 | fecha}}</b></h5>
    <h5 v-if="cbufec==1"><b><div style="display:inline-block; width:150px;">Reporte Mensual:</div> @{{mes | mescotejar}}  de @{{anio}}</b></h5>
    <h5 v-if="cbufec==2"><b><div style="display:inline-block; width:150px;">Reporte del Año:</div> @{{anio}}</b></h5>
    <h5 v-if="cbufec==3"><b><div style="display:inline-block; width:150px;">Reporte Desde:</div> @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
      </div>

      <div class="col-md-6">
        <h5 v-if="tipo==0"><b><div style="display:inline-block; width:150px;">Tipo:</div> Todos (Procesados y No Procesados)</b></h5>
        <h5 v-if="tipo==1"><b><div style="display:inline-block; width:150px;">Tipo:</div> Solo No Procesados</b></h5>
        <h5 v-if="tipo==2"><b><div style="display:inline-block; width:150px;">Tipo:</div> Solo Procesados</b></h5>
      </div>  
      
      <div class="col-md-6">
      <h5><b><div style="display:inline-block; width:150px;">Monto Total Cobrado:</div> S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>

      </div>  


      
          <div class="col-md-12">
          <h5 v-if="cajero>0"><b><div style="display:inline-block; width:150px;">Cajero:</div> @{{nombrecajero}} </b></h5>
          <h5 v-if="persona.length>0"><b><div style="display:inline-block; width:150px;">Cliente:</div> @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
          </div>


          

    <!-- /.box-header -->
    <div class="box-body table-responsive"> 

     

      <table class="table table-hover table-bordered table-dark table-condensed table-striped" id="tablaimp">
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
         <span class="label label-primary" v-if="recibo.estado=='2' && recibo.estadodetalle=='1'">Pagado No Procesado</span>
         <span class="label label-success" v-if="recibo.estado=='2'  && recibo.estadodetalle=='2'">Pagado Procesado</span>

         <span class="label label-danger" v-if="recibo.estado=='3'">Extornado</span>
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
      <div style="padding-top: 0cm;padding-left: 0cm; padding-right: 0cm;">

        <div id="titulo1" style="width:100%;">

          <div style="width:200px;position: absolute; font-size: 8px; float: left; text-align: left;">
            <b>UNIVERSIDAD NACIONAL SANTIAGO ANTÚNEZ DE MAYOLO<b> -
            UNIDAD DE TESORERÍA
          </div>
          <div style="width:50px; position: absolute; font-size: 8px; float: right; right: 50px; top:0mm!important;" class="logorep">
            <img src="{{ asset('/img/unasam.png')}}" class="img img-responsive">
          </div>
            <h3 class="box-title" style="padding-top:10px;font-size: 12px; text-align: center; font-weight: bold; width: 100%;    line-height: 2;"> 
              <center>REPORTE DETALLADO DE RECIBOS EMITIDOS</center>
            </h3>
        </div>


        <div id="cabecera1" style="width:100%;">


          <div class="width:100%;">
            <h5 style="font-size:11px;" v-if="local>0"><b><div style="display:inline-block; width:3cm;">Local:</div> @{{nombrelocal}} </b></h5>
            <h5 style="font-size:11px;" v-if="local>0 && entidad>0"><b><div style="display:inline-block; width:3cm;">Entidad:</div> @{{nombreentidad}}</b></h5>
          </div>
      
          <div class="width:100%;">
            <h5 style="font-size:11px;" v-if="categoria>0"><b><div style="display:inline-block; width:3cm;">Categoria:</div> @{{nombrecategoria}} </b></h5>
            <h5 style="font-size:11px;" v-if="categoria>0 && rubro>0"><b><div style="display:inline-block; width:3cm;">Rubro:</div> @{{nombrerubro}}</b></h5>
            <h5 style="font-size:11px;" v-if="categoria>0 && rubro>0 && precio>0"><b><div style="display:inline-block; width:3cm;">Concepto de Pago:</div> @{{nombreprecio}}</b></h5>
          </div>

          
        
          <div style="width:45%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="cbufec==0"><b><div style="display:inline-block; width:3cm;">Reporte Diario:</div> @{{fecha0 | fecha}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==1"><b><div style="display:inline-block; width:3cm;">Reporte Mensual:</div> @{{mes | mescotejar}}  de @{{anio}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==2"><b><div style="display:inline-block; width:3cm;">Reporte del Año:</div> @{{anio}}</b></h5>
            <h5 style="font-size:11px;" v-if="cbufec==3"><b>Reporte Desde: @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
              </div>
        
              <div style="width:45%; display:inline-block;">
                <h5 style="font-size:11px;" v-if="tipo==0"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Todos (Procesados y No Procesados)</b></h5>
                <h5 style="font-size:11px;" v-if="tipo==1"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Solo No Procesados</b></h5>
                <h5 style="font-size:11px;" v-if="tipo==2"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Solo Procesados</b></h5>  
              </div>  
              
              <div style="width:100%; display:inline-block;">
              <h5 style="font-size:11px;"><b><div style="display:inline-block; width:3cm;">Monto Total Cobrado:</div> S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>

              </div>  

                

        
       
        
                  <div style="width:100%;display:inline-block;">
                  <h5 style="font-size:11px;" v-if="cajero>0"><b><div style="display:inline-block; width:3cm;">Cajero:</div> @{{nombrecajero}} </b></h5>
                  <h5 style="font-size:11px;" v-if="persona.length>0"><b><div style="display:inline-block; width:3cm;">Cliente:</div> @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
                  </div>
   
                  
        </div>



        <div class="box-body table-responsive" style="width:100%;">
          <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
            <tbody><tr>

              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 3%;">#</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Código de Recibo</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Categoría</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Rubro</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 8%;">Concepto de Pago</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Entidad</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Costo Unitario (S/.)</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 5%;">Cantidad</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Costo Total (S/.)</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Persona</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Fecha Pagado</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 7%;">Fecha Procesado</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 9%;">Cajero</th>
              <th style="font-size:10px;border:1px solid #000000;padding: 5px; width: 5%;">Estado</th>

            </tr>
            <tr v-for="recibo, key in recibosimp">
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{key+pagination.from}}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.codigo }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.categoria }}</td>
   
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.rubro }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.concepto }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.entidad }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px; "><label style="float:right;">@{{ parseFloat(recibo.precioUnitario).toFixed(2) }}</label></td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.cantidad }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;"><label style="float:right;">@{{ parseFloat(recibo.precioTotal).toFixed(2) }}</label></td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.persona }}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;" v-if="recibo.estadodetalle=='1'"> <center>----</center></td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;" v-if="recibo.estadodetalle=='2'">@{{ recibo.fecha | fecha}} @{{recibo.hora_pagada}}</td>
             <td style="font-size:10px;border:1px solid #000000; padding: 2px;">@{{ recibo.nomcajero }}</td>
   
             <td style="font-size:10px;border:1px solid #000000; padding: 2px; vertical-align: middle;">
               <center>
          <span  v-if="recibo.estado=='2' && recibo.estadodetalle=='1'">Pagado No Procesado</span>
         <span  v-if="recibo.estado=='2'  && recibo.estadodetalle=='2'">Pagado Procesado</span>
   
            <span  v-if="recibo.estado=='3'">Extornado</span>
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
            <center>REPORTE DETALLADO DE RECIBOS EMITIDOS</center>
          </h3>
      </div>


      <div id="cabecera2" style="width:100%;">


        <div class="width:100%;">
          <h5 style="font-size:11px;" v-if="local>0"><b><div style="display:inline-block; width:3cm;">Local:</div> @{{nombrelocal}} </b></h5>
          <h5 style="font-size:11px;" v-if="local>0 && entidad>0"><b><div style="display:inline-block; width:3cm;">Entidad:</div> @{{nombreentidad}}</b></h5>
        </div>
    
        <div class="width:100%;">
          <h5 style="font-size:11px;" v-if="categoria>0"><b><div style="display:inline-block; width:3cm;">Categoria:</div> @{{nombrecategoria}} </b></h5>
          <h5 style="font-size:11px;" v-if="categoria>0 && rubro>0"><b><div style="display:inline-block; width:3cm;">Rubro:</div> @{{nombrerubro}}</b></h5>
          <h5 style="font-size:11px;" v-if="categoria>0 && rubro>0 && precio>0"><b><div style="display:inline-block; width:3cm;">Concepto de Pago:</div> @{{nombreprecio}}</b></h5>
        </div>

        
      
        <div style="width:45%; display:inline-block;">
          <h5 style="font-size:11px;" v-if="cbufec==0"><b><div style="display:inline-block; width:3cm;">Reporte Diario:</div> @{{fecha0 | fecha}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==1"><b><div style="display:inline-block; width:3cm;">Reporte Mensual:</div> @{{mes | mescotejar}}  de @{{anio}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==2"><b><div style="display:inline-block; width:3cm;">Reporte del Año:</div> @{{anio}}</b></h5>
          <h5 style="font-size:11px;" v-if="cbufec==3"><b>Reporte Desde: @{{fechai | fecha}} Hasta: @{{fechaf | fecha}}</b></h5>
            </div>
      
            <div style="width:45%; display:inline-block;">
              <h5 style="font-size:11px;" v-if="tipo==0"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Todos (Pagados y Extornos)</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==1"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Solo Pagados</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==2"><b><div style="display:inline-block; width:3cm;">Tipo:</div> Solo Extornos</b></h5>  
            </div>  
            
            <div style="width:100%; display:inline-block;">
            <h5 style="font-size:11px;" v-if="tipo==0 | tipo==1"><b><div style="display:inline-block; width:3cm;">Monto Total Cobrado:</div> S/ @{{parseFloat(totalcobrado).toFixed(2)}}</b></h5>
              <h5 style="font-size:11px;" v-if="tipo==0 | tipo==2"><b><div style="display:inline-block; width:3cm;">Monto Total Extornos:</div> S/ @{{parseFloat(totalextornado).toFixed(2)}}</b></h5>
            </div>  
      
     
      
                <div style="width:100%;display:inline-block;">
                <h5 style="font-size:11px;" v-if="cajero>0"><b><div style="display:inline-block; width:3cm;">Cajero:</div> @{{nombrecajero}} </b></h5>
                <h5 style="font-size:11px;" v-if="persona.length>0"><b><div style="display:inline-block; width:3cm;">Cliente:</div> @{{persona}} DNI-RUC N° @{{dni_ruc}}</b></h5>
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
 