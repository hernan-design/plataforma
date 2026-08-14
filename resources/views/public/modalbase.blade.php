<div id="modal-base-tp" class="reveal-modal-main xsmall clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h4 class="inner-title-modal text-center">Personas a quienes les gusta esto</h4>
	</div>
	{{-- Content modal --}}
	<div class="content-modal scroll-general-v">
		{{-- Render Template js --}}
	</div>
	{{-- Footer modal --}}
	<div class="footer-modal hidesoft"></div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

<div id="modal-base-material" class="reveal-modal-main xsmall clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h4 class="inner-title-modal text-center">Personas a las que les gusta esto</h4>
	</div>
	{{-- Content modal --}}
	<div class="content-modal scroll-general-v">
		{{-- Render Template js --}}
	</div>
	{{-- Footer modal --}}
	<div class="footer-modal hidesoft"></div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal base Message Contact --}}
<div id="modal-base-message-tp" class="reveal-modal-main small clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h6 class="inner-title-modal text-center"></h6>
	</div>
	{{-- Content modal --}}
	<div class="content-modal">
		{{-- Render Template js --}}
	</div>
	{{-- Footer modal --}}
	<div class="footer-modal hidesoft"></div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal base confirm --}}
<div id="modal-base-confirm-tp" class="reveal-modal-main xsmall dialog-confirm clearfix" data-reveal data-noclose data-noscroll>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<ul class="inline-list-grid">
			<li><h4 class="inner-title-modal text-left"></h4></li>
			<li class="short-col"><i class="right mdi mdi-alert mdi-24"></i></li>
		</ul>
	</div>
	{{-- Content modal --}}
	<div class="content-modal">
		{{-- Render Template js --}}
	</div>
	{{-- Footer modal --}}
	<div class="footer-modal">
        <a href="#" class="button flat small close-reveal-modal btn-clean-margin">Cancelar</a>
        <a href="#" class="confirm-action button flat-inst-secondary small btn-clean-margin action">Continuar</a>
	</div>
</div>

{{-- Modal base create entity --}}
<div id="modal-base-create-entity" class="reveal-modal-form xlarge clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h6 class="inner-title-modal text-left">
			<i class="icon-title-modal mdi mdi-lock mdi-21 vtop"></i>
			{{ transtp('entities.create') }}
		</h6>
	</div>
	<div id='content-modal-create-entity'>
		{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-entity')) !!}
			{{-- Content modal --}}
			<div class="content-modal scroll-general">
				<div class="row">
					<div class="small-12 columns">

						<div class="row">
							<div class="small-12 columns input-field">
								<select id="codigo_clase_empre_insti" name="codigo_clase_empre_insti" class="choice-filter-class" required data-placeholder="Selecciona un tipo" placeholder="Selecciona un tipo">
									<option value="" selected disabled>Selecciona un tipo</option>
									@foreach( App\ClaseEmprendimiento::getClasses() as $value)
										<option value="{{ $value->codigo_clase_empre_insti }}">{{ $value->class_name }}</option>
									@endforeach
								</select>
								<label>Tipo:</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div id="class-complementary-container">
									{{-- Render info complementary --}}
								</div>
							</div>
						</div>
					</div>

				</div>
				{{-- Render Template js --}}
			</div>
			{{-- Footer modal --}}
			<div class="footer-modal">
				<div class="row">
					<div class="small-12 tablet-4 medium-3 tablet-centered columns">
						{!! Form::submit(transtp('entities.submit'), ['class' => 'button medium sky-blue expand btn-shadow radius']) !!}
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal to confirm schedule event for adviser --}}
<div id="modal-confirm-schedule" class="modal-adviser-schedule" role="dialog">
	{{-- Content modal --}}
	<div class="content-modal"></div>
</div>

{{-- Modal create calendar event --}}
<div id="modal-create-calendar-event" class="modal-event-calendar" role="dialog">
	{{-- Content modal --}}
	<div class="content-modal"></div>
</div>

