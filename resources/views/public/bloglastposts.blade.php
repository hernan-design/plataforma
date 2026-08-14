<div class="most-viewed no-border-aside">
	<div class="title-section">
		<h6 class="inner-title-section text-center">Artículos recientes</h6>
	</div>
	<ul class="large-block-grid-3 list-most-viewed" data-equalizer>
		@foreach ($lastArticles as $article)
		<li data-equalizer-watch>
			<a href="{{ URL::route('blog.categoria.articulo', array($article->url_tipo_contenido, $article->url_contenido)) }}" title="{{ $article->nombre_contenido }}">
				{!! HTML::image($article->imagen_contenido, $article->nombre_contenido) !!}
			</a>
		</li>
		@endforeach
	</ul>
</div>
