@extends('core.evaluator.evaluator')

@section('evaluator.content')

	{{-- ------------------ Evaluator Templates JS -------------------- --}}
	{{-- panel filters --}}
	<script type="text/template" id="evaluation-sidemenu-filter-tpl">
		<div class="wrapper-side-nav radius-bottom">

			<a href="#" class="toggle-slide-collapse button-collapse hide-for-tablet-up" data-activates="slide-out">
				<i class="mdi mdi-filter mdi-21 vcenter gray-base"></i>
				<span class="title-side-nav text-sm">Filtrar</span>
			</a>
			<a href="#" class="toggle-slide-drop show-for-tablet-up">
				<i class="mdi mdi-filter mdi-21 vcenter gray-base"></i>
				<span class="title-side-nav text-sm">Filtrar el contenido</span>
			</a>

			<div id="slide-out" class="content-filters-sidemenu">
				{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-evaluation'))  !!}
					<ul class="side-nav-slide">
						<li><label class="title-side-nav text-sm">Filtrar por Estado</label></li>
						<li>
							<input type="radio" name="state" id="state-pending" value="8" class="check-filter with-gap" <%- (state == '8' || state == '') ? 'checked' : '' %> >
							<label for="state-pending">Por evaluar</label>
						</li>
						<li>
							<input type="radio" name="state" id="state-evaluated" value="15" class="check-filter with-gap" <%- state == '15' ? 'checked' : '' %> >
							<label for="state-evaluated">Evaluados</label>
						</li>
						<li>
							<input type="radio" name="state" id="state-returned" value="26" class="check-filter with-gap" <%- state == '26' ? 'checked' : '' %> >
							<label for="state-returned">Devueltos</label>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="text" name="entrepreneurship" id="entrepreneurship" value="<%- entrepreneurship %>" class="keyup-search">
								<label for="entrepreneurship">Emprendimiento</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="number" name="code" id="code" value="<%- code %>" class="keyup-search" min="0">
								<label for="code">Código de aplicación</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="program" id="program" class="browser-default choice-select-deselect change-choice" required data-placeholder="Selecciona una convocatoria" placeholder="Selecciona una convocatoria">
										<option></option>
										@foreach( App\Convocatoria::getProgramList() as $value)
											<option value="{{ $value->key }}" <%- program == '{{ $value->key }}' ? 'selected': ''%>>{{ $value->value}}</option>
										@endforeach
									</select>
									<label>Convocatoria:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="industry" id="industry" class="browser-default choice-select-deselect change-choice" required data-placeholder="Selecciona una industria" placeholder="Selecciona una industria">
										<option></option>
										@foreach( App\CategoriaProyecto::getCategoriesList() as $value)
											<option value="{{ $value->key }}" <%- industry == '{{ $value->key }}' ? 'selected': ''%>>{{ $value->value}}</option>
										@endforeach
									</select>
									<label>Industria:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="mobile-12 small-11 small-centered columns">
									<a href="#" class="clean-filters button xsmall inst-secondary-outline expand radius btn-clean-margin btn-lowerc">Borrar todos los filtros</a>
								</div>
							</div>
						</li>
					</ul>
				{!! Form::close() !!}
			</div>
		</div>
    </script>
	{{-- Base content evaluator --}}
	<script type="text/template" id="evaluation-project-base-tpl">
		<!-- module navigation -->
        <div id="evaluation-menu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
            <div class="row">
                <div class="small-12 columns">
                    <ul id="evaluation-tabs-navs" class="tabs-sub-nav-alt tabs tabs-route text-right">

                    	<li class="tab-title left">
                            <a href="javascript:history.back();" class="tabs-back-button mdi mdi-chevron-left vcenter tab-icon-left button-history-back" title="Volver">Volver</a>
                    	</li>

                        <li class="tab-title <%- section == 'evaluationList' ? 'active' : '' %>">
                            <a href="<%- Route.route('evaluacion.index') %>" title="Inicio" class="linkto-inst-color">Inicio</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- module responsive navigation -->
        <div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
                        <a href="javascript:history.back();" class="button left"><i class="mdi mdi-chevron-left mdi-18 gutter-right vcenter"></i>Volver</a>

                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">Principal<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
                        <ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
                            <li class="<%- section == 'evaluationList' ? 'active' : '' %>">
                                <a href="<%- Route.route('evaluacion.index') %>" title="">Evaluaciones</a>
                            </li>
                        </ul>
                    </dl>
                </div>
            </div>
        </div>

		<div id="evaluation-inner-content">
			{{-- Render templates content --}}
        </div>
	</script>

	{{-- List evaluation projects --}}
	<script type="text/template" id="evaluation-project-list-tpl">

		<div class="row mobile-collapse tablet-uncollapse">
			<div class="small-12 columns">

				<div class="fx-main-content">

					<div class="fx-col-left">
						<div id="wrapper-filter-bar" class="sticky-filter-top">
							<div id="side-menu-filter" class="filter-side-nav-left">
								{{-- Render side menu filter --}}
							</div>
						</div>
					</div>

					<div class="fx-col-content">
						<div class="row">
							<div class="small-12 columns">
								<ul class="inline-list-grid no-bullet align-center">
									<li>
										<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
									</li>
									<li>
										<div class="wrap-pagination">
											{{-- Render Pagination--}}
										</div>
									</li>
								</ul>

								<div id="content-evaluation-projects" class="content-data-list h-hollow-both">
									@include('public.noresults')
									<ul class="browse-list-evaluation-project mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 medium-block-grid-3 xxlarge-block-grid-4 browse-list-mask responsive-browse">
										{{-- Render view:evaluation-item-project-tpl --}}
									</ul>
								</div>

								<ul class="inline-list-grid no-bullet align-center">
									<li>
										<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
									</li>
									<li>
										<div class="wrap-pagination">
											{{-- Render Pagination--}}
										</div>
									</li>
								</ul>

							</div>
						</div>
					</div>

				</div>

			</div>
		</div>
	</script>

	<script type="text/template" id="evaluation-item-project-tpl">
		<div class="item-wrap-list radius">
			<div class="top-item-list no-border">
				<a href="<%- Route.route('evaluacion.show', {'evaluacion' : url_asignacion_jurado }) %>" title="" class="item-thumb <%- codigo_estado == window._tp.getState['returned'] ? 'disabled' : '' %>">
					<img src="<%- imagen_usuario_proyecto %>" alt="<%- nombre_usuario_proyecto %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_image') }}')"/>
				</a>
			</div>
			<div class="content-item-list">
				<h5 class="title-item-list is-hovered ellipsis dark-text">
					<a href="<%- Route.route('evaluacion.show', {'evaluacion' : url_asignacion_jurado }) %>" title="" class="<%- codigo_estado == window._tp.getState['returned'] ? 'disabled' : '' %>"><%- nombre_usuario_proyecto %></a>
				</h5>
				<ul class="no-bullet">

					<li>
						<span class="text-sm thin-text gray-base-text"><span class="dark-text"><%- nombre_fase %> - <%- nombre_convocatoria %></span></span>
					</li>
					<li>
						<span class="text-sm thin-text gray-base-text">Registrado: <span class="dark-text"><%- window.moment([fecha_registro_fase_usuario, hora_registro_fase_usuario].join(' '), "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DD, h:mm a") %></span></span>
					</li>
					<li>
						<span class="text-sm thin-text gray-base-text">Asignado: <span class="dark-text"><%- window.moment(fecha_asignacion_jurado).format('YYYY-MM-DD') %></span></span>
					</li>
					<% if(fecha_evaluacion_jurado) { %>
						<li>
							<span class="text-sm thin-text gray-base-text">Fecha evaluación: <span class="dark-text"><%- window.moment(fecha_evaluacion_jurado).format('YYYY-MM-DD') %></span></span>
						</li>
					<% } %>
					<li>
						<span class="text-sm thin-text gray-base-text">Lugar: <span class="dark-text"><%- lugar_evaluacion_jurado %></span></span>
					</li>
					<li>
						<span class="text-sm thin-text gray-base-text">Código aplicación: <span class="dark-text"><%- id_aplication %></span></span>
					</li>

					<% if(!evaluation && codigo_estado != window._tp.getState['returned']) { %>
						<li>
							<span class="text-sm thin-header <%- postulation_days >= 20 ? 'alert-text' : (postulation_days >= 15 ? 'warning-text' : 'success-text') %>"><%
								if( postulation_days >= 20 ) { %>
									Antiguo
								<% }else if( postulation_days >= 15 ) { %>
									Hace algún tiempo
								<% }else { %>
									Reciente
								<% }
							 %></span>
						</li>
					<% } %>
				</ul>

				<% if(codigo_estado != window._tp.getState['returned']) { %>
					<div class="bottom-item-list text-right">
						<a href="<%- Route.route('evaluacion.show', {'evaluacion' : url_asignacion_jurado }) %>" class="button xsmall inst-secondary-outline btn-bold btn-clean-margin radius is-hovered"><%- evaluation ? 'Editar' : 'Evaluar' %></a>
					</div>
				<% } %>
			</div>


		</div>
	</script>

	{{-- View evaluation project detail --}}
	<script type="text/template" id="evaluation-detail-tpl">
		<% if(fase_entidad_editable){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown radius content medium" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-lg" data-dropdown-content class="md-dropdown radius content large" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
		<% } %>

		{{-- content project detail --}}
		<div id="evaluation-project-detail-content">
			<div class="row">
				<div class="tablet-4 medium-3 columns">
					<div id="info-project-evaluation" class="info-project-evaluation panel-content radius <%- fase_entidad_editable ? 'editable' : '' %>">
						{{-- Render info project - temaple id:project-info-tpl --}}
					</div>
				</div>

				<div class="panel-content-project-evaluation">
					<div class="tablet-8 medium-9 columns">
						<div class="strip-tabs-content submenu-project-evaluation">
							<ul id="evaluation-tabs-filter" class="tabs-project-evaluation tabs-sub-nav" data-tab data-tab-init="is_hover:false">
								<li class="tab-title active">
									<a href="#evaluation-project-form" title="General" aria-controls="evaluation-project-form">Formato de evaluación</a>
								</li>
								<% if( visibilidad_aplicacion ) { %>
								<li class="tab-title">
									<a href="#evaluation-project-program-review" title="{{ transtp('evaluations.titlesurvey') }}" aria-controls="evaluation-project-program-review">{{ transtp('evaluations.titlesurvey') }}</a>
								</li>
								<% } %>
								<% if( !_.isUndefined(categorias_producto) && _.isObject(categorias_producto) ) { %>
									<li class="tab-title">
										<a href="#available-themes" title="Llaves de acceso" aria-controls="available-themes">Llaves de acceso</a>
									</li>
								<% } %>
								<% if(codigo_fase === window._tp.getPhases['aldea_20__challenge_1_3']) { %>
									<li class="tab-title">
										<a href="#response-application-13" title="Respuestas" aria-controls="response-application-13">Respuestas</a>
									</li>
								<% } %>
								<% if(
									{{-- codigo_fase == 350
									|| codigo_fase == 351
									|| codigo_fase == 353
									|| codigo_fase == 354 --}}
									true && codigo_fase != 367
									) { %>
									<li class="tab-title">
										<a href="#edicion-evaluacion" title="Ediciones" aria-controls="edicion-evaluacion">Ediciones</a>
									</li>
								<% } %>
							</ul>
						</div>

						<div class="tabs-content">
							<div id="evaluation-project-form" class="content active">
								<div class="content-project-evaluation">
									{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-evaluation-project') ) !!}

										<% if( !_.isNull(promedio_acumulado_evaluacion_emprendimiento) && !_.isUndefined(promedio_acumulado_evaluacion_emprendimiento) && promedio_acumulado_evaluacion_emprendimiento ) { %>

											<div id="content-acomulated-average" class="info-panel-evaluation">
												{{-- Render acomulated average --}}
											</div>
										<% } %>

										<% if( !_.isNull(recomendacion_fase) && !_.isUndefined(recomendacion_fase) && recomendacion_fase != '') { %>
											<div class="panel-content radius inner-section-evaluation">
												<p class="clean-bottom text-md lighter-text gray-dark-text"><%- recomendacion_fase %></p>
											</div>
										<% } %>

										<% if(extraQuestions.length > 0) { %>
											<div class="panel-content content-project-evaluation with-header radius">
												<div class="content-header-panel no-border radius-top">
													<h4 class="hpanel-title clean-header">Preguntas Adicionales - <%- nombre_evaluacion %></h4>
												</div>
												<div id="info-calification-evaluation">
													<% _.each(extraQuestions, function (item) { %>
														<div class="inner-section-evaluation">
															<% if( item.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['open'] ) { %>
																<!-- Matriz field answer -->
																<% var answerQuestion = item.respuesta %>
																<% if(!_.isNull(item.respuesta) && !_.isUndefined(item.respuesta)) { %>
																	<% if(item.tipo_campo_pregunta == window._tp.typeQuestionField['cities']) { %>
																		@foreach( App\Ciudad::getCities() as $city)
																			<% if(item.respuesta == '{{ $city->key }}') { answerQuestion = "{{ $city->value }}"; } %>
																		@endforeach
																	<% } else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['date'] || item.tipo_campo_pregunta == window._tp.typeQuestionField['before_date']) {
																		answerQuestion = window.moment(item.respuesta).format('YYYY-MM-DD');
																	} else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['number_format']) { %>
																		answerQuestion = Globalize.formatNumber(parseFloat(item.respuesta));
																	} else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['ciiu']) { %>
																		@foreach( App\SectorInteres::getInterests() as $interest )
																			<% if(item.respuesta == '{{ $interest->codigo_sector_interes }}') { answerQuestion = "{{ $interest->codigo_sector_interes.' - '.$interest->nombre_sector_interes }}"; } %>
																		@endforeach
																	<% } else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['education_level']) { %>
																		@foreach( App\NivelEducacion::getLevels() as $level )
																			<% if(item.respuesta == '{{ $level->codigo_nivel_educacion }}') { answerQuestion = "{{ $level->nombre_nivel_educacion }}"; } %>
																		@endforeach
																	<% } else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['economic_sector']) { %>
																		@foreach( App\SectorEconomico::getSectors() as $sector )
																			<% if(item.respuesta == '{{ $sector->codigo_sector_economico }}') { answerQuestion = "{{ $sector->nombre_sector_economico }}"; } %>
																		@endforeach
																	<% } else if(item.tipo_campo_pregunta == window._tp.typeQuestionField['currency'] || item.tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency']) {
																		answerQuestion = Globalize.formatCurrency(parseFloat(question.respuesta), item.sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2});
																	} else {
																		answerQuestion = item.respuesta;
																	} %>
																<% } %>
																<p class="lighter-text text-md gray-dark-text bold-text"><%= item.texto_pregunta_encuesta %></p>
																<% if(!_.isNull(answerQuestion) && !_.isUndefined(answerQuestion) && answerQuestion != '') { %>
																	<p class="text-md lighter-text gray-dark-text text-justify"><%- answerQuestion %></p>
																<% } %>
															<% } else if( item.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['matriz'] ) { %>
																<div class="title-question-survey">
																	<span class="pos-question-survey"><%- item.numero_pregunta_encuesta ? item.numero_pregunta_encuesta +'.' : '' %></span>
																	<%= item.texto_pregunta_encuesta %>
																</div>
																<% if(item.texto_opcional_pregunta) { %>
																	<p class="text-xmd gray-dark-text thin-text"><%- item.texto_opcional_pregunta %></p>
																<% } %>
																<table class="grid-matriz-survey responsive-table">
																	<thead>
																		<tr>
																			<th><%- item.titulo_opciones_pregunta ? item.titulo_opciones_pregunta : '' %></th>
																			<% _.each(item.campos_opciones, function (fieldOption) { %>
																				<th data-field="head_<%- fieldOption.codigo_opcion_encuesta %>"><%- fieldOption.texto_opcion_encuesta %></th>
																			<% }); %>
																		</tr>
																	</thead>
																	<tbody>
																		<% if(!_.isNull(item.respuesta) && !_.isUndefined(item.respuesta)) { %>
																			<% _.each(item.opciones, function (option) { %>
																				<tr>
																					<th id="matriz-option-<%- option.codigo_opcion_encuesta %>" class="<%- option.calculado_opcion_encuesta ? 'dark-text bold-text' : ''%>"><%- option.texto_opcion_encuesta %></th>
																					<% _.each(item.campos_opciones, function (fieldOption) {
																						var typeField = option.tipo_campo_opcion || item.tipo_campo_pregunta;
																						fieldOption.tipo_campo_opcion && (typeField = fieldOption.tipo_campo_opcion);
																					%>
																						<% if(typeField == window._tp.typeQuestionField['date'] || typeField == window._tp.typeQuestionField['before_date']) { %>
																							<td><%- window.moment(item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta]).format('YYYY-MM-DD') %></td>
																						<% } else if(typeField == window._tp.typeQuestionField['number_format']) { %>
																							<td><%- Globalize.formatNumber(parseFloat(item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta])) %></td>
																						<% } else if( typeField == window._tp.typeQuestionField['currency'] || typeField == window._tp.typeQuestionField['negative_currency']) { %>
																							<td class="text-right"><%- Globalize.formatCurrency(parseFloat(item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta]), item.sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2}) %></td>
																						<% } else if( typeField == window._tp.typeQuestionField['percentage'] ) { %>
																							<td class="text-right"><%- Globalize.formatNumber(parseInt(item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta])/100, { style: "percent", round: 'round', }) %></td>
																						<% } else if(typeField == window._tp.typeQuestionField['cities']) { %>
																							@foreach( App\Ciudad::getCities() as $city)
																								<% if(item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] == '{{ $city->key }}') { %>
																									<p class="text-md">{{ $city->value }}</p>
																								<% } %>
																							@endforeach
																						<% } else if( typeField == window._tp.typeQuestionField['select'] ) { %>
																							<td>
																								<ul class="no-bullet">
																									<li><span class="text-md"><%- item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] ? item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] : '' %></span></li>
																								</ul>
																							</td>
																						<% } else if( typeField == window._tp.typeQuestionField['image'] ) { %>
																							<td>
																								<div class="field-with-image">
																									<img id="image-thumb-<%- codigo_pregunta_encuesta +'_'+ option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta %>" src="<%- item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" />
																								</div>
																							</td>
																						<% } else { %>
																							<td><%- item.respuesta[option.codigo_opcion_encuesta +'_'+ fieldOption.codigo_opcion_encuesta] %></td>
																						<% } %>
																					<% }); %>
																			<% }); %>
																		<% } %>
																	</tbody>
																</table>
															<% } %>
														</div>
													<% }); %>
												</div>
											</div>
										<% } %>

										<dl id="container-item-evaluation" class="inner-contect-evaluation">
											<!-- Render view id:evaluation-item-tpl -->
										</dl>

										<div id="total-evaluation-container">
											{{-- Render Total Evaluation  --}}
										</div>

										<div class="panel-content radius">
											<div class="row">
												<div class="small-12 columns">
													<h6 class="dark-text bold-header clean-header">{{ transtp('evaluations.titlecomment') }}</h6>
													<div class="input-field">
														<textarea placeholder="Comenta aquí" name="comentario_resultado_evaluacion" id="comentario_resultado_evaluacion" rows="2" class="materialize-textarea validate"><%- comentario_evaluacion %></textarea>
														<label for="comentario_resultado_evaluacion"></label>
													</div>
												</div>
											</div>
										</div>
										<% if( !window.moment(fecha_evaluacion_jurado).isValid() || window.moment(window.moment().format('Y') + '-' + window.moment().format('M') + '-' + window.moment().format('D')).diff(window.moment(fecha_evaluacion_jurado), 'days') == 0 ) { %>

											<% if(aceptacion_termnos_evaluacion) { %>
												<div class="panel-content radius inner-section-evaluation">
													{!! Form::checkbox('aceptacion_terminos', 'yes', false, ['required' => 'required', 'id' => 'aceptacion_terminos']) !!}
													<label for="aceptacion_terminos" class="label-terms dark-text" data-error="{{ transtp('evaluations.terms.error') }}">
														<%= terminos_evaluacion %>
													</label>
												</div>
											<% } %>

											<div class="row">
												<div class="small-12 columns text-right">
													<ul class="inline-list-items">
														<% if(fase_cancelacion && !evaluation) { %>
															<li>
																<a href="#" class="button xsmall inst-secondary-outline radius btn-clean-margin to-return-evaluation">Devolver</a>
															</li>
														<% } %>
														<li>
															<button class="button xsmall sky-blue radius btn-shadow btn-clean-margin" type="submit"><%- evaluation ? 'Editar' : 'Calificar' %></button>
														</li>
													</ul>
												</div>
											</div>
										<% } else if(window.moment().diff(window.moment(fecha_evaluacion_jurado), 'days') > 0) { %>
											<div class="row">
												<div class="small-12 columns">
													<p class="text-md gray-dark-text">El periodo para poder evaluar este emprendimiento ha terminado en <span class="dark-text bold-text"><%- window.moment(fecha_evaluacion_jurado).format('YYYY/MM/DD') %></span></p>
												</div>
											</div>
										<% } else { %>
											<div class="row">
												<div class="small-12 columns">
													<p class="text-md gray-dark-text">Podrás evaluar este emprendimiento desde <span class="dark-text bold-text"><%- window.moment(fecha_evaluacion_jurado).format('YYYY/MM/DD') %></span></p>
												</div>
											</div>
										<% } %>
									{!! Form::close() !!}
								</div>
							</div>
							<div id="evaluation-project-program-review" class="content">
								<!-- Render program review -->
							</div>
							<% if( !_.isUndefined(categorias_producto) && _.isObject(categorias_producto) ) { %>
								<div id="available-themes" class="content">
									<p class="text-sm darl-text">Con base en la identificación de las necesidades críticas del emprendedor, los expertos realizaran la recomendación de una o varias de las siguientes temáticas disponibles en las cuales se busca su fortalecimiento para detonar su crecimiento.</p>
									<div class="panel-content content-project-evaluation with-header radius">
										<div class="content-header-panel no-border radius-top">
											<h4 class="hpanel-title clean-header">Temáticas disponibles</h4>
										</div>

										<ol class="categories-product-list list-separator list-highlighted ordered">
											<% _.each(categorias_producto, function(categoryProduct){ %>
												<li><%- categoryProduct %></li>
											<% }) %>
										</ol>
									</div>
								</div>
							<% } %>
							<% if (codigo_fase === window._tp.getPhases['aldea_20__challenge_1_3']) { %>
								<div id="response-application-13" class="content">
									<div class="panel-content content-project-evaluation with-header radius">
										<div class="content-header-panel no-border radius-top">
											<h4 class="hpanel-title clean-header">Respuestas - <%- nombre_evaluacion %></h4>
										</div>
										<div id="info-calification-evaluation">
											<div class="inner-section-evaluation">
												<table class="table-content">
													<thead>
														<tr>
															<th class="dark-text" style="width:30%">Nombre</th>
															<th class="dark-text" style="width:30%">Factor</th>
															<th class="dark-text" style="width:30%">Puntaje</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td> Innovacion </td>
															<td> 30% </td>
															<td><%- respuestas.total_innovacion %></td>
														</tr>
														<tr>
															<td> Potencial de escalabilidad </td>
															<td> 15% </td>
															<td><%- respuestas.total_escalabilidad %></td>
														</tr>
														<tr>
															<td> Tracción de mercado </td>
															<td> 10% </td>
															<td><%- respuestas.total_traccion %></td>
														</tr>
														<tr>
															<td> Equipo emprendedor </td>
															<td> 45% </td>
															<td><%- respuestas.total_equipo %></td>
														</tr>
													</tbody>
												</table>
												<p> Total: <b> <%- respuestas.total %> - Minimo para pasar a momento 4 60 / 100 </b> </p>
											</div>
										</div>
									</div>
								</div>
							<% } %>

							{{-- tab solo para rutan --}}
							<% if (codigo_fase == 351 || codigo_fase == 352 || codigo_fase == 353 || codigo_fase == 354) { %>
								<div id="edicion-evaluacion" class="content">
									<div class="panel-content content-project-evaluation with-header radius">
										<div class="content-header-panel no-border radius-top">
											<h4 class="hpanel-title clean-header">HISTORICO</h4>
										</div>
										<div id="info-calification-evaluation">
											<div class="inner-section-evaluation">
												<table class="table-content">
													<thead>
														<tr>
															<th class="dark-text text-center" style="width:30%">Fecha edición</th>
															<th class="dark-text text-center" style="width:30%">PDF</th>
														</tr>
													</thead>
													<tbody>
														<% _.each(data_logs, function (data) { %>
															<tr>
																<td class="text-center" > <%- data.created_at %> </td>
																<td class="text-center">
																	<a href="<%- data.pdf_evaluacion %>" target="_blank" title="Ver pdf">
																		<i class="mdi mdi-file-check"></i>
																	</a>
																</td>
															</tr>
														<% }) %>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							<% } %>

						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="project-info-tpl">
		<ul class="list-info-project-evaluation list-separator">
			<li>
				<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_image') }}')" class="image-project-evaluation" />
				<div class="info-inner-evaluation">
					<h4 class="lighter-header gray-dark-text"><%- nombre_usuario %></h4>
				</div>
			</li>
			<li>
				<div class="info-inner-evaluation">
					<ul class="list-info-inner-evaluation">
						<li>
							<label class="label single text-sm gray-base-text">Redes Sociales</label>
							<div class="card-creator-info card-user-info">
								<ul class="inline-list-grid no-spacing align-center">
									<li>
										<ul class="list-info-data no-bullet">
											<% if(!_.isEmpty(tiktok_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- tiktok_usuario %>" target="_blank"> TikTok </a>
													</div>
												</li>
											<% } %>
											<% if(!_.isEmpty(linkedin_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- linkedin_usuario %>" target="_blank"> Linkedin </a>
													</div>
												</li>
											<% } %>

											<% if(!_.isEmpty(facebook_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- facebook_usuario %>" target="_blank"> Facebook </a>
													</div>
												</li>
											<% } %>

											<% if(!_.isEmpty(instagram_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- instagram_usuario %>" target="_blank"> Instagram </a>
													</div>
												</li>
											<% } %>

											<% if(!_.isEmpty(twitter_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- twitter_usuario %>" target="_blank"> X </a>
													</div>
												</li>
											<% } %>

											<% if(!_.isEmpty(pagina_web_usuario)) { %>
												<li>
													<div class="carduser-namename-user bold-header clean-header inst-color-secondary">
														<a href="<%- pagina_web_usuario %>" target="_blank"> Pagina Web </a>
													</div>
												</li>
												<% } %>
										</ul>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</li>
			<% if( visibilidad_aplicacion ) { %>
			<li>
				<div class="info-inner-evaluation">
					<ul class="list-info-inner-evaluation">
						<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
							<li>
								<label class="label single text-sm gray-base-text">Ciudad</label>
								<p class="text-sm dark-text"><%- nombre_ciudad %>, <%- nombre_pais %></p>
							</li>
						<% } %>
				 		<li>
				 			<label class="label single text-sm gray-base-text">Industria</label>
							<p class="text-sm dark-text"><%- nombre_categoria_proyecto %></p>
				 		</li>
				 		<li>
				 			<label class="label single text-sm gray-base-text">Industria evaluador</label>
							<div id="project-industry-evaluator-container" class="editable-item">
								{{-- Render info industry evaluator --}}
							</div>
				 		</li>
				 		<li>
				 			<label class="label single text-sm gray-base-text">Descripción</label>
							<p class="description-project-evaluation text-sm dark-text"><%- biografia_usuario %></p>
				 		</li>
				 		<li>
				 			<label class="label single text-sm gray-base-text">Creador</label>
				 			<div class="card-creator-info card-user-info">
	 							<ul class="inline-list-grid no-spacing align-center">
	 								<li class="has-image">
	 									<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {nickname:nickname_founder}) ) %>" title="<%- nombre_founder %>" class="rounded-thumb">
											<img src="<%= imagen_founder %>" alt="<%- nombre_founder %>" class="rounded-img size45" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
										</a>
	 								</li>
	 								<li>
	 									<ul class="list-info-data no-bullet">
	 										<li>
	 											<h6 class="carduser-namename-user bold-header clean-header inst-color-secondary">
													<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {nickname:nickname_founder}) ) %>" title="<%- nombre_founder %>"><%- nombre_founder %></a>
												</h6>
	 										</li>
	 										<% if(!_.isUndefined(ciudad_founder) && !_.isNull(ciudad_founder) && ciudad_founder.length) { %>
												<li>
													<span class="text-sm gray-base-text linear-span"><i class="mdi mdi-map-marker-radius mdi-14 mdi-center"></i><%- ciudad_founder %>, <%- pais_founder %></span>
												</li>
											<% } %>
	 									</ul>
	 								</li>
	 							</ul>
				 			</div>
						 </li>
				 		<li class="text-right">
							<a href="<%- window.Misc.urlFull( Route.route('proyecto.proyecto.tab', {proyecto:url_nickname,tab:'basico'}) ) %>" title="{{ transtp('entities.see') }}" target="_blank" class="inst-color-secondary text-sm">{{ transtp('entities.see') }}</a>
						</li>
				 	</ul>
				</div>
			</li>
			<% } %>
		</ul>
	</script>

	{{-- Item Evaluation View --}}
	<script type="text/template" id="evaluation-item-tpl">
		<div class="panel-content content-project-evaluation with-header radius">
			<div class="content-header-panel no-border radius-top">
				<h4 class="hpanel-title clean-header"><%- nombre_grupo_item_eval %>
					<% if( !_.isNull(promedio_conmutado) && !_.isUndefined(promedio_conmutado) ) { %>
						<span class="text-white thin-text text-center right"><%- promedio_conmutado %> <%- sigla_grupo_item_eval %></span>
					<% } %>
				</h4>
			</div>

			<div id="info-calification-evaluation">
				<% _.each(items, function (item) { %>
					<div class="inner-section-evaluation">
						<% if(subgrupos_evaluacion_emprendimiento && item.nombre_grup_opc_eval_pregunta) { %>
							<h5 class="bold-header dark-text"><%- item.nombre_grup_opc_eval_pregunta %></h5>
						<% } %>
						<% if(item.nombre_item_evaluacion) { %>
							<label class="label single text-md bold-text gray-dark-text"><%- item.nombre_item_evaluacion %></label>
						<% } %>
						<% _.each(item.preguntas, function (question) { %>
							<% if( question.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['open'] ) { %>
								<!-- Matriz field answer -->
								<% var answerQuestion = question.respuesta %>
								<% if(!_.isNull(question.respuesta) && !_.isUndefined(question.respuesta)) { %>
									<% if(question.tipo_campo_pregunta == window._tp.typeQuestionField['cities']) { %>

										@foreach( App\Ciudad::getCities() as $city)
											<% if(question.respuesta == '{{ $city->key }}') { answerQuestion = "{{ $city->value }}"; } %>
										@endforeach

									<% } else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['date'] || question.tipo_campo_pregunta == window._tp.typeQuestionField['before_date']) {

										answerQuestion = window.moment(question.respuesta).format('YYYY-MM-DD');

									} else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['number_format']) { %>

										answerQuestion = Globalize.formatNumber(parseFloat(question.respuesta));

									} else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['ciiu']) { %>

										@foreach( App\SectorInteres::getInterests() as $interest )
											<% if(question.respuesta == '{{ $interest->codigo_sector_interes }}') { answerQuestion = "{{ $interest->codigo_sector_interes.' - '.$interest->nombre_sector_interes }}"; } %>
										@endforeach

									<% } else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['education_level']) { %>

										@foreach( App\NivelEducacion::getLevels() as $level )
											<% if(question.respuesta == '{{ $level->codigo_nivel_educacion }}') { answerQuestion = "{{ $level->nombre_nivel_educacion }}"; } %>
										@endforeach

									<% } else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['economic_sector']) { %>

										@foreach( App\SectorEconomico::getSectors() as $sector )
											<% if(question.respuesta == '{{ $sector->codigo_sector_economico }}') { answerQuestion = "{{ $sector->nombre_sector_economico }}"; } %>
										@endforeach

									<% } else if(question.tipo_campo_pregunta == window._tp.typeQuestionField['currency'] || question.tipo_campo_pregunta == window._tp.typeQuestionField['negative_currency']) {

										answerQuestion = Globalize.formatCurrency(parseFloat(question.respuesta), question.sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2});

									} else {
										answerQuestion = question.respuesta;
									} %>
								<% } %>

								<p class="lighter-text text-md gray-dark-text bold-text"><%= question.texto_pregunta_encuesta %></p>
								<% if(!_.isNull(answerQuestion) && !_.isUndefined(answerQuestion) && answerQuestion != '') { %>
									<p class="text-md lighter-text gray-dark-text text-justify"><%- answerQuestion %></p>
								<% } %>
							<% } else if( question.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['single'] ) { %>
								<p class="lighter-text text-md gray-dark-text"><%= question.texto_pregunta_encuesta %></p>
								<% if(!_.isNull(question.respuesta) && !_.isUndefined(question.respuesta) && question.respuesta != '') { %>
									<ul class="disc">
										<% _.chain(question.opciones).filter(function(option) { return question.respuesta == option.codigo_opcion_encuesta; }).each(function (option) { %>
											<li><p class="text-md lighter-text gray-dark-text text-justify"><%- option.texto_opcion_encuesta %></p></li>
										<% }); %>
									</ul>
								<% } %>
							<% } else if( question.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['multiple'] ) { %>
								<p class="lighter-text text-md gray-dark-text"><%= question.texto_pregunta_encuesta %></p>
								<ul class="disc">
									<% _.each(question.opciones, function (option) { %>
										<li><p class="text-md lighter-text gray-dark-text text-justify"><%- option.texto_opcion_encuesta %></p></li>
									<% }); %>
								</ul>
							<% } else if( question.tipo_pregunta_encuesta ==  window._tp.typeQuestionSurvey['matriz'] ) { %>
								<% if(!_.isNull(question.respuesta) && !_.isUndefined(question.respuesta)) { %>
									<%
										var questionOption = _.findWhere(question.opciones, {'codigo_opcion_encuesta': question.agrupacion_item_ejey}),
											fieldOption = _.findWhere(question.campos_opciones, {'codigo_opcion_encuesta': question.agrupacion_item_ejex} );
									%>
									<table class="table-content">
										<tbody>
											<tr>
												<th class="dark-text" style="width:30%"><%= question.texto_pregunta_encuesta %></th>
												<th class="dark-text" style="width:25%"><%- fieldOption.texto_opcion_encuesta %></th>
												<th class="dark-text" style="width:25%"><%- questionOption.texto_opcion_encuesta %></th>

												<!-- Matriz field answer -->
												<% var typeField = questionOption.tipo_campo_opcion || question.tipo_campo_pregunta; %>

												<% if(typeField == window._tp.typeQuestionField['date'] || typeField == window._tp.typeQuestionField['before_date']) { %>

													<td class="text-right" style="width:20%"><%- window.moment(question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex]).format('YYYY-MM-DD') %></td>

												<% } else if(typeField == window._tp.typeQuestionField['number_format']) { %>

													<td class="text-right" style="width:20%"><%- Globalize.formatNumber(parseFloat(question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex])) %></td>

												<% } else if( typeField == window._tp.typeQuestionField['currency'] || typeField == window._tp.typeQuestionField['negative_currency']) { %>

													<td class="text-right" style="width:20%"><%- Globalize.formatCurrency(parseFloat(question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex]), question.sigla_moneda || 'COP', {style: "symbol", minimumFractionDigits: 0, maximumFractionDigits: 2}) %></td>

												<% } else if( typeField == window._tp.typeQuestionField['percentage'] ) { %>

													<td class="text-right" style="width:20%"><%- Globalize.formatNumber(parseFloat(question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex]), { style: "percent", round: 'round' }) %></td>

												<% } else if( typeField == window._tp.typeQuestionField['select'] ) { %>

													<td class="text-right" style="width:20%"><%- question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex] %></td>

												<% } else { %>
													<td class="text-right" style="width:20%"><%- question.respuesta[question.agrupacion_item_ejey +'_'+ question.agrupacion_item_ejex] %></td>
												<% }  %>
											</tr>
										</tbody>
									</table>
								<% } %>
							<% } %>
						<% }); %>

						<div class="row">
							<div class="small-12 columns">
								<% if( item.codigo_tipo_evaluacion_item == window._tp.typeItemEvaluation[('select')] ) { %>
									<% if(!_.isNull(item.codigo_grup_opc_eval_pregunta) && !_.isUndefined(item.codigo_grup_opc_eval_pregunta)) { %>
										<select name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" data-placeholder="Selecciona una opción" placeholder="Selecciona una opción"  class="" required>
											<option value="" selected disabled>Selecciona una opción</option>
											<% _.chain(options).filter(function(option) { return item.codigo_grup_opc_eval_pregunta == option.codigo_grup_opc_eval_pregunta; }).each(function (option) { %>
												<option value="<%- option.codigo_opc_eval_pregunta %>" <%- item.calification == option.codigo_opc_eval_pregunta ? 'selected' : '' %> id="codigo_evaluacion_item_<%- option.codigo_opc_eval_pregunta %>" id="codigo_evaluacion_item_<%- option.codigo_opc_eval_pregunta %>" ><%- option.nombre_opc_eval_pregunta %></option>
											<% }) %>
										</select>
									<% } %>
								<% } else if( item.codigo_tipo_evaluacion_item == window._tp.typeItemEvaluation[('stars')] ) { %>
									<div class="right stars-rating stars-30">
										<input type="radio" name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_5" value="5" required="required" <%- item.calification == 5 ? 'checked' : '' %>>
										<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_5" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

										<input type="radio" name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_4" value="4" required="required" <%- item.calification == 4 ? 'checked' : '' %>>
										<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_4" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

										<input type="radio" name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_3" value="3" required="required" <%- item.calification == 3 ? 'checked' : '' %>>
										<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_3" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

										<input type="radio" name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_2" value="2"  required="required" <%- item.calification == 2 ? 'checked' : '' %>>
										<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_2" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>

										<input type="radio" name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>" id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_1" value="1"  required="required" <%- item.calification == 1 ? 'checked' : '' %>>
										<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>_1" class="label-terms"><i class="mdi mdi-star sky-blue"></i></label>
									</div>
								<% } else if( item.codigo_tipo_evaluacion_item == window._tp.typeItemEvaluation[('upload')] ) { %>
									<div id="evaluation-documents-container" class="editable-item">
										<section id="wrap-documents-<%- item.codigo_item_evaluacion %>" class="">
											{{-- Render  Documents --}}
										</section>
									</div>
								<% } else if( item.codigo_tipo_evaluacion_item == window._tp.typeItemEvaluation[('textarea')] ) { %>
									<div id="evaluation-documents-container" class="editable-item">
										<textarea
											class="materialize-textarea"
											id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>"
											name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion %>"
											rows="2"
											><%- item.comentario_adicional %></textarea>
									</div>
								<% } else if( item.codigo_tipo_evaluacion_item == window._tp.typeItemEvaluation[('checkbox')] ) { %>
									<% if(!_.isNull(item.codigo_grup_opc_eval_pregunta) && !_.isUndefined(item.codigo_grup_opc_eval_pregunta)) { %>
										<% const atLeastOneChecked = _.some(options, function(option) {
											return option.checked || _.some(item.valores_evaluacion_item, function(val) {
												return val == option.codigo_opc_eval_pregunta;
											});
										}); %>
										<% _.chain(options)
											.filter(function(option) { return item.codigo_grup_opc_eval_pregunta == option.codigo_grup_opc_eval_pregunta; })
											.each(function (option) { %>
												<input
													type="checkbox"
													name="codigo_evaluacion_item_<%-item.codigo_item_evaluacion%>"
													id="codigo_evaluacion_item_<%-item.codigo_item_evaluacion%>_<%-option.codigo_opc_eval_pregunta%>"
													value="<%-option.codigo_opc_eval_pregunta%>"
													class="group<%- item.codigo_grup_opc_eval_pregunta %>"
													<% if (option.checked || _.some(item.valores_evaluacion_item, function(val) { return val == option.codigo_opc_eval_pregunta; })) { %>
														checked
													<% } %>
													<% if (!atLeastOneChecked) { %>
														required
													<% } %>
											 	>
											<label for="codigo_evaluacion_item_<%-item.codigo_item_evaluacion%>_<%-option.codigo_opc_eval_pregunta%>"> <%- option.nombre_opc_eval_pregunta %> </label>
											<br>
										<% }) %>
									<% } %>
								<% } %>
							</div>
						</div>
					</div>
				<% }) %>
			</div>
		</div>

	</script>

	{{-- Total Evaluation View --}}
	<script type="text/template" id="total-evaluation-tpl">
		<% if(!_.isNull(valor_total_evaluacion) && !_.isUndefined(valor_total_evaluacion) && valor_total_evaluacion != '') { %>
			<div class="content-score-result">
				<div class="row collapse col-equal-height">
					<div class="mobile-9 tablet-10 columns">
						<div class="panel-score-result-desc panel-content inner-section-evaluation">
							<p class="clean-bottom text-md lighter-text gray-dark-text"><%- recomendacion_evaluacion %></p>
						</div>
					</div>
					<div class="mobile-3 tablet-2 columns">
						<div class="panel-score-result-value panel-content inner-section-evaluation inst-bgcolor-secondary text-center">
							<span class="white-text thin-text"><%- Globalize.numberFormatter({ minimumFractionDigits: 0, maximumFractionDigits: 2 })( parseFloat(valor_total_evaluacion) ) %></span>
						</div>
					</div>
				</div>
			</div>
		<% } %>
	</script>

	<script type="text/template" id="acomulated-average-evaluation-tpl">
		<div class="row collapse col-equal-height">
			<div class="mobile-6 tablet-7 columns">
				<div class="panel-score-result-desc panel-content inner-section-evaluation">
					<ul class="no-bullet">
						<li>
							<label class="label single text-lg bold-text gray-dark-text">Nombre del evaluador:</label>
							<p class="thin-text text-md"><%- nombre_usuario_jurado %></p>
						</li>
						<li>
							<label class="label single text-lg bold-text gray-dark-text">Nombre de la postulación:</label>
							<p class="thin-text text-md"><%- nombre_usuario_proyecto %></p>
						</li>
						<% if(window.moment(fecha_evaluacion_jurado).isValid()) { %>
							<li>
								<label class="label single text-lg bold-text gray-dark-text">Fecha de evaluación:</label>
								<p class="thin-text text-md"><%- window.moment(fecha_evaluacion_jurado).format('YYYY-MM-DD') %></p>
							</li>
						<% } %>
					</ul>
				</div>
			</div>
			<div class="mobile-6 tablet-5 columns">
				<div class="panel-score-result-value panel-content content-project-evaluation inst-bgcolor-secondary">

					<table class="data-result-average highlight-light">
						<tbody>
							<tr>
								<td class="thin-text white-text"><h5 class="white-text bold-header">PROMEDIO TOTAL</h5></td>
								<td class="text-md thin-text white-text text-right"><%- promedio_total_acumulado %></td>
							</tr>
							<% _.each(promedio_acumulado, function(item){ %>
								<tr>
									<td class="text-md thin-text white-text"><%- item.nombre_item %></td>
									<td class="text-md thin-text white-text text-right"><%- item.promedio_item %></td>
								</tr>
							<% }) %>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</script>
@stop
