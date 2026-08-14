@extends('layout.core.layout')

@section('content')
<div id="register-section" class="wrapper-signin has-bgimage">

	<div class="row">
		<div class="small-12 {{ App\RegistroSesion::getLoginSocial() || $institution->tipo_registro_institucion == App\Institucion::getTypeRegister('survey') ? 'tablet-10 medium-9' : 'tablet-6 medium-5' }} tablet-centered columns">
			<div class="advise-login text-center">
				<span class="">{{ transtp('register.adviselogin.text') }} </span>
				<a href="{{ URL::route('login') }}" class="button tiny sky-blue btn-lowerc btn-shadow radius bold-btn">{{ transtp('register.adviselogin.button') }}</a>
			</div>

			<div id="register-content">

				@if($institution->tipo_registro_institucion == App\Institucion::getTypeRegister('html'))
					<div class="inner-signin panel-info">

						{{-- Html redirect external forms --}}
						<div class="register-apply-inner">
							<div class="row">
								<div class="mobile-12 medium-9 tablet-10 tablet-centered columns">
									<div class="wrap-icon-confirm text-center">
										<span class="confirm-circle circle-reflex-bottom">
											<i class="mdi mdi-account-key"></i>
										</span>
									</div>
									{!! transtp('register.invitation', ['institution' => ucwords( App\RegistroSesion::getInstitutionName() )]) !!}
									{!! $institution->contenido_registro_institucion !!}
								</div>
							</div>
						</div>

					</div>

				@elseif($institution->tipo_registro_institucion == App\Institucion::getTypeRegister('survey'))
					{{-- Internal custom form --}}
					<section id="survey-content" class="survey-content">
						{{-- Render survey --}}
					</section>
					@include('public.surveytemplates')
				@else
					<div class="inner-signin panel-info">
						<div class="content-register-inner">
							<div class="row">
								<div class="small-12 tablet-11 tablet-centered columns">
									<div class="tabs-content">
										<section class="content active" id="content-logindefault">
											@include ('auth.registerdefault')
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>

			@if($institution->modal_registro_datos)
				<div class="reveal-modal-main medium clearfix content-scroll is-fixed" data-reveal data-noclose data-openauto>
					{{-- Content modal info register --}}
					<div class="content-modal">
						{!! $institution->texto_modal_registro_datos !!}
					</div>
					{{-- Footer modal --}}
					<div class="footer-modal">
						<div class="row">
				            <div class="small-12 medium-3 medium-offset-9 columns">
				                <a href="#" class="close-reveal-modal button white-skyblue tiny btn-shadow expand radius">Aceptar</a>
				            </div>
				        </div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
@stop