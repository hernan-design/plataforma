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
		@include('public.landing.institutions.sena.header')

		{{-- banner --}}
        @include('public.landing.institutions.sena.banner')

        <div id="main-land" class="main-section" data-stellar-offset-parent="true">
			{{-- benefits --}}
			@include('public.landing.institutions.sena.benefits')

			{{-- about --}}
			@include('public.landing.institutions.sena.about')

			{{-- comunidad --}}
			@include('public.landing.institutions.sena.community')

			{{-- comunidad --}}
			@include('public.landing.institutions.sena.contact')
        </div>

		{{-- Footer --}}
		<footer class="footer" id="footer-land">
			{{-- Social and copyright footer --}}
			<div class="copyright-social-footer">
				<div class="row valign-middle">
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-left">
						<span>® 2019 Sena · &copy; {{ $institution->nombre_institucion }} {{ date('Y') }}<b> | todos los derechos reservados</b></span>
					</div>
					<div class="mobile-12 tablet-4 columns text-center">
						{!! HTML::image((isset($parameters['imagen_footer']) ? $parameters['imagen_footer'] : Config::get('tuproyecto.logo')), 'Logo', array('id' => 'logo-bottom-inst')) !!}
					</div>
					<div class="mobile-12 tablet-4 columns mobile-text-center tablet-text-right">
						<span><a href="#">Políticas de privacidad | Términos y condiciones</a></span>
					</div>
				</div>
			</div>
		</footer>
	</div>
@stop
