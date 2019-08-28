@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
	Emisión de Recibos
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

			@if(accesoUser([1,2,3]))

<template v-if="divprincipal" id="divprincipal">
	@include('recibo.principal')
</template>
			@endif


		</div>
	</div>
@endsection
