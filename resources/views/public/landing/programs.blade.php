@if(isset($programs) && count($programs) > 0)
<section id="programs-land" class="section-land programs-land block-vpadding-both">
	@if(isset($parameters['title_convocatorias']) && $parameters['title_convocatorias'])
		<div class="row">
			<div class="small-12 columns">
				<div class="strip-title-white">
					<h2 class="title-section-land">{{{ isset($parameters['title_convocatorias']) ? $parameters['title_convocatorias'] : '' }}}</h2>
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="mobile-12 columns">
			<div class="content-data-list">
				<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-5 large-block-grid-6 slick-programs slick-browse browse-list-mask list-programs-land">
					@foreach ($programs as $program)
						<li class="item-programs item-carousel">
							<div class="item-wrap-list radius programs-item-land text-center clearfix">
								<h5 class="text-left programs-call-category-title">{{ $program->nombre_convocatoria }}</h5>
								<h3 class="programs-title text-left">
									<a href="" class="title-small programs-title-anchor-land">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
								</h3>
								<h6 class="text-left programs-call-date">Inicio: <b>Julio 22 de 2016</b></h6>
								<h6 class="text-left programs-call-date">Cierre: <b>Agosto 28 de 2016</b></h6>
								<a href="http://premioalainnovacion.innpulsa.com.co/convocatoria?category=1" class="button tiny left radius btn-lowerc view-programs-cta innpulsa-bright-blue-color">ver más</a>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</section>
@endif
