<script type="text/template" id="edit-user-name-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-name') ) !!}

		<div class="row">
			<div class="columns small-12 input-field">
				<input type="text" name="nombre_usuario" id="nombre_usuario" value="<%- nombre_usuario %>" required>
				<label for="nombre_usuario">Nombre</label>
			</div>
		</div>

		<div class="row">
			<div class="columns small-6 input-field">
				<input type="text" name="primer_apellido_persona" id="primer_apellido_persona" value="<%- primer_apellido_persona %>" required>
				<label for="primer_apellido_persona">Primer apellido</label>
			</div>
			<div class="columns small-6 input-field">
				<input type="text" name="segundo_apellido_persona" id="segundo_apellido_persona" value="<%- segundo_apellido_persona %>">
				<label for="segundo_apellido_persona">Segundo apellido</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-user-location-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-location') ) !!}
		<div class="row">
			<div class="columns small-12 input-field">
				<input type="text" name="profesion_usuario" id="profesion_usuario" value="<%- profesion_usuario %>" required>
				<label for="profesion_usuario">Titulo profesional</label>
			</div>
		</div>

		<div class="row">
			<div class="columns small-12 input-field">
				<input type="text" name="nickname_usuario" id="nickname_usuario" value="<%- nickname_usuario %>" pattern="nickname" class="validate change-nickname-profile" data-abide-validator="usernameAvailable" maxlength="15" required>
				<label for="nickname_usuario">Nickname</label>
				<span class="nickname-field-message success-text text-sm hidesoft"></span>
				<span class="nickname-field-path success-text text-sm"><%- window.Misc.urlFull(Route.route('usuario.nickname', {'nickname': nickname_usuario})) %></span>
			</div>
		</div>

		<div class="row">
			<div class="columns small-6 input-field">
				<select name="codigo_ciudad" class="browser-default choice-select chosen-single chosen-single-with-deselect" required data-placeholder="Selecciona una ubicación">
					<option value=""></option>
					@foreach( App\Ciudad::getCities() as $city)
						<option value="{{ $city->key }}" <%- codigo_ciudad == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
					@endforeach
				</select>
				<label>Ubicación:</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-user-biography-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-biography') ) !!}
		<div class="row col-equal-height">
			<div class="mobile-9 small-9 tablet-10 columns">
				<textarea name="biografia_usuario" id="biografia_usuario" rows="3" class="edit-field-text" required data-abide-validator="maxLength" length="235" ><%- biografia_usuario %></textarea>
			</div>
			<div class="mobile-3 small-3 tablet-2 columns vbottom">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-user-basic-data-form-tpl">

	{!! Form::open( ['action' => null, 'data-abide' => '', 'id' => 'form-edit-user-basic-data'] ) !!}
		<div class="row">
			<div class="small-6 columns input-field">
				<input
					type="text"
					name="pagina_web_usuario"
					id="pagina_web_usuario"
					value="<%- pagina_web_usuario %>"
					style="margin-bottom: 0;"
					placeholder="http://www.dominio.com"
					title="Incluye http:// ó https://"
				>
				<label for="pagina_web_usuario">Página web</label>
				<p  class="inst-color-secondary"
					id="errorUrl"
					style="display: none; font-size: .75rem; margin-bottom: 0.5rem;">
					Url invalida, debe incluir http:// o https://<br>Ejem: https://www.dominio.com
				</p>
			</div>
			<div class="tablet-6 columns input-field">
				<label><%- window.moment(fecha_nacimiento_usuario).format('D MMMM YYYY') %></label>
				<label class="active">Fecha de nacimiento</label>
			</div>
		</div>

		<div class="row">
			<div class="small-6 columns input-field">
				<label><%- correo_electronico %></label>
				<label class="active">E-mail</label>
			</div>
			<div class="small-4 columns input-field">
				<input type="text" name="direccion_usuario" id="direccion_usuario" value="<%- direccion_usuario %>">
				<label for="direccion_usuario">Dirección domicilio</label>
			</div>
			<div class="small-2 columns input-field">
				<input type="text" name="barrio_usuario" id="barrio_usuario" value="<%- barrio_usuario %>">
				<label for="barrio_usuario">Barrio</label>
			</div>
		</div>

		<div class="row">
			<div class="small-6 columns input-field">
				<div><input type="text" name="movil_usuario" id="movil_usuario" value="<%- movil_usuario %>" class="phone-mask-co validate" required></div>
				<label class="active" for="movil_usuario">Celular</label>
			</div>

			<div class="small-6 columns input-field">
				<div><input type="text" name="telefono_usuario" id="telefono_usuario" value="<%- telefono_usuario %>" class="phone-mask-co validate"></div>
				<label class="active" for="telefono_usuario">Teléfono Fijo</label>
			</div>
		</div>

		<div class="row">
			<div class="small-6 columns input-field">
				<select name="genero_persona" class="" required data-placeholder="Seleccione" placeholder="Seleccione">
					<option value="" disabled selected>Seleccione</option>
					@foreach( App\Usuario::getArrayGender() as $key => $value)
						<option value="{{ $key }}" <%- genero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
				<label>Sexo</label>
			</div>
			<div class="small-6 columns input-field">
				<select name="estado_civil_persona" class="" required data-placeholder="Seleccione estado civil" placeholder="Seleccione estado civil">
					<option value="" disabled selected>Seleccione estado civil</option>
					@foreach( App\Usuario::$maritalStatus as $key => $value)
						<option value="{{ $key }}" <%- estado_civil_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
				<label>Estado civil:</label>
			</div>
		</div>

		<div class="row">
			<div class="small-6 columns input-field">
				<label><%- identificacion_usuario %></label>
				<label class="active">Número de identificación</label>
			</div>
		</div>

		<div class="row">
			<div class="tablet-3 tablet-offset-9 columns">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-user-socials-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-socials') ) !!}

		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-close-outline prefix"></i>
				<input type="text" name="twitter_usuario" id="twitter_usuario" value="<%- twitter_usuario %>" placeholder="https://X.com" pattern="url" class="validate">
				<label for="twitter_usuario" data-error="La url no es válida.">X:</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-facebook prefix"></i>
				<input type="text" name="facebook_usuario" id="facebook_usuario" value="<%- facebook_usuario %>" placeholder="https://www.facebook.com" pattern="url" class="validate">
				<label for="facebook_usuario" data-error="La url no es válida.">Facebook:</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns input-field">
				<i class="mdi mdi-linkedin prefix"></i>
				<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" placeholder="https://linkedin.com" pattern="url" class="validate">
				<label for="linkedin_usuario" data-error="La url no es válida.">Linkedin:</label>
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
				<label for="tiktok_usuario" data-error="La url no es válida.">TikTok:</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

