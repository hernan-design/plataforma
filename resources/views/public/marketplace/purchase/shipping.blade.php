<div class="row">
	<div class="small-10 small-centered columns">
		<div class="wrap-icon-confirm-purchase text-center">
			<span class="confirm-purchase-circle circle-reflex-bottom">
				<i class="mdi mdi-package-variant"></i>
			</span>
		</div>
		<div class="description-content text-center">
			<h5 class="thin-header sky-blue-text clean-header">Formas de entrega</h5>
		</div>
	</div>
</div>

<div class="row">
	<div class="mobile-12 mobile-centered columns">
		{!! Form::open(['route' => ['marketplace.compras.shipping.update', TuProyecto::encryptSrcParams([$purchase->codigo_compra])], 'method' => 'put', 'data-abide' => '', 'id' => 'form-purchase-shipping' ]) !!}
			@foreach(App\TipoEnvio::getTypes() as $type)

				@if(($product->domicilio_producto == true  &&  $type->codigo_tipo_envio == App\TipoEnvio::getTypeShipping('shippingdomicile')) || $type->codigo_tipo_envio != App\TipoEnvio::getTypeShipping('shippingdomicile') )
					<div class="row">
						<div class="small-12 columns text-center">
							<input name="shipping-type" id="shipping-type-{{ $type->codigo_tipo_envio }}" type="radio" value="{{ $type->codigo_tipo_envio }}" {{ session("shipping_$purchase->codigo_compra") == $type->codigo_tipo_envio ? 'checked' : ($type->nombre_tipo_envio == 'Envío a domicilio.' ? 'checked' : '') }}>
							<label for="shipping-type-{{ $type->codigo_tipo_envio }}" class="">
								<span class="text-md dark-text lighter-text">{{ $type->nombre_tipo_envio }} <span class="light-text">{{ $type->descripcion_tipo_envio ? '('.$type->descripcion_tipo_envio.')' : '' }}</span></span>
							</label>
						</div>
					</div>
				@endif
			@endforeach
			<div class="content-data-list content-data-products-purchase">
				<ul class="mobile-block-grid-1 browse-list-mask list-products-purchase adaptive-images">
					<li>
						<div class="item-wrap-list radius">
							<div class="row collapse col-equal-height">
								<div class="mobile-5 medium-4 columns">
									<div class="top-item-list no-border">
										<div class="item-thumb">
											<img src="{{ $product->imagen_producto }}" title="{{ $product->nombre_producto }}" alt="{{ $product->nombre_producto }}">
										</div>
									</div>
								</div>
								<div class="mobile-7 medium-8 columns">
									<div class="content-item-list text-left">
										<h5 class="title-product-purchase sky-blue-text">{{ $product->nombre_producto }}</h5>
										<p class="desc-product-purchase text-md lighter-text dark-text ellipsis">{{ $product->resumen_producto }}</p>

										<div class="bottom-item-list no-border">
											<ul class="no-bullet options-bottom-item">
												<li>
													<span class="text-xlg dark-text heavy-text">
														${{ number_format($purchase->valor_total_compra,2,',','.') }}
														<em class="gray-light-text text-xlg normal-text">iva incluido.</em>
													</span>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="mobile-12 small-12 tablet-offset-2 tablet-4 medium-3 medium-offset-3 columns">
					<a href="{{ route('marketplace.index') }}" title="Volver a catálogo" class="button medium sky-blue expand btn-shadow radius btn-lowerc">Volver a catálogo</a>
				</div>
				<div class="mobile-12 small-12 tablet-4 medium-3 columns end">
					<input name="step" type="hidden" value="{{ $action }}">
					@if(isset($promotion_code) && !empty($promotion_code))
						<input name="promotion_code" type="hidden" value="{{ $promotion_code }}">
					@endif
					{!! Form::submit('Continuar', ['class' => 'button medium sky-blue expand btn-shadow radius']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
