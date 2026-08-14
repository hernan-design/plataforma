@extends('layout.core.layout')

@section('content')

    <div id="verify_vote" style="margin-top: 1.8rem;">
			<div class="large-4 large-offset-4">
				<div class="panel no-padding" style="box-shadow: rgba(0, 0, 0, 0.3) 0px 2px 6px 0px">
					<div class="full-width col-equal-height sky-blue-bg" style="padding: 1rem;">
						<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/terpel/img-success.png" alt="" class="large-2 mobile-4 large-offset-5 mobile-offset-4">
					</div>
					<div class="row">
						<div class="small-12 columns">
							<div class="form-group" style="padding: 1rem;">
								{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-verify-vote'))  !!}
									<p class="text-justify">El código fue enviado exitósamente, para validar su petición porfavor ingrese el código de verificación que fue enviado a su celular y escríbalo en el siguiente espacio:</p>
								<input id="code_verification" name="code_verification" type="text" class="form-control" placeholder="Codigo de verificación" maxlength="6" required>
									<button type="submit" class="button xsmall radius full-width sky-blue"> Verificar </button>
									<small>
										<a id="re-send-vote-number" class="re-send-vote" data-type="number" href="#">
											reenviar al número (+57) {{ $voto->numero_celular_voto }}
										</a>
									</small><br>
									{{-- <small>
										<a id="re-send-vote-email" class="re-send-vote" data-type="email" href="#">
											reenviar al correo {{ $voto->correo_electronico_voto }}
										</a>
									</small> --}}
									@if($entidad instanceof App\Usuario)
									<small>
										<a id="back-to-proyect"  class="linkto-inst-color"  href="{{ route('proyecto.proyecto',['proyecto'=> $entidad->nickname_usuario]) }}"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter"></i> volver al proyecto</a>
									</small>
									@endif
								{!! Form::close() !!}

								<div id="myModal" class="reveal-modal tiny" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">

									<div class="text-center">
										<label class="label title text-center text-md gray-base-text gray-dark-text">Ingrese el nuevo número</label>
									</div>
									{!! Form::open(['action' => null, '' => '', 'name' => '', 'data-abide' => '']) !!}


									<div class="row">
										<div class="small-12 columns input-field">
											<i class="mdi mdi-phone prefix"></i>
											{!! Form::text('phone', Input::old('phone'),[
												'id' => 'phone_user_vote',
												'class' => 'validate',
												'required' => 'required'
											])
											!!}
											<label for="phone_user_vote" data-error="Campo obligatorio.">Celular</label>
										</div>
									</div>

									<div class="row">
										<div class="small-12 columns" style="margin-top: 2rem;">
											<button type="submit" class="button xsmall radius full-width"> Enviar codigo </button>
										</div>
									</div>
									{!! Form::close() !!}
									<a class="close-reveal-modal" aria-label="Close">&#215;</a>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    </div>
@endsection
