<div class="content-form-login">
	<div class="row">
		@if(App\RegistroSesion::getLoginSocial())
			<div class="tablet-6 columns">
				<div class="content-social-register text-center">
					<label class="label title text-center text-md gray-base-text gray-dark-text">Inicia sesión a través de:</label>

						<ul class="mobile-block-grid-1 list-register-social text-center">
							<li>
								<a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="login_facebook button xmedium expand social-btn-facebook btn-lowerc radius btn-shadow social-btn-register text-left">
									Facebook
									<i class="right mdi mdi-facebook icon-btn mdi-16"></i>
								</a>
							</li>
							<li>
								<a href="{{ route('auth.provider', ['provider' => 'linkedin']) }}" class="login_linkedin button xmedium expand social-btn-linkedin btn-lowerc radius btn-shadow social-btn-register text-left">
									Linkedin
									<i class="right mdi mdi-linkedin-box icon-btn mdi-16"></i>
								</a>
							</li>
							<li>
								<a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="login_twitter button xmedium expand btn-lowerc radius btn-shadow social-btn-twitter social-btn-register text-left">
									X
									<i class="right mdi mdi-close-outline icon-btn mdi-16"></i>
								</a>
							</li>
						</ul>
					<p class="text-info clean-bottom">
						<span class="gray-dark-text text-sm">(Nunca compartiremos tu información con terceros)</span>
					</p>
				</div>
			</div>
		@endif

		<script>
			function onSubmit(token) {
				document.getElementById("form-login-email").submit();
			}
		</script>
		<div class="{{ App\RegistroSesion::getLoginSocial() ? 'tablet-6' : 'small-12' }} columns">
			<div class="content-login-inner">
				<div class="text-center">
					<label class="label title text-center text-md gray-base-text gray-dark-text">Ingresa con tu e-mail y contraseña</label>
				</div>
				{!! Form::open(['route' => 'login', 'id' => 'form-login-email', 'name' => 'form-login-email', 'data-abide' => '']) !!}
					<div class="row">
						<div class="small-12 columns input-field">
							<i class="mdi mdi-email prefix"></i>
							{!! Form::email('correo_electronico', Input::old('correo_electronico'), [
								'id' => 'correo_electronico',
								'class' => 'validate',
								'required' => 'required'
							])
							!!}
							<label for="correo_electronico" data-error="E-mail incorrecto.">E-mail</label>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns input-field">
							<i class="mdi mdi-lock prefix"></i>
							{!! Form::password('password', [
								'class' => 'validate',
								'required' => 'required',
								'autocomplete' => 'off'
							])
							!!}
							<label for="password" data-error="Campo obligatorio.">Contraseña</label>
						</div>
					</div>

					@if(isset($errors) && $errors->any())
						<br>
						<div class="row">
							<div class="small-12 columns">
								<div data-alert class="notice-box-tp alert" style="display:block;">
									<i class="icon-alert"></i>
									<span>
										<ul>
											@foreach ($errors->all() as $error)
												<li>{!! $error !!}</li>
											@endforeach
										</ul>
									</span>
								</div>
							</div>
						</div>
					@endif

					<div class="row">
						<div class="small-12 columns">
							{!! Form::submit(trans('app.login'), ['class' => 'button xmedium sky-blue expand btn-lowerc btn-shadow radius']) !!}
						</div>
					</div>

					<div class="row">
						<div class="small-12 columns text-center">
							{!! link_to('password/email', trans('user.forgot.password'), array(
								'class' => 'text-sm sky-blue-text lighter-text'
							)) !!}
						</div>
					</div>

					<div class="widget-login-recaptcha-new" data-key-recaptcha="{{ env('RECAPTCHA_SITE_KEY', '6Ld4HuQtAAAAAEgDP3VE3SpcymOzvL_yxvN8At-v') }}"></div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<div id="terms-policy-login">
				{{-- render terms policy --}}
			</div>
		</div>
	</div>
</div>
