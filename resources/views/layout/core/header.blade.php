<!-- Tablet-up top-bar -->
<nav id="nav-header" class="top-bar show-for-tablet-up" data-topbar role="navigation" data-options="is_hover:true">
	<section class="top-bar-section">
		<div class="full-width">
			<ul id="nav-menus-grid" class="inline-list-grid">
				<li class="left-nav-top-bar">
					{{-- Left Nav Section --}}
					<div class="left {{-- show-for-large-up --}} wrap-inst-logo">
						<a href="{{ App\RegistroSesion::getUrlHomePage() != null ? App\RegistroSesion::getUrlHomePage() : App\RegistroSesion::getCommunityRoot() }}" class="left inst-logo" title="{{ Lang::get('app.home') }}">
							{!! HTML::image(App\RegistroSesion::getInstitutionImg(), App\RegistroSesion::getInstitutionName()) !!}
						</a>
					</div>
					<ul class="left-top-menu inline-list-grid">
						<li>&nbsp;</li>
						{{-- Form search --}}
						<li class="has-form item-field-search">
							{!! Form::open(['route' => 'search.index', 'method' => 'GET', 'id' => 'form-search']) !!}
								<div class="field-search text-left">
									<input
										type="text"
										name="search"
										id="search-txt"
										value="{{ request('search') }}"
								   		@if( App\RegistroSesion::getInstitution() == App\Institucion::getInstitution('dinamiza') )
											placeholder= "Busca programas, eventos y servicios que Cali tiene para ti""
										@else  placeholder="Buscar en la red."
										@endif
										style="display: none"
									/>
									<input type="hidden" name="type" value="{{ request('type') }}">
									<button
										type="button"
										class="btn-search text-left"
										data-focuses="search-txt"
										style="display: none;"
									>
										<i class="mdi mdi-magnify mdi-24 icon-search"></i>
									</button>
								</div>
							{!! Form::close() !!}
						</li>
					</ul>
				</li>
				<li class="right-nav-top-bar">
					{{-- Right Nav Section --}}
					<ul class="right right-top-menu inline-list-grid">
						@if (Auth::guest())
							<li>
								{{-- sign-in buttons --}}
								<ul class="right singin-buttons-top-menu inline-list-grid valign-center">
									<li class="no-warp">
										<a href="{{ URL::route('login') }}" class="button xtiny radius inst-secondary-outline" @if( !in_array(Request::segment(1), ['login', 'register']) ) data-reveal-id="modal-login" @endif>Iniciar Sesión</a>
									</li>
									<li class="no-warp">
										<a href="{{ URL::route('register') }}" class="button xtiny radius sky-blue">{{ transtp('register.principalbutton') }}</a>
									</li>
								</ul>
							</li>
						@endif
						@if (Auth::check())
							{{-- Notification dropdowns --}}
							@include('layout.notifydrops')
					    	<li class="has-dropdown">
					    		<a class="avatar" data-options="align:bottom;is_hover:false;hover_timeout:0" data-dropdown="user-opt-menu">
					    			<img src="{{ Auth::user()->imagen_usuario }}" alt="{{ Auth::user()->nombre_usuario }}" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
								</a>
								<ul id="user-opt-menu" class="notification-layer-dropdown gutter-side small radius" data-dropdown-content aria-autoclose="false" aria-hidden="true">
									<li>
										<a href="{{ url(Auth::user()->getProfileUrl()) }}" title="{{ Lang::get('app.profile') }}">
											<ul class="inline-list-grid valign-center">
												<li>{{ Lang::get('app.profile') }}</li>
												<li class="has-image text-right"><i class="mdi mdi-account mdi-21 vcenter"></i></li>
											</ul>
										</a>
									</li>
									@if (App::environment('local'))
										@if(Auth::user()->tipo_usuario ==  App\Usuario::typeUser('entity') && !empty(session('_user_owner')))
											<li>
												<a href="{{ URL::route('auth.identityswitch', ['srcparams' => TuProyecto::encryptSrcParams([session('_user_owner')])]) }}" title="{{ Lang::get('app.profile') }}">
													<ul class="inline-list-grid valign-center">
														<li>Volver a mi cuenta</li>
														<li class="has-image text-right"><i class="mdi mdi-account mdi-24 vcenter"></i></li>
													</ul>
												</a>
											</li>
										@endif
									@endif
									<li>
										<a href="{{ URL::route('usuario.index') }}" title="{{ Lang::get('user.search') }}">
											<ul class="inline-list-grid valign-center">
												<li>{{ Lang::get('user.search') }}</li>
												<li class="has-image text-right"><i class="mdi mdi-account-search mdi-24 vcenter"></i></li>
											</ul>
										</a>
                                    </li>

                                    {{-- Other roles --}}
                                    @if(Auth::user()->hasRole(['jurado', 'super-admin']))
                                        <li class=""><hr class="no-margin"></li>
                                        <li>
                                            <a href="{{ route('evaluacion.index') }}" title="{{ transtp('menu.evaluations') }}">
                                                <ul class="inline-list-grid valign-center">
                                                    <li>{{ transtp('menu.evaluations') }}</li>
                                                    <li class="has-image text-right"><i class="mdi mdi-clipboard-text mdi-24 vcenter"></i></li>
                                                </ul>
                                            </a>
                                        </li>
                                    @endif
									<li class=""><hr class="no-margin"></li>
									<li>
										<a href="{{ URL::route('logout') }}" title="{{ Lang::get('app.logout') }}">
											<ul class="inline-list-grid valign-center">
												<li>{{ Lang::get('app.logout') }}</li>
												<li class="has-image text-right"><i class="mdi mdi-logout mdi-24 vcenter"></i></li>
											</ul>
										</a>
									</li>
								</ul>
					    	</li>
				    	@endif
						<li>
				    		<a href="{{ url('https://api.whatsapp.com/send?phone=' . config('tuproyecto.whatsapp_number')) }}" target="_blank" title="Ayuda rápida" class="has-icon-notify">
								<span class=""><i class="mdi mdi-help-circle mdi-24"></i></span>
							</a>
				    	</li>
				    	<li>
				    		<a href="#" class="menu-icon-custom" >
				    			<div class="md-animated-icon bubbleback md-hamburger-close__icon main-menu-toggle">
									<span class="md-hamburger__layer"></span>
									{{-- <span class="text-sm reset-case-text label-icon">Menú</span> --}}
				    			</div>
							</a>
				    	</li>
					</ul>
				</li>
			</ul>
		</div>
	</section>
