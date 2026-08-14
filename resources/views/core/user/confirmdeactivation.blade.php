@extends('layout.core.layout')

@section('content')
<div id="deactivation-account-confirm" class="wrapper-signin">
	<div class="row">
		<div class="small-12 tablet-8 tablet-centered columns">
			<div id="deactivation-account-content" class="inner-signin panel-info">
				<div class="row">
					<div class="small-12 columns text-center">
						<div class="wrap-icon-deactivation-account text-center">
							<span class="deactivation-account-circle circle-reflex-bottom">
								<i class="mdi mdi-account-remove"></i>
							</span>
						</div>
						<h4 class="text-center">¿Estás seguro de que quieres desactivar tu cuenta?</h4>
						<a href="mailto:soporte@tuproyecto.com">Cuéntanos porqué.</a>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="small-12 columns">

						<div class="content-deactivation-inner">

							<h6>Antes de desactivar {{ Auth::user()->nickname() }}, ten en cuenta lo siguiente:</h6>

							<div class="row">
								<div class="small-12 columns">
									<ul class="considerations-deactivation text-justify">
										<li>
											<p class="block-text-small">Puedes reactivar tu cuenta en cualquier momento iniciando sesión de nuevo.</p>
										</li>
										<li>
											<p class="block-text-small">Tu cuenta deberá ser eliminada dentro de unos minutos, pero puede que algún contenido sea visible unos días después de su desactivación.</p>
										</li>
										<li>
											<p class="block-text-small">No tenemos control sobre contenido indexado por los motores de búsqueda como Google.</p>
										</li>
									</ul>
								</div>
							</div>

						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="small-6 tablet-3 tablet-offset-5 columns">
						<a href="{{ URL::route('usuario.nickname.tab', array( Auth::user()->nickname_usuario, 'preferencias')) }}" title="Cancelar" class='right button small white expand btn-shadow radius'>Cancelar</a>
					</div>
					<div class="small-6 tablet-4 columns">
						<a id="cancel-account-user" href="#" title="Desactivar mi cuenta" class='right button small sky-blue expand btn-shadow radius' data-reveal-id="modal-confirm-deactivation" >Desactivar <span class="reset-case-text">{{ Auth::user()->nickname() }}</span></a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div id="modal-confirm-deactivation" class="reveal-modal-main xmedium clearfix" data-reveal data-options="animation:'fade';">
	{{-- Title modal --}}
	<div class="title-modal-top">
		<h3 class="inner-title-modal text-center bold-header">Desactivar Cuenta</h3>
	</div>
	{{-- Content modal --}}
	<div class="content-modal">
		<div id="content-confirm-deactivation" class="row collapse">
			<div class="small-12 columns">

				{!! Form::open(['route' => ['usuario.destroy',TuProyecto::encryptSrcParams([ Auth::user()->codigo_usuario])], 'method' => 'delete']) !!}
					<div class="row">
						<div class="small-12 columns text-center">
							<span class="confirm-deactivation-circle circle-reflex-bottom">
								<i class="mdi mdi-account-remove"></i>
							</span>

							<h4 class="text-center">¿Estás seguro de que quieres desactivar tu cuenta?</h4>
							<a href="mailto:soporte@tuproyecto.com" class="sky-blue-text">Cuéntanos porqué.</a>
						</div>
					</div>
					<div class="row">
						<div class="small-12 medium-6 medium-centered columns">
							{!! Form::submit('Desactivar cuenta', array('class' => 'button medium sky-blue expand btn-shadow radius')) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	{{-- Footer modal --}}
	<a class="close content-close close-reveal-modal">&#215;</a>
</div>
@stop
