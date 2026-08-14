<section id="cenisoft-news">
	<!-- contenedor -->
	@if(isset($articles) && count($articles) > 0)
				<div class="container-news"> <!-- Contenido banner-->
					<div class="image-news"> <!-- Contenedor de la imagen-->
						<h3>Noticias</h3>
						<div class="row content-news">
							<div class="mobile-12 tablet-12 large-10 large-offset-1 columns">
								<figure class="slick-slider-cenisoft-news">
									@foreach ($articles as $articles)
									<div class="panel">
										<div class="row">
											<div class="panel-header mobile-12 tablet-6 large-4 columns">
												<img src="{{$articles->imagen_contenido}}" alt="">
											</div>
											<div class="panel-body mobile-12 tablet-6 large-8 columns">
												<label class="title-news">{{$articles->nombre_contenido}}</label><br>
												<label class="date-news">{{$articles->fecha_contenido}}</label><br><br>
												<label class="description-news">{{$articles->resumen_contenido}}</label><br>
												<a class="button right" href="blog/general/{{$articles->url_contenido}}">Conoce más</a>
											</div>
										</div>
									</div>
									@endforeach
								</figure>
							</div>
						</div>
					</div>
				</div>

    @endif
</section>
