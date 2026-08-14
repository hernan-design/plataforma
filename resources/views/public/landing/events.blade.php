@if(isset($events) && count($events) > 0)
<section id="events-land" class="section-land events-land block-vpadding-both" data-stellar-background-ratio="0.5">
	@if(isset($parameters['title_eventos']))
		<div class="row">
			<div class="small-12 columns">
				<div class="strip-title-white">
					<h2 class="title-section-land">{{{ $parameters['title_eventos'] }}}</h2>
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="mobile-12 columns">
			<div class="content-data-list">
				<ul class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 large-block-grid-3 slick-events slick-browse browse-list-mask list-events-land">
					@if(isset($events))
						@foreach ($events as $event)
							<li class="item-events item-carousel">
								<div class="item-wrap-list radius events-item-land">
									<h5 class="events-title-land">
										<a class="events-title-anchor-land" href="{{ URL::route('calendario.evento.show', $event->url_evento) }}" title="{{ $event->nombre_evento }}">{{{ $event->nombre_evento }}}</a>
									</h5>
									<div class="event-date">
										<div>
											<span class="event-date-day">
												{{{ TuProyecto::dateFormat($event->fecha_evento, 'day') }}} <b>{{{ date('d', strtotime($event->fecha_evento)) }}}</b>
												@if(isset($event->fecha_fin_evento) && !is_null($event->fecha_fin_evento) && $event->fecha_fin_evento != $event->fecha_evento && $event->fecha_fin_evento != '')
													{{{ TuProyecto::dateFormat($event->fecha_fin_evento, 'day') }}} <b>{{{ date('d', strtotime($event->fecha_fin_evento)) }}}</b>
												@endif
											</span>
										</div>
										<div class="event-date-month-year">
											{{-- <span class="event-date-year-month">{{{ TuProyecto::dateFormat($event->fecha_evento, 'month') }}}</span> --}}
											<span class="event-date-month">mes</span>
											<span class="event-date-year">año</span>
										</div>
									</div>
									<div class="event-place">
										<p class="place">{{{ $event->lugar_evento }}}</p
										>
									</div>
								</div>
							</li>
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</section>
@endif
