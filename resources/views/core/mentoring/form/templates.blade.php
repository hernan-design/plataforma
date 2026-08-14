	{{-- Templates for mentor --}}
	<script type="text/template" id="edit-mentor-assistance-form-tpl">

		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-assistance') ) !!}
			<div class="row col-equal-height valign-bottom">
				<div class="mobile-9 tablet-10 columns input-field">
					<section id="form-mentor-help-editor">
						{{-- Render component pulse-editor --}}
						<input type="hidden" name="forma_ayuda_mentoria" value="<%- forma_ayuda_mentoria %>" required data-abide-validator="maxWords" data-maxlen="200">
					</section>
				</div>
				<div class="mobile-3 tablet-2 columns">
					<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}

	</script>

	{{-- Info mentoring asisstance template --}}
	<script type="text/template" id="info-assistance-mentor-tpl">
		<div class="text-dmd gray-dark-text text-assistance-mentoring mentoring-top-info-item"><%= forma_ayuda_mentoria ? typeof forma_ayuda_mentoria === 'string' ? forma_ayuda_mentoria : !forma_ayuda_mentoria.length ? '<span class="edit-no-result text-dmd">Ingresa un resumen</span>' : '' : ''%></div>
	</script>

	{{-- Info user experience template --}}
	<script type="text/template" id="edit-mentor-experience-form-tpl">

		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-experience') ) !!}
			<div class="row col-equal-height valign-bottom">
				<div class="mobile-9 tablet-10 columns input-field">
					<section id="form-project-editor">
						{{-- Render component pulse-editor --}}
						<input type="hidden" name="experiencia_usuario" value="<%- experiencia_usuario %>" required data-abide-validator="maxWords" data-maxlen="200">
					</section>
				</div>
				<div class="mobile-3 tablet-2 columns">
					<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}

	</script>

	<script type="text/template" id="info-experience-mentor-tpl">
		<div class="text-dmd gray-dark-text text-experience-mentor mentor-top-info-item"><%= experiencia_usuario ? typeof experiencia_usuario === 'string' ? experiencia_usuario : !experiencia_usuario.length ? '<span class="edit-no-result text-dmd">Ingresa un resumen</span>' : '' : '' %></div>
	</script>

	<script type="text/template" id="edit-mentor-expertise-form-tpl">

		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-expertise') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<div id="mentor-specialities-container">
						<select name="codigo_especialidad_destacada" id="codigo_especialidad_destacada" class="browser-default choice-select choice-filter-specialities" required placeholder="Seleccione una especialidad">
							<option></option>
							@foreach( App\Especialidad::getSpecialties() as $key => $value)
								<option value="{{ $key }}" <%- codigo_especialidad == '{{ $key }}' ? 'selected': ''%> >{{ $value }}
								</option>
							@endforeach
						</select>
						<label>Especialidad:</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="columns tablet-4 tablet-offset-8">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}

	</script>

	<script type="text/template" id="edit-mentor-terms-form-tpl">
    @php
        $terms = App\TerminosCondiciones::termsAndConditions(App\TerminosCondiciones::getTypeTerms('mentoring'));
    @endphp
    @if($terms)
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-terms') ) !!}

			<div class="row">
				<div class="small-12 columns save-section">
					<div id="terms-content" class="terms-content text-center">
						<input type="checkbox" name="aceptacion_terminos" id="aceptacion_terminos" value="true" class="filled-in" required>
						<label for="aceptacion_terminos" class="label-terms dark-text" data-error="Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.">
							{!! transtp('mentoring.create.terms1') !!}
							{!! link_to_route('terminos-mentoria', ' Términos y Políticas', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} {!! transtp('mentoring.create.terms2') !!}
						</label>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
    @endif
	</script>

	<script type="text/template" id="edit-mentor-level-development-form-tpl">

		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-level-development') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<div class="input-field">
						<h4 class="thin-header sky-blue-text">Nivel de desarrollo</h4>
						<p class="clean-bottom gray-dark-text">¿En qué nivel de desarrollo te gustaría apoyar más?</p>
					</div>
					<ul class="no-bullet list-separator">
						@foreach( App\EtapaProyecto::getStages() as $value)
							<li>
								<input type="checkbox" name="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" id="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" value="{{ $value->codigo_etapa_proyecto }}" class="filled-in etapa_proyecto" <%- (_.contains(stage_mentoring, {{ $value->codigo_etapa_proyecto }}) ? 'checked' : '')%> >
								<label for="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}">
									{{ $value->nombre_etapa_proyecto }}
									<span class="text-sm">{{ $value->descripcionetapa_proyecto }}</span>
								</label>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="columns tablet-4 tablet-offset-8">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}

	</script>

	{{-- Info mentor expertise template --}}
	<script type="text/template" id="info-expertise-mentor-tpl">
		<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="expertise">
			<span class="edit-field project-top-info-item text-lg">
				<p class="text-md thin-text clean-bottom dark-text field-text"><%- nombre_especialidad %></p>
				<%= _.isUndefined(nombre_especialidad) || _.isNull(nombre_especialidad) || nombre_especialidad == '' ? '<span class="edit-no-result text-dmd">Especialidad...</span>' : '' %>
			</span>
			<button class="edit-field-button vtop invert-edit-button"><i class="mdi mdi-pencil"></i></button>
		</div>
	</script>

	{{-- Info mentor level development template --}}
	<script type="text/template" id="info-level-development-mentor-tpl">
		<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="level-development">
			<h4 class="thin-header">
				<span class="field-text">Nivel de desarrollo</span>
				<button class="edit-field-button right edit-field"><i class="mdi mdi-pencil"></i></button>
			</h4>
			<ul class="no-bullet list-separator">
				@foreach( App\EtapaProyecto::getStages() as $value)
					<li>
						<input type="checkbox" name="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" id="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}" value="{{ $value->codigo_etapa_proyecto }}" class="filled-in" <%- (_.contains(stage_mentoring, {{ $value->codigo_etapa_proyecto }}) ? 'checked' : '')%> >
						<label for="codigo_etapa_proyecto_{{ $value->codigo_etapa_proyecto }}">
							{{ $value->nombre_etapa_proyecto }}
							<span class="text-sm">{{ $value->descripcionetapa_proyecto }}</span>
						</label>
					</li>
				@endforeach
			</ul>
		</div>
	</script>

	<script type="text/template" id="question-documents-form-tpl">

		{!! Form::open(array('route' => 'adjunto.asesoria.index', 'data-abide' => '', 'id' => 'form-question-documents')) !!}
			<div class="row">
				<div class="small-12 columns">
					<div id="fnuploader-attach-file" class="uploader-attachments"></div>
				</div>
			</div>
				<div class="row save-section">
					<div class="mobile-11 mobile-centered medium-6 medium-offset-3 columns">
						{!! Form::submit('Cargar archivos', array('class' => 'button xsmall expand sky-blue btn-shadow radius')) !!}
					</div>
				</div>
		{!! Form::close() !!}

	</script>

	{{-- Template attachments file uploader --}}
	<script type="text/template" id="qq-attachments-advice-template">
		<div class="qq-uploader-selector qq-uploader qq-uploader-attachments uploader-wrapper" qq-drop-area-text="Documentos">
			<div class="row">
				<div class="small-12 columns">
					<div class="file-field input-field">
						<div id="button-upload" class="qq-upload-button-selector qq-upload-btn-file button left inst-bgcolor-secondary btn-resetc radius">
							<span>Archivo</span>
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text" placeholder="Puedes adjuntar uno o más archivos">
						</div>
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
				<span>Procesando...</span>
				<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
			</span>
			<div class="content-list-attachments scroll-general-v">
				<ul class="qq-upload-list-selector qq-upload-list-attachments list-info-editing list-highlighted gray-dark-text text-sm uploaded-files-list" aria-live="polite" aria-relevant="additions removals">
					<li>
						<div class="qq-progress-bar-container-selector">
							<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
						</div>
						<span class="qq-upload-spinner-selector qq-upload-spinner-circle"></span>
						<a class="preview-link" target="_blank">
							<span class="qq-upload-file-selector qq-upload-file"></span>
                            <span class="qq-edit-filename-icon-selector qq-edit-filename-icon icon-option" aria-label="Edit filename">
                                <i class="mdi mdi-pencil mdi-16 vcenter icon-circle item-label"></i>
                            </span>
						</a>
                        <span class="date-file"></span>
						<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
						<button class="qq-upload-cancel-selector button xtiny alert radius btn-clean-margin cancel-button">Cancelar</button>
						<button class="qq-btn qq-upload-retry-selector qq-upload-retry">procesar de nuevo</button>
						<a id="clean-upload" class="right qq-upload-delete-selector icon-option">
                            <i class="mdi mdi-delete-forever mdi-18 vcenter icon-circle item-label"></i>
                        </a>
						<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
					</li>
				</ul>
			</div>
		</div>
	</script>

	<script type="text/template" id="documents-item-project-tpl">
		<ul class="attached-list-theme">
			<li>
				<span class="left link-attached-theme link-to-theme-video">
					<span class="thumb-icon"></span>
					<span><%= label_documento %></span>
				</span>
				<a href="#" title="Borrar" class="close remove-document">&#215;</a>
			</li>
		</ul>
	</script>

	{{-- form recommendation mentor --}}
    <script type="text/template" id="recommendation-mentor-tpl">
        {!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-recommendation-mentor')) !!}

            <div class="row">
                <div class="tablet-12 columns input-field">
                    <input type="text" id="nombre" name="nombre" required maxlength="200" length="200" class="view-input validate">
                    <label for="nombre">Nombre</label>
                </div>
            </div>

            <div class="row">
                <div class="tablet-12 columns input-field">
                    {!! Form::text('correo_electronico', null, [
                        'id' => 'fld-email-register',
                        'required' => 'required',
                        'class' => 'validate',
                        'pattern' => 'email'
                    ]) !!}
                    <label for="correo_electronico" data-error="E-mail incorrecto.">E-mail</label>
                </div>
            </div>

            <div class="row">
                <div class="tablet-12 columns input-field">
                    <textarea required name="mensaje_recomendacion" id="mensaje_recomendacion" cols="50" rows="4" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
                    <label for="mensaje_recomendacion">mensaje</label>
                </div>
            </div>

            <div class="row">
            	<div class="small-12 columns save-section">
		            <div class="row">
		            	<div class="mobile-12 tablet-6 medium-5 large-4 medium-offset-2 large-offset-4 columns">
			                <a href="#" class="close-reveal-modal button secondary white btn-shadow radius xsmall expand">Cancelar</a>
			            </div>
		                <div class="mobile-12 tablet-6 medium-5 large-4 columns">
		                    {!! Form::submit('Recomendar', array('class' => 'button xsmall sky-blue btn-shadow radius expand')) !!}
		                </div>
		            </div>
            	</div>
            </div>
        {!! Form::close() !!}
	</script>



	<script type="text/template" id="edit-mentor-socials-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-mentor-socials') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<i class="mdi mdi-linkedin prefix"></i>
					<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" placeholder="https://linkedin.com" pattern="url" class="validate">
					<label for="linkedin_usuario" data-error="La url no es valida.">Linkedin:</label>
				</div>
			</div>

			<div class="row">
				<div class="columns tablet-4 tablet-offset-8">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

    {{-- Info Socials Mentor template--}}
	<script type="text/template" id="info-socials-mentor-tpl">
		<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="socials">
			<h4 class="thin-header">
				<span class="field-text">Linkedin</span>
				<button class="edit-field-button right edit-field"><i class="mdi mdi-pencil"></i></button>
			</h4>

		</div>
			<ul class="socials-project-share social-box-icons">
				<li>
					<a href="<%- linkedin_usuario %>" title="Linkedin" class="<%- linkedin_usuario ? 'linkedin' : 'disabled' %>" target="_blank"><i class="mdi mdi-linkedin mdi-24 <%- linkedin_usuario ? 'linkedin' : '' %>" ></i></a>
				</li>
			</ul>
	</script>

	<script type="text/template" id="mentor-attachment-form-tpl">
		<div class="row">
			<div class="small-12 columns">
				<div id="fnuploader-attach-file" class="uploader-attachments"></div>
			</div>
		</div>
	</script>

	{{-- Template attachments file uploader --}}
	<script type="text/template" id="qq-attachments-mentor-template">
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
				<ul class="qq-upload-list-selector qq-upload-list-attachments uploaded-files-list" aria-live="polite" aria-relevant="additions removals">
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