<script type="text/template" id="edit-user-experience-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-experience') ) !!}
		<div class="row col-equal-height valign-bottom">
			<div class="mobile-9 small-9 tablet-10 columns input-field">
				<section id="form-project-editor">
					{{-- Render component pulse-editor --}}
					<input type="hidden" name="experiencia_usuario" value="<%- experiencia_usuario %>" required data-abide-validator="maxWords" data-maxlen="200">
				</section>
			</div>
			<div class="mobile-3 small-3 tablet-2 columns vbottom">
				<button class="button tiny expand white radius close-editing">Cancelar</button>
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue radius btn-clean-margin')) !!}
			</div>
		</div>
	{!! Form::close() !!}

</script>

<script type="text/template" id="edit-user-reasons-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-reasons') ) !!}
		<div class="row">
			<div class="tablet-8 tablet-centered columns input-field">
				<select name="codigo_razon_registro" data-placeholder="Selecciona una razón" placeholder="Selecciona una razón" required>
					<option value="" disabled selected>Selecciona una razón</option>
					@foreach( App\RazonRegistro::getReasons() as $key => $value)
						<option value="{{ $key }}" <%- genero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
				<label>Razones:</label>
			</div>
		</div>
		<div class="row">
			<div class="tablet-8 tablet-centered columns">
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

