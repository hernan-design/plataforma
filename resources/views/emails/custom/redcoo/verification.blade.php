@extends('emails.layout')

@section('content')
	<p>Verificar tu cuenta es fácil - simplemente inicia sesión y haz clic en el siguiente botón.</p>
	@include('emails.calltoaction', ['label' => 'Verificar cuenta', 'action' => $_url_action, 'color' => $_inst_color])
@stop
