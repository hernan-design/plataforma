
{{-- ------------------ Programs Apply Templates JS -------------------- --}}
{{-- Main wrapper apply survey --}}
<script type="text/template" id="wrapper-apply-program-tpl">
	<div id="content-apply-program">
		<div class="row">
            <% if( typeof(texto_alerta_convocaotoria) !== 'undefined' && texto_alerta_convocaotoria) { %>
            <div class="tablet-12 mobile-12 columns" id="anounciement-terms">
                <div class="tablet-12 mobile-12 columns" id="anounciement-calls">
                    <h5 class="text-center">¡ANUNCIO IMPORTANTE!</h5>
                    <%= texto_alerta_convocaotoria  %>
                </div>
            </div>
            <% }%>
			<div class="small-12 columns">
				<div class="content-progress-apply-program panel-info radius">
					<ul class="list-program-apply tabs-progress-bar tabs-route disabled" data-tab data-tab-init="is_hover:false">
						<li class="bar">
							<div style="width: 0%;" class="bar__fill"></div>
						</li>
						<li class="tab-title">
							<a title="" aria-controls="">
								<div class="bullet"></div>
								<label class="text-phase">{{ transtp('programs.step1') }}</label>
							</a>
						</li>
						<li class="tab-title <%- step == 'terminos' ? 'active': '' %>">
							<a href="#apply-terms-program" title="" aria-controls="apply-terms-program" class="get-apply-terms-program">
								<div class="bullet"></div>
								<label class="text-phase">{{ transtp('programs.step2') }}</label>
							</a>
						</li>
						<li class="tab-title <%- step == 'entidad' ? 'active': '' %>">
							<a href="#apply-terms-program" title="" aria-controls="apply-entity-program" class="get-apply-entity-program">
								<div class="bullet"></div>
								<label class="text-phase">{{ transtp('programs.step3') }}</label>
							</a>
						</li>
						<li class="tab-title <%- step == 'formulario' ? 'active': '' %>">
							<a href="#apply-terms-program" title="" aria-controls="apply-survey-program" class="get-apply-survey-program">
								<div class="bullet"></div>
								<label class="text-phase">{{ transtp('programs.step4') }}</label>
							</a>
						</li>
					</ul>
				</div>

				<div id="contents-apply-program" class="tabs-content">
					<section class="content <%- step == 'terminos' ? 'active': '' %>" id="apply-terms-program">
						{{-- Render Terms --}}
					</section>

					<section class="content <%- step == 'entidad' ? 'active': '' %>" id="apply-entity-program">
						{{-- Render Entity --}}
					</section>

					<section class="content <%- step == 'formulario' ? 'active': '' %>" id="apply-survey-program">
						{{-- Render  --}}
					</section>
				</div>
			</div
		</div>

	</div>

	{{-- Modal terms --}}
	<div id="modal-base-terms-program" class="reveal-modal-main xmedium clearfix is-fixed content-scroll" data-reveal>
		{{-- Title modal --}}
		<div class="title-modal-top">
			<h3 class="inner-title-modal text-center">Términos convocatoria</h3>
		</div>
		{{-- Content modal --}}
		<div class="content-modal scroll-general-v">
			<div class="text-md gray-dark-text"><%= terminos_convocatoria %></div>
		</div>
		{{-- Footer modal --}}
		<div class="footer-modal">
			<div class="row">
	            <div class="tablet-3 tablet-offset-9 columns">
	                <a href="#" class="close-reveal-modal button sky-blue medium btn-shadow expand btn-clean-margin radius">Continuar</a>
	            </div>
	        </div>
		</div>
		<a class="close content-close close-reveal-modal">&#215;</a>
	</div>

	{{-- dropdown edit form --}}
	<div id="drop-edit-form-lg" data-dropdown-content class="md-dropdown content radius large" aria-hidden="true"></div>
</script>

