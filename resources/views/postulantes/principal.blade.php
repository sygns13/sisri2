<div class="box box-primary panel-group">
        <div class="box-header with-border" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Gestión de Postulantes</h3>
          <a style="float: right;" type="button" class="btn btn-default" href="{{URL::to('home')}}"><i class="fa fa-reply-all" aria-hidden="true"></i> 
          Volver</a>
        </div>
      
      <div class="box-body" style="border: 1px solid #3c8dbc;">
          <div class="form-group form-primary">
            <button type="button" class="btn btn-primary" id="btnCrear" @click.prevent="nuevo()"><i class="fa fa-plus-square-o" aria-hidden="true" ></i> Nuevo Registro</button>
          </div>     
          </div>
      
</div>
      
<div class="box box-success" v-if="divNuevo">
  <div class="box-header with-border" style="border: 1px solid rgb(0, 166, 90); background-color: rgb(0, 166, 90); color: white;">
    <h3 class="box-title" id="tituloAgregar">Nuevo Postulante
    </h3>
  </div>
  @include('postulantes.formulario')  
</div>
      
      
      
      
      <div class="box box-primary" style="border: 1px solid #3c8dbc;">
        <div class="box-header" style="border: 1px solid #3c8dbc;background-color: #3c8dbc; color: white;">
          <h3 class="box-title">Listado de Postulantes</h3>
      
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
              <th style="border:1px solid #ddd;padding: 5px; width: 30%;">Apellidos y Nombres</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 30%;">DNI</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 40%;">Carrera 1° Opción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Carrera 2° Opción</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Modalidad de Admisión</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Estado</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Puntaje Obtenido</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 10%;">Carrera Ingreso</th>
              <th style="border:1px solid #ddd;padding: 5px; width: 15%;">Gestión</th>
            </tr>
            <tr v-for="modadmision, key in modadmisions">
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{key+pagination.from}}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ modadmision.nombre }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">@{{ modadmision.descripcion }}</td>
              <td style="border:1px solid #ddd;font-size: 13px; padding: 5px; vertical-align: middle;">
                  <center>
               <span class="label label-success" v-if="modadmision.activo=='1'">Activo</span>
               <span class="label label-warning" v-if="modadmision.activo=='0'">Inactivo</span>
              </center>
             </td>
             <td style="border:1px solid #ddd;font-size: 13px; padding: 5px;">
      <center>
               <a href="#" v-if="modadmision.activo=='1'" class="btn bg-navy btn-sm" v-on:click.prevent="baja(modadmision)" data-placement="top" data-toggle="tooltip" title="Desactivar Modalidad de Admisión"><i class="fa fa-arrow-circle-down"></i></a>
      
               <a href="#" v-if="modadmision.activo=='0'" class="btn btn-success btn-sm" v-on:click.prevent="alta(modadmision)" data-placement="top" data-toggle="tooltip" title="Activar Modalidad de Admisión"><i class="fa fa-check-circle"></i></a>
      
      
               <a href="#" class="btn btn-warning btn-sm" v-on:click.prevent="edit(modadmision)" data-placement="top" data-toggle="tooltip" title="Editar Modalidad de Admisión"><i class="fa fa-edit"></i></a>
               <a href="#" class="btn btn-danger btn-sm" v-on:click.prevent="borrar(modadmision)" data-placement="top" data-toggle="tooltip" title="Borrar Modalidad de Admisión"><i class="fa fa-trash"></i></a>
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
