@extends('layout.core.layout')

@if(isset($entity))
	@section('title_site'){{{ trim($entity->nombre_usuario) }}}@stop
	@section('meta_description'){{{ trim($entity->biografia_usuario) }}}@stop
	@section('meta_type'){{ 'article' }}@stop
	@section('meta_url'){{ URL::route('proyecto.proyecto', ['proyecto' => $entity->nickname_usuario]) }}@stop

	{{-- Metas by facebook --}}
	@section('meta_ob_title'){{{ $entity->nombre_usuario }}}@stop
	@section('meta_ob_description'){{{ trim($entity->biografia_usuario) }}}@stop
	@section('meta_ob_image'){{{ $entity->imagen_usuario ? $entity->imagen_usuario : Config::get('tuproyecto.image_project') }}}@stop

	{{-- Metas by twitter --}}
	@section('meta_tw_title'){{{ $entity->nombre_usuario }}}@stop
	@section('meta_tw_description'){{{ trim($entity->biografia_usuario) }}}@stop
	@section('meta_tw_image'){{{ $entity->imagen_usuario ? $entity->imagen_usuario : Config::get('tuproyecto.image_project') }}}@stop
@else
	@section('meta_url'){{ Request::url() }}@stop
@endif

@section('content')
	<section id="project-wrapper">

		<section id="project-content" class="project-content">
			{{-- Project dinamic content  --}}
			@yield('project.content')
		</section>

	</section>

	{{-- section title Confirm Remove Project --}}
	<script type="text/template" id="project-title-confirm-remove-tpl">
		{{ transtp('entities.remove') }}
	</script>

	{{-- Templates edit forms --}}
	@include('core.project.form.templates')
	@include('public.surveytemplates')

	{{-- Templates review programs --}}
	@if(App\RegistroSesion::getInstitution() == App\Institucion::getInstitution('innpulsa')) {
		@include('core.project.reviewprograms.review-113')
		@include('core.project.reviewprograms.review-198')
	@elseif(App\RegistroSesion::getInstitution() == App\Institucion::getInstitution('dinamiza'))
		@include('core.project.reviewprograms.review-232')
	@elseif(App\RegistroSesion::getInstitution() == App\Institucion::getInstitution('cenisoft'))
		@include('core.project.reviewprograms.review-365')
	@endif
@stop
