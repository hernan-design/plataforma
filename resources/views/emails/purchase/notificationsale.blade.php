@extends('emails.layout')

@section('content')
	<p>
		<h1>{!! transtp('marketplace.purchase.mail.titleMailConfirm') !!}<h1>
		<br>
		 	<img src="{{{ $_image_product }}}" alt="" style=" width: 70px; height: 70px;"/>
		<br>
		 	<h4 class="clean-header sky-blue-text">{{{ $_name_product }}}</h4>
		@if(isset($_product_unit) && $_product_unit > 0)
		<br>
			<span class="light-text text-md">Cantidad: </span>
			<span class="dark-text text-lg">{{{ $_product_unit }}}</span>
		@endif
		<br>
			<span class="dark-text text-lg">$ {{{ $_total_value_purchase }}}</span>
		<br>
		<h3 class="clean-header sky-blue-text">Pago</h3>
		<span class="dark-text text-lg">{{{ $_payment }}}</span>

		<h3 class="clean-header sky-blue-text">Envio</h3>
		<span class="dark-text text-lg">{{{ $_shipping }}}</span>

		<h3 class="clean-header sky-blue-text">Comprador</h3>
		<span class="dark-text text-lg">{{{ $_name_entity_user_action }}}</span>
		<br>
		<span class="dark-text text-lg">{{{ $_name_user_action }}}</span>
		<br>
		<span class="dark-text text-lg">{{{ $_email_purchaser }}}</span>
		<br>
		<span class="dark-text text-lg">{{{ $_phones_purchaser }}}</span>
	</p>
@stop
