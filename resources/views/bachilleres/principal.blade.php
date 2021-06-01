<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Bachilleres</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <div class="col-sm-12">

            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'bachilleres/exportarExcel?busca='+buscar+'&tipo='+tipoGeneral" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>

     
      
            <a download="Bachilleres_Plantilla_Carga_Datos.xlsx" type="button" class="btn btn-warning" id="btnDescargarPlantilla" href="{{URL::to('plantillas/Bachilleres_Plantilla_Carga_Datos.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Plantilla de Carga de Datos"><i class="fa fa-file-text" aria-hidden="true" ></i> Descargar Plantilla Para Carga de Data</a>
          
            <button type="button" class="btn btn-primary" id="btncrearArea" @click.prevent="nuevaExportación()"><i class="fa fa-cloud-upload" aria-hidden="true" ></i> Realizar Nueva Importación de Data</button>

          </div>


            <div class="col-sm-12" style="padding-top:15px;">
          
              <a download="Instructivo_Carga_Data_Bachilleres.xlsx" type="button" class="btn btn-info" id="btnDescargarPlantilla" href="{{URL::to('instructivo/Instructivo_Carga_Data_Bachilleres.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Instructivo Para Importar Data"><i class="fa fa-search" aria-hidden="true" ></i> Ver Instructivo Para Carga de Data</a>


              <a type="button" class="btn btn-default" id="btnDescargarPlantilla" v-bind:href="'escuelas/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos de Escuelas Profesionales"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Escuelas Profesionales</a>


          </div>
      
                    
      
             


          </div>     
          </div>
      
</div>


<div class="box box-success" v-if="divNuevoImporte">
  <div class="box-header with-border" >
    <h3 class="box-title" id="tituloAgregarImporte">Importar Datos en Lote de Bachilleres - Formato EXCEL</h3>
  </div>

   <form v-on:submit.prevent="createImportacion">

    {{--  <form action="/" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" id="pruebaCreate">--}}
   <div class="box-body">




                  {{ csrf_field() }}
                  
                        <div class="col-sm-12" style="padding-left: 0px;">
                      <div class="form-group">

                        
                          <span class="pull-left label label-default" style="margin-right: 5px; font-size: 12px;">
                           {{--    {!! Form::file('formatoexcel',['id'=>'formatoexcel','accept'=>'.xls,.xlsx','required']) !!}  --}}  

                                <input v-if="uploadReady" name="archivo2" type="file" id="archivo" class="archivo form-control" required @change="getArchivo" 
        accept=".xls, .XLS, .xlsx, .XLSX "/>

                              </span>
                        </div>

                      </div>




  </div>

  <!-- /.box-body -->
  <div class="box-footer">
    <button type="submit" class="btn btn-info" id="btnGuardarImporte" >Guardar Datos</button>

     {{-- <button type="submit" class="btn btn-primary" id="guardar" style="margin-right: 15px;">Guardar</button>--}}

    <button type="reset" class="btn btn-warning" id="btnCancelImporte" @click="cancelFormImporteForm()">Cancelar</button>

    <button type="button" class="btn btn-default" id="btnCloseImporte" @click.prevent="cerrarFormImportacion()">Cerrar</button>

    <div v-show="divloaderNuevoImporte">
      
    
    <div class="sk-circle" >
      <div style="color:red;" class="sk-circle1 sk-child"></div>
      <div style="color:red;" class="sk-circle2 sk-child"></div>
      <div style="color:red;" class="sk-circle3 sk-child"></div>
      <div style="color:red;" class="sk-circle4 sk-child"></div>
      <div style="color:red;" class="sk-circle5 sk-child"></div>
      <div style="color:red;" class="sk-circle6 sk-child"></div>
      <div style="color:red;" class="sk-circle7 sk-child"></div>
      <div style="color:red;" class="sk-circle8 sk-child"></div>
      <div style="color:red;" class="sk-circle9 sk-child"></div>
      <div style="color:red;" class="sk-circle10 sk-child"></div>
      <div style="color:red;" class="sk-circle11 sk-child"></div>
      <div style="color:red;" class="sk-circle12 sk-child"></div>
    </div>
    <center>
    <h3 style="color:red;">Importando Datos del Archivo Excel, espere por favor y no ejecute ninguna acción hasta que el proceso haya finalizado</h3></center>
    </div>

  </div>
  <!-- /.box-footer -->

</form>

</div>





      
 <div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo bachiller Matriculado de Pregrado
    </h3>
  </div>
  @include('bachilleres.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Bachiller: @{{ fillbachilleres.nombres }} @{{ fillbachilleres.apellidopat }} @{{ fillbachilleres.apellidomat }}


    </h3>
  </div>

  @include('bachilleres.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Bachilleres</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 16%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 15%;">Facultad</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 18%;">Escuela Profesional</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 11%;">Denominación del Grado</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Fecha de Egreso</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Fecha de Emisión</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="bachiller, key in graduados">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ bachiller.apellidopat }} @{{ bachiller.apellidomat }}, @{{ bachiller.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.facultad }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.escuela }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.nombreGrado }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.fechaEgreso | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ bachiller.fechaEmision | pasfechaVista }}</td>

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(bachiller)" data-placement="top" data-toggle="tooltip" title="Editar Bachiller"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(bachiller)" data-placement="top" data-toggle="tooltip" title="Borrar Bachiller"><i class="fa fa-trash"></i></a>
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
