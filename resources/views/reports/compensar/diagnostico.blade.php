@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
	<div>
		<p> Estimado emprendedor, </p>
		<br>
		<p> 
			Para el Programa de Emprendimiento de Compensar es muy valioso el que hayas aceptado realizar el autodiagnóstico de perfil emprendedor, dado que demuestra el interés que tienes en alcanzar el sueño de ser empresario.
		</p>
		<br>
		<p>
			El presente resultado, te servirá de referencia para identificar aquellas competencias en las que puedes tener una oportunidad de mejora (en la gráfica se encuentran hacia el centro), para lo cual te invitamos a que desarrolles tu plan de acción de una manera ordenada y con actividades concretas.
		</p>
		<br>
		<p>
			Encontrarás también, aquellas fortalezas que debes seguir cultivando (en la gráfica se encuentran hacia el centro) y enriqueciendo.
		</p>
		<br>
		<p>
			Si tienes alguna duda o comentario, por favor escríbenos al correo <b> fomentoempresarial@compensar.com </b>
		</p>
		<br>
		<img src="{{ $graph }}" style="width: 710px; height: 300px; border: none">
		<br><br>
		<p>Programa de Emprendimiento</p>
		<p>Agencia de Empelo y Fomento Empresarial</p>
		<br><br>
		<p> Gracias. </p>
	</div>
@stop
