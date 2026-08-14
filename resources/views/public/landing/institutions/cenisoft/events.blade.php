<section id="cenisoft-events">
	@if(isset($events) && count($events) > 0)
		<div class="container-events"> <!-- Contenido banner-->
			<div class="image-events show-for-large-up"> <!-- Contenedor de la imagen-->
				<h3>Mapeo iniciativas de mitigación Covid 19</h3>
				@if(count($events) > 0 && count($events) < 4)
					@switch(count($events))
						@case(1)
							<div class="large-2 large-offset-5">
								@foreach ($events as $event)
									<div class="column large-12">
										<div class="panel no-padding">
											<div class="panel-header">
												{!! HTML::image(($event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.no_event_image'))) !!}
											</div>
											<div class="panel-body">
												<label class="title-event"><a href="calendario/evento/{{$event->url_evento}}">{{ $event->nombre_evento }}</a></label><br>
												<label class="date-event">{{$event->fecha_evento}}</label><br>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@break
						@case(2)
							<div class="large-4 large-offset-4">
								@foreach ($events as $event)
									<div class="columns large-6">
										<div class="panel no-padding">
											<div class="panel-header">
												{!! HTML::image(($event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.no_event_image'))) !!}
											</div>
											<div class="panel-body">
												<label class="title-event"><a href="calendario/evento/{{$event->url_evento}}">{{ $event->nombre_evento }}</a></label><br>
												<label class="date-event">{{$event->fecha_evento}}</label><br>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@break
						@case(3)
							<div class="large-6 large-offset-3">
								@foreach ($events as $event)
									<div class="column large-4">
										<div class="panel no-padding">
											<div class="panel-header">
												{!! HTML::image(($event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.no_event_image'))) !!}
											</div>
											<div class="panel-body">
												<label class="title-event"><a href="calendario/evento/{{$event->url_evento}}">{{ $event->nombre_evento }}</a></label><br>
												<label class="date-event">{{$event->fecha_evento}}</label><br>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@break
					@endswitch
				@else
					<div class="large-8 large-offset-2">
						<figure class="slick-slider-cenisoft-events">
							@foreach ($events as $event)
								<div class="column large-3">
									<div class="panel no-padding">
										<div class="panel-header">
											{!! HTML::image(($event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.no_event_image'))) !!}
										</div>
										<div class="panel-body">
											<label class="title-event"><a href="calendario/evento/{{$event->url_evento}}">{{ $event->nombre_evento }}</a></label><br>
											<label class="date-event">{{$event->fecha_evento}}</label><br>
										</div>
									</div>
								</div>
							@endforeach
						</figure>
					</div>
				@endif
			</div>
			<div class="hide-for-large-up image-events">
				<h3>Mapeo iniciativas de mitigación Covid 19</h3>
				<div class="large-8 large-offset-2">
					<figure class="slick-slider-cenisoft-events">
						@foreach ($events as $event)
							<div class="column large-3">
								<div class="panel no-padding">
									<div class="panel-header">
										{!! HTML::image(($event->imagen_evento ? $event->imagen_evento : Config::get('tuproyecto.no_event_image'))) !!}
									</div>
									<div class="panel-body">
										<label class="title-event"><a href="calendario/evento/{{$event->url_evento}}">{{ $event->nombre_evento }}</a></label><br>
										<label class="date-event">{{$event->fecha_evento}}</label><br>
									</div>
								</div>
							</div>
						@endforeach
					</figure>
				</div>
			</div>
		</div>
	@endif
</section>
