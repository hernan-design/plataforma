@extends('layout.core.layout')

@if(isset($course))
	@section('title_site'){{ trim($course->nombre_curso) }}@stop
	@section('meta_url'){{ URL::route($course->inscripcion ? 'aprende.contenido' : 'aprende.categoria.curso', ['type' => $course->url_tipo_curso, 'category' => $course->url_categoria_curso, 'course' => $course->url_curso]) }}@stop
	@section('meta_description'){{{ !empty($course->descripcion_curso) ? trim($course->descripcion_curso) : trim($course->nombre_curso) }}}@stop
    @section('meta_keywords'){{{ trim($course->tags_content) }}}@stop

    @if(!empty($course->url_canonica) && !is_null($course->url_canonica))
        @section('canonical_url'){{{ trim($course->url_canonica) }}}@stop
    @endif

    @if(!empty($course->directivas))
        @section('directivas'){{{ $course->directivas }}}@stop
    @endif

	{{-- Metas by facebook --}}
	@section('meta_ob_title'){{{ !empty($course->nombre_facebook) ? trim($course->nombre_facebook) : trim($course->nombre_curso) }}}@stop
	@section('meta_ob_description'){{{ !empty($course->descripcion_facebook) ? trim($course->descripcion_facebook) : !empty($course->descripcion_curso) ? trim($course->nombre_curso) : trim($course->descripcion_curso) }}}@stop
	@section('meta_ob_image'){{{ !empty($course->imagen_facebook) ? $course->imagen_facebook : $course->imagen_curso ? $course->imagen_curso : Config::get('tuproyecto.image_forum') }}}@stop

	{{-- Metas by twitter --}}
	@section('meta_tw_title'){{{ !empty($course->nombre_twitter) ? trim($course->nombre_twitter) : trim($course->nombre_curso) }}}@stop
	@section('meta_tw_description'){{{ !empty($course->descripcion_twitter) ? trim($course->descripcion_twitter) : !empty($course->descripcion_curso) ? trim($course->nombre_curso) : trim($course->descripcion_curso) }}}@stop
	@section('meta_tw_image'){{{ !empty($course->imagen_twitter) ? $course->imagen_twitter : $course->imagen_curso ? $course->imagen_curso : Config::get('tuproyecto.image_forum') }}}@stop
@else
	@section('meta_url'){{ Request::url() }}@stop
@endif

@section('content')

	<section id="course-wrapper">

		<section id="course-content" class="course-content">
			{{-- Course dinamic content  --}}
			@yield('learn.content')
		</section>

	</section>
	{{-- Templates edit forms --}}
	@include('core.project.form.templates')
@stop