</nav>
<!-- Mobile offCanvas -->
<nav id="nav-header-side" class="tab-bar hide-for-tablet-up">
	{{-- Middle Tittle --}}
	<div class="left tab-bar-section">
		<ul class="settings-nav-menu inline-list-grid">
			<li class="has-image">
				<a href="{{ App\RegistroSesion::getCommunityRoot() }}" class="inst-logo">
					{!! HTML::image(App\RegistroSesion::getInstitutionImg(), App\RegistroSesion::getInstitutionName()) !!}
				</a>
			</li>
			<li class="clearfix">
				<ul class="notifications-items inline-list-items right">
					{{-- Notification dropdowns --}}
					@if (Auth::check())
						@include('layout.notifydrops')
					@endif
				</ul>
			</li>
		</ul>
	</div>
	<div class="right-small">
		{{-- Right Menu --}}
		@if (Auth::check())
			<ul class="inline-list-grid menu-nav-user">
				<li>
					<a href="#" data-options="align:bottom" data-dropdown="user-opt" class="avatar">
		    			<img src="{{ Auth::user()->imagen_usuario }}" alt="{{ Auth::user()->nombre_usuario }}" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
					</a>
					<ul id="user-opt" class="notification-layer-dropdown gutter-side small" data-dropdown-content aria-autoclose="false" aria-hidden="true">
						<li>
							<a href="{{ url(Auth::user()->getProfileUrl()) }}">
								<ul class="inline-list-grid valign-center">
									<li>{{ Lang::get('app.profile') }}</li>
									<li class="has-image text-right"><i class="mdi mdi-account mdi-21 vcenter"></i></li>
								</ul>
							</a>
						</li>
						<li>
							<a href="{{ URL::route('usuario.index') }}" title="{{ Lang::get('user.search') }}">
								<ul class="inline-list-grid valign-center">
									<li>{{ Lang::get('user.search') }}</li>
									<li class="has-image text-right"><i class="mdi mdi-account-search mdi-24 vcenter"></i></li>
								</ul>
							</a>
                        </li>

                        @if(Auth::user()->hasRole(['jurado', 'super-admin']))
                            <li class="divider"><hr class="no-margin"></li>
                            <li>
                                <a href="{{ route('evaluacion.index') }}" title="{{ transtp('menu.evaluations') }}">
                                    <ul class="inline-list-grid valign-center">
                                        <li>{{ transtp('menu.evaluations') }}</li>
                                        <li class="has-image text-right"><i class="mdi mdi-clipboard-text mdi-24 vcenter"></i></li>
                                    </ul>
                                </a>
                            </li>
                        @endif
						<li class="divider"><hr class="no-margin"></li>
						<li>
							<a href="{{ URL::route('logout') }}" title="{{ Lang::get('app.logout') }}">
								<ul class="inline-list-grid valign-center">
									<li>{{ Lang::get('app.logout') }}</li>
									<li class="has-image text-right"><i class="mdi mdi-logout mdi-24 vcenter"></i></li>
								</ul>
							</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="{{ url('https://api.whatsapp.com/send?phone=' . config('tuproyecto.whatsapp_number')) }}" target="_blank" title="Ayuda rápida" class="has-icon-help">
						<span class=""><i class="mdi mdi-help-circle mdi-24"></i></span>
					</a>
				</li>
			</ul>
		@elseif( !in_array(Request::segment(1), ['login', 'register']) )
			<ul class="settings-nav-menu inline-list-grid">
				<li>
					<a href="#" class="show-strip-signup"><i class="mdi mdi-account-key mdi-24"></i></a>
				</li>
			</ul>
		@endif
	</div>
