<header id="innpulsa-header" class="fixed header" data-magellan-expedition>
	<div class="contain-top-bar">
		<div id="nav-initial">
			<div id="container-nav1" class="hide-for-mobile-only">
				<div class="row full-width" id="container-responsive-1">
					<div class="small-2 tablet-3 large-2 columns right no-padding">
						@if(Auth::guest())
							<div class="radius right">
								<a href="{{ url('https://api.whatsapp.com/send?phone=' . config('tuproyecto.whatsapp_number')) }}">
									<i class="mdi mdi-help-circle-outline mdi-18px">
									</i>
								</a>&nbsp;
							</div>
							<div class="radius right">
								<a href="{{ URL::route('login') }}" title="Iniciar sesión">
									INICIAR SESIÓN
								</a>
							</div>
						@else
							<div class="radius right">
								<a href="{{ url('https://api.whatsapp.com/send?phone=' . config('tuproyecto.whatsapp_number')) }}">
									<i class="mdi mdi-help-circle-outline mdi-18px">
									</i>
								</a>&nbsp;
							</div>
							<div class="radius right">
								<a href="{{ URL::route('logout') }}" title="{{ Lang::get('app.logout') }}">
									<i class="mdi mdi-power mdi-18px">
									</i>
								</a>
							</div>
						@endif
					</div>
				</div>
			</div>
			<nav class="top-bar hide-for-mobile-only" data-topbar role="navigation">
				<div class="row" style="padding: 0px 45px;position:absolute;">
					<div class="small-4 large-4 columns">
						<a href="{{ App\RegistroSesion::getCommunityRoot() }}">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/innpulsa/landing-octubre-2018/innpulsa-logo-header.svg" style=" width: 126px;margin-left: 30px;" alt="">
						</a>
					</div>
					<div class="small-4 large-4 columns">
						<section class="top-bar-section center-block" style="width: 60px;">
							<!-- Right Nav Section -->
							<ul>
								<li class="has-dropdown">
									<a href="#" id="hamburger"><i class="mdi mdi-menu" style="color: white;font-size: 30px;"></i></a>
									<ul class="dropdown center-block" style="background: transparent;">
										<div id="contenedor" style="width: 330px;display: block;margin: auto;height: 320px;z-index: 1000;background: #0D2467;opacity: 0.8;overflow: hidden;margin: -6px -135px;">
											<li class="text-center" style="list-style: none;padding: 10px;"><a href="" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Inicio</a></li>
											<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'programas']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Convocatorias</a></li>
											<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'locosemprendimiento']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Nosotros</a></li>
											<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'impacto']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Nuestro impacto</a></li>
											{{-- <li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'grandesarboles']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Contacto</a></li> --}}
										</div>
									</ul>
								</li>
							</ul>
							<!-- Left Nav Section -->
						</section>
					</div>
					<div class="small-4 large-4 columns no-padding">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/nuevo+landing/mincomercio.jpg" class="right" style="width: 160px;margin-top: 15px;margin-right: 30px;" alt="">
					</div>
				</div>
			</nav>
			<nav class="top-bar show-for-mobile-only" data-topbar role="navigation">
				<ul class="title-area">
					<li class="name">
						<a href="{{ App\RegistroSesion::getCommunityRoot() }}">
							<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/innpulsa/landing-octubre-2018/innpulsa-logo-header.svg" style="width: 126px;margin: 8px;" alt="">
						</a>
					</li>
					<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
					<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				</ul>

				<section class="top-bar-section">
					<!-- Right Nav Section -->
					<ul class="right">
						<div id="contenedor" class="full-width" style="display: block;margin: auto;height: 320px;z-index: 1000;background: #0D2467;opacity: 0.8;overflow: hidden;">
							<li class="text-center" style="list-style: none;padding: 10px;"><a href="" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Inicio</a></li>
							<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'programas']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Convocatorias</a></li>
							<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'locosemprendimiento']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Nosotros</a></li>
							<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'impacto']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Nuestro impacto</a></li>
							{{-- <li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ route('landingpage', ['category' => 'pagina', 'slug' => 'grandesarboles']) }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;text-transform:capitalize;">Contacto</a></li> --}}
						@if(Auth::guest())
						<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ URL::route('login') }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;">INICIAR SESION <i class="mdi mdi-login"></i> </a></li>
						@else
						<li class="text-center" style="list-style: none;padding: 10px;"><a href="{{ URL::route('logout') }}" style="color: #FFD535;font-family: 'Montserrat Medium';font-weight: bold;font-size: 12px;">SALIR <i class="mdi mdi-logout"></i> </a></li>
						@endif
						</div>
					</ul>
				</section>
			</nav>
		</div>
	</div>
</header>
