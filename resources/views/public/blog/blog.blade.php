@extends('layout.core.layout')

@if(isset($article))
	@section('title_site'){{{ trim($article->nombre_contenido) }}}@stop
	@section('meta_description'){{{ trim($article->resumen_contenido) }}}@stop
	@section('meta_keywords'){{{ trim($article->tags_content) }}}@stop
	@section('meta_type'){{ 'article' }}@stop
    @section('meta_url'){{ URL::route('blog.categoria.articulo', ['category' => $article->url_tipo_contenido, 'article' => $article->url_contenido]) }}@stop
    
    @if(!empty($article->url_canonica) && !is_null($article->url_canonica))
        @section('canonical_url'){{{ trim($article->url_canonica) }}}@stop
    @endif

    @if(!empty($article->directivas))
        @section('directivas'){{{ $article->directivas }}}@stop
    @endif

	{{-- Metas by facebook --}}
	@section('meta_ob_title'){{{ !empty($article->nombre_facebook) ? trim($article->nombre_facebook) : trim($article->nombre_contenido) }}}@stop
	@section('meta_ob_description'){{{ !empty($article->descripcion_facebook) ? trim($article->descripcion_facebook) : trim($article->resumen_contenido) }}}@stop
	@section('meta_ob_image'){{{ !empty($article->imagen_facebook) ? $article->imagen_facebook : $article->imagen_contenido ? $article->imagen_contenido : Config::get('tuproyecto.image_project') }}}@stop

	{{-- Metas by twitter --}}
	@section('meta_tw_title'){{{ !empty($article->nombre_twitter) ? trim($article->nombre_twitter) : trim($article->nombre_contenido) }}}@stop
	@section('meta_tw_description'){{{ !empty($article->descripcion_twitter) ? trim($article->descripcion_twitter) : trim($article->resumen_contenido) }}}@stop
	@section('meta_tw_image'){{{ !empty($article->imagen_twitter) ? $article->imagen_twitter : $article->imagen_contenido ? $article->imagen_contenido : Config::get('tuproyecto.image_project') }}}@stop
@else
	@section('meta_url'){{ Request::url() }}@stop
@endif

@section('content')

	<section id="blog-wrapper">
		<div class="fx-main-content">

			<div class="fx-col-left is-hide">
				<div id="side-menu-filter" class="filter-slide-sidenav-left">
					{{-- Render side menu filter --}}
				</div>
			</div>
			<div class="fx-col-content">
				<section id="blog-content" class="blog-content clearfix">
					{{-- Content dinamic content  --}}
					@yield('blog.content')
				</section>
			</div>

		</div>
	</section>

	{{-- modal crop image article --}}
	<div id="modal-image-article" class="reveal-modal-main xmedium clearfix" data-reveal>
		{{-- Title modal --}}
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-article-crop'))  !!}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Editar imagen</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				<div class="row">
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Ajustar la imagen</label>
						<div id="uploader-image-article" class="uploader-img-article uploader-image"></div>
					</div>
					<div class="tablet-6 columns">
						<label class="label single bold-text inst-color-secondary">Vista previa</label>
						<span class="text-xmd light-text">Tamaño real de la imagen (780px X 520px)</span>
					</div>
				</div>
				<div class="row">
					<div class="tablet-6 columns">
						<div id="image-crop-article" class="crop-article-img crop-load-img">
							<img id="image-article-tocrop" src="" class="image-to-crop" />
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
						<div id="preview-article-avatar" class="crop-preview-article crop-preview-img">
							<img id="article-preview-tocrop" src="" />
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
@stop
