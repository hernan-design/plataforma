{{-- Stages --}}
{{--*/ $stages = App\EtapaProyecto::getStages(); /*--}}
{{--*/ $privacy = App\PrivacidadContenido::getPrivaciesContent(); /*--}}

{{-- New Templates for project --}}

<script type="text/template" id="edit-project-name-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-name') ) !!}
		<div class="row">
			<div class="small-12 columns input-field">
				<input type="text" name="nombre_usuario" id="nombre_usuario" value="<%- nombre_usuario %>" required class="validate" length="200">
				<label for="nombre_usuario">Nombre (*)</label>
			</div>
		</div>
		<input type="hidden" id="tags_usuario" name="tags_usuario" class="edit-field-text" value="">

		<div class="row">
			<div class="tablet-4 tablet-offset-8 columns input-field">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-project-location-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-location') ) !!}
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
			<div class="columns tablet-4 tablet-offset-8">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-project-industry-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-industry') ) !!}
		<div class="row">
			<div class="small-12 columns input-field">
				<select name="codigo_categoria_proyecto" required data-placeholder="{{ transtp('entities.project.placeholder.industry') }}" placeholder="{{ transtp('entities.project.placeholder.industry') }}">
					<option value="" disabled selected>{{ transtp('entities.project.placeholder.industry') }}</option>
					@foreach( App\CategoriaProyecto::getCategoriesList() as $category)
						<option value="{{ $category->key }}" <%- codigo_categoria_proyecto == '{{ $category->key }}' ? 'selected': ''%> >{{ $category->value }}</option>
					@endforeach
				</select>
				<label>{{ transtp('entities.project.industry') }} (*)</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-4 tablet-offset-8">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-project-tags-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-tags') ) !!}
		<div class="row col-equal-height">
			<div class="mobile-7 tablet-7 columns">
				<input type="text" id="tags_usuario" name="tags_usuario" class="edit-field-text" value="" placeholder="Nombre">
			</div>
			<div class="mobile-5 tablet-5 columns vbottom">
				<div class="row">
					<div class="tablet-6 columns">
						<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					</div>
					<div class="tablet-6 columns">
						{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
</script>


<script type="text/template" id="edit-project-video-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-video-project') ) !!}
		<div class="row">
			<div class="small-6 columns">
				<div class="video-content-preview flex-video widescreen vimeo">
					<i class="icon icon-cam-video icon-placeholder"></i>
					<iframe id="video-project-preview" class="preview-video" src="<%- window.Misc.convertVideoEmbed(video_entidad,'embed') %>" scrolling="no" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
			</div>
			<div class="small-6 columns input-field">
				<input type="text" name="video_entidad" id="video-project-txt" value="<%- video_entidad %>" placeholder="">
				<label for="video-project-txt">Vídeo de Youtube:</label>
			</div>
		</div>
		<div class="row">
			<div class="columns tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-socials-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-socials') ) !!}

		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-close-outline prefix"></i>
				<input type="text" name="twitter_usuario" id="twitter_usuario" value="<%- twitter_usuario %>" placeholder="https://X.com" pattern="url" class="validate">
				<label for="twitter_usuario" data-error="La url no es valida.">X:</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-facebook prefix"></i>
				<input type="text" name="facebook_usuario" id="facebook_usuario" value="<%- facebook_usuario %>" placeholder="https://www.facebook.com" pattern="url" class="validate">
				<label for="facebook_usuario" data-error="La url no es valida.">Facebook:</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-instagram prefix"></i>
				<input type="text" name="instagram_usuario" id="instagram_usuario" value="<%- instagram_usuario %>" placeholder="https://instagram.com" pattern="url" class="validate">
				<label for="instagram_usuario" data-error="La url no es valida.">Instagram</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-linkedin prefix"></i>
				<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" placeholder="https://linkedin.com" pattern="url" class="validate">
				<label for="linkedin_usuario" data-error="La url no es valida.">Linkedin:</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns input-field">
				<i class="prefix">
					<svg xmlns="http://www.w3.org/2000/svg" style="
					position: absolute;
					width: 2.5rem;
					font-size: 2rem;
					transition: color .2s; width="1em" height="1em" viewBox="0 0 24 24"><path fill="#f60" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07"/></svg>
				</i>
				<input type="text" name="tiktok_usuario" id="tiktok_usuario" value="<%- tiktok_usuario %>" placeholder="https://www.tiktok.com/" pattern="url" class="validate">
				<label for="tiktok_usuario" data-error="La url no es valida.">TikTok:</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-project-interests-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-interests') ) !!}
		<div class="row">
			<div class="tablet-12 tablet-centered columns input-field">
				<select name="codigo_sector_interes" id="codigo_sector_interes" class="browser-default choice-select" required data-placeholder="Selecciona un sector económico" placeholder="Selecciona un sector económico">
					<option value=""></option>
					@foreach( App\SectorInteres::getInterests() as $interest)
						<option value="{{ $interest->codigo_sector_interes }}">{{ $interest->nombre_sector_interes }}</option>
					@endforeach
				</select>
				<label for="">Sectores económicos:</label>
			</div>
		</div>
		<div class="row">
			<div class="tablet-12 tablet-centered columns">
				<div class="row">
					<div class="tablet-3 tablet-offset-6 columns">
						<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					</div>
					<div class="tablet-3 columns">
						{!! Form::submit('Agregar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-members-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-members') ) !!}
		<div class="row">
			<div class="tablet-12 tablet-centered columns">
				<div class="row">
					<div class="small-12 columns">
						<h5 class="field-text">Invita a una persona</h5>
					</div>
				</div>
				<div class="row">
					<div class="small-8 columns input-field">
						<input type="text" id="email" name="email" required pattern="email" class="validate">
						<label for="email" data-error="E-mail incorrecto">E-mail</label>
					</div>
					<div class="small-4 columns input-field">
						<select name="codigo_rol_usuario_grupo_insti" required data-placeholder="Selecciona un rol" placeholder="Selecciona un rol">
							<option value="" disabled selected>Selecciona un rol</option>
							@foreach( App\RolUsuarioGrupo::getUserGroupRol() as $roleuser)
								<option value="{{ $roleuser->key }}">{{ $roleuser->value }}</option>
							@endforeach
						</select>
						<label>Roles:</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 medium-6 columns input-field">
						<input type="text" id="nombre_usuario" name="nombre_usuario" required maxlength="200" length="200" class="view-input validate">
						<label for="nombre_usuario">Nombre</label>
					</div>
					<div class="small-12 medium-6 columns input-field">
						<input type="text" id="primer_apellido_persona" name="primer_apellido_persona" required maxlength="200" length="200" class="view-input validate">
						<label for="primer_apellido_persona">Apellido</label>
					</div>
					<input type="hidden" name="segundo_apellido_persona" placeholder="Apellido">
				</div>

				<div class="row">
					<div class="small-12 columns input-field">
						<textarea name="mensaje_invitacion" id="mensaje_invitacion" rows="2" data-abide-validator="maxLength" length="200" class="materialize-textarea validate"></textarea>
						<label for="mensaje_invitacion">Mensaje de invitación</label>
					</div>
				</div>

				<div class="row">
					<div class="tablet-3 tablet-offset-6 columns input-field">
						<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					</div>
					<div class="tablet-3 columns input-field">
						{!! Form::submit('Invitar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-description-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-description') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 tablet-10 columns input-field">
				<section id="form-project-editor">
					{{-- Render component pulse-editor --}}
					<input type="hidden" name="descripcion_entidad" value="<%- descripcion_entidad %>" required>
				</section>
			</div>
			<div class="mobile-3 tablet-2 columns">
				<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="interest-item-project-tpl">
	<em><%- nombre_sector_interes %></em>
	<a href="#" title="Borrar" class="close remove-interest">&#215;</a>
</script>

<script type="text/template" id="edit-project-sponsor-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-sponsors') ) !!}
		<div class="row">
			<div class="tablet-12 tablet-centered columns input-field">
				{!! Form::select('codigo_patrocinador', ['' => ''] + App\Patrocinador::getSponsors(), null, [
					'class'=> 'browser-default choice-select',
					'data-placeholder' => 'Selecciona un patrocinador',
					'placeholder' => 'Selecciona un patrocinador',
					'required' => 'required'])
				!!}
				<label>Patrocinadores:</label>
			</div>
		</div>
		<div class="row">
			<div class="tablet-12 tablet-centered columns">
				<div class="row">
					<div class="tablet-3 tablet-offset-6 columns">
						<button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button>
					</div>
					<div class="tablet-3 columns">
						{!! Form::submit('Agregar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-summary-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-summary') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 tablet-10 columns">
				<textarea name="biografia_usuario" rows="4" placeholder="Ingresa un resumen" class="edit-field-text materialize-textarea" required data-abide-validator="maxWords" data-maxlen="200"><%- typeof biografia_usuario != 'undefined' ? biografia_usuario : '' %></textarea>
			</div>
			<div class="mobile-3 tablet-2 columns">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-pageweb-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-pageweb') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 tablet-10 columns">
				<input
					name="pagina_web_usuario"
					rows="4"
					placeholder="URL de maximo 50 carácteres"
					class="edit-field-text materialize-textarea"
					required
					data-abide-validator="maxLength"
					maxlength="50"
					data-maxlen="50"
					value="<%- typeof pagina_web_usuario != 'undefined' ? pagina_web_usuario : '' %>"
				>
				<p  class="inst-color-secondary"
					id="errorUrl"
					style="display: none; font-size: .75rem; margin-bottom: 0.5rem;">
					Url invalida
				</p>

			</div>
			<div class="mobile-3 tablet-2 columns">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>
<script type="text/template" id="edit-project-numerowhatsapp-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-numerowhatsapp') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 tablet-10 columns">
				@if (App\RegistroSesion::getInstitutionSlug() == 'rutan')
				<input
					name="numero_whatsapp"
					rows="4"
					placeholder="Ingreso número de celular de la empresa"
					class="edit-field-text materialize-textarea"
					data-abide-validator="maxLength"
					maxlength="10"
					required
					data-maxlen="10"
					value="<%- typeof numero_whatsapp != 'undefined' ? numero_whatsapp : '' %>"
				/>
				<small class="error">¡El número de celular es obligatorio!</small>
				@else
				<input
				name="numero_whatsapp"
				rows="4"
				placeholder="Ingreso número whatsapp"
				class="edit-field-text materialize-textarea"
				required
				data-abide-validator="maxLength"
				maxlength="10"
				data-maxlen="10"
				value="<%- typeof numero_whatsapp != 'undefined' ? numero_whatsapp : '' %>"
				/>
				@endif
				<p  class="inst-color-secondary"
					id="errorNumWS"
					style="display: none; font-size: .75rem; margin-bottom: 0.5rem;">
					Número incorrecto
				</p>
			</div>
			<div class="mobile-3 tablet-2 columns">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-mail-contact-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-summary') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 tablet-10 columns">
				<textarea name="correo_contacto" rows="4" placeholder="Ingresa un correo" class="edit-field-text-mail-contact materialize-textarea" required data-abide-validator="maxWords" data-maxlen="200"><%- typeof correo_contacto != 'undefined' ? correo_contacto : '' %></textarea>
			</div>
			<div class="mobile-3 tablet-2 columns">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-project-documents-form-tpl">

	{!! Form::open(array('route' => 'adjunto.usuario.index', 'data-abide' => '', 'id' => 'form-edit-project-documents')) !!}
		<div class="row">
			<div class="small-12 medium-9 medium-centered columns">
				<p class="text-center">Archivos adjuntos</p>
				<% if(owner){ %>
					<small class="description-field-form text-center">{{ transtp('entities.project.documents.description') }}</small>
				<% } %>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns">
				<div id="fnuploader-attach-file" class="uploader-attachments"></div>
			</div>
		</div>
		<% if(owner){ %>
			<div class="row save-section">
				<div class="mobile-11 tablet-3 mobile-centered columns">
					{!! Form::submit('Cargar archivos', array('class' => 'button small expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		<% } %>
	{!! Form::close() !!}

</script>

{{-- Template attachment evaluation file uploader --}}
<script type="text/template" id="edit-evaluation-documents-form-tpl">
	<div class="row">
		<div class="small-12 columns">
			<div id="fnuploader-attach-file" class="uploader-attachments"></div>
		</div>
	</div>
</script>

{{-- Template attachments file uploader --}}
<script type="text/template" id="qq-attachments-template">

	<div class="qq-uploader-selector qq-uploader qq-uploader-attachments" qq-drop-area-text="Documentos">
		<div class="row">
			<div class="mobile-12 small-10 tablet-4 tablet-centered columns">
				<div id="button-upload" class="qq-upload-button-selector qq-upload-btn-file button xsmall expand sky-blue btn-shadow radius">
					<div>Selecciona tu archivo</div>
				</div>
			</div>
		</div>
		<div id="bar-progress" class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
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
						<div class="tablet-6 columns">
							<span class="qq-upload-spinner-selector qq-upload-spinner-circle"></span>
							<img class="qq-thumbnail-selector" qq-max-size="50" qq-server-scale>
							<span id="preview-name-archive"></span>
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
						<div class="tablet-6 columns">
							<div class="row">
								<div class="small-6 columns">
									<label class="label-codigo-documento dark-text">Tipo de documento
										<select name="codigo_documento" id="codigo_documento" class="browser-default" required data-placeholder="Tipo" placeholder="Tipo">
											@foreach( App\Documento::getDocuments('entity') as $document)
												<option value="{{ $document->codigo_documento }}">{{ $document->nombre_documento }}</option>
											@endforeach
										</select>
									</label>
								</div>
								<div class="small-6 columns">
									<label class="label-codigo_privacidad dark-text">Privacidad
										<select name="codigo_privacidad_contenido" id="codigo_privacidad_contenido" class="browser-default" required data-placeholder="Privacidad" placeholder="Privacidad">
											@foreach( App\PrivacidadContenido::getPrivacyContent() as $item)
												<option value="{{ $item->codigo_privacidad_contenido }}" {{ App\PrivacidadContenido::getPrivacy('public') == $item->codigo_privacidad_contenido ? 'selected' : '' }}>{{ $item->nombre_privacidad_contenido }}</option>
											@endforeach
										</select>
									</label>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</script>

{{-- Template attachments evaluations file uploader --}}
<script type="text/template" id="qq-attachments-evaluation-template">

	<div class="qq-uploader-selector qq-uploader qq-uploader-attachments" qq-drop-area-text="Documentos">
		<div class="row">
			<div class="mobile-12 small-10 tablet-4 tablet-centered columns">
				<div id="button-upload" class="qq-upload-button-selector qq-upload-btn-file button xsmall expand sky-blue btn-shadow radius">
					<div>Selecciona tu archivo</div>
				</div>
			</div>
		</div>
		<div id="bar-progress" class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
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
						<div class="tablet-8 columns">
							<span class="qq-upload-spinner-selector qq-upload-spinner-circle"></span>
							<img class="qq-thumbnail-selector" qq-max-size="50" qq-server-scale>
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

{{-- Template attachments file final report uploader --}}
<script type="text/template" id="qq-attachments-final-report-template">

	<div class="qq-uploader-selector qq-uploader-one-attachment">
		<div class="content-attachment scroll-general-v">
			<ul class="no-bullet inline-list-grid align-center">
				<li class="text-right">
					<ul class="qq-upload-list-selector qq-upload-list-attachments" aria-live="polite" aria-relevant="additions removals">
						<li>
							<div class="qq-progress-bar-container-selector">
								<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
							</div>
							<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
							<a class="preview-link dark-text" target="_blank">
								<span class="qq-upload-file-selector qq-upload-file text-md"></span>
							</a>
							<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
							<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
							<span class="qq-upload-size-selector qq-upload-size"></span>
							<button type="button" class="qq-btn qq-upload-cancel-selector tip-top radius" title="Cancelar" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
								<i class="mdi mdi-close sky-blue mdi-24"></i>
							</button>
							<button type="button" class="qq-btn qq-upload-retry-selector tip-top radius" title="Procesar de nuevo" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
								<i class="mdi mdi-reload sky-blue mdi-24"></i>
							</button>
							<button type="button" class="qq-btn qq-upload-delete-selector tip-top radius" title="Eliminar" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
								<i class="mdi mdi-delete sky-blue mdi-24"></i>
							</button>
							<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
						</li>
						</li>
					</ul>
				</li>
				<li class="text-right has-image no-wrap">
					<div class="qq-upload-button-selector qq-upload-btn-icon action-hover-circle">
						<i class="mdi mdi-upload"></i>
					</div>
					<a type="button" role="button" class="qq-download-button action-hover-circle qq-hide" title="Descargar adjunto" target="_blank">
						<i class="mdi mdi-download"></i>
					</a>
					<span class="message-no-attachment text-md gray-dark-text qq-hide">¡No hay adjunto!</span>
				</li>
			</ul>
		</div>

		{{-- <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Close</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog> --}}
	</div>
</script>

	{{-- --------------Templates for preview project data--------------- --}}

{{-- member item project --}}
<script type="text/template" id="member-item-project-tpl">
	<div class="item-wrap-list radius">
		<ul class="inline-list-grid align-center">
			<li class="has-image">
				<a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="item-thumb" title="<%- window.Misc.strToNickname(nickname_usuario) %>">
					<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size70">
				</a>
			</li>
			<li>
				<ul class="no-bullet">
					<li>
						<h6 class="carduser-namename-user bold-header gray-dark-text clean-header is-hovered"><a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario }) ) %>" title="<%- nombre_usuario %>" class="is-hovered"><%- nombre_usuario %></a></h6>
					</li>
					<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
						<li><span class="light-text text-md linear-span"><%- nombre_ciudad %>, <%- distrito_ciudad %></span></li>
					<% } %>
					<li>
						<span class="text-md linear-span gray-dark-text"><%- nombre_rol_usuario_grupo %></span>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" title="Borrar" class="close remove-member">&#215;</a>
				<ul id="buttons-connect-friendship" class="stages-friendship-user right">
					{{-- Render buttoms follows --}}
				</ul>
			</li>
		</ul>
	</div>
</script>

{{-- sponsor item project --}}
<script type="text/template" id="sponsor-item-project-tpl">

	<% if (!_.isUndefined(url_patrocinador) && !_.isNull(url_patrocinador) && url_patrocinador.length) { %>
		<a href="<%- url_patrocinador %>" title="<%- nombre_patrocinador %>" target="_blank">
			<img src="<%- imagen_patrocinador %>" alt="<%- nombre_patrocinador %>">
		</a>
		<% }else{ %>
		<img src="<%- imagen_patrocinador %>" alt="<%- nombre_patrocinador %>" title="<%- nombre_patrocinador %>">
	<% } %>

	<a href="#" title="Borrar" class="close close-editing remove-sponsor">&#215;</a>
</script>

{{-- document item --}}
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

{{-- Image main Project template --}}
<script type="text/template" id="main-image-project-tpl">
	<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" title="<%- nombre_usuario %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
	<% if(owner){ %>
		<button id="change-image-project" class="edit-photo change-photo small">
			<div class="edit-photo-content">
				<i class="mdi mdi-camera mdi-24 vcenter"></i>
				<span>Añadir una Imagen</span>
				<span class="editing-photo-message">Cambiar Imagen</span>
			</div>
		</button>
	<% } %>
</script>

{{-- Info Basic Project template --}}
<script type="text/template" id="info-basic-project-tpl">
	<h3 class="title-detail-product-main lighter-header clean-header dark-text edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="name-project">
		<span class="field-text"><%- nombre_usuario %></span>
		<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
	</h3>
</script>

{{-- Info summary project template --}}
<script type="text/template" id="info-summary-project-tpl">
	<div class="content-summary-project field-for-edit edit-field clearfix" data-edit-template="summary">
		<ul class="field-and-button-edit align-top no-bullet">
			<li>
				<p class="text-summary-project block-text-medium project-top-info-item prepared-to-edit"> <%= !_.isNull(biografia_usuario) && biografia_usuario.length ? biografia_usuario : '' %>  <%= !_.isNull(biografia_usuario) && !biografia_usuario.length && owner ? '<span class="edit-no-result text-dmd">Ingresa un resumen</span>' : '' %></p>
			</li>
			<li class="has-image">
				<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>

{{-- Info page web template --}}
<script type="text/template" id="info-pageweb-project-tpl">
	<div class="content-pageweb-project field-for-edit edit-field clearfix" data-edit-template="pageweb">
		<ul class="field-and-button-edit align-top no-bullet">
			<li>
				<p
					class="text-pageweb-project block-text-medium project-top-info-item prepared-to-edit">
					<span class="icon-data-basic"><i class="mdi mdi-web  vcenter mdi-21 gutter-right  gray-base-text"></i> </span>
					<%= !_.isNull(pagina_web_usuario) && pagina_web_usuario.length ? pagina_web_usuario : '' %>
					<%= !_.isNull(pagina_web_usuario) && !pagina_web_usuario.length && owner ?
					'<span class="edit-no-result text-dmd">Ingresa URL</span>' : '' %>
				</p>
			</li>
			<li class="has-image">
				<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>
<script type="text/template" id="info-numerowhatsapp-project-tpl">
	<div
		class="content-numerowhatsapp-project field-for-edit edit-field clearfix"
		data-edit-template="numerowhatsapp">
		<ul class="field-and-button-edit align-top no-bullet">
			<li>
				<p
					class="text-numerowhatsapp-project block-text-medium project-top-info-item prepared-to-edit">
					<span class="icon-data-basic">
						<i class="mdi mdi-whatsapp  vcenter mdi-21 gutter-right  gray-base-text"></i>
					</span>
					<%= !_.isNull(numero_whatsapp) && numero_whatsapp > 0 ? numero_whatsapp : '' %>
					<%= _.isNull(numero_whatsapp) && !numero_whatsapp > 0 && owner ?
					'<span class="edit-no-result text-dmd">Ingresa número de whatsapp</span>' : '' %>
				</p>
			</li>
			<li class="has-image">
				<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>

{{-- Info mail contact template --}}
<script type="text/template" id="info-mail-contact-project-tpl">
	<div class="content-mail-contact-project field-for-edit edit-field clearfix" data-edit-template="mailContact">
		<ul class="field-and-button-edit align-top no-bullet">
			<li>
				<p class="text-mail-contact-project block-text-medium project-top-info-item prepared-to-edit"> <%= !_.isNull(correo_contacto) && correo_contacto.length ? correo_contacto : '' %>  <%= !_.isNull(correo_contacto) && !correo_contacto.length && owner ? '<span class="edit-no-result text-dmd">Ingresa un correo de contacto</span>' : '' %></p>
			</li>
			<li class="has-image">
				<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>

{{-- Info Location Project template --}}
<script type="text/template" id="info-location-project-tpl">
	<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="location-project">
		<span class="gray-light-text text-lg field-text">
			<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
				<i class="mdi mdi-map-marker-radius mdi-21 vcenter"></i>
				<span class="bold-text dark-text"><%- nombre_ciudad %></span>, <%- distrito_ciudad %>
			<% }else { %>
				<span class="edit-no-result text-dmd">Ciudad, Departamento</span>
			<% } %>
		</span>
		<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
	</div>
</script>

{{-- Info industry project template --}}
<script type="text/template" id="info-industry-project-tpl">
	<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="industry-project">
		<span class="project-top-info-item text-md field-text"><%- nombre_categoria_proyecto %><%= (_.isUndefined(nombre_categoria_proyecto) || _.isNull(nombre_categoria_proyecto)) && owner ? '<span class="edit-no-result project-top-info-item text-dmd">Categoria...</span>' : '' %></span>
		<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
	</div>
</script>

{{-- Info Stages Project template--}}
<script type="text/template" id="info-stage-project-tpl">
	<div>
		<% if(typeof stage !== 'undefined' && stage ) { %>
			<span><%- stage %> </span>
		<% } %>
	</div>
</script>

{{-- Info Tags Project template--}}
<script type="text/template" id="info-tag-project-tpl">
	<div class="field-for-edit edit-field" data-edit-template="tags">
		<% if(tags.length) { %>
			<ul class="tags-icon-list field-text project-top-info-item">
				<% _.each(tags.split(','), function (tag) { %>
					<li><span class="tag-item"><%- tag %></span></li>
				<% }) %>
			</ul>
		<% }else if(owner) { %>
			<span class="edit-no-result project-top-info-item text-dmd">Agrega tus tags</span>
		<% } %>
		<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
	</div>
	<div class="field-editing content-form-editing">
		{{-- Render template edit form --}}
	</div>
</script>

{{-- Info Video Project template--}}
<script type="text/template" id="info-video-project-tpl">
	<div class="video-content-preview wrapper-video-edit flex-video widescreen vimeo">
		<i class="icon icon-cam-video icon-placeholder"></i>
		<iframe id="video-project-preview" class="preview-video" src="<%- window.Misc.convertVideoEmbed(video_entidad,'embed') %>" scrolling="no" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

		<% if(owner){ %>
			<button class="edit-video change-video small edit-field" data-dropdown="drop-edit-form-lg" aria-controls="drop-edit-form-lg" aria-expanded="false" data-options="align:right;" data-edit-template="video-project">
				<div class="edit-video-content">
					<i class="icon icon-cam-video icon-24 vcenter"></i>
					<span>Añadir un vídeo</span>
					<span class="editing-video-message">Cambiar vídeo</span>
				</div>
			</button>
		<% } %>
	</div>
</script>

{{-- Info Socials Project template--}}
<script type="text/template" id="info-socials-project-tpl">
	<ul class="socials-project-share social-box-icons">
		<li>
			<a href="<%- twitter_usuario %>" title="X" class="<%- twitter_usuario ? 'twitter' : 'disabled' %>" target="_blank"><i class="mdi mdi-close-outline mdi-24 <%- twitter_usuario ? 'twitter' : '' %>"></i></a>
		</li>
		<li>
			<a href="<%- facebook_usuario %>" title="Facebook" class="<%- facebook_usuario ? 'facebook' : 'disabled' %>" target="_blank"><i class="mdi mdi-facebook mdi-24 <%- facebook_usuario ? 'facebook' : '' %>"></i></a>
		</li>
		<li>
			<a href="<%- instagram_usuario %>" title="Instagram" class="<%- instagram_usuario ? 'instagram' : 'disabled' %>" target="_blank"><i class="mdi mdi-instagram mdi-24 <%- instagram_usuario ? 'instagram' : '' %>"></i></a>
		</li>
		<li>
			<a href="<%- linkedin_usuario %>" title="Linkedin" class="<%- linkedin_usuario ? 'linkedin' : 'disabled' %>" target="_blank"><i class="mdi mdi-linkedin mdi-24 <%- linkedin_usuario ? 'linkedin' : '' %>" ></i></a>
		</li>
		<li>
			<a href="<%- tiktok_usuario %>" title="TikTok" class="<%- tiktok_usuario ? 'tiktok' : 'disabled' %>" target="_blank" style="font-size: 0;" ><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"><path fill="<%- tiktok_usuario ? '#000' : '#8D8D8D' %>" d="M12.525.02c1.31-.02 2.61-.01 3.91-.02c.08 1.53.63 3.09 1.75 4.17c1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97c-.57-.26-1.1-.59-1.62-.93c-.01 2.92.01 5.84-.02 8.75c-.08 1.4-.54 2.79-1.35 3.94c-1.31 1.92-3.58 3.17-5.91 3.21c-1.43.08-2.86-.31-4.08-1.03c-2.02-1.19-3.44-3.37-3.65-5.71c-.02-.5-.03-1-.01-1.49c.18-1.9 1.12-3.72 2.58-4.96c1.66-1.44 3.98-2.13 6.15-1.72c.02 1.48-.04 2.96-.04 4.44c-.99-.32-2.15-.23-3.02.37c-.63.41-1.11 1.04-1.36 1.75c-.21.51-.15 1.07-.14 1.61c.24 1.64 1.82 3.02 3.5 2.87c1.12-.01 2.19-.66 2.77-1.61c.19-.33.4-.67.41-1.06c.1-1.79.06-3.57.07-5.36c.01-4.03-.01-8.05.02-12.07"/><i class="fa-brands fa-tiktok mdi-24 <%- tiktok_usuario ? 'tiktok' : '' %>" ></i></svg></a>
		</li>
	</ul>
	<button class="edit-field-button edit-field vbottom" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="socials"><i class="mdi mdi-pencil"></i></button>
</script>

<script type="text/template" id="info-description-project-tpl">
	<div class="content-description-project clearfix" data-edit-template="description">
		<div class="prepared-to-edit text-md"><%= window.Misc.stripTags(descripcion_entidad) ? descripcion_entidad : '' %><%= !window.Misc.stripTags(descripcion_entidad) && owner ? '<div class="center"><span class="edit-no-result text-dmd">Agrega una descripción...</span></div>' : '' %></div>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>
