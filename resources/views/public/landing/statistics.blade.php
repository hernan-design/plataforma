<section class="statistic-count landing-bgcolor-secondary">
	<div class="md-wrapper">
		<div class="row medium-uncollapse large-collapse">
			<div class="mobile-12 columns">
				<ul class="mobile-block-grid-2 tablet-block-grid-3 medium-block-grid-4 list-statistic-count landing-color-primary">
					@if(isset($stadistics))
						@foreach ($stadistics as $stadistic)
							<li>
								<label>{{{ $stadistic->valor_metrica_institucion }}}</label>
								<h4 class="desct-statistic-count">{{{ $stadistic->nombre_metrica }}}</h4>
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</section>
