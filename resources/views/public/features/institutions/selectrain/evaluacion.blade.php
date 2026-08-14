@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Herramientas de evaluación</h1>
		<p class="features-section-header-text">Gerentes, supervisores, jefes directos o hasta personas del equipo de trabajo pueden recibir invitaciones para evaluar a los candidatos seleccionados bien sea para completar un proceso de selección o para pasar de una etapa a la otra.</p>
	</div>
	<section class="features-section">
		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Evaluar candidatos es mucho más fácil usando las herramientas de SelecTrain. Con notificaciones automáticas, puntuaciones que se calculan automáticamente, la posibilidad de invitar a múltiples evaluadores, y reportes de toda la actividad, el proceso de selección pasa de ser un proceso tedioso a ser un proceso analítico y generador de valor para la organización.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Los usuarios invitados a participar en la evaluación de candidatos reciben un correo electrónico con un link a la evaluación con control de acceso en donde pueden registrar sus evaluaciones de candidatos.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>
				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">La evaluación de candidatos incluye múltiples aspectos y permite hacer comentarios para compartir entre los evaluadores o administradores del proceso de selección. Esta información también se almacena para generar reportes y trazabilidad.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'marketplace') }}">Marketplace de cursos online</a>
				</div>
			</div>
		</div>
	</section>
@stop
