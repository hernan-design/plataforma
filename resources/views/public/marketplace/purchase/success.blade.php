@extends('public.marketplace.marketplace')

@section('marketplace.content')

<div id="content-purchase-marketplace">
	<div class="row">
		<div class="small-12 columns">

			<div class="panel-purchase-success panel-content">
				<div class="row">
					<div class="mobile-11 small-10 mobile-centered columns">
						<div class="wrap-icon-confirm-purchase text-center">
							<span class="confirm-purchase-circle circle-reflex-bottom">
								<i class="mdi mdi-check-all"></i>
							</span>
						</div>
						<div class="description-content text-center">
							<h5 class="gray-dark-text title-info">
								{{ $purchase->codigo_estado == App\Estado::getState('offer') ? transtp('marketplace.offer.success') : transtp('marketplace.purchase.success') }}
							</h5>
							<p class="text-md light-text">
								{{ $purchase->codigo_estado == App\Estado::getState('offer') ? transtp('marketplace.offer.instructions') : transtp('marketplace.purchase.instructions') }}
							</p>
							@if($purchase->codigo_estado != App\Estado::getState('offer'))
								<span class="text-md light-text">{!! transtp('marketplace.numberPurchase') !!}</span>
								<br>
								<span class="sky-blue-text">{{ $purchase->codigo_compra }}</span>
							@endif
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="mobile-11 small-10 mobile-centered columns">
						<h5 class="thin-header dark-text title-info text-center">{{ transtp('marketplace.purchase.seller') }}</h5>
						<ul class="list-seller-info mobile-block-grid-1 small-block-grid-1 medium-block-grid-2 large-block-grid-3 justify">
							<li>
								<div class="item-info text-center">
									<div><i class="mdi mdi-account mdi-24 gray-base"></i></div>
									<div><span class="dark-text text-sm">{{ $seller->nombre_usuario }}</span></div>
								</div>
							</li>
							<li>
								<div class="item-info text-center">
									<div><i class="mdi mdi-phone mdi-24 gray-base"></i></div>
									<div><span class="dark-text text-sm">{{ $seller->telefono_usuario ? $seller->telefono_usuario : 'Sin teléfono registrado'  }}</span></div>
								</div>
							</li>
							<li>
								<div class="item-info text-center">
									<div><i class="mdi mdi-cellphone mdi-24 gray-base"></i></div>
									<div><span class="dark-text text-sm">{{ $seller->movil_usuario }}</span></div>
								</div>
							</li>
							<li>
								<div class="item-info text-center">
									<div><i class="mdi mdi-email mdi-24 gray-base"></i></div>
									<div><span class="dark-text text-sm">{{ $seller->correo_electronico }}</span></div>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="mobile-12 small-12 tablet-offset-2 tablet-4 medium-3 medium-offset-3 columns">
						<a href="{{ route('marketplace.index') }}" title="Volver a catálogo" class="button medium sky-blue expand btn-shadow radius btn-lowerc">Volver a catálogo</a>
					</div>
					<div class="mobile-12 small-12 tablet-4 medium-3 columns end">
						<a href="{{ route('marketplace.compras.index') }}" title="{!! transtp('marketplace.showSuccessPurchases') !!}" class="button medium sky-blue expand btn-shadow radius btn-lowerc">{!! transtp('marketplace.showSuccessPurchases') !!}</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>


@stop
