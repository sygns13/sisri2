<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Personal Administrativo por Locación de Servicios</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <div class="col-sm-12">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>



     
          <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'locacionservicios/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>


          <a download="Locadores_Plantilla_Carga_Datos.xlsx" type="button" class="btn btn-warning" id="btnDescargarPlantilla" href="{{URL::to('plantillas/Locadores_Plantilla_Carga_Datos.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Plantilla de Carga de Datos"><i class="fa fa-file-text" aria-hidden="true" ></i> Descargar Plantilla Para Carga de Data</a>
          
            <button type="button" class="btn btn-primary" id="btncrearArea" @click.prevent="nuevaExportación()"><i class="fa fa-cloud-upload" aria-hidden="true" ></i> Realizar Nueva Importación de Data</button>


        </div>  



        <div class="col-sm-12" style="padding-top:15px;">

          <a download="Instructivo_Carga_Data_Locadores.xlsx" type="button" class="btn btn-info" id="btnDescargarPlantilla" href="{{URL::to('instructivo/Instructivo_Carga_Data_Locadores.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Instructivo Para Importar Data"><i class="fa fa-search" aria-hidden="true" ></i> Ver Instructivo Para Carga de Data</a>
          
          <a type="button" class="btn btn-default" id="btnDescargarPlantilla" v-bind:href="'locales/exportarExcel?busca='" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos de Locales"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Locales</a>

        </div>
      
                    
      
             


          </div>     
          </div>
      
</div>














<div class="box box-success" v-if="divNuevoImporte">
  <div class="box-header with-border" >
    <h3 class="box-title" id="tituloAgregarImporte">Importar Datos en Lote Locadores de Servicios - Formato EXCEL</h3>
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
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Personal Administrativo por Locación de Servicios
    </h3>
  </div>
  @include('adminlocacion.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Personal Administrativo por Locación de Servicios: @{{ filladminlocaservs.nombres }} @{{ filladminlocaservs.apellidopat }} @{{ filladminlocaservs.apellidomat }}


    </h3>
  </div>

  @include('adminlocacion.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de administrativos por Locación de Servicios</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 13%;">Local</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 13%;">Dependencia</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Condición Laboral</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Cargo</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha de Ingreso</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha de Inicio de Contrato</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha Final de Contrato</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="adminlocaserv, key in adminlocaservs">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ adminlocaserv.apellidopat }} @{{ adminlocaserv.apellidomat }}, @{{ adminlocaserv.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.local }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.dependencia }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.condicionLaboral }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.cargo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.fechaIngreso | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.fechaInicioContrato | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ adminlocaserv.fechaFinContrato | pasfechaVista }}</td>
              

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(adminlocaserv)" data-placement="top" data-toggle="tooltip" title="Editar Administrativo por Locación de Servicios"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(adminlocaserv)" data-placement="top" data-toggle="tooltip" title="Borrar por Locación de Servicios"><i class="fa fa-trash"></i></a>
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
