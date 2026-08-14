{{-- uploader question & answer survey --}}
<script type="text/template" id="survey-upload-question-tpl">
	<% if(!opcional_pregunta_encuesta && !review ) { %>
		<em class="required-msg lighter-text gray-light-text text-xmd"><span class="alert-text">*</span> <%- window.formatMessage('survey/require_question_text')%></em>
	<% } %>
	<div class="title-question-survey">
		<span class="pos-question-survey"><%- numero_pregunta_encuesta ? numero_pregunta_encuesta +'.' : '' %></span>
		<%= texto_pregunta_encuesta %>
		<% if(tipo_campo_pregunta == window._tp.typeQuestionField['image'] && !review) { %>
			<a href="#" title="Cargar imagen" class="upload-image-survey-question text-md sky-blue-text">Cargar Imagen</a>
		<% } %>
	</div>
	<% if(texto_opcional_pregunta) { %>
		<p class="text-xmd gray-dark-text thin-text"><%- texto_opcional_pregunta %></p>
	<% } %>

	{{-- review answer --}}
	<% if(review) { %>
		<% if(!_.isNull(respuesta) && !_.isUndefined(respuesta)) { %>
			<div class="row">
				<div class="tablet-6 medium-5 columns end">
					<% if(tipo_campo_pregunta == window._tp.typeQuestionField['image']){ %>
						<img id="image-thumb-<%- codigo_pregunta_encuesta %>" src="<%- respuesta %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" >
					<% }else if(tipo_campo_pregunta == window._tp.typeQuestionField['attachment']){ %>
						<a href="<%- respuesta %>" title=""><%- respuesta %></a>
					<% } %>
				</div>
			</div>
		<% } %>
	<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['image']) { %>
		<div class="row">
			<div class="tablet-6 medium-5 columns end">
				<div class="wrapper-image-survey">
					<div class="wrapper-image-edit image-area-drop">
						<img id="image-thumb-<%- codigo_pregunta_encuesta %>" src="<%- respuesta %>" class="thumbnail-image-survey item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';" >
						<button class="upload-image-survey-question edit-photo <%- window.Misc.isUrl(respuesta) ? 'change-photo' : '' %> small">
							<div class="edit-photo-content">
								<i class="mdi mdi-camera mdi-24 vcenter"></i>
								<span>Añadir una Imagen</span>
								<span class="editing-photo-message">Cambiar Imagen</span>
							</div>
						</button>
					</div>
					<input type="hidden" name="pregunta_<%- codigo_pregunta_encuesta %>" id="pregunta_<%- codigo_pregunta_encuesta %>_opcion_0" value="<%- respuesta %>" <%- !opcional_pregunta_encuesta ? 'required' : '' %> class="validate" >
					<span class="error">Carga una imagen</span>
				</div>
			</div>
		</div>
	<% } else if(tipo_campo_pregunta == window._tp.typeQuestionField['attachment']) { %>
		<div class="row">
			<div class="tablet-10 medium-9 tablet-centered columns">
				<div id="attach-file-survey" class="uploader-attachments"></div>
				<input type="hidden" name="pregunta_<%- codigo_pregunta_encuesta %>_validate" value="" data-abide-validator="<%- !opcional_pregunta_encuesta ? 'oneDataMinimun' : '' %>" <%- !opcional_pregunta_encuesta ? 'data-reldata=pregunta_'+ codigo_pregunta_encuesta : '' %>>
			</div>
		</div>
	<% } %>
</script>

{{-- Template attachments file uploader --}}
<script type="text/template" id="qq-attachments-survey-template">
	<div class="qq-uploader-selector qq-uploader qq-uploader-attachments" qq-drop-area-text="Arrastra un archivo hasta aquí">
		<div class="row">
			<div class="small-12 tablet-4 tablet-centered columns">
				<div id="button-upload" class="qq-upload-button-selector qq-upload-btn-file button tiny expand sky-blue btn-shadow radius">
					<div>Selecciona un archivo</div>
				</div>
			</div>
		</div>
		<div  id="bar-progress" class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
			<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		</div>
		<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
			<span class="qq-upload-drop-area-text-selector"></span>
		</div>
		<span class="qq-drop-processing-selector qq-drop-processing">
			<span>Processing dropped files...</span>
			<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		</span>
		<div class="content-list-attachments scroll-general-v">
			<ul class="qq-upload-list-selector qq-upload-list-attachments" aria-live="polite" aria-relevant="additions removals">
				<li>
					<div class="qq-progress-bar-container-selector">
						<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<span class="qq-upload-spinner-selector qq-upload-spinner-circle"></span>
							<img class="qq-thumbnail-selector" qq-max-size="45" qq-server-scale>
							<a class="preview-link" target="_blank">
								<span class="qq-upload-file-selector qq-upload-file"></span>
							</a>
							<span class="qq-upload-size-selector qq-upload-size"></span>

							<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
							<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
							<button class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancelar</button>
							<button class="qq-btn qq-upload-retry-selector qq-upload-retry">Procesar de nuevo</button>
							<button id="clean-upload" class="qq-btn qq-upload-delete-selector qq-upload-delete">Borrar</button>
							<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</script>
