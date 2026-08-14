@extends('layout.core.layout')
@section('content')

	<section id="mentoring-eval-session-wrapper">
		<h3 class="inst-color-invert">Evaluacion sesión de mentoria</h3>

		<div class="row collapse">
			<div class="small-12 columns">
				<div class="row">
					<div class="large-12 columns">
						<p>{{{ sprintf('%s %s / %s %s', $event->fecha_evento, $event->hora_inicio_evento, $event->fecha_fin_evento, $event->hora_fin_evento) }}}</p>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<p>{{{ $mentoring->descripcion_mentoria }}}</p>
					</div>
				</div>
				<div class="row">
					@if(isset($objectives))
						<ul class="list-data-aside">
							@foreach($objectives as $objective)
							<li>
								{{{ $objective->descripcion_objetivo_mentoria }}}
							</li>
							@endforeach
						</ul>
					@endif
				</div>

				{{ Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-eval') ) }}
					<div class="row">
						<div class="large-12 columns">
							<label for="comentario__evaluacion_mentoria">
								<span class="required-star">*</span>
								Comentario
							</label>
							{{ Form::textarea('comentario__evaluacion_mentoria', null,
								array(
									'class' => '',
									'rows' => '3',
									'placeholder' => 'Comentario',
									'required' => 'required'
								))
							}}
						</div>
					</div>

					@if(isset($items))
						@foreach($items as $item)
							<div class="row">
								<div class="large-10 columns">
									{{{ $item->nombre_item_general_mentoria }}}
								</div>
								<div class="large-1 columns">
									{{ Form::radio('cumplimiento_item_mentoria_'.$item->codigo_item_general_mentoria, '1', true); }}
									SI
								</div>
								<div class="large-1 columns end">
									{{ Form::radio('cumplimiento_item_mentoria_'.$item->codigo_item_general_mentoria, '0'); }}
									NO
								</div>
							</div>
						@endforeach
					@endif

					<div class="row">
						<div class="right large-2 columns text-right">
							{{ Form::submit('Enviar', array('class' => 'button tiny expand')) }}
						</div>
					</div>
			    {{ Form::close() }}
			</div>
		</div>

	</section>
@stop
