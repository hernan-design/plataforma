@extends('emails.layout')

@section('content')
	<p>
		El día {{ date('d') }} de {{ $_month_current }} el emprendedor {{ $_buyer }} revisó los entregables del servicio {{ $_product }},
		por el valor de {{ number_format($_value_product, 2) }}, conforme a lo establecido en la guía de facturación usted recibirá en el mes de {{ $_name_month }}
		la respuesta del resultado de revisión de entregables efectuados por ALDEA de iNNpulsa Colombia.
	</p>
	<p>
		Cordialmente

		Equipo ALDEA
	</p>
@stop

