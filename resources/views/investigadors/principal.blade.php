<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Docentes Investigadores</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

           {{--  <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

        
           <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'investigadores/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>
     
      
      
                    
      
             


          </div>     
          </div>
      
</div>
      
<div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Docente
    </h3>
  </div>
 @include('investigadors.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Docente: @{{ filldocente.nombres }} @{{ filldocente.apellidopat }} @{{ filldocente.apellidomat }}


    </h3>
  </div>

  @include('investigadors.editar')  

</div>



      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Docentes Investigadores</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 13%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Clasificación</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 14%;">Facultad</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 13%;">Escuela</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Género</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Fecha de Nacimiento</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 14%;">Observaciones</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="docente, key in docentes">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ docente.apellidopat }} @{{ docente.apellidomat }}, @{{ docente.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.clasificacion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                @{{ docente.escuela }}
                <template v-if="parseInt(docente.escuela_id)==0">No Adscrito a una Escuela Profesional</template>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.genero }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.fechanac }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ docente.observaciones }}</td>
             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(docente)" data-placement="top" data-toggle="tooltip" title="Editar Docente Investigador"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(docente)" data-placement="top" data-toggle="tooltip" title="Borrar Docente Investigador"><i class="fa fa-trash"></i></a>
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
