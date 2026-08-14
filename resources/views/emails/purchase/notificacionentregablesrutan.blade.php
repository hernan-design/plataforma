@extends('emails.layout')

@section('content')

	<p>
        <span># Compra {{ $_id_sale }}</span>
        <br>
        <br>
		El día {{ date('d') }} de {{ date('m') }} del {{ date('Y') }} el vendedor {{ $_name_seller }} envío los entregables para su revisión.
	</p>

	<p>Puedes ingresar al marketplace haciendo click en el siguiente botón: </p>
	@include('emails.calltoaction', ['label' => 'Ir al marketplace', 'action' => "$_inst_url$_go_marketplace", 'color' => $_inst_color])

@stop

