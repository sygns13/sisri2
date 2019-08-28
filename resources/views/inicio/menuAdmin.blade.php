

  {{--   @if(accesoUser([1,2,3]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Recibos</h3>

              <p>Emisión de Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
 			<i class="fa fa-credit-card"></i> 
            </div>
            <a href="recibos" id="recibosH" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->

        @if(accesoUser([1,2,3]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Recibos Emitidos</h3>

              <p>Listado de Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-newspaper-o"></i>
            </div>
		  <a href="recibosemitidos" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
		   </div>
        </div>
@endif



@if(accesoUser([1,2,4]))
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-purple" style="box-shadow: 0px 10px 30px 0px #8d8686;">
    <div class="inner">
      <h3 style="font-size: 30px">Procesar Recibos</h3>

      <p>Proceso de Recibos Emitidos</p>
    </div>
    <div class="icon" style="top: 7px;">
<i class="fa fa-cogs"></i> 
    </div>
    <a href="procesar" id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
  </div>
</div>

@endif


@if(accesoUser([1,2,4]))
<div class="col-lg-3 col-xs-6">
  <!-- small box -->
  <div class="small-box bg-Teal" style="box-shadow: 0px 10px 30px 0px #8d8686;">
    <div class="inner">
      <h3 style="font-size: 30px">Recibos Procesados</h3>

      <p>Listado de Recibos Procesados</p>
    </div>
    <div class="icon" style="top: 7px;">
<i class="fa fa-cogs"></i> 
    </div>
    <a href="recibosprocesados" id="recibosP" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
  </div>
</div>

@endif



@if(accesoUser([1]))

        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-yellow" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Usuarios</h3>

              <p>Gestión de Usuarios</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-fax"></i>
            </div>
			<a href="usuarios" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->

@if(accesoUser([1,2,5]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Reportes Generales</h3>

              <p>Ver Reportes </p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-file-pdf-o"></i>
            </div>
			<a href="reportesgenerales" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>
@endif

@if(accesoUser([1,2,5]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Reportes Específicos</h3>

              <p>Ver Reportes</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-print"></i>
            </div>
			<a href="reportedestallados" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif
        <!-- ./col -->
 

@if(accesoUser([1]))
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-Navy" style="box-shadow: 0px 10px 30px 0px #8d8686;">
            <div class="inner">
              <h3 style="font-size: 30px">Auditoría de Recibos</h3>

              <p>Auditar Recibos</p>
            </div>
            <div class="icon" style="top: 7px;">
              <i class="fa fa-search-plus"></i>
            </div>
			<a href="auditarrecibos" class="small-box-footer" style="height: 37px"><i class="fa fa-arrow-circle-right" style="font-size: 30px"></i></a>
          </div>
        </div>

@endif --}}