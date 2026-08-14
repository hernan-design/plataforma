@php $events = App\Evento::getEvents(2); @endphp
<div class="next-events-top-section">
	<table class="data-info-events">
		<thead>
			<tr>
				<th colspan="2" class="text-center inst-color-invert">Próximos eventos</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($events as $event)
				<tr>
					<td>
						<a href="#" data-event="{{{ $event->codigo_evento }}}" title="{{{ strip_tags($event->nombre_evento) }}}" class="open-event-info">
							{{{ ucwords(strtolower(TuProyecto::cutStrictFormatString(strip_tags($event->nombre_evento),25))) }}}</a>
					</td>
					<td class="text-center">{{{ TuProyecto::dateFormat($event->fecha_evento, 'large') }}}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="2" class="text-center">
					<a href="{{ URL::route('calendario.index') }}" class="inst-color-invert">Ver todos</a>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
