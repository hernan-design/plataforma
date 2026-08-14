@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Páginas de perfiles y búsquedas</h1>
		<p class="features-section-header-text">Sin necesidad de crear una convocatoria, puedes explorar manualmente todos los perﬁles públicos de los usuarios inscritos en la plataforma. Cada usuario tiene su página con la información que decida hacer publica y tendrás la posibilidad de contactarlo.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">En la red de profesionales de SelecTrain también podrás encontrar manualmente los perfiles que necesites con las herramientas de el motor de búsqueda y filtros.</p>
				</div>
			</div>
		</article>
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Cada usuario tiene su página de perfil, en donde se puede observar toda la información que comparta un candidato.</p>
				</div>
			</div>
		</article>
		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'evaluacion') }}">Herramientas de evaluación</a>
				</div>
			</div>
		</div>
	</section>
@stop
