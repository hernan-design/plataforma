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

		<div class="full-width" id="banner-us-page">
			<div class="xlage-8 medium-10 small-12 xlarge-offset-2 medium-offset-1 small-offset-0 columns container-breadcum"> 
				<h3 class="title-breadcum-impact-page">
					Nosotros
				</h3>
				<small class="paragraph-breadcum-impact-page">
					Inicio / Nosotros
				</small>
			</div>
		</div>

		{{-- Video de youtube  --}}

		<div class="row" id="video-us-page">
			<div class="large-8 large-offset-2 medium-8 medium-offset-2 tablet-10 tablet-offset-1 small-12 small-offset-0 columns">
				<h3 class="text-center">
					Somos la Vicepresidencia de Aceleración y Emprendimiento
				</h3>
			</div>
		</div>
		<iframe style="border-top: 14px solid #FF0000;" src="https://www.youtube.com/embed/MOSnkBnONGA" class="full-width" height="400" allowfullscreen></iframe>

		{{-- seccion informativa 1 --}}

		<div class="row full-width no-padding" id="section2-us-page" style="background: url(https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/Hero-PORTADA-Innpulsa-AGO.jpg) 50% no-repeat;">
			<div class="" style="background: rgba(250,250,250,0.8);padding: 70px 300px;">
				<h2 class="text-center">
					Somos apasionados por el emprendimiento, pensamos en grande, somos auténticos, diversos y dinámicos.
				</h2>
				<p class="text-center">
					Disponemos nuestro talento para generar impacto en los emprendedores de Colombia, por medio de programas diferenciados y de alto valor.
					<br><br>
					Celebramos los triunfos de nuestros emprendedores y los acompañamos en sus retos estratégicos, para transformar sus emprendimientos al más alto nivel.
				</p>
			</div>
		</div>

		{{-- seccion informativa 2 --}}

		<div id="section3-us-page" class="row full-width col-equal-height">
			<h3 class="center-block">
				Nuestros ejes estratégicos
			</h3>
			<div class="large-8 large-offset-2 medium-10 medium-offset-1 tablet-12 tablet-offset-0 small-12 small-offset-0 columns" id="container-items-us-page">
				<div class="row">
					<div class="small-10 small-offset-1 tablet-4 tablet-offset-0 medium-4 medium-offset-0 columns no-padding">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/innpulsa2020/us+page/op-emprendedores%402x.png" alt="">
						<h2 class="text-center">Emprendedores</h2>
						<hr style="border:3px solid red; display:block; margin:auto; width:30px;">
						<p class="text-center">
							Potenciamos emprendedores, para que desarrollen las habilidades y capacidades que necesitan para detonar su potencial de liderazgo.
						</p>
					</div>
					<div class="small-10 small-offset-1 tablet-4 tablet-offset-0 medium-4 medium-offset-0 columns no-padding">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/innpulsa2020/us+page/op-emprendedores%402x+(1).png" alt="">
						<h2 class="text-center">Emprendimientos</h2>
						<hr style="border:3px solid red; display:block; margin:auto; width:30px;">
						<p class="text-center">
							Acompañamos emprendimientos, a través de programas de aceleración empresarial para que logren alcanzar un crecimiento extraordinario.
						</p>
					</div>
					<div class="small-10 small-offset-1 tablet-4 tablet-offset-0 medium-4 medium-offset-0 columns no-padding">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/innpulsa2020/us+page/op-emprendedores%402x+(2).png" alt="">
						<h2 class="text-center">Ecosistema</h2>
						<hr style="border:3px solid red; display:block; margin:auto; width:30px;">
						<p class="text-center">
							Fortalecemos los ecosistemas de emprendimiento regionales, para que los emprendedores tengan un entorno favorable y encuentren el apoyo que necesitan para crecer.
						</p>
					</div>
				</div>
			</div>
		</div>

		{{-- Boton de postulate --}}

		
	</div>
	{{-- Footer --}}
	@include('public.landing.institutions.innpulsa.footer')
</div>
@stop