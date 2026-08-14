@extends('layout.landing.layout')

@section('content')
	<div id="wrapper-land" class="login-alert-display wrapper-sacudete">

		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.header')

		{{-- banner --}}
		<section id="sacudete-banner" data-stellar-offset-parent="true">
			<figure class="content-image-banner" data-stellar-background-ratio="0">
				<div class="row">
					<div class="small-12 tablet-10 medium-centered columns text-center">
						<img class="fondo-emprender-logo" src="https://static-dev.tuproyecto.com/images/institutions/Metamorfosis/letras-blancas-o-naranja.png" alt="">
						<h1 class="banner-title-1 white-text">Salud, cultura, deporte, tecnología y emprendimiento.</h1>
						<h4 class="banner-text white-text paragraph-hpadding-both title-small">Los METAMORFOSIS son centros para inspirar y potenciar talentos jóvenes para construir construir país de la mano de todos para el desarrollo y la productividad.</h4>
					</div>
				</div>
			</figure>
		</section>

		{{-- main land --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- About --}}
			<section id="sacudete-about" data-stellar-background-ratio="0.5">
				<div class="row">
					<div class="mobile-12 tablet-12 medium-5 columns">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/sacudete/sacudete-about-img.jpg" alt="">
					</div>
					<div class="mobile-12 tablet-12 medium-7 columns">
						<h3 class="title-medium about-title">Crearemos 1.400 centros METAMORFOSIS. Salud, cultura, deporte, tecnología y emprendimiento</h3>
						<p class="text-paragraph-normal">Crearemos 1.400 centros METAMORFOSIS (salud, cultura, deporte, tecnología y emprendimiento) como puntos de encuentro para jóvenes, en los cuales buscaremos crecer y consolidar las habilidades base, para participar de los beneficios de la Economía Naranja. A la vez que se construye ciudadanía y se previenen situaciones de embarazo adolescente, pandillas y vandalismo, entre otras.</p>
					</div>
				</div>
			</section>

			{{-- Inspírate --}}
			@if(isset($articles) && count($articles) > 0)
				<section id="news-land" class="section-land news-land block-vpadding-both" data-stellar-background-ratio="0.5">
					{{-- @if(isset($parameters['title_blog']) && $parameters['title_blog']) --}}
						<div class="row">
					        <div class="small-12 columns">
					            <h2 id="title-section" class="title-section-land">
					            	Inspírate
					           	</h2>
					        </div>
					    </div>
					{{-- @endif --}}
					<div class="row">
						<div class="mobile-12 columns">
							<div class="content-data-list">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-4 large-block-grid-5 slick-news slick-browse browse-list-mask list-news-land">
									@foreach ($articles as $article)
										<li class="item-news item-carousel">
											<div class="item-wrap-list radius news-item-land">
												<div class="top-item-list news-image-land no-border">
													<a href="{{ URL::route('blog.categoria.articulo', array($article->url_tipo_contenido, $article->url_contenido)) }}" title="{{ $article->nombre_contenido }}" class="item-thumb">
														{!! HTML::image($article->imagen_contenido, $article->nombre_contenido) !!}
													</a>
												</div>
												<div class="content-item-list news-description-land">
													<h5 class="news-item-title ellipsis">
														<a class="news-title-anchor-land" href="{{ URL::route('blog.categoria.articulo', array($article->url_tipo_contenido, $article->url_contenido)) }}" title="{{ $article->nombre_contenido }}">{{{ $article->nombre_contenido }}}</a>
													</h5>
												</div>
												<div class="bottom-item-list">
													<span class="gray-base-text thin-text news-bottom-land"><em>{{{ $article->fecha_contenido }}}</em></span>
												</div>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</section>
			@endif

			{{-- Convocatorias --}}
			@if(isset($programs) && count($programs) > 0)
				<section id="programs-land" class="section-land programs-land block-vpadding-both" data-stellar-background-ratio="0.5">
					@if(isset($parameters['title_convocatorias']) && $parameters['title_convocatorias'])
						<div class="row">
							<div class="small-12 columns">
								<div class="strip-title-white">
									<h2 class="title-section-land">Fondo emprender</h2>
								</div>
							</div>
						</div>
					@endif

					<div class="row">
						<div class="mobile-12 columns">
							<div class="content-data-list">
								<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-5 large-block-grid-6 slick-programs slick-browse browse-list-mask list-programs-land">
									@foreach ($programs as $program)
										<li class="item-programs item-carousel">
											<div class="item-wrap-list radius programs-item-land text-center clearfix">
												<h5 class="text-left programs-call-category-title">{{ $program->nombre_convocatoria }}</h5>
												<h3 class="programs-title text-left">
													<a href="" class="title-small programs-title-anchor-land">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
												</h3>
												<h6 class="text-left programs-call-date">Inicio: <b>Julio 22 de 2016</b></h6>
												<h6 class="text-left programs-call-date">Cierre: <b>Agosto 28 de 2016</b></h6>
												<a href="http://premioalainnovacion.innpulsa.com.co/convocatoria?category=1" class="button button-inst-secondary medium left radius btn-lowerc view-programs-cta">ver más</a>
											</div>
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</section>
			@endif

			{{-- Partners --}}
			@include('public.landing.partners')

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
								<a href="{{{ Cookie::get('_inst_facebook', Config::get('tuproyecto.social_facebook')) }}}" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-facebook"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_twitter', Config::get('tuproyecto.social_twitter')) }}}" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-close-outline"></i>
								</a>
							</li>
							<li>
								<a href="{{{ Cookie::get('_inst_youtube', Config::get('tuproyecto.social_youtube')) }}}" target="_blank" class="icon-circle small icon-18 footer-social-icons">
									<i class="mdi mdi-youtube-play"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</div>
@stop
