@extends('core.mentoring.mentoring')

@section('mentoring.content')
	{{-- ------------------ Mentoring Templates JS -------------------- --}}


	{{-- Section Detail Mentor --}}
	<script type="text/template" id="mentor-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing content medium radius" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown content medium radius" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-lg" data-dropdown-content class="md-dropdown content large radius" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
		<% } %>


		<section id="profile-mentor-section" class="">
			 <!-- module navigation -->
			<div class="wrapper-submenu-section  inst-bgcolor-secondary show-for-large-up">
				<div class="rows">
					<div class="small-12">
						<div class="tabs-container">
							<ul id="mentor-list-tabs-filter" class="tabs-sub-nav-alt tabs-route text-left" data-tab data-tab-init="is_hover:false">
								<div class="row" id="container-bar">
									<div class="small-1 no-padding columns">
										<li class="left tab-title disabled">
											<a class="text-xlg">{{ transtp('mentoring.mentoring') }}<i class="mdi mdi-presentation"></i></a>
										</li>
									</div>
									<div class="small-4 text-right no-padding right columns">
										<li class="tab-title ">
											<a href="<%- Route.route('mentoria.preguntas.index') %>" title="Principal" aria-controls="mentoring-questions">Principal</a>
										</li>

										<li class="tab-title ">
											<a href="<%- Route.route('mentoria.mentores.index') %>" title="Mentores" aria-controls="mentoring-mentors">{{ transtp('mentoring.tabMentor') }}</a>
										</li>

										<li class="tab-title ">
											<a href="<%- Route.route('mentoria.mentores.procesos.index') %>" title="Procesos" aria-controls="mentoring-process-main">{{ transtp('mentoring.tabProcess') }}</a>
										</li>
									</div>
								</div>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<!-- module responsive navigation -->
			<div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right text-md">Mentoría&nbsp;&nbsp;<i class="mdi mdi-menu mdi-18px"></i></button>
						<ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
                            <li class="tab-title ">
                                <a href="<%- Route.route('mentoria.mentores.index') %>" title="Mentores" aria-controls="mentoring-mentors">Mentores</a>
                            </li>
                            <li class="tab-title ">
                                <a href="<%- Route.route('mentoria.preguntas.index') %>" title="Preguntas" aria-controls="mentoring-questions">Principal</a>
                            </li>
							<li class="tab-title ">
								<a href="<%- Route.route('mentoria.mentores.procesos.index') %>" title="Procesos" aria-controls="mentoring-process-main">Procesos de mentoria</a>
							</li>
                        </ul>
                    </dl>
                </div>
            </div>
        </div>

			{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-mentor-profile') ) !!}
			<div class="row container-profile">

				<!-- PERFIL DEL MENTOR -->


				<div id="content-profile-mentor" class="large-12 panel z-depth-1">

						<!-- HEADER-->

					<div class="row gray-light-alt-bg header-profile show-for-small-up">
						<div style="margin-top: 18px;">
							<a class="button small btn-shadow" href={{route('mentoria.preguntas.index')}}><i class="mdi mdi-chevron-left">Volver</i></a>
						</div>
						<div class="tablet-10 columns padding-1">
							<img src="<%- imagen_usuario %>"  class="img-carduser size90 rounded-img left" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
							<ul class="no-bullet dark-text">
								<li><h3 class="thin-header clean-bottom"> <%- nombre_usuario %></h3></li>
								<li>
									<span class="text-md">
										<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>"><%= window.Misc.strToNickname(nickname_usuario) %></a>
										<span>&bull;</span>
										<span><% if(nombre_ciudad) { %><%- nombre_ciudad %>, <%- nombre_pais %><% } %></span>
									</span>
								</li>
								<!--<li>
									<div id="mentor-expertise-container" class="editable-item">
										{{-- Render info expertise --}}
									</div>
								</li>-->
								<li>
									<div>
									<% if(typeof ultimo_ingreso_usuario_ago !=='undefined' && ultimo_ingreso_usuario_ago) { %>

										<p>última vez hace   <%- ultimo_ingreso_usuario_ago %> </p>
									<% }%>
									</div>
								</li>
								<li>
									<div class="row">
										<div class="large-5 columns">
											@if(Auth::check() && App\Institucion::getMentoringDirectRequest(App\RegistroSesion::getInstitution()) )
											<% if(typeof mentor !=='undefined' && mentor && !owner) { %>
													<button id="request-advisory" class="full-width btn-sm radius z-depth-1 white-text"><i class="mdi mdi-presentation white-text"></i> {{ transtp('mentoring.requestProcess') }} </button>
											<% }%>
											@endif
										</div>
										<div class="large-4 columns left">
											<button id="recommendation-mentor" class="full-width btn-sm radius z-depth-1 white-skyblue"> <i class="mdi mdi-human-greeting sky-blue-text"></i> Recomendar a un colega </button>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="tablet-2 columns right container-tab show-for-medium-up">
							<ul class="tabs text-right" data-tab role="tablist">
								<li class="tab-title active" role="presentation">
									<a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1" class="transparent">perfil</a></li>
								<li class="tab-title" role="presentation">
									<a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2" class="transparent">agenda</a>
								</li>
							</ul>
						</div>

					</div>

					<div class="row gray-light-alt-bg show-for-mobile-only" id="container-mentor-profile">
						<div class="mobile-12 columns">
							<img src="<%- imagen_usuario %>"  class="img-carduser size90 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
							<div class="no-bullet dark-text">
								<li><h3 class="thin-header clean-bottom text-center"> <%- nombre_usuario %></h3></li>
								<li class="text-center">
									<span class="text-md">
										<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>"><%= window.Misc.strToNickname(nickname_usuario) %></a>
										<span>&bull;</span>
										<span><% if(nombre_ciudad) { %><%- nombre_ciudad %>, <%- nombre_pais %><% } %></span>
									</span>
								</li>
								<li>
									<div>
										<% if(typeof ultimo_ingreso_usuario_ago !=='undefined' && ultimo_ingreso_usuario_ago) { %>
											<p>última vez hace  <%- ultimo_ingreso_usuario_ago %>  </p>
										<% } %>
									</div>
								</li>
							</div>
							<div class="large-12 columns">
								@if(Auth::check() && App\Institucion::getMentoringDirectRequest(App\RegistroSesion::getInstitution()) )
								<% if(typeof mentor !=='undefined' && mentor && !owner) { %>
									<button id="request-advisory" class="full-width btn-sm radius z-depth-1 lower-text" > Solicitar Proceso</button>
								<% } %>
								@endif
								<button id="recommendation-mentor" class="full-width btn-sm radius z-depth-1 white-skyblue lower-text"> <i class="mdi mdi-human-greeting"></i>Recomendar a un colega </button>
							</div>
						</div>
					</div>



						<!-- CONTENIDO DE LOS TABS-->

					<div class="tabs-content">

						<!-- INFORMACION MENTOR -->

						<section role="tabpanel" aria-hidden="false" class="content active" id="panel2-1">
							<div class="row" id="container-information-mentor">
								<div class="tablet-6 columns">
									<div class="<%- owner ? 'editable' : '' %>">
										<div id="mentor-asisstance-container" class="description-knowledge-mentor editable-item ">
											<h4 class="thin-header">
												<span class="field-text">En qué puedo ayudar</span>
												<button class="edit-field-button right edit-field" data-edit-template="assistance"><i class="mdi mdi-pencil"></i></button>
											</h4>
											<div class="content-assistance-mentoring field-for-edit edit-field clearfix  wrap-text" data-edit-template="assistance">
												{{-- Render info assistance--}}
											</div>
											<div class="field-editing">
												{{-- Render template edit form--}}
											</div>
										</div>

										<div id="mentor-experience-container" class="description-knowledge-mentor editable-item">
											<h4 class="thin-header">
												<span class="field-text">{!! transtp('mentoring.create.experience') !!}</span>
												<button class="edit-field-button right edit-field" data-edit-template="experience"><i class="mdi mdi-pencil"></i></button>
											</h4>
											<div class="content-experience-mentor field-for-edit edit-field clearfix wrap-text" data-edit-template="experience">
												{{-- Render info experience--}}
											</div>
											<div class="field-editing">
												{{-- Render template edit form--}}
											</div>
										</div>
										<div id="mentor-level-development-container" class="editable-item">
											{{-- Render info level development --}}
										</div>

										<div id="mentor-socials-container" class="editable-item">
											{{-- Render info Socials --}}
										</div>
										<% if(owner){ %>
										<div id="mentor-curriculum-container">
											<br>
											<h4 class="thin-header sky-blue-text">Adjunto Hoja de vida</h4>
											<section id="wrap-documents" class="">
												{{-- Render Documents --}}
											</section>
										</div>
										<% if(!terminos_aceptados){ %>
										<div id="mentor-terms-container">
											{{-- Render Terms --}}
										</div>
										<% } %>
										<% } %>
									</div>
								</div>

								<div class="tablet-6 columns">

									<div class="<%- owner ? 'editable' : '' %>">
										<div id="mentor-specialities-container" class="input-field">
											<h4 class="thin-header">{!! transtp('mentoring.create.specialties') !!}</h4>
											<% if(owner){ %>
											<select name="codigo_especialidad" id="codigo_especialidad" class="choice-filter-specialities" placeholder="Seleccione una especialidad" data-placeholder="Seleccione una especialidad">
												<option value="" selected disabled>Seleccione una especialidad</option>
												@foreach( App\Especialidad::getSpecialties() as $key => $value)
													<option value="{{ $key }}">{{ $value }}</option>
												@endforeach
											</select>
											<% } %>
											<div class="content-data-list content-specialities-list">
												<ul class="list-info-editing list-specialities-mentor disc text-md gray-dark-text list-highlighted">
													{{-- Render views item of specialities --}}
												</ul>
											</div>
										</div>
										<br>
										<div id="mentor-economic-sector-container" class="input-field">
											<h4 class="thin-header">{!! transtp('mentoring.create.sectors') !!}</h4>
											<% if(owner){ %>
											<select name="codigo_sector_economico" id="codigo_sector_economico" class="choice-filter-economic-sector" data-placeholder="Selecciona sector económico" placeholder="Selecciona sector económico">
												<option value="" selected disabled>Seleccione sector económico</option>
												@foreach( App\SectorEconomico::getSectors() as $sector)
													<option value="{{ $sector->codigo_sector_economico }}">{{ $sector->nombre_sector_economico }}</option>
												@endforeach
											</select>
											<% } %>
											<div class="content-data-list content-economic-sector-list">
												<ul class="list-info-editing list-economic-sector-mentor disc text-md gray-dark-text list-highlighted">
													{{-- Render views item of economic-sector --}}
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</section>

						<!-- SESIONES Y CALENDARIO-->

						<section role="tabpanel" aria-hidden="true" class="content full-width" id="panel2-2">
							<div class="row panel">
								<div class="large-12 columns">
									<!-- ESPACIO PARA EL CALENDARIO -->
									<div id="calendar-mentoring" class="calendar-mentoring"></div>
								</div>
							</div>

							<div class="large-12 columns">

							<!-- SESIONES-->
								<br>
								<h4 class="text-xlg gray-base-text">Tus sesiones</h4>
								<table>
									<tbody id="body-sesiones-calendario">
										<p class="yourSessions">No hay sesiones activas o pendientes</p>

									</tbody>
								</table>

							</div>
						</section>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</section>

	</script>

	{{-- layout mentoring views --}}
	<script type="text/template" id="rol-switch-mentoring-tpl">
        <!-- module navigation -->
		<div id="module-nav-bar" class="wrapper-submenu-section  inst-bgcolor-secondary show-for-large-up">
            <div class="rows">
                <div class="small-12">
                    <div class="tabs-container">
                        <ul id="mentor-list-tabs-filter" class="tabs-sub-nav-alt tabs-route text-left" data-tab data-tab-init="is_hover:false">
							<div class="row" id="container-bar">
								<div class="small-1 no-padding columns">
									<li class="left tab-title disabled">
										<a class="text-xlg">{{ transtp('mentoring.title') }}<i class="mdi mdi-presentation"></i></a>
									</li>
								</div>
								<div class="small-4 text-right no-padding right columns">
									<li class="tab-title <%- tab == 'preguntas' ? 'active' : '' %>">
										<a href="<%- Route.route('mentoria.preguntas.index') %>" title="Principal" aria-controls="mentoring-questions">Principal</a>
									</li>

									<li class="tab-title <%- tab == 'mentores' ? 'active' : '' %>">
										<a href="<%- Route.route('mentoria.mentores.index') %>" title="Mentores" aria-controls="mentoring-mentors">{{ transtp('mentoring.tabMentor') }}</a>
									</li>

									<li class="tab-title <%- tab == 'process' || tab === 'sesiones' ? 'active' : '' %>">
										<a href="<%- Route.route('mentoria.mentores.procesos.index') %>" title="Procesos" aria-controls="mentoring-process-main">{{ transtp('mentoring.tabProcess') }}</a>
									</li>
								</div>
							</div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- module responsive navigation -->
        <div id="module-nav-bar-responsive" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right text-md">Mentoría&nbsp;&nbsp;<i class="mdi mdi-menu mdi-18px"></i></button>
						<ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
                            <li class="tab-title <%- tab == 'mentores' ? 'active' : '' %>">
                                <a href="<%- Route.route('mentoria.mentores.index') %>" title="Mentores" aria-controls="mentoring-mentors">Mentores</a>
                            </li>
                            <li class="tab-title <%- tab == 'preguntas' ? 'active' : '' %>">
                                <a href="<%- Route.route('mentoria.preguntas.index') %>" title="Preguntas" aria-controls="mentoring-questions">Principal</a>
                            </li>
							<li class="tab-title <%- tab == 'process' || tab === 'sesiones' ? 'active' : '' %>">
								<a href="<%- Route.route('mentoria.mentores.procesos.index') %>" title="Procesos" aria-controls="mentoring-process-main">Procesos de mentoria</a>
							</li>
                        </ul>
                    </dl>
                </div>
            </div>
        </div>
			@php
				$terms = App\TerminosCondiciones::termsAndConditions(App\TerminosCondiciones::getTypeTerms('mentoring'));
				$hasTerms = $terms instanceof App\TerminosCondiciones;
			@endphp
			@if( Auth::check() && App\Institucion::hasPermission('assign-mentor') && Auth::user()->hasRole(['mentor']) === false && $hasTerms)

			<!-- conviertete en mentor -->
			<div class="large-6 large-offset-3 columns show-for-small-up" id="notification-add">
				<br>
				<br>
				<p class="text-center text-md thin-text gray-base-text">Aún no eres mentor &nbsp; <a href="<%- Route.route('mentoria.mentores.create') %>"><button class="btn btn-sm white-text radius"><i class="mdi mdi-tie white-text"></i>&nbsp; Conviértete en mentor</button></a> &nbsp; y obtén beneficios ayudando a otros a lograr sus metas</p>
				<hr>
			</div>

			<!-- conviertete en mentor responsive -->
			<div class="full-width columns show-for-mobile-only gray-light-alt-bg" id="notification-add">
				<br>
				<div class="row">
					<div class="mobile-2 columns">
						<i class="mdi mdi-tie"></i>
					</div>
					<div class="mobile-9 columns">
						<a class="white-text sky-blue-text text-lg">Conviértete en mentor</a>
					</div>
					<div class="mobile-1 columns">
						<i class="mdi mdi-close gray-dark-text mdi-18px right text-center"></i>
					</div>
				</div>
			</div>
		@endif



		{{-- main content mentoring --}}
		<div class="row">
			<div class="small-12 columns no-padding">
				<div id="container-sections-mentoring" class="no-padding">
					<% if( jQuery.inArray(tab, ['preguntas','sesiones', 'disponibilidad','mentores', 'process']) !== -1 ) { %>

						<div class="row" id="container-rendering">
							<div class="large-12 small-12 no-padding columns">
								<div class="tabs-content section-content-mentoring">

									<section class="content <%- tab == 'mentores' ? 'active' : '' %>" id="mentoring-mentors">
										{{-- render mentoring mentors template id="mentor-list-tpl" --}}
									</section>

									<section class="content <%- tab == 'preguntas' ? 'active' : '' %>" id="mentoring-questions">
										{{-- render mentoring questions template id="mentoring-viewquestions-tpl" --}}
									</section>

									<section class="content <%- tab == 'process' || tab === 'sesiones' ? 'active' : '' %>" id="mentoring-process-main">
										{{-- render mentoring questions template id="mentoring-process" --}}
									</section>

									<section id="mentoring-session">
										{{-- render sessions template --}}
									</section>
									<section class="content" id="mentoring-create">
										{{-- render mentoring view create --}}
									</section>
								</div>
							</div>
						</div>
					<% }else{ %>
						<section class="content" id="mentoring-create">
							{{-- render mentoring view create --}}
						</section>
					<% } %>
				</div>

			</div>
		</div>
	</script>

	{{-- form request mentory --}}
	<script type="text/template" id="request-mentor-advisory-tpl">
		<div class="panel row">
			<div class="large-11 center-block">
				{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-request-mentor-advisory')) !!}
				<p class="text-lg">{{ transtp('mentoring.requestEntrepreneurship') }}</p>
				<input type="hidden" name="codigo_usuario" id="mentor" value="<%- codigo_usuario %>">
				<select name="codigo_entidad" id="codigo_entidad" style="display: block;" required >
					<option selected disabled>{{ transtp('mentoring.chooseEntrepreneurship') }}</option>
					@foreach( App\Entidad::getEntitysList() as $value)
						<option value="{{ TuProyecto::encryptSrcParams([$value->key]) }}">{{ $value->value }}</option>
					@endforeach
				</select><br>
				<p class="text-lg">Inicia la conversacion con </p>
				<input name="descripcion_asesoria" type="text" placeholder="mensaje" required><br><br>
				<div class="right">
					<button  type="submit" class="btn-sm text-sm radius">Solicitar</button>
					<button class="btn-sm text-sm radius sky-blue-text white-bg close-reveal-modal">Cancelar</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</script>

	{{--  mentoring questions view --}}
	<script type="text/template" id="mentoring-viewquestions-tpl">
		<div id="container-sections-mentoring" class="no-padding">

			<div class="row" id="container-tab-main">
			@php
				$mentor = Auth::user()->hasRole(['mentor']);
			@endphp
			@if($mentor)
				<!-- filtro -->
				<div class="small-12 medium-12 large-3 columns">
					<div class="small-11 ">
						<div class="block-filters-choice panel radius z-depth-1">

							{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-mentoring'))  !!}
								<!-- input para busqueda por numero documento-->
								<div class="row">
									<div class="small-12 columns input-field">
										<input
											autoFocus
											id="number_document"
											maxlength="15"
											name="number_document"
											placeholder="{{ transtp('mentoring.filters.number_document') }}"
											type="text"
										>
										<span class="count-field-char count_number_document"></span>
										<span class="mdi mdi-magnify" id="mentoring-name-search-icon"></span>
									</div>
								</div>
								<!-- input para busqueda por nombre emprendimiento -->
								<div class="row">
									<div class="small-12 columns input-field">
										<input
											id="name_entrepreneurship"
											maxlength="30"
											name="name_entrepreneurship"
											placeholder="{{ transtp('mentoring.filters.name_entrepreneurship') }}"
											type="text"
										>
										<span class="count-field-char count_name_entrepreneurship"></span>
										<span class="mdi mdi-magnify" id="mentoring-name-search-icon"></span>
									</div>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				<!-- end filtro -->

				<div class="small-12 medium-12 large-9 columns content-data-mentoring">
			@else
				<div class="small-12 medium-12 large-12 columns content-data-mentoring">
			@endif
					<h4 class="text-lg gray-base-text title-main">{{ transtp('mentoring.active') }}</h4>
					<div id="container-active-mentoring" class="row no-padding z-depth-1">
						{{-- Render template active-mentoring --}}
					</div>
					<div class="wrap-pagination">
						<!-- Render Pagination-->
					</div>


				<!-- soluciones de sesion -->


					<h4 class="text-lg gray-base-text title-main">Solicitudes de Sesión</h4>
					<div id="container-session-mentoring" class="no-padding row z-depth-1">
						{{-- Render template session-mentoring --}}
					</div>


				<!-- solicitud de mentoria -->


					<h4 class="text-lg gray-base-text title-main">{{ transtp('mentoring.request') }}</h4>
					<div id="container-mentoring-pending" class="no-padding row z-depth-1">
						{{-- Render template mentoring-pending --}}
					</div>
				</div>

				<!-- mentores destacados -->

				{{-- <h4 class="text-lg gray-base-text">Mentores destacados</h4>
				<div class="large-3 columns">
					<div class="rows panel rounded z-depth-1 columns">
						<div class="large-4 columns">
							<img src="{{ Auth::user()->imagen_usuario }}"  class="img-carduser size60 rounded-img right" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-8 columns">
							<h4 class="text-md gray-base-text">Raul A. Rodriguéz</h4>
							<a class="">@andrestobon</a><br>
							<small class="text-sm gray-base-text tiny-text"><i class="mdi mdi-18px mdi-map-marker-radius "></i> Bogotá, Colombia</small>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
										<i class="mdi mdi-24px mdi-certificate gray-base-text right"></i>
									</span>
						</div>
					</div>
				</div>
				<div class="large-3 columns">
					<div class="rows panel rounded z-depth-1 columns">
						<div class="large-4 columns">
							<img src="{{ Auth::user()->imagen_usuario }}"  class="img-carduser size60 rounded-img right" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-8 columns">
							<h4 class="text-md gray-base-text">Raul A. Rodriguéz</h4>
							<a class="">@andrestobon</a><br>
							<small class="text-sm gray-base-text tiny-text"><i class="mdi mdi-18px mdi-map-marker-radius "></i> Bogotá, Colombia</small>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
										<i class="mdi mdi-24px mdi-certificate gray-base-text right"></i>
									</span>
						</div>
					</div>
				</div>
				<div class="large-3 columns">
					<div class="rows panel rounded z-depth-1 columns">
						<div class="large-4 columns">
							<img src="{{ Auth::user()->imagen_usuario }}"  class="img-carduser size60 rounded-img right" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-8 columns">
							<h4 class="text-md gray-base-text">Raul A. Rodriguéz</h4>
							<a class="">@andrestobon</a><br>
							<small class="text-sm gray-base-text tiny-text"><i class="mdi mdi-18px mdi-map-marker-radius "></i> Bogotá, Colombia</small>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
										<i class="mdi mdi-24px mdi-certificate gray-base-text right"></i>
									</span>
						</div>
					</div>
				</div>
				<div class="large-3 columns">
					<div class="rows panel rounded z-depth-1 columns">
						<div class="large-4 columns">
							<img src="{{ Auth::user()->imagen_usuario }}"  class="img-carduser size60 rounded-img right" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-8 columns">
							<h4 class="text-md gray-base-text">Raul A. Rodriguéz</h4>
							<a class="">@andrestobon</a><br>
							<small class="text-sm gray-base-text tiny-text"><i class="mdi mdi-18px mdi-map-marker-radius "></i> Bogotá, Colombia</small>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
											<i class="mdi mdi-24px mdi-certificate gray-base-text right"></i>
										</span>
						</div>
					</div>
				</div>
			</div> --}}
		</div>
	</script>


	<script type="text/template" id="mentoring-process">
		<div id="container-sections-mentoring" class="no-padding">
			<div class="row" id="container-tab-main">
				<!-- soluciones de sesion -->
				<h4 class="text-lg gray-base-text title-main">Solicitudes de sesión</h4>
				<div id="container-sessions-proccess" class="row no-padding z-depth-1">
					<!-- Render template-->
				</div>

				<!-- solicitudes de mentoria -->
				<h4 class="text-lg gray-base-text title-main">{{ transtp('mentoring.request') }}</h4>
				<div id="container-mentoring-pending-proccess" class="row no-padding z-depth-1">
					<!-- Render template-->
				</div>

				<h4 class="text-lg gray-base-text title-main">{{ transtp('mentoring.mentoring') }}</h4>
				<!-- mentorias -->
				<div id="container-mentoring-all-proccess" class="row no-padding z-depth-1">
					<!-- Render template-->
				</div>
			</div>
		</div>
	</script>


	{{--  mentor list view --}}
	<script type="text/template" id="mentor-list-tpl">
		<div class="row">


			<div class="small-3 columns">
				<div class="small-11">
					<div class="block-filters-choice panel radius z-depth-1 show-for-small-up">

					{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-mentor'))  !!}

					<!-- input para busqueda de mentores por nombre-->

						<div class="row">
							<div class="small-12 columns input-field">
							<input type="text" id="mentoring-name" name="q" placeholder="{{ transtp('mentoring.filters.title') }}" >
								<span class="mdi mdi-magnify" id="mentoring-name-search-icon"></span>
							</div>
						</div>

						<!-- select para busqueda de mentores por tema-->

						<div class="row">
							<div class="small-12 columns input-field">
								<select name="specialty" id="specialty" class="browser-default  choice-select-autocomplete change-choice"  data-ajax--url="<%= window.Misc.urlFull( Route.route('usuario.especialidades.selector.list') ) %>" data-initial-value="<%- typeof(specialty) !== 'undefined' ? specialty : '' %>" required data-placeholder="Tema" placeholder="Tema">
								</select>
							</div>
						</div>

						<!-- select para busqueda de mentores por sector-->

						<div class="row">
							<div class="small-12 columns input-field">
								<select  name="sectors" id="sectors" class="browser-default  choice-select-autocomplete change-choice"  data-ajax--url="<%= window.Misc.urlFull( Route.route('usuario.economicos.selector.list') ) %>" data-initial-value="<%- typeof(sectors) !== 'undefined' ? sectors : '' %>" required data-placeholder="Sector" placeholder="Sector">
								</select>
							</div>
						</div>

						<!-- select para busqueda de mentores por Etapa-->

						<div class="row">
							<div class="small-12 columns input-field">
								<select  name="level" id="level" class="browser-default  choice-select-autocomplete change-choice"  data-ajax--url="<%= window.Misc.urlFull( Route.route('proyecto.etapa.index') ) %>" data-initial-value="<%- typeof(level) !== 'undefined' ? level : '' %>" required data-placeholder="{{ transtp('mentoring.slcStage') }}" placeholder="{{ transtp('mentoring.slcStage') }}">
								</select>
							</div>
						</div>

						<!-- select para busqueda de mentores por ciudad-->

						<div class="row">
							<div class="small-12 columns input-field">
								<select name="city" id="city" class="browser-default  choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-val="#department" data-initial-value="<%- typeof(city) !== 'undefined' ? city : '' %>" required data-placeholder="Ciudad" placeholder="Ciudad">
								</select>
							</div>
						</div>

						<!-- select para busqueda de mentores por programa-->

						<div class="row">
							<div class="small-12 columns input-field">
								<select name="program" id="program" class="browser-default  choice-select-autocomplete change-choice"  data-ajax--url="<%= window.Misc.urlFull( Route.route('convocatoria.selector.list') ) %>" data-initial-value="<%- typeof(program) !== 'undefined' ? program : '' %>" required data-placeholder="Programa" placeholder="Programa">
								</select>
							</div>
						</div>
						{!! Form::close() !!}
					</div>

				</div>
			</div>
			<!-- filtro -->



			<!-- renderizacion de mentores -->

			<div class="small-9 columns">
				<div class="content-data-list">
					<ul id="list-mentoring-mentor" class="mobile-block-grid-1 tablet-block-grid-2 large-block-grid-3 browse-list-carduser no-padding">
						{{-- Render mentors--}}
					</ul>
				</div>
			</div>
		</div>
	</script>

	{{-- view mentor item --}}
	<script type="text/template" id="mentor-item-tpl">
		<div class="item-carduser-list item-wrap-list panel radius no-padding z-depth-1 show-for-tablet-up">
			<div class="top-item-carduser">
				<ul class="inline-list-grid">
					<li class="has-image">
						<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>">
							<img src="<%= imagen_usuario %>" alt="<%- nombre_usuario %>" class="img-carduser size50" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</a>
					</li>
					<li>
						<ul class="no-bullet">
							<li>
								<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>" title="<%- nombre_usuario %>"><h6 class="bold-header carduser-name inst-color-secondary bold-text"><%- nombre_usuario %></h6></a>
							</li>
							<li>
								<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>"><span class="text-sm dark-text"><%= window.Misc.strToNickname(nickname_usuario) %></span></a>
							</li>
							<li>
								<span class="text-sm thin-text gray-base-text"><i class="mdi mdi-map-marker-radius mdi-14 mdi-center"></i><%- nombre_ciudad %><%- nombre_pais ? ', '+ nombre_pais : '' %></span>
							</li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="content-item-carduser no-border">
				<dl class="inner-sections-carduser">
					<dd>
						<p class="text-xmd thin-text gray-base-text"><%- nombre_especialidad %></p>
					</dd>
					<dd>
						<div class="section-description-card section-footer">
							<p class="text-xmd thin-text gray-base-text">En qué puedo ayudar:</p>
							<% if(specialties.length) { %>
								<ul class="browser-default disc gray-base-text">
									<% _.each(specialties, function (specialty) { %>
										<li><p class="text-xmd thin-text gray-base-text"><%- specialty.nombre_especialidad %></p></li>
									<% }) %>
								</ul>
							<% } %>
						</div>
					</dd>
					<dd class="clearfix">
						<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>" class="right inst-color-secondary bold-text">VER MÁS</a>
					</dd>
				</dl>
			</div>
	    </div>
		<div class="show-for-mobile-only">
			<ul class="inline-list-grid">
				<li class="has-image">
					<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>">
						<img src="<%= imagen_usuario %>" alt="<%- nombre_usuario %>" class="img-carduser size50  rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</a>
				</li>
				<li>
					<div class="row">
						<ul class="no-bullet">
							<div class="mobile-10 columns">
								<li>
									<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>" title="<%- nombre_usuario %>"><h6 class="bold-header carduser-name inst-color-secondary bold-text"><%- nombre_usuario %></h6></a>
								</li>
								<li>
									<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>"><span class="text-sm dark-text"><%= window.Misc.strToNickname(nickname_usuario) %></span></a>
								</li>
								<li>
									<span class="text-sm thin-text gray-base-text"><i class="mdi mdi-map-marker-radius mdi-14 mdi-center"></i><%- nombre_ciudad %><%- nombre_pais ? ', '+ nombre_pais : '' %></span>
								</li>
							</div>
							<div class="mobile-2 columns">
								<a data-dropdown="drop1" aria-controls="drop1" aria-expanded="false" data-options="align:left">
									<i class="mdi mdi-dots-vertical mdi-36px">

									</i>
								</a>
							</div>

						</ul>
						<div class="mobile-12 columns">
							<ul id="drop1" class="f-dropdown" data-dropdown-content>
								<div class="panel">
									<li><a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario}) %>">ver perfil</a></li>
								</div>
							</ul>
						</div>
					</div>
				</li>
			</ul>
		</div>

	</script>

	<script type="text/template" id="not-result-mentoring-tpl">
		<div class="large-12 columns container-targets">
			<p class="text-md gray-light-text text-center"> No se encontraron mentorias </p>
		</div>
	</script>

	<script type="text/template" id="not-result-sessions-tpl">
		<div class="large-12 columns container-targets">
			<p class="text-md gray-light-text text-center"> No se han encontrado solicitudes de sesiones </p>
		</div>
	</script>

	{{-- Active mentoring template --}}
	<script type="text/template" id="active-mentoring-tpl">
		<%if (!isMentor) { %>
			<% if(emprendedor) { %>
				<div class="large-12 columns container-targets">
					<div class="large-1 mobile-3 columns">
						<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>" title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
					</div>
					<div class="large-4 mobile-9 columns">
						<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>"><h4 class="text-md gray-base-text link-process">{{ transtp('mentoria.texto') }}</h4></a>
						<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>" class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
					</div>

					<div class="large-3 columns hide-for-mobile-only">
						<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
								<i class="mdi mdi-lightbulb white-text"></i>
							</span>
							&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 columns">
						<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
						<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
						<% } else { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
						<% } %>
					</div>
					<div class="large-1 columns">
						<span  data-tooltip aria-haspopup="true" title="Mentoría activa">
							<i class="mdi mdi-24px mdi-check gray-base-text"></i>
						</span>
					</div>
				</div>
			<% } %>
		<% } else if (isMentor) { %>
			<div class="large-12 columns container-targets">
				<div class="large-1 mobile-3 columns">
					<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>" title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
				</div>
				<div class="large-4 mobile-9 columns">
					<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>"><h4 class="text-md gray-base-text link-process">{{ transtp('mentoria.texto') }}</h4></a>
					<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>" class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
				</div>
				<% if(emprendedor) { %>
					<div class="large-3 columns hide-for-mobile-only">
						<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
								<i class="mdi mdi-lightbulb white-text"></i>
							</span>
							&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 columns">
						<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
						<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
						<% } else { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
						<% } %>
					</div>
				<% } else { %>
					<div class="large-3 columns hide-for-mobile-only">
						<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
								<i class="mdi mdi-tie white-text"></i>
							</span>
							&nbsp;{{ transtp('mentoring.mentor-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 columns">
						<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
						<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
						<% } else { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
						<% } %>
					</div>
				<% } %>
				<div class="large-1 columns">
					<span  data-tooltip aria-haspopup="true" title="Mentoría activa">
						<i class="mdi mdi-24px mdi-check gray-base-text"></i>
					</span>
				</div>
			</div>
		<% } %>
	</script>

	{{-- Rejected mentoring template --}}
	<script type="text/template" id="rejected-mentoring-tpl">
		<div class="large-12 columns container-targets">
			<div class="large-1 mobile-3 columns">
				<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>" title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
			</div>
			<div class="large-4 mobile-9 columns">
				<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>"><h4 class="text-md gray-base-text link-process">{{ transtp('mentoria.texto') }}</h4></a>
				<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>" class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
			</div>
			<% if(emprendedor) { %>
				<div class="large-3 columns hide-for-mobile-only">
					<h5 class="text-sm gray-base-text">
						<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
							<i class="mdi mdi-lightbulb white-text"></i>
						</span>
						&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
					</h5>
				</div>
				<div class="large-3 mobile-12 columns">
					<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
					<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
					<% } else { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
					<% } %>
				</div>
			<% } else { %>
				<div class="large-3 columns hide-for-mobile-only">
					<h5 class="text-sm gray-base-text">
						<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
							<i class="mdi mdi-tie white-text"></i>
						</span>
						&nbsp;{{ transtp('mentoring.mentor-role') }}
					</h5>
				</div>
				<div class="large-3 mobile-12 columns">
					<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
					<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
					<% } else { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
					<% } %>
				</div>
			<% } %>
			<div class="large-1 columns">
				<span  data-tooltip aria-haspopup="true" title="Mentoría Rechazada">
					<i class="mdi mdi-24px mdi-close gray-base-text"></i>
				</span>
			</div>
		</div>
	</script>

	<script type="text/template" id="session-mentorig-tpl">
		<div class="large-12 columns container-targets">
			<div class="large-1 mobile-3 columns">
				<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
			</div>
			<div class="large-4 mobile-9 columns">
				{{-- description describe el titulo de la sesión o sesione --}}
				<h4 class="text-md gray-base-text"><%- description %></h4>
				<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_usuario_emprendedor}) )  %>"  class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
			</div>
				<% if(typeof mentor !== 'undefined' && mentor) { %>
					<div class="large-3 hide-for-mobile-only columns">
						<h5 class="text-sm gray-base-text">
						<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
							<i class="mdi mdi-tie white-text"></i>
						</span>
						&nbsp;{{ transtp('mentoring.mentor-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 columns">
						<p class="text-sm gray-base-text hide-for-mobile-only">Nueva solicitud de sesión</p>
						<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
						<% } else { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
						<% } %>
					</div>
				<% } else { %>
					<div class="large-3 hide-for-mobile-only columns">
						<h5 class="text-sm gray-base-text">
						<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es emprendedor" data-options="disable_for_touch:true">
							<i class="mdi mdi-lightbulb white-text"></i>
						</span>
						&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 columns">
						<p class="text-sm gray-base-text hide-for-mobile-only">Nueva solicitud de sesión</p>
						<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
						<% } else { %>
							<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
						<% } %>
					</div>
				<% } %>

			<div class="large-1 columns">
					<% if(emprendedor) { %>
					<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-clock gray-base-text"></i>
						</span>
					<% } else { %>
					<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-human-greeting sky-blue-text"></i>
						</span>
					<% } %>
				</h4>
			</div>
		</div>
	</script>

	<script type="text/template" id="mentoring-finished-tpl">
		<div class="large-12 columns container-targets">
			<div class="large-1 columns">
				<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>"  title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>" class="img-carduser size60 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
			</div>
			<div class="large-4 columns">
				<% if( codigo_estado == window._tp.getState['closed'] && mentor && !evaluation_mentor ||  codigo_estado == window._tp.getState['closed'] && emprendedor && !evaluation_entrepreneur ){ %>
					<a href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>" title="" class="" area-title="¡Evaluar conversación!">
						<h4 class="text-md gray-base-text"><%- descripcion_asesoria %>
					</a>
				<% } else { %>
					<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>"><h4 class="text-md gray-base-text link-process">{{ transtp('mentoria.texto') }}</h4></a>
				<% } %>
				<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>"  class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
			</div>
			<% if(mentor) { %>
				<div class="large-3 columns">
						<h5 class="text-sm gray-base-text">
						<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
							<i class="mdi mdi-tie white-text"></i>
						</span>
						&nbsp;{{ transtp('mentoring.mentor-role') }}
						</h5>
				</div>
				<div class="large-3 columns">
					<p class="text-sm gray-base-text">Ultima actividad</p>
					<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
					<% } else { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
					<% } %>
				</div>
			<% } else { %>
				<div class="large-3 columns">
					<h5 class="text-sm gray-base-text">
					<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es emprendedor" data-options="disable_for_touch:true">
						<i class="mdi mdi-lightbulb white-text"></i>
					</span>
					&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
					</h5>
				</div>
				<div class="large-3 columns">
					<p class="text-sm gray-base-text">Ultima actividad</p>
					<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago   %></small></h4>
					<% } else { %>
						<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
					<% } %>
				</div>
			<% } %>
			<div class="large-1 columns">
				<% if( codigo_estado == window._tp.getState['closed'] && mentor && !evaluation_mentor ||  codigo_estado == window._tp.getState['closed'] && emprendedor && !evaluation_entrepreneur ){ %>
					<a href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>"   data-tooltip aria-haspopup="true" title="Evaluación Pendiente">
						<i class="mdi mdi-24px mdi-check-all sky-blue-text"><small class="text-sm tiny-text">Evaluación Pendiente</small></i>
					</a>
				<% } else { %>
					<span  data-tooltip aria-haspopup="true" title="Proceso Finalizado">
						<i class="mdi mdi-24px mdi-check-all gray-base-text"><small class="text-sm tiny-text">Finalizado</small></i>
					</span>
				<% } %>
			</div>
		</div>
	</script>

	<script type="text/template" id="mentoring-pending-tpl">
		<% if (isMentor) { %>
			<div class="large-12 columns container-targets">
					<div class="large-1 mobile-3 column">
						<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>"  title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>" class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
					</div>
					<div class="large-4 mobile-9 column">
						<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>"><h4 class="text-md gray-base-text">{{ transtp('mentoria.texto') }}</h4></a>
						<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>"  class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
					</div>

					<% if(mentor) { %>
						<div class="large-3 hide-for-mobile-only column">
							<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
							<i class="mdi mdi-tie white-text"></i>
							</span>
								&nbsp;{{ transtp('mentoring.mentor-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 column">
							<p class="text-sm gray-base-text hide-for-mobile-only">{{ transtp('mentoring.newRequestProcess') }}</p>
							<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } else { %>
						<div class="large-3 hide-for-mobile-only column">
							<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es emprendedor" data-options="disable_for_touch:true">
							<i class="mdi mdi-lightbulb white-text"></i>
							</span>
								&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 column">
							<p class="text-sm gray-base-text hide-for-mobile-only">{{ transtp('mentoring.newRequestProcess') }}</p>
							<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } %>
					<div class="large-1 columns">
							<% if(emprendedor) { %>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-clock gray-base-text"></i>
						</span>
							<% } else { %>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-human-greeting sky-blue-text"></i>
						</span>
							<% } %>
					</div>


			</div>
		<% } else if (!isMentor) { %>
			<% if(emprendedor) { %>
				<div class="large-12 columns container-targets">
					<div class="large-1 mobile-3 column">
						<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': emprendedor ? nickname_usuario_mentor : nickname_usuario_emprendedor }) )  %>"><img src="<%- emprendedor ? imagen_usuario_mentor : imagen_usuario_emprendedor %>"  title="<%- emprendedor ? nombre_usuario_mentor : nombre_usuario_emprendedor %>" class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')"></a>
					</div>
					<div class="large-4 mobile-9 column">
						<a href="#" class="redirect___Mentoring" data-mentoring="<%- codigo_asesoria %>">
							<h4 class="text-md gray-base-text">{{ transtp('mentoria.texto') }}</h4>
						</a>
						<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }}
							<a 	href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_emprendimiento}) )  %>"
								class="sky-blue-text"><%- nombre_emprendimiento %>
							</a>
						</p>
					</div>

					<div class="large-3 hide-for-mobile-only column">
						<h5 class="text-sm gray-base-text">
							<span 	class="circle-entrepreneurship entrepreneur icon-18 tip-top radius"
									data-tooltip aria-haspopup="true"
									title="Tu rol es emprendedor"
									data-options="disable_for_touch:true">
							<i class="mdi mdi-lightbulb white-text"></i>
							</span>
								&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
						</h5>
					</div>
					<div class="large-3 mobile-12 column">
						<p class="text-sm gray-base-text hide-for-mobile-only">{{ transtp('mentoring.newRequestProcess') }}</p>
						<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
							<h4 class="text-md gray-base-text">
								<small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small>
							</h4>
						<% } else { %>
							<h4 class="text-md gray-base-text">
								<small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small>
							</h4>
						<% } %>
					</div>

					<div class="large-1 columns">
						<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-clock gray-base-text"></i>
						</span>
					</div>
			<% } %>

				</div>
		<% } %>
	</script>

	{{--  mentoring questions view --}}

	{{-- view mentoring questions on grid --}}
	<script type="text/template" id="mentoring-question-tpl">
	    <td class="vcenter">
	    	<i class="mdi mdi-21 <%- is_open ? 'mdi-lock-open-outline' : 'mdi-lock' %>"></i>
	    </td>
	    <td>
	    	<ul class="inline-list-grid">
	    			<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario_emprendedor %>">
	    				<img src="<%= imagen_usuario_emprendedor %>" alt="<%- nombre_usuario_emprendedor %>" class="rounded-img size45" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">

	    		</li>
	    		<li>
	    			<a href="#" title="<%- descripcion_asesoria %>" class="link-title tp_link-title"> <span class="inst-color-secondary"> <%- window.Misc.maxLen(nombre_emprendimiento, 20) %>: </span><%- window.Misc.maxLen(descripcion_asesoria, 100) %></a>
			        <span class="thin-text text-sm gray-dark-text linear-span">Creado por
			        	<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario_emprendedor %>" class="inst-color-secondary"><%= window.Misc.strToNickname(nickname_usuario_emprendedor) %></a>
			        	<%- window.moment([fecha_asesoria, hora_asesoria].join(''), "YYYY MM DD HH mm ss").format("D MMMM YYYY, h:mm a") %>
			        </span>
	    		</li>
	    	</ul>
	    </td>
	    <td class="text-center">
	    	<% if(mentor){ %>
	    		<span class="circle-entrepreneurship mentor icon-21 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
		    		<i class="mdi mdi-tie"></i>
	    		</span>
		    <% }else{ %>
		    	<span class="circle-entrepreneurship entrepreneur icon-21 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Emprendedor" data-options="disable_for_touch:true">
		    		<i class="mdi mdi-lightbulb"></i>
		    	</span>
		    <% } %>
	    </td>
	    <td class="text-left">
	    	<%- nombre_tipo_asesoria %>
	    </td>
		<% if( codigo_estado == window._tp.getState['active'] ){ %>
	    <td class="text-right">
	    	<% if( typeof mentor !== 'undefined' && mentor && !evaluation_mentor || emprendedor && !evaluation_entrepreneur ){ %>
				<a href="#" class="button xsmall sky-blue radius btn-lowerc btn-clean-margin" data-dropdown="drop-opts-mentoring-question1" aria-controls="drop-opts-mentoring-question" data-options="is_hover:false;align:bottom">Opciones</a>
				<ul id="drop-opts-mentoring-question1" data-dropdown-content class="opts-action-dropdown radius arrow text-left" aria-hidden="true">
					<li>
						<a id="opt-close-mentoring-question" href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>">Finalizar pregunta</a>
					</li>
					<!-- <li>
						<a href="#">Solicitar sesión</a>
					</li> -->
				</ul>
			<% } %>
	    </td>
        <% } else if( codigo_estado == window._tp.getState['closed'] ){ %>
	    <td class="text-right">
	    	<% if( mentor && !evaluation_mentor || emprendedor && !evaluation_entrepreneur ){ %>
				<a href="#" class="button xsmall sky-blue radius btn-lowerc btn-clean-margin" data-dropdown="drop-opts-mentoring-question2" aria-controls="drop-opts-mentoring-question" data-options="is_hover:false;align:bottom">Opciones</a>
				<ul id="drop-opts-mentoring-question2" data-dropdown-content class="opts-action-dropdown radius arrow text-left" aria-hidden="true">
					<li>
						<a id="opt-evaluate-mentoring-question" href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>">Evaluar</a>
					</li>
				</ul>
			<% }else{ %>
                <%- nombre_estado %>
            <% } %>
	    </td>
		<% }else{ %>
			<td class="text-center">
				<% if( codigo_estado == window._tp.getState['pending'] ){ %>
					<% if( mentor && !evaluation_mentor ){ %>
						<%- nombre_estado %> por aprobar
					<% } %>

					<% if( emprendedor && !evaluation_entrepreneur ){ %>
						<%- nombre_estado %> por aprobación
					<% } %>
				<% } %>

				<% if( codigo_estado == window._tp.getState['rejected'] ){ %>
					<%- nombre_estado %>
				<% } %>
			</td>
		<% } %>
	</script>

	{{-- view mentoring questions on list --}}
	<script type="text/template" id="mentoring-question-list-tpl">
		<div class="item-carduser-list item-wrap-list radius">
			<div class="top-item-carduser">
				<ul class="inline-list-grid">
					<li class="has-image">
						<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario_emprendedor %>">
							<img src="<%= imagen_usuario_emprendedor %>" alt="<%- nombre_usuario_emprendedor %>" class="img-carduser size50" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</a>
					</li>
					<li>
						<ul class="no-bullet">
							<li>
								<h6 class="bold-header carduser-name inst-color-secondary">
									<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario_emprendedor %>"><%- nombre_usuario_emprendedor %></a>
								</h6>
							</li>
							<li>
								<a href="<%- window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario_emprendedor %>">
									<span class="text-sm dark-text"><%- window.Misc.strToNickname(nickname_usuario_emprendedor) %></span>
								</a>
							</li>
							<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad) && nombre_ciudad.length) { %>
								<li>
									<span class="text-sm thin-text gray-base-text"><i class="mdi mdi-map-marker-radius mdi-14 mdi-center"></i><%- nombre_ciudad %>, <%- nombre_pais %></span>
								</li>
							<% } %>
						</ul>
					</li>
				</ul>
			</div>

			<div class="content-item-carduser no-border">
				<dl class="inner-sections-carduser">
					<dd>
						<div class="section-description-card section-detail">
							<label class="text-sm clearfix">
								<ul class="inline-list-grid align-top">
									<li>
										<span class="light-text">Tema:</span>
										<span class="dark-text upper-text"><%- nombre_tipo_asesoria %></span>
									</li>
									<li class="text-right">
										<i class="mdi mdi-16 vcenter <%- is_open ? 'mdi-lock-open-outline' : 'mdi-lock' %>"></i>
									</li>
								</ul>
							</label>
							<span class="inst-color-secondary"> <%- window.Misc.maxLen(nombre_emprendimiento, 20) %>
							</span>
							<p class="block-text-small ellipsis"><%- descripcion_asesoria %></p>
						</div>
					</dd>
					{{-- <dd>
						<i class="mdi mdi-tag-outline secondary mdi-18 icon-info-card"></i>
						<span>Mercadeo, Finanzas, Informática, Innvación.</span>
					</dd> --}}
					<dd>
						<label class="label single text-sm"><em>Evaluación:</em></label>
                        <% if( codigo_estado == window._tp.getState['active'] ){ %>
                            <% if(mentor && !evaluation_mentor || emprendedor && !evaluation_entrepreneur ){ %>
                                <a href="#" class="button tiny sky-blue radius btn-lowerc btn-clean-margin" data-dropdown="drop-opts-mentoring-question" aria-controls="drop-opts-mentoring-question" data-options="is_hover:false;align:top">Opciones</a>
                                <ul id="drop-opts-mentoring-question" data-dropdown-content class="opts-action-dropdown radius arrow text-left" aria-hidden="true">
                                    <li>
                                        <a id="opt-close-mentoring-question" href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>">Finalizar pregunta</a>

                                    </li>
                                </ul>
                            <% } %>
                        <% } else if( codigo_estado == window._tp.getState['closed'] ){ %>
                            <% if(mentor && !evaluation_mentor || emprendedor && !evaluation_entrepreneur ){ %>
                                <a href="#" class="button tiny sky-blue radius btn-lowerc btn-clean-margin" data-dropdown="drop-opts-mentoring-question" aria-controls="drop-opts-mentoring-question" data-options="is_hover:false;align:top">Opciones</a>
                                <ul id="drop-opts-mentoring-question" data-dropdown-content class="opts-action-dropdown radius arrow text-left" aria-hidden="true">
                                    <li>
                                        <a id="opt-evaluate-mentoring-question" href="<%- Route.route('mentoria.preguntas.evaluacion.mentor.create', {'user': codigo_asesoria}) %>">Evaluar</a>
                                    </li>
                                </ul>
                            <% } else { %>
                                <%- nombre_estado %>
                            <% } %>
                         <% } else { %>

                            <% if( codigo_estado == window._tp.getState['pending'] ){ %>
                                <% if( mentor && !evaluation_mentor ){ %>
                                    <%- nombre_estado %> por aprobar
                                <% } %>

                                <% if( emprendedor && !evaluation_entrepreneur ){ %>
                                    <%- nombre_estado %> por aprobación
                                <% } %>
                            <% } %>

                            <% if( codigo_estado == window._tp.getState['rejected'] ){ %>
                                <%- nombre_estado %>
                            <% } %>
                         <% } %>
					</dd>
					<dd class="text-center">
						<% if(mentor){ %>
							<span class="circle-entrepreneurship mentor icon-21 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
					    		<i class="mdi mdi-tie"></i>
							</span>
					    <% }else{ %>
					    	<span class="circle-entrepreneurship entrepreneur icon-21 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Emprendedor" data-options="disable_for_touch:true">
					    		<i class="mdi mdi-lightbulb"></i>
					    	</span>
					    <% } %>
					</dd>
				</dl>
			</div>

			<div class="bottom-item-carduser clearfix">
				<ul class="inline-list-grid">
					<li class="clearfix text-left">
						<i class="mdi mdi-calendar sky-blue mdi-18 icon-info-card vcenter"></i>
						<span class="light-text text-sm"><%- window.moment([fecha_asesoria, hora_asesoria].join(''), "YYYY MM DD HH mm ss").format("DD-MM-YYYY h:mm a") %></span>
					</li>
					<li class="clearfix text-right">
						<a href="#" class="button xsmall white-skyblue btn-shadow btn-lowerc radius is-hovered btn-clean-margin tp_link-title">Ver más</a>
					</li>
				</ul>
			</div>
	    </div>
	</script>

	{{-- Section Feedback Mentoring --}}
	<script type="text/template" id="mentoring-feedback-tpl">
		<section id="mentoring-feedback-section">
			{{-- header panel --}}
			<div id="header-mentoring-feedback" class="large-12 columns no-padding">
				<% if (estado === window._tp.getState['active']) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
						<div class="large-1 mobile-3 columns center">
							<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size70 center-block rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-6 mobile-9 columns">
							<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
							<strong class="text-lg white-text"><%- mentor ? short_name_emprendedor : short_name_mentor %></strong><br>
							<small class="text-sm white-text">En proceso</small> {{--  Solicitud aceptada --}}
							<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
								<p class="white-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago   %></small></p>
							<% } else { %>
								<p class="white-text"> No se encontro actividad reciente </p>
							<% } %>
							{{-- <small class="text-sm gray-base-text">Ultima actividad de <strong> usuario </strong> hace <strong> 5 dias </strong> </small> --}}
						</div>
						<div class="large-5 columns">
							<button class="btn btn-sm full-width conclude__Mentoring radius z-depth-1 white-skyblue"> <i class="mdi mdi-close mdi-18px"></i> {{ transtp('mentoring.endProcess') }} </button>
						</div>
					</div>
				 <% } else if (estado === window._tp.getState['pending'] && mentor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
					<div class="large-1 mobile-12 columns center">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-6 mobile-12 columns">
						<small class="text-xlg white-text"><%- nombre_usuario_emprendedor %></small><br>
						<small class="text-md white-text">@<%- nickname_usuario_emprendedor %> - <small class="text-mb gray-light-text">Bogotá - Colombia</small></small><br>
						<small class="text-md white-text"><%- descripcion_emprendimiento %></small>
					</div>
					<div class="large-5 columns">
					   <small class="text-md white-text right"><i class="mdi mdi-human-greeting"></i> &nbsp; <strong class="text-mb gray-light-text"><%- short_name_emprendedor %></strong> te ha solicitado este proceso de mentoria </small><br>
					   <div class="row" id="container-buttons">
						  <div class="large-6 columns">
							 <button class="full-width accept__Mentoring btn-sm radius z-depth-1"> Aceptar solicitud </button>
						  </div>
						  <div class="large-6 columns left">
							 <button class="full-width refuse__Mentoring btn-sm radius z-depth-1 white-skyblue"> <i class="mdi mdi-human-greeting"></i> Rechazar solicitud </button>
						  </div>
					   </div>
					</div>
				 </div>
				 <% } else if (estado === window._tp.getState['closed'] && mentor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
					<div class="large-1 mobile-12 columns center">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-6 mobile-12 columns">
						<small class="text-xlg white-text"><%- nombre_usuario_emprendedor %></small><br>
						<small class="text-md white-text">@<%- nickname_usuario_emprendedor %> - <small class="text-mb gray-light-text">Bogotá - Colombia</small></small><br>
						<small class="text-md white-text"><%- descripcion_emprendimiento %></small>
					</div>
					<div class="large-5 columns">
						<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
						<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- short_name_emprendedor %></strong></small><br>
						<small class="text-sm gray-light-text">Proceso Finalizado</small>
					</div>
				 </div>
				 <% } else if (estado === window._tp.getState['finalized'] && mentor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
					<div class="large-1 mobile-12 columns center">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-6 mobile-12 columns">
						<small class="text-xlg white-text"><%- nombre_usuario_emprendedor %></small><br>
						<small class="text-md white-text">@<%- nickname_usuario_emprendedor %> - <small class="text-mb gray-light-text">Bogotá - Colombia</small></small><br>
						<small class="text-md white-text"><%- descripcion_emprendimiento %></small>
					</div>
					<div class="large-5 columns">
						<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
						<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- short_name_emprendedor %></strong></small><br>
						<small class="text-sm gray-light-text">Proceso Finalizado</small>
					</div>
				 </div>
				 <% } else if (estado === window._tp.getState['rejected'] && mentor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
					<div class="large-1 mobile-12 columns center">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-6 mobile-12 columns">
						<small class="text-xlg white-text"><%- nombre_usuario_emprendedor %></small><br>
						<small class="text-md white-text">@<%- nickname_usuario_emprendedor %> - <small class="text-mb gray-light-text">Bogotá - Colombia</small></small><br>
						<small class="text-md white-text"><%- descripcion_emprendimiento %></small>
					</div>
					<div class="large-5 columns">
						<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
						<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- short_name_emprendedor %></strong></small><br>
						<small class="text-sm gray-light-text">Proceso Rechazado</small>
					</div>
				 </div>
				 <% } else if (estado === window._tp.getState['pending'] && emprendedor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
						<div class="large-1 mobile-12 columns">
							<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img center block-center" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-6 mobile-12 columns">
							<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
							<small class="text-lg white-text"><%- nombre_usuario_mentor %></small><br>
							<small class="text-sm gray-light-text">Solicitud enviada</small>
						</div>

						<div class="large-5 columns">
						<small class="text-md white-text right"><i class="mdi mdi-clock gray-light-text"></i> &nbsp; Has solicitado este proceso de mentoria a  <strong class="text-mb gray-light-text"><%- nombre_usuario_mentor %></strong></small><br><br>
							<button class="full-width cancel__Mentoring btn-sm radius z-depth-1 white-skyblue"> <i class="mdi mdi-close"></i> Cancelar solicitud de mentoria </button>
						</div>
					</div>

				<% } else if (estado === window._tp.getState['closed'] && emprendedor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
						<div class="large-1 mobile-12 columns">
							<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img center block-center" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-6 mobile-12 columns">
							<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
							<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- nombre_usuario_mentor %></strong></small><br>
							<small class="text-sm gray-light-text">Proceso Finalizado</small>
						</div>
					</div>
				<% } else if (estado === window._tp.getState['finalized'] && emprendedor) { %>
					<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
						<div class="large-1 mobile-12 columns">
							<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img center block-center" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
						</div>
						<div class="large-6 mobile-12 columns">
							<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
							<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- nombre_usuario_mentor %></strong></small><br>
							<small class="text-sm gray-light-text">Proceso Finalizado</small>
						</div>
					</div>
					<% } else if (estado === window._tp.getState['rejected'] && emprendedor) { %>
						<div class="rows panel rounded z-depth-1 columns gray-dark-bg">
							<div class="large-1 mobile-12 columns">
								<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size80 rounded-img center block-center" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
							</div>
							<div class="large-6 mobile-12 columns">
								<small class="text-sm white-text">{{ transtp('mentoring.processWith') }}</small><br>
								<small class="text-lg white-text"> <strong class="text-mb gray-light-text"><%- nombre_usuario_mentor %></strong></small><br>
								<small class="text-sm gray-light-text">Proceso Rechazado</small>
							</div>
						</div>
					 <% } %>
			</div>
		</section>

		<section id="mentoring-feedback-form">
			<!-- proceso de mentoria formulario-->

				<div class="row">
					<div class="large-12 columns no-padding" id="container-sessions-proccess-list">
						<div class="large-6 columns">
							<p class="label single gray-base-text">Última actividad de <strong class="gray-dark-text"><%- short_name_mentor %></strong> hace <span class="bold-text gray-dark-text"><%- ultimo_ingreso_mentor_ago %></span></p>
							<div class="panel z-depth-1 no-padding">
								<div class="panel-header gray-light-alt-bg">
									<h4 class="dark-text thin-text title-session"><!-- renderizar #title-session-tpl --></h4>
									<p class="dark-text thin-text">Etapa: <%- etapaProyecto %></p>
								</div>
								<% if(sessions.total_entries > 0) { %>

								<div class="panel-body body-session-content">
									<div class="row">
										<div class="small-12 columns">
											@include('public.noresults')
										</div>
									</div>
									<!-- renderizar item de sesiones -->
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="columns" id="buttonAcceptMentoring"></div>
									</div>
									<div class="row">
										<div class="large-11 columns">
												<% if (mentor) { %>
													<small class="text-sm sky-blue-text">Haz clic aquí y revisa tu disponibilidad en el calendario</small>
													<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario_mentor}) %>" class="right button tiny sky-blue radius btn-shadow btn-lowerc"><span>Agenda Sesión</span></a>
												<% } else { %>
													<% if(estado === window._tp.getState['active']) { %>
														{{-- <p class="text-md gray-base-text"><%- short_name_mentor %> ha aceptado tu solicitud de mentoria</p> --}}
														<p class="text-md gray-base-text">Mentoría en proceso</p>
													<% } %>
													<small class="text-sm sky-blue-text">Haz clic aquí y revisa la agenda de <%- short_name_mentor %> en el calendario</small>
													<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario_mentor}) %>" class="right button tiny sky-blue radius btn-shadow btn-lowerc"><span>Revisar Agenda</span></a>
												<% } %>
										</div>
									</div>
								</div>
								<% } else { %>
									<div class="panel-body">
										<div class="row">
											<div class="large-1 columns">
											</div>
											<div class="large-11 columns">
													<% if (mentor) { %>
														<small class="text-sm sky-blue-text">Haz clic aquí y revisa tu disponibilidad en el calendario</small>
														<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario_mentor}) %>" class="right button tiny sky-blue radius btn-shadow btn-lowerc"><span>Agenda Sesión</span></a>
													<% } else { %>
														<% if(estado === window._tp.getState['active']) { %>
															<p class="text-md gray-base-text">Mentoría en proceso</p>
														<% } %>
														<small class="text-sm sky-blue-text">Haz clic aquí y revisa la agenda de <%- short_name_mentor %> en el calendario</small>
														<a href="<%- Route.route('mentoria.mentores.show', {'mentores': nickname_usuario_mentor}) %>" class="right button tiny sky-blue radius btn-shadow btn-lowerc"><span>Revisar Agenda</span></a>
													<% } %>
											</div>
										</div>
									</div>
								<% } %>
							</div>
							<div id="attachedMentoring"></div>
						</div>
						<p class="label single gray-base-text right">Última actividad de <strong class="gray-dark-text"><%- short_name_emprendedor %></strong> hace <span class="bold-text gray-dark-text"><%- ultimo_ingreso_emprendedor_ago %></span></p>
						<div class="large-6 columns">

							<% if(estado === window._tp.getState['pending']) { %>

							<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
								<div class="row">
									<div class="large-1 mobile-2 columns">
										<span>
											<i class="mdi mdi-clock gray-light-text mdi-24px"></i>
										</span>
									</div>
									<div class="large-11 mobile-10 columns">
										<% if (mentor) { %>
										<p class="text-md gray-light-text">Acepta la solicitud de mentoria de <%- short_name_emprendedor %> para comenzar a chatear</p>
										<% } else { %>
										<p class="text-md gray-light-text">Esperando aceptación de mentoria de <%- short_name_mentor %> para comenzar a chatear</p>
										<% } %>
									</div>
								</div>
							</div>
							{{-- <% } else if(estado == window._tp.getState['closed'] || estado == window._tp.getState['finalized'] ){ %>
								<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
									<div class="row">
										<div class="large-1 mobile-2 columns">
											<span>
												<i class="mdi mdi-check-all gray-light-text mdi-24px"></i>
											</span>
										</div>
										<div class="large-11 mobile-10 columns">
											<p class="text-md gray-light-text">El proceso de mentoría finalizó</p>
										</div>
									</div>
								</div> --}}
							<% } else if(estado === window._tp.getState['rejected']) { %>

								<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
									<div class="row">
										<div class="large-1 mobile-2 columns">
											<span>
												<i class="mdi mdi-close gray-light-text mdi-24px"></i>
											</span>
										</div>
										<div class="large-11 mobile-10 columns">
											<% if (mentor) { %>
											<p class="text-md gray-light-text">Rechazaste la solicitud de mentoria de <%- short_name_emprendedor %> </p>
											<% } else { %>
											<p class="text-md gray-light-text">La mentoría fue rechazada por <%- short_name_mentor %>  </p>
											<% } %>
										</div>
									</div>
								</div>

							<% } else { %>
								<div id="discusionMentoring"></div>
							<% } %>
						</div>
					</div>

					</div>
				</div>

	</script>

	<script type="text/template" id="discusion-mentoring-tpl">
		<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
			<% if (!finished && estado_session != window._tp.getState['closed']) { %>
				@if(Auth::check())
					{{-- <% if( (estado != window._tp.getState['closed']) && (estado != window._tp.getState['rejected']) && (estado != window._tp.getState['finalized'])  ){ %> --}}
					{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-advice') ) !!}
					<div class="textarea-post-discussion clearfix">
						<textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" cols="50" rows="2" pattern="max_char_textarea" class="materialize-textarea validate"></textarea>
						<label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
						<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
					</div>
					<input type="hidden" name="codigo_asesoria" value="<%= codigo_mentoria %>" />
					{!! Form::close() !!}
				@endif
				@include('public.noresults', ['message' => 'No hay discusiones'])
				<section id="discussion-posts-wrap" class="">
					{{-- Render Tasks template --}}
				</section>
			<% } else { %>
				<div class="row">
					<span>
						<i class="mdi mdi-clock gray-light-text mdi-24px"></i>
					</span>
					<div class="large-11 mobile-10 columns">
						<p class="text-md gray-light-text">Session de Mentoria Finalizada</p>
					</div>
				</div>
			<% } %>
		</div>
		<br>
		{{--  <% if(emprendedor && estado_session === window._tp.getState['pending_accept']) { %>
			<a href="#" id="button-accept-mentoring" class="button xtiny sky-blue btn-shadow btn-lowerc radius" data-mentoring="<%- mentoring %>" title="Acepto">Acepto lo realizado en la mentoría</a>
		<% } %>  --}}
	</script>

	<script type="text/template" id="attached-mentoring-tpl">
		<div class="panel z-depth-1">
			<div class="panel-header">
				<h3 class="thin-header inst-color-secondary"> Documentos adjuntos</h3>
				<% if( estado == window._tp.getState['pending'] ){ %>
				<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
					<div class="row">
						<div class="large-1 mobile-2 columns">
							<span>
								<i class="mdi mdi-clock gray-light-text mdi-24px"></i>
							</span>
						</div>
						<div class="large-11 mobile-10 columns">
							<% if (mentor) { %>
							<p class="text-md gray-light-text">Acepta la solicitud de mentoria de <%- short_name_emprendedor %> para comenzar a chatear</p>
							<% } else { %>
							<p class="text-md gray-light-text">Esperando aceptación de mentoria de <%- short_name_mentor %> para comenzar a chatear</p>
							<% } %>
						</div>
					</div>
				</div>
				<% } else if(estado == window._tp.getState['rejected'] ){ %>
				<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
					<div class="row">
						<div class="large-1 mobile-2 columns">
							<span>
								<i class="mdi mdi-close gray-light-text mdi-24px"></i>
							</span>
						</div>
						<div class="large-11 mobile-10 columns">
							<% if (mentor) { %>
							<p class="text-md gray-light-text">Rechazaste la solicitud de mentoria de <%- short_name_emprendedor %> </p>
							<% } else { %>
							<p class="text-md gray-light-text">La mentoría fue rechazada por <%- short_name_mentor %>  </p>
							<% } %>
						</div>
					</div>
				</div>
				{{-- <% } else if(estado == window._tp.getState['closed'] || estado == window._tp.getState['finalized'] ){ %>
				<div class="panel radius z-depth-1" id="wrapper-posts-discussion">
					<div class="row">
						<div class="large-1 mobile-2 columns">
								<span>
									<i class="mdi mdi-check-all gray-light-text mdi-24px"></i>
								</span>
						</div>
						<div class="large-11 mobile-10 columns">
							<p class="text-md gray-light-text">El proceso de mentoría finalizó</p>
						</div>
					</div>
				</div> --}}
				<% } else { %>
					<% if (!finished && estado_session != window._tp.getState['closed'] && estado_session != window._tp.getState['pending_accept']) { %>
						<section id="wrap-documents" class="">
							{{-- Render Documents --}}
						</section>
					<% } else { %>
						<div class="row">
							<span>
								<i class="mdi mdi-clock gray-light-text mdi-24px"></i>
							</span>
							<div class="large-11 mobile-10 columns">
								<p class="text-md gray-light-text">Session de Mentoria Finalizada</p>
							</div>
						</div>
					<% } %>
				<% } %>

			</div>
		</div>
	</script>

	<script type="text/template" id="title-session-tpl">
		<div class="row">
			<div class="large-6 columns">
				<h4 class="dark-text thin-text"><%- !list ? 'Sesiones' : 'Desarrollo de sesiones' %></h4>
			</div>
			<% if(list) { %>
				<div class="large-6 columns">
					<a href="#" class="back__Tosession"><strong class="gray-light-text thin-text right text-sm ">Salir a sesiones &nbsp; <i class="mdi mdi-close mdi-24px"></i></strong></a>
				</div>
			<% } %>
		</div>
	</script>

	<script type="text/template" id="buttonAcceptMentoring-tpl">
		<% if(emprendedor && estado === window._tp.getState['pending_accept']) { %>
			<a href="#" id="button-accept-mentoring" class="button xtiny sky-blue btn-shadow btn-lowerc radius" data-mentoring="<%- codigo_mentoria %>" title="Acepto">Acepto lo realizado en la mentoría</a>
		<% } %>
	</script>

	<script type="text/template" id="mentoring-confirm-close-tpl">
		<p>{{ Lang::get('mentoring.close.confirm') }}</p>
	</script>

	<script type="text/template" id="calendar-mentoring-tpl">
		<div class="row">
			<div class="small-11 small-centered columns">
				<!-- <select name="codigo_asesor" class="chosen-select" id="chosen-advisers" data-placeholder="Seleccione un Mentor" data-chosenopts="{'url':'{{ URL::route('proyecto.mentoremprendimiento.index') }}','type':'setitems','setvalue': '','data':{'codigo_proyecto':'<%- codigo_proyecto %>'}}">
					<option value=""></option>
				</select> -->
			</div>
		</div>
		<div id="calendar-mentoring" class="calendar-mentoring"></div>
	</script>

	<script type="text/template" id="not-result-sessions-calendar-tpl">
		<div class="row">
			<div class="large-1 columns">
					<span>
						<i class="mdi mdi-check sky-blue mdi-24px"></i>
					</span>
			</div>
			<div class="large-11 columns">
				<p class="text-md gray-base-text"><%- short_name_mentor %> ha aceptado tu solicitud de mentoria</p>
				<a class="text-sm sky-blue-text">Haz clic aquí y revisa la disponibilidad de <%- short_name_mentor %> en el calendario</a>
			</div>
		</div>
		<br>
	</script>




	{{-- ------------------ Mentoring Evaluation Templates JS -------------------- --}}
	{{-- Section Mentoring Evaluation --}}
	<script type="text/template" id="mentoring-sessions-list-tpl">
		<div class="row">
			<div class="small-12 columns">
				<div class="wrap-pagination">
					<!-- Render Pagination-->
				</div>
				<table role="grid" class="table-content" id="browse-list-mentoring-sessions" width="100%">
					<thead>
						<tr>
							<th width="30%">Descripción</th>
							<th width="20%">Fecha</th>
							<th width="20%">Estado</th>
							<th width="20%" class="text-right">Evaluación</th>
						</tr>
					</thead>
					<tbody>
						<!-- Render view id:mentoring-evaluation-item-list-tpl -->
					</tbody>
				</table>
				@include('public.noresults')
				<div class="wrap-pagination">
					<!-- Render Pagination-->
				</div>
				<div class="content-mentoring-evaluation">
				</div>
			</div>
		</div>
	</script>

	{{-- item Mentoring Evaluation --}}
	<script type="text/template" id="mentoring-session-item-list-tpl">
		<td>
			<ul class="inline-list-grid">
	    		<li class="has-image">
	    			<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': mentor ? nickname_usuario_emprendedor : nickname_usuario_mentor }) ) %>" title="<%- mentor ? nombre_usuario_emprendedor : nombre_usuario_mentor %>">
	    				<img src="<%- mentor ? imagen_usuario_emprendedor : imagen_usuario_mentor %>" alt="<%- mentor ? nombre_usuario_emprendedor : nombre_usuario_mentor %>" class="rounded-img size40">
	    			</a>
	    		</li>
	    		<li>
	    			<a href="<%- Route.route('mentoria.{rol?}.sesiones.show', { 'rol' : rol, 'sesiones': url_mentoria }) %>" class="link-title" ><%- window.Misc.maxLen(descripcion_mentoria, 100) %></a>
			        <span class="thin-text text-sm"><%- mentor ? '{{ Lang::get('mentoring.rol.entrepreneur') }}' : '{{ Lang::get('mentoring.rol.mentor') }}' %>
			        	<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': mentor ? nickname_usuario_emprendedor : nickname_usuario_mentor }) ) %>" title="<%- mentor ? nombre_usuario_emprendedor : nombre_usuario_mentor %>"><%= window.Misc.strToNickname(mentor ? nickname_usuario_emprendedor : nickname_usuario_mentor) %></a>
			        </span>
	    		</li>
	    	</ul>
	    </td>
		<td>
			<span class="light-text text-sm">desde:
				<strong class="dark-text"><%- window.moment(fecha_evento, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD") %></strong>
				<span class="thin-text dark-text"><%- window.moment(hora_inicio_evento, "HH:mm:ss").format("h:mm a") %></span>
			</span>
			<br>
			<span class="light-text text-sm">hasta:
				<strong class="dark-text"><%- window.moment(fecha_fin_evento, "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD") %></strong>
				<span class="thin-text dark-text"><%- window.moment(hora_fin_evento, "HH:mm:ss").format("h:mm a") %></span>
			</span>
		</td>
		<td>
		<% if(mentor) { %>
			<% if(estado_evento == window._tp.getState['confirm']) { %>
				<a href="#" id= "button-confirm-sesion" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Confirmar">Confirmar</a>
				<a href="#" id= "button-cancel-sesion" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Cancelar">Cancelar</a>
			<% }else{ %>
				<%- nombre_estado %>
			<% } %>
			{{-- Entrepreneurs --}}
		<% }else { %>
			<% if(estado_evento == window._tp.getState['confirm']) { %>
				<a href="#" id= "button-cancel-sesion" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Cancelar">Cancelar</a>
			<% }else{ %>
				<%- nombre_estado %>
			<% } %>
		<% } %>
		</td>
		<td class="text-right">
			<% if(evaluacion) { %>
				{{-- Mentor Evaluation --}}
				<% if(mentor) { %>
					<% if(_.isUndefined(codigo_evaluacion_tarea) || _.isNull(codigo_evaluacion_tarea)) { %>
						<a href="<%= Route.route( 'mentoria.{rol?}.sesiones.calificacion.create',{'rol' : 'mentor', m: url_mentoria}) %>" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Evaluar emprendedor">Evaluar Emprendedor</a>
					<% }else{ %>
						<span class="button xtiny white disabled btn-shadow btn-lowerc radius disabled">Ya has evaluado a este emprendedor</span>
					<% } %>
				{{-- Entrepreneur Evaluation --}}
				<% } else if(_.isUndefined(codigo_evaluacion_mentoria) || _.isNull(codigo_evaluacion_mentoria)) { %>
					<a href="<%= Route.route( 'mentoria.{rol?}.sesiones.evaluacion.create', {'rol' : 'emprendedor', m: url_mentoria}) %>" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Evaluar emprendedor">Evaluar Mentor</a>
				<% }else{ %>
					<span class="button xtiny white disabled btn-shadow btn-lowerc radius disabled">Ya has evaluado a este mentor</span>
				<% } %>
			<% } %>
		</td>
	</script>

	<script type="text/template" id="mentoring-session-process-item-list-tpl">
	<div class="row" id="<%- id_mentoria %>">
		<% if (typeof(mentor) !== 'undefined' && mentor) { %>
			<div class="large-1 mobile-2 columns">
			<% if (typeof estado  !== 'undefined' && estado == window._tp.getState['pending'] ) { %>
				<span>
					<i class="mdi mdi-human-greeting sky-blue mdi-24px"></i>
				</span>
			<% } else { %>
				<span>
					<i class="mdi mdi-check sky-blue mdi-24px"></i>
				</span>
			<% } %>
			</div>
			<div class="large-10 mobile-8 columns">
				<h4 class="text-md gray-base-text"><%- typeof(description) !== 'undefined' ? description : '' %></h4>
				<p class="text-sm dark-text"><%- typeof(nombre_usuario_emprendedor) !== 'undefined' ? nombre_usuario_emprendedor : '' %> - &nbsp; <small class="text-sm gray-base-text hora"> <%- window.moment([fecha_evento, hora_inicio].join(' ')).format("dddd, D [de] MMMM [de] YYYY, h:mm a") %></small></p>
			</div>
		<% } else { %>
			<div class="large-1 mobile-2 columns">
				<% if (typeof estado !== 'undefined' && estado == window._tp.getState['pending'] ) { %>
					<span>
						<i class="mdi mdi-clock sky-blue mdi-24px"></i>
					</span>
				<% } else { %>
						<span>
							<i class="mdi mdi-check sky-blue mdi-24px"></i>
						</span>
				<% } %>

			</div>
			<div class="large-10 mobile-8 columns">
				{{-- <h4 class="text-md gray-base-text"><%- typeof(nombre_usuario_mentor) !== 'undefined' ? nombre_usuario_mentor : '' %></h4> --}}
				<h4 class="text-md gray-base-text"><%- typeof(description) !== 'undefined' ? description : '' %></h4>
				<p class="text-sm dark-text"><%- typeof(nombre_usuario_emprendedor) !== 'undefined' ? nombre_usuario_emprendedor : '' %>  - &nbsp; <small class="text-sm gray-base-text"> <%- window.moment([fecha_evento, hora_inicio].join(' ')).format("dddd, D [de] MMMM [de] YYYY, h:mm a") %></small></p>
			</div>
		<% } %>
		<div class="large-1 mobile-2 columns">
			<a data-dropdown="drop-<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : 0 %>" aria-controls="drop-<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : 0 %>" data-options="align:right">
				<i class="mdi mdi-dots-vertical mdi-36px">
				</i>
			</a>
		</div>

		<div class="mobile-12 columns">
			<ul id="drop-<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : 0 %>" class="f-dropdown" data-dropdown-content>
				<div class="panel" id="panel-options-<%- id_mentoria %>">
					<% if( emprendedor && (estado == window._tp.getState['pending_accept'] || estado != window._tp.getState['closed']) || mentor && (estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed']) ) { %>
						<li><a href="#" class="modify__Session no-decoration" data-finished="<%- false %>" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Sesión en Desarrollo<i class="mdi mdi-calendar-clock mdi-18px gray-light-text right"></i></a></li>
					<% } %>

					<% if ((can_finish_mentoring && mentor && (estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed'])) ) { %>
						<li><a href="#" class="modify__Session_Finished no-decoration" data-finished="<%- true %>" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Finalizar Sesión<i class="mdi mdi-calendar-remove mdi-18px gray-light-text right"></i></a></li>
					<% }%>

					<% if ((mentor && (estado == window._tp.getState['pending_accept'] || estado == window._tp.getState['closed']) || emprendedor && estado == window._tp.getState['closed'])  ) { %>
						<li><a href="#" class="modify__Session no-decoration" data-finished="<%- true %>"  data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Ver Sesión<i class="mdi mdi-calendar-remove mdi-18px gray-light-text right"></i></a></li>
					<% } %>


					<% if(estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed']) { %>
						<li><a href="#" class="cancel__Session no-decoration" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Cancelar Sesión<i class="mdi mdi-close mdi-18px gray-light-text right"></i></a></li>
					<% } %>
				</div>

			</ul>
		</div>
	</div>
	<br>
	</script>

	<script type="text/template" id="options-session-list-item">
		<% if( emprendedor && (estado == window._tp.getState['pending_accept'] || estado != window._tp.getState['closed']) || mentor && (estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed']) ) { %>
			<li><a href="#" class="modify__Session no-decoration" data-finished="<%- false %>" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Sesión en Desarrollo<i class="mdi mdi-calendar-clock mdi-18px gray-light-text right"></i></a></li>
		<% } %>

		<% if ((mentor && (estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed'])) ) { %>
			<li><a href="#" class="modify__Session_Finished no-decoration" data-finished="<%- true %>" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Finalizar Sesión<i class="mdi mdi-calendar-remove mdi-18px gray-light-text right"></i></a></li>
		<% }%>

		<% if ((mentor && (estado == window._tp.getState['pending_accept'] || estado == window._tp.getState['closed']) || emprendedor && estado == window._tp.getState['closed'])  ) { %>
			<li><a href="#" class="modify__Session no-decoration" data-finished="<%- true %>"  data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Ver Sesión<i class="mdi mdi-calendar-remove mdi-18px gray-light-text right"></i></a></li>
		<% } %>


		<% if(estado != window._tp.getState['pending_accept'] && estado != window._tp.getState['closed']) { %>
			<li><a href="#" class="cancel__Session no-decoration" data-id="<%- typeof id_mentoria !== 'undefined' && id_mentoria ? id_mentoria : '' %>">Cancelar Sesión<i class="mdi mdi-close mdi-18px gray-light-text right"></i></a></li>
		<% } %>
	</script>

	<script type="text/template" id="mentoring-session-calendar-list-item">
		<tr>
			<td class="no-padding">

				<% if(typeof estado !== 'undefined' && estado == window._tp.getState['pending'] ) { %>
				  <div class="large-12 columns container-targets">
					<div class="large-1 mobile-3 columns">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-4 mobile-9 columns">
						<h4 class="text-md gray-base-text"><%- description %></h4>
						<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_usuario_emprendedor}) )  %>"  class="sky-blue-text"><%- short_name_emprendedor %></a></p>
					</div>

					<% if(typeof mentor !== 'undefined' && mentor) { %>
						<div class="large-3 hide-for-mobile-only columns">
							<h5 class="text-sm gray-base-text">
								<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
									<i class="mdi mdi-tie white-text"></i>
								</span>
								&nbsp;{{ transtp('mentoring.mentor-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 columns">
							<p class="text-sm gray-base-text hide-for-mobile-only">Nueva solicitud de sesión</p>
							<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } else { %>
						<div class="large-3 hide-for-mobile-only columns">
							<h5 class="text-sm gray-base-text">
								<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es emprendedor" data-options="disable_for_touch:true">
									<i class="mdi mdi-lightbulb white-text"></i>
								</span>
								&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 columns">
							<p class="text-sm gray-base-text hide-for-mobile-only">Nueva solicitud de sesión</p>
							<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } %>
						<div class="large-1 mobile-12 columns">
							<% if(emprendedor) { %>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-clock gray-base-text"></i>
						</span>
							<% } else { %>
							<span  data-tooltip aria-haspopup="true"  title="Solicitud pendiente">
							<i class="mdi mdi-18px mdi-human-greeting sky-blue-text"></i>
						</span>
							<% } %>
					</div>
				</div>
				<% } else { %>
				<div class="large-12 columns container-targets">
					<div class="large-1 mobile-3 columns">
						<img src="<%- imagen_usuario_emprendedor %>"  class="img-carduser size50 rounded-img center-block" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-4 mobile-9 columns">
						<h4 class="text-md gray-base-text"><%- description %> - <%- estado %> </h4>
						<p class="text-sm gray-base-text">{{ transtp('mentoring.entrepreneurship') }} <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_usuario_emprendedor}) )  %>"  class="sky-blue-text"><%- nombre_emprendimiento %></a></p>
					</div>
					<% if(typeof mentor !== 'undefined' && mentor) { %>
						<div class="large-3 hide-for-mobile-only columns">
							<h5 class="text-sm gray-base-text">
								<span class="circle-entrepreneurship mentor icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es Mentor" data-options="disable_for_touch:true">
								<i class="mdi mdi-tie white-text"></i>
								</span>
									&nbsp;{{ transtp('mentoring.mentor-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 columns">
							<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
							<% if (typeof ultimo_ingreso_mentor_ago != 'undefined' && ultimo_ingreso_mentor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_mentor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } else { %>
						<div class="large-3 hide-for-mobile-only columns">
							<h5 class="text-sm gray-base-text">
							<span class="circle-entrepreneurship entrepreneur icon-18 tip-top radius" data-tooltip aria-haspopup="true" title="Tu rol es emprendedor" data-options="disable_for_touch:true">
							<i class="mdi mdi-lightbulb white-text"></i>
							</span>
								&nbsp;{{ transtp('mentoring.entrepreneurship-role') }}
							</h5>
						</div>
						<div class="large-3 mobile-12 columns">
							<p class="text-sm gray-base-text hide-for-mobile-only">Ultima actividad</p>
							<% if (typeof ultimo_ingreso_emprendedor_ago != 'undefined' && ultimo_ingreso_emprendedor) { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text"><%- ultimo_ingreso_emprendedor_ago  %></small></h4>
							<% } else { %>
								<h4 class="text-md gray-base-text"><small class="text-sm tiny-text gray-light-text">No hay actividad registrada</small></h4>
							<% } %>
						</div>
					<% } %>
					<div class="large-1 mobile-12 columns">
							<% if(emprendedor) { %>
							<span  data-tooltip aria-haspopup="true"  title="Sesión aceptada">
							<i class="mdi mdi-18px mdi-check gray-base-text"></i>
						</span>
							<% } else { %>
							<span  data-tooltip aria-haspopup="true"  title="Sesión aceptada">
							<i class="mdi mdi-18px mdi-check gray-base-text"></i>
						</span>
							<% } %>
					</div>

				</div>
			<% } %>
			</td>
		</tr>
	</script>

	{{-- item Mentoring Session --}}
	<script type="text/template" id="mentoring-session-tpl">

		<div id="container-mentoring-session" class="container-mentoring-session">
			<a href="javascript:history.back()" title="Regresar" class="right button small white-skyblue btn-shadow btn-lowerc radius"><i class="mdi mdi-arrow-left icon-btn"></i>Regresar</a>

			<div class="top-mentoring-session">

				<div class="container-users-session">
					<div class="row">
						<div class="tablet-8 tablet-centered columns">

							<div class="row valign-middle">
								<div class="mobile-5 columns">
									<ul class="inline-list-grid card-user-evaluated">
										<li class="text-right">
											<span class="bold-text text-md dark-text"><%- nombre_usuario_mentor %></span>
											<% if(emprendedor && evaluacion) { %>
												<% if(_.isUndefined(codigo_evaluacion_mentoria) || _.isNull(codigo_evaluacion_mentoria)) { %>
													<a href="<%= Route.route( 'mentoria.{rol?}.sesiones.evaluacion.create', {'rol' : 'emprendedor', m: url_mentoria}) %>" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Evaluar emprendedor">Evaluar Mentor</a>
												<% }else{ %>
													<span class="button xtiny white disabled btn-shadow btn-lowerc radius disabled">Ya has evaluado a este mentor</span>
												<% } %>
											<% } %>
										</li>
										<li class="has-image">
											<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_mentor }) ) %>" title="<%= window.Misc.strToNickname(nickname_usuario_mentor) %>" class="wrap-avatar-circle-mentoring">
												<img src="<%= imagen_usuario_mentor %>" alt="<%= nombre_usuario_mentor %>" class="rounded-img size50" />
												<span class="circle-entrepreneurship mentor xsmall">
													<i class="mdi mdi-tie"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>
								<div class="mobile-2 columns text-center">
									<span class="icon-circle large sky-blue circle-shadow">
										<i class="mdi mdi-presentation mdi-42"></i>
									</span>
								</div>
								<div class="mobile-5 columns">
									<ul class="inline-list-grid card-user-evaluated">
										<li class="has-image">
											<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_emprendedor }) ) %>" title="<%= window.Misc.strToNickname(nickname_usuario_emprendedor) %>" class="wrap-avatar-circle-mentoring">
												<img src="<%= imagen_usuario_emprendedor %>" alt="<%= nombre_usuario_emprendedor %>" class="rounded-img size50" />
												<span class="circle-entrepreneurship entrepreneur xsmall">
													<i class="mdi mdi-lightbulb"></i>
												</span>
											</a>
										</li>
										<li class="text-left">
											<span class="bold-text text-md dark-text"><%- nombre_usuario_emprendedor %></span>
											<% if(mentor && evaluacion) { %>
												<% if(_.isUndefined(codigo_evaluacion_tarea) || _.isNull(codigo_evaluacion_tarea)) { %>
													<a href="<%= Route.route( 'mentoria.{rol?}.sesiones.calificacion.create',{'rol' : 'mentor', m: url_mentoria}) %>" class="button xtiny sky-blue btn-shadow btn-lowerc radius" title="Evaluar emprendedor">Evaluar Emprendedor</a>
												<% }else{ %>
													<span class="button xtiny white disabled btn-shadow btn-lowerc radius disabled">Ya has evaluado a este emprendedor</span>
												<% } %>
											<% } %>
										</li>
									</ul>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="tablet-7 tablet-centered columns">
						<p class="light-text text-sm clean-bottom text-center">
							<em>Sesión de mentoría con</em>
							<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': mentor ? nickname_usuario_emprendedor : nickname_usuario_mentor }) ) %>" title="<%- mentor ? nombre_usuario_emprendedor : nombre_usuario_mentor %>" class="bold-text"><%- mentor ? nombre_usuario_emprendedor : nombre_usuario_mentor %></a> <em>Iniciada el
							<span class="dark-text"><%- window.moment([fecha_evento, hora_inicio_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("LLLL") %></span> finaliza el
							<span class="dark-text"><%- window.moment([fecha_fin_evento, hora_fin_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("LLLL") %></span></em>
						</p>
					</div>
				</div>
			</div>

			<hr>

			<div class="row">
				<div class="small-12 columns">
					<h5 class="bold-header dark-text">Descripción de sesión</h5>
					<p><%- descripcion_mentoria %></p>

					<div class="clearfix">
						<h5 class="bold-header dark-text">Objetivos</h5>
						<ol class="list-separator list-ordering light-text">
							<% _.each(objetivos, function (target) { %>
								<li><span class="dark-text bold-text text-md"><%- target.descripcion_objetivo_mentoria %></span></li>
							<% }); %>
						</ol>
					</div>

					<div class="clearfix">
						<h5 class="bold-header dark-text">Acuerdos</h5>

						<% if(mentor){ %>
							<div id="task-mentoring-form">
								{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-task-mentoring') ) !!}
									<div class="row">
										<div class="small-11 columns">
											<input type="text" name="descripcion_tarea_mentoria" value="" placeholder="Ingresa un acuerdo aquí" required="required">
											<small class="error">El campo esta vació o tiene muy pocos caracteres</small>
										</div>
										<div class="small-1 columns">
											<button class="left md-circle inst-bgcolor xsmall" type="submit">
												<i class="mdi mdi-plus mdi-24"></i>
											</button>
										</div>
									</div>
									<input type="hidden" name="codigo_mentoria" value="<%= codigo_mentoria %>" />
								{!! Form::close() !!}
							</div>
						<% } %>

						<ol id="container-task-detail" class="list-separator list-ordering light-text">
							{{-- Render Tasks template --}}
						</ol>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section Tasks Mentoring --}}
	<script type="text/template" id="mentoring-task-tpl">
		<span class="dark-text bold-text text-md"><%- descripcion_tarea_mentoria %></span>
		<% if(mentor){ %>
			<a href="#" title="Eliminar Tarea" class="right close content-close remove-task-mentoring" >&#215;</a>
		<% } %>
	</script>
	{{-- section Confirm Remove Task --}}
	<script type="text/template" id="task-mentoring-confirm-remove-tpl">
		<p>{{ Lang::get('mentoring.task.remove.confirm') }}</p>
	</script>

	{{-- section Eval Session Mentoring --}}
	<script type="text/template" id="mentoring-eval-session-tpl">
		<div id="container-mentoring-eval-session">
			<div class="row">
				<div class="mobile-7 columns">
					<ul class="inline-list-grid align-top card-user-session">
						<li class="has-image">
							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_mentor }) ) %>" title="<%= window.Misc.strToNickname(nickname_usuario_mentor) %>">
								<img src="<%= imagen_usuario_mentor %>" alt="<%= nombre_usuario_mentor %>" class="size60" />
							</a>
						</li>
						<li>
							<h6 class="clean-header bold-header"><a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_mentor }) ) %>"><%- nombre_usuario_mentor %></a></h6>
							<span class="thin-text dark-text text-md"><%- window.Misc.strToNickname(nickname_usuario_mentor) %></span>
							<br>
							<span class="bold-text text-sm"><i class="mdi mdi-tie mdi-18 vbottom"></i>Mentor</span>
						</li>
					</ul>
				</div>
				<div class="mobile-5 columns">
					<a href="javascript:history.back()" title="Regresar" class="right button small white-skyblue btn-shadow btn-lowerc radius"><i class="mdi mdi-arrow-left icon-btn"></i>Regresar</a>
				</div>
			</div>

			<hr>

			<div class="row">

				<div class="small-12 columns">
					<h5 class="bold-header dark-text">Descripción</h5>
					<em class="text-sm">
						<%- window.moment([fecha_evento, hora_inicio_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("dddd, MMMM Do YYYY, h:mm:ss a") %> &#8260;
						<%- window.moment([fecha_fin_evento, hora_fin_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("dddd, MMMM Do YYYY, h:mm:ss a") %>
					</em>
					<p><%- descripcion_mentoria %></p>
					<div class="clearfix">
						<h5 class="bold-header dark-text">Objetivos</h5>
						<ol class="list-separator list-ordering light-text">
							<% _.each(objetivos, function (target) { %>
								<li><span class="dark-text bold-text text-md"><%- target.descripcion_objetivo_mentoria %></span></li>
							<% }); %>
						</ol>
					</div>

					<div class="clearfix">
						<h5 class="bold-header dark-text">Evaluación</h5>

						{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-eval') ) !!}
							<div class="row">
								<div class="small-12 columns">
									<label class="label-terms">Comentario</label>
									<textarea placeholder="Comentario Mentoria" required="required" name="comentario__evaluacion_mentoria" cols="50" rows="4" pattern="max_char_textarea"></textarea>
									<small class="error">El campo esta vació o tiene muy pocos caracteres</small>
									<input type="hidden" name="codigo_mentoria" value="<%= codigo_mentoria %>" />
								</div>
							</div>

							<div class="row">
								<div class="small-12 columns">
									<label class="label-terms">Items Mentoria</label>
									<ul id="container-session-items-mentoring" class="list-separator list-ordering light-text no-bullet">
										{{-- Render Tasks template --}}
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="small-2 small-centered columns">
									<button class="button expand medium radius sky-blue btn-shadow" type="submit">Evaluar</button>
								</div>
							</div>
						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Item Eval Session Mentoring --}}
	<script type="text/template" id="mentoring-session-item-detail-tpl">
		<div class="clearfix">
			<a data-dropdown="drop-evaluation-<%- codigo_item_general_mentoria %>" data-options="align:top;is_hover:true;" aria-expanded="false" class="dark-text bold-text text-md"><%- nombre_item_general_mentoria %>
			</a>
			<ul id="drop-evaluation-<%- codigo_item_general_mentoria %>" class="md-dropdown" data-dropdown-content aria-hidden="true" >
				<%= descripcion_item_general_mentoria %>
			</ul>
			<div class="right stars-rating">
				<input type="radio" name="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>" id="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_5" value="5" required="required" class="check-star">
				<label for="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_5" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>" id="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_4" value="4" required="required" class="check-star">
				<label for="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_4" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>" id="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_3" value="3" required="required" class="check-star">
				<label for="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_3" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>" id="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_2" value="2" required="required" class="check-star">
				<label for="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_2" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>" id="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_1" value="1" required="required" class="check-star">
				<label for="evaluacion_item_mentoria_<%- codigo_item_general_mentoria %>_1" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>
			</div>
		</div>
	</script>

	{{-- section Calification Task Mentoring --}}
	<script type="text/template" id="mentoring-calification-task-tpl">
		<div id="">

			<div class="row">
				<div class="mobile-7 columns">
					<ul class="inline-list-grid align-top card-user-session">
						<li class="has-image">
							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_emprendedor }) ) %>" title="<%= window.Misc.strToNickname(nickname_usuario_emprendedor) %>">
								<img src="<%= imagen_usuario_emprendedor %>" alt="<%= nombre_usuario_emprendedor %>" class="size60" />
							</a>
						</li>
						<li>
							<h6 class="clean-header bold-header"><a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario_emprendedor }) ) %>"><%- nombre_usuario_emprendedor %></a></h6>
							<span class="thin-text dark-text text-md"><%- window.Misc.strToNickname(nickname_usuario_emprendedor) %></span>
							<br>
							<span class="bold-text text-sm"><i class="mdi mdi-lightbulb mdi-18 vbottom"></i>Emprendedor</span>
						</li>
					</ul>
				</div>
				<div class="mobile-5 columns">
					<a href="javascript:history.back()" title="Regresar" class="right button small white-skyblue btn-shadow btn-lowerc radius"><i class="mdi mdi-arrow-left icon-btn"></i>Regresar</a>
				</div>
			</div>

			<hr>

			<div class="row">

				<div class="small-12 columns">
					<h5 class="bold-header dark-text">Descripción</h5>
					<em class="text-sm">
						<%- window.moment([fecha_evento, hora_inicio_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("dddd, MMMM Do YYYY, h:mm:ss a") %> &#8260;
						<%- window.moment([fecha_fin_evento, hora_fin_evento].join(' '), "YYYY-MM-DD HH:mm:ss").format("dddd, MMMM Do YYYY, h:mm:ss a") %>
					</em>
					<p><%- descripcion_mentoria %></p>

					<div class="clearfix">
						<h5 class="bold-header dark-text">Objetivos</h5>
						<ol class="list-separator list-ordering light-text">
							<% _.each(objetivos, function (target) { %>
								<li><span class="dark-text bold-text text-md"><%- target.descripcion_objetivo_mentoria %></span></li>
							<% }); %>
						</ol>
					</div>

					<div class="clearfix">
						{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-calification-task-mentoring') ) !!}
							<div class="row">
								<div class="small-12 columns">
									<h5 class="bold-header dark-text">Tareas Mentoria</h5>
									<ul id="container-calification-task-detail" class="list-separator list-ordering no-bullet">
										{{-- Render Tasks template --}}
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="small-12 columns">
									<label class="label-terms">Comentario</label>
									<textarea placeholder="Comentario Tarea" required="required" name="comentario_evaluacion_tarea" cols="50" rows="4" pattern="max_char_textarea"></textarea>
									<small class="error">El campo esta vació o tiene muy pocos caracteres</small>
									<input type="hidden" name="codigo_mentoria" value="<%= codigo_mentoria %>" />
								</div>
							</div>
							<div class="row">
								<div class="small-2 small-centered columns">
									<button class="button expand medium radius sky-blue btn-shadow" type="submit">Evaluar</button>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Item Calification Tasks Mentoring --}}
	<script type="text/template" id="mentoring-calification-task-detail-tpl">

		<div class="clearfix">
			<span class="dark-text bold-text text-md"><%- descripcion_tarea_mentoria %></span>
			<div class="right stars-rating">
				<input type="radio" name="evaluacion_tarea_<%-item %>" id="evaluacion_tarea_<%-item %>_5" value="5" required="required">
				<label for="evaluacion_tarea_<%-item %>_5" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_tarea_<%-item %>" id="evaluacion_tarea_<%-item %>_4" value="4" required="required">
				<label for="evaluacion_tarea_<%-item %>_4" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_tarea_<%-item %>" id="evaluacion_tarea_<%-item %>_3" value="3" required="required">
				<label for="evaluacion_tarea_<%-item %>_3" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_tarea_<%-item %>" id="evaluacion_tarea_<%-item %>_2" value="2" required="required">
				<label for="evaluacion_tarea_<%-item %>_2" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

				<input type="radio" name="evaluacion_tarea_<%-item %>" id="evaluacion_tarea_<%-item %>_1" value="1" required="required" >
				<label for="evaluacion_tarea_<%-item %>_1" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>
			</div>


		</div>
	</script>


	<script type="text/template" id="form-session-development">
		@switch(App\RegistroSesion::getInstitutionSlug())
			@case('rutan')
				@include('layout.templateinstitution.formsessiondevelopment.rutan')
				@break
			@default
				@include('layout.templateinstitution.formsessiondevelopment.general')
		@endswitch
	</script>


	<script type="text/template" id="mentoring-task-session-item-tpl">
		<li>
			<div class="center-block">
				<small class="gray-dark-text text-md"> <%- descripcion_tarea_mentoria %></small>
				<% if(!finished && estado != window._tp.getState['closed']) { %>
					<a href=""><i class="mdi mdi-close right remove-mentoring-task-session" data-id="<%- typeof item !== 'undefined' && item ? item : 0 %>"></i></a>
				<% } %>
				<hr class="gray-dark">
			</div>

		</li>
	</script>

	<script type="text/template" id="mentoring-tags-session-item-tpl">
		<li>
			<div class="center-block">
				<small class="gray-dark-text text-md"> <b> <%- nombre_tag_sesion_mentoria %>: </b> <%- valor_tag_sesion_mentoria %> </small>
				<% if(!finished && estado != window._tp.getState['closed']) { %>
					<a href=""><i class="mdi mdi-close right remove-mentoring-tags-session" data-id="<%- typeof item !== 'undefined' && item ? item : 0 %>"></i></a>
				<% } %>
				<hr class="gray-dark">
			</div>
		</li>
	</script>

	<script type="text/template" id="mentoring-confirm-close-tpl">
		<p>{{ Lang::get('mentoring.close.confirm') }}</p>
	</script>

	{{-- Section Create Mentor --}}
	<script type="text/template" id="mentoring-confirm-remove-tpl">
		<p>{{ Lang::get('mentoring.remove.mentoring.confirm') }}</p>
	</script>

	<script type="text/template" id="schedule-adviser-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-schedule-adviser') ) !!}
			<div class="row">
				<div class="small-12 columns">
					<ul class="no-bullet">
						<li><%- start +' hasta '+ end %></li>
						<li><h6 class="inst-color-invert"><%- typeof title !== 'undefined' ? title : '' %></h6></li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns">
					<% if(stateEvent == 'available') { %>
						<textarea name="descripcion_mentoria" required placeholder="Descripción" row="2" data-abide-validator="maxWords" data-maxlen="200"></textarea>
					<% }else {%>
						<p><%- descripcion_mentoria %></p>
					<% } %>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns">
					<small><b>Emprendimiento: </b><%- nombre_emprendimiento %></small></br>
					<small><b>Emprendedor: </b><%- nombre_usuario_emprendimiento %> <%- apellido_usuario_emprendimiento %></small>
				</div>
			</div>

			<% if(typeof(nombre_tema_principal_evento) !== 'undefined' && !_.isEmpty(nombre_tema_principal_evento)){ %>
				<div class="row">
					<div class="small-12 columns">
						<label>Tema Principal: <%- typeof( nombre_tema_principal_evento) !== 'undefined' ? nombre_tema_principal_evento : '' %></label>
					</div>
				</div>
			<% } %>
			<div class="row">
				<div class="small-12 columns">
					<label for="">Objetivos:</label>
					<% if(stateEvent == 'available') { %>
						<div class="row collapse">
							<div class="small-10 columns">
								<input type="text" id="target_mentoring" value="" placeholder="Agregue un objetivo">
							</div>
							<div class="small-2 columns">
								<a href="#" class="button secondary postfix add-target-schedule">+</a>
							</div>
						</div>
					<% } %>
					<ul class="targets-schedule-mentoring list-data-aside">
						<% _.each(objetivos_mentoria, function (target) { %>
						<li>  <%- typeof target.texto_tag !==  'undefined' ? target.texto_tag : target %></li>
						<% }); %>
					</ul>
				</div>
			</div>
			<div class="row">
				<% if(stateEvent == 'confirm'){ %>
					<% if(owner){ %>
						<div class="small-12 medium-3 medium-offset-9 columns">
							{!! Form::submit('Confirma', array('class' => 'button small sky-blue btn-bold radius btn-clean-margin expand')) !!}
						</div>
					<% } else { %>
						<div class="small-12 columns">
							<div data-alert class="notice-box-tp text-center warning">
								<span>
									!Pendiente para confirmar mentoría!
								</span>
								<i class="icon-alert"></i>
							</div>
						</div>
					<% } %>
				<% }else if(stateEvent== 'available'){ %>
					<div class="small-12 medium-3 medium-offset-9 columns">
						{!! Form::submit('Solicitar', array('class' => 'button small sky-blue btn-bold radius btn-clean-margin expand')) !!}
					</div>
				<% }else if(stateEvent == 'confirmed'){ %>
					<div class="small-12 columns">
						<div data-alert class="notice-box-tp text-center success">
							<span>
								!La mentoría ya fue confirmada!
							</span>
							<i class="icon-alert"></i>
						</div>
					</div>
				<% } %>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- Section Create Mentor --}}
	<script type="text/template" id="profile-mentor-tpl">
		@include('core.mentoring.form.creatementor')
	</script>

	{{-- Image Profile template --}}
	<script type="text/template" id="main-image-profile-mentor-tpl">
		<img src="<%- imagen_usuario %>" alt="<%- nickname_usuario %>" title="<%- nickname_usuario %>" class="image-user-profile rounded-img" onerror="if (this.src != '{{ config('tuproyecto.avatar_image') }}') this.src = '{{ config('tuproyecto.avatar_image') }}';">
		<span class="circle-entrepreneurship mentor invert xsmall icon-24 circle-shadow">
			<i class="mdi mdi-tie"></i>
		</span>
		<% if(owner){ %>
			<button id="change-image-mentor-profile" class="edit-photo change-photo icon-circle white xsmall icon-21 circle-shadow">
				<div class="edit-photo-content">
					<i class="mdi mdi-pencil gray-light"></i>
				</div>
			</button>
		<% } %>
		<input type="hidden" id="imagen_usuario" name="imagen_usuario" value="<%- imagen_usuario %>">
	</script>

	<script type="text/template" id="economic-sector-item-tpl">
		<small class="gray-dark-text text-md"><%- nombre_sector_economico %></small>
		<% if(owner){ %>
			<a href="#" title="Borrar" class="close remove-economic-sector"><i class="mdi mdi-close right"></i></a>
		<% } %>
	</script>

	<script type="text/template" id="specialities-item-mentor-tpl">
		<small class="gray-dark-text text-md"><%- nombre_especialidad %></small>
		<% if(owner){ %>
			<a href="#" title="Borrar" class="close remove-specialities"><i class="mdi mdi-close right"></i></a>
		<% } %>
	</script>

	<script type="text/template" id="other-specialty-tpl">
		<h5 class="thin-header sky-blue-text">¿Cuál?</h5>
		<em><%- descripcion_especialidad %></em>
	</script>

	<script type="text/template" id="evaluation-mentor-tpl">

		@switch(App\RegistroSesion::getInstitutionSlug())
			@case('rutan')
				@include('core.mentoring.evaluation.mentoringformrutan')
			@break
			@default
				@include('core.mentoring.evaluation.mentoringformdefault')
		@endswitch

	</script>
@stop
