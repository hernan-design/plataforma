@extends('core.middleware.steps', ['step' => 'profile'])

@section('step')
	<section id="general-user-info" class="content active">
		{{-- Render info template --}}
	</section>

	<script type="text/template" id="step-profile-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-step-profile') ) !!}
            @include("core.middleware.profileForm.{$templateForm}")
		{!! Form::close() !!}
	</script>

	{{-- Image Profile template --}}
	<script type="text/template" id="main-image-profile-tpl">
		<div class="upload-profile-img-box">
			<img src="<%- imagen_usuario %>" alt="<%- nickname_usuario %>" title="<%- nickname_usuario %>" class="upload-profile-img" onerror="if (this.src != '{{ config('tuproyecto.avatar_image') }}') this.src = '{{ config('tuproyecto.avatar_image') }}';">
			<input type="hidden" id="imagen_usuario" name="imagen_usuario" value="<%- imagen_usuario %>">
		</div>
		<a id="change-image-step-profile" class="upload-img-icon-circle icon-circle small white-text btn-floating btn-small waves-effect waves-light bg-secondary-color"><i class="mdi mdi-plus"></i></a>
	</script>

	{{-- Professions template --}}
	<script type="text/template" id="professions-profile-tpl">
		<div class="row">
			<div class="tablet-12 columns input-field">
				<select name="codigo_profesion_persona" id="codigo_profesion_persona" style="max-width:100%;" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('profesiones.index') ) %>" data-initial-value="<%- typeof(codigo_profesion_persona) !== 'undefined' ? codigo_profesion_persona : '' %>" data-placeholder="Seleccione" placeholder="Seleccione" required>
				</select>
				<label for="codigo_profesion_persona">Profesión</label>
			</div>
		</div>
	</script>

	{{-- Identification template --}}
	<script type="text/template" id="identification-user-tpl">
		<input type="text" name="identificacion_usuario" id="identificacion_usuario" value="<%- typeof(identificacion_usuario) !== 'undefined' ? identificacion_usuario : '' %>" class="<%- typeof(classInput) !== 'undefined' ? classInput : '' %> validate text-right" pattern=".{4,}" maxlength="13" required>
        <label for="identificacion_usuario">Número de identificación (*)</label>
        <small class="error">¡Mínimo 4 caracteres!</small>
	</script>
@stop
