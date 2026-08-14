@if (Auth::check())
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-promotion')) !!}
		<div class="row">
			<div class="mobile-12 columns">
				<label>Imagen principal:</label>
				<small class="description-field-form">Elige una imagen principal para publicar tu promoción.</small>
				<div id="promotion-main-image" class="wrapper-image-edit image-area-drop product-img-main">
					{{-- Render image template--}}
				</div>
			</div>
		</div>
		<br>
		<div class="row col-equal-height valign-center">
			<div class="tablet-6 columns input-field">
				<select id="tipo_promocion" name="tipo_promocion" class="" required data-placeholder="Seleccione clasificación" placeholder="Seleccione clasificación">
					<option value="" disabled selected>Seleccione clasificación</option>
					@foreach( App\Promocion::$typePromo as $key => $value )
						<option value="{{ $key }}" <%- typeof tipo_promocion != 'undefined' ? tipo_promocion == {{ $key }} ? 'selected' : '' : '' %>>{{ $value }}</option>
					@endforeach
				</select>
				<label>Clasificación:</label>
			</div>
			<div class="tablet-6 columns input-field choice-product">
				<select name="codigo_producto" id="codigo_producto" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('marketplace.index') ) %>" data-initial-value="<%- typeof codigo_producto != 'undefined' && tipo_promocion == window._tp.getTypePromo['promotion'] ? codigo_producto : '' %>" data-list="true" data-placeholder="Seleccione un producto" placeholder="Seleccione un producto">
				</select>
				<label>Producto:</label>
			</div>
		</div>

		<div class="row">
			<div class="tablet-5 columns input-field">
				<input type="text" name="fecha_inicio_promocion" id="fecha_inicio_promocion" value="<%- typeof fecha_inicio_promocion != 'undefined' ? fecha_inicio_promocion : '' %>" required pattern="date" class="datepk" data-abide-ignore>
				<label for="fecha_inicio_promocion">Fecha inicio</label>
			</div>
			<div class="tablet-5 columns input-field">
				<input type="text" name="fecha_fin_promocion" id="fecha_fin_promocion" value="<%- typeof fecha_fin_promocion != 'undefined' ? fecha_fin_promocion : '' %>" required pattern="date" class="datepk" data-abide-ignore>
				<label for="fecha_fin_promocion">Fecha fin</label>
			</div>
			<div class="tablet-2 columns input-field input-percentage">
				<input type="text" name="porcentaje_descuento_promocion" id="porcentaje_descuento_promocion" value="<%- typeof porcentaje_descuento_promocion != 'undefined' && !_.isNull(porcentaje_descuento_promocion) ? porcentaje_descuento_promocion : '0' %>" class="percentage-mask">
				<label for="porcentaje_descuento_promocion">Procentaje de descuento:</label>
			</div>
		</div>

		<div class="row">
			<div class="tablet-12 columns input-field">
				<textarea  required name="descripcion_promocion" id="descripcion_promocion" cols="50" rows="4" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"><%- typeof descripcion_promocion != 'undefined' && !_.isNull(descripcion_promocion) ? descripcion_promocion : '' %></textarea>
				<label for="descripcion_promocion">Describe tu promoción</label>
			</div>
		</div>

		<div class="save-section">
			<div class="row">
				<% if(typeof codigo_estado != 'undefined' && codigo_estado != window._tp.getState['pending']){ %>
					<div class="tablet-2 tablet-offset-4 columns">
						<a href="<%- Route.route('marketplace.ventas.promocion.index') %>" class="button white btn-shadow xmedium expand radius">Cancelar</a>
					</div>
					<div class="tablet-2 columns text-right end">
						<input type="submit" value="Guardar" class="button xmedium sky-blue btn-shadow expand radius">
					</div>
				<% }else{ %>
					<div class="tablet-2 tablet-offset-4 columns">
						<a href="<%- Route.route('marketplace.ventas.promocion.index') %>" class="button white btn-shadow xmedium expand radius">Cancelar</a>
					</div>
					<div class="tablet-2 columns text-right end">
						<input type="submit" value="Guardar" class="button xmedium sky-blue btn-shadow expand radius">
					</div>
				<% } %>
					
			</div>
		</div>
	{!! Form::close() !!}

@else
	@include('public.unauth', array('message' => Lang::get('forum.unauth.theme')))
@endif
