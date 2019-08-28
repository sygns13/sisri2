<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Reporte de Locales</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-success" id="btncrearReporte" @click.prevent="imprimirReporte()"><i class="fa fa-print" aria-hidden="true" ></i> Imprimir Reporte</button>
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
      

      
      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Locales</h3>
      
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
              <th style="border:1px solid #ddd;padding: 5px; width: 40%;">Nombre</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 45%;">Dirección</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
  
            </tr>
            <tr v-for="local, key in locals">
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ local.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px;">@{{ local.direccion }}</td>
              <td style="border:1px solid #ddd;font-size: 14px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="local.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="local.estado=='0'">Inactivo</span>
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
    
    <div style="width: 100%; max-width: 21cm; height: auto; background-color: white; border: 1px solid white; margin-bottom:1cm!important;" id="divImp">
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
            <center>REPORTE DE LOCALES</center>
          </h3>
      </div>


      <div id="cabecera1" style="width:100%;">
        
        <div style="width:100%; display:inline-block;">
          <h5 style="font-size:11px;" v-if="buscar.length>0"><b>Criterio de Búsqueda: @{{buscar}}</b></h5>

            </div>
      </div>


      <div class="box-body table-responsive" style="width:100%;">
        <table class="table table-hover table-bordered table-dark table-condensed table-striped" >
          <tbody><tr>

              <th style="font-size:12px;border:1px solid #000000;padding: 5px;width: 5%;">#</th>
              <th style="font-size:12px;border:1px solid #000000;padding: 5px;width: 40%;">Nombre</th>
              <th style="font-size:12px;border:1px solid #000000;padding: 5px;width: 45%;">Dirección</th>
              <th style="font-size:12px;border:1px solid #000000;padding: 5px;width: 10%;">Estado</th>

          </tr>
          <tr v-for="data, key in dataimp">


        <td style="font-size:12px;border:1px solid #000000; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="font-size:12px;border:1px solid #000000; padding: 5px;">@{{ data.nombre }}</td>
              <td style="font-size:12px;border:1px solid #000000; padding: 5px;">@{{ data.direccion }}</td>
              <td style="font-size:12px;border:1px solid #000000; padding: 5px; vertical-align: middle;">
                  <center>
               <span  v-if="data.estado=='1'">Activo</span>
               <span  v-if="data.estado=='0'">Inactivo</span>
              </center>
             </td>
 

         </tr>
    
       </tbody></table>

      </div>


      

    </div>
    </div>
</div>