{{-- Modal request mentor advisory --}}
<div id="modal-request-mentor-advisory" class="modal-request-mentor-advisory  reveal-modal-form xsmall clearfix" data-reveal>
	{{-- Title modal --}}
	<div class="title-modal-top no-padding">
		<div class="row gray-dark-bg"  style="padding:1rem;">
			<div class="large-11 center-block">
				<div class="row">
					<div class="large-2 mobile-3 columns">

						<img src="{{  Auth::user() ? Auth::user()->imagen_usuario : '' }}"  class="img-carduser size80 rounded-img right" onerror="imageDefault(this,'{{ config('tuproyecto.avatar_image') }}')">
					</div>
					<div class="large-10 mobile-9 columns">
						<small class="text-md white-text">Solicitud de asesoría/mentoría</small><br>
						@if(isset($mentorUser) && $mentorUser )
							<small class="text-xlg white-text">{{ $mentorUser->nombre_usuario . ' ' . $mentorUser->primer_apellido_persona . ' ' . $mentorUser->segundo_apellido_persona }}</small><br>
							<input type="hidden" name="codigo_usuario" id="mentor" value="{{  TuProyecto::encryptSrcParams([$mentorUser->codigo_usuario]) }}">
						@endif
					</div>
				</div>
			</div>

		</div>
	</div>
	{{-- Content modal --}}
	<div class="content-modal no-padding"></div>
	{{-- Footer modal --}}
	<div class="footer-modal hidesoft"></div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal create calendar event --}}
<div id="modal-create-request-mentoring" class="modal-request-mentoring" role="dialog">
	{{-- Content modal --}}
	<div class="content-modal"></div>
</div>

{{-- Modal login --}}
<div id="modal-login" class="reveal-modal-form {{ App\RegistroSesion::getLoginSocial() ? 'xmedium' : 'tiny' }} clearfix scroll-general-v" data-reveal>
	{{-- Content modal --}}
	<div class="content-modal {{-- scroll-general-v --}}">
		<div class="advise-register text-center" style="margin-top: 25px;">
			<span class="">Si no tienes una cuenta, </span>
			<a href="{{ URL::route('register') }}" class="button tiny sky-blue btn-lowerc btn-shadow radius bold-btn">Regístrate</a>
		</div>
		<hr>
		<div id="login-section" class="wrapper-signin">
			@include ('auth.loginform')
		</div>
	</div>
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal user vote --}}
<div id="modal-user-vote" class="reveal-modal-form tiny clearfix scroll-general-v" data-reveal>
	{{-- Content modal --}}
	<div class="content-modal {{-- scroll-general-v --}}">
		<div id="vote-section" class="wrapper-vote">
			@include ('core.project.vote.voteform')
		</div>
	</div>
	<a class="close close-reveal-modal">&#215;</a>
</div>


{{-- terms policy templates  --}}
<script type="text/template" id="terms-policy-login-tpl">
	<p class="text-info clean-bottom text-center">
		<span class="gray-dark-text text-sm"><strong>Al registrarse en esta plataforma, aceptas nuestros {!! link_to_route('terminos', 'términos de uso', [], ['class' => 'sky-blue-text', 'target' => '_blank']) !!} y {!! link_to_route('privacidad', 'política de datos', [], ['class' => 'sky-blue-text', 'target' => '_blank']) !!}.<strong></span>
	</p>
</script>

