<div class="row">
	<div class="small-10 small-centered columns">
		<div class="wrap-icon-confirm-purchase text-center">
			<span class="confirm-purchase-circle circle-reflex-bottom">
				<i class="mdi mdi-cash-multiple"></i>
			</span>
		</div>
		<div class="description-content text-center">
			<h5 class="thin-header sky-blue-text clean-header">{!! transtp('marketplace.paymentMethods') !!}</h5>
		</div>
	</div>
</div>

<div class="row">
	<div class="mobile-12 mobile-centered columns">
		{{-- Alerts --}}
		@if(Request::has('payment_error'))
			<div data-alert class="alert-box-tp alert" style="display:block">
				<i class="icon-alert"></i>
				<span>{!! Request::get('payment_error') !!}</span>
				<a href="#" class="close">&times;</a>
			</div>
		@endif

		{!! Form::open(['route' => ['marketplace.compras.payment.update', TuProyecto::encryptSrcParams([$purchase->codigo_compra])], 'method' => 'put', 'data-abide' => '', 'id' => 'form-purchase-payment' ]) !!}

			@foreach(App\TipoPago::getTypes() as $type)
				<div class="row">
					<div class="small-12 columns text-center">
						<input name="payment" id="payment-{{ $type->codigo_tipo_pago }}" type="radio" class="payment-type" value="{{ $type->codigo_tipo_pago }}" checked>
						<label for="payment-{{ $type->codigo_tipo_pago }}" class="">
							<span class="text-md dark-text lighter-text">{{ $type->nombre_tipo_pago }} <span class="light-text">{{ $type->descripcion_tipo_pago ? '('.$type->descripcion_tipo_pago.')' : '' }}</span></span>
						</label>
						@if($type->codigo_tipo_pago == App\TipoPago::getTypePayment('voucher') || $type->codigo_tipo_pago == App\TipoPago::getTypePayment('voucher-aldea'))
							@if(isset($totalvoucher)) ${{ number_format($totalvoucher,0,',','.') }} @endif
						@endif
					</div>
				</div>
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
                                                    @if(!is_null($purchase->descuento))
                                                        <span class="text-xlg dark-text heavy-text text-line-through">
                                                            ${{ number_format($purchase->valor_total_compra,2,',','.') }}
                                                        </span>
                                                        <br>
                                                        <span class="gray-light-text heavy-text text-xbg">
                                                            (-{{ $purchase->porcentaje_descuento }}%)
                                                        </span>
                                                        <span class="gray-dark-text heavy-text text-xbg">
                                                            ${{ number_format($purchase->descuento,2,',','.') }}
                                                            <em class="gray-light-text text-xlg normal-text">iva incluido.</em>
                                                        </span>
                                                    @else
                                                        <span class="text-xlg dark-text heavy-text">
                                                            ${{ number_format($purchase->valor_total_compra,2,',','.') }}
                                                            <em class="gray-light-text text-xlg normal-text">iva incluido.</em>
                                                        </span>
                                                    @endif
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
                    @if(isset($promotion_code) && !empty($promotion_code))
					    <input name="promotion_code" type="hidden" value="{{ $promotion_code }}">
                    @endif
					{!! Form::submit('Continuar', ['class' => 'button medium sky-blue expand btn-shadow radius']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
