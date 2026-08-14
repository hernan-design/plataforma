@extends('layout.core.layout')

@section('content')
<section id="pricing-wrapper">
	<section id="pricing-main">
		<div class="row">
			<div class="small-12 columns">
				<h4 class="pricing-title">{!! transtp('pricing.title') !!}</h4>

				<!-- pricing large devices -->
				<div class="pricing-large-devices">
					<div class="panel-content radius">					
						<div class="row collapse">
						@if(isset($plans) && count($plans) > 0)
							<div class="small-8 columns">
								<h5 class="pricing-items-list-title">QUÉ OBTIENES</h5>
								@if(isset($advantages))
									<ul class="pricing-items-list">
										@foreach($advantages as $advantage)
											<li class="pricing-item">{{ $advantage->descripcion_beneficio_plan }}</li>
										@endforeach
									</ul>
								@endif
							</div>
							<div class="small-4 columns">
								<div class="row collapse">
									@if(isset($plans))
										@foreach($plans as $plan)
											<div class="small-6 columns end">
												<div class="pricing-plans-boxes text-center radius {{ $plan->plan_sugerido ? 'premium' : '' }}">
													<h6 class="pricing-plans-title">{{ $plan->nombre_plan }}</h6>
													<div class="pricing-plans-head">
														<b class="price-number">{{ $plan->pago_plan ? "$$plan->precio_plan" : ($plan->texto_boton_plan ? "$plan->texto_boton_plan" : 'COMPRAR') }}</b>
														<small class="plans-payment-annual text-xsm">{{ $plan->descripcion_plan }}</small>
													</div>
													@if(isset($advantages))
														@php $items = $plan->items->pluck('codigo_beneficio_plan')->toArray(); @endphp
														@foreach($advantages as $advantage)
															<div class="plans-checkbox">
																<i class="mdi plans-checkbox-icon {{ in_array($advantage->codigo_beneficio_plan, $items) ? 'mdi-check' : 'mdi-close' }} vcenter"></i>
															</div>
														@endforeach
													@endif
													<a href="{{ $plan->url_boton_plan ? $plan->url_boton_plan : route('comprar.index', ['suscription' => $plan->url_plan]) }}" class="button tiny button-inst-secondary radius">{{ $plan->texto_boton_plan ? "$plan->texto_boton_plan" : 'COMPRAR' }}</a>
												</div>
											</div>
										@endforeach
									@endif
								</div>
							</div>																																
						@else
							<div class="small-12 columns">
								<div class="text-center white-text block-vpadding-bottom">
									<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/colabora/bloqueo-100.png" />									
								</div>
								<h3 class="text-center price-number">{!! transtp('pricing.subtitle') !!}</h3>
							</div>
						@endif
						</div>					
					</div>					
				</div>

				<!-- pricing medium-small devices -->
				<div class="pricing-ms-devices">
					<div class="row">
						<div class="small-12 columns">
						@if(isset($plans) && count($plans) > 0)
							<ul class="accordion accordion-pricing-plans" data-accordion>
								@if(isset($plans))
									@foreach($plans as $plan)
									  	<li class="accordion-navigation accordion-pricing-plans-item {{ $plan->plan_sugerido ? 'premium' : '' }}">
									  		<a class="accordion-plan-anchor" href="#panel_{{ $plan->codigo_plan }}">
												<ul class="accordion-plans-head-list">
													<li class="accordion-plans-head-item head-item-title">
														<div>
													    	<h6 class="accordion-plan-name">{{ $plan->nombre_plan }}</h6>
													    	<span class="accordion-plan-price-number right">{{ $plan->pago_plan ? "$$plan->precio_plan" : ($plan->texto_boton_plan ? "$plan->texto_boton_plan" : 'COMPRAR') }}</span>
													    	<h6 class="accordion-plan-text text-xsm">{{ $plan->descripcion_plan }}</h6>
														</div>

													</li>
													<li class="accordion-plans-head-item">
														<span class="accordion-plan-more">Ver más</span>
													</li>
												</ul>
											</a>
										    <div id="panel_{{ $plan->codigo_plan }}" class="content accordion-pricing-content">
												@if(isset($advantages))
													@php $items = $plan->items->pluck('codigo_beneficio_plan')->toArray(); @endphp
													<ul class="accordion-plans-content-list">
													@foreach($advantages as $advantage)
														<li class="accordion-plans-content-item accordion-icon {{ in_array($advantage->codigo_beneficio_plan, $items) ? 'icon-check' : 'icon-close' }}">{{ $advantage->descripcion_beneficio_plan }}</li>
													@endforeach
													</ul>
													<a href="{{ $plan->url_boton_plan ? $plan->url_boton_plan : route('comprar.index', ['suscription' => $plan->url_plan]) }}" class="button xmedium button-inst-secondary radius expand">{{ $plan->texto_boton_plan ? "$plan->texto_boton_plan" : 'COMPRAR' }}</a>
												@endif
										    </div>
									  	</li>
									@endforeach
								@endif
							</ul>
						@else
							<div class="text-center white-text block-vpadding-bottom">
								<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/colabora/bloqueo-100.png" />									
							</div>
							<h3 class="text-center price-number">{!! transtp('pricing.subtitle') !!}</h3>
						@endif
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</section>
@stop
