@extends('core.middleware.steps', ['step' => 'entity'])

@section('step')
	<section id="general-user-info" class="content active">
		<div class="row col-equal-height">
			<div class="small-12 tablet-4 columns">
				<div class="registration-process-border">
					<div class="reg-process-info-box">
						<small class="reg-process-info-steps">PASO 3 DE 4</small>
						<h5 class="reg-process-info-title">{{ transtp('steps.entity.title') }}</h5>
						<p class="reg-process-info-text">{{ transtp('steps.entity.description') }}</p>
					</div>
				</div>
			</div>
			<div id="step-entity-form" class="small-12 tablet-8 columns">
				{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-entity')) !!}
					<div class="reg-content-box">
						<div class="row">
							<div class="small-12 columns input-field">
								<select id="codigo_clase_empre_insti" name="codigo_clase_empre_insti" class="choice-filter-class" required data-placeholder="Selecciona un tipo" placeholder="Selecciona un tipo">
									<option value="" selected disabled>Selecciona un tipo</option>
									@foreach( App\ClaseEmprendimiento::getClasses() as $value)
										<option value="{{ $value->codigo_clase_empre_insti }}">{{ $value->class_name }}</option>
									@endforeach
								</select>
								<label>Tipo:</label>
							</div>
						</div>
						<div class="row">
							<div class="small-12 columns">
								<div id="class-complementary-container">
									{{-- Render info complementary --}}
								</div>
							</div>
						</div>

						<div class="row">
							<div class="small-12 columns">
								<input type="submit" class="registration-next-email-button right button small radius btn-resetc" value="{{ strtoupper(transtp('entities.submit')) }}">
								<a href="{{ route('step.canales') }}" type="button" class="registration-next-email-button right button small radius btn-resetc">CREAR DESPUÉS</a>
							</div>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop
