@extends('layout.landing.layout')

@section('content')

	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		@if($modules->where('codigo_modulo', App\Modulo::getModule('header'))->first() instanceof App\VisibilidadInstitucion)
			{{-- Header --}}
			@include('public.landing.header')
		@endif

		@if($modules->where('codigo_modulo', App\Modulo::getModule('banner'))->first() instanceof App\VisibilidadInstitucion)
			<div id="banner-land-top">
				@if($institution->carrousel_institucion)
	 				<figure class="slick-slider-banner">
						@foreach($images_carrusel as $imagen)
							<div class="wrap-img-slider">
								<img src="{{ $imagen->direccion_adjunto }}" alt="{{ $imagen->nombre_adjunto }}">
							</div>
						@endforeach
					</figure>
				@else
					<figure class="content-image-banner" {!! (isset($parameters['parallax_banner']) && $parameters['parallax_banner'] ? 'data-stellar-background-ratio="0.5"' : '') !!}>
					</figure>
				@endif

				<div class="content-banner">
					<div class="row">
						<div class="mobile-12 medium-11 medium-centered columns">
							<div class="text-content-banner panel-content radius text-center">
								<div class="text-banner text-center">{!! (isset($parameters['text_banner']) ? $parameters['text_banner'] : '') !!}</div>
							</div>
						</div>
					</div>
				</div>

				@if($institution->video_institucion && !$institution->carrousel_institucion)
					<a href="#" data-reveal-id="modal-video-landing" class="play-video-land">
						<i class="icon-play-land mdi mdi-play-circle"></i>
						<span>Ver video</span>
					</a>
					<div id="modal-video-landing" class="reveal-modal-ground full clearfix" data-reveal>
						{{-- Content modal --}}
						<div class="content-modal">
							<div id="container-video-land" class="flex-player full-player">
								<video id="player-video-landing" class="" controls preload="auto" showinfo="0" width="640" height="264">
									<source type="video/youtube" src="{{ $institution->video_institucion }}" />
									<object class="" width="640" height="264" type="application/x-shockwave-flash"
										data="{!! asset('js/vendor/flashmediaelement.swf') !!}">
										<param name="movie" value="{!! asset('js/vendor/flashmediaelement.swf') !!}" />
										<param name="allowfullscreen" value="true" />
										<param name="allowScriptAccess" value="always">
										<param name="allowNetworking" value="all">
										<param name="wmode" value="opaque">
										<param name="bgcolor" value="#000000">
										<param name="flashvars" value="" />

										{{-- <img src="http://video-js.zencoder.com/oceans-clip.png" width="640" height="264" alt="Poster Image" title="No video playback capabilities." /> --}}
									</object>
								</video>
							</div>
						</div>
						<a class="close content-close close-reveal-modal">&#215;</a>
					</div>
				@endif
			</div>
		@endif

		<div id="main-land" class="main-section" data-stellar-offset-parent="true">
			@if(isset($modules))
				@foreach ($modules as $module)
					@if ($module->name == 'cifras')
						@include('public.landing.statistics')
					@elseif ($module->name == 'entidades')
						@include('public.landing.projects')
					@elseif ($module->name == 'beneficios')
						@include('public.landing.advantage')
					@elseif ($module->name == 'aliados')
						@include('public.landing.partners')
					@elseif ($module->name == 'blog')
						@include('public.landing.news')
					@elseif ($module->name == 'eventos')
						@include('public.landing.events')
					@elseif ($module->name == 'convocatorias')
						@include('public.landing.programs')
					@elseif ($module->bloque_texto_modulo == true)
						{!! (isset($parameters["text_{$module->name}"]) ? $parameters["text_{$module->name}"] : '') !!}
					@endif
				@endforeach
			@endif
			{{-- @include('public.landing.institutions.innpulsa') --}}
		</div>

		{{-- Footer --}}
		<footer class="footer" id="footer-land">
			@if($modules->where('codigo_modulo', App\Modulo::getModule('sitemap'))->first() instanceof App\VisibilidadInstitucion)
				{{-- Sitemap footer --}}
				@include('public.landing.sitemap')
			@endif
			{{-- Social and copyright footer --}}
			@include('public.landing.footer')
		</footer>
	</div>
@stop
