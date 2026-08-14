{{-- feature projects --}}
@if(isset($entities) && count($entities) > 0)
<section id="projects-land" class="section-land projects-land block-vpadding-both">
	@if(isset($parameters['title_entidades']))
		<div class="row">
	        <div class="small-12 columns">
	            <h2 class="title-section-land">{{ $parameters['title_entidades'] }}</h2>
	        </div>
	    </div>
	@endif
	<div class="row">
		<div class="small-12 columns">
			<div class="content-data-list">
				<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-5 large-block-grid-6 slick-feature-projects slick-browse browse-list-mask list-projects-land">
					@foreach ($entities as $entity)
						<li class="item-projects item-carousel">
							<div class="item-wrap-list radius text-left feature-project-boxes">
								{!! HTML::image($entity->imagen_usuario, 'Proyecto') !!}
								<h3 class="feature-project-title-box">
									<a class="feature-project-title" href="{{ URL::route('proyecto.proyecto', $entity->nickname_usuario) }}">{{{ $entity->nombre_usuario }}}</a>
								</h3>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</section>
@endif
