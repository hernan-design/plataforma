@extends('layout.core.layout')

@section('content')
<div id="commitment-section" class="wrapper-signin persistent-section">
	<div class="row">
		<div class="small-12 columns">
			<div id="commitment-content" class="inner-signin panel-content">

				<div class="row">
					<div class="small-12 tablet-11 tablet-centered columns">
						<div class="wrap-icon-persistent text-center">
							<span class="persistent-circle circle-reflex-bottom">
								<i class="mdi mdi-file-document"></i>
							</span>
						</div>

						<div class="wrap-description-persistent text-center">
							<h5 class="text-center clean-header gray-dark-text">Aceptación carta de compromiso</h5>
						</div>
					</div>
				</div>

				<div class="content-persistent-inner">
					<div class="row">
						<div class="small-11 tablet-8 medium-7 tablet-centered columns">
							<div class="wrap-description-persistent text-center">
								<p class="text-center text-dmd normal-text"><strong>{{ ucwords(strtolower(Auth::user()->nombre_usuario)) }},</strong> <a href="{{ URL::route('step.compromiso.show',['compromiso' => $compromiso]) }}" target='_blank'>descarga y lee la carta de compromiso</a>. Si estás de acuerdo con lo pactado acepta las condiciones para tener acceso a los servicios.</p>
							</div>
						</div>
					</div>
				</div>

				{!! Form::open(['route' => 'step.compromiso.store', 'id' => 'form-commitment-middleware', 'data-abide' => '']) !!}
					<div class="row">
					<input type="hidden" name="codigo_carta_compromiso" value="{{ $compromiso }}">
						<div class="small-12 text-center">
							{!! Form::submit('Aceptar carta de compromiso', ['class' => 'button xmedium sky-blue btn-shadow radius btn-bold']) !!}
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

{{-- section confirm Offer Product --}}
<script type="text/template" id="commitment-confirm-tpl">
	<p>{{ transtp('marketplace.commitment.confirmation') }}</p>
</script>
@stop
