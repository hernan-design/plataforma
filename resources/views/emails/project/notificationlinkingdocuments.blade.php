@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		El empresario {{ $_businessman }} cargó los documentos de vinculación, valida la información en el siguiente botón.

		@include('emails.calltoaction', ['label' => 'Validar', 'action' => $_url_admin_institution, 'color' => $_inst_color])
	</p>
@stop
