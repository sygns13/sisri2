<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de la Condición Económica de los Estudiantes</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <template v-if="contse!='0'">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button> --}}

            <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'condicion/exportarExcel?busca='+buscar+'&semestre_id='+semestre_id" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>

            <label for="cbusemestre" class="col-sm-3 control-label" style="width: auto;">Semestre de Matrícula:*</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="cbusemestre" name="cbusemestre" v-model="semestre_id" @change="cambiarSemestre">
                          <option value="0" disabled>Seleccione un Semestre...</option>
                          @foreach ($semestres as $dato)
                          @if($dato->estado=="1")
                          <option value="{{$dato->id}}" selected>{{$dato->nombre}}</option>                        
                          @else
                          <option value="{{$dato->id}}">{{$dato->nombre}}</option>    
                          @endif
                          @endforeach
                        </select>
                      </div>
                      @foreach ($semestres as $dato)
                      <input type="hidden" id="txtseme{{$dato->id}}" value="{{$dato->nombre}}">
                      @endforeach
            </template>

            <template v-if="contse=='0'">
              <h3 style="color:red;">No cuenta con semestres configurados en el sistema, primero configure uno para que pueda ingresar registros</h3>
                <a class="btn btn-danger" id="btnLink" href="{{URL::to('semestres')}}"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Configurar un Semestre Académico</a>
              </template>

     
      
      
                    
      
             


          </div>     
          </div>
      
</div>
      
<div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Registro de Condición Económica del Estudiante
    </h3>
  </div>
  @include('condicioneconomicaestudiante.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar Registro de Condición Económica del Estudiante: @{{ fillalumnos.nombres }} @{{ fillalumnos.apellidopat }} @{{ fillalumnos.apellidomat }}


    </h3>
  </div>

  @include('condicioneconomicaestudiante.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;" v-if="semestre_id!='0'">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Registros de la Condición Económica del Estudiante del Semestre: @{{semestreNombre}}</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 12%;">Apellidos y Nombres</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 5%;">DNI</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Código</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">Nro de Hermanos(as)</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">Nro de Hermanos(as) que estudian en la UNASAM</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Puesto Laboral que desempeña el Padre u Apoderado</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Puesto Laboral que desempeña la Madre u Apoderado</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 6%;">Ingreso Económico mensual Familiar</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Condición de la Vivienda</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 4%;">El estudiante Cuenta con seguro de salud</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 11%;">Nombre del seguro de salud</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 5%;">El estudiante se encuentra laborando actualmente</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="alumno, key in alumnos">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ alumno.apellidopat }} @{{ alumno.apellidomat }}, @{{ alumno.nombres }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.doc }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.codigo }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.numhermanos }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.numhermanosunasam }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.puestopadre }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.puestomadre }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.ingresomensualfamiliar | mostrarNumero }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.condicionviivienda }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <span slot="header" class="badge badge-success" v-if="alumno.tieneseguro=='1'">Si</span>
                <span slot="header" class="badge badge-warning" v-if="alumno.tieneseguro=='0'">No</span>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ alumno.nombreseguro }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">              
                <span slot="header" class="badge badge-success" v-if="alumno.estalaborando=='1'">Si</span>
                <span slot="header" class="badge badge-warning" v-if="alumno.estalaborando=='0'">No</span>

              </td>
             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(alumno)" data-placement="top" data-toggle="tooltip" title="Editar Registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(alumno)" data-placement="top" data-toggle="tooltip" title="Borrar Registro"><i class="fa fa-trash"></i></a>
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
