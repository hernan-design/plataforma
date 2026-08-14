@extends('layout.landing.layout')

@section('content')
	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">

		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.institutions.innpulsa.header')

		{{-- main land  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

		{{-- Miga de pan --}}

			<div class="full-width" id="banner-impact-page">
				<div class="xlage-8 medium-10 small-12 xlarge-offset-2 medium-offset-1 small-offset-0 columns container-breadcum">
					<h3 class="title-breadcum-impact-page">
						Contacto
					</h3>
					<small class="paragraph-breadcum-impact-page">
						Inicio / Contacto
					</small>
				</div>
			</div>


			<div class="row" id="container-contactus-page">
				<div class="small-12 small-offset-0 large-8 large-offset-2 tablet-12 tablet-offset-0 medium-8 medium-offset-2">
					<div class="small-4 columns" id="contact-info">
						<h3>Contáctenos</h3>
						<p>
							Oficina principal: <br>
							Calle 28 No. 13 A 15, piso 37 C.P. 110311 <br>
							<br>
							Horario de atención: <br>
							Lunes a viernes, de 08:00 a.m. a 06:00 p.m. <br>
							<br>
							Conmutador: <br>
							(57-1) 743 79 39 Fax: (57-1) 286 24 51 / (57-1) <br>
							286 02 37 <br>
							<br>
							Línea gratuita para Colombia: <br>
							01 8000 18 0098 <br>
							<br>
							info@innpulsacolombia.com <br>
						</p>
					</div>
					<div class="small-8 columns no-padding" id="contact-form">
						<div class="small-6 columns">
							<input type="text" placeholder="Nombres y Apellidos">
							<input type="text" placeholder="Empresa">
							<input type="text" placeholder="Ciudad">
						</div>
						<div class="small-6 columns">
							<input type="text" placeholder="Email">
							<input type="text" placeholder="Teléfono">
							<input type="text" placeholder="Asunto">
						</div>
						<div class="small-12 columns">
							<textarea rows="7">
							</textarea>
							<button> ENVIAR </button>
						</div>
					</div>
				</div>
			</div>

		</div>

			{{-- Footer --}}
		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.sitemap')
		</footer>
	</div>
@stop