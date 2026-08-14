@extends('layout.core.layout')

@section('content')

	<section id="user-wrapper">

		<section id="user-content" class="user-content">
			{{-- User dynamic content  --}}
			@yield('user.content')
		</section>

	</section>

	{{-- Template for image loader --}}
	<script type="text/template" id="qq-avatar-template">
	    <div class="qq-uploader-selector qq-uploader-avatar" qq-drop-area-text="Arrastra una imagen aquí">
	    	<div class="qq-upload-drop-area-selector" qq-hide-dropzone>
                <span class="qq-upload-drop-area-text-selector"></span>
            </div>
            <small class="description-field-form">
            	<span>Arrastra el cuadrado para cambiar la posición y el tamaño.</span>
	            <div class="qq-upload-button-selector qq-upload-btn-avatar">
		            <div>Cambiar foto.</div>
		        </div>
            </small>
            <ul class="qq-upload-list-selector" aria-live="polite" aria-relevant="additions removals">
            	<li></li>
            </ul>
	        <dialog class="qq-alert-dialog-selector">
	            <div class="qq-dialog-message-selector"></div>
	            <div class="qq-dialog-buttons">
	                <button class="qq-cancel-button-selector">Cerrar</button>
	            </div>
	        </dialog>
	        <dialog class="qq-confirm-dialog-selector">
	            <div class="qq-dialog-message-selector"></div>
	            <div class="qq-dialog-buttons">
	                <button class="qq-cancel-button-selector">No</button>
	                <button class="qq-ok-button-selector">Si</button>
	            </div>
	        </dialog>
	        <dialog class="qq-prompt-dialog-selector">
	            <div class="qq-dialog-message-selector"></div>
	            <input type="text">
	            <div class="qq-dialog-buttons">
	                <button class="qq-cancel-button-selector">Cancelar</button>
	                <button class="qq-ok-button-selector">Continuar</button>
	            </div>
	        </dialog>
	    </div>
	</script>

	{{-- Templates edit forms --}}
	@include('core.user.form.templates')
	@if(App\RegistroSesion::getInstitution() == App\Institucion::getInstitution('compensar'))
		@include('core.project.reviewprograms.review-441')
	@endif
@stop