</nav>

<aside id="bottom-offcanvas-menu" class="bottom-off-canvas-menu scroll-general-v">
	<ul class="off-canvas-list">
		@php $parents = App\Menu::getParents(App\TipoMenu::getType('platform')); @endphp
		<li><a href="{{ route('comunidad.index') }}">{{ trans('app.home') }}</a></li>
		@foreach ($parents as $parent)
			<li>
				<label>
					<ul class="inline-list-grid valign-center">
						<li>{{ $parent->nombre_item_menu }}</li>
						<li class="has-image">
							<li class="has-image text-right"><i class="mdi mdi-web mdi-30 gray-light"></i></li>
						</li>
					</ul>
				</label>
			</li>
			@php $children = App\Menu::getChildren(App\TipoMenu::getType('platform'), $parent->codigo_menu_institucion); @endphp
			@foreach ($children as $son)
				<li><a href="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('internal') ? ($son->ruta_menu_institucion ? url($son->ruta_menu_institucion) : '#') : $son->ruta_menu_institucion }}" target="{{ $son->tipo_enlace_menu_institucion == App\Menu::getTypeLink('external') ? '_blank' : ''}}" data-section="{{ $son->seccion_menu_institucion }}" class="{{ $son->clase_item_menu ? $son->clase_item_menu : '' }}">{{ $son->nombre_item_menu }}</a></li>
			@endforeach
		@endforeach
		@if (Auth::guest())
			<li>{!! link_to_route('login', Lang::get('app.login')) !!}</li>
		@endif
	</ul>
</aside>
{{-- bottom bar --}}
<nav id="nav-bottom-bar" class="tab-bar bottom-bar hide-for-tablet-up fixed">
	<div class="left tab-bar-section">
		<ul class="settings-nav-menu inline-list-grid">
			<li class="clearfix">
				<div class="item-field-search">
					{!! Form::open(['route' => 'search.index', 'method' => 'GET', 'id' => 'form-search']) !!}
						<div class="field-search text-left">
							<input
								type="text"
								name="search"
								id="small-search-txt"
								value="{{ request('search') }}"
								placeholder="Buscar en la red."
								autofocus
								style="display: none"
							>
							<input type="hidden" name="type" value="{{ request('type') }}">
							<button
								type="button"
								class="btn-search text-left"
								data-focuses="small-search-txt"
								style="display: none"
							>
								<i class="mdi mdi-24 mdi-magnify icon-search"></i>
							</button>
						</div>
					{!! Form::close() !!}
				</div>
			</li>
		</ul>
	</div>
	{{-- Slider bottom right Menu --}}
	<div class="right-small md-hamburger">
		<a href="#" id="boton-buttom-menu" class="bottom-off-canvas-toggle md-animated-icon bubbleback md-hamburger-close__icon menu-icon-custom">
			<span class="md-hamburger__layer"></span>
		</a>
	</div>
</nav>
