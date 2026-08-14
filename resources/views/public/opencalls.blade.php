@php $openCalls = App\Convocatoria::getOpenCalls(); @endphp
@if(count($openCalls) >0)
	<div class="ad-aside no-border-aside">
		<div class="title-section text-center">
			<h6 class="inner-title-section">Convocatorias</h6>
		</div>
		<div class="carrousel-aside">
			<ul class="small-block-grid-1 slick-aside list-opencall">
				@foreach ($openCalls as $call)
					<li class="item-opencall">
						@if($call->tipo_convocatoria === App\Convocatoria::getCallType('external'))
							<a href="{{ $call->url_externa_convocatoria }}" title="{{ $call->nombre_convocatoria }}" target="_blank">
								{!! HTML::image($call->banner_convocatoria, $call->nombre_convocatoria) !!}
							</a>	
						@else
							<a href="{{ URL::route('convocatoria.convocatoria', $call->url_convocatoria) }}" title="{{ $call->nombre_convocatoria }}">
								{!! HTML::image($call->banner_convocatoria, $call->nombre_convocatoria) !!}
							</a>
						@endif
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
