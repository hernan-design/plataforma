@extends('layout.core.layout')

@section('content')
	<section id="features-wrapper">
		<section id="features-main">
			<div class="row full-width collapse">
				<div class="small-12 tablet-4 medium-3 large-3 xlarge-2 columns">
					<ul id="slide-out" class="features-vertical-menu side-nav">
						<li class="features-menu-item active">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'empresa') }}">Sitio de empresa</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'vacantes') }}">Creación y administración de vacantes</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'perfiles') }}">Sitios de perfiles y búsquedas</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'evaluacion') }}">Herramientas de evaluación</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'marketplace') }}">Marketplace de cursos online</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'cursos-propios') }}">Cursos online propios</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" hre	f="{{ route('caracteristicas.show', 'evaluaciones-desempeno') }}">Evaluaciones de desempeño</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'soporte') }}">Soporte</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="#">PRÓXIMAMENTE:</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'preentrevistas') }}">Pre-entrevistas por video</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'preguntas-respuestas') }}">Preguntas y respuestas sugeridas</a>
						</li>
						<li class="features-menu-item">
							<a class="features-menu-anchor" href="{{ route('caracteristicas.show', 'marketplace-tests') }}">Marketplace de tests</a>
						</li>
					</ul>
					<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
				</div>

				<div class="small-12 tablet-8 medium-9 large-9 xlarge-10 columns">
					@yield('content-features')
				</div>
			</div>
		</section>
	</section>
@stop
