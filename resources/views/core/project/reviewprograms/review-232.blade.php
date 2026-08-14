<script type="text/template" id="project-program-review-232-tpl">
	<div class="panel-review-program-project panel-content radius">
		<!-- div class="submenu-tabs-review-program no-shadow no-border clearfix">
			<ul id="project-tabs-navs-review" class="project-program-submenu-review tabs-sub-nav" data-tab
				data-tab-init="is_hover:false">
				<li class="tab-title active">
					<a href="#program-preview-result" title="Resultado"
					   aria-controls="program-preview-result">Resultado</a>
				</li>
				<li class="tab-title">
					<a href="#program-preview-diagnostic" title="Diagnóstico"
					   aria-controls="program-preview-diagnostic">Diagnóstico</a>
				</li>
				<li class="tab-title">
					<a href="#program-preview-opportunities" title="Oportunidades"
					   aria-controls="program-preview-opportunities">Oportunidades</a>
				</li>
			</ul>
		</div> -->

		<!-- <div class="tabs-content"> -->
			<div id="program-preview-diagnostic" class="">
				<div class="inner-panel-program-review">
					<h5 class="inst-color-secondary bold-text">Resultados del diagnóstico empresarial.</h5>
					<br>
					<p>A continuación encontraras los resultados del diagnóstico de tu empresa/emprendimiento. Estos resultados se componen de una gráfica de radar con el puntaje de las tres áreas evaluadas, una recomendación general para cada área y recomendaciones de recursos con los que puedes fortalecer tu empresa/emprendimieno.</p>
				</div>
				<div class="inner-panel-program-review">
					<canvas id="chart-area-result-program"></canvas>
				</div>
			</div>



			<div id="program-preview-result" class="">
				<!-- Informacion de la empresa -->
				<div class="inner-panel-program-review">
					<%= report['data_general']['texto_respuesta'] %>
				</div>
			</div>



			<div id="program-preview-opportunities" class="">


			<%	if(!_.isUndefined(report['oportunidades']) && _.size(report['oportunidades']) > 0) {%>
				<div class="inner-panel-program-review">
					<h5 class="inst-color-secondary bold-text">Recomendaciones</h5>
					<br>
					Te invitamos a participar en los diferentes programas para que fortalezcas tu negocio en las áreas identificadas en la sección de Diagnóstico
				</div>
			<% } else { %>
				<div class="inner-panel-program-review">
					<h5 class="inst-color-secondary bold-text">Recomendaciones</h5>
					<br>
					No encontramos ningún programa que coincida con el resultado del Diagnóstico
				</div>
			<% }; %>
			<div class="content-data-program-review-list content-data-list">

			<ul class="browse-list-program-review browse-list-piece">
				<% _.each( report['oportunidades'], function(item) { %>
					<hr style="margin:0;">
					<li>
						<div class="item-wrap-list">
							<div class="row collapse col-equal-height">
								<div class="mobile-4 medium-3 columns">
									<div class="top-item-list">
										<a href="<%- window.Misc.urlFull( Route.route('convocatoria.convocatoria',{convocatoria:item.url_convocatoria}) )%>" title="<%- item.nombre_convocatoria %>" target="_blank" class="wrapper-pointer-item">
											<img src="<%- item.imagen_convocatoria %>" alt="<%- item.nombre_convocatoria %>">
										</a>
									</div>
								</div>
								<div class="mobile-8 medium-7 columns">
									<div class="content-item-list">
										<a href="<%- window.Misc.urlFull( Route.route('convocatoria.convocatoria',{convocatoria:item.url_convocatoria}) )%>" title="<%- item.nombre_convocatoria %>" target="_blank" class="wrapper-pointer-item">
											<h6 class="bold-header dark-text is-hovered"> <%- item.nombre_convocatoria%></h6>
										</a>
										<label  class="dark-text bold-text"> Fase(s): <span class="lighter-text gray-dark-text text-md"> <%= item.etapas %> </span></label>
										<br>
										<label class="dark-text bold-text"> Categoria(s):  <span class="lighter-text gray-dark-text text-md"><%- item.categorias %></span></label>
										<br>
										<ul class="inline-list-grid align-center state-program-info">
										<% if(item.codigo_estado == window._tp.getState['active']) { %>
												<li class="has-image">
													<i class="mdi mdi-bullhorn vcenter mdi-24 success-text"></i>
												</li>
												<li class="no-warp">
													<label class="label single dark-text text-ms bold-text">{!!  transtp('programs.open') !!}  </label>
												</li>
										<% } else if(item.codigo_estado == window._tp.getState['inactive']) { %>
											<li class="has-image">
												<i class="mdi mdi-block-helper mdi-18"></i>
											</li>
											<li class="no-warp">
												<label class="label single dark-text text-sm bold-text">{{  transtp('programs.closed') }}</label>
												<p class="clean-bottom text-sm gray-base-text">{{transtp('programs.closedmessage')}}</p>
											</li>
										<% } %>
										</ul>
									</div>
								</div>
								<div class="medium-1 columns hide-for-mobile-only hide-for-tablet-only">
									<div class="top-item-list">
										<% if( item.nombre_usuario ) { %>
											<a href="<%- window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto':item.nickname_usuario}) )  %>" class="organizer">
												<img src="<%- item.imagen_usuario %>" class="rounded-img"/>
											</a>
										<% } %>
									</div>
								</div>
							</div>
						</div>

				</li>
				<% }); %>
			</ul>

			</div>

		<!-- </div> -->
	</div>
</div>
</script>
