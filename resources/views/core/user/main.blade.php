@extends('core.user.user')

@section('user.content')

<script type="text/template" id="user-profile-tpl">
	{{-- header profile --}}
	<div id="profile-header-content" class="<%- owner ? 'editable' : '' %>">
		<div id="profile-header-background" class="profile-header-image-background"></div>
		<div class="row">
			<div class="small-12 columns">
				<div class="profile-basic-info">
					<div class="row">
						<div class="tablet-12 medium-2 columns">
							<div id="profile-picture-avatar" class="wrapper-image-edit image-area-drop mobile-only-text-center small-only-text-center tablet-only-text-center">

								<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" title="<%- nombre_usuario %>" class="image-user-profile" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
								<% if(owner){ %>
									<button id="change-photo-user" class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
								<% } %>

							</div>
						</div>

						<div class="tablet-12 medium-10 columns">
							<div class="profile-info-detail">
								<div class="row col-equal-height">
									<div class="mobile-12 columns">
										<div class="profile-info-container mobile-only-text-center small-only-text-center tablet-only-text-center">
											<div id="user-name-container" class="editable-item">
												@if (App\Institucion::find(App\RegistroSesion::getInstitution())->edicion_nombres)
													<h4 class="name-user-profile black-text edit-field bold-text" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="name">
														<span class="field-text"><%- [nombre_usuario, primer_apellido_persona, segundo_apellido_persona].join(' ') %></span>
														<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
													</h4>
												@else
													<h4 class="black-text bold-text">
														<span class="field-text"><%- [nombre_usuario, primer_apellido_persona, segundo_apellido_persona].join(' ') %></span>
													</h4>
												@endif
											</div>

											<div id="user-location-container" class="editable-item clearfix">
												<span class="location-user-profile edit-field " data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="location">
													<a href="#" class="nickname-user-profile"><%- window.Misc.strToNickname(nickname_usuario) %></a>

													<span class="user-location-middot">&bull;</span>

													<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
													<i class="mdi mdi-map-marker mdi-16 vcenter gray-light-text"></i>
														<span class="text-location field-text"><%- nombre_ciudad %>, <%- nombre_pais %></span>
													<% } %>
													<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
												</span>
											</div>

											<% if( (!_.isUndefined(profesion_usuario) && !_.isNull(profesion_usuario) ) || owner) { %>
												<div id="user-sector-container" class="editable-item">
													<span class="sector-user-profile edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="location">
														<span class="field-text inst-color-secondary"><%- profesion_usuario %></span>
														<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
													</span>
												</div>
											<% } %>

											<div id="user-biography-container" class="editable-item">
												<div class="field-for-edit edit-field clearfix" data-edit-template="biography">
													<ul class="inline-list-grid align-top">
														<% if(biografia_usuario) { %>
															<li>
																<p class="user-bio-text"><%- window.Misc.maxLen(biografia_usuario, 235) %></p>
															</li>
														<% } %>
														<li class="has-image">
															<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
														</li>
													</ul>
												</div>
												<div class="field-editing">
													{{-- Render template edit form--}}
												</div>
											</div>

											@if(Auth::check())
												<% if(!owner) { %>
													<div class="user-buttons-contact-mentoring clearfix">
														<ul id="buttons-connect-user" class="no-bullet">
															{{-- Render buttons follows --}}
														</ul>
														@if(App\Institucion::getMentoringDirectRequest(App\RegistroSesion::getInstitution()))
															<% if(mentor){ %>
																<a href="<%- window.Misc.urlFull( Route.route('mentoria.preguntas.create', {'nickname': nickname_usuario}) ) %>" id="request-mentoring" class="button inst-secondary-outline xtiny radius btn-lowerc" area-title="¡Solicitar Mentoría!">
																	<i class="mdi mdi-presentation mdi-16 vcenter"></i>
																	Solicitar mentoría
																</a>
															<% } %>
														@endif
													</div>
												<% } %>
											@endif

											<div id="user-socials-container">
												<ul class="socials-user-profile">
													<li>
														<a href="<%- twitter_usuario %>" title="X" class="<%- twitter_usuario ? 'active' : 'disabled' %>" target="_blank">
															<i class="mdi mdi-close-outline mdi-16 icon-circle circle-outline tiny <%- twitter_usuario ? 'icon-active' : '' %>"></i>
														</a>
													</li>
													<li>
														<a href="<%- facebook_usuario %>" title="Facebook" class="<%- facebook_usuario ? 'active' : 'disabled' %>" target="_blank">
															<i class="mdi mdi-facebook mdi-16 icon-circle circle-outline tiny <%- facebook_usuario ? 'icon-active' : '' %>"></i>
														</a>
													</li>
													<li>
														<a href="<%- linkedin_usuario %>" title="Linkedin" class="<%- linkedin_usuario ? 'active' : 'disabled' %>" target="_blank">
															<i class="mdi mdi-linkedin mdi-16 icon-circle circle-outline tiny <%- linkedin_usuario ? 'icon-active' : '' %>" ></i>
														</a>
													</li>
													<li>
														<a href="<%- tiktok_usuario %>" title="TikTok" class="<%- tiktok_usuario ? 'active' : 'disabled' %>" target="_blank" style="
															border: 1px solid;
															border-radius: 20px;
															min-width: 1em;
															min-height: 1em;
															width: auto;
															height: auto;
															display: inline-block;
															line-height: 1 !important;
															color: #2A3670;
															background-color: transparent;
															text-align: center;
															-moz-border-radius: 50%;
															-webkit-border-radius: 50%;
															border-radius: 50%;
															-moz-box-sizing: content-box;
															-webkit-box-sizing: content-box;
															box-sizing: content-box;
															color: #ddd;
															border-color: #ddd;
														">
															<svg xmlns="http://www.w3.org/2000/svg" width="15px" height="15px" viewBox="0 0 24 24"><path fill="<%- tiktok_usuario ? '#f60' : '#ccc' %>" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07"/></svg>

														</a>
													</li>
													<li>
														<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="socials"><i class="mdi mdi-pencil"></i></button>
													</li>
													@if (Auth::check())
														<% if(owner) { %>
															<li>
																<a href="#user-preferences" class="light-text text-xmd get-preferences-user" aria-controls="user-preferences">
																	<i class="mdi mdi-settings mdi-16 icon-circle vcenter"></i>
																	Ajustes
																</a>
															</li>
														<% } %>
													@endif
												</ul>
											</div>
											@if (Auth::check())
												<% if(owner && !_.isEmpty(last_income)) { %>
													<div class="user-last-login">
														<span>Último ingreso: <b class="inst-color-secondary"><%- window.moment(last_income).format("dddd D [de] MMMM, YYYY [a las] LT a") %></b></span>
													</div>
												<% } %>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- submenu tabs profile--}}
	<div id="profile-submenu-nav">
		<div class="row">
			<div class="small-10 small-offset-2 columns">
				<div id="user-submenu-filter">
					<ul id="user-tabs-filter" class="tabs-sub-nav tabs tabs-route" data-tab>
						@if (Auth::check())
							{{--
							<li class="tab-title <%- tab=='comunidad' ? 'active' : '' %>">
								<a href="#user-wall" title="Comunidad" class="get-wall-user" aria-controls="user-wall">Comunidad</a>
							</li>
							--}}
						@endif
						<li class="tab-title <%- tab=='basico' ? 'active' : '' %>">
							<a href="#user-data" title="Datos personales" class="get-databasic-user" aria-controls="user-data">Datos personales</a>
						</li>
						@if (Auth::check())
							<li class="tab-title <%- tab=='proyectos' ? 'active' : '' %>">
								<a href="#user-projects" title="Emprendimientos" class="get-projects-user" aria-controls="user-projects">{{ transtp('users.entrepreneurship') }}</a>
							</li>
							<li class="tab-title <%- tab=='convocatorias' ? 'active' : '' %>">
								<a href="#user-program" title="Convocatorias" class="get-program-user" aria-controls="user-program">{{ transtp('users.program') }}</a>
							</li>
							@if( Auth::user()->ability('super-admin', 'view', ['module'  => '/marketplace']) )
								<li class="tab-title <%- tab=='productos' ? 'active' : '' %>">
									<a href="#user-product" title="Productos" class="get-product-user" aria-controls="user-product">Productos</a>
								</li>
							@endif
							<li class="tab-title  <%- tab=='contactos' ? 'active' : '' %>">
								<a href="#user-contacts" title="Contactos" class="get-contacts-user" aria-controls="user-contacts">Contactos</a>
							</li>
						@endif
						<% if(owner){ %>
							<!-- <li class="tab-title  <%- tab=='mensajes' ? 'active' : '' %>">
								<a href="#user-messages" title="Mensajes" class="get-messages-user" aria-controls="user-messages">Mensajes</a>
							</li>-->
							<!-- <li class="tab-title <%- tab=='grupos' ? 'active' : '' %>">
								<a href="#user-teams" title="Grupos" class="get-teams-user" aria-controls="user-teams">Grupos</a>
							</li> -->
							<!--<li class="tab-title <%- tab=='encuestas' ? 'active' : '' %>">
								<a href="#user-surveys" title="Encuestas" class="get-surveys-user" aria-controls="user-surveys">Encuestas</a>
							</li>-->
							<li class="tab-title <%- tab=='calendario' ? 'active' : '' %>">
								<a href="#user-calendar" title="Calendario" class="get-calendar-user" aria-controls="user-calendar">Calendario</a>
							</li>
						<% } %>
						<!-- <li class="tab-title  <%- tab=='mentor' ? 'active' : '' %>">
							<a href="#user-mentor" title="Mentor" class="profile-user-mentor mdi mdi-teach mdi-16 white-text vcenter tab-icon-left" aria-controls="user-mentor">Mentor</a>
						</li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>

	{{-- content profile --}}
	<div id="user-profile-content">
		<div class="row">
			<div class="small-12 columns">
				<div class="tabs-content">
					{{-- content data basic profile--}}
					<div class="content <%- tab=='basico' ? 'active' : '' %>" id="user-data">
						<div class="row">
							<div class="small-12 columns">
								<div class="row">
									<div class="small-12 columns">
										<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">

											<div id="" class="editable-item clearfix">
												<h4 class="title-panel text-left">
													<ul class="inline-list-grid align-top no-bullet">
														<li class="field-text">Datos</li>
														<li class="has-image">
															<button class="edit-field-button edit-field right" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" aria-expanded="false" data-options="align:left;" data-edit-template="basic">
																<i class="mdi mdi-pencil"></i>
															</button>
														</li>
													</ul>
												</h4>
											</div>
											<ul class="data-basic-profile mobile-block-grid-1 small-block-grid-1 tablet-block-grid-2">
												<li>
													<div class="item-basic-profile">
														<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-web"></i></span>
														<em>
															<% if (!_.isUndefined(pagina_web_usuario) && !_.isNull(pagina_web_usuario) && window.Misc.isUrl(pagina_web_usuario)) { %>
																<a href="<%- pagina_web_usuario %>" target="_blank"><%- pagina_web_usuario %></a>
															<% } %>
														</em>
													</div>
												</li>
												<li>
													<div class="item-basic-profile">
														<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-cake"></i></span>
														<em><%- window.moment(fecha_nacimiento_usuario, "YYYY MM DD").format("Do MMMM") %></em>
													</div>
												</li>

												</li>
												<% if(owner) { %>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-email"></i></span>
															<em><%- correo_electronico %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-home"></i></span>
															<em><%- direccion_usuario %> <%- barrio_usuario %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-cellphone-android"></i></span>
															<em><%- movil_usuario %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-phone"></i></span>
															<em><%- telefono_usuario %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-gender-male-female"></i></span>
															<em><%- nombre_genero %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-human-male-female"></i></span>
															<em><%- nombre_estado_civil %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
													<li>
														<div class="item-basic-profile">
															<span class="icon-data-basic"><i class="mdi inst-color-secondary mdi-account-key"></i></span>
															<em><%- identificacion_usuario %></em>
															<span class="icon-data-lock"><i class="mdi mdi-12 mdi-lock"></i></span>
														</div>
													</li>
												<% } %>
											</ul>
											<% if(owner) { %>
												<br>
												<em class="text-sm light-text">Los campos marcados con el candado (<i class="mdi mdi-lock"></i>) no son visibles al público y son de uso exclusivo para programas y convocatorias.</em>
											<% } %>
										</div>
									</div>
								</div>

								<% if ( (!_.isUndefined(experiencia_usuario) && !_.isNull(experiencia_usuario) && experiencia_usuario.length) || owner ) { %>
									<div class="row">
										<div class="small-12 columns">
											<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">
												<div id="user-experience-container" class="editable-item clearfix">

													<h4 class="title-panel text-left">
														<ul class="inline-list-grid align-top no-bullet">
															<li class="field-text">Experiencia</li>
															<li class="has-image">
																<button class="edit-field-button edit-field right" data-edit-template="experience">
																	<i class="mdi mdi-pencil"></i>
																</button>
															</li>
														</ul>
													</h4>

													{{-- <h4 class="title-panel text-left">
														<span class="field-text">Experiencia</span>
														<button class="edit-field-button right edit-field" data-edit-template="experience">
														<i class="mdi mdi-pencil"></i>
														</button>
													</h4> --}}
													<div class="content-experience-profile field-for-edit edit-field clearfix wrap-text" data-edit-template="experience">
														<div class="text-md"><%= experiencia_usuario %></div>
													</div>
													<div class="field-editing">
														{{-- Render template edit form--}}
													</div>
												</div>
											</div>
										</div>
									</div>
								<% } %>

								@if (Auth::check())
									<div class="row">
										<div class="small-12 columns">
											<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">
												<div id="user-education-container" class="editable-item clearfix">
													<h4 class="title-panel text-left">
														<ul class="inline-list-grid align-top no-bullet">
															<li class="field-text">Educación</li>
															<li class="has-image">
																<button class="edit-field-button edit-field right" data-edit-template="education">
																	<i class="mdi mdi-pencil"></i>
																</button>
															</li>
														</ul>
													</h4>
													{{-- <h4 class="title-panel text-left">
														<span class="field-text">Educación</span>
														<button class="edit-field-button right edit-field" data-edit-template="education"><i class="mdi mdi-pencil"></i></button>
													</h4> --}}
													<div class="field-editing content-form-editing">
														{{-- Render template edit form--}}
													</div>
													<ul class="list-info-profile list-education-profile disc text-md">
														{{-- Render views item of reason --}}
													</ul>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="small-12 columns">
											<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">
												<div id="user-reasons-container" class="editable-item clearfix">
													<h4 class="title-panel text-left">
														<ul class="inline-list-grid align-top no-bullet">
															<li class="field-text">Razones</li>
															<li class="has-image">
																<button class="edit-field-button edit-field right" data-edit-template="reasons">
																	<i class="mdi mdi-pencil"></i>
																</button>
															</li>
														</ul>
													</h4>
													{{-- <h4 class="title-panel text-left">
														<span class="field-text">Razones</span>
														<button class="edit-field-button right edit-field" data-edit-template="reasons"><i class="mdi mdi-pencil"></i></button>
													</h4> --}}
													<div class="field-editing content-form-editing">
														{{-- Render template edit form--}}
													</div>
													<ul class="list-info-profile list-reasons-profile disc text-md">
														{{-- Render views item of reason --}}
													</ul>
												</div>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="small-12 columns">
											<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">
												<div id="user-specialities-container" class="editable-item clearfix">
													<h4 class="title-panel text-left">
														<ul class="inline-list-grid align-top no-bullet">
															<li class="field-text">Especialidades</li>
															<li class="has-image">
																<button class="edit-field-button edit-field right" data-edit-template="specialities">
																	<i class="mdi mdi-pencil"></i>
																</button>
															</li>
														</ul>
													</h4>
													{{-- <h4 class="title-panel text-left">
														<span class="field-text">Especialidades</span>
														<button class="edit-field-button right edit-field" data-edit-template="specialities"><i class="mdi mdi-pencil"></i></button>
													</h4> --}}
													<div class="field-editing content-form-editing">
														{{-- Render template edit form--}}
													</div>
													<ul class="list-info-profile list-specialities-profile disc text-md">
														{{-- Render views item of reason --}}
													</ul>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="small-12 columns">
											<div class="panel-info radius-tablet-up with-title <%- owner ? 'editable' : '' %>">
												<div id="user-interests-container" class="editable-item clearfix">
													<h4 class="title-panel text-left">
														<ul class="inline-list-grid align-top no-bullet">
															<li class="field-text">Sectores económicos de interés</li>
															<li class="has-image">
																<button class="edit-field-button edit-field right" data-edit-template="interests">
																	<i class="mdi mdi-pencil"></i>
																</button>
															</li>
														</ul>
													</h4>
													{{-- <h4 class="title-panel text-left">
														<span class="field-text">Sectores económicos de interés</span>
														<button class="edit-field-button right edit-field" data-edit-template="interests"><i class="mdi mdi-pencil"></i></button>
													</h4> --}}
													<div class="field-editing content-form-editing">
														{{-- Render template edit form--}}
													</div>
													<ul class="list-info-profile list-interests-profile disc text-md">
														{{-- Render views item of reason --}}
													</ul>
												</div>
											</div>
										</div>
									</div>
								@endif
							</div>
						</div>
					</div>

					@if (Auth::check())
					{{-- Content user projects --}}
					<div class="content content-project-list <%- tab=='proyectos' ? 'active' : '' %> " id="user-projects">

						<div class="row mobile-collapse tablet-uncollapse">
							<div class="small-12 columns">
								<div id="content-projects-list" class="content-browse-projects content-data-list">			<% if(owner) { %>
										<a href="<%- window.Misc.urlFull(Route.route('proyecto.create')) %>" class="show-for-mobile-only user-project-create-new">
											<div class="panel-content">
												<ul class="inline-list-grid align-center">
													<li class="text-left">
														<span class="text-md">Crear nuevo emprendimiento</span>
													</li>
													<li class="text-right no-wrap short-col">
														<i class="mdi mdi-plus mdi-21 vcenter"></i>
													</li>
												</ul>
											</div>
										</a>
									<% } %>

									@include('public.noresults', ['message' => 'No hay emprendimientos', 'panel' => true, 'url' => route('proyecto.create') ])
									<ul id="browse-projects-list" class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 medium-block-grid-3 xxlarge-block-grid-4 browse-list-mask browse-list-projects responsive-browse">
										{{-- Render project list --}}
									</ul>
								</div>
							</div>
						</div>
					</div>

					{{-- Content user product --}}
					<div class="content <%- tab=='productos' ? 'active' : '' %> " id="user-product">
						<div class="row mobile-collapse tablet-uncollapse">
							<div class="small-12 columns">
								<div id="content-product-list" class="content-browse-list content-data-list">
									<% if(owner) { %>
										@if( Auth::user()->hasRole(['seller']) && Auth::user()->ability('super-admin', 'create', ['module'  => '/marketplace']) )
											<a href="<%- window.Misc.urlFull(Route.route('marketplace.create')) %>" class="show-for-mobile-only user-project-create-new">
												<div class="panel-content">
													<ul class="inline-list-grid align-center">
														<li class="text-left">
															<span class="text-md">Crear nuevo producto</span>
														</li>
														<li class="text-right no-wrap short-col">
															<i class="mdi mdi-plus mdi-21 vcenter"></i>
														</li>
													</ul>
												</div>
											</a>
										@endif
									<% } %>
									@include('public.noresults', ['message' => 'No hay productos', 'panel' => true])
									<ul id='user-product-list' class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 medium-block-grid-3 xxlarge-block-grid-4 browse-list-mask browse-list-products responsive-browse">
										<!-- Render products list -->
									</ul>
								</div>
							</div>
						</div>
					</div>

					{{-- Content user program --}}
					<div class="content <%- tab=='convocatorias' ? 'active' : '' %> " id="user-program">
						<div class="row">
							<div class="tablet-3 medium-2 columns">
								<ul id='user-program-list' class="section table-of-contents no-bullet vertical" data-tab>
									<!-- Render program list -->
								</ul>
							</div>
							<div class="tablet-9 medium-10 columns">
								<div class="tabs-content">
									@include('public.noresults', ['message' => 'No tiene convocatorias inscritas para este proyecto'])
									<div id="content-review-program-user" class="content active section scrollspy">
										{{-- Render review program --}}
									</div>
								</div>
							</div>
						</div>
					</div>

					{{-- Content user contacts --}}
					<div class="content <%- tab=='contactos' ? 'active' : '' %>" id="user-contacts">
						<div id="contacts-users-friendship">
							<div class="row">


								<div class="mobile-12 medium-4 medium-push-8 large-3 large-push-9 columns">
									<div id="pending-contacts-wrap">
										<div class="panel-info radius-tablet-up with-title content-requests-contacts">
											<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
												<span class="left">Solicitudes de contacto</span>
												<i class="mdi mdi-human-greeting mdi-18 gray-light vcenter"></i>
											</h6>

											<div id="pending-users-confirm">
												@include('public.noresults', ['message' => 'Aún no hay participantes en este evento'])
												<ul id="pending-friendship-wrap" class="no-bullet">
													{{-- Render contact list --}}
												</ul>
											</div>
										</div>
									</div>
								</div>


								<div class="mobile-12 medium-8 medium-pull-4 large-9 large-pull-3 xlarge-3 xlarge-pull-3 columns">
									<div class="panel-info radius-tablet-up with-title search-contacts-wrap">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Filtros</span>
											<i class="mdi mdi-tune mdi-18 gray-light vcenter"></i>
										</h6>
										<div class="section-events-filter">
											{!! Form::open(array('route' => null, 'id' => 'form-conctacts-filter')) !!}
												<div>
													<div class="input-field">
														{!! Form::text('username', null,
															array(
																'id' => 'username',
																'pattern' => '^(.){2,}[^\s]*',
																'class' => 'validate',
																'placeholder' => 'Busca un contacto'
															))
														!!}
														<i class="right mdi mdi-magnify mdi-21 vcenter item-label search-contacts-input-icon"></i>
													</div>
													<div class="input-field">
														{!! Form::select("city",['' => ''] + App\Ciudad::getCitiesList(),null, ['class'=>'browser-default choice-select-deselect choice-filter-contacts', 'id'=>'filter-contacts-city', 'data-placeholder' => "Selecciona una ciudad", 'placeholder' => "Selecciona una ciudad"] )!!}
													</div>
												</div>
											{!! Form::close() !!}
											</a>
										</div>
										<a href="<%- window.Misc.urlFull( Route.route('usuario.index') ) %>" title="Buscar Amigos" class="text-xmd">Buscar más contactos</a>
									</div>
								</div>


								<div class="mobile-12 medium-8 medium-pull-4 large-9 large-pull-3 xlarge-6 xlarge-pull-3 columns">
									<div class="panel-info radius-tablet-up with-title">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Contactos</span>
											<i class="mdi mdi-account-multiple mdi-18 gray-light vcenter"></i>
										</h6>
										@include('public.noresults', ['message' => 'No hay contactos'])
										<ul id="user-network-wrap" class="tablet-block-grid-2 no-bullet">
													{{-- Render contacs list --}}
										</ul>
									</div>
								</div>


							</div>
						</div>
					</div>

					{{-- Content user calendar --}}
					<div class="content <%- tab=='calendario' ? 'active' : '' %> " id="user-calendar">
						<div class="row">
							<div class="small-12 columns">
								<div id="calendar-user" class="calendar-user"></div>
							</div>
						</div>
					</div>

					{{-- Content user mentor --}}
					<div class="content <%- tab=='mentor' ? 'active' : '' %>" id="user-mentor">
						<div id="profile-user-mentor">
							<div class="row">


								{{-- <div class="mobile-12 columns">
									<div class="panel-content radius-tablet-up">
										Aún no eres mentor <a href="">(conviértete en mentor y obtén beneficios ayudando a otros a lograr sus objetivos, haz clic aquí)</a>
									</div>
								</div>
								<div class="mobile-12 columns">
									<div class="panel-info radius-tablet-up with-title user-mentor-become-request">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Solicitud enviada</span>
											{{-- <i class="mdi mdi-clock mdi-18 gray-light vcenter"></i>
										</h6>

										<ul class="inline-list-grid align-top no-bullet">
											<li class="has-image">
												<i class="mdi mdi-clock-outline mdi-24 vtop icon-circle gutter-right item-label gray-light"></i>
											</li>

											<li>
												<ul class="becoming-mentor-actions">
													<li>Espera a que tu solicitud de mentor sea aceptada</li>
													<li class="text-xsm light-text">hace 2 meses</li>
													<li class="mentor-request-action">
														<a href="" class="btn-friendship button button-outline xtiny btn-lowerc radius"><i class="icon-btn mdi mdi-close mdi-16 vcenter"></i>Cancelar solictud</a>
													</li>
												</ul>
											</li>
										</ul>
									</div>
								</div> --}}


								<div class="mobile-12 medium-12 xlarge-3 columns">
									<div id="mentor-active-process" class="panel-info radius-tablet-up with-title">

										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Tienes 1 proceso activos</span>
											<i class="mdi mdi-cogs mdi-18 gray-light vcenter"></i>
										</h6>

										<div class="content-data-list">
											@include('public.noresults', ['message' => 'No tienes procesos activos'])

											<ul class="no-bullet">

												<li class="card-data-info separator">
													<div class="row valign-middle">
														<div class="small-12 columns">
															<ul class="inline-list-grid card-data-item align-top no-bullet">
																<li class="has-image">
																	<a href="" class="post-avatar" title="<%- nombre_usuario %>">
																		<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg" alt="" class="rounded-img size35">
																	</a>
																</li>
																<li>
																	<a href="" title="" class="name-mentor-process text-sm">
																		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
																	</a>
																	<span class="text-xsm process-time">Hace 3 horas</span>
																</li>

																<li>
																	<ul class="align-top no-bullet card-options-button">
																		<li class="tablet-text-right">
																			<a class="action-mentoring-process" data-dropdown="drop-opts-friendship-<%- nickname_usuario %>" aria-controls="drop-opts-friendship-<%- nickname_usuario %>"><i class="mdi mdi-dots-vertical mdi-18 vcenter icon-circle item-label"></i></a>
																		</li>
																	</ul>
																</li>
															</ul>
														</div>
													</div>



												</li>

												{{-- <li class="card-data-info separator">
													<ul class="inline-list-grid card-data-item align-top no-bullet">
														<li class="has-image">
															<a href="" class="post-avatar" title="<%- nombre_usuario %>">
																<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg" alt="" class="rounded-img size35">
															</a>
														</li>
														<li>
															<a href="" title="" class="name-mentor-process text-sm">
																<p>Vivamus convallis augue non.</p>
															</a>
															<span class="text-xsm process-time">Hace 12 horas</span>
														</li>
														<li>
															<ul class="align-top no-bullet card-options-button">
																<li class="tablet-text-right">
																	<a class="action-mentoring-process" data-dropdown="drop-opts-friendship-<%- nickname_usuario %>" aria-controls="drop-opts-friendship-<%- nickname_usuario %>"><i class="mdi mdi-dots-vertical mdi-18 vcenter icon-circle item-label"></i></a>
																</li>
															</ul>
														</li>
													</ul>
												</li> --}}

											</ul>
										</div>

									</div>
								</div>


								<div class="mobile-12 tablet-5 tablet-push-7 medium-4 medium-push-8 xlarge-3 xlarge-push-6 columns">

									<div id="mentoring-process-requests" class="panel-info radius-tablet-up with-title">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Solicitudes de mentoría</span>
											<i class="mdi mdi-teach mdi-18 gray-light vcenter"></i>
										</h6>
										<div>
											<p class="light-text text-sm">Aún no tienes solicitudes de mentorías, <a class="lighter-text" href="">prueba buscar proyectos que podrían necesitar tu ayuda</a></p>
										</div>
									</div>

									<div id="mentoring-process-requests" class="panel-info radius-tablet-up with-title">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Solicitudes de mentoría</span>
											<i class="mdi mdi-teach mdi-18 gray-light vcenter"></i>
										</h6>
										<div class="mentoring-process-request-item">
											<ul class="no-bullet">
												<li class="card-data-info separator">
													<div class="row valign-middle">
														<div class="small-12 columns">
															<ul class="inline-list-grid card-data-item align-top no-bullet">
																<li class="has-image">
																	<a href="" class="post-avatar" title="<%- nombre_usuario %>">
																		<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg" alt="" class="rounded-img size35">
																	</a>
																</li>
																<li>
																	<a href="" title="" class="text-sm request-user-name">
																		<p>Nombre usuario</p>
																	</a>
																	<p class="light-text text-sm request-issue">Fusce imperdiet posuere turpis vel sagittis. Vivamus viverra finibus quam, eget auctor nu...</p>
																	<span class="text-xsm request-time">Hace 3 horas</span>
																</li>
																<li>
																	<ul class="align-top no-bullet card-options-button">
																		<li class="tablet-text-right">
																			<a class="action-mentoring-process" data-dropdown="drop-opts-friendship-<%- nickname_usuario %>" aria-controls="drop-opts-friendship-<%- nickname_usuario %>"><i class="mdi mdi-dots-vertical mdi-18 vcenter icon-circle item-label"></i></a>
																		</li>
																	</ul>
																</li>
															</ul>
														</div>
													</div>
												</li>
											</ul>
										</div>
									</div>

									<div class="panel-info radius-tablet-up with-title mentor-profile-improve">
										<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
											<span class="left">Completa tu perfil mentor</span>
											<i class="mdi mdi-chart-donut mdi-18 gray-light vcenter"></i>
										</h6>
										<div class="user-mentoring-process-item">
											<ul class="inline-list-grid user-mentoring-process-card align-top">
												<li class="has-image">
													<i class="mdi mdi-paperclip mdi-18 gray-light vcenter"></i>
												</li>
												<li>
													<a class="text-sm" href="">Adjunta tu hoja de vida</a>
												</li>
											</ul>
										</div>
									</div>
								</div>



								{{-- mentor skills --}}
								<div class="mobile-12 tablet-7 tablet-pull-5 medium-8 medium-pull-4 xlarge-6 xlarge-pull-3 columns">
									<div class="panel-info radius-tablet-up with-title editable mentor-skills">

										<div class="mentor-skills-content-item">
											<div id="" class="editable-item clearfix">
												<h4 class="title-panel text-left">
													<ul class="inline-list-grid align-top no-bullet">
														<li>En qué puedo ayudar</li>
														<li class="has-image">
															<button class="edit-field-button edit-field right">
																<i class="mdi mdi-pencil"></i>
															</button>
														</li>
													</ul>
												</h4>
											</div>

											<ul class="user-mentor-content-list  mobile-block-grid-1 small-block-grid-1 tablet-block-grid-1">
												<li class="text-xmd">
													· Acceso a contenidos e información sobre emprendimiento.
												</li>
												<li class="text-xmd">
													· Encontrar opciones de capacitación.
												</li>
												<li class="text-xmd">
													· Asesoría en la creación de un plan de negocios.
												</li>
												<li class="text-xmd">
													· Conocer programas y organizaciones de ayuda al emprendedor.
												</li>
											</ul>
										</div>

										<hr>

										<div class="mentor-skills-content-item">
											<div id="" class="editable-item clearfix">
												<h4 class="title-panel text-left">
													<ul class="inline-list-grid align-top no-bullet">
														<li>Especialidades (áreas de experiencia)</li>
														<li class="has-image">
															<button class="edit-field-button edit-field right">
																<i class="mdi mdi-pencil"></i>
															</button>
														</li>
													</ul>
												</h4>
											</div>

											<ul class="user-mentor-content-list  mobile-block-grid-1 small-block-grid-1 tablet-block-grid-1">
												<li class="text-xmd">
													· Acceso a contenidos e información sobre emprendimiento.
												</li>
												<li class="text-xmd">
													· Encontrar opciones de capacitación.
												</li>
												<li class="text-xmd">
													· Asesoría en la creación de un plan de negocios.
												</li>
												<li class="text-xmd">
													· Conocer programas y organizaciones de ayuda al emprendedor.
												</li>
											</ul>
										</div>

										<hr>

										<div class="mentor-skills-content-item">
											<div id="" class="editable-item clearfix">
												<h4 class="title-panel text-left">
													<ul class="inline-list-grid align-top no-bullet">
														<li>Mi experiencia</li>
														<li class="has-image">
															<button class="edit-field-button edit-field right">
																<i class="mdi mdi-pencil"></i>
															</button>
														</li>
													</ul>
												</h4>
											</div>

											<ul class="user-mentor-content-list  mobile-block-grid-1 small-block-grid-1 tablet-block-grid-1">
												<li class="text-xmd">
													· Acceso a contenidos e información sobre emprendimiento.
												</li>
												<li class="text-xmd">
													· Encontrar opciones de capacitación.
												</li>
												<li class="text-xmd">
													· Asesoría en la creación de un plan de negocios.
												</li>
												<li class="text-xmd">
													· Conocer programas y organizaciones de ayuda al emprendedor.
												</li>
											</ul>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>


					{{-- Content user preferences --}}
					<div class="content <%- tab=='preferencias' ? 'active' : '' %> " id="user-preferences">
						<div class="small-12 columns">
							<div class="row">
								<div class="small-12 tablet-6 tablet-centered columns">
									<div class="panel-content radius">
										<ul class="no-bullet list-highlighted">
											<li>
												<a href="<%= window.Misc.urlFull(Route.route( 'usuario.confirmdeactivation'))%>" title="Desactivar mi cuenta">
													<i class="mdi mdi-close-circle mdi-21 vcenter"></i>
													Desactivar mi cuenta
												</a>
											</li>
											<li id="stage-permission-notification">
												{{-- Render template stage permission notification - id::stage-permission-notification --}}
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					@endif

				</div>
			</div>
		</div>
	</div>

	<% if(owner){ %>
		{{-- dropdown edit form --}}
		<div id="drop-edit-form" data-dropdown-content class="md-dropdown content radius large" aria-hidden="true">
			{{-- Render profile edit form --}}
		</div>
		<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown content radius large" aria-hidden="true">
			{{-- Render profile edit form --}}
		</div>
	<% } %>
</script>

{{-- item project list user --}}
<script type="text/template" id="project-item-list-tpl">
	@if (Auth::check())
		<div class="item-wrap-list radius">
			<div class="top-item-list no-border">
				<a class="item-thumb" href="<%= window.Misc.urlFull(Route.route( 'proyecto.proyecto',{'proyecto': nickname_usuario }))%>" title="<%= nombre_usuario %>">
					<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" title="<%- nombre_usuario %>"  onerror="imageDefault(this,'{{ config('tuproyecto.no_project_image') }}')">
				</a>
			</div>
			<div class="content-item-list text-left">
				<h5 class="title-item-list black-text is-hovered ellipsis is-truncated">
					<a href="<%= window.Misc.urlFull(Route.route( 'proyecto.proyecto',{'proyecto': nickname_usuario }))%>"><%- nombre_usuario %></a>
				</h5>
				<p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- biografia_usuario %></p>
				<p class="category-list-item upper-text ellipsis is-truncated"><%- nombre_categoria_proyecto %></p>

				<div class="bottom-item-list">

					<ul class="inline-list-grid align-center">
						<% if(!_.isNull(nombre_ciudad)){ %>
						<li class="text-left project-origin">
							<ul class="inline-list-grid align-center gray-base-text no-spacing overflowed-text">
								<li class="has-image"><i class="mdi mdi-map-marker mdi-16 vcenter"></i></li>
								<li class="no-wrap">
									<span class="text-xsm"><%- nombre_ciudad+ ' · ' +distrito_ciudad %></span>
								</li>
							</ul>
						</li>
						<% } %>
						<li class="text-right no-wrap short-col">
							<ul id="drop-liked-project-<%- codigo_entidad %>" class="post-social-shared program-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
								<li>
									<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
								</li>
							</ul>
							<ul class="social-box-icons">
								<li class="no-wrap">
									<a class="data-post-share TPlikelink no-text-like {{ (!Auth::check() && App\RegistroSesion::institution()->votacion_entidades) ? 'vote-system' : '' }}" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-project-<%- codigo_entidad %>" aria-controls="drop-liked-project-<%- codigo_entidad %>" data-options="align:top;is_hover:true;hover_timeout:500">
									<i class="mdi mdi-thumb-up-outline mdi-16 vcenter"></i>
									<span class="data-count-likes text-xsm"><%- contador_like %></span>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	@endif
</script>
{{-- item team list user --}}
<script type="text/template" id="team-item-list-tpl">
	@if (Auth::check())
	<div class="item-project-list">
		<div class="top-item-project">
			<h4 class="left title-item-project"><%- nombre_grupo %></h4>
		</div>
		<div class="img-item-project">
			<a href="http://red.redemprendedoresbavaria.net/teamintegrate?codigo_usuario={{ Auth::user()->codigo_usuario_mysql}}&team=<%= codigo_grupo %>" title="<%- nombre_grupo %>" target="blank">
				<img src="<%- imagen_grupo ? imagen_grupo : 'http://static.tuproyecto.com/images/svg/no-group-image.svg' %>" alt="<%- nombre_grupo %>"  title="<%- nombre_grupo %>" />
			</a>
		</div>
	</div>
	@endif
</script>
{{-- item survey list user --}}
<script type="text/template" id="survey-item-list-tpl">
	@if (Auth::check())
	<div class="item-piece-list">
		<div class="content-item-piece clearfix">
			<ul class="left inline-list">
				<li>
					<span><i class="<%- icono_orientacion_encuesta %> purple-blue mdi-24"></i></span>
				</li>
				<li>
					<span class="title-item-piece text-xmd">
						<strong><a href="<%- redirect ? redirect : '#' %>" title="<%- nombre_encuesta %>" target="blank">
								<%- nombre_encuesta %></a>
						</strong>
						<% if(!_.isUndefined(reference_encuesta) && !_.isNull(reference_encuesta) && reference_encuesta.length) { %>
							<div class="content-item-pice"><span><%- reference_encuesta %></span></div>
						<% } %>
					</span>
					<span class="light-text text-xsm"><%- window.moment(fecha_encuesta).format('LL') %></span>
				</li>
			</ul>
			<ul class="right inline-list">
				<li>
					<span><%- nombre_estado %></span>
				</li>
			</ul>
		</div>
	</div>
	@endif
</script>

{{-- User Network template --}}
<script type="text/template" id="user-network-item-tpl">
	@if (Auth::check())
		<div class="user-network-item">

			<div class="row valign-middle">
				<div class="small-12 columns">
					<ul class="inline-list-grid card-data-item network-user-card align-center no-bullet">
						<li class="has-image">
							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="post-avatar" title="<%- nombre_usuario %>">
								<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size35">
							</a>

						</li>
						<li>
							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" title="<%- nombre_usuario %>" class="name-user text-sm">
								<%- nombre_usuario%>
							</a>
							<% if( (!_.isUndefined(profesion_usuario) && !_.isNull(profesion_usuario) ) || owner) { %>
							<p class="light-text text-xsm">
									<span><%- profesion_usuario %></span>
							</p>
							<% } %>
						</li>
						<li>
							<ul id="buttons-contact-friendship" class="align-top no-bullet card-options-button">
								{{-- Render buttoms follows --}}
							</ul>
						</li>
					</ul>
				</div>
			</div>


		</div>
	@endif
</script>

{{-- Pending Friendship template --}}
<script type="text/template" id="pending-friendship-item-tpl">
	@if (Auth::check())

		<div class="pending-friendship-item">
			<div class="row valign-middle">
				<div class="small-12 columns">


					<ul class="inline-list-grid card-data-item align-center no-bullet">
						<li class="has-image">

							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="post-avatar" title="<%- nombre_usuario %>">
								<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size35">
							</a>

						</li>
						<li>
							<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" title="<%- nombre_usuario %>" class="name-user text-sm">
								<%- nombre_usuario%>
							</a>
							<% if( (!_.isUndefined(profesion_usuario) && !_.isNull(profesion_usuario) ) || owner) { %>
							<p class="light-text text-xsm">

									<span><%- profesion_usuario %></span>
							</p>
							<% } %>
						</li>

						<li>
							<ul id="buttons-contact-pending-friendship" class="{{-- stages-friendship-user --}} align-top no-bullet card-options-button">
								{{-- Render buttoms follows --}}
							</ul>
						</li>
					</ul>


				</div>
			</div>
		</div>

	@endif
</script>


{{-- Section Find Friends --}}
<script type="text/template" id="filters-friends-tpl">
	<div id="content-user-results-search">
		<div class="row">
			<div class="tablet-3 columns">
				<div id="" class="panel-info radius-tablet-up with-title content-contacts-list content-data-list block-filters-choice">
					<h5 class="title-panel text-left">Filtros de usuario</h5>
					<div class="section-events-filter">
						{!! Form::open(array('route' => null, 'id' => 'form-conctacts-filter')) !!}
							<div class="row">
								<div class="small-12 columns">

									<select name="city" class="browser-default choice-select change-choice" data-placeholder="Seleccione una ciudad" placeholder="Seleccione una ciudad">
										<option value=""></option>
										@foreach( App\Ciudad::getCitiesList() as $key => $value)
											<option value="{{ $key }}" <%- dataFilter.city == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
										@endforeach
									</select>
								</div>
								<div class="small-12 columns input-field">
									<input type="text" name="user" id="user" value="<%- dataFilter.user %>" placeholder="Escribe un nombre" class="keyup-search" pattern="^(.){2,}[^\s]*">

								</div>
								<div class="small-12 columns input-field">
									<input type="text" name="nickname" id="nickname" value="<%- dataFilter.nickname %>" placeholder="Escribe un nickname" class="keyup-search" pattern="^(.){2,}[^\s]*">

								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
			<div class="tablet-9 columns">
				<div id="list-result-users" class="panel-info radius-tablet-up with-title content-data-list">
					<h5 class="title-panel text-left">Usuarios</h5>
					@include('public.noresults')
					<ul id="friends-wrap" class="list-separator no-bullet">
						{{-- Render contacts list --}}
					</ul>
				</div>
			</div>
		</div>
	</div>
</script>


{{-- Template for contacts --}}
<script type="text/template" id="find-friends-tpl">
	@if (Auth::check())
		<div class="row valign-middle">
			<div class="small-12 columns">
				<ul class="inline-list-grid filter-result-user-card align-top no-bullet">
					<li class="has-image">
						<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="post-avatar" title="<%- nombre_usuario %>">
							<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size45">
						</a>
					</li>
					<li>
						<ul class="no-bullet">
							<li>
								<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" title="<%- nombre_usuario %>" class="name-user text-md">
									<%- nombre_usuario %>
								</a>
							</li>
							<li>
								<span class="light-text text-sm">
									<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
										<span><%- nombre_ciudad %>, <%- nombre_pais %></span><span class="vertical-separator">&VerticalSeparator;</span>
									<% } %>
									<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" class="dark-text"><%- window.Misc.strToNickname(nickname_usuario) %>
									</a>
								</span>
							</li>
						</ul>
						<ul id="buttons-connect-friendship" class="stages-friendship-user no-bullet">
							{{-- Render buttons follows --}}
						</ul>
					</li>
				</ul>
			</div>
		</div>
	@endif
</script>

{{-- User Message template --}}
<script type="text/template" id="user-message-item-tpl">
	@if (Auth::check())
		<div class="item-message-user">
			<ul class="inline-list-grid align-top card-user-message no-bullet">
				<li class="has-image">
					<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': emisor ? nickname_usuario_receptor : nickname_usuario_emisor }) ) %>" title="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>" class="avatar">
						<img src="<%- emisor ? imagen_usuario_receptor : imagen_usuario_emisor %>" alt="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>" class="rounded-img size40">
					</a>
				</li>
				<li>
					<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname.tab', {'nickname': nickname_usuario, 'tab': 'mensajes', 'user': emisor ? nickname_usuario_receptor : nickname_usuario_emisor }) ) %>" title="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>" class="data-message" title="Ver mensaje">
						<ul class="no-bullet">
							<li>
								<span class="text-xmd dark-text">
								<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>
								</span>
							</li>
							<li>
								<p class="block-text-xmedium light-text clean-bottom"><%- window.Misc.maxLen(lastcomment, 25) %></p>
							</li>
						</ul>
					</a>
				</li>
			</ul>
		</div>
	@endif
</script>

{{-- item Product list --}}
<script type="text/template" id="user-product-item-list-tpl">
	<div class="item-wrap-list radius">
		<div class="top-item-list no-border">
			<a href="<%= window.Misc.urlFull(Route.route('marketplace.show', {'marketplace': url_producto}))%>" title="<%- nombre_producto %>" class="item-thumb">
				<img src="<%- imagen_producto %>" alt="<%- nombre_producto %>" title="<%- nombre_producto %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_image') }}')">
			</a>
		</div>
		<div class="content-item-list text-left">
			<h5 class="title-item-list black-text is-hovered ellipsis is-truncated">
				<a href="<%= window.Misc.urlFull(Route.route('marketplace.show', {'marketplace': url_producto}))%>" title="<%- nombre_producto %>">
				<%- nombre_producto %>
				</a>
			</h5>
			<p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- resumen_producto %></p>
			<p class="category-list-item upper-text ellipsis is-truncated"><%- nombre_categoria_producto %></p>

			<div class="bottom-item-list card-action">
				<ul class="inline-list-grid align-center">
					<li class="product-price">
						<span class="black-text heavy-text">$<%- (precio_producto > 0 && !producto_sin_precio)? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%></span>
					</li>
					<li>
						<span class="right">
							<a href="#" title="Añadir a favoritos" class="post-favorite-icon TPfavoritelink gray-light-text">
								<i class="mdi mdi-heart-outline vcenter"></i>
							</a>
						</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</script>

{{-- item Program list --}}
<script type="text/template" id="user-program-item-list-tpl">
	<a href="#content-review-program-user" class="to-open-review">
			<span class="gray-dark-text text-md"><%- nombre_convocatoria %></span>
	</a>
	<ul>
		<li class="gray-dark-text text-sm"><%- nombre_fase %></li>
		<li class="gray-dark-text text-sm"><%- fecha_registro_convocatoria %></li>
	</ul>
</script>

{{-- post Discussion Message template --}}
<script type="text/template" id="discussion-message-user-tpl">
	<div class="user-discussion-item">
		<div class="row collapse">
			<div class="small-12 columns">
				<ul class="inline-list-grid discussion-user-card align-top">
					<li class="has-image">
						<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': emisor ? nickname_usuario_receptor : nickname_usuario_emisor }) ) %>" class="post-avatar" title="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>">
							<img src="<%- emisor ? imagen_usuario_receptor : imagen_usuario_emisor %>" alt="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>" class="rounded-img size40">
						</a>
					</li>
					<li>
						<ul class="no-bullet">
							<li>
								<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': emisor ? nickname_usuario_receptor : nickname_usuario_emisor }) ) %>" title="<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>" class="name-user text-md">
									<%- emisor ? nombre_usuario_receptor : nombre_usuario_emisor %>
								</a>
							</li>
							<li>
								<span class="light-text text-sm">
									<% if( emisor ? !_.isUndefined(nombre_ciudad_receptor) &&  !_.isNull(nombre_ciudad_receptor) : !_.isUndefined(nombre_ciudad_emisor) &&  !_.isNull(nombre_ciudad_emisor) ) { %>
											<span><%- emisor ? nombre_ciudad_receptor : nombre_ciudad_emisor %>, <%- emisor ? nombre_pais_receptor : nombre_pais_emisor %></span><span class="vertical-separator">&VerticalSeparator;</span>
									<% } %>
									<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': emisor ? nickname_usuario_receptor : nickname_usuario_emisor }) ) %>" class="dark-text"><%- window.Misc.strToNickname(emisor ? nickname_usuario_receptor : nickname_usuario_emisor) %>
									</a>
								</span>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<hr />

	{{-- Discussion comments box--}}
	<section class="comments-discussion-list scroll-general-v">
		{{-- Render user discussion--}}

	</section>

	<div class="textarea-post-message">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-comment-discussion') ) !!}
			<div class="row collapse">
				<div class="small-11 columns">
					{{-- <textarea name="texto_comentario_discucion" placeholder="Escribe un mensaje" rows="1" class="wysiwyg-commentdiscussion" required="required" autofocus></textarea> --}}
					<input type="text" name="texto_comentario_discucion" value="" placeholder="Escribe un mensaje" autofocus required="required" class="wysiwyg-commentdiscussion">
				</div>
				<div class="small-1 columns">
					<button class="postfix" type="submit"><i class="mdi mdi-send mdi-24"></i></button>
				</div>
			</div>
			<input type="hidden" name="codigo_discucion" value="<%- codigo_discucion %>">
		{!! Form::close() !!}
	</div>

</script>

{{-- comment Discussion template --}}
<script type="text/template" id="comment-discussion-tpl">
	<ul class="inline-list-grid post-message-card align-top" data-owner="<%= owner %>">
		<% if(!owner){ %>
			<li class="has-image">
				<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" class="post-avatar" title="">
					<img src="<%- imagen_usuario %>" alt="" class="rounded-img size35">
				</a>
			</li>
		<% } %>
		<li>
			<div class="content-message-post">
				<p class="text-description-message"><%- texto_comentario %></p>
				<span class="text-xsm light-text"><%- window.moment([fecha_comentario, hora_comentario].join(' '), "YYYY-MM-DD HH:mm:ss").format("MMM D, h:mm a") %></span>
				<% if(owner){ %>
					<a class="options-message right" data-dropdown="drop-message-opts-<%- id_comentario %>" aria-controls="drop-message-opts-<%- id_comentario %>" data-options="align:left"><i class="mdi mdi-chevron-down mdi-21"></i></a>
					<ul id="drop-message-opts-<%- id_comentario %>" data-dropdown-content class="friendship-dropdown radius no-arrow" aria-hidden="true">
						<li>
							<a href="#" title="Eliminar mensaje" class="on-remove-comment">
								Eliminar mensaje
								<i class="mdi mdi-eraser mdi-24 vcenter"></i>
							</a>
						</li>
					</ul>
				<% } %>
			</div>
		</li>
		<% if(owner){ %>
			<li class="has-image">
				<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" class="post-avatar" title="">
					<img src="<%- imagen_usuario %>" alt="" class="rounded-img size35">
				</a>
			</li>
		<% } %>
	</ul>
</script>

{{-- Templates for user wall --}}

{{-- section Confirm Remove Project --}}
<script type="text/template" id="project-confirm-remove-tpl">
	<p>{{ Lang::get('project.close.confirm') }}</p>
</script>

<script type="text/template" id="user-confirm-contact-tpl">
	<p>{{ Lang::get('user.contact.remove.confirm') }}</p>
</script>

<script type="text/template" id="confirm-remove-discussion-tpl">
	<p>{{ Lang::get('user.confirm.remove.comment.discussion') }}</p>
</script>

@stop
