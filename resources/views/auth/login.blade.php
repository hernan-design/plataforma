@extends('layout.core.layout')

@section('content')
	<div id="login-section" class="wrapper-signin has-bgimage">
		
		<div class="row">
			<div class="small-12 {{ App\RegistroSesion::getLoginSocial() ? 'tablet-10 medium-9' : 'tablet-6 medium-5' }} tablet-centered columns">
				<div class="advise-register text-center">
					<span class="">Si no tienes una cuenta, </span>
					<a href="{{ URL::route('register') }}" class="button tiny sky-blue btn-lowerc btn-shadow radius bold-btn">Regístrate</a>
				</div>

				<div id="login-content" class="inner-signin panel-info">
					@include ('auth.loginform')
				</div>
				<div class="panel-info text-center">
					<div class="row">
						<div class="small-12 tablet-12 tablet-centered columns">
							<span class="sky-blue-text">
								<strong>¡Por favor, recargue el navegador en caso de no cargar el reCAPTCHA!</strong>
							</span>
						</div>
					</div>
					<div class="row">
						<div class="small-12 tablet-12 tablet-centered columns">
							<img src="https://s3.us-west-2.amazonaws.com/static.tuproyecto.com/images/general/hero-recaptcha-invisible.gif"
                                width="10%" height="10%" alt="reCAPTCHA">
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
@stop
