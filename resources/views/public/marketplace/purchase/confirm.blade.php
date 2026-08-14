<div class="row">
	<div class="small-10 small-centered columns">
		<div class="wrap-icon-confirm-purchase text-center">
			<span class="confirm-purchase-circle circle-reflex-bottom">
				<i class="mdi mdi-eye"></i>
			</span>
		</div>
		<div class="description-content text-center">
			<h5 class="thin-header sky-blue-text clean-header">{!! transtp('marketplace.reviewPurchase') !!}</h5>
		</div>
	</div>
</div>

<hr class="no-margin">

<div class="row collapse">
	<div class="mobile-12 mobile-centered columns">
		{!! Form::open(['route' => ['marketplace.compras.confirm.update', TuProyecto::encryptSrcParams([$purchase->codigo_compra])], 'method' => 'put', 'data-abide' => '', 'id' => 'form-purchase-confirm' ]) !!}
			<ul class="list-chip-info list-detail-purchase">
				<li>
					<h4 class="sky-blue-text thin-header">
						<i class="mdi mdi-barcode-scan mdi-36 vcenter gray-light"></i>
						{{ transtp('marketplace.purchase.product') }}
					</h4>
					<ul class="inline-list-grid products-detail-purchase">
						<li class="has-image">
							<img src="{{ $product->imagen_producto }}" title="{{ $product->nombre_producto }}" alt="{{ $product->nombre_producto }}" class="img-product-purchase">
						</li>
						<li>
							<span class="dark-text text-lg">{{ $product->nombre_producto }}</span>
							<br />
							<p class="clean-bottom desc-product-purchase gray-dark-text text-md ellipsis">{{ $product->resumen_producto }}</p>
						</li>
					</ul>
                </li>
                @if($shipping)
				<li>
					<h4 class="sky-blue-text thin-header">
						<i class="mdi mdi-package-variant mdi-36 vcenter gray-light"></i>
						Envío
					</h4>
					<div>
						<span class="text-md dark-text lighter-text">{{ $shipping->nombre_tipo_envio }} <span class="light-text">{{ $shipping->descripcion_tipo_envio }}</span></span>
					</div>
                </li>
                @endif
				<li>
					<h4 class="sky-blue-text thin-header">
						<i class="mdi mdi-cash-multiple mdi-36 vcenter gray-light"></i>
						Pago
					</h4>
					<div>
						<span class="text-md dark-text lighter-text">{{ $payment->nombre_tipo_pago }} <span class="light-text">{{ $payment->descripcion_tipo_pago }}</span></span>
					</div>
				</li>
				<li>
					<h4 class="sky-blue-text thin-header">
						<i class="mdi mdi-tag-text-outline mdi-36 vcenter gray-light"></i>
						Precio
					</h4>
					<table class="table-content">
						<tr>
							<td class="text-left dark-text bold-text">$ {{ number_format($purchase->valor_total_compra,2,',','.') }}</td>
							<td class="text-center dark-text bold-text">{{ $purchase->unidad_producto > 0 ? "$purchase->unidad_producto": ''}}</td>
							<td class="text-right dark-text bold-text">$ {{ $purchase->unidad_producto > 0 ? number_format(($purchase->unidad_producto * $purchase->valor_total_compra),2,',','.') : number_format($purchase->valor_total_compra,2,',','.') }}</td>
						</tr>
						<tr>
							<th class="text-left light-text">Unidad</th>
							<th class="text-center light-text">{{ $purchase->unidad_producto > 0 ? 'Cantidad': ''}}</th>
							<th class="text-right light-text">Total</th>
						</tr>
					</table>
				</li>
			</ul>
			<div class="row">
				<div class="mobile-12 small-12 tablet-offset-2 tablet-4 medium-3 medium-offset-3 columns">
					<a href="{{ route('marketplace.index') }}" title="Volver a catálogo" class="button medium sky-blue expand btn-shadow radius btn-lowerc">Volver a catálogo</a>
				</div>
				<div class="mobile-12 small-12 tablet-4 medium-3 columns end">
					{!! Form::submit(transtp('marketplace.finishPurchaseReview'), ['class' => 'button medium sky-blue expand btn-shadow radius']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
