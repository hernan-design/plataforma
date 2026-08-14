@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Pre-entrevistas por video</h1>
		<p class="features-section-header-text">Ahorra tiempo, esfuerzo y mejora los resultados de tus búsquedas ampliando tu capacidad de entrevistar candidatos utilizando per-entrevistas por video que formulan preguntas de manera automatizada a los candidatos, grabando sus respuestas y dándote la posibilidad de incluirlas en el proceso de evaluación por parte de múltiples usuarios.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los candidatos reciben preguntas estructuradas con base al perfil que se busca y pueden grabar sus respuestas en un tiempo determinado. </p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Posteriormente los otros evaluadores como miembros del equipo, jefe director y personas a cargo según aplique, reciben un link para evaluar al trabajador.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Estas pre-entrevistas se incluyen como parte de la aplicación a una vacante por parte de un candidato y es un insumo mas que los evaluadores tienen a su disposición para conocer mejor a un candidato y poder tomar mejor una decisión.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'preguntas-respuestas') }}"></a>
				</div>
			</div>
		</div>
	</section>
@stop
