@extends('core.learn.learn')
@section('learn.content')
	{{-- Navbar template --}}
	<script type="text/template" id="learn-navbar">
		{{-- Navbar desktop--}}
        <div id="learn-menu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
            <div class="row">
                <div class="small-12 columns">
                    <ul id="learn-tabs-filter" class="learn-submenu-tabs tabs-sub-nav-alt tabs tabs-route text-right">
						@if (App\RegistroSesion::getInstitutionSlug() == 'ninojesus')
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'bienestar' ? 'active' : '' %>">
								<a
									href="<%- Route.route('aprende.tipo', { 'type': 'bienestar'})%>"
									title="{{transtp('learn.type.bienestar')}}"
									aria-controls="courses">{{transtp('learn.type.bienestar')}}
								</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursosColaboradores' ? 'active' : '' %>">
								<a
									href="<%- Route.route('aprende.tipo', { 'type': 'cursosColaboradores'})%>"
									title="{{transtp('learn.type.coursesColaborators')}}"
									aria-controls="courses">{{transtp('learn.type.coursesColaborators')}}
								</a>
							</li>
						@endif
                        <li class="tab-title <%- typeof type !== 'undefined' && type == 'cursos' ? 'active' : '' %>">
                            <a href="<%- Route.route('aprende.tipo', { 'type': 'cursos'})%>" title="{{transtp('learn.type.courses')}}" aria-controls="courses">{{transtp('learn.type.courses')}}</a>
                        </li>
						@if (App\RegistroSesion::getInstitutionSlug() != 'propace')
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'webinars' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'webinars'})%>" title="{{transtp('learn.type.webinars')}}" aria-controls="webinars">{{transtp('learn.type.webinars')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'conferencias' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'conferencias'})%>" title="{{transtp('learn.type.conferences')}}" aria-controls="conferencias">{{transtp('learn.type.conferences')}}</a>
							</li>
						@endif
						@if(Auth::check())
						{{--
                        <li class="tab-title <%- typeof type !== 'undefined' && type == 'certificados' ? 'active' : '' %>">
                            <a href="<%- Route.route('aprende.tipo', { 'type': 'certificados'})%>" title="{{transtp('learn.type.certificates')}}" aria-controls="certificados">{{transtp('learn.type.certificates')}}</a>
                        </li>
                        --}}
                        <li class="tab-title <%- typeof type !== 'undefined' && type == 'micontenido' ? 'active' : '' %>">
                            <a class="mdi mdi-school vcenter tab-icon-left" href="<%- Route.route('aprende.tipo', { 'type': 'micontenido'})%>" title="{{transtp('learn.type.mycontent')}}" aria-controls="micontenido">{{transtp('learn.type.mycontent')}}</a>
                        </li>
						@endif
                    </ul>
                </div>
            </div>
        </div>
		{{--Navbar responsive--}}
		<div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
			<div class="row collapse">
				<div class="small-12 columns">
					<dl class="sub-nav">
						<button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">Aprende<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
						<ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
							@if (App\RegistroSesion::getInstitutionSlug() == 'ninojesus')
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'bienestar' ? 'active' : '' %>">
									<a
										href="<%- Route.route('aprende.tipo', { 'type': 'bienestar'})%>"
										title="{{transtp('learn.type.bienestar')}}"
										aria-controls="courses">{{transtp('learn.type.bienestar')}}
									</a>
								</li>
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursosColaboradores' ? 'active' : '' %>">
									<a
										href="<%- Route.route('aprende.tipo', { 'type': 'cursosColaboradores'})%>"
										title="{{transtp('learn.type.coursesColaborators')}}"
										aria-controls="courses">{{transtp('learn.type.coursesColaborators')}}
									</a>
								</li>
							@endif
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursos' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'cursos'})%>" title="{{transtp('learn.type.courses')}}" aria-controls="courses">{{transtp('learn.type.courses')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'webinars' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'webinars'})%>" title="{{transtp('learn.type.webinars')}}" aria-controls="webinars">{{transtp('learn.type.webinars')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'conferencias' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'conferencias'})%>" title="{{transtp('learn.type.conferences')}}" aria-controls="conferencias">{{transtp('learn.type.conferences')}}</a>
							</li>
							@if(Auth::check())
								<!--<li class="tab-title <%- typeof type !== 'undefined' && type == 'certificados' ? 'active' : '' %>">
									<a href="<%- Route.route('aprende.tipo', { 'type': 'certificados'})%>" title="{{transtp('learn.type.certificates')}}" aria-controls="certificados">{{transtp('learn.type.certificates')}}</a>
								</li>-->
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'micontenido' ? 'active' : '' %>">
									<a class="mdi mdi-school vcenter tab-icon-left" href="<%- Route.route('aprende.tipo', { 'type': 'micontenido'})%>" title="{{transtp('learn.type.mycontent')}}" aria-controls="micontenido">{{transtp('learn.type.mycontent')}}</a>
								</li>
							@endif
						</ul>
					</dl>
				</div>
			</div>
		</div>
	</script>


	<script type="text/template" id="learn-navbar-button">
		{{-- Navbar desktop--}}
		<div id="learn-menu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
			<div class="row">
				<div class="small-12 columns">
					<ul id="learn-tabs-filter" class="learn-submenu-tabs tabs-sub-nav-alt tabs tabs-route text-right">
						<li class="tab-title left" id="button-hide" >
							<a href="<%- Route.route('aprende.cursos.index', { 'type': 'cursos'})%>" id="onback"><i class="mdi mdi-chevron-left">Volver</i></a>
						</li>
						@if (App\RegistroSesion::getInstitutionSlug() == 'ninojesus')
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'bienestar' ? 'active' : '' %>">
								<a
									href="<%- Route.route('aprende.tipo', { 'type': 'bienestar'})%>"
									title="{{transtp('learn.type.bienestar')}}"
									aria-controls="courses">{{transtp('learn.type.bienestar')}}
								</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'capacitacion' ? 'active' : '' %>">
								<a
									href="<%- Route.route('aprende.tipo', { 'type': 'cursosColaboradores'})%>"
									title="{{transtp('learn.type.coursesColaborators')}}"
									aria-controls="courses">{{transtp('learn.type.coursesColaborators')}}
								</a>
							</li>
						@endif
						<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursos' ? 'active' : '' %>">
							<a href="<%- Route.route('aprende.tipo', { 'type': 'cursos'})%>" title="{{transtp('learn.type.courses')}}" aria-controls="courses">{{transtp('learn.type.courses')}}</a>
						</li>
						@if (App\RegistroSesion::getInstitutionSlug() != 'propace')
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'webinars' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'webinars'})%>" title="{{transtp('learn.type.webinars')}}" aria-controls="webinars">{{transtp('learn.type.webinars')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'conferencias' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'conferencias'})%>" title="{{transtp('learn.type.conferences')}}" aria-controls="conferencias">{{transtp('learn.type.conferences')}}</a>
							</li>
						@endif
						@if(Auth::check())
							{{--
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'certificados' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'certificados'})%>" title="{{transtp('learn.type.certificates')}}" aria-controls="certificados">{{transtp('learn.type.certificates')}}</a>
							</li>
							--}}
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'micontenido' ? 'active' : '' %>">
								<a class="mdi mdi-school vcenter tab-icon-left" href="<%- Route.route('aprende.tipo', { 'type': 'micontenido'})%>" title="{{transtp('learn.type.mycontent')}}" aria-controls="micontenido">{{transtp('learn.type.mycontent')}}</a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		{{--Navbar responsive--}}
		<div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
			<div class="row collapse">
				<div class="small-12 columns">
					<dl class="sub-nav">
						<a href="<%- Route.route('aprende.cursos.index', { 'type': 'cursos'})%>" id="onback" class="button left"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter">Volver</i></a>
						<button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">Aprende<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
						<ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
							@if (App\RegistroSesion::getInstitutionSlug() == 'ninojesus')
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'bienestar' ? 'active' : '' %>">
									<a
										href="<%- Route.route('aprende.tipo', { 'type': 'bienestar'})%>"
										title="{{transtp('learn.type.bienestar')}}"
										aria-controls="courses">{{transtp('learn.type.bienestar')}}
									</a>
								</li>
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursosColaboradores' ? 'active' : '' %>">
									<a
										href="<%- Route.route('aprende.tipo', { 'type': 'cursosColaboradores'})%>"
										title="{{transtp('learn.type.coursesColaborators')}}"
										aria-controls="courses">{{transtp('learn.type.coursesColaborators')}}
									</a>
								</li>
							@endif
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'cursos' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'cursos'})%>" title="{{transtp('learn.type.courses')}}" aria-controls="courses">{{transtp('learn.type.courses')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'webinars' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'webinars'})%>" title="{{transtp('learn.type.webinars')}}" aria-controls="webinars">{{transtp('learn.type.webinars')}}</a>
							</li>
							<li class="tab-title <%- typeof type !== 'undefined' && type == 'conferencias' ? 'active' : '' %>">
								<a href="<%- Route.route('aprende.tipo', { 'type': 'conferencias'})%>" title="{{transtp('learn.type.conferences')}}" aria-controls="conferencias">{{transtp('learn.type.conferences')}}</a>
							</li>
							@if(Auth::check())
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'certificados' ? 'active' : '' %>">
									<a href="<%- Route.route('aprende.tipo', { 'type': 'certificados'})%>" title="{{transtp('learn.type.certificates')}}" aria-controls="certificados">{{transtp('learn.type.certificates')}}</a>
								</li>
								<li class="tab-title <%- typeof type !== 'undefined' && type == 'micontenido' ? 'active' : '' %>">
									<a class="mdi mdi-school vcenter tab-icon-left" href="<%- Route.route('aprende.tipo', { 'type': 'micontenido'})%>" title="{{transtp('learn.type.mycontent')}}" aria-controls="micontenido">{{transtp('learn.type.mycontent')}}</a>
								</li>
							@endif
						</ul>
					</dl>
				</div>
			</div>
		</div>
	</script>

    {{-- course content main template --}}
	<script type="text/template" id="course-main-tpl">
		<div id="learn-content-main">
			<div id="learn-inner-content" class="section-inner-content">
				<div class="row mobile-collapse tablet-uncollapse">
					<div class="small-12 columns">
						<div class="fx-main-content">
							<div class="fx-col-content">
								<div class="tabs-content section-content-learn">
								{{-- courses Colaboradores--}}
									<section
										id="content-section-courses-colaborators"
										class="content <%- $.inArray(type,['cursosColaboradores']) != -1 ? 'active' : '' %>"
									>
									 	<div class="row">
											{{-- course content main filters --}}
											<div class="large-2 mobile-12 columns filters"><br>
												<form action="" id="form-filter-courses" name="form-filter-courses">
													<label>{{ transtp('learn.filter.title') }}</label><br><br>
													<input id="payment-courses-colaborators" type="checkbox">
													<label for="payment-courses-colaborators">{{ transtp('learn.payment') }}</label>
													<br><br>
													<input id="free-courses-colaborators" type="checkbox">
													<label for="free-courses-colaborators">{{ transtp('learn.free') }}</label>
												</form>
												<br>
											</div>

											{{-- course content main items --}}
											<div class="medium-12 large-7 columns">
												<div id="contentnav-course-list" class="content-data-list">
													@include('public.noresults', ['message' => 'No hay resultados'])
													<ul id='browse-list-courses-colaborators' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
														<!-- Render courses list -->
													</ul>
												</div>
											</div>
											{{-- course content main noted items --}}
											<div class="mobile-3 columns show-for-large-up">
												<div id="contentnav-noted-list" class="content-data-list">
													<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text">
														<i class="mdi mdi-star mdi-24 gray-light vtop"></i>
														<span class="bold-text black-text text-md vtop title-panel-list">{{ transtp('learn.relevantcourses')}}</span>
													</h6>
													<ul id='course-content-noted-courses-colaborators' class="browse-list-learn browse-list-mask responsive-browse">
														<!-- Render courses list -->
													</ul>
												<div>
											</div>
										</div>
									</section>

									{{-- Facilitadores bienestar--}}
									<section
										id="content-section-courses-bienestar"
										class="content <%- $.inArray(type,['bienestar']) != -1 ? 'active' : '' %>"
									>
									 	<div class="row">
											{{-- course content main filters --}}
											<div class="large-2 mobile-12 columns filters"><br>
												<form action="" id="form-filter-courses" name="form-filter-courses">
													<label>{{ transtp('learn.filter.title') }}</label><br><br>
													<input id="payment-courses-bienestar" type="checkbox">
													<label for="payment-courses-bienestar">{{ transtp('learn.payment') }}</label>
													<br><br>
													<input id="free-courses-bienestar" type="checkbox">
													<label for="free-courses-bienestar">{{ transtp('learn.free') }}</label>
												</form>
												<br>
											</div>

											{{-- course content main items --}}
											<div class="medium-12 large-7 columns">
												<div id="contentnav-course-list" class="content-data-list">
													@include('public.noresults', ['message' => 'No hay resultados'])
													<ul id='browse-list-courses-bienestar' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
														<!-- Render courses list -->
													</ul>
												</div>
											</div>
											{{-- course content main noted items --}}
											<div class="mobile-3 columns show-for-large-up">
												<div id="contentnav-noted-list" class="content-data-list">
													<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text">
														<i class="mdi mdi-star mdi-24 gray-light vtop"></i>
														<span class="bold-text black-text text-md vtop title-panel-list">{{ transtp('learn.relevantcourses')}}</span>
													</h6>
													<ul id='course-content-noted-courses-bienestar' class="browse-list-learn browse-list-mask responsive-browse">
														<!-- Render courses list -->
													</ul>
												<div>
											</div>
										</div>
									</section>
									{{-- End Facilitadores bienestar --}}

									{{-- courses --}}
									<section  id="content-section-courses" class="content <%- $.inArray(type,['cursos']) != -1 ? 'active' : '' %>" >
										<div class="row">
											{{-- course content main filters --}}
											<div class="large-2 mobile-12 columns filters"><br>
												<form action="" id="form-filter-courses" name="form-filter-courses">
													<label>{{ transtp('learn.filter.title') }}</label><br><br>
													<input id="payment-courses" type="checkbox"><label for="payment-courses">{{ transtp('learn.payment') }}</label><br><br>
													<input id="free-courses" type="checkbox"><label for="free-courses">{{ transtp('learn.free') }}</label><br><br>
													<label for="name-courses">{{ transtp('learn.name') }}</label><input id="name-courses" type="text">
												</form>
												<br>
												{{-- @if (isset($certificate))
													@if ($certificate)
														@if ( $url )
															<a class="mdi mdi-download" href="https://comunidadpropace.com/convocatoria/test-de-zarit-2'" title="Test zarit 2">Test de Zarit 2</a>
														@else
															<a class="mdi mdi-download course-certificate-total" href="" title="Descargar">Descarga tu certificado</a>
														@endif
													@endif
												@endif --}}
											</div>

											{{-- course content main items --}}
											<div class="medium-12 large-7 columns">
												<div id="contentnav-course-list" class="content-data-list">
													@include('public.noresults', ['message' => 'No hay resultados'])
													<ul id='browse-list-courses' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
														<!-- Render courses list -->
													</ul>
												</div>
											</div>
											{{-- course content main noted items --}}
											<div class="mobile-3 columns show-for-large-up">
												<div id="contentnav-noted-list" class="content-data-list">
													<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text">
														<i class="mdi mdi-star mdi-24 gray-light vtop"></i>
														<span class="bold-text black-text text-md vtop title-panel-list">{{ transtp('learn.relevantcourses')}}</span>
													</h6>
													<ul id='course-content-noted-courses' class="browse-list-learn browse-list-mask responsive-browse">
														<!-- Render courses list -->
													</ul>
												<div>
											</div>
										</div>
									</section>
									{{-- webinars --}}
									<section  id="content-section-webinars" class="content <%- $.inArray(type,['webinars']) != -1 ? 'active' : '' %>">
										<div class="row">
											{{-- webinars content main filters --}}
											<div class="large-2 mobile-12 columns filters"><br>
												<form action="" id="form-filter-courses" name="form-filter-courses">
													<label>{{ transtp('learn.filter.title') }}</label><br><br>
													<input id="payment-webinars" type="checkbox"><label for="payment-webinars">{{ transtp('learn.payment') }}</label><br><br>
													<input id="free-webinars" type="checkbox"><label for="free-webinars">{{ transtp('learn.free') }}</label><br><br>
												</form>
											</div>
											{{-- webinars content main items --}}
											<div class="medium-12 large-7 columns">
												<div id="contentnav-course-list" class="content-data-list">
													@include('public.noresults', ['message' => 'No hay resultados'])
													<ul id='browse-list-webinars' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
														<!-- Render courses list -->
													</ul>
												</div>
											</div>
											{{-- webinars content main noted items --}}
											<div class="mobile-3 columns show-for-large-up">
												<div id="contentnav-noted-list" class="content-data-list">
													<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text">
														<i class="mdi mdi-star mdi-24 gray-light vtop"></i>
														<span class="bold-text black-text text-md vtop title-panel-list">Webinars destacados</span>
													</h6>
													<ul id='course-content-noted-webinars' class="browse-list-learn browse-list-mask responsive-browse">
														<!-- Render courses list -->
													</ul>
												<div>
											</div>
										</div>
									</section>
									{{-- lectures --}}
									<section  id="content-section-lectures" class="content <%- $.inArray(type,['conferencias']) != -1 ? 'active' : '' %>">
										<div class="row">
											{{-- lectures content main filters --}}
											<div class="large-2 mobile-12 columns filters"><br>
												<form action="" id="form-filter-courses" name="form-filter-courses">
													<label>{{ transtp('learn.filter.title') }}</label><br><br>
													<input id="payment-lectures" type="checkbox"><label for="payment-lectures">{{ transtp('learn.payment') }}</label><br><br>
													<input id="free-lectures" type="checkbox"><label for="free-lectures">{{ transtp('learn.free') }}</label><br><br>
												</form>
											</div>
											{{-- lectures content main items --}}
											<div class="medium-12 large-7 columns">
												<div id="contentnav-course-list" class="content-data-list">
													@include('public.noresults', ['message' => 'No hay resultados'])
													<ul id='browse-list-conferencias' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
														<!-- Render courses list -->
													</ul>
												</div>
											</div>
											{{-- lectures content main noted items --}}
											<div class="mobile-3 columns show-for-large-up">
												<div id="contentnav-noted-list" class="content-data-list">
													<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text">
														<i class="mdi mdi-star mdi-24 gray-light vtop"></i>
														<span class="bold-text black-text text-md vtop title-panel-list">{{transtp('learn.desc.conferences')}}</span>
													</h6>
													<ul id='course-content-noted-lectures' class="browse-list-learn browse-list-mask responsive-browse">
														<!-- Render courses list -->
													</ul>
												<div>
											</div>
										</div>
									</section>
									{{-- mycontent --}}
									@if(Auth::check())
										<section id="content-section-mycourses" class="content <%- $.inArray(type,['micontenido']) != -1 ? 'active' : '' %>" >
											<div class="row">
												{{-- mycontent content main filters --}}
												<div class="large-2 mobile-12 columns filters"><br>
													<form action="" id="form-filter-courses" name="form-filter-courses">
														<label>Precio</label><br><br>
														<input id="payment-mycourses" type="checkbox"><label for="payment-mycourses">{{ transtp('learn.payment') }}</label><br><br>
														<input id="free-mycourses" type="checkbox"><label for="free-mycourses">{{ transtp('learn.free') }}</label><br><br>
													</form>
												</div>
												{{-- mycontent content main items --}}
												<div class="medium-12 large-8 columns left">
													<div id="contentnav-course-list" class="content-data-list">
														@include('public.noresults', ['message' => 'No hay resultados'])
														<ul id='browse-list-mycourses' class="browse-list-learn browse-list-mask browse-list-courses responsive-browse">
															<!-- Render courses list -->
														</ul>
													</div>
												</div>
											</div>
										</section>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	{{-- item Course Browse list Template --}}
	<script type="text/template" id="browse-course-item-tpl">
        <div class="row col-equal-height">
            <div class="mobile-4 columns">
                <% if(codigo_orientacion_curso === window.Misc.getOrientation('external')) { %>
                    <a href="<%- url_externa_curso %>" title="<%- nombre_curso %>" target="_blank" class="mask-thumb">
                        <img src="<%- imagen_curso %>" alt="<%- nombre_curso %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_project_image') }}')" />
                    </a>
                <% }else{ %>
                    <a href="<%= window.Misc.urlFull( Route.route( inscripcion ? 'aprende.contenido' : 'aprende.categoria.curso', {'type': url_tipo_curso, 'category': url_categoria_curso, 'course': url_curso})) %>" title="<%- nombre_curso %>" class="mask-thumb">
                        <img src="<%= imagen_curso %>" alt="<%= nombre_curso %>">
                    </a>
                <% } %>
            </div>
            <div class="mobile-8 columns">
                <div class="content-item-list text-left">
                    <h5 class="title-item-list black-text ellipsis">
                        <% if(codigo_orientacion_curso === window.Misc.getOrientation('external')) { %>
                            <a  href="<%- url_externa_curso %>" title="<%- nombre_curso %>" target="_blank"><%- nombre_curso %></a>
                        <% }else{ %>
                            <a  href="<%= window.Misc.urlFull( Route.route( inscripcion ? 'aprende.contenido' : 'aprende.categoria.curso', {'type': url_tipo_curso, 'category': url_categoria_curso, 'course': url_curso})) %>"><%- nombre_curso %></a>
                        <% } %>
                    </h5>
                    <p class="text-xmd description-list-item gray-dark-text ellipsis is-truncated show-for-tablet-up"><%- descripcion_curso %></p>
                    <p class="text-xmd category-list-item bold-text light-text ellipsis is-truncated"><%- nombre_categoria_curso %></p>
                    <div class="bottom-item-list no-border">
                        <div class="foot-info-mask">
                            <% if( curso_gratis ) { %><span class="text-md dark-text">{{ transtp('learn.freecourse') }}</span><% } %>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</script>
	<script type="text/template" id="browse-course-noted">
		<div class="row col-equal-height">
			<div class="mobile-6 columns">
				<% if(codigo_orientacion_curso === window.Misc.getOrientation('external')) { %>
				<a href="<%- url_externa_curso %>" title="<%- nombre_curso %>" target="_blank" class="mask-thumb-noted">
					<img src="<%- imagen_curso %>" alt="<%- nombre_curso %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_project_image') }}')" />
				</a>
				<% }else{ %>
				<a href="<%= Route.route( inscripcion ? 'aprende.contenido' : 'aprende.categoria.curso' , { 'type': url_tipo_curso, 'category': url_categoria_curso, 'course': url_curso }) %>" title="<%- nombre_curso %>" class="mask-thumb-noted">
					<img src="<%= imagen_curso %>" alt="<%= nombre_curso %>">
				</a>
				<% } %>
			</div>
			<div class="mobile-6 columns">
				<div class="content-item-list text-left">
					<h5 class="text-xmd">
						<% if(codigo_orientacion_curso === window.Misc.getOrientation('external')) { %>
						<a href="<%- url_externa_curso %>" title="<%- nombre_curso %>" target="_blank"><%- nombre_curso %></a>

						<% }else{ %>
						<a href="<%= Route.route(inscripcion ? 'aprende.contenido' : 'aprende.categoria.curso', {'type': url_tipo_curso, 'category': url_categoria_curso, 'course': url_curso}) %>"><%- nombre_curso %></a>
						<% } %>
					</h5>
					<p class="text-xsm category-list-item bold-text light-text ellipsis is-truncated"><%- nombre_categoria_curso %></p>
				</div>
			</div>
		</div>
	</script>
	{{-- Section Detail Course --}}
	<script type="text/template" id="course-detail-tpl">
		<div class="top-detail-course">
			<div class="row">
				<div class="small-12 columns">
					<div class="row">
						<br>
						<div class="medium-6 columns">
							<div class="row">
								<div class="large-12 columns">
									<div class="det-course-img-wrapper">
										<img src="<%- imagen_curso %>" alt="<%- nombre_curso %>"  title="<%- nombre_curso %>" />
									</div>
								</div>
								<br><br>


								<div class="large-12 columns">
									<div class="registered-students">
									<span class="text-xmd">
										<% if(contador_inscritos > 0){ %>
											<a href="#"><%- contador_inscritos %> personas</a> inscritas en este curso
										<% }else{ %>
											<a href="#">0 personas</a> inscritas en este curso
										<% } %>
										<ul class="mobile-text-center medium-text-right program-icons-shared social-box-icons right">
										<li>
											<ul id="drop-shared-social-program" class="drop-shared-social-program friendship-dropdown no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
												<li class="text-center">
													<label class="label single gray-base-text">Compartir en redes:</label>
													<ul class="inline-list-grid align-top">
														<li class="text-center">
															<a href="" title="Compartir en facebook" class="tp_facebook_share">
																<i class="mdi mdi-facebook mdi-21 facebook"></i>
															</a>
														</li>
														<li class="text-center">
															<a href="" title="Compartir en linkedin" class="tp_linkedin_share">
																<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
															</a>
														</li>
														<li class="text-center">
															<a href="" title="Compartir en X" class="">
																<i class="mdi mdi-close-outline mdi-21 twitter"></i>
															</a>
														</li>
													</ul>
												</li>
											</ul>
											<a title="Compartir" data-dropdown="drop-shared-social-program" aria-controls="drop-shared-social-program" data-options="align:bottom;is_hover:false;hover_timeout:500">
												<i class="mdi mdi-share-variant mdi-21"></i>
											</a>
										</li>
										<li>
											<ul id="drop-liked-program" class="post-social-shared program-shared-list clearfix md-dropdown drop-strip radius show-for-large-up" data-dropdown-content>
												<li>
														<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_likes %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
												</li>
											</ul>
											<a class="data-post-share 1 no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-program" aria-controls="drop-liked-program" data-options="align:top;is_hover:true;hover_timeout:500">
												<i class="mdi mdi-thumb-up-outline mdi-21"></i>
												<span class="data-count-likes text-xmd"><%- contador_likes %></span>
											</a>
										</li>
									</ul>
									</span>
									</div>
								</div>
								<div class="large-12 columns show-for-medium-up">
									<strong>Descripción</strong><br><br>
									<p><%- descripcion_curso %></p>
								</div>
							</div>
						</div>
						<div class="large-6 columns">
							<h2 class="title-course-main bold-header"><%- nombre_curso %></h2>
							<strong><%- nombre_categoria_curso%></strong>
							<hr>
							<% if(curso_gratis) { %>
								<span class="course-price text-md dark-text">{{ transtp('learn.freecourse') }}</span>
							<% }else{ %>
								<span class="course-price text-md dark-text"><%- precio_curso != null && precio_curso != '' ? '$' + precio_curso : '' %></span>
							<% } %>

							@if(Auth::check())
								<div class="registered-user">
									<% if(inscripcion){ %>
										<i class="mdi mdi-21 mdi-check success"></i>
										<span class="text-xmd">
											Ya estás tomando este curso
											<span class="vertical-separator">&VerticalSeparator;</span>
										</span>
									<% } %>
									<% if(inscripcion){ %>
										<span class="text-xmd">Si quieres dejar de tomar este curso haz clic <a href="#" class="on-unsubscribe-course">aquí</a></span>
									<% } %>
								</div>
							@endif

							<% if(inscripcion){ %>
								<a href="<%- Route.route('aprende.contenido', { 'type': type, 'category': url_categoria_curso, 'course': url_curso }) %>" class="button sky-blue radius xmedium">Ir al curso</a>
							<% }else{ %>
								@if(!in_array(App\Institucion::getInstitution('redcoo'), [App\RegistroSesion::getInstitution()]))

									<a href="<%- window.Misc.urlFull( Route.route('aprende.contenido', { 'type': type, 'category': url_categoria_curso, 'course': url_curso }) ) %>" class="button sky-blue radius large-12 {{ Auth::check() ? 'register-course' : '' }}">{{ transtp('learn.inscription') }}</a>
								<br><br>
								@else
									<% if(curso_gratis) { %>
										<a href="<%- window.Misc.urlFull( Route.route('aprende.contenido', { 'type': type, 'category': url_categoria_curso, 'course': url_curso }) ) %>" class="button sky-blue radius xmedium register-course">{{ transtp('learn.inscription') }}</a>
									<% }else{ %>
										<a href="<%- window.Misc.urlFull( Route.route('aprende.contenido', { 'type': type, 'category': url_categoria_curso, 'course': url_curso }) ) %>" class="button sky-blue expand radius xmedium {{ Auth::check() && Auth::user()->hasRole('asociado') ? 'register-course' : '' }}">{{ transtp('learn.inscription') }}</a>
									<% } %>
								@endif
							<% } %>
							<div class="content-datail-course">
								<div class="wrapper-themes-course">
									{{--<button class="button sky-blue radius xmedium" href="#"><i class="mdi mdi-school"></i>&nbsp;Tomar evaluación de este curso</button>
									<br><br>--}}
									<h6 class="dark-text">Temas del curso</h6><br>
									<dl class="themes-course accordion-theme-alt ordering" data-accordion>
									<input id="subscription-validate" type="hidden" value="<%- inscripcion %>">
										{{-- Render course themes list --}}
									</dl>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	{{-- Item detail course theme list --}}
	<script type="text/template" id="course-themes-list-tpl">
		<% if(subscrition == "true"){%>
			<a href="#course-theme-<%- codigo_tema_curso %>"><%= nombre_tema_curso %></a>
		<% }else{ %>
		<br>
			<strong style="margin:1.2rem;"><%= nombre_tema_curso %></strong>
		<% } %>
		<p class="block-text-xmedium description-course-theme light-tex"><%= objetivo_tema_curso %></p>
		<% if(subscrition == "true"){%>
			<div id="course-theme-<%- codigo_tema_curso %>" class="content-theme">
				<ul class="attached-list-themes">
					<% _.each(adjuntos, function(adjunto) { %>
					<li>
						<% if( window.Misc.codInDoc(adjunto.codigo_tipo_adjunto) != -1 ) { %>
						<a href="<%= adjunto.direccion_adjunto %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="mdi mdi-paperclip vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<% if(adjunto.state_review){ %>
						<span class="right icon-circle tiny state-attached-theme change-viewed <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
						<% } %>
						<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['link']) { %>
						<a href="<%=  adjunto.direccion_adjunto %>" title="<%= nombre_tema_curso %>" target="_blank" class="left link-attached-theme link-to-theme-article" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[1]%> vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>

						<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-survey link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>

						{{-- <% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['ext_survey']) { %>
							<a href="<%= window.Misc.urlFull( Route.route('aprende.curso.tema.formulario',{'type': type, 'category': url_categoria_curso, 'course': url_curso, 'survey': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) ) %>" title="<%= nombre_tema_curso %>" target="_blank" class="left link-attached-theme link-to-theme-survey" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
								<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop"></i></span>
								<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
							</a>
							<span class="right icon-circle tiny state-attached-survey state-attached-theme  change-viewed <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span> --}}
						<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['html']) { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-article link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<% }else { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<% } %>
					</li>
					<% }); %>
				</ul>
			</div>
		<% } %>
	</script>

	{{-- Content Course response --}}
	<script type="text/template" id="course-contentcourse-tpl">
		<div class="wrapper-content-course">
			<div class="row">
				<div class="medium-12 columns">
					<h2 class="title-course-main"><%- nombre_curso %></h2>
					<strong class="subtitle-course-main"><%- nombre_categoria_curso %></strong><br><br>
					<p class="description-course-main">
					<%- descripcion_curso %>
					</p>

				</div>
			</div>

			<div class="row">
				<div class="tablet-6 columns">
					<div class="panel-info panel-progress-course">
						<div id="progress-course" class="progress-tooltip small-12 sky-blue radius" data-value-progress="<%- porcentaje_progreso %>">
							<span class="meter has-tip tip-top radius" style="width: <%= porcentaje_progreso %>%" data-tooltip aria-haspopup="true" title="<%= porcentaje_progreso %>% Completado" data-options="disable_for_touch:true;append_to:#progress-course>.meter"></span>
						</div>
					</div>
					<div class="content-themes-course">
						<dl class="themes-course accordion-theme-alt ordering" data-accordion>
							<!-- Render course themes list -->
						</dl>
					</div>
					<div class="panel panel-unsubscribe">
						@if(Auth::check())
							<% if(inscripcion){ %>
								<span class="text-xmd">Si quieres dejar de tomar este curso haz clic <a href="#" class="on-unsubscribe-course">aquí &nbsp;<i class="mdi mdi-logout vcenter mdi-24 sky-blue"></i></a></span>
							<% } %>
						@endif
					</div>
				</div>
				<div class="tablet-6 columns">
					<div class="course-interactive-nav radius with-title">
						<ul class="nav-interactive title-panel" data-tab>
							<li class="tab-title active text-center">
								<a href="#wrapper-course-discussion">{{ transtp('learn.sidecourse.discussion.title')}}</a>
							</li>
							<li class="tab-title text-center">
								<a href="#side-course-students">{{ transtp('learn.sidecourse.students.title')}}</a>
							</li>
							<li class="tab-title text-center">
								<a href="#side-course-developer">{{ transtp('learn.sidecourse.developer.title')}}</a>
							</li>

							<% if( certificado_curso) { %>
								<% if( porcentaje_progreso === 100 ) { %>
								<li class="tab-title text-center">
									<a href="#side-course-certificate">{{ transtp('learn.sidecourse.certificate.title')}}</a>
								</li>
								<% } %>
							<% } %>
							<li class="tab-title spacing show-only-for-medium-up">
							</li>
						</ul>
						<div class="tabs-content">
							<div class="content active" id="wrapper-course-discussion">
								{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-course') ) !!}
									<div class="textarea-post-discussion main-comment clearfix">
										<textarea placeholder="Comenta aquí" required name="texto_discucion" id="texto_discucion" cols="50" rows="2" class="wysiwyg-single materialize-textarea validate"></textarea>
										<button class="button tiny sky-blue radius btn-lowerc" type="submit">Comentar</button>
									</div>
									<input type="hidden" name="codigo_curso" value="<%= codigo_curso %>" />
								{!! Form::close() !!}
								@include('public.noresults', ['message' => 'No hay discusiones'])
								<section id="discussion-posts-wrap" class="">
									{{-- Render discussions template --}}
								</section>
							</div>
							<div class="content" id="side-course-students">
								@include('public.noresults')
								<ul id="students-course-wrap" class="list-separator list-ordering no-bullet">
									{{-- Render Tasks template --}}
								</ul>
							</div>
							<div class="content" id="side-course-certificate">
								<div class="sponsors-course">
									<ul class="list-separator list-ordering list-sponsors-course">
										<li>
											<ul class="inline-list-grid align-center">
												<li class="text-left">
													<a class="mdi mdi-download course-certificate" href="" title="Descargar"> Descarga tu certificado aquí </a>
												</li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
							<div class="content" id="side-course-developer">
								<% if(organizadores.length) { %>
									<div class="sponsors-course">
										<ul class="list-separator list-ordering list-sponsors-course">
											<% _.each(organizadores, function(sponsor) { %>
												<li>
													<ul class="inline-list-grid align-center">
														<li class="text-left">
															<% if (!_.isUndefined(sponsor.url_patrocinador) && !_.isNull(sponsor.url_patrocinador) && sponsor.url_patrocinador.length) { %>
																<a href="<%- sponsor.url_patrocinador %>" title="<%- sponsor.nombre_patrocinador %>" target="_blank">
																	<img src="<%- sponsor.imagen_patrocinador %>" alt="<%- sponsor.nombre_patrocinador %>">
																</a>
															<% }else{ %>
																<img src="<%- sponsor.imagen_patrocinador %>" alt="<%- sponsor.nombre_patrocinador %>" title="<%- sponsor.nombre_patrocinador %>">
															<% } %>
														</li>
														<li class="text-right">
															<% if (!_.isUndefined(sponsor.url_patrocinador) && !_.isNull(sponsor.url_patrocinador) && sponsor.url_patrocinador.length) { %>
																<a href="<%- sponsor.url_patrocinador %>" target="_blank" class="text-md" ><%- sponsor.nombre_patrocinador %></a>
															<% }else {%>
																<span class="text-md"><%- sponsor.nombre_patrocinador %></span>
															<% } %>
														</li>
													</ul>
												</li>
											<% }); %>
										</ul>
									</div>
								<% } %>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Item course theme list --}}
	<script type="text/template" id="course-theme-item-list-tpl">
		<a href="#course-theme-<%- codigo_tema_curso %>"><%= nombre_tema_curso %></a>
		<div id="course-theme-<%- codigo_tema_curso %>" class="content-theme">
			<p class="block-text-xmedium description-course-theme"><%= objetivo_tema_curso %></p>
			<ul class="attached-list-theme">
				<% _.each(adjuntos, function(adjunto)
				{
				%>
				<li>
					<% if( window.Misc.codInDoc(adjunto.codigo_tipo_adjunto) > -1 ) { %>
					<a
						href="<%= adjunto.direccion_adjunto %>"
						title="<%= nombre_tema_curso %>"
						target="_blank"
						class="left link-attached-theme link-to-theme-article"
						data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
						<span class="thumb-icon"><i class="mdi mdi-paperclip vtop"></i></span>
						<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
					</a>
					<% if(adjunto.state_review){ %>
							<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
					<% } %>
					<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['link']) { %>
						<a href="<%=  adjunto.direccion_adjunto %>" title="<%= nombre_tema_curso %>" target="_blank" class="left link-attached-theme link-to-theme-article" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>" >
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[1]%> vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
							<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
                     <% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) { %>

						<% if(log_biofacial){ %>

							<a
							href="javascript:void(0)"
							title="<%= nombre_tema_curso %>"
							title="<%= nombre_tema_curso %>"
							class="left link-attached-theme link-to-theme-survey link-to-theme-video"
							data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>"
							onClick="decodeBio('<%= Route.route('aprende.curso.biometric', {'uri': ''}) %>', '<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>')"
							>
								<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop""></i></span>
								<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
							</a>
							<span class="right icon-circle tiny state-attached-survey state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
						<% } else { %>

							<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-survey link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
								<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop""></i></span>
								<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
							</a>
							<span class="right icon-circle tiny state-attached-survey state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>

						<% } %>
					<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['html']) { %>

						<% if(log_biofacial){ %>
							<a
							href="javascript:void(0)"
							title="<%= nombre_tema_curso %>"
							class="left link-attached-theme link-to-theme-article link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>"
							onClick="decodeBio('<%= Route.route('aprende.curso.biometric', {'uri': ''}) %>', '<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>')"
							>
								<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
								<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
							</a>
							<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
						<% }else{ %>
							<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-article link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>" data-test="<%- log_curso %>" >
								<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
								<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
							</a>
							<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
						<% } %>
						<% }else{ %>
							<% if(log_biofacial){ %>

								<a
									id='bioLink'
									href="javascript:void(0)"
									title="<%= nombre_tema_curso %>"
									class="left link-attached-theme link-to-theme-video"

									onClick="decodeBio('<%= Route.route('aprende.curso.biometric', {'uri': ''}) %>', '<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>')"

									data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>"
									data-biometric-url="<%= Route.route('aprende.curso.biometric', {'uri': ''}) %>"
									data-decoded-url="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>"
								>
									<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[1]%> vtop"></i></span>
									<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
								</a>
							<% }else{ %>

								<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>"  title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">

									<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[1]%> vtop"></i></span>
									<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
								</a>
							<% } %>


						<% if(adjunto.state_review){ %>
							<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %> disabled"><i class="mdi mdi-check"></i></span>
						<% } %>
					<% } %>
				</li>
				<% }); %>
			</ul>
		</div>
	</script>

	<script>
		function decodeBio(url, second){
			console.log(url);
			console.log(second)
			// Define the string
			var string = 'Hello World!';
			// Eliminar ?uri= de la URL biometricUrl
			url = url.replace('?uri=', '');

			// Encode the String
			var encodedString = btoa(second);
			console.log(encodedString); // Outputs: "SGVsbG8gV29ybGQh"
			var baseUrl = window.location.origin;
			console.log(baseUrl)
			window.location = baseUrl  + url + encodedString

			// Decode the String
			var decodedString = atob(encodedString);
			console.log(decodedString); // Outputs: "Hello World!"
		}
	</script>
	{{-- section Confirm Unsubscribe --}}
	<script type="text/template" id="course-confirm-unsubscribe-tpl">
		<p>{{ Lang::get('learn.unsubscribe.confirm') }}</p>
	</script>
	{{-- Themes Course response --}}
	<script type="text/template" id="course-course-theme-lecture-tpl">
		<!-- Modal HTML -->
		<div id="modal-log-cursos" class="modal-log-cursos" style="display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5);">
			<div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 400px; border-radius: 10px; text-align: center;">
				<span class="close-button" style="color: #aaa; float: right; font-size: 28px; font-weight: bold;">&times;</span>
				<p id="modal-message">Usted ha incumplido la norma del cambio de ventana.</p>
				<button id="modal-ok-button" class="modal-ok-button" style="background-color: #f44336; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;">OK</button>
			</div>
		</div>

		<div id="lecture-course" class="">
			<div class="course-lecture-main large-9 columns">
				<h4 id="title-lecture-main">
					{{-- Render Theme Name--}}
				</h4>
				<p id="description-lecture-main">
					{{-- Render Theme Name--}}
				</p>
				<div id="course-lecture-video" class="">
					{{-- Render course lecture video--}}
				</div>
				<div class="bottom-lecture-player">
					<div class="row">
						<div class="mobile-6 columns">
							<ul class="left inline-list-items controls-lecture">
								<li>
									<a href="#" title="Vover atras" class="btn-control-lecture prev-video">
										<i class="mdi mdi-skip-previous vcenter"></i>
										Clase anterior
									</a>
								</li>
							</ul>
						</div>
						<div class="mobile-6 columns">
							<ul class="right inline-list-items controls-lecture">
								<li>
									<a href="#" title="Vover atras" class="btn-control-lecture next-video">
										Siguiente clase
										<i class="mdi mdi-skip-next vcenter"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div id="sidemenu-course-lecture" class="sidemenu-course-lecture large-3 columns right">
				<a href="#" class="hide-fx-right-btn">
					<i class="side-nav-arrow"></i>
				</a>
				<ul class="tabs-sidemenu" data-tab id="container-tab-main">
					<li class="tab-title large-1 disabled" style="height: 4.45rem">
						<a href="#" ></a>
					</li>
					<li class="tab-title active large-2">
						<a href="#side-course-themes" class="middle"><i class="mdi mdi-book-open-variant mdi-24px sky-blue-text tab-aprende"></i></a>
					</li>
					<li class="tab-title large-2">
						<a href="#side-course-attachments" class="middle"><i class="mdi mdi-link mdi-24px sky-blue-text tab-aprende"></i></a>
					</li>
					<li class="tab-title large-2">
						<a href="#wrapper-lecture-discussion" class="middle"><i class="mdi mdi-comment-multiple-outline mdi-24px sky-blue-text tab-aprende"></i></a>
					</li>
					<li class="tab-title large-2">
						<a href="#side-course-notes" class="middle"><i class="mdi mdi-pin mdi-24px sky-blue-text tab-aprende"></i></a>
					</li>
					<li class="tab-title large-3 disabled" style="height: 4.45rem">
						<a href="#" ></a>
					</li>
				</ul>
				<div class="tabs-content">
					<div class="content active" id="side-course-themes">
						<dl class="themes-course accordion-theme-alt ordering" data-accordion>
							{{-- Render course themes list --}}
						</dl>
					</div>
					<% if(log_curso){ %>
						<br>
						<div class="alert-message" id="alert-message">
							<p style="color: #ff0000; text-align: center">
								¡Mientras esté en el curso no puede cambiar de ventana!
							</p>
						</div>
					<% } %>
					<div class="content" id="side-course-attachments">
						@include('public.noresults', ['message' => 'No hay archivos disponibles para descargar'])
						<ul id="course-attachments-wrap" class="list-separator list-ordering light-text no-bullet">
							{{-- Render Attachments template --}}
						</ul>
					</div>
					<div class="content" id="side-course-notes">
						{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-note-course') ) !!}
							<div class="wrap-field-comment clearfix">
								<textarea placeholder="Escribe una nueva nota aquí" required="required" name="texto_nota_usuario" id="texto_nota_usuario" cols="50" rows="2" class="validate">
								</textarea>
								<label data-error="El campo esta vació o tiene muy pocos caracteres"></label>
								{{-- <button class="right button tiny sky-blue radius btn-lowerc" type="submit">Guardar</button> --}}
							</div>
							<input type="hidden" name="codigo_curso" value="<%= codigo_curso %>" />
						{!! Form::close() !!}
						<ul id="notes-posts-wrap" class="list-separator list-ordering no-bullet">
							{{-- Render Tasks template --}}
						</ul>
					</div>
					<div class="content" id="wrapper-lecture-discussion">
						{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-course') ) !!}
							<div class="textarea-post-discussion clearfix">
								<textarea placeholder="Comenta sobre el curso" required="required" name="texto_discucion" id="texto_discucion" cols="50" rows="3" pattern="max_char_textarea" class="wysiwyg-single">
								</textarea>
								<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
							</div>
							<input type="hidden" name="codigo_curso" value="<%= codigo_curso %>" />
						{!! Form::close() !!}
						@include('public.noresults', ['message' => 'No hay discusiones'])
						<section id="discussion-posts-wrap" class="">
							{{-- Render Tasks template --}}
						</section>
					</div>
				</div>
			</div>
		</div>
	</script>
	{{-- Player for course lecture --}}
	<script type="text/template" id="course-lecture-video-tpl">
		<% if(codigo_tipo_adjunto == window._tp.getTypeAttached['flash'] || codigo_tipo_adjunto == window._tp.getTypeAttached['html'] || codigo_tipo_adjunto == window._tp.getTypeAttached['imagen'] ) {  %>
			<iframe id="player-video-lecture" src="<%- src %>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="display:block; width: 100%; height: 600px"></iframe>
        <% }else if(codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) { %>
            <iframe id="player-video-lecture" src="<%- src %>?iframe=1" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="display:block; width: 100%; height: 700px;"></iframe>
		<% }else if(codigo_tipo_adjunto == window._tp.getTypeAttached['youtube']) { %>
			<video id="player-video-lecture" class="{{-- mejs-player --}}" controls preload="auto" style="width: 100%;height: 100%;">
				<source type="video/youtube" src="<%- src %>" />
				<object class="" type="application/x-shockwave-flash"
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
		<% }else if(codigo_tipo_adjunto == window._tp.getTypeAttached['vimeo']) { %>
            <!-- <video id="player-video-lecture" class="{{-- mejs-player --}} mejs-vimeo-player" controls preload="auto" style="width: 100%; height: 100%;">
                <source type="video/vimeo" src="<%- src %>" />
                <object class="" style="width: 100%; height: 100%;" type="application/x-shockwave-flash"
                    data="{!! asset('js/vendor/flashmediaelement.swf') !!}">
                    <param name="movie" value="{!! asset('js/vendor/flashmediaelement.swf') !!}" />
                    <param name="allowfullscreen" value="true" />
                    <param name="allowScriptAccess" value="always">
                    <param name="allowNetworking" value="all">
                    <param name="wmode" value="opaque">
                    <param name="bgcolor" value="#000000">
                    <param name="flashvars" value="" />

                </object>
            </video> -->
			<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="<%- src %>?color=ffffff&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div>
			<!-- <iframe src="<%- src %>?color=ffffff&title=0&byline=0&portrait=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe> -->
			<!-- <iframe id="player-video-lecture" src="<%- src %>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen style="display:block; width: 100%; height: 100%"></iframe> -->
        <% } %>
	</script>
	{{-- Item course theme class list --}}
	<script type="text/template" id="course-theme-class-item-list-tpl">
		<a href="#course-theme-<%- codigo_tema_curso %>"><%= nombre_tema_curso %></a>
		<div id="course-theme-<%- codigo_tema_curso %>" class="content-theme">
			<p class="block-text-xmedium description-course-theme"><%= objetivo_tema_curso %></p>
			<ul class="attached-list-theme">
				<% _.each(adjuntos, function(adjunto) { %>
				<li>
					<% if( window.Misc.codInDoc(adjunto.codigo_tipo_adjunto) != -1 ) { %>
						<a
							href="<%= adjunto.direccion_adjunto %>"
							title="<%= nombre_tema_curso %>"
							target="_blank"
							class="left link-attached-theme  link-to-theme-article"
							data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="mdi mdi-paperclip vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
					<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['link']) { %>
						<a
							href="<%=  adjunto.direccion_adjunto %>"
							title="<%= nombre_tema_curso %>"
							target="_blank"
							class="left link-attached-theme link-to-theme-article"
							data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[1]%> vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
                    <% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-article link-to-theme-survey link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-survey state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
                    {{-- <% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['ext_survey']) { %>
						<a href="<%= window.Misc.urlFull( Route.route('aprende.curso.tema.formulario',{'type': type, 'category': url_categoria_curso, 'course': url_curso, 'survey': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) ) %>" title="<%= nombre_tema_curso %>" target="_blank" class="left link-attached-theme link-to-theme-survey" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[9]%> vtop"></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-survey state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span> --}}
					<% }else if(adjunto.codigo_tipo_adjunto == window._tp.getTypeAttached['html']) { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-article link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
					<% }else { %>
						<a href="<%= Route.route('aprende.curso.tema.clase', {'type': type, 'category': url_categoria_curso, 'course': url_curso, 'theme': url_tema_curso, 'class': adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido}) %>" title="<%= nombre_tema_curso %>" title="<%= nombre_tema_curso %>" class="left link-attached-theme link-to-theme-article link-to-theme-video" data-lecture="<%- adjunto.url_adjunto ? adjunto.url_adjunto : adjunto.url_contenido %>">
							<span class="thumb-icon"><i class="<%- adjunto.codigo_tipo_adjunto != '' && !_.isNull(adjunto.codigo_tipo_adjunto) ? window._tp.getIconTypeAttachment[adjunto.codigo_tipo_adjunto] :  window._tp.getIconTypeAttachment[2]%> vtop""></i></span>
							<span><%= adjunto.nombre_adjunto ? adjunto.nombre_adjunto : adjunto.nombre_contenido %></span>
						</a>
						<span class="right icon-circle tiny state-attached-theme <%- adjunto.state_review ? 'success' : 'gray-light' %>" title="<%- adjunto.state_review ? 'Marcar como incompleto' : 'Marcar como completo' %>"><i class="mdi mdi-check"></i></span>
					<% } %>
				</li>
				<% }); %>
			</ul>
		</div>
	</script>
{{-- post Discussion Class template --}}
<script type="text/template" id="discussion-post-class-tpl">
@if (Auth::check())
	<% if(owner){ %>
		<a href="#" class="close content-close discussion-post-hide" title="Remover Discusión">×</a>
	<% } %>
	<div class="post-user-data-box">
		<div class="row">
			<div class="small-12 columns">
				<ul class="post-user-card">
					<li>
						<a href="<%= window.Misc.urlFull( url_profile ) %>" class="post-avatar" title="<%- nombre_usuario %>">
							<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size40">
						</a>
					</li>
					<li>
						<ul class="post-user-data">
							<li>
								<span>
									<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="nickname-user-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
								</span>
								<span class="text-xsm light-text">&bull;</span>
								<span class="light-text"><%- window.moment([fecha_discusion].join(' '), "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD h:mm a") %></span>
							</li>
							<li>
								{{-- post content box --}}
								<div class="post-content-box">
									<div class="row collapse">
										<div class="small-12 columns">
											<div class="text-description-post container-more"><%= texto_discucion %></div>
										</div>
									</div>
								</div>
							</li>
							<li>
								{{-- footer box --}}
								<div class="post-footer-box">
									<div>
										<div class="row">
											<div class="small-8 columns">
												<ul class="post-social-shared comment-shared-list">
													<li>
														<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
													</li>
												</ul>
											</div>
											<div class="small-4 columns">
												<ul class="right footer-box-icons post-icons-list">
													<li>
														<a href="#" class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
															<i class="icon icon-like"></i>
															<span class="data-count-likes"><%- contador_like %></span>
														</a>
													</li>
													<li>
														<a href="#" class="show-comment-field" title="Haz un comentario">
															<i class="icon icon-comment"></i>
															<span class="data-count-comments"><%= contador_comentarios_discucion %></span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	{{-- Discussion comments box--}}
	<div class="post-comments-box discussion-comments-box hidesoft">

		<div class="user-comment discussion-user-comment">
			<div class="row">
				<div class="small-12 columns">

					<ul class="post-user-card">
						{{-- <li>
							<a href="{{ URL::route('usuario.nickname', Auth::user()->nickname_usuario) }}" class="picture-comment-post" title="{{ Auth::user()->getName() }}">
								<img src="{{{ Auth::user()->imagen_usuario ? Auth::user()->imagen_usuario :  Config::get('tuproyecto.avatar_image') }}}" alt="{{{ Auth::user()->nickname_usuario }}}" class="rounded-img size35" />
							</a>
						</li> --}}
						<li>
							<div class="comment-post-field textarea-post-discussion ">
								{!! Form::open( array('action' => null, 'data-abide' => '', 'class' => 'form-comment-discussion') ) !!}
									<div class="row collapse">
										<div class="small-9 columns">
											<textarea name="texto_comentario_discucion" placeholder="Escribe un comentario" rows="1" class="wysiwyg-commentdiscussion" required="required" autofocus></textarea>
										</div>
										<div class="small-3 columns">
											<button class="right button expand tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
										</div>
									</div>
									<input type="hidden" name="codigo_discucion" value="<%- codigo_discucion %>">
								{!! Form::close() !!}
							</div>
						</li>
					</ul>

				</div>
			</div>
		</div>

		<section class="comments-discussion-list hidesoft">

			{{-- Render user commnet--}}

		</section>

	</div>
@endif
</script>

{{-- comment Discussion Class template --}}
<script type="text/template" id="comment-discussion-class-tpl">
<div class="row">
	<div class="small-12 columns">
		<ul class="post-user-card">
			<li>
				<a href="<%= window.Misc.urlFull( url_profile ) %>" title="" class="picture-comment-post">
					<img src="<%- imagen_usuario ? imagen_usuario : window.Misc.dv().avatar %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size30">
				</a>
			</li>
			<li>
				<ul class="post-user-data">
					<li>
						<span>
							<a href="<%= window.Misc.urlFull( url_profile ) %>" class="nickname-comment-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
						<span>
						<span class="text-xsm light-text">&bull;</span>
						<span class="light-text"><%- window.moment([fecha_comentario, hora_comentario].join(' '), "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD h:mm a") %></span>
					</li>
					<li>
						<div class="comment-content-post">
							<div class="text-description-comment container-more">
								<%= texto_comentario %>
							</div>
						</div>
					</li>
					<li>
						<ul class="comment-icons-list">
							<li>
								<a href="#" class="TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
									<i class="icon icon-like"></i>
									<span class="data-count-likes"><%- contador_like %></span>
								</a>
							</li>
							<li><span class="text-xsm light-text">&bull;</span></li>
							<li>
								<span><a href="#" class="show-user-likes">A quién le gusta esto.</a></span>
							</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
</script>

<script type="text/template" id="discussion-confirm-hide-tpl">
	<p>{{ Lang::get('learn.remove.discussion.confirm') }}</p>
</script>

{{-- Item attached course list --}}
<script type="text/template" id="course-attached-list-tpl">
	<a href="<%= direccion_adjunto %>" title="<%- nombre_adjunto %>" class="link-attached-theme">
		<%= nombre_adjunto %>
	</a>
</script>

{{-- post Notes User template --}}
<script type="text/template" id="note-post-tpl">
	@if (Auth::check())
		<a href="#" class="close content-close note-post-hide" title="Remover Nota">×</a>
		{{-- post content box --}}
		<div class="text-description-post container-more"><%= texto_nota_usuario %></div>
	@endif
</script>

{{-- Registration User Course template --}}
<script type="text/template" id="registration-user-course-tpl">
	@if (Auth::check())
		<div class="item-student-course">
			<ul class="inline-list-grid no-bullet">
				<li class="has-image">
					<a href="<%= window.Misc.urlFull( url_profile ) %>" class="" title="<%- nombre_usuario %>">
						<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size45">
					</a>
				</li>
				<li>
					<ul class="no-bullet">
						<li>
							<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="name-user dark-text">
								<h6 class="carduser-name"><%- nombre_usuario %></h6>
							</a>
						</li>
						<li>
							<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="nickname-user-post"><span class="text-xmd dark-text"><%- window.Misc.strToNickname(nickname_usuario) %></span></a>
						</li>
						<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
							<li><span class="light-text text-sm"><%- nombre_ciudad %>, <%- nombre_pais %></span></li>

						<% } %>
					</ul>
				</li>
			</ul>
		</div>
	@endif
</script>

@stop

