@extends('emails.layout')

@section('content')
	<p style="text-align:justify">
		<span> Buenas tardes a continuación puede ingresar a desarrollar el programa.</span>

	</p>

  @include('emails.calltoaction', ['label' => 'Ingresar', 'action' => $_inst_url.'/aprende/cursos', 'color' => $_inst_color])

@stop
