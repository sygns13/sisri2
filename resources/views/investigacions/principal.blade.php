<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Investigaciones</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">



            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button>

          </div>     
          </div>
      
</div>
      
 <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Investigación
    </h3>
  </div>
  @include('investigacions.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Registro de Investigación: @{{ fillinvestigacion.titulo }}


    </h3>
  </div>

  @include('investigacions.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Investigaciones</h3>
      
          <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 300px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Buscar" v-model="buscar" @keyup.enter="buscarBtn()">
      
              <div class="input-group-btn">
                <button type="submit" class="btn btn-default" @click.prevent="buscarBtn()"><i class="fa fa-search"></i></button>
              </div>
      
      
            </div>
          </div>
        </div>
        <!-- /.box-header  table-bordered table-dark table-condensed table-striped -->
        <div class="box-body table-responsive">
          <table class="table table-hover " >
            <tbody><tr>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Facultad</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Escuela</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 250px;">Título de Investigación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 250px;">Autores</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Descripción</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Publicaciones</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Archivo</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 200px;">Resolución de Aprobación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Clasificación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 150px;">Línea de Investigación</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Tipo de Financiamiento</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Presupuesto Asignado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 100px;">Presupuesto Ejecutado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Fecha de Inicio</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Fecha de Término</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Horas Dedicadas</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Patentado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Estado</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 80px;">Avance</th>
              <th style="font-size: 13px;border:1px solid #ddd;padding: 5px; width: 300px;">Gestión de Investigacines</th>
            </tr>
            <tr v-for="investigación, key in investigacions">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ investigación.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.escuela }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.titulo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">Autores</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.descripcion }} </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">Publicaciones</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"><a v-bind:href="'investigacion/'+investigación.rutadocumento" v-bind:download="investigación.archivonombre">@{{ investigación.archivonombre }}</a>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.resolucionAprobacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.clasificacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.lineainvestigacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.financiamiento }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.presupuestoAsignado }} </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.presupuestoEjecutado }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.fechaInicio }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.fechaTermino }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.horas }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.patentado }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ investigación.estado }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;width: 300px;">@{{ investigación.avance }}</td>
  
                
      
          {{--     
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <center><span v-if="investigación.estado=='1'">---------</span></center>
              <center>
               <span class="label label-success" v-if="investigación.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="investigación.estado=='0'">Finalizado</span>
              </center>
              </td> --}}

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(investigación)" data-placement="top" data-toggle="tooltip" title="Editar Investigación"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(investigación)" data-placement="top" data-toggle="tooltip" title="Borrar Investigación"><i class="fa fa-trash"></i></a>
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