<script type="text/template" id="edit-user-education-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-education') ) !!}
		<div class="row">
			<div class="tablet-5 columns input-field">
				<select name="codigo_nivel_educacion" data-placeholder="Seleccione nivel de educación" placeholder="Seleccione nivel de educación" required>
					<option value="" disabled selected>Seleccione nivel educación</option>
					@foreach( App\NivelEducacion::getLevels() as $level)
						<option value="{{ $level->codigo_nivel_educacion }}">{{ $level->nombre_nivel_educacion }}</option>
					@endforeach
				</select>
				<label>Nivel educación:</label>
			</div>
			<div class="tablet-7 columns input-field">
				{!! Form::text('nombre_nivel_educacion', null, [
					'required' => 'required']
				) !!}
				<label for="nombre_nivel_educacion">Disciplina académica</label>
			</div>
		</div>
		<div class="row">
			<div class="tablet-12 columns">
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

<script type="text/template" id="edit-user-specialities-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-specialities') ) !!}
		<div class="row">
			<div class="tablet-12 tablet-centered columns input-field">
				<select name="codigo_especialidad" class="browser-default choice-select" required data-placeholder="Seleccione una especialidad" placeholder="Seleccione una especialidad">
					<option></option>
					@foreach( App\Especialidad::getSpecialties( App\Especialidad::getSpecialty('other') ) as $key => $value)
						<option value="{{ $key }}" <%- genero_persona == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
					@endforeach
				</select>
				<label>Especialidades:</label>
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

<script type="text/template" id="edit-user-interests-form-tpl">

	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-user-interests') ) !!}
		<div class="row">
			<div class="tablet-12 tablet-centered columns input-field">
				<select name="codigo_sector_interes" class="browser-default choice-select" required data-placeholder="Seleccione sector económico" placeholder="Seleccione sector económico">
					<option></option>
					@foreach( App\SectorInteres::getInterests() as $interest)
						<option value="{{ $interest->codigo_sector_interes }}">{{ $interest->nombre_sector_interes }}</option>
					@endforeach
				</select>
				<label>Sectores económicos de interés:</label>
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

{{-- Image Profile template --}}
<script type="text/template" id="main-image-profile-user-tpl">
	<img src="<%- imagen_usuario %>" alt="<%- nickname_usuario %>" title="<%- nickname_usuario %>" class="image-user-profile" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
	<% if(owner){ %>
		<button id="change-image-step-profile" class="edit-photo change-photo small">
			<div class="edit-photo-content">
				<i class="mdi mdi-camera mdi-24 vcenter"></i>
				<span>Añadir una Imagen</span>
				<span class="editing-photo-message">Cambiar Imagen</span>
			</div>
		</button>
	<% } %>
	<input type="hidden" id="imagen_usuario" name="imagen_usuario" value="<%- imagen_usuario %>">
</script>

<script type="text/template" id="reason-item-user-tpl">
	<em><%- nombre_razon_registro %></em>
	<a href="#" title="Borrar" class="close remove-reason">&#215;</a>
</script>

<script type="text/template" id="education-item-user-tpl">
	<em><%- nombre_nivel_educacion %></em>
	<em><%- disciplina %></em>

	<a href="#" title="Borrar" class="close remove-education">&#215;</a>
</script>

<script type="text/template" id="speciality-item-user-tpl">
	<em><%- nombre_especialidad %></em>
	<a href="#" title="Borrar" class="close remove-speciality">&#215;</a>
</script>

<script type="text/template" id="interest-item-user-tpl">
	<em><%- nombre_sector_interes %></em>
	<a href="#" title="Borrar" class="close remove-interest">&#215;</a>
</script>

