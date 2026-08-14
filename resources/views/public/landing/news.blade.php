@if(isset($articles) && count($articles) > 0)
<section id="news-land" class="section-land news-land block-vpadding-both">
	@if(isset($parameters['title_blog']) && $parameters['title_blog'])
		<div class="row">
	        <div class="small-12 columns">
	            <h2 id="title-section" class="title-section-land">
	            	{!! isset($parameters['title_blog']) ? $parameters['title_blog'] : '' !!}
	           	</h2>
	        </div>
	    </div>
	@endif
	<div class="row">
		<div class="mobile-12 columns">
			<div class="content-data-list">
				<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-4 large-block-grid-5 slick-news slick-browse browse-list-mask list-news-land">
					@foreach ($articles as $article)
						<li class="item-news item-carousel">
							<div class="item-wrap-list radius news-item-land">
								<div class="top-item-list news-image-land no-border">
									<a href="{{ URL::route('blog.categoria.articulo', array($article->url_tipo_contenido, $article->url_contenido)) }}" title="{{ $article->nombre_contenido }}" class="item-thumb">
										{!! HTML::image($article->imagen_contenido, $article->nombre_contenido) !!}
									</a>
								</div>
								<div class="content-item-list news-description-land">
									<h5 class="news-item-title ellipsis">
										<a class="news-title-anchor-land" href="{{ URL::route('blog.categoria.articulo', array($article->url_tipo_contenido, $article->url_contenido)) }}" title="{{ $article->nombre_contenido }}">{{{ $article->nombre_contenido }}}</a>
									</h5>
								</div>
								<div class="bottom-item-list">
									<span class="gray-base-text thin-text news-bottom-land"><em>{{{ $article->fecha_contenido }}}</em></span>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</section>
@endif

