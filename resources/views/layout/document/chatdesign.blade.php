<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
	@include('public.meta')

	<link rel="stylesheet" href="{{ elixir('css/vendor.min.css') }}">
	<link rel="stylesheet" href="{{ elixir('css/application.css') }}">
	{!! HTML::style('css/institution/'.App\RegistroSesion::getInstitutionSlug().'.css') !!}

	@if (Auth::check() && $app->environment('production'))
		{{-- Woopra --}}
		@include('public.woopra')
	@endif

	{{-- Modernizr --}}
	{!! HTML::script('js/vendor/modernizr.min.js') !!}

	<script>
		/**
		 * default image
		 * @param imgEl Element
		 * @param imgDefault String default image url
		 */
		function imageDefault (imgEl, imgDefault) { imgDefault || (imgDefault = ''); if (imgEl.getAttribute('src') != imgDefault) imgEl.setAttribute('src', imgDefault); }
	</script>
</head>
<body style="background:#c7c7c7 !important;">
<!--[if lt IE 9]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve yourhttp://open.spotify.com/track/4sFbojhVXQv7dBC9PVCcRn experience.</p>
<![endif]-->

{{-- preloader full screen
	@include('layout.preloader')
--}}

{{-- Header Site --}}
<header id="header-wrap" class="fixed">
	@include('layout.core.header')
</header>
{{-- Main menu options
 	@include('layout.mainmenu')
--}}

<div class="row">
	<div class="mobile-12">
		<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">
				<nav class="tab-bar sky-blue-bg">
					<section class="left-small">
						<a class="left-off-canvas-toggle menu-icon" href="#"><span></span></a>
					</section>

					<section class="middle tab-bar-section">
						<div>
							<strong style="color:white;">Patricia Fernandez</strong><br>
						</div>
					</section>

					<section class="right-small">
						<a class="right-off-canvas-toggle menu-icon" href="#"><span></span></a>
					</section>
				</nav>

				<aside class="left-off-canvas-menu">
					<div class="mobile-12 columns no-padding" style="border-right:1px solid #d7d7d7; ">
						<a href="">
							<div style="padding:0.8rem;border-bottom:1px solid #d7d7d7;">
								<span class="mdi mdi-settings"></span>
								<small style="font-size:0.7rem;color:#777;">&nbsp;Configuración</small>
							</div>
						</a>
						<ul class="tabs vertical" data-tab style="min-width:100%;">
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Paola Andrea Garzón Fernandez</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Raúl Escobar</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Patricia Fernandez</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</aside>

				<aside class="right-off-canvas-menu">
					<div class="mobile-12 columns no-padding" style="border-right:1px solid #d7d7d7; ">
						<ul class="tabs vertical" data-tab style="min-width:100%;">
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Paola Andrea Garzón Fernandez</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Raúl Escobar</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
							<li class="tab-title">
								<a href="#panel21" style="padding: 0.2rem 1.3rem;text-align: left;">
									<div>
										<label style="color:#232323;">Patricia Fernandez</label><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">Tú : Lorem ipsum dolor sit  </label>
									</div>
								</a>
							</li>
						</ul>
					</div>
				</aside>

				<section class="main-section">
					<div class="mobile-12 columns no-padding" style="background: white;">
						{{-- body chat--}}
						<div style="padding:0.8rem 1.2rem;">
							<div>
								<div class="panel radius" style="background:#f7f7f7;width:60%;border:0;">
									<p style="font-size:0.75rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque rerum porro necessitatibus vel sapiente!</p>
									<div style="margin-top: -1.2rem;">
										<label style="font-size:0.6rem;color:#777;font-weight:300;">22:38</label>
									</div>
								</div>
							</div>
							<div>
								<div class="panel radius right" style="background:#a0a0a0;width:60%;border:0;margin-bottom: 3rem;">
									<p style="color:#f9f9f9;font-size:0.75rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque rerum porro necessitatibus vel sapiente!</p>
									<div style="margin-top: -1.2rem;">
										<label style="font-size:0.6rem;color:#f9f9f9;font-weight:300;">22:38 Visto</label>
									</div>
									<a data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"><span class="mdi mdi-chevron-down white right"></span></a>
									<div style="width:15% !important;">
										<ul id="drop1" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1" style="">
											<li><a href="#">Eliminar</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						{{-- footer chat --}}
						<div>
							<div>
								<input type="text" style="position:absolute; bottom: 0;margin-bottom: 0; border-top: 1px solid #c7c7c7;border-bottom:0;padding: 0.2rem 0.8rem;width: -webkit-fill-available; margin: 0;" placeholder="Escribe un mensaje...">
								<a href="">
									<span class="mdi mdi-send" style="position: absolute;bottom: 15px;right: 15px;"></span>
								</a>
							</div>
						</div>
						<div class="tabs-content">
							<div class="content" id="panel21">
								{{-- header chat--}}
								<div style="padding:0.8rem 1.2rem;border-bottom:1px solid #d7d7d7;">
									<div>
										<strong>Patricia Fernandez</strong><br>
									</div>
									<div style="margin-top: -0.4rem;">
										<small style="font-size:0.6rem;color:#777;">&nbsp;Ingeniero de sistemas</small>
									</div>
								</div>
								{{-- body chat--}}
								<div style="padding:0.8rem 1.2rem;">
									<div>
										<div class="panel radius" style="background:#f7f7f7;width:60%;border:0;">
											<p style="font-size:0.75rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque rerum porro necessitatibus vel sapiente!</p>
											<div style="margin-top: -1.2rem;">
												<label style="font-size:0.6rem;color:#777;font-weight:300;">22:38</label>
											</div>
										</div>
									</div>
									<div>
										<div class="panel radius right" style="background:#a0a0a0;width:60%;border:0;margin-bottom: 3rem;">
											<p style="color:#f9f9f9;font-size:0.75rem;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque rerum porro necessitatibus vel sapiente!</p>
											<div style="margin-top: -1.2rem;">
												<label style="font-size:0.6rem;color:#f9f9f9;font-weight:300;">22:38 Visto</label>
											</div>
											<a data-dropdown="drop1" aria-controls="drop1" aria-expanded="false"><span class="mdi mdi-chevron-down white right"></span></a>
											<div style="width:15% !important;">
												<ul id="drop1" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1" style="">
													<li><a href="#">Eliminar</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
								{{-- footer chat --}}
								<div>
									<div>
										<input type="text" style="position:absolute; bottom: 0;margin-bottom: 0; border-top: 1px solid #c7c7c7;border-bottom:0;padding: 0.2rem 0.8rem;width: -webkit-fill-available; margin: 0;" placeholder="Escribe un mensaje...">
										<a href="">
											<span class="mdi mdi-send ellipsis" style="position: absolute;bottom: 15px;right: 15px;"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>


				<a class="exit-off-canvas"></a>

			</div>
		</div>
	</div>
</div>












{{-- Js libraries --}}
<script>window.document.url = "{{ URL::to('/') }}";</script>
{{-- Libraries like: jQuery, foundation --}}
<script src="{{ elixir('js/vendor/third-party.js') }}"></script>
<script src="{{ elixir('js/bundle.js') }}"></script>

@if (Auth::check() && $app->environment('production'))
	{{-- Realtime script --}}
	<script src="{{ elixir('js/realtime.app.js') }}"></script>
@endif

@if ($app->environment('production'))
	{{-- Google Analytics API --}}
	@include('public.googleanalytics')

	@if( in_array(Request::segment(1), ['comunidad']) )
		{{-- Userguiding SDK --}}
		@include('public.userguiding')
	@endif
@endif
</body>
</html>