{{-- Info Basic Profile template --}}
<script type="text/template" id="info-basic-profile-tpl">
	<h3 class="title-detail-product-main lighter-text dark-text clean-top edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="name">
		<span class="field-text"><%- nombre_usuario %></span>
		<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
	</h3>
</script>

{{-- Info Location Profile template --}}
<script type="text/template" id="info-location-profile-tpl">
	<div class="edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="location">
		<span class="edit-field project-top-info-item text-lg">
		<span><%- profesion_usuario %></span>
		<span class="slah-separator">&frasl;</span>
			<span id="project-category-edit" class="gray-light-text field-text"><em><%- nickname_usuario %></em><%= !nickname_usuario.length ? '<span class="edit-no-result project-top-info-item text-dmd">Categoria...</span>' : '' %></span>
			<span class="slah-separator">&frasl;</span>
			<span class="gray-light-text field-text">
				<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
					<i class="mdi mdi-map-marker-radius mdi-21 vcenter"></i>
					<%- nombre_ciudad %>, <%- nombre_pais %>
				<% }else { %>
					<span class="edit-no-result text-dmd">Ciudad, País</span>
				<% } %>
			</span>
		</span>
		<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
	</div>
</script>

{{-- Info summary Profile template --}}
<script type="text/template" id="info-summary-profile-tpl">
	<div id="user-biography-container" class="editable-item">
		<div class="content-description-profile field-for-edit edit-field clearfix" data-edit-template="biography">
			<p class="block-text-xmedium"><%- window.Misc.maxLen(biografia_usuario, 235) %></p>
			<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
		</div>
		<div class="field-editing">
			{{-- Render template edit form--}}
		</div>
	</div>
</script>

<script type="text/template" id="info-basic-user-profile-tpl">
	<div class="panel-info with-title <%- owner ? 'editable' : '' %>">
		<div id="user-basic-container" class="editable-item clearfix">
			<h5 class="title-panel text-left">
				<span class="field-text">Actualización Datos</span>
				<button class="edit-field-button edit-field right" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" aria-expanded="false" data-options="align:left;" data-edit-template="basic"><i class="mdi mdi-pencil"></i></button>
			</h5>
		</div>
		<ul class="data-basic-profile tablet-block-grid-2">
			<li>
				<div class="item-basic-profile">
					<span class="icon-data-basic"><i class="mdi mdi-web"></i></span>
					<em>
						<% if (!_.isUndefined(pagina_web_usuario) && !_.isNull(pagina_web_usuario) && window.Misc.isUrl(pagina_web_usuario)) { %>
							<a href="<%- pagina_web_usuario %>" target="_blank"><%- pagina_web_usuario %></a>
						<% } %>
					</em>
				</div>
			</li>
			<li>
				<div class="item-basic-profile">
					<span class="icon-data-basic"><i class="mdi mdi-cake"></i></span>
					<em><%- window.moment(fecha_nacimiento_usuario, "YYYY MM DD").format("Do MMMM") %></em>
				</div>
			</li>

			</li>
			<% if(owner) { %>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-email"></i></span>
						<em><%- correo_electronico %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-home"></i></span>
						<em><%- direccion_usuario %> <%- barrio_usuario %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-cellphone-android"></i></span>
						<em><%- movil_usuario %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-phone"></i></span>
						<em><%- telefono_usuario %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-gender-male-female"></i></span>
						<em><%- nombre_genero %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-human-male-female"></i></span>
						<em><%- nombre_estado_civil %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
				<li>
					<div class="item-basic-profile">
						<span class="icon-data-basic"><i class="mdi mdi-account-key"></i></span>
						<em><%- identificacion_usuario %></em>
						<span class="right light-text"><i class="mdi mdi-lock"></i></span>
					</div>
				</li>
			<% } %>
		</ul>
		<% if(owner) { %>
			<br>
			<em class="text-md light-text">Los campos marcados con (<i class="mdi mdi-lock"></i>) no son visibles al público y son de uso exclusivo para programas y convocatorias.</em>
		<% } %>
	</div>
</script>
