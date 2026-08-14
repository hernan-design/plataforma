@extends('emails.layout')

@section('content')

	<p style="text-align:center">
		{{{ transtp('mentoring.atachment.notification') }}}
	</p>

	@include('emails.calltoaction', ['label' => 'Ver adjunto', 'action' => "$url_discusion", 'color' => $_inst_color])
@stop
