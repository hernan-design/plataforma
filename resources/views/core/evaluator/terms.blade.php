@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')

	<p class="justify">Yo <strong>{{ $asignacion->nombre_jurado }}</strong> he   sido   invitado   por   parte   la UNIDAD DE GESTIÓN DE CRECIMIENTO EMPRESARIAL - INNPULSA COLOMBIA a ser parte de la conversación con expertos y evaluar los emprendimientos y empresas que hacen parte del Reto 2 del programa de ALDEA.</p>

	<p class="justify">En tal sentido he decidido participar voluntariamente como evaluador, para lo cual, afirmo conocer los criterios de evaluación de la convocatoria y los términos de referencia de la misma. Así mismo como evaluador me comprometo a:</p>
	<ol>
		<li>Mantener la confidencialidad de la información que me sea compartida para llevar a cabo la actividad de evaluación.</li>
		<li>Usar la información confidencial únicamente con el propósito de evaluar los proyectos que me sean asignados y de ninguna manera utilizarla en beneficio propio.</li>
		<li>Adoptar todas las medidas necesarias para asegurar la no divulgación de la información confidencial.</li>
		<li>Cumplir con la obligación de confidencialidad, de la misma forma y con el mismo cuidado con que se realiza la protección de la información confidencial propia.</li>
		<li>Apoyar  a  la  UNIDAD  ante  cualquier  reclamación  que  se  genere  por  el  concepto  de evaluación emitido.</li>
		<li>No  intervenir  directamente  o  por  interpuesta  persona  en  los  proyectos  evaluados respecto de los cuales hubiera emitido concepto.</li>
		<li>Dar estricto cumplimiento a las normas relacionadas con derechos de autor y propiedad intelectual e industrial, en relación con los proyectos evaluados.</li>
		<li>Manifestar cualquier posible conflicto de interés que se le genere respecto de cualquiera de las propuestas sometidas a su evaluación.</li>
	</ol>

	<br>
	<p class="justify">Fecha de Panel: {{ $asignacion->fecha_evaluacion_jurado }}</p>
	<p class="justify">Lugar de Panel: {{ $asignacion->lugar_evaluacion_jurado }}</p>

@stop
