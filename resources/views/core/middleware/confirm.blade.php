@extends('core.middleware.steps', ['step' => 'confirmation'])

@section('step')
	<section id="mail-confirmation" class="content active">
		<div class="row col-equal-height">
			<div class="small-12 tablet-4 columns">
				<div class="registration-process-border">
					<div class="reg-process-info-box">
						<small class="reg-process-info-steps">PASO 1 DE {{ App\RegistroSesion::institution()->pasos_complementarios_registro ? '4' : '2' }}</small>
						<h5 class="reg-process-info-title">Confirma tu dirección de correo electrónico</h5>
					</div>
				</div>
			</div>

			<div class="small-12 tablet-8 columns" id="verify-account-content">
				<div class="reg-content-box">
					<p class="mail-confirmation-text">¡Gracias por unirte a nuestra red!</p>
					<p class="mail-confirmation-text">{!! empty(Auth::user()->correo_electronico) ? trans('app.confirm.mail.empty') : trans('app.confirm.mail', ['mail' => Auth::user()->correo_electronico, 'institution' => App\RegistroSesion::getInstitutionName()]) !!}</b></p>
					<span class="mail-confirmation-note">* Puedes cambiar tu dirección de correo electrónico y/o reenviar un nuevo mensaje de confirmación.</span>

					<div class="row">
						<div class="small-12 columns">
							{!! Form::open(['route' => null, 'id' => 'form-forward-confirm', 'data-abide' => '']) !!}
								<div class="row">
									<div class="small-12 columns input-field">
										<div class="small-12 columns input-field">
											{!! Form::text('correo_electronico', Auth::user()->correo_electronico,
												array(
													'required' => 'required',
													'class' => 'validate',
													'pattern' => 'email'
											)) !!}
											<label for="correo_electronico" data-error="E-mail incorrecto.">Correo electrónico de confirmación</label>
										</div>
									</div>
								</div>

								{!! Form::submit('REENVIAR MENSAJE DE CONFIRMACIÓN', ['class' => 'registration-confirm-email-button button small radius btn-resetc']) !!}
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
  	</section>
@stop
