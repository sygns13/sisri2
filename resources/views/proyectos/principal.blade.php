<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Proyectos y Campañas Itinerantes</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">


            <template v-if="contse!='0'">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>

            {{-- <button type="button" class="btn btn-success" id="btnDescargarPlantilla" @click.prevent="descargarPlantilla()"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Plantilla</button>
 --}}

 <a type="button" class="btn btn-success" id="btnDescargarPlantilla" v-bind:href="'proyectos/exportarExcel?busca='+buscar+'&semestre_id='+semestre_id" data-placement="top" data-toggle="tooltip" title="Descargar Base de Datos Según el Filtro de Semestre y Búsqueda Empleado"><i class="fa fa-file-excel-o" aria-hidden="true" ></i> Descargar Base de Datos</a>


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
    <h3 class="box-title" id="tituloAgregar">Nuevo proyecto o Campaña Itinerante
    </h3>
  </div>
  @include('proyectos.formulario')  
</div>


<div class="box box-warning" v-if="divEdit">
  <div class="box-header with-border" style="border: 1px solid #f39c12; background-color: #f39c12; color: white;">
    <h3 class="box-title" id="tituloAgregar">Editar  proyecto o Campaña Itinerante: @{{ fillproyectos.nombre }} 


    </h3>
  </div>

  @include('proyectos.editar')  

</div>


      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;" v-if="semestre_id!='0'">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
        <h3 class="box-title">Listado de Proyectos y Campañas Itinerantes registrados en el Semestre: @{{semestreNombre}}</h3>
      
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
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Nombre</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Tipo</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 11%;">Descripción</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha de Inicio</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 7%;">Fecha de Término</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Lugar</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 10%;">Jefe de Proyecto</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 9%;">Fuente de Financiamiento</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Presupuesto</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Cantidad de Beneficiarios</th>
              <th style="font-size: 11px;border:1px solid #ddd;padding: 5px; width: 8%;">Gestión</th>
            </tr>
            <tr v-for="proyecto, key in proyectos">
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;"> @{{ proyecto.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
                <center>
                  <span  v-if="parseInt(proyecto.tipo)==1">Proyecto</span>
                  <span  v-if="parseInt(proyecto.tipo)==2">Campaña Itinerante</span>
                </center>
              </td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.descripcion }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.fechainicio | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.fechafinal | pasfechaVista }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.lugar }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.jefeproyecto }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.fuentefinanciamiento }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.presupuesto | mostrarNumero }}</td>
              <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">@{{ proyecto.cantidadbeneficiarios }}</td>

             <td style="border:1px solid #ddd;font-size: 11px; padding: 5px;">
      <center>      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(proyecto)" data-placement="top" data-toggle="tooltip" title="Editar registro"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(proyecto)" data-placement="top" data-toggle="tooltip" title="Borrar registro"><i class="fa fa-trash"></i></a>
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
