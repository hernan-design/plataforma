<div class="content-form-vote">
	<div class="row">
        <div class="small-12 columns">
			<div class="content-vote-inner">
				<div class="text-center">
					<label class="label title text-center text-md gray-base-text gray-dark-text">Ingresa tus datos para continuar</label>
				</div>
				{!! Form::open(['action' => null, 'id' => 'form-user-vote', 'name' => 'form-user-vote', 'data-abide' => '']) !!}
					<div class="row">
						<div class="small-12 columns input-field">
							<i class="mdi mdi-email prefix"></i>
							{!! Form::text('correo_electronico', Input::old('correo_electronico'), [
								'id' => 'correo_electronico_user_vote',
								'class' => 'validate',
								'required' => 'required',
								'pattern' => 'email'
							])
							!!}
							<label for="correo_electronico" data-error="E-mail incorrecto.">E-mail</label>
						</div>
                    </div>
                    <div class="row">
						<div class="small-12 columns input-field">
							<i class="mdi mdi-account prefix"></i>
							{!! Form::text('name', Input::old('name'), [
								'id' => 'name_user_vote',
								'class' => 'validate',
								'required' => 'required',
							])
							!!}
							<label for="name_user_vote" data-error="Campo obligatorio.">Nombre</label>
						</div>
					</div>
                    <div class="row">
						<div class="small-12 columns input-field">
							<i class="mdi mdi-phone prefix"></i>
							{!! Form::text('phone', Input::old('phone'),[
                                'id' => 'phone_user_vote',
								'class' => 'validate phone-mask-co',
								'required' => 'required'
							])
							!!}
							<label for="phone_user_vote" data-error="Campo obligatorio.">Celular</label>
						</div>
                    </div>
                    <div class="row">
                        <div id="terms-content" class="terms-content text-left">
                            <input type="checkbox" name="manejo_datos" id="manejo_datos" value="yes" required="" class="validate">
                            <label for="manejo_datos" class="label-terms dark-text" data-error="Debes aceptar los los terminos de datos para continuar">
							Acepto los <a href="{{ route('privacidad') }}" target="_blank" rel="noopener noreferrer">términos de manejos de datos</a>
                            </label>
                        </div>
					</div>
					<div class="g-recaptcha widget-vote-recaptcha" data-sitekey="6Lc8ydoZAAAAAM0AoC5gnBO9XuK_Z5cN95G2QCHQ"></div>

					<div class="row">
						<div class="small-12 columns">
                            <br><br>
							{!! Form::submit(trans('app.vote'), ['class' => 'button xmedium sky-blue expand btn-lowerc btn-shadow radius']) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
    </div>
</div>
