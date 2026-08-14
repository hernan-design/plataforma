@extends('public.marketplace.marketplace')

@section('marketplace.content')

	<div id="content-purchase-marketplace">
		<div class="row">
			<div class="small-12 columns">

				<div class="panel-purchase-marketplace panel-content">
					{{-- Alerts --}}
					@if($errors->purchase->first())
						<div data-alert class="alert-box-tp alert" style="display:block">
							<i class="icon-alert"></i>
							<span>{{ $errors->purchase->first() }}</span>
							<a href="#" class="close">&times;</a>
						</div>
					@endif	
					<div id="purchase-submenu-tabs">
                        {{-- submenu navigation purchase --}}
						<ul id="purchase-tabs-filter" class="tabs-sub-nav tabs-route inline-list-grid" data-tab-init="is_hover:false">
                            @if( $product->codigo_clase_producto != 3))
							    <li class="tab-title payment {{ in_array($action, ['shipping','payment','confirm']) ? 'active' : '' }}">
								    <a href="{{ route('marketplace.compras.shipping.edit', ['shipping' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])]) }}" title="Envío" aria-controls="shipping-purchase">Envío</a>
                                </li>
                            @endif
							<li class="tab-title {{ in_array($action, ['confirm']) ? 'active' : '' }}">
								<a href="{{ route('marketplace.compras.confirm.edit', ['confirm' => TuProyecto::encryptSrcParams([$purchase->codigo_compra])]) }}" title="Revisa y confirma" aria-controls="confirm-purchase">Revisa y confirma</a>
							</li>
						</ul>
					</div>

					<div class="tabs-content section-content-purchase">
						<section class="content active" id="{{ $action }}-purchase">
							{{-- Render shipping dinamic content --}}
							@include("public/marketplace/purchase/$action")
						</section>
					</div>
				</div>

			</div>
		</div>
	</div>

@stop
