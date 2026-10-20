{!! Form::open(array('route' => 'usuario.store', 'id' => 'form-new-account', 'data-abide' => '')) !!}
	<div class="row">
		@if(App\RegistroSesion::getLoginSocial())
			<div class="tablet-6 columns">
				<div class="content-social-register text-center">
					<label class="label title text-center text-md gray-base-text gray-dark-text">Regístrate a través de:</label>
					<ul class="social-login mobile-block-grid-1 list-register-social text-center">
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
					<p class="text-info clean-bottom text-center">
						<span class="gray-dark-text text-sm">(Nunca compartiremos tu información con terceros)</span>
					</p>
				</div>
			</div>
		@endif
		<div class="{{ App\RegistroSesion::getLoginSocial() ? 'tablet-6' : 'small-12' }} columns">
			<div class="content-login-inner">
				<div class="text-center">
					<label class="label title text-center text-md gray-base-text gray-dark-text">Crea una cuenta completando los siguientes campos:</label>
				</div>
				<div class="row">
					<div class="small-12 columns input-field">
						<i class="mdi mdi-email prefix"></i>
						{!! Form::text('correo_electronico', null, [
							'id' => 'fld-email-register',
							'class' => 'validate',
							'required' => 'required',
							'pattern' => 'email'
						]) !!}
						<label for="correo_electronico" data-error="E-mail incorrecto.">E-mail</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns input-field">
						<i class="mdi mdi-lock prefix"></i>
						{!! Form::password('password', [
							'id' => 'password',
							'class' => 'validate',
							'required' => 'required',
							'pattern' => 'password_valid'
						]) !!}
						<span class="error">{{ trans('passwords.password') }}</span>
						<label for="password">Contraseña</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns input-field">
						<i class="mdi mdi-lock prefix"></i>
						{!! Form::password('password_confirmation', [
							'id' => 'password_confirmation',
							'class' => 'validate',
							'required' => 'required',
							'data-equalto' => 'password'
						]) !!}
						<label for="password_confirmation" data-error="Las claves no coinciden">Confirmar contraseña</label>
					</div>
				</div>

				@if (count($errors) > 0)
					<br>
					<div class="row">
						<div class="small-12 columns">
							<div data-alert class="notice-box-tp alert">
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
						{!! Form::submit('Registrarse', ['class' => 'button xmedium sky-blue expand btn-lowerc btn-shadow radius']) !!}
					</div>
				</div>
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
	
	<div class="widget-login-recaptcha-new" data-key-recaptcha="{{ env('RECAPTCHA_SITE_KEY', '6Ld4HuQtAAAAAEgDP3VE3SpcymOzvL_yxvN8At-v') }}"></div>
{!! Form::close() !!}

