@extends('layout.core.layout')

@section('content')

	<section id="error-500" class="app-errors has-bgimage">
		<div class="row">
			<div class="mobile-12 medium-11 medium-centered columns">
				<div class="panel-content radius text-center">
					<h4 class="app-errors-title inst-color-secondary">ERROR 500</h4>
					<p class="app-errors-text">Disculpa, hubo un error inesperado. Puedes hacer <a href="#" class="app-errors-goback">clic aquí para regresar</a> o elegir una de las opciones en el siguiente menú.</p>
					<i class="mdi mdi-sign-direction sky-blue" id="icon-error"></i>
					<ul class="wrapper-item-options mobile-block-grid-2 tablet-block-grid-2 medium-block-grid-4 app-errors-menu">
						<li class="app-errors-boxes">
							<ul class="app-errors-menu-list">
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Emprendimientos</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Convocatorias</a>
								</li>
							</ul>
						</li>
						<li class="app-errors-boxes">
							<ul class="app-errors-menu-list">
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Eventos</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Muro</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Foro</a>
								</li>
							</ul>
						</li>
						<li class="app-errors-boxes">
							<ul class="app-errors-menu-list">
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Aprende</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Artículos</a>
								</li>
							</ul>
						</li>
						<li class="app-errors-boxes">
							<ul class="app-errors-menu-list">
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Ser mentor</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Crear empresa</a>
								</li>
								<li class="app-errors-menu-item">
									<a class="app-errors-menu-anchor" href="#">Crear grupo</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</section>

@stop
