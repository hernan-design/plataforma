@extends('emails.layout')

@section('content')
	<p style="text-align:justify">
		<span> {!! $comment !!} </span>
	</p>

	@include('emails.calltoaction', [
									'label' => 'Ingresar',
									'action' => $_inst_url.'/convocatoria/pfc-test-de-zarit-30',
									'color' => $_inst_color
								])

@stop
