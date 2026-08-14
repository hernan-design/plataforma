@extends('public.calendar.calendar')

@section('calendar.content')

	{{-- ------------------ Calendar Templates JS -------------------- --}}
	{{-- Section calendar events --}}
	<script type="text/template" id="calendar-events-tpl">
		<div id="content-calendar-events">
			<div class="row">
				<div class="small-12 tablet-12 medium-3 columns">
					{!! Form::open(array('route' => null, 'id' => 'form-events-filter')) !!}
						<div class="panel-content with-title radius-tablet-up events-filters show-for-tablet-up">
							<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
								<span class="left">Filtros</span>
									<i class="mdi mdi-tune mdi-18 gray-light vcenter"></i>
							</h6>
							<div class="section-events-filter">
								<div class="tablet-6 columns input-field">
									<label for="fecha_evento">Fecha de Inicio del evento</label>
									<input type="text" name="fecha_evento" id="fecha_evento" value="<% (typeof(fecha_evento) !=='undefined') ? fecha_evento :''  %>"class="dateafterpk validate" required>
								</div>
                                <div class="tablet-6 columns input-field">
									<label for="fecha_fin_usuario">Fecha de Fin del evento</label>
									<input type="text" name="fecha_fin_evento" id="fecha_fin_evento" value="<% (typeof(fecha_fin_evento) !=='undefined') ? fecha_fin_evento :''  %>"class="datepk validate" required>
								</div>
								<div class="">
									{!! Form::select("city",['' => ''] + App\Ciudad::getCitiesList(),null, ['class'=>'browser-default choice-select-deselect choice-filter-events', 'id'=>'filter-events-city', 'data-placeholder' => "Seleccione una ciudad"] )!!}
								</div>
							</div>
						</div>

						<div class="panel-content with-title radius-tablet-up events-filters-category show-for-tablet-up">
							<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
								<span class="left">Filtrar por categorías</span>
								<i class="mdi mdi-tune mdi-18 gray-light vcenter"></i>
							</h6>
							<ul class="side-nav-slide">
								@php
									$calendar = isset($id) && !empty($id) ? $id : null;
								@endphp
								@foreach(App\TipoEvento::getTypes('platform', $calendar) as $value)
					                <li>
					                    <input type="checkbox" id="filter_{{ strtolower($value->nombre_tipo_evento) }}" name="categories" class="filters-categories" value="{{ $value->codigo_tipo_evento }}">
					                    <label for="filter_{{ strtolower($value->nombre_tipo_evento) }}" class="check-right">
					                        <span class="text-md">
					                            <i class="{{ $value->icono_tipo_evento }} mdi-16 vcenter gray-light gutter-right"></i>
					                            {{ $value->nombre_tipo_evento }}
					                        </span>
					                    </label>
					                </li>
								@endforeach
				            </ul>
						</div>
					{!! Form::close() !!}
				</div>

				<div class="small-12 tablet-12 medium-9 columns">

					{{--<div id="panel-event-publishing" class="panel-content radius-tablet-up">
			            <ul class="inline-list-grid vcenter">
			                <li class="has-image">
			                    <img class="rounded-img size35" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/svg/no-user-image.svg" alt="" onError="" />
			                </li>
			                <li>
			                    <span class="gray-base-text text-md normal-text">Crea un Evento aquí</span>
			                </li>
			                <li>
			                    <a class="button xsmall sky-blue radius btn-resetc btn-bold btn-clean-margin waves-effect waves-light right">Crear un tema</a>
			                </li>
			            </ul>
			        </div>--}}

					@include('public.noresults', ['message' => 'No hay eventos.'])
			        <div id="events-wall-browse">
						{{-- Render template id="events-wall-browse-tpl" --}}
			        </div>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="events-wall-browse-tpl">
		<div id="events-content-<%- id %>">
			{{-- date item  --}}
			<div id="date-events-<%- id %>" class="date-events-content">
				{{-- Render template id="date-events-content-tpl" --}}
			</div>
			<div id="content-events-list-<%- id %>" class="events-content">
				<ul id="calendar-events-list-<%- id %>" class="mobile-block-grid-1 browse-list-mask browse-list-events adaptive-images events-list">
					{{-- Render Template id="calendar-item-event-tpl" --}}
				</ul>
			</div>
		</div>
	</script>

	<script type="text/template" id="date-events-content-tpl">
		<div class="events-wall-date">
			<span class="date"><em><%- window.moment(date).format("DD") %></em> <%- window.moment(date).format("MMMM")%> <em><%- window.moment(date).format('YYYY') < moment(new Date(), 'YYYY').format('YYYY') ? window.moment(date).format("YYYY") : '' %></em></span>
		</div>
	</script>

	<script type="text/template" id="calendar-item-event-tpl">
		<div class="card-event-info card-data-info">
			<div class="row collapse col-equal-height">
				<div class="mobile-3 tablet-4 medium-3 columns">
					<div class="top-item-list no-border">
						<a href="<%= window.Misc.urlFull( Route.route( 'calendario.evento.show', { evento: url_evento }) ) %>" class="item-thumb">
							<img src="<%- imagen_evento %>" alt="" onerror="if (this.src != '{{ config('tuproyecto.no_event_image') }}') this.src = '{{ config('tuproyecto.no_event_image') }}';">
						</a>
					</div>
				</div>

				<div class="mobile-9 tablet-8 medium-9 columns">
					<div class="content-item-list content-roster-list">
						<h4 class="title-item-list ellipsis">
							<a class="black-text" href="<%= window.Misc.urlFull( Route.route( 'calendario.evento.show', { evento: url_evento }) ) %>"><%- window.Misc.maxLen(nombre_evento, 65) %></a>
						</h4>

						<ul class="no-bullet show-for-tablet-up">
							<li class="event-place text-sm gray-text">
								<span><%- window.Misc.maxLen(lugar_evento, 25) %></span>
								<span class="vertical-separator">·</span>
								<span><%- nombre_ciudad %></span>
							</li>

							<li class="event-date-time text-sm gray-text">
								<span><%- window.moment(fecha_evento).format("dddd DD [{{ Lang::get('app.of') }}] MMMM [{{ Lang::get('app.of') }}] YYYY") %></span>
								<% if( window.moment(fecha_fin_evento).isValid() && window.moment(fecha_fin_evento).isAfter(fecha_evento) ) { %>
									<span>, <%- window.moment(fecha_fin_evento).format("dddd DD [{{ Lang::get('app.of') }}] MMMM [{{ Lang::get('app.of') }}] YYYY") %></span>
								<% } %>
								<% if (hora_inicio_evento || hora_fin_evento) {%>
									<span class="vertical-separator">·</span>
									<% if(hora_inicio_evento && !hora_fin_evento) { %>
										<span><%- window.moment(hora_inicio_evento, "H:mm").format("HH:mm") %></span>
									<% } else if (!hora_inicio_evento && hora_fin_evento) { %>
										<span><%- window.moment(hora_fin_evento, "H:mm").format("HH:mm") %></span>
									<% } else { %>
										<span><%- window.moment(hora_inicio_evento, "H:mm").format("HH:mm") %> {{ Lang::get('app.to') }} <%- window.moment(hora_fin_evento, "H:mm").format("HH:mm") %></span>
									<% } %>
								<% } %>
							</li>
						</ul>

						<p class="bold-text text-sm black-text"> <%- pago_evento ? 'Evento pago' : '' %></p>

                        <% if(typeof etapas !== 'undefined' && etapas) { %>
						<label class="label single dark-text bold-text text-xsm"> Fase(s): <span class="lighter-text gray-dark-text"><%- etapas %></span></label>
						<br>
                        <% } %>

                        <% if(typeof categorias !== 'undefined' && categorias) { %>
						<label class="label single dark-text bold-text text-xsm"> Categoria(s):  <span class="lighter-text gray-dark-text"><%- categorias %></span></label>
                        <% } %>

                        <div class="event-botom-list">
                            <ul class="inline-list-grid align-center">
                                <li class="text-left">
                                    <% if(nombre_organizador_principal){ %>
                                    <ul class="card-user-entry inline-list-grid align-center no-spacing">
								        <li class="has-image">
									        <a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="rounded-thumb no-outline">
										        <img class="rounded-img" src="<%- imagen_organizador_principal ? imagen_organizador_principal : window._tp.thumbs.avatar() %>" alt="" />
									        </a>
								        </li>
								        <li class="card-user-name">
									        <a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':nickname_organizador}) )  %>" class="bold-text text-sm"><%- nombre_organizador_principal ? nombre_organizador_principal : '' %></a>
								        </li>
                                    </ul>
                                    <% } %>
                                </li>

                                <li class="text-right">
                                    <div class="card-user-entry">
                                        <a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="rounded-thumb no-outline">
										<img class="rounded-img" src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="" />
									    </a>
                                    </div>
                                </li>
                            </ul>
                        </div>

					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section calendar event detail --}}
	<script type="text/template" id="calendar-event-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true" aria-autoclose="false">
			</div>
			<div id="event-city-container" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true" aria-autoclose="false">
			</div>
		<% } %>
		<div id="content-detail-event" class="content-detail-event">
			<div class="wrapper-summary-event">
				<div class="row">
					<div class="mobile-12 tablet-3 columns">
						<div class="event-img">
							<img src="<%- imagen_evento %>" alt="" onerror="if (this.src != '{{ config('tuproyecto.no_event_image') }}') this.src = '{{ config('tuproyecto.no_event_image') }}';">
							<span class="date-on-image">
								<em><%- window.moment(fecha_evento).format("DD") %></em> <%- window.moment(fecha_evento).format("MMM") %>
							</span>
							<% if(owner){ %>
								<div class="content-edit-button">
									<button id="change-photo-user" class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
								</div>
							<% } %>
						</div>
					</div>

					<div class="mobile-12 tablet-9 columns">
						<div id="event-title-main"></div>
						<div class="event-main-info">
							<div>
								<i class="mdi mdi-calendar vcenter gutter-right"></i>
								{{-- date --}}
								<span class="date">
									<%- window.moment(fecha_evento).format("ddd DD [{{ Lang::get('app.of') }}] MMMM") %>
										<% if( window.moment(fecha_fin_evento).isValid() && window.moment(fecha_fin_evento).isAfter(fecha_evento) ) { %>
										 	- <%- window.moment(fecha_fin_evento).format("ddd DD [{{ Lang::get('app.of') }}] MMMM") %>
											 <span class="vertical-separator show-for-tablet-up">·</span>
											<i class="mdi mdi-clock-outline vcenter gutter-right"></i>
											 <span class="time">
											 	<%- window.moment(fecha_evento+' '+hora_inicio_evento).format("hh:mm A") %> -
												<%- window.moment(fecha_fin_evento+' '+hora_fin_evento).format("hh:mm A") %>
											</span>
									<% } %>
								</span>
							</div>
							<div>
								<% if( window.moment(fecha_fin_evento).isValid() && window.moment(fecha_fin_evento).isSame(fecha_evento) ) { %>
								{{-- time --}}
									<% if (hora_inicio_evento) { %>
										<span class="vertical-separator show-for-tablet-up">·</span>
										<i class="mdi mdi-clock-outline vcenter gutter-right"></i>
										 <% if (hora_inicio_evento && !hora_fin_evento) { %>
											<span class="time">
												<%- window.moment(fecha_evento+' '+hora_inicio_evento).format("hh:mm A") %>
											</span>
										<% } else if (hora_inicio_evento && hora_fin_evento) { %>
											<span class="time">
												<%- window.moment(fecha_evento+' '+hora_inicio_evento).format("hh:mm A") %> -
												<%- window.moment(fecha_fin_evento+' '+hora_fin_evento).format("hh:mm A") %>
											</span>
										<% } %>
									<% } %>
								<% } %>
							</div>
							<div>
								<span class="vertical-separator show-for-tablet-up">·</span>
								<i class="mdi mdi-map-marker vcenter gutter-right"></i>
								{{-- address --}}
								<span class="place"><%- lugar_evento %></span>
								{{-- city --}}
								<span class="city"><%- nombre_ciudad %>,</span>
								{{-- year --}}
								<span class="year"><%- window.moment(fecha_evento).format('YYYY') %></span>
								<button class="edit-field-button edit-field" data-dropdown="event-city-container" aria-controls="event-city-container" data-options="align:right" aria-expanded="false" data-edit-template="infocity"><i class="mdi mdi-pencil"></i></button>
							</div>
						</div>

						<p class="bold-text text-sm black-text"> <%- pago_evento ? 'Evento pago' : '' %></p>
						<% if(typeof etapas !== 'undefined' && etapas){ %>
							<label class="label single dark-text text-ms bold-text"> Fases(s): <span class="lighter-text gray-dark-text text-md"> <%- etapas ? etapas : '' %> </span></label>
						<% } %>
						<br>
						<% if(typeof categorias !== 'undefined' && categorias){ %>
							<label class="label single dark-text text-ms bold-text"> Categorias(s): <span class="lighter-text gray-dark-text text-md"> <%- categorias ? categorias : '' %> </span></label>
						<% } %>
						<br><br>
						<div class="row">
							<div class="mobile-12 tablet-9 columns">
								<div class="event-owner">
									<ul class="inline-list-grid align-top no-spacing event-user-card">
										<li class="has-image">
											<a href="" class="rounded-thumb no-outline">
												<img class="rounded-img size35" src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="" />
											</a>
										</li>
										<li class="event-user-text">
											<span class="text-xsm gray-light-text">Creado por</span><br>
											<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="bold-text text-sm black-text"><%- nombre_usuario %></a>
										</li>
									</ul>
								</div>
							</div>

							<div class="mobile-12 tablet-3 columns">
								<div class="participate-button-action">
									<div id="participate-event">
										{{-- Render template id="participate-event-tpl" --}}
									</div>
								</div>
							</div>

							<div class="mobile-12 tablet-10 tablet-push-2 columns show-for-tablet-up">
								<div class="event-url-group">
									<div class="event-url-icon-group">
										<i class="activator-selection mdi mdi-14 mdi-content-copy vcenter inst-color-secondary icon-circle gutter-right event-url-icon" title="Haz click para copiar vínculo del evento"></i>
										<% if(url_evento_organizador) { %>
											<span class="selection-text text-sm gray-base-text">
												<input readonly class="selection-text event-url medium-text-left text-sm" value="<%- url_evento_organizador %>">
											</span>
										<% } else { %>
											<span class="selection-text text-sm gray-base-text">
												<input readonly class="selection-text event-url medium-text-right text-sm" value="<%- window.Misc.urlFull( Route.route('calendario.evento.show', { evento: url_evento }) ) %>">
											</span>
										<% } %>
									</div>
								</div>
							</div>

							<div class="mobile-2 mobile-centered tablet-2 tablet-pull-10 tablet-uncentered columns">
								<div class="event-social">
									<ul class="inline-list-grid article-icons-shared social-box-icons">
										<li>
											<ul id="drop-shared-social-article" class="friendship-dropdown no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
												<li class="text-center">
													<label class="label single gray-base-text">Compartir en redes:</label>
													<ul class="inline-list-grid align-top">
														<li class="text-center">
															<a href="http://www.facebook.com/share.php?u=<%- window.Misc.urlFull( Route.route( 'calendario.evento.show', { evento: url_evento }) ) %>&title=<%- nombre_evento %>" title="Compartir en facebook" class="tp_facebook_share">
																<i class="mdi mdi-facebook mdi-21 facebook"></i>
															</a>
														</li>
														<li class="text-center">
															<a href="http://www.linkedin.com/shareArticle?mini=true&url=<%= window.Misc.urlFull( Route.route( 'calendario.evento.show', { evento: url_evento }) ) %>&title=<%- nombre_evento %>&source=DOMAIN" title="Compartir en linkedin" class="tp_linkedin_share">
																<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
															</a>
														</li>
														<li class="text-center">
															<a href="http://twitter.com/intent/tweet?status=<%- nombre_evento %>+<%- window.Misc.urlFull( Route.route( 'calendario.evento.show', { evento: url_evento }) ) %>" class="">
																<i class="mdi mdi-close-outline mdi-21 twitter"></i>
															</a>
														</li>
													</ul>
												</li>
											</ul>
											<a title="Compartir" data-dropdown="drop-shared-social-article" aria-controls="drop-shared-social-article" data-options="align:bottom;is_hover:false;hover_timeout:500">
												<i class="mdi mdi-share-variant mdi-21 gutter-right"></i>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="mobile-12 tablet-8 columns">
					<div class="panel-content radius-tablet-up">
						<div id="event-infodescription-container" class="editable-item">
							{{-- Render info description--}}
						</div>
					</div>
				</div>

				<div class="mobile-12 tablet-4 columns">
					<div class="panel-info radius-tablet-up with-title event-organizers">
						<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
							<span class="left">{{ transtp('event.organizers.title') }}</span>
							<i class="mdi mdi-book mdi-18 gray-light vcenter"></i>
						</h6>

						<div id="event-organizers-wrap">
							<ul id="event-organizers-list" class="no-bullet">
								<% if(organizadores.length) { %>
									<% _.each(organizadores, function(sponsor) { %>
										<li class="card-data-info separator">
											<div class="organizer-item text-center">
												<ul>
													<li>
														<% if (!_.isUndefined(sponsor.url_patrocinador) && !_.isNull(sponsor.url_patrocinador) && sponsor.url_patrocinador.length) { %>
															<a href="<%- sponsor.url_patrocinador %>" title="<%- sponsor.nombre_patrocinador %>" target="_blank">
																<img src="<%- sponsor.imagen_patrocinador %>" alt="<%- sponsor.nombre_patrocinador %>">
															</a>
														<% }else{ %>
															<img src="<%- sponsor.imagen_patrocinador %>" alt="<%- sponsor.nombre_patrocinador %>" title="<%- sponsor.nombre_patrocinador %>">
														<% } %>
													</li>
												</ul>

											</div>
										</li>
									<% }); %>
								<% }else{ %>
									<li>
										<h5 class="title-panel lighter-header clean-bottom text-md gray-base-text text-center">
											No hay organizadores.
										</h5>
									</li>
								<% } %>
							</ul>
						</div>
					</div>
				</div>

				<div class="mobile-12 tablet-4 columns">
					<div class="panel-info radius-tablet-up with-title event-participants">
						<h6 class="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
							<span class="left">Últimos inscritos</span>
							<i class="mdi mdi-account-multiple mdi-18 gray-light vcenter"></i>
						</h6>

						<div id="event-participants-wrap">
							@include('public.noresults', ['message' => 'No hay inscritos.'])
							<ul id="event-participants-list" class="no-bullet">
								{{-- Render template id="inscribed-event-tpl" --}}
							</ul>
						</div>
						<div class="panel-action">
							<a class="text-sm all-participants" href="">Ver todos los participantes</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="inscribed-event-tpl">
		<div class="pending-friendship-item">
			<div class="row valign-middle">
				<div class="small-12 columns">
					<ul class="inline-list-grid card-data-item align-center no-bullet">
						<li class="has-image">
							<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="rounded-thumb no-outline">
								<img class="rounded-img size35" src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt=""  />
							</a>
						</li>

						<li>
							<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="name-user text-sm">
								<%- nombre_usuario %>
							</a>
							<p class="light-text text-xsm">
								<span><%- nombre_nivel_educacion %></span>
							</p>
						</li>

						<li>
							<ul id="buttons-contact-pending-friendship" class="align-top no-bullet card-options-button">
								<li class="tablet-text-right">
									<a class="action-friendship network-user">
										<i class="mdi mdi-plus mdi-21 vcenter icon-circle item-label"></i>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</script>

	{{-- template edit event title --}}
	<script type="text/template" id="participate-event-tpl">
	@if (isset($event) && $event->registro_interes_evento)

		@if (isset(Auth::user()->codigo_usuario))
			<a href="" id="button-participate-event" target="_blank" class="button xsmall sky-blue radius btn-resetc btn-bold btn-clean-margin waves-effect waves-light right">{{ transtp('event.button.participate') }}</a>
		@else
			<a href="" target="_blank" class="button xsmall sky-blue radius btn-resetc btn-bold btn-clean-margin waves-effect waves-light right" data-reveal-id="modal-login">{{ transtp('event.button.participate') }} </a>
		@endif
	@endif
	</script>

	{{-- template edit event title --}}
	<script type="text/template" id="registered-event-tpl">
		<a href="" id="button-stop-participating-event" target="_blank" class="is-hovered button tiny inst-secondary-outline radius btn-clean-margin">
			<i class="mdi mdi-close icon-btn"></i>{{ transtp('event.button.stopparticipating') }}</a>
	</script>

	{{-- template edit event title --}}
	<script type="text/template" id="event-title-tpl">
		<h2 class="event-title">
			<span class="field-text black-text"><%- nombre_evento %></span>
			<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="infobasic"><i class="mdi mdi-pencil"></i></button>
		</h2>
	</script>

	{{-- template form edit event title--}}
	<script type="text/template" id="edit-event-title-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-event-title') ) !!}
		<div class="row">
			<div class="small-12 columns input-field">
				<input type="text" name="nombre_evento" id="nombre_evento" value="<%- nombre_evento %>" placeholder="" required class="validate">
				<label for="nombre_evento" data-error="El campo esta vacío">Título</label>
			</div>
		</div>
		<div class="row">
			<div class="columns mobile-4 mobile-offset-8 tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
		{!! Form::close() !!}
	</script>

	{{-- template edit event city --}}
	<script type="text/template" id="event-city-tpl">
		<span><%- nombre_ciudad %>
			<span><%- window.moment(fecha_evento).format('YYYY') %></span>
			<button class="edit-field-button edit-field" data-dropdown="event-city-container" aria-controls="event-city-container" data-options="align:right" aria-expanded="false" data-edit-template="infocity"><i class="mdi mdi-pencil"></i></button>
		</span>
	</script>

	<script type="text/template" id="edit-event-city-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-event-city') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<select name="codigo_ciudad" class="browser-default choice-select" required data-placeholder="Seleccione una ubicación" placeholder="Seleccione una ubicación">
						<option value=""></option>
						@foreach( App\Ciudad::getCities() as $city)
							<option value="{{ $city->key }}" <%- codigo_ciudad == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
						@endforeach
					</select>
					<label>Ciudad:</label>
				</div>
			</div>

			<div class="row">
				<div class="small-6 columns">
					<label for="fecha_evento">Fecha Inicio</label>
					<input type="text" name="fecha_evento" id="fecha_evento" value="<%- moment(start).format('YYYY-MM-DD HH:mm') %>" class="datetimepk" required>
				</div>
				<div class="small-6 columns">
					<label for="fecha_fin_evento">Fecha Fin</label>
					<input type="text" name="fecha_fin_evento" id="fecha_fin_evento" value="<%- moment(end).format('YYYY-MM-DD HH:mm') %>" class="datetimepk" required>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns">
					<label for="lugar_evento">Lugar del evento</label>
					<input type="text" name="lugar_evento" id="lugar_evento" value="<%- lugar_evento %>" required>
				</div>
			</div>

			<div class="row">
				<div class="columns tablet-4 tablet-offset-8">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- template edit event date --}}
	<script type="text/template" id="event-date-tpl">
		<i class="mdi mdi-16 mdi-calendar vcenter gray-light gutter-right"></i>
		<span class="even-date"><%- window.moment(fecha_evento).format("ddd DD [{{ Lang::get('app.of') }}] MMMM") %>
			<% if( window.moment(fecha_fin_evento).isValid() && window.moment(fecha_fin_evento).isAfter(fecha_evento) ) { %>
				- <%- window.moment(fecha_fin_evento).format("ddd DD [{{ Lang::get('app.of') }}] MMMM") %>
				<% } %>
		</span>
	</script>

	{{-- Info Description event template --}}
	<script type="text/template" id="info-description-event-tpl">
		<div id="" class="editable-item clearfix">
			<h4 class="title-panel text-left">
				<ul class="inline-list-grid align-top no-bullet">
					<li class="field-text black-text">Detalles</li>
					<li class="has-image">
						<button class="edit-field-button edit-field right" data-edit-template="infodescription">
							<i class="mdi mdi-pencil"></i>
						</button>
					</li>
				</ul>
			</h4>
		</div>

		<div class="content-description-event <% owner ? 'field-for-edit edit-field' : ''%> clearfix wrap-text" data-edit-template="infodescription">
			<div class="prepared-to-edit"><%= window.Misc.stripTags(descripcion_evento) ? descripcion_evento : '' %><%= !window.Misc.stripTags(descripcion_evento) && owner ? '<span class="edit-no-result text-dmd">Agrega un contenido</span>' : '' %></div>
		</div>
		<div class="field-editing">
			{{-- Render template edit form--}}
		</div>
	</script>

	<script type="text/template" id="edit-event-description-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-description-event') ) !!}
			<div class="row">
				<div class="mobile-12 columns">
					<div id="edit-description-event">
						{{-- Render editor react --}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="mobile-12 tablet-5 tablet-offset-7 columns">
					<ul class="inline-list-grid">
						<li><button class="button tiny expand white radius close-editing">Cancelar</button></li>
						<li>{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue radius')) !!}</li>
					</ul>
				</div>
			</div>
		{!! Form::close() !!}
	</script>


@stop
