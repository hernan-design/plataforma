@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Preguntas y respuestas sugeridas</h1>
		<p class="features-section-header-text">Para ayudar a los jefes de talento humano, jefes directos o miembros del equipo a que puedan llevar a cabo entrevistas estructuradas que produzcan mejores resultados, los entrevistados pueden recibir preguntas y respuestas sugeridas y utilizar SelecTrain para registrar sus evaluaciones y comentarios. Esta información se puede utilizar posteriormente para computar caliﬁcaciones de candidatos o reportes de procesos de selección.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Para llevar a cabo entrevistas productivas que produzcan los mejores resultados, los entrevistadores reciben sugerencias de preguntas y recomendaciones sobre lo que deben buscar en las respuestas por parte de los candidatos evaluados.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Estas entrevistas se pueden evaluar desde SelecTrain, para llevar un registro de todo el proceso de selección y posteriormente poder calificar candidatos y generar reportes.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'marketplace-tests') }}">Marketplace de tests</a>
				</div>
			</div>
		</div>
	</section>
@stop