{{-- Terms apply step --}}
<script type="text/template" id="terms-apply-program-tpl">
	<div class="content-step-apply-program panel-content with-header radius">
		{{-- header panel --}}
		<div class="header-panel-program content-header-panel no-shadow radius-top">
			<div class="hpanel-title">
				<h3 class="white-text thin-header"><%- nombre_convocatoria %></h3>
			</div>

			<span class="circle-icon-hpanel no-border">
				<i class="mdi mdi-book-open-page-variant"></i>
			</span>
		</div>

		<div class="gray-dark-text">
			{{-- <p><%- resumen_convocatoria %></p> --}}
			<p>{!! transtp('programs.mterms') !!}</p>
		</div>

		{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-terms-apply-program')) !!}
			<div class="row">
				<div class="small-12 columns">
					<div id="terms-content" class="terms-content text-left">
						<input type="checkbox" name="terminos-convocatoria" id="terminos-convocatoria" value="yes" required class="validate" >
						<label for="terminos-convocatoria" class="label-terms dark-text" data-error="Debes aceptar los términos para continuar">
							<% if(!_.isUndefined(contenido_aceptacion_terminos) && !_.isNull(contenido_aceptacion_terminos)) { %>
								<%= contenido_aceptacion_terminos %>
							<% }else{ %>
								Acepto los <a href="" title="Términos" class="sky-blue-text bold-text" data-reveal-id="modal-base-terms-program">Términos y Condiciones</a> de esta convocatoria
							<% } %>
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns save-section text-right">
					<ul class="inline-list-items">
						<li>
							<a href="<%- Route.route('convocatoria.convocatoria', {'convocatoria': url_convocatoria}) %>" class="button xmedium white btn-shadow radius">Cancelar</a>
						</li>
						<li>
							<button class="page-next-apply-program button xmedium sky-blue btn-shadow radius" type="submit" >Continuar</button>
						</li>
					</ul>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</script>

{{-- Entity apply step --}}
<script type="text/template" id="entity-apply-program-tpl">
	<div class="content-step-apply-program panel-content with-header radius">
		{{-- header panel --}}
		<div class="header-panel-program content-header-panel no-shadow radius-top">
			<div class="hpanel-title">
				<h3 class="white-text thin-header"><%- nombre_convocatoria %></h3>
			</div>

			<span class="circle-icon-hpanel no-border">
				<i class="mdi mdi-file-check"></i>
			</span>
		</div>

		<p class="gray-dark-text">{!! transtp('programs.choose') !!}</p>

		<div class="row col-equal-height valign-center">
			<div class="mobile-9 small-11 columns input-field">
				<select id="codigo_usuario" name="codigo_usuario" class="choice-entities-program" required data-placeholder="Elige un proyecto" placeholder="Elige un proyecto">
					<option value="" disabled selected>{{ transtp('programs.selectprogram') }}</option>
					@foreach( App\Entidad::getEntitysList() as $value)
						<option value="{{ TuProyecto::encryptSrcParams([$value->key]) }}">{{ $value->value }}</option>
					@endforeach
				</select>
			</div>
			<div class="mobile-3 small-1 columns">
				 <a class="btn-floating small btn-small waves-effect waves-light inst-bgcolor-secondary icon-circle white-text" data-tooltip aria-haspopup="true" title="Crear entidad" data-reveal-id="modal-base-create-entity" data-options="disable_for_touch:true"><i class="mdi mdi-plus"></i></a>
			</div>
		</div>
	</div>

	<div id="content-data-entity-program" class="content-step-apply-program panel-content radius">
		{{-- Render entity data --}}
	</div>
</script>
<script type="text/template" id="entity-edit-program-tpl">
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-edit-entity-program')) !!}
		<div class="row">
			<div class="small-12 columns">

				<div id="wrap-edit-entity-program">
					{{-- Render entity form --}}
				</div>

				<div class="row">
					<div class="small-12 tablet-6 columns">
						<label class="label single text-xlg inst-color-secondary">Imagen:</label>
						<div id="program-entity-edit-image" class="wrapper-image-edit image-area-drop image-profile-entity input-field">
							<img src="<%- imagen_usuario %>" alt="<%- nickname_usuario %>" title="<%- nickname_usuario %>" class="image-entity-program" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
							<% if(owner){ %>
								<button id="change-img-entity-program" class="edit-photo change-photo icon-circle white xsmall icon-30 circle-shadow" data-tooltip aria-haspopup="true" title="Editar imagen" data-options="disable_for_touch:true">
									<div class="edit-photo-content">
										<i class="mdi mdi-pencil gray-light"></i>
									</div>
								</button>
							<% } %>
						</div>
						<input type="hidden" id="imagen_usuario" name="imagen_usuario" value="<%- imagen_usuario %>" required>
						<small class="error">Campo obligatorio</small>
					</div>

					<div class="small-12 tablet-6 columns">
						<label class="label single text-xlg inst-color-secondary">Video:</label>
						<div class="wrapper-video-edit video-content-preview video-profile-entity">
							<div class="flex-video widescreen vimeo">
								<i class="mdi mdi-file-video icon-placeholder"></i>
								<iframe id="video-project-preview" class="preview-video preview-video-project" src="<%- window.Misc.convertVideoEmbed(video_entidad,'embed') %>" scrolling="no" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

								<% if(owner){ %>
									<button class="edit-video change-video icon-circle white xsmall icon-30 circle-shadow edit-field change-video-entity-program" data-dropdown="drop-edit-form-lg" aria-controls="drop-edit-form-lg" aria-expanded="false" data-options="disable_for_touch:true;align:top" data-edit-template="video-project" data-tooltip aria-haspopup="true" title="Agregar video">
										<div class="edit-video-content">
											<i class="mdi mdi-pencil gray-light"></i>
										</div>
									</button>
								<% } %>
							</div>
						</div>
						<input type="hidden" name="video_entidad" class="input-video-project" value="<%- video_entidad %>">
						<small class="error">Campo obligatorio</small>
					</div>
				</div>

			</div>
		</div>

		<div class="row">
			<div class="small-12 columns save-section text-right">
				<ul class="inline-list-items">
					<li>
						<a href="<%- Route.route('convocatoria.convocatoria', {'convocatoria': url_convocatoria}) %>" class="button xmedium white btn-shadow radius">Cancelar</a>
					</li>
					<li>
						<button class="page-next-apply-program button xmedium sky-blue btn-shadow radius" type="submit" >Continuar</button>
					</li>
				</ul>
			</div>
		</div>
	{!! Form::close() !!}
</script>
<script type="text/template" id="invalid-message-apply-program-tpl">
	<div class="">
		<ul class="inline-list-grid">
			<li class="has-image"><i class="mdi mdi-clipboard-check mdi-36 vcenter sky-blue"></i></li>
			<li><span class="lighter-text gray-base-text"><%= message %></span></li>
		</ul>
    </div>
    <% if(!no_cancel){ %>
        <div class="row">
            <div class="small-12 columns save-section text-right">
                <ul class="inline-list-items">
                    <li>
                        <a href="<%- Route.route('convocatoria.convocatoria', {'convocatoria': url_convocatoria}) %>" class="button xmedium white btn-shadow radius">Cancelar</a>
                    </li>
                </ul>
            </div>
        </div>
    <% } %>
</script>

<script type="text/template" id="invalid-message-apply-program-user-tpl">
	<div class="">
		<i class="mdi mdi-clipboard-check mdi-36 vcenter sky-blue"></i>
		<span class="lighter-text gray-base-text">Ya estas inscrito en esta convocatoria.</span>
	</div>
	<div class="row">
		<div class="small-12 columns save-section text-right">
			<ul class="inline-list-items">
				<li>
					<a href="<%- Route.route('convocatoria.convocatoria', {'convocatoria': url_convocatoria}) %>" class="button xmedium white btn-shadow radius">Cancelar</a>
				</li>
			</ul>
		</div>
	</div>
</script>

{{-- User apply step --}}
<script type="text/template" id="user-apply-program-tpl">
	<div class="content-step-apply-program panel-content with-header radius">
		{{-- header panel --}}
		<div class="header-panel-program content-header-panel no-shadow radius-top">
			<div class="hpanel-title">
				<h3 class="white-text thin-header"><%- nombre_convocatoria %></h3>
			</div>

			<span class="circle-icon-hpanel no-border">
				<i class="mdi mdi-clipboard-account"></i>
			</span>
		</div>

		<div id="content-data-user-program" class="">
			{{-- Render user data --}}
		</div>
	</div>
</script>
<script type="text/template" id="user-edit-program-tpl">
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-edit-user-program')) !!}
		<div class="row">
			<div class="columns tablet-4 input-field">
				<label>Nombre </label>
				<input type="text" name="nombre_usuario" value="<%- nombre_usuario %>" required pattern="[a-zA-Z]+">
			</div>
			<div class="columns tablet-4 input-field">
				<label>Primer Apellido</label>
				<input type="text" name="primer_apellido_persona" value="<%- primer_apellido_persona %>" required pattern="[a-zA-Z]+">
			</div>
			<div class="columns tablet-4 input-field">
				<label>Segundo Apellido</label>
				<input type="text" name="segundo_apellido_persona" value="<%- segundo_apellido_persona %>" pattern="[a-zA-Z]+">
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-4 input-field">
				<select name="genero_persona" required data-placeholder="Seleccione género" placeholder="Seleccione género">
					<option value="" disabled selected>Seleccione género</option>
					@foreach( App\Usuario::getArrayGender() as $key => $value)
						<option value="{{ $key }}" <%- genero_persona == '{{ $key }}' ? 'selected': ''%>>{{ $value }}</option>
					@endforeach
				</select>
				<label>Sexo</label>
			</div>
			<div class="columns tablet-8 input-field">
				<select name="codigo_ciudad" class="browser-default choice-select" required data-placeholder="Seleccione una ubicación">
					<option value=""></option>
					@foreach( App\Ciudad::getCities() as $city)
						<option value="{{ $city->key }}" <%- codigo_ciudad == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
					@endforeach
				</select>
				<label>Ciudad</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns">
				<label class="label single text-xlg inst-color-secondary">Imagen:</label>
				<div id="program-user-edit-image" class="wrapper-image-edit image-area-drop image-profile-user input-field">
					<img src="<%- imagen_usuario %>" alt="<%- nickname_usuario %>" title="<%- nickname_usuario %>" class="image-user-program" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
					<% if(owner){ %>
						<button id="change-img-user-program" class="edit-photo change-photo icon-circle white xsmall icon-30 circle-shadow" data-tooltip aria-haspopup="true" title="Editar imagen" data-options="disable_for_touch:true">
							<div class="edit-photo-content">
								<i class="mdi mdi-pencil gray-light"></i>
							</div>
						</button>
					<% } %>
				</div>
				<input type="hidden" id="imagen_usuario" name="imagen_usuario" value="<%- imagen_usuario %>">
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns save-section text-right">
				<ul class="inline-list-items">
					<li>
						<a href="<%- Route.route('convocatoria.convocatoria', {'convocatoria': url_convocatoria}) %>" class="button xmedium white btn-shadow radius">Cancelar</a>
					</li>
					<li>
						<button class="page-next-apply-program button xmedium sky-blue btn-shadow radius" type="submit" >Continuar</button>
					</li>
				</ul>
			</div>
		</div>
	{!! Form::close() !!}
</script>

{{-- Form apply step --}}
<script type="text/template" id="survey-apply-program-tpl">
	<div class="content-step-apply-program panel-content with-header radius">
		{{-- header panel --}}
		<div class="header-panel-program content-header-panel no-shadow radius-top">
			<div class="hpanel-title">
				<h3 class="white-text thin-header"><%- nombre_convocatoria %></h3>
			</div>

			<span class="circle-icon-hpanel no-border">
				<i class="mdi mdi-file-check"></i>
			</span>
		</div>

		{{-- Render survey --}}
		<section id="survey-content" class="survey-content">
			{{-- Render survey --}}
		</section>
	</div>
</script>

{{-- form edit video entity --}}
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
