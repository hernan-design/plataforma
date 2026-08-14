@extends('layout.core.layout')
@section('content')
	<section id="mentoring-wrapper">

		{{-- <a href="#" class="button tiny expand create-mentoring">Solicitud</a> --}}

		<section id="user-wrapper">

			<section id="mentoring-content" class="mentoring-content">
				{{-- Mentoring dinamic content  --}}
				@yield('mentoring.content')
			</section>

			<section id="prueba"></section>

		</section>

		{{-- Modal agendar mentoria --}}
		<div id="modal-schedule-mentoring" class="reveal-modal-main medium clearfix" data-reveal>
			{{-- Title modal --}}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Agendar mentoría</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				{{-- Render calendar mentoring --}}
			</div>
			{{-- Footer modal --}}
			<div class="footer-modal">
				<div class="row">
					<div class="small-12 medium-3 medium-offset-9 columns">
						<a href="#" class="close-reveal-modal button small expand white btn-shadow radius">Cancelar</a>
					</div>
				</div>
			</div>
			<a class="close content-close close-reveal-modal">&#215;</a>

			{{-- Modal to schedule event for adviser --}}
			<div id="modal-schedule-adviser" class="modal-adviser-schedule clearfix" role="dialog">
				{{-- Content modal --}}
				<div class="content-modal"></div>
			</div>
		</div>

		{{-- Content modal Image --}}
		<div id="modal-image-mentor-profile" class="reveal-modal-main xmedium clearfix" data-reveal>
			{{-- Title modal --}}
			{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-mentor-profile-crop'))  !!}
				<div class="title-modal-top">
					<h3 class="inner-title-modal text-center">Editar foto de perfil</h3>
				</div>
				{{-- Content modal --}}
				<div class="content-modal">
					<div class="row">
						<div class="tablet-6 columns">
							<label class="label-terms">Ajustar foto</label>
							<div id="uploader-image-mentor-profile" class="uploader-avatar"></div>
						</div>
						<div class="tablet-6 columns">
							<label class="label-terms">Vista previa</label>
						</div>
					</div>
					<div class="row">
						<div class="tablet-6 columns">
							<div id="image-crop-mentor-profile" class="crop-mentor-profile-img crop-avatar-img">
								<img id="image-mentor-profile-tocrop" src="" class="image-to-crop" />
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
							<div id="preview-mentor-profile-avatar" class="crop-preview-mentor-profile crop-preview-avatar">
								<img id="mentor-profile-preview-tocrop" src="" />
							</div>
						</div>
					</div>
				</div>
				{{-- Footer modal --}}
				<div class="footer-modal">
					<div class="row">
						<div class="tablet-3 tablet-offset-6 columns end">
							<a href="#" class="close-reveal-modal button small expand white btn-shadow radius">Cancelar</a>
						</div>
						<div class="tablet-3 columns">
							<button type="submit" class="button small sky-blue expand btn-shadow radius">Guardar</button>
						</div>
					</div>
				</div>
			{!! Form::close() !!}
			<a class="close content-close close-reveal-modal">&#215;</a>
		</div>

		{{-- Modal base Message Contact --}}
		<div id="modal-mentor-other-specialty-tp" class="reveal-modal-main xsmall clearfix" data-reveal>
			{!! Form::open(array('url' => null, 'data-abide' => '', 'id' => 'form-mentor-other-specialty'))  !!}
				{{-- Title modal --}}
				<div class="title-modal-top">
					<h6 class="inner-title-modal text-center">Escribe cuál es la especialidad.</h6>
				</div>
				{{-- Content modal --}}
				<div class="content-modal">
					<h4 class="thin-header sky-blue-text">¿Cuál?</h4>
					<input type="text" name="descripcion_especialidad" id="descripcion_especialidad" placeholder="¿Cuál?" required class="validate">
				</div>
				{{-- Footer modal --}}
				<div class="footer-modal">
					<div>
						<a href="#" class="button flat small close-reveal-modal btn-clean-margin">Cancelar</a>
						<button type="submit" class="waves-effect waves-light button small sky-blue radius btn-bold btn-clean-margin">Guardar</button>
					</div>
				</div>
			{!! Form::close() !!}
			<a class="close content-close close-reveal-modal">&#215;</a>
		</div>
	</section>

	{{-- Templates edit forms --}}
	@include('core.mentoring.form.templates')


	<script type="text/template" id="mentoring-end-confirm-tpl">
		{{ transtp('mentoring.confirmation.end') }}
	</script>

	<script type="text/template" id="mentoring-accept-confirm-tpl">
		{{ transtp('mentoring.confirmation.accept') }}
	</script>

	<script type="text/template" id="mentoring-refuse-confirm-tpl">
		{{ transtp('mentoring.confirmation.refuse') }}
	</script>
@stop
