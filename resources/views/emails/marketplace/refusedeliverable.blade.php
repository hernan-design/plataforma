@extends('emails.layout')

@section('content')
	<p>
		Una vez realizada la revisión a los entregables correspondientes al servicio {{ $_project }} por parte de {{ $_purchaser }}, nos permitimos informar que estos no cumplen con lo definido en el acuerdo de negociación, por lo cual es preciso que se ajuste lo siguiente:
	</p>
	<p>
		<strong>{{ $_comment }}</strong>
	</p>
	<p>
		Por favor realizar los ajustes sugeridos por el emprendedor, modificando la información en la plataforma en los tiempos establecidos por el equipo de iNNpulsa Colombia.
	</p>

	@include('emails.calltoaction', ['label' => 'Ajusta tus entregables aquí', 'action' => "$_url_action", 'color' => $_inst_color])
@stop

