<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Personal Administrativo</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <div class="col-sm-12">
              @if($activoModulo == 1 || $activoModulo == 3 || accesoUser([1]))
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>
            @endif

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'administrativos/exportarExcel?busca='+buscar" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>
      
            <a download="Administrativos_Plantilla_Carga_Datos.xlsx" type="button" class="btn btn-warning" id="btnDescargarPlantilla" href="{{URL::to('plantillas/Administrativos_Plantilla_Carga_Datos.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Plantilla de Carga de Datos"><i class="fa fa-file-text" aria-hidden="true" ></i> Descargar Plantilla Para Carga de Data</a>
            @if($activoModulo == 1 || $activoModulo == 3 || accesoUser([1]))
            <button type="button" class="btn btn-primary" id="btncrearArea" @click.prevent="nuevaExportación()"><i class="fa fa-cloud-upload" aria-hidden="true" ></i> Realizar Nueva Importación de Data</button>
@endif
          </div>

          <div class="col-sm-12" style="padding-top:15px;">

          <a download="Instructivo_Carga_Data_Administrativos.xlsx" type="button" class="btn btn-info" id="btnDescargarPlantilla" href="{{URL::to('instructivo/Instructivo_Carga_Data_Administrativos.xlsx')}}" data-placement="top" data-toggle="tooltip" title="Descargar Instructivo Para Importar Data"><i class="fa fa-search" aria-hidden="true" ></i> Ver Instructivo Para Carga de Data</a>
          
          <a type="button" class="btn btn-default" id="btnDescargarPlantilla" v-bind:href="'locales/exportarExcel?busca='" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos de Locales"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Locales</a>

        </div>


        @if($activoModulo == 0 && !accesoUser([1]))
        <div class="col-sm-12" style="padding-top:15px;">
          <h4 style="color:red;">El módulo está cerrado para realizar registros, en caso de requerir su habilitación, coordinar con el administrador</h4>
        </div>
        @endif

        @if($activoModulo == 1 && !accesoUser([1]))
        <div class="col-sm-12" style="padding-top:15px;">
          <h4 style="color:blue;">Actualmente el módulo está activo para permitir el registro</h4>
        </div>
        @endif

        @if($activoModulo == 2 && !accesoUser([1]))
        <div class="col-sm-12" style="padding-top:15px;">
          <h4 style="color:red;">La fecha de programacion aun no inicia. El módulo está programado para permitir el registro desde el {{pasFechaVista($submodulo->fechaini)}} hasta el {{pasFechaVista($submodulo->fechafin)}}</h4>
        </div>
        @endif

        @if($activoModulo == 3 && !accesoUser([1]))
        <div class="col-sm-12" style="padding-top:15px;">
          <h4 style="color:blue;">El módulo está activo para permitir el registro según la programación desde el {{pasFechaVista($submodulo->fechaini)}} hasta el {{pasFechaVista($submodulo->fechafin)}}</h4>
        </div>
        @endif

        @if($activoModulo == 4 && !accesoUser([1]))
        <div class="col-sm-12" style="padding-top:15px;">
          <h4 style="color:red;">La fecha de programacion ha finalizado. El módulo estaba programado para permitir el registro desde el {{pasFechaVista($submodulo->fechaini)}} hasta el {{pasFechaVista($submodulo->fechafin)}}. Si requiere una prórroga de ampliación puede solicitarlo picando click en el siguiente botón</h4>

          <button type="button" class="btn btn-danger" id="btnCrear" @click.prevent="nuevaProrroga({{$submodulo->id}})"><i class="fa fa-calendar-plus-o" aria-hidden="true" ></i> Solicitar Prórroga</button>


        </div>

        @endif
                    
      
             


          </div>     
          </div>
      
</div>












<div class="box box-success" v-if="divNuevoImporte">
  <div class="box-header with-border" >
    <h3 class="box-title" id="tituloAgregarImporte">Importar Datos en Lote Administrativos - Formato EXCEL</h3>
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
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Personal Administrativo
    </h3>
  </div>
  @include('administrativos.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Personal Administrativo: @{{ filladministrativos.nombres }} @{{ filladministrativos.apellidopat }} @{{ filladministrativos.apellidomat }}


    </h3>
  </div>

  @include('administrativos.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de administrativos</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 14%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Local</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 14%;">Dependencia</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Cargo</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Fecha de Ingreso</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Fecha de Salida</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Estado de Contrato</th>
              @if($activoModulo == 1 || $activoModulo == 3 || accesoUser([1]))
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
              @endif
            </tr>
            <tr v-for="administrativo, key in administrativos">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ administrativo.apellidopat }} @{{ administrativo.apellidomat }}, @{{ administrativo.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.local }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.dependencia }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.cargo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.fechaIngreso | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ administrativo.fechaSalida | pasfechaVista }}
                <center><span v-if="administrativo.estado=='1'">---------</span></center>
              </td>
              
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
              <center>
               <span class="label label-success" v-if="administrativo.estado=='1'">Activo</span>
               <span class="label label-warning" v-if="administrativo.estado=='0'">Finalizado</span>
              </center>
              </td>
              @if($activoModulo == 1 || $activoModulo == 3 || accesoUser([1]))
             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(administrativo)" data-placement="top" data-toggle="tooltip" title="Editar Administrativo"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(administrativo)" data-placement="top" data-toggle="tooltip" title="Borrar Administrativo"><i class="fa fa-trash"></i></a>
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


      <form method="post" v-on:submit.prevent="solicitarProrroga()">
        <div class="modal bs-example-modal-lg" id="modalProrroga" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg" role="document" id="modaltamanioP">
            <div class="modal-content" style="border: 1px solid #3c8dbc;">
              <div class="modal-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="font-size: 35px;">&times;</span></button>
                <h4 class="modal-title" id="desEditarTituloProrroga" style="font-weight: bold;text-decoration: underline;">SOLICITAR PRORROGA DE AMPLIACIÓN</h4>
      
              </div> 
              <div class="modal-body">
                <input type="hidden" id="idSubmodulo" value="0">
      
                <div class="row">
      
                  <div class="box" id="o" style="border:0px; box-shadow:none;" >
                    <div class="box-header with-border">
                      <h3 class="box-title" id="boxTituloProrroga">Submódulo:</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
      
                    <div class="box-body">
      
                      <div class="form-group">
                        <label for="txtmotivoProrroga" class="col-sm-2 control-label">Motivo:*</label>
      
                        <div class="col-sm-8">
                          <textarea type="text" class="form-control" id="txtmotivoProrroga" name="txtmotivoProrroga" placeholder="Indique el Motivo de Solicitud de Prórroga de Ampliación" maxlength="5000" autofocus v-model="motivoProrroga" ></textarea>
                        </div>
                      </div>
                    </div>
      
       
                    <div class="col-md-12" style="padding-top: 15px;">
                      <h4 style="color:red;">Nota: Solo se puede solicitar un máximo de 05 veces una prórroga ampliación de plazo para realizar el registro de datos por cada programación realizada por el administrador. En caso de no haber cumplido con el registro luego de haber recibido 05 prórrogas, por favor cominicarse con el administrador del sistema o con la OGTISE</h4>

      
                    </div>
      
      
      
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btnSaveProrroga"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
      
                  <button type="button" id="btnCancelProrroga" class="btn btn-default" data-dismiss="modal"><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar</button>
      
                  <div class="sk-circle" v-show="divloaderProrroga">
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
      </form>