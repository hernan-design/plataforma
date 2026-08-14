@if (Auth::check())
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-entity')) !!}
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

		<div class="row save-section">
			<div class="small-12 columns">
				<input type="submit" class="right button small sky-blue radius" value="{{ strtoupper(transtp('entities.submit')) }}">
			</div>
		</div>
@else
	@include('public.unauth', array('message' => Lang::get('forum.unauth.theme')))
@endif
