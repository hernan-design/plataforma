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

        {{-- banner video section
        @include('public.landing.institutions.innpulsa.video-tabs')--}}

		 {{-- main land  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

            @include('public.landing.institutions.innpulsa.2020.banner1')
            {{-- requisitos
            @include('public.landing.institutions.innpulsa.requirements')--}}

			{{-- about subscribe
            @include('public.landing.institutions.innpulsa.about') --}}

            {{-- emprendedores
            @include('public.landing.institutions.innpulsa.emprendedores') --}}

			{{-- aldea innpulsa beneficios
            @include('public.landing.institutions.innpulsa.benefits') --}}

		    {{-- stats
            @include('public.landing.institutions.innpulsa.stats') --}}

            {{-- equipo innpulsa
            @include('public.landing.institutions.innpulsa.team') --}}

            {{-- emprendimientos
            @include('public.landing.institutions.innpulsa.successful-projects') --}}
		</div>

		{{-- Footer --}}
		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.sitemap')
			{{-- Social and copyright footer --}}
			<div class="copyright-social-footer">
				<div class="row valign-middle">
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
						<span class="inst-copyright">Todo el contenido &copy; {{ $institution->nombre_institucion }} {{ date('Y') }}</span>
					</div>
					<div class="mobile-12 tablet-4 columns text-center">
						{!! HTML::image((isset($parameters['imagen_footer']) ? $parameters['imagen_footer'] : Config::get('tuproyecto.logo')), 'Logo', array('id' => 'logo-bottom-inst')) !!}
					</div>
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-right">
						<ul class="list-social-footer text-small-right text-mobile-center">
							<li>
								<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
									<i class="mdi mdi-facebook"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
									<i class="mdi mdi-twitter"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank" class="icon-circle medium icon-24 footer-social-icons">
									<i class="mdi mdi-youtube"></i>
								</a>
							</li>
						</ul>
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/mintic-logo.png" alt="Mintic logo">
					</div>
				</div>
			</div>
		</footer>
	</div>
@stop
