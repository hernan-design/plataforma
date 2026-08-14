<section class="work-info-land gradient-inst-land">
	{{-- <div class="strip-title-white landing-bgcolor-secondary landing-color-primary text-center">
		<h2>¿Cómo funciona?</h2>
	</div> --}}
	<div class="md-wrapper">
		<div class="row medium-uncollapse large-collapse">
			<div class="mobile-12 columns">
				<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 list-work-info text-center">
					@if(isset($advantage))
						@foreach ($advantage as $benefit)
							<li>
								<div class="title-work-info text-center">
									{!! HTML::image($benefit->imagen_beneficio, 'Beneficio') !!}
									{{--  <label>Idea</label> --}}
								</div>
								<p class="desc-work-info text-center">{{{ $benefit->texto_beneficio }}}</p>
								{{-- <a href="#"><span>Beneficios</span></a> --}}
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</section>
