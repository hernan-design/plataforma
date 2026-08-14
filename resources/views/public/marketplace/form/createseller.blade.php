@if (Auth::check())
	{{-- Alerts --}}
	@if($errors->terms->first())
		<div data-alert class="alert-box-tp alert" style="display:block">
			<i class="icon-alert"></i>
			<span>{{ $errors->terms->first() }}</span>
			<a href="#" class="close">&times;</a>
		</div>
	@endif
	<a href="<%- Route.route('marketplace.index') %>" class="close content-close">&times;</a>
	<div class="row">
		<div class="small-12 columns">
			<div class="confirm-creation-seller">
				<div class="wrap-icon-confirm-seller text-center">
					<span class="confirm-seller-circle circle-reflex-bottom">
						<i class="mdi mdi-cash"></i>
					</span>
				</div>
				<h6 class="title-info dark-text text-center">Conviertete en vendedor.</h6>
				<p class="description-info text-center text-md">Debes tener en cuenta las condiciones de garantías y políticas para ser vendedor.</p>

				{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-seller') ) !!}
					<div class="row">
						<div class="tablet-4 columns">
							<div class="row">
								<div class="mobile-12 columns input-field">
									<span data-tooltip aria-haspopup="true" class="radius prefix" title="Teléfono"><i class="mdi mdi-phone"></i></span>
									{!! Form::text('telefono_usuario', Auth::user()->telefono_usuario, array(
										'required' => 'required',
										'class' => 'validate',
										'pattern' => '^[-+]?\d+$',
										'maxlength' => '15'
									)) !!}
									<label for="telefono_usuario" data-error="El Teléfono no debe contener espacios, ni caracteres raros, solo valor numérico">Teléfono</label>
								</div>
							</div>
						</div>

						<div class="tablet-4 columns">
							<div class="row">
								<div class="mobile-12 columns input-field">
									<span class="radius prefix" title="Movil" data-tooltip aria-haspopup="true"><i class="mdi mdi-cellphone"></i></span>
									{!! Form::text('movil_usuario', Auth::user()->movil_usuario, array(
										'required' => 'required',
										'class' => 'validate',
										'pattern' => '^[-+]?\d+$',
										'maxlength' => '15'
									)) !!}
									<label for="movil_usuario" data-error="El móvil no debe contener espacios, ni caracteres raros, solo valor numérico">Celular</label>
								</div>
							</div>
						</div>

						<div class="tablet-4 columns">
							<div class="row">
								<div class="small-12 columns input-field">
									<span class="radius prefix" title="correo electrónico" data-tooltip aria-haspopup="true"><i class="fa fa-envelope"></i></span>

									<input type="text" name="correo_electronico" id="correo_electronico" value="{{Auth::user()->correo_electronico}}" required="required" class="validate" pattern="email" {{ Auth::user()->tipo_usuario == App\Usuario::typeUser('person') ? 'readonly' : '' }} >

									<label for="correo_electronico" data-error="E-mail incorrecto.">Correo electrónico</label>
								</div>
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="small-12 columns">
							<div id="terms-content" class="terms-content text-center input-field">
								{!! Form::checkbox('aceptacion_terminos', 'yes', false, ['required' => 'required', 'id' => 'aceptacion_terminos']) !!}
								<label for="aceptacion_terminos" class="label-terms dark-text" data-error="Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.">
									Acepto los
									{!! link_to_route('politicaventas', 'Términos y políticas de ventas', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} de
									<span class="bold-text dark-text">{{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</span>
								</label>
							</div>
						</div>
					</div>
					<br>
					<div class="row collapse">
						<div class="small-12 tablet-4 tablet-centered columns save-section">
							{!! Form::submit('Ser Vendedor', ['class' => 'button medium sky-blue expand btn-shadow radius btn-clean-margin']) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endif

