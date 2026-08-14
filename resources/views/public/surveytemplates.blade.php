{{-- template survey form base --}}
<script type="text/template" id="wrapper-main-survey-tpl">
	<div id="content-form-survey">
		<div class="row">
			<div class="small-12 columns">
				{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-survey-base')) !!}
					<div class="panel-content with-title content-detail-survey">
						<div class="title-panel" style="<%- color_encuesta ? 'color:'+ color_encuesta +';' : '' %><%- color_fondo_encuesta ? 'background-color:'+ color_fondo_encuesta +';' : '' %>">
							<div class="row collapse">
								<div class="columns mobile-8">
									<ul class="inline-list-grid align-center no-spacing white-text">
										<li class="short-col"><i class="mdi mdi-pencil-box-outline mdi-36 vcenter icon-title"></i></li>
										<li><h4 class="bold-header clean-header"><%- nombre_encuesta %></h4></li>
									</ul>
								</div>
								<div class="columns mobile-4">
									<div class="wrap-progress-indicator">
										{{-- render percentage progress template:#survey-progress-indicator-tpl --}}
									</div>
								</div>
							</div>
						</div>
						<% if(descripcion_encuesta) { %>
							<div class="gray-dark-text description-survey"><%= descripcion_encuesta %></div>
						<% } %>
					</div>
					<div class="completed-survey">
						{{-- Render completed message --}}
					</div>
					<div id="content-asked-questions" class="content-panels">
						{{-- render question item --}}
					</div>
					<div class="buttons-action-survey hidesoft">
						<div class="row">
							<div class="small-12 columns text-right">
								<ul class="inline-list-items">
									<% if(preguardado_encuesta) { %>
										<li>
											<button id="continue-after" class="button xsmall sky-blue btn-shadow radius btn-resetc btn-continue-after"><%- window.formatMessage('survey/presave_button_text')%></button>
										</li>
									<% } %>
									<% if(cancelar_encuesta) { %>
										<li>
											<a href="<%= window.Misc.urlFull( Route.route( 'encuesta.cancelar', {'encuesta': codigo_encuesta, 'program': dataFilter.program ? dataFilter.program : '' }) )%>" title="{{ transtp('programs.cancelregistration') }}" class="button xsmall white btn-shadow radius cancel-survey-action btn-resetc">{{ transtp('programs.cancelregistration') }}</a>
										</li>
									<% } %>
									<li>
										<button type="button" class="page-prev-survey button xsmall white-skyblue btn-shadow radius">Anterior</button>
									</li>
									<li>
										<button class="page-next-survey button xsmall sky-blue btn-shadow radius" area-text="<%- label_finalizar ? label_finalizar : 'Finalizar' %>" type="submit">{{ transtp('forms.nextpage') }}</button>
									</li>
								</ul>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	{{-- image upload modal survey --}}
	<div id="modal-image-survey" class="reveal-modal-main xmedium clearfix" data-reveal >
		{{-- Title modal --}}
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-survey-image-crop'))  !!}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Agrega una imagen</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				<div class="row">
					<div class="tablet-6 columns">
						<label class="label-terms">Ajustar imagen</label>
						<div id="uploader-image-survey" class="uploader-survey uploader-image"></div>
					</div>
					<div class="tablet-6 columns">
						<label class="label-terms">Vista previa</label>
						<span class="text-xmd light-text">Tamaño real de la imagen <span class="image-size-real">(770px Por 460px)</span></span>
					</div>
				</div>
				<div class="row">
					<div class="tablet-6 columns">
						<div id="image-crop-survey" class="crop-survey-img">
							<img id="image-survey-tocrop" src="" class="image-to-crop" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" />
						</div>

						<input type="hidden" id="crop_type" name="crop_type" />
						<input type="hidden" id="file_name" name="file_name" />
						<input type="hidden" id="file_type" name="file_type" />
						<input type="hidden" class="crop-x" name="x" />
						<input type="hidden" class="crop-y" name="y" />
						<input type="hidden" class="crop-w" name="w" />
						<input type="hidden" class="crop-h" name="h" />
					</div>
					<div class="tablet-6 columns">
						<div id="preview-survey-question" class="crop-preview-img">
							<img id="survey-preview-tocrop" src="" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" />
						</div>
					</div>
				</div>
			</div>
			{{-- Footer modal --}}
			<div class="footer-modal">
				<a href="#" class="close-reveal-modal">Cancelar</a>
				<button type="submit" class="button small sky-blue radius btn-clean-margin">Confirmar</button>
			</div>
		{!! Form::close() !!}
		<a class="close close-reveal-modal">&#215;</a>
	</div>
</script>
{{-- template review survey --}}
<script type="text/template" id="survey-review-tpl">
	<div class="row">
		<div class="small-12 columns">
			<div id="content-review-survey">
				<div class="wrap-pagination">
					<!-- Render Pagination-->
				</div>
				<div class="panel-content with-title content-review-survey">
					<h4 class="title-panel white-text bold-header" style="<%- color_encuesta ? 'color:'+ color_encuesta +';' : '' %><%- color_fondo_encuesta ? 'background-color:'+ color_fondo_encuesta +';' : '' %>">
						<i class="mdi mdi-pencil-box-outline mdi-36 vcenter icon-title"></i>
						<%- nombre_encuesta %>
					</h4>
					<% if(descripcion_encuesta) { %>
						<div class="gray-dark-text description-survey"><%= descripcion_encuesta %></div>
					<% } %>
				</div>
				<div id="content-asked-questions" class="content-panels">
					{{-- render question item --}}
				</div>
				<div class="wrap-pagination">
					<!-- Render Pagination-->
				</div>
			</div>
		</div>
	</div>
</script>

{{-- wrapper group questions survey --}}
<script type="text/template" id="survey-wrapper-questions-tpl">
	<div id="grouping-survey-<%- codigo_grupo_pregunta_encuesta %>" class="grouping-survey-questions panel-item">
		<div class="title-panel">
			<h4 class="dark-text heavy-header <%- !desc_grupo_pregunta_encuesta ? 'clean-header' : '' %>"><%- nombre_grupo_pregunta_encuesta %></h4>
			<% if(desc_grupo_pregunta_encuesta) { %>
				<p class="gray-dark-text text-md"><%= desc_grupo_pregunta_encuesta %></p>
			<% } %>
		</div>
	</div>
</script>
{{-- progress advance indicator --}}
<script type="text/template" id="survey-progress-indicator-tpl">
	<div class="survey-progress-indicator">
		<p class="normal-text text-sm white-text text-right">
			<% if(tipo_porcentaje_avance === 1) { %>
				<%- window.formatMessage('survey/message_progress_by_pages', { count: currentPage-1, total: lastPage }) %>
			<% }else{ %>
				<%- window.formatMessage('survey/message_progress_by_questions', { count: total_respuestas_padre, total: total_preguntas_padre }) %>
			<% } %>
		</p>
		<div class="progress-bar round">
			<span class="meter" style="width:<%- percentage+'%' %>"></span>
		</div>
	</div>
</script>
{{-- success message --}}
<script type="text/template" id="survey-alert-box-tpl">
	<div class="row">
		<div class="small-12 columns">
			<div class="panel">
				<%= message %>
			</div>
		</div>
	</div>
</script>
{{-- invalid data message --}}
<script type="text/template" id="survey-invalid-message-tpl">
	Por favor corrige todos los campos requeridos e intenta nuevamente.
</script>
{{-- cancel message --}}
<script type="text/template" id="survey-cancel-message-tpl">
	<p>¿Está seguro de cancelar la postulación en esta convocatoria?</p>
</script>

{{-- =================== type of questions =================== --}}
{{-- open question & answer survey --}}
@include('core.survey.questions.openquestion')
{{-- single question & answer survey --}}
@include('core.survey.questions.singlequestion')
{{-- multiple question & answer survey --}}
@include('core.survey.questions.multiplequestion')
{{-- uploader question & answer survey --}}
@include('core.survey.questions.uploaderquestion')
{{-- Matriz question & answer survey --}}
@include('core.survey.questions.matrizquestion')
