@extends('layout.core.layout')
@section('content')
	<section id="group-wrapper">

		<div class="fx-main-content">
			<div class="fx-col-left is-hide">
				<div id="side-menu-filter" class="wrapper-side-nav sticky-side-nav">
					{{-- Render side menu filter --}}
				</div>
			</div>
			<div class="fx-col-content">

				<section id="group-content" class="group-content">
					{{-- group dinamic content  --}}
					@yield('group.content')

				</section>
			</div>

		</div>

	</section>

	<div id="modal-image-group" class="reveal-modal-main xmedium clearfix" data-reveal>
		{{-- Title modal --}}
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-group-crop'))  !!}
			<div class="title-modal-top">
				<h3 class="inner-title-modal text-center">Editar imagen</h3>
			</div>
			{{-- Content modal --}}
			<div class="content-modal">
				<div class="row">
					<div class="tablet-6 columns">
						<label class="label-terms">Ajustar la imagen</label>
						<div id="uploader-image-group" class="uploader-img-group"></div>
					</div>
					<div class="tablet-6 columns">
						<label class="label-terms">Vista previa</label>
					</div>
				</div>
				<div class="row">
					<div class="tablet-6 columns">
						<div id="image-crop-group" class="crop-group-img">
							<img id="image-group-tocrop" src="" class="image-to-crop" />
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
						<div id="preview-group-avatar" class="crop-preview-group crop-preview-img">
							<img id="group-preview-tocrop" src="" />
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
	@include('core.project.form.templates')
@stop

