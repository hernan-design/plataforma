@extends('emails.layout')

@section('content')
	<h1>{!! transtp('marketplace.purchase.mail.titleMailConfirm') !!}<h1>
	<h3 class="clean-header sky-blue-text">Apreciado Proveedor,</h3>
	<p style="text-align: justify">
		Para la Corporación Ruta N es un gusto informarle sobre su selección, por parte de uno de nuestros beneficiarios,
		para la prestación del servicio: <b>{{ $_category_producto }}</b>
	</p>
	<br><br>
	<img src="{{{ $_image_product }}}" alt="" style=" width: 70px; height: 70px;"/>
	<h4 class="clean-header sky-blue-text">{{{ $_name_product }}}</h4>
	<div>
		<h3 class="clean-header sky-blue-text">Resumen Del Comprador:</h3>
		<p style="text-align: justify">
			Los datos asociados al emprendedor/empresario son:
		</p>
		<ul>
			<li><span class="dark-text text-lg"><b>Nombre del proyecto: </b></span> {{ $_name_entity_user_action }}</li>
			<br>
			{{--  Valdiación si la entidad es tipo empresa.  --}}
			@if ($_type_entity == 61)
				<li><span class="dark-text text-lg"><b>Identificación del proyecto: </span></b> {{ $_identify_entity }}</li>
				<br>
			@endif

			<li><span class="dark-text text-lg"><b>Correo electrónico: </b></span> {{{ $_email_purchaser }}}</li>
			<br>
			<li><span class="dark-text text-lg"><b>Número de contacto: </b></span> {{{ $_phones_purchaser }}}</li>
		</ul>
	</div>
@stop
