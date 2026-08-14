@extends('layout.core.layout')

@section('content')
	<section id="marketplace-wrapper">
		<section id="marketplace-content" class="marketplace-content">
			{{-- MarketPlace dinamic content --}}
			@yield('marketplace.content')
		</section>
    </section>

	{{-- modal crop image product --}}
	<div id="modal-image-product" class="reveal-modal-main xmedium clearfix" data-reveal>
		{{-- Title modal --}}
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-product-crop'))  !!}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Editar imagen</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				<div class="row">
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Ajustar la imagen</label>
						<div id="uploader-image-product" class="uploader-img-product uploader-image"></div>
					</div>
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Vista previa</label>
						<span class="text-xmd light-text">Tamaño real de la imagen (646px X 374px)</span>
					</div>
				</div>
				<div class="row">
					<div class="tablet-6 columns">
						<div id="image-crop-product" class="crop-product-img crop-load-img">
							<img id="image-product-tocrop" src="" class="image-to-crop" />
						</div>

						<input type="hidden" id="crop_type" name="crop_type" />
						<input type="hidden" id="file_name" name="file_name" />
						<input type="hidden" id="file_type" name="file_type" />
						<input type="hidden" class="crop-x" name="x" />
						<input type="hidden" class="crop-y" name="y" />
						<input type="hidden" class="crop-w" name="w" />
						<input type="hidden" class="crop-h" name="h" />
					</div>
					<div class="tablet-6 columns">
						<div id="preview-product-avatar" class="crop-preview-product crop-preview-img">
							<img id="product-preview-tocrop" src="" />
						</div>
					</div>
				</div>
			</div>
			{{-- Footer modal --}}
			<div class="footer-modal">
				<div class="row">
					<div class="tablet-3 tablet-offset-6 columns end">
						<a href="#" class="close-reveal-modal button small expand white btn-shadow radius">Cancelar</a>
					</div>
					<div class="tablet-3 columns">
						<button type="submit" class="button small sky-blue expand btn-shadow radius">Guardar</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<a class="close content-close close-reveal-modal">&#215;</a>
	</div>

	{{-- modal crop image product --}}
	<div id="modal-image-promotion" class="reveal-modal-main xmedium clearfix" data-reveal>
		{{-- Title modal --}}
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-promotion-crop'))  !!}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Editar imagen</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				<div class="row">
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Ajustar la imagen</label>
						<div id="uploader-image-promotion" class="uploader-img-product uploader-image"></div>
					</div>
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Vista previa</label>
						<span class="text-xmd light-text">Tamaño real de la imagen (1180px X 320px) </span>
					</div>
				</div>
				<div class="row">
					<div class="tablet-6 columns">
						<div id="image-crop-promotion" class="crop-product-img crop-load-img">
							<img id="image-promotion-tocrop" src="" class="image-to-crop" />
						</div>

						<input type="hidden" id="crop_type" name="crop_type" />
						<input type="hidden" id="file_name" name="file_name" />
						<input type="hidden" id="file_type" name="file_type" />
						<input type="hidden" class="crop-x" name="x" />
						<input type="hidden" class="crop-y" name="y" />
						<input type="hidden" class="crop-w" name="w" />
						<input type="hidden" class="crop-h" name="h" />
					</div>
					<div class="tablet-6 columns">
						<div id="preview-product-avatar" class="crop-preview-product crop-preview-img">
							<img id="promotion-preview-tocrop" src="" />
						</div>
					</div>
				</div>
			</div>
			{{-- Footer modal --}}
			<div class="footer-modal">
				<div class="row">
					<div class="tablet-3 tablet-offset-6 columns end">
						<a href="#" class="close-reveal-modal button small expand white btn-shadow radius">Cancelar</a>
					</div>
					<div class="tablet-3 columns">
						<button type="submit" class="button small sky-blue expand btn-shadow radius">Guardar</button>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
		<a class="close content-close close-reveal-modal">&#215;</a>
	</div>

	{{-- Templates edit forms --}}
	@include('public.marketplace.form.templates')

	{{-- content confirm sale agreement --}}
	<script type="text/template" id="sale-agreement-confirm-tpl">
		<p>{{ transtp('marketplace.agreement.confirmation', ['institution' => App\RegistroSesion::getInstitutionName()]) }}</p>
	</script>

	{{-- content confirm sale agreement --}}
	<script type="text/template" id="agreement-send-to-confirm-tpl">
		<p>{{ transtp('marketplace.agreement.confirmationsend') }}</p>
	</script>

	{{-- section Confirm Offer Product --}}
	<script type="text/template" id="product-confirm-offer-tpl">
		<p>{{ transtp('marketplace.offer.confirmation') }}</p>
	</script>

	{{-- section confirm offer product --}}
	<script type="text/template" id="purchase-confirm-offer-tpl">
		<p>{{ transtp('marketplace.offer.seller.confirmation') }}</p>
    </script>


	{{-- section confirm offer product --}}
	<script type="text/template" id="purchase-cancel-offer-tpl">
		<p>{{ transtp('marketplace.offer.seller.cancel') }}</p>
	</script>

	{{-- section Confirm Offer Product --}}
	<script type="text/template" id="purchase-confirm-cancel-tpl">
		<p>¿Desea cancelar la compra?</p>
    </script>

    {{-- section confirm purchase store --}}
	<script type="text/template" id="purchase-store-confirm-tpl">
        <p>{{ transtp('marketplace.purchase.store.confirmation') }}</p>

	</script>

@stop
