@if (Auth::check())
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-article')) !!}
		<div class="row">
			<div class="tablet-4 columns input-field">
				<input type="text" name="nombre_contenido" id="nombre_contenido" value="" required class="validate" >
				<label for="nombre_contenido">Título</label>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="codigo_tipo_cont_institucion" name="codigo_tipo_cont_institucion" class="" required data-placeholder="Seleccione una categoría" placeholder="Seleccione una categoría">
					<option value="" disabled selected>Seleccione una categoría</option>
					@foreach( App\TipoContenido::getTypes() as $value )
						<option value="{{ $value->codigo_tipo_cont_institucion }}">{{ $value->nombre_tipo_contenido }}</option>
					@endforeach
				</select>
				<label>Categoría:</label>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="codigo_canal" name="codigo_canal" class="" required data-placeholder="Seleccione canal" placeholder="Seleccione canal">
					<option value="" disabled selected>Seleccione canal</option>
					@foreach( App\Canal::getChannels() as $value )
						<option value="{{ $value->codigo_canal }}">{{ $value->nombre_canal }}</option>
					@endforeach
				</select>
				<label>Canal:</label>
			</div>
		</div>
		<div class="row">
			<div class="tablet-12 columns input-field">
				<textarea required name="resumen_contenido" id="resumen_contenido" cols="50" rows="4" class="materialize-textarea validate" data-abide-validator="maxLength" data-maxlen="200"></textarea>
				<label for="resumen_contenido">Resumen</label>
			</div>
		</div>
		<div class="save-section">
			<div class="row">
				<div class="tablet-2 tablet-offset-4 columns">
					<a href="<%- Route.route('blog.index') %>" class="button white btn-shadow xmedium expand radius">Cancelar</a>
				</div>
				<div class="tablet-2 columns text-right end">
					<input type="submit" value="Guardar" class="button xmedium sky-blue btn-shadow expand radius">
				</div>
			</div>
		</div>
	{!! Form::close() !!}

@else
	@include('public.unauth', array('message' => Lang::get('forum.unauth.theme')))
@endif
