<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">
              @if(intval($programassalud->tipo)==1)
              Gestión de Beneficiarios del Programa de Salud "{{$programassalud->nombre}}"
              @elseif(intval($programassalud->tipo)==2)
              Gestión de Beneficiarios, Participantes y Voluntarios de la Campaña de Salud "{{$programassalud->nombre}}"
              @endif
          </h3>
          @if(intval($programassalud->tipo)==1)
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('programassalud')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver a Programas de Salud</a>
          @elseif(intval($programassalud->tipo)==2)
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('campadbu')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
            Volver a Campañas de Salud</a>
          @endif
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">



            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

           {{--  <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

           <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'/beneficiariosR/exportarExcel?busca='+buscar+'&programasalud='+programasalud" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>

     
      
      
                    
      
             


          </div>     
          </div>
      
</div>
      
 <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro
    </h3>
  </div>
 @include('beneficiarios.formulario') 
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Registro de: @{{ fillbeneficiario.nombres }} @{{ fillbeneficiario.apellidopat }} @{{ fillbeneficiario.apellidomat }}


    </h3>
  </div>

 @include('beneficiarios.editar')

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de 
            @if(intval($programassalud->tipo)==1)
            Beneficiarios del Programa de Salud "{{$programassalud->nombre}}"
            @elseif(intval($programassalud->tipo)==2)
            Beneficiarios, Participantes y Voluntarios de la Campaña de Salud "{{$programassalud->nombre}}"
            @endif
        </h3>
      
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

              @if(intval($programassalud->tipo)==1)
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 26%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 15%;">Tipo</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">fecha de Atención</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 29%;">Observaciones</th>


              @elseif(intval($programassalud->tipo)==2)
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">#</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 26%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 15%;">Tipo</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">fecha de Atención</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 29%;">Observaciones</th>
              @endif

              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="beneficiario, key in beneficiarios">
                @if(intval($programassalud->tipo)==1)

              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ beneficiario.apellidopat }} @{{ beneficiario.apellidomat }}, @{{ beneficiario.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <span v-if="parseInt(beneficiario.tipo)==1">Alumno</span>
                <span v-if="parseInt(beneficiario.tipo)==2">Docente</span>
                <span v-if="parseInt(beneficiario.tipo)==3">Administrativo</span>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.fechaatencion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.observaciones }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                  <center>      
                           <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(beneficiario)" data-placement="top" data-toggle="tooltip" title="Editar Beneficiario"><i class="fa fa-edit"></i></a>
                           <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(beneficiario)" data-placement="top" data-toggle="tooltip" title="Borrar Beneficiario"><i class="fa fa-trash"></i></a>
                  </center>
                         </td>

              @elseif(intval($programassalud->tipo)==2)

              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ beneficiario.apellidopat }} @{{ beneficiario.apellidomat }}, @{{ beneficiario.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <span v-if="parseInt(beneficiario.tipo)==1">Alumno</span>
                <span v-if="parseInt(beneficiario.tipo)==2">Docente</span>
                <span v-if="parseInt(beneficiario.tipo)==3">Administrativo</span>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.fechaatencion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ beneficiario.observaciones }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                  <center>      
                           <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(beneficiario)" data-placement="top" data-toggle="tooltip" title="Editar Beneficiario"><i class="fa fa-edit"></i></a>
                           <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(beneficiario)" data-placement="top" data-toggle="tooltip" title="Borrar Beneficiario"><i class="fa fa-trash"></i></a>
                  </center>
                         </td>
              @endif

             
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