{{-- Modal base change avatar --}}
<div id="modal-chage-avatar" class="reveal-modal-main xmedium clearfix" data-reveal>
	{{-- Title modal --}}
	{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-avatar-crop'))  !!}
		<div class="title-modal-top">
			<h3 class="inner-title-modal text-center">Editar foto de perfil</h3>
		</div>
		{{-- Content modal --}}
		<div class="content-modal">
			<div class="row">
				<div class="tablet-6 columns">
					<label class="label-terms">Ajustar foto</label>
					<div id="uploader-image-avatar" class="uploader-avatar"></div>
				</div>
				<div class="tablet-6 columns">
					<label class="label-terms">Vista previa</label>
				</div>
			</div>
			<div class="row">
				<div class="tablet-6 columns">
					<div id="image-crop-avatar" class="crop-avatar-img">
						<img id="image-user-tocrop" src="" class="img-avatar-to-crop" />
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
					<div id="preview-user-avatar" class="crop-preview-avatar">
						<img id="avatar-preview-tocrop" src="" />
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
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal base project image --}}
<div id="modal-image-project" class="reveal-modal-main xmedium clearfix" data-reveal>
	{{-- Title modal --}}
	{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-project-upload-crop'))  !!}
		<div class="title-modal-top">
			<h3 class="inner-title-modal text-center">Editar imagen</h3>
		</div>
		{{-- Content modal --}}
		<div class="content-modal">
			<div class="row">
				<div class="tablet-6 columns">
					<label class="label-terms">Ajustar la imagen</label>
					<div id="uploader-image-project" class="uploader-img-project uploader-image"></div>
				</div>
				<div class="tablet-6 columns">
					<label class="label-terms">Vista previa</label>
					<span class="text-xmd light-text">Tamaño real de la imagen (770px X 460px)</span>
				</div>
			</div>
			<div class="row">
				<div class="tablet-6 columns">
					<div id="image-crop-project" class="crop-project-img crop-load-img">
						<img id="img-project-tocrop" src="" class="image-to-crop" />
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
					<div id="preview-project-avatar" class="crop-preview-project crop-preview-img">
						<img id="project-preview-tocrop" src="" />
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
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- Modal crop image gallery --}}
<div id="modal-image-gallery" class="reveal-modal-main xmedium clearfix" data-reveal>
	{{-- Title modal --}}
	{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-gallery-crop'))  !!}
		<div class="title-modal-top">
			<h3 class="inner-title-modal text-center">Editar imagen</h3>
		</div>
		{{-- Content modal --}}
		<div class="content-modal">
			<div class="row">
				<div class="tablet-6 columns">
					<label class="label single bold-text inst-color-secondary">Ajustar la imagen</label>
					<div id="uploader-image-gallery" class="uploader-img-gallery uploader-image"></div>
				</div>
				<div class="tablet-6 columns">
					<label class="label single bold-text inst-color-secondary">Vista previa</label>
					<span class="text-xmd light-text">Tamaño real de la imagen (646px X 374px)</span>
				</div>
			</div>
			<div class="row">
				<div class="tablet-6 columns">
					<div id="image-crop-gallery" class="crop-gallery-img crop-load-img">
						<img id="image-gallery-tocrop" src="" class="image-to-crop" />
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
					<div id="preview-gallery-avatar" class="crop-preview-gallery crop-preview-img">
						<img id="gallery-preview-tocrop" src="" />
					</div>
				</div>
			</div>
		</div>
		{{-- Footer modal --}}
		<div class="footer-modal">
			<a href="#" class="close-reveal-modal">Cancelar</a>
			<button type="submit" class="button small sky-blue radius">Guardar</button>
		</div>
	{!! Form::close() !!}
	<a class="close close-reveal-modal">&#215;</a>
</div>

{{-- modal crop image event --}}
<div id="modal-image-event" class="reveal-modal-main xmedium clearfix" data-reveal>
	{{-- Title modal --}}
	{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-event-crop'))  !!}
	<div class="title-modal-top">
		<h3 class="inner-title-modal text-center">Imagen evento</h3>
	</div>
	{{-- Content modal --}}
	<div class="content-modal">
		<div class="row">
			<div class="tablet-6 columns">
				<label class="label single bold-text inst-color-secondary">Ajustar la imagen</label>
				<div id="uploader-image-event" class="uploader-img-event uploader-image"></div>
			</div>
			<div class="tablet-6 columns">
				<label class="label single bold-text inst-color-secondary">Vista previa</label>
				<span class="text-xmd light-text">Tamaño real de la imagen (780px X 520px)</span>
			</div>
		</div>
		<div class="row">
			<div class="tablet-6 columns">
				<div id="image-crop-event" class="crop-event-img crop-load-img">
					<img id="image-event-tocrop" src="" class="image-to-crop" />
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
				<div id="preview-event-avatar" class="crop-preview-event crop-preview-img">
					<img id="event-preview-tocrop" src="" />
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
