@extends('layout.core.layout')

@if(isset($event))
	@section('title_site'){{ trim($event->nombre_evento) }}@stop
	@section('meta_url'){{ URL::route('calendario.evento.show', ['evento' => $event->url_evento]) }}@stop
	@section('meta_description'){{{ !empty($event->resumen_evento) ? trim($event->resumen_evento) : trim($event->nombre_evento) }}}@stop
    @section('meta_keywords'){{{ trim($event->tags_content) }}}@stop
    
    @if(!empty($event->url_canonica) && !is_null($event->url_canonica))
        @section('canonical_url'){{{ trim($event->url_canonica) }}}@stop
    @endif

    @if(!empty($event->directivas))
        @section('directivas'){{{ $event->directivas }}}@stop
    @endif

	{{-- Metas by facebook --}}
	@section('meta_ob_title'){{{ !empty($event->nombre_facebook) ? trim($event->nombre_facebook) : trim($event->nombre_evento) }}}@stop
	@section('meta_ob_description'){{{ !empty($event->descripcion_facebook) ? trim($event->descripcion_facebook) : !empty($event->resumen_evento) ? trim($event->nombre_evento) : trim($event->resumen_evento) }}}@stop
	@section('meta_ob_image'){{{ !empty($event->imagen_facebook) ? $event->imagen_facebook : $event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.image_forum') }}}@stop

	{{-- Metas by twitter --}}
	@section('meta_tw_title'){{{ !empty($event->nombre_twitter) ? trim($event->nombre_twitter) : trim($event->nombre_evento) }}}@stop
	@section('meta_tw_description'){{{ !empty($event->descripcion_twitter) ? trim($event->descripcion_twitter) : !empty($event->resumen_evento) ? trim($event->nombre_evento) : trim($event->resumen_evento) }}}@stop
	@section('meta_tw_image'){{{ !empty($event->imagen_twitter) ? $event->imagen_twitter : $event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.image_forum') }}}@stop
@else
	@section('meta_url'){{ Request::url() }}@stop
@endif

@section('content')
	<section id="calendar-wrapper">
		<section id="calendar-content" class="calendar-content">
			{{-- Calendar dinamic content  --}}
			@yield('calendar.content')
		</section>
	</section>

	<script type="text/template" id="modal-participate-event-tpl">
		<p>{{ transtp('event.modal') }}</p>
	</script>
@stop
