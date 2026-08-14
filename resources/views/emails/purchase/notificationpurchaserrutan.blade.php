@extends('emails.layout')

@section('content')
	<p>
		<h1>{!! transtp('marketplace.purchase.mail.infoPurchase') !!}<h1>
		<br>
		<a href="{{ $_url_product }}" target="_blank">
			<img src="{{{ $_image_product }}}" alt="" style=" width: 70px; height: 70px;"/>
		</a>
		<br>
		<h4 class="clean-header sky-blue-text">{{{ $_name_product }}}</h4>

		<h3 class="clean-header sky-blue-text">Tipo De Pago</h3>
		<span class="dark-text text-lg">{{{ $_payment }}}</span>

		<div>
			<h3 class="clean-header sky-blue-text">Resumen Del Vendedor:</h3>
			<p style="text-align: justify">
				Los datos asociados al emprendedor/empresario son:
			</p>
			<ul>
				<li><span class="dark-text text-lg"><b>Nombre del vendeodr: </b></span> {{ $_name_user_action }}</li>
				<br>
				<li><span class="dark-text text-lg"><b>Correo electrónico: </b></span> {{{ $_email_seller }}}</li>
				<br>
				<li><span class="dark-text text-lg"><b>Número de contacto: </b></span> {{{ $_phones_seller }}}</li>
			</ul>
		</div>
	</p>
@stop
