@extends('layout.core.layout')

@if(isset($call))
	@section('title_site'){{{ $call->metatitle() }}}@stop
	@section('meta_description'){{{ trim($call->resumen_convocatoria) }}}@stop
	@section('meta_url'){{ URL::route('convocatoria.convocatoria', ['convocatoria' => $call->url_convocatoria]) }}@stop

	{{-- Metas by facebook --}}
	@section('meta_ob_title'){{{ $call->metatitle() }}}@stop
	@section('meta_ob_description'){{{ $call->resumen_convocatoria ? $call->resumen_convocatoria : $call->nombre_convocatoria }}}@stop
	@section('meta_ob_image'){{{ $call->imagen_convocatoria ? $call->imagen_convocatoria : Config::get('tuproyecto.image_project') }}}@stop

	{{-- Metas by twitter --}}
	@section('meta_tw_title'){{{ $call->metatitle() }}}@stop
	@section('meta_tw_description'){{{ $call->resumen_convocatoria ? $call->resumen_convocatoria : $call->nombre_convocatoria }}}@stop
	@section('meta_tw_image'){{{ $call->imagen_convocatoria ? $call->imagen_convocatoria : Config::get('tuproyecto.image_project') }}}@stop
@else
	@section('meta_url'){{ Request::url() }}@stop
	@section('meta_title'){{{ Lang::choice('call.call',0) }}}@stop
@endif

@section('content')
	<section id="calls-wrapper">
        <!-- module navigation -->

		<div class="fx-main-content">
			{{-- <div class="fx-col-left is-hide">
				<div id="side-menu-filter" class="wrapper-side-nav sticky-side-nav">
					<!-- Render side menu filter -->
				</div>
			</div> --}}
			<div class="fx-col-content">

				<section id="calls-content" class="calls-content">
                    <!-- module navigation -->
					{{-- Calls dinamic content  --}}
					@yield('call.content')
				</section>

			</div>

		</div>

	</section>

	@if (Auth::check())
		{{-- Templates apply program --}}
		@include('public.surveytemplates')
	@endif

@stop
