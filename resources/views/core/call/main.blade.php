@extends('core.call.call')

@section('call.content')
	{{-- ------------------ Programs Templates JS -------------------- --}}
	{{-- template menu aside filter --}}

	<script type="text/template" id="programs-menu">

			<div id="program-menu-nav" class="wrapper-module-menu-section show-for-large-up">
				<div class="row">
					<div class="small-12 columns">
						<ul id="programs-tabs-navs" class="tabs-sub-nav-alt tabs tabs-route text-left" data-tab data-tab-init="is_hover:false">
							<li class="tab-title">

								<a class="linkto-inst-color" id="onBack"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter"></i> volver</a>

							</li>
						</ul>
					</div>
				</div>
			</div>
			<br>
			<!-- module responsive navigation -->
			<div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up">
				<div class="row collapse">
					<div class="small-12 columns">
						<dl class="sub-nav">
							<button id="onBack" class="button left"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter"></i> volver</button>

						</dl>


					</div>
				</div>
			</div>

	</script>




	<script type="text/template" id="programs-sidemenu-filter-tpl">
		<a href="#" class="hide-fx-left-btn on">
			<span class="title-side-nav text-sm">Filtrar convocatorias</span>
			<i class="side-nav-arrow"></i>
		</a>
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-programs'))  !!}
			<ul class="side-nav-slide">
				<li class="divider"></li>
				<li>
					<input type="radio" name="type" id="type-all" value="" class="check-filter with-gap"  <%- type == '' ? 'checked' : '' %>>
					<label for="type-all">{{ Lang::choice('app.all', 0) }}</label>
				</li>
				<li>
					<input type="radio" name="type" id="type-internal" value="1" class="check-filter with-gap" <%- type == '1' ? 'checked' : '' %> >
					<label for="type-internal">{{ Lang::choice('app.internal', 0) }}</label>
				</li>
				<li>
					<input type="radio" name="type" id="type-external" value="2" class="check-filter with-gap" <%- type == '2' ? 'checked' : '' %> >
					<label for="type-external">{{ Lang::choice('app.external', 0) }}</label>
				</li>

				<li><span class="title-side-nav text-sm">Filtrar por Categoria</span></li>
				<li>
					<input type="radio" name="category" id="category-all" value="" class="check-filter with-gap" <%- category == '' ? 'checked' : '' %> >
					<label for="category-all">Todos</label>
				</li>
				@foreach( App\CategoriaProcesoInstitucion::getCategoriesProcess() as $value)
					<li>
						<input type="radio" name="category" id="category-{{ $value->codigo_categoria_proceso }}" value="{{ $value->codigo_categoria_proceso }}" class="check-filter with-gap" <%- category == '{{ $value->codigo_categoria_proceso }}' ? 'checked' : '' %> >
						<label for="category-{{ $value->codigo_categoria_proceso }}">{{ $value->nombre_categoria_proceso }}</label>
					</li>
				@endforeach
			</ul>
		{!! Form::close() !!}
	</script>
	{{-- countdown template --}}
	<script type="text/template" id="countdown-program-detail-tpl">
		<ul class="format-countdown inline-list-items">
			<li>
				<span class="bold-text digit-date"><%- window.moment.duration(countdown.asDays(), 'days').format('DD') %></span>
				<span class="text-lg light-text gray-light-text">d</span>
			</li>
			<li class="vdivider"></li>
			<li>
				<span class="bold-text digit-date"><%- window.moment.duration(countdown.hours(), 'hours').format('hh') %></span>
				<span class="text-lg light-text gray-light-text">h</span>
			</li>
			<li class="vdivider"></li>
			<li>
				<span class="bold-text digit-date"><%- window.moment.duration(countdown.minutes(), 'minutes').format('mm') %></span>
				<span class="text-lg light-text gray-light-text">m</span>
			</li>
			<li class="vdivider"></li>
			<li>
				<span class="bold-text digit-date"><%- window.moment.duration(countdown.seconds(), 'seconds').format('ss') %></span>
				<span class="text-lg light-text gray-light-text">s</span>
			</li>
		</ul>
	</script>
	{{-- program detail --}}
		<script type="text/template" id="call-detail-tpl">

		<div id="content-program-detail">

			<div class="top-program-detail">
				<div class="row">
					<div class="small-12 columns">
						<div id="">
							{{-- <% if( !this.model.get('permanente_convocatoria') ) { %> --}}
							{{-- 	<div class="countdown-program-closing show-for-tablet-up"> --}}
									{{-- Render coundown --}}
							{{-- 	</div> --}}
						{{-- 	<% }%> --}}
							<div class="row collapse col-equal-height">
                           		 <% if( this.model.get('texto_alerta_convocaotoria') ) { %>
								<div class="tablet-12 mobile-12 columns" id="anounciement-calls">
									<h5 class="text-center">¡ANUNCIO IMPORTANTE!</h5>
									<%= this.model.get('texto_alerta_convocaotoria')  %>
								</div>
								<% }%>
								<div class="small-12 tablet-6 columns">
									<figure class="program-main-image">
										<img src="<%= imagen_convocatoria %>" alt="<%= nombre_convocatoria %>" title="<%= nombre_convocatoria %>" />
									</figure>
								</div>
								<div class="small-12 tablet-6 columns">
									<div class="mask-program-header">
										<h4 class="dark-text text-h-lg"><%- nombre_convocatoria %></h4>
										<p class="lighter-text gray-dark-text text-md"><%- resumen_convocatoria %></p>
										<ul class="inline-list-grid align-center state-program-info">
											<% if( opened && codigo_estado_institucion != 9 ) { %>
												<% if( opened && codigo_estado_institucion != 9 ) { %>
													<li class="has-image">
														<i class="mdi mdi-bullhorn vcenter mdi-24 success-text"></i>
													</li>
													<li class="no-warp">
														<label class="label single dark-text text-ms bold-text">{!!  transtp('programs.open') !!}  </label>
														{{-- <p class="clean-bottom text-sm gray-base-text">Esta convocatoria se cierra en:</p> --}}
													</li>
												<% }else{ %>
													<li class="has-image">
														<i class="mdi mdi-block-helper mdi-18"></i>
													</li>
													<li class="no-warp">
														<label class="label single dark-text text-sm bold-text">{{  transtp('programs.closed') }}</label>
														<p class="clean-bottom text-sm gray-base-text">{{transtp('programs.closedmessage')}}</p>
													</li>
												<% } %>
											<% }else{ %>
												<li class="has-image">
													<i class="mdi mdi-block-helper mdi-18"></i>
												</li>
												<li class="no-warp">
													<p class="clean-bottom text-sm gray-base-text">La convocatoria se encuentra Inactiva</p>
												</li>
											<% } %>
										</ul>
										<% if( typeof(etapas) !== 'undefined' && etapas ){ %>
										<label class="label single dark-text text-ms bold-text"> Fase(s): <span class="lighter-text gray-dark-text text-md"><%- etapas %></span></label>
										<br>
										<% } %>
										<% if( typeof(categorias) !== 'undefined' && categorias ){ %>
										<label class="label single dark-text text-ms bold-text"> Categoria(s):  <span class="lighter-text gray-dark-text text-md"><%- categorias %></span></label>
										<br>
										<% } %>
										<%if(permanente_convocatoria != true && fecha_cierre_convocatoria != null && hora_cierre_convocatoria != null && codigo_estado_institucion == 8){%>
											<%console.log(codigo_estado)%>
											<%if(mensaje_tiempo_restante){ %>
											<label class="label single text-ms bold-text success-text">Abierto: <span class="lighter-text gray-dark-text text-md"><%- formatoDias%> ( <%- mensaje_tiempo_restante %>)</span></label>
											<%}else{%>
												<%if(codigo_estado != 8){ %>
													<label class='label single text-ms bold-text alert-text'>Programa cerrado</label>
												<% } %>
											<% } %>
										<%}%>
										<br><br>
										<% if( nombre_organizador ) { %>
											<ul class="inline-list-grid list-small-thumb-item program-organizer-list">
												<li class="has-image">
													<a class="mask-thumb">
														<img src="<%- imagen_organizador %>" />
													</a>
												</li>
												<li>
													<span clas="light-text">Organizado por</span>
													<a  href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':url_organizador}) )  %>" class="organizer"><h6><%- nombre_organizador %></h6></a>
												</li>
											</ul>
                                        <% } %>
										<div class="program-info-detail">
											<div class="row collapse col-equal-height valign-bottom">
												<div class="mobile-6 medium-5 columns">
													<% if(codigo_estado_institucion != 9) { %>
														<% if(opened) { %>
															<% if(registered) { %>
																<span class="text-sm lighter-text gray-base-text">{{ transtp('programs.registered') }}</span>
															<% }else{ %>
																<a href="<%- tipo_convocatoria === window._tp.typeProgram.external ? url_externa_convocatoria : window.Misc.urlFull(Route.route('convocatoria.aplicar', {'convocatoria': url_convocatoria, 'step': 'terminos'})) %>" class="button sky-blue medium expand radius btn-clean-margin" target="<%- tipo_convocatoria === window._tp.typeProgram.external ? '_blank' : '' %>" ><%- texto_boton %></a>
															<% } %>
														<% }else{ %>
															<span class="text-sm lighter-text gray-base-text">{{transtp('programs.notallowedmessage')}}</span>
														<% } %>
													<% } %>

												</div>
												<div class="mobile-6 medium-4 columns">
													<div class="btn-participants-program no-bullet">
														<span class="count-participants bold-text gray-light-text"><%- contador_inscritos %></span>
														<a href="#" class="show-participants-program" title="Participantes"><span class="text-participants text-sm thin-text inst-color-secondary">Participantes Inscritos</span></a>
													</div>
												</div>
												<div class="mobile-12 medium-3 columns">
													<ul class="mobile-text-left medium-text-right program-icons-shared social-box-icons">
														<li>
															<ul id="drop-shared-social-program" class="drop-shared-social-program friendship-dropdown no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
																<li class="text-center">
																	<label class="label single gray-base-text">Compartir en redes:</label>
																	<ul class="inline-list-grid align-top">
																		<li class="text-center">
																			<a href="http://www.facebook.com/share.php?u=<%- window.Misc.urlFull( Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria}) ) %>&title=<%- nombre_convocatoria %>" title="Compartir en facebook" class="tp_facebook_share">
																				<i class="mdi mdi-facebook mdi-21 facebook"></i>
																			</a>
																		</li>
																		<li class="text-center">
																			<a href="http://www.linkedin.com/shareArticle?mini=true&url=<%= window.Misc.urlFull( Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria}) ) %>&title=<%- nombre_convocatoria %>&source=DOMAIN" title="Compartir en linkedin" class="tp_linkedin_share">
																				<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
																			</a>
																		</li>
																		<li class="text-center">
																			<a href="http://twitter.com/intent/tweet?status=<%- nombre_convocatoria %>+<%- window.Misc.urlFull( Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria}) ) %>" title="Compartir en X" class="">
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
																		<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
																</li>
															</ul>
															<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-program" aria-controls="drop-liked-program" data-options="align:top;is_hover:true;hover_timeout:500">
																<i class="mdi mdi-thumb-up-outline mdi-21"></i>
																<span class="data-count-likes text-xmd"><%- contador_like %></span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="content-stages-call" class="program-schedule">
					<div class="row">
						<div class="small-11 small-centered columns">
		                    <ul class="list-program-stages tabs slick-tabs-programs" data-tab data-indicators="true" data-slick='{"slidesToShow":<%- fases.length <= 5 ? fases.length : 5 %>}' >
		                        <% _.each(fases, function(fase, index) { %>
		                            <li class="tab-title tab-program-stage" style="width: <%- 100 / fases.length %>%">
		                            	<a href="#tab-stage-<%- index %>" aria-controls="tab-stage-<%- index %>">
											<%
											var diffStage = window.moment(fase.fecha_fin_fase).diff(window.moment(), 'days'),
												diffStagePrev = window.moment( (fases[index-1] ? fases[index-1].fecha_fin_fase : new Date()) ).diff(window.moment(), 'days'),
												diffStageNext = window.moment( (fases[index+1] ? fases[index+1].fecha_fin_fase : new Date()) ).diff(window.moment(), 'days');
											%>
			                                <div class="item-program-stage <%- permanente_convocatoria ? 'finalized' : ( ( diffStagePrev <= 0 && diffStageNext >= 0 && diffStage > 0) ? 'current' : (diffStage <= 0 ? 'finalized' : '') ) %> ">
			                                    <div class="progress progress-stage">
			                                    	<span class="meter meter-progress-stage"></span>
			                                    </div>
			                                    <label class="label single text-lg"><%- fase.nombre_fase %></label>
			                                    <div class="date-program wrap-text">
				                                    <% if(!permanente_convocatoria) { %>
				                                    	Cierra el <%- window.moment(fase.fecha_fin_fase, "YYYY-MM-DD").format('D [de] MMMM') %><br><span><%- window.moment(fase.fecha_fin_fase, "YYYY-MM-DD").format('YYYY') %></span>
				                                	<% }else{ %>
			                                    		<%- fase.resumen_fase %>
				                                	<% } %>
			                                	</div>
			                                </div>
		                            	</a>
		                            </li>
		                        <% }); %>
		                    </ul>
						</div>
					</div>
					<div class="program-schedule-contents tabs-content">
						<% _.each(fases, function(fase, index) { %>
							<%
							var diffStage = window.moment(fase.fecha_fin_fase).diff(window.moment(), 'days'),
								diffStagePrev = window.moment( (fases[index-1] ? fases[index-1].fecha_fin_fase : new Date()) ).diff(window.moment(), 'days'),
								diffStageNext = window.moment( (fases[index+1] ? fases[index+1].fecha_fin_fase : new Date()) ).diff(window.moment(), 'days');
							%>

							<div class="panel-detail content" id="tab-stage-<%- index %>">
	                            <div class="row">
		                            <div class="small-12 columns">
										<div id="call-submenu-program-schedule" class="clearfix">
											<ul id="call-tabs-filter" class="tabs-sub-nav tabs tabs-route inline-list-items" data-tab>
												<li class="tab-title active">
													<a href="#content-description-call" title="" class="linkto-inst-color">Descripción</a>
												</li>
												<% if( fase.resources.length ) { %>
                                                 	<li class="tab-title">
														<a href="#content-resources-call-<%-index+1%>" title="" class="linkto-inst-color">Recursos</a>
													</li>
                                                <% } %>

											</ul>
										</div>
		                            </div>
	                            </div>

								<div class="tabs-content">
                                    <div class="content active" id="content-description-call">
                                        <div class="row">
                                            <div class="tablet-12 columns">
                                                <h4 class="thin-header dark-text">
                                                    <% if(!permanente_convocatoria) { %>
                                                        <% if( diffStagePrev <= 0 && diffStageNext >= 0 && diffStage > 0 ) { %>
                                                            <span class="gray-light-text text-lg">(etapa actual)</span>
                                                        <% } %>
                                                        <span class="dark-text">&minus;</span>
                                                        <span><%- window.moment(fase.fecha_inicio_fase, 'YYYY-MM-DD').format('LL') %> a <%- window.moment(fase.fecha_fin_fase, 'YYYY-MM-DD').format('LL') %></span>
                                                    <% } %>
                                                </h4>
                                                <div class="scroll-general-v">
                                                    <div class="text-md description-stage"><%= fase.descripcion_fase %></div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									<div class="content" id="content-resources-call-<%-index+1%>">
										<div class="row">
											<div class="small-3 columns">
												<ul id="program-phase-resources-menu-list" class="tabs vertical" data-tab>
													<% _.each(fase.resources, function(resource, indexResource) { %>
														<li class="tab-title <%- indexResource === 0 ? 'active' : '' %>">
														<a href="#panel-<%-indexResource +1%>">
															<ul class="inline-list-grid align-top">
																<li class="has-image">
																	<i class="mdi mdi-bullhorn mdi-16 vcenter gutter-right resources-icon"></i>
																</li>
																<li>
																	<%- resource.nombre_adjunto%>
																</li>
															</ul>
														</a>
													</li>
													<% }); %>
												</ul>
											</div>
											<div class="small-9 columns">
												<div class="program-phase-resources-content tabs-content">

													<% _.each(fase.resources, function(resource, indexResource) { %>

														<div class="content <%- indexResource === 0 ? 'active' : ''%>" id="panel-<%-indexResource +1%>">
															<ul class="inline-list-grid list-small-thumb-item">
																<li class="has-image">
																	<i class="<%- resource.icono_tipo_recurso_fase ? resource.icono_tipo_recurso_fase : 'mdi mdi-link-variant' %> circle-outline mdi-21 vcenter gutter-right resources-icon"></i>
																</li>
																<li>
																	<span clas="light-text">Recurso tipo</span>
																	<h6 class="organizer black-text"><%- resource.nombre_tipo_recurso_fase ? resource.nombre_tipo_recurso_fase : 'Link'%></h6>
																</li>
															</ul>
															<hr>
															<p><%- resource.descripcion_adjunto_fase  %></p>
																<a href="<%- resource.direccion_adjunto %>" target="_blank"><%- resource.nombre_adjunto%></a>
															<hr>

															{!! Form::open(['url'=>route('convocatoria.fase.adjunto.store'), 'method'=>'POST', 'class'=>'phase-resource-finalize-form'
															]) !!}
															<% if(resource.recurso_fase_completada ) { %>
															<button class="button small radius btn-lowerc" type="button" disabled><i class="mdi mdi-check gutter-right mdi-16"></i>Has finalizado esta fase</button><br>
															<small>* Has finalizado esta fase</small>
															<% }else { %>
																<input type="hidden" name='codigo_adjunto_fase' value="<%- resource.codigo_adjunto_fase %>">
																<button class="button small inst-secondary-outline is-hovered radius btn-lowerc phase-resource-finalize-btn" type="submit"><i class="mdi mdi-crop-square gutter-right mdi-16"></i>Marcar esta fase como finalizada</button><br>
															<% } %>
															{!! Form::close() !!}


														</div>
													<% }); %>

												</div> <!--end tabs-content-->
											</div> <!--end columns-->
										</div> <!--end row-->

                                	</div> <!--end content resources call-->

								</div>
								<a href="#" class="close content-close"><i class="mdi mdi-close-box sky-blue"></i></a>
							</div>
						<% }); %>
					</div>
				</div>
			</div>

			{{-- submenu navigation program --}}
			<div id="call-submenu-nav">
				<div class="row">
					<div class="small-12 columns">
						<div id="call-submenu-tabs" class="clearfix">
							<ul id="call-tabs-filter" class="tabs-sub-nav tabs tabs-route inline-list-items text-center" data-tab>
								<li class="tab-title active">
									<a href="#content-description-call" title="{{ transtp('programs.description') }}" class="linkto-inst-color">{{ transtp('programs.description') }}</a>
								</li>
								<li class="tab-title">
									<a href="#content-discussion-call" title="{{ transtp('programs.discussions') }}" class="linkto-inst-color">{{ transtp('programs.discussions') }}</a>
								</li>
								<% if (!_.isUndefined(terminos_convocatoria) && !_.isNull(terminos_convocatoria)) { %>
									<li class="tab-title">
										<a href="#content-terms-call" title="{{ transtp('programs.terms') }}" class="linkto-inst-color">{{ transtp('programs.terms') }}</a>
									</li>
								<% } %>
								<% if (!_.isUndefined(politicas_convocatoria) && !_.isNull(politicas_convocatoria)) { %>
									<li class="tab-title">
										<a href="#content-policies-call" title="Términos" class="linkto-inst-color">Políticas</a>
									</li>
								<% } %>

								<% if(documentos.length) { %>
									<li class="tab-title">
										<a href="#content-documents-call" title="{{ transtp('programs.attached') }}" class="linkto-inst-color">{{ transtp('programs.attached') }}</a>
									</li>
								<% } %>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="main-program-detail">
				<div class="row">
					<div class="small-12 columns">
						<div class="tabs-content">

							<div class="content active" id="content-description-call">
								<div class="panel-content radius with-title">
									<h6 class="title-panel">
										<span class="icon-title icon-circle gray-light medium icon-24 vcenter"><i class="mdi mdi-book"></i></span>
										{{ transtp('programs.descriptionprogram') }}
									</h6>
									<div class="call-content-inner"><%= descripcion_convocatoria %></div>
								</div>
							</div>
							<div class="content" id="content-discussion-call">
								<div class="row">
									<div class="small-12 tablet-6 columns">
										<div class="panel-content radius with-title">
											<div id="user-basic-container" class="editable-item clearfix">
												<h6 class="title-panel text-left">
													<span class="icon-title icon-circle gray-light medium icon-24 vcenter"><i class="mdi mdi-help"></i></span>
													Preguntas frecuentes (FAQs)
												</h6>

												<div id="faq-programs" class="call-content-inner">
													@include('public.noresults', ['message' => 'No hay preguntas frecuentes'])
													<ul id="program-faq-wrap" class="list-separator list-ordering light-text no-bullet">
														{{-- Render Attachments template --}}
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="small-12 tablet-6 columns">
										<div id="wrapper-program-discussion" class="panel-content radius">
											@if(Auth::check())
												{!! Form::open(['action' => null, 'data-abide' => '', 'id' => 'form-discussion-program']) !!}
													<div class="textarea-post-discussion clearfix input-field">
														<textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" cols="50" rows="2" pattern="max_char_textarea" class="materialize-textarea validate"></textarea>
														<label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
														<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
													</div>
													<input type="hidden" name="codigo_convocatoria" value="<%= codigo_convocatoria %>" />
												{!! Form::close() !!}
											@endif
											@include('public.noresults', ['message' => 'No hay discusiones'])
											<section id="discussion-posts-wrap" class="">
												{{-- Render Tasks template --}}
											</section>
										</div>
									</div>
								</div>
							</div>
							<% if (!_.isUndefined(terminos_convocatoria) && !_.isNull(terminos_convocatoria)) { %>
								<div class="content" id="content-terms-call">
									<div class="panel-content radius with-title">
										<h6 class="title-panel">
											<span class="icon-title icon-circle gray-light medium icon-24 vcenter"><i class="mdi mdi-book"></i></span>
											{{  transtp('programs.termsprogram') }}
										</h6>
										<div class="call-content-inner"><%= terminos_convocatoria %></div>
									</div>
								</div>
							<% }%>
							<% if (!_.isUndefined(politicas_convocatoria) && !_.isNull(politicas_convocatoria)) { %>
								<div class="content" id="content-policies-call">
									<div class="panel-content radius with-title">
										<h6 class="title-panel">
											<span class="icon-title icon-circle gray-light medium icon-24 vcenter"><i class="mdi mdi-book"></i></span>
											Políticas de la convocatoria
										</h6>
										<div class="call-content-inner"><%= politicas_convocatoria %></div>
									</div>
								</div>
							<% }%>
							<% if(documentos.length) { %>
								<div class="content" id="content-documents-call">
									<div class="panel-content radius with-title">
										<h6 class="title-panel" class="title-course-main bold-header h-hollow-bottom">
											<span class="icon-title icon-circle gray-light medium icon-24 vcenter"><i class="mdi mdi-file-multiple"></i></span>
											{{ transtp('programs.attached') }}
										</h6>
										<ul class="list-content-tabs">
											<% _.each(documentos, function(documento) { %>
												<li>
													<div class="item-content-tabs">
														<a href="<%- documento.direccion_adjunto %>" title="<%- documento.nombre_adjunto %>" target="_blank">
															<%- documento.nombre_adjunto %>
														</a>
													</div>
												</li>
											<% }); %>
										</ul>
									</div>
								</div>
							<% } %>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	{{-- template call list --}}
	<script type="text/template" id="list-call-tpl">
		<div id="content-browse-programs">
            <div class="banner-section">
                <figure class="header-section text-center">
                    <i class="mdi mdi-bullhorn circle-outline mdi-24 icon-btn"></i>
                    <h2>{{transtp('programs.title')}}</h2>
                    <p>{{transtp('programs.subheader')}}</p>
                </figure>
            </div>
			<div class="row">
				<div class="small-12 tablet-12 medium-3 columns">
					{!! Form::open(array('route' => null, 'id' => 'form-calls-filter')) !!}
						<div class="menu-filter-panel">
							<h6 class="title-panel clean-bottom black-text text-md">
								<i class="mdi mdi-tune mdi-24 gray-light vcenter gutter-right"></i>Filtros
							</h6>
							<div class="section-call-filter">
								<div class="">
									{!! Form::select("categories",['' => ''] + App\CategoriaProceso::getCategories(),null, ['class'=>'browser-default choice-select-deselect choice-filter-call', 'id'=>'filter-calls-categoy', 'data-placeholder' => 'Categorías'] )!!}
								</div>
								<div class="">
									{!! Form::select("stages",['' => ''] + App\EtapaProyecto::getStagesList(),null, ['class'=>'browser-default choice-select-deselect choice-filter-calls', 'id'=>'filter-calls-stage', 'data-placeholder' => 'Etapa'] )!!}
								</div>
								<div class="">
									{!! Form::select("entity",['' => ''] + App\Entidad::getNameOfEntities(),null, ['class'=>'browser-default choice-select-deselect choice-filter-calls', 'id'=>'filter-calls-entity', 'data-placeholder' => 'Entidad'] )!!}
								</div>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
				<div class="tablet-12 medium-9 columns">
					<div class="content-data-list">
						@include('public.noresults', ['message' => 'No hay ningún resultado'])
						<ul id="browse-list-call" class="mobile-block-grid-1 mobile-block-grid-1 small-block-grid-2 tablet-block-grid-2 medium-block-grid-3 xxlarge-block-grid-3 browse-list-mask browse-list-programs responsive-browse">
							<!-- Render call list -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</script>
	{{-- template item call list --}}
	<script type="text/template" id="item-call-list-tpl">
		<div class="list-item-wrap">


					<div class="top-item-list no-border">
						<a href="<%- tipo_convocatoria === window._tp.typeProgram.external ? url_externa_convocatoria : window.Misc.urlFull(Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria})) %>" title="<%- nombre_convocatoria %>" target="<%- tipo_convocatoria === window._tp.typeProgram.external ? '_blank' : '' %>" class="item-thumb">
							<img src="<%- imagen_convocatoria %>" alt="<%- nombre_convocatoria %>" />
						</a>
					</div>
					<div class="text-left content-item-list">

                        <ul class="inline-list-grid align-center">

                            <li class="text-left">
							    <h5 class="list-item-title is-hovered ellipsis bold-text black-text text-lg">
								    <a href="<%- window.Misc.urlFull( Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria}) )%>" title="<%- nombre_convocatoria %>" class="dark-text is-hovered" ><%- nombre_convocatoria %></a>
							    </h5>
                            </li>

                            <li class="text-right dots-action-item">

                                <a class="list-dots-action" data-dropdown="drop-call-info-<%- url_convocatoria %>" aria-controls="drop-call-info-<%- url_convocatoria %>" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-21 vcenter icon-circle"></i>
                                </a>


                                <div id="drop-call-info-<%- url_convocatoria %>" data-dropdown-content class="drop-item-content-box no-arrow text-sm show-for-tablet-up" aria-hidden="true" tabindex="-1">

                                    <ul class="inline-list-grid align-top">
                                        <li class="text-left">
                                            <h5 class="is-hovered bold-text black-text">
                                                <a href="<%- tipo_convocatoria === window._tp.typeProgram.external ? url_externa_convocatoria : window.Misc.urlFull(Route.route( 'convocatoria.convocatoria', {convocatoria: url_convocatoria})) %>" title="<%- nombre_convocatoria %>" class="is-hovered text-md" ><%- nombre_convocatoria %></a>
                                            </h5>
                                        </li>
                                        <li class="text-right">
                                            <a><i class="mdi mdi-close mdi-18 vcenter light-text"></i></a>
                                        </li>
                                    </ul>

                                    <div class="text-left">
                                        <a href="#" class="show-participants-program-list text-xmd gray-base-text is-hovered" title="Participantes">
                                            <%- contador_inscritos %> participantes
                                        </a>
                                        <p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- resumen_convocatoria %></p>
                                    </div>

                                    <div class="bottom-item-list">
                                        <p>A <a href="#" class="show-user-likes text-xmd"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</p>
                                    </div>
                                </div>
                            </li>

                        </ul>

                        <p class="text-sm black-text ellipsis">
                            <% if(typeof(nombre_organizador) !== 'undefined' && nombre_organizador){ %>
                                <span><%- nombre_organizador  %></span>
                            <% } %>
                        </p>


						<% if(typeof(categorias) !== 'undefined' && categorias){ %>
							<p class="text-sm light-text">
								<span class="dark-text">Categoría(s): </span>
                                <% _.each(categorias.split(','), function (categoria, index) { %>
                                    <% if((index + 1) < categorias.split(',').length ) %>
                                        <span><%- categoria %>, </span>
                                    <% else{ %>
                                        <span><%- categoria %> </span>
                                    <% } %>
                                <% }) %>
                       		 </p>
						<% } %>


					<% if(typeof(etapas) !== 'undefined' && etapas){ %>
                        <p class="text-sm light-text">
                            <span class="dark-text">Fase(s): </span>
							<% _.each(etapas.split(','), function (etapa, index) { %>
								<% if((index + 1) < etapas.split(',').length ) %>
									<span><%- etapa %>, </span>
								<% else{ %>
									<span><%- etapa %> </span>
								<% } %>
							<% }) %>
						</p>
					<% } %>
						<% if( codigo_estado_institucion != 9 ) { %>
							<% if( opened ) { %>
								<p class="text-sm light-text">
									<b class="success-text bold-text">Abierta</b>
									<% if(!permanente_convocatoria && fecha_cierre_convocatoria != null && hora_cierre_convocatoria != null) { %>
										hasta el
										<span class="dark-text thin-text">
											<%- window.moment([fecha_cierre_registro].join(' '), "YYYY-MM-DD").format("D [{{ Lang::get('app.of') }}] MMMM, YYYY") %>
											<span class="text-sm light-text"> (<%- mensaje_tiempo_restante%>) </span>
										</span>
									<% } %>
									<a href="<%- tipo_convocatoria === window._tp.typeProgram.external ? url_externa_convocatoria : window.Misc.urlFull(Route.route('convocatoria.aplicar', {'convocatoria': url_convocatoria, 'step': 'terminos'})) %>" target="<%- tipo_convocatoria === window._tp.typeProgram.external ? '_blank' : '' %>"  class="participate-action upper-text bold-text text-lg">Participar</a>
								</p>
								<% }else{ %>
								<p class="text-sm light-text">
									<span class="thin-text alert-text"></i> {{transtp('programs.closed')}}</span>
								</p>
							<% } %>
						<% } %>



					</div>


		</div>
	</script>


	{{-- Item Faq program list --}}
	<script type="text/template" id="program-faq-list-tpl">
		<span class="dark-text bold-text text-md">
			<%- texto_preguntas_frecuentes %>
		</span>
		</br>
		<span class="light-text text-sm">
			<%= respuesta_preguntas_frecuentes %>
		</span>
		</br></br>
	</script>

	{{-- phase resource completed action --}}
	<script type="text/template" id="phase-resource-completed-tpl">

	</script>

	{{-- Template for Participants --}}
	<script type="text/template" id="participant-program-item-tpl">
		<div class="row collapse info-user-likes">
			<div class="small-9 columns">
				<ul class="inline-list-grid filter-result-user-card align-top no-bullet">
					<li class="has-image">
						<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="post-avatar">
                            <img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" onerror="if (this.src != '{{ config('tuproyecto.avatar_image') }}') this.src = '{{ config('tuproyecto.avatar_image') }}';" class="rounded-img size45"/>
                        </a>
					</li>
					<li>
						<ul class="no-bullet">
							<li>
								<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="name-user text-md">
									<%- nombre_usuario %>
								</a>
							</li>
							<li>
								<span class="light-text text-sm">
									<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
										<span><%- nombre_ciudad %>, <%- nombre_pais %></span>&nbsp;<span class="vertical-separator">&VerticalSeparator;</span>
									<% } %>
									<a href="<%= window.Misc.urlFull( url_profile ) %>" class="dark-text"><%- window.Misc.strToNickname(nickname_usuario) %>
									</a>
								</span>
							</li>
							<li>
								<span class="text-xsm "><%- profesion_usuario %></span>
							<li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="small-3 columns">
				<ul id="buttons-connect-friendship" class="stages-friendship-user right">
					{{-- Render buttoms follows --}}
				</ul>
			</div>
		</div>
	</script>

	@if (Auth::check())
		{{-- Templates apply program --}}
		@include('core.call.apply.templates')
	@endif
@stop
