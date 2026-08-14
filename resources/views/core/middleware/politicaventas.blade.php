@extends('layout.core.layout')

@section('content')
<div id="terms-section" class="wrapper-signin">
	<div class="row">
		<div class="small-12 columns">
			<div id="terms-content" class="inner-signin panel-info">
				<div class="row">
					{{-- Alerts --}}
					@if($errors->terms->first())
						<div data-alert class="alert-box-tp alert" style="display:block">
							<i class="icon-alert"></i>
							<span>{{ $errors->terms->first() }}</span>
							<a href="#" class="close">&times;</a>
						</div>
					@endif
					<div class="small-12 tablet-11 tablet-centered columns">
						<div class="content-terms-inner">
							{!! Form::open(array('route' => 'step.politicaventas.store', 'class' => 'form', 'data-abide' => '')) !!}

								<div class="row">
									<div class="small-12 columns">
										<div class="wrap-icon-terms text-center">
											<span class="terms-circle circle-reflex-bottom">
												<i class="mdi mdi-file-document"></i>
											</span>
										</div>
										<div class="wrap-description-terms text-center">
											<p class="text-center text-md lighter-text">
												Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de  {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</p>
										</div>
										<div id="terms-content" class="terms-content text-center">
											{!! Form::checkbox('aceptacion_terminos', 'yes', false, ['required' => 'required', 'id' => 'aceptacion_terminos']) !!}
											<label for="aceptacion_terminos" class="label-terms dark-text">
												Acepto los {!! link_to_route('politicaventas', 'Términos y políticas de ventas', [], ['target' => '_blank', 'class' => 'sky-blue-text bold-text']) !!} de
												<span class="bold-text dark-text">{{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</span>
											</label>
											<small class="error">Para poder utilizar nuestros servicios, debes aceptar las condiciones del servicio de {{{ ucwords( App\RegistroSesion::getInstitutionName() ) }}}.</small>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="small-12 tablet-4 tablet-centered columns">
										{!! Form::submit('Aceptar', ['class' => 'button xmedium sky-blue expand btn-shadow radius']) !!}
									</div>
								</div>
							</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
