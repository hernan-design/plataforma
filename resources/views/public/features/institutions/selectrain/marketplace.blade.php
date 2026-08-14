@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Marketplace de cursos online</h1>
		<p class="features-section-header-text">Con una oferta que crece constantemente, los usuarios pueden encontrar cursos orientados a fortalecer sus competencias y conocimientos. Los temas incluyen habilidades de comunicación, ventas, equipo de trabajo, entre otros. Todos los cursos se pueden tomar desde un computador o dispositivo móvil y en el momento que se quiera.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los usuarios reciben recomendaciones de los cursos para potenciar sus habilidades, competencias, y conocimientos, pero también pueden navegar el marketplace y explorar todas las opciones de cursos disponibles utilizando filtros, categorías y el buscador.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los cursos pueden contener diferentes tipos de recursos: videos, presentaciones, quizes, tareas y foros. Los usuarios pueden hacer preguntas, participar en discusiones y acceder a archivos subidos por los instructores en un ambiente amigable e interactivo.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Toda la actividad por parte de los usuarios queda registrada y puede ser analizada en reportes que aparecen en el dashboard de los usuarios administradores y que también pueden ser descargados en hojas de calculo.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'cursos-propios') }}">Cursos online propios</a>
				</div>
			</div>
		</div>
	</section>
@stop
