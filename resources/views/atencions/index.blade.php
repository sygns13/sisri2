@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
	Gestión de Atenciones

	@if(intval($programassalud->tipo)==1)
	del Programa de Salud {{$programassalud->nombre}}
	@elseif(intval($programassalud->tipo)==2)
	de la Campaña de Salud {{$programassalud->nombre}}
	@endif
@endsection

<style type="text/css">         
          
#modaltamanio{
  width: 70% !important;
}

.swal2-popup{
	font-size: 1.175em !important;
}

</style>
@section('main-content')
	<div class="container-fluid spark-screen" id="contenidoItem">



		<div class="row">

@include('vendor.adminlte.layouts.partials.loaders')

			@if(accesoUser([1,2]))

<template v-if="divprincipal" id="divprincipal">
	 @include('atencions.principal')
</template>
			@endif


		</div>
	</div>
@endsection
