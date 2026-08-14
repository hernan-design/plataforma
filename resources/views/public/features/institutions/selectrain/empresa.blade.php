@extends('public.features.main')

@section('content-features')
	<div class="features-section-header">
		<h1 class="features-section-header-title inst-color-secondary">Sitio de empresa</h1>
		<p class="features-section-header-text">Cada empresa tiene su sitio con espacios para publicar una descripción, sector económico, redes sociales, pagina web, entre otros datos esenciales para facilitar la búsqueda por parte de candidatos interesados. Adicionalmente, en cada sitio se muestran todas las vacantes disponibles, las cuales son ILIMITADAS para todos los planes.</p>
	</div>

	<section class="features-section">

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>

				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Para que cualquier candidato pueda conocer la información básica de una empresa y sus vacantes disponibles, cada empresa tiene su espacio para publicar un perfil, incluir imágenes, video, conectar sus redes sociales (Facebook, X y LinkedIn), información de contacto, todo con una URL amigable que facilita el compartir esta pagina por diferentes medios.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>

				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Crear y editar un sitio de empresa es rápido, fácil y no requiere de conocimientos técnicos. Solo debes completar un formulario de información básica para crearlo. Para editarlo solo es necesario hacer click en los botones de edición para cada campo que están convenientemente ubicados sobre la vista pública de la página de empresa.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>

				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">En tu sitio los visitantes o candidatos podrán encontrar todas las vacantes que hayas publicado, las cuales son ILIMITADAS para todos nuestros planes, incluyendo el plan gratuito.</p>
				</div>
			</div>
		</article>

		<article class="features-section-item">
			<div class="row collapse">
				<div class="tablet-12 medium-4 columns">
					<img class="features-section-img" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/selectrain/features-img.jpg">
				</div>

				<div class="tablet-12 medium-8 columns">
					<p class="features-section-text">Tienes la posibilidad de publicar actualizaciones (apertura/cierre de vacantes, artículos, noticias, etc.) en el “Muro” de tu empresa, los cuales se transmiten a todos los usuarios que le hayan dado “Me Gusta” a tu organización.</p>
				</div>
			</div>
		</article>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="features-next-footer">
					<span class="features-next">Siguiente</span>
					<a class="features-next-feature-link" href="{{ route('caracteristicas.show', 'vacantes') }}">Creación y administración de vacantes</a>
				</div>
			</div>
		</div>

	</section>

@stop
