@if (Auth::check())
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-create-product')) !!}
		<div class="row col-equal-height valign-center">
			<div class="tablet-4 columns input-field">
				<select id="type_owner" name="type_owner" class="" required data-placeholder="Elige un propietario" placeholder="Elige un propietario">
					<option value="" disabled selected>Elige un propietario</option>
                    @if(App\Institucion::getMartketplaceOnlyEntitiesOwner(App\RegistroSesion::getInstitution()) )
					    <option value="{{ App\Usuario::typeUser('entity') }}"> {{ transtp('marketplace.create.typeownerentity') }} </option>
                    @else
                        <option value="{{ App\Usuario::typeUser('person') }}">Usuario</option>
                        <option value="{{ App\Usuario::typeUser('entity') }}">{{ transtp('marketplace.create.typeownerentity') }} </option>
                    @endif
				</select>
				<label>Propietario:</label>
			</div>
			<div class="tablet-3 columns input-field">
				<select id="seg_codigo_usuario" name="seg_codigo_usuario" class="choice-entities-product" required data-placeholder="Elige una empresa" placeholder="Elige una empresa">
					<option value="" disabled selected>Elige una empresa</option>
					@foreach(App\Entidad::getEntitysList() as $entity)
						<option value="{{ TuProyecto::encryptSrcParams([$entity->key]) }}">{{ $entity->value }}</option>
					@endforeach
				</select>
				<label>Empresa:</label>
			</div>
			<div class="mobile-1 small-1 columns">
				 <a id="btn-modal-base-create-entity" class="btn-floating small btn-small waves-effect waves-light inst-bgcolor-secondary icon-circle white-text" data-tooltip aria-haspopup="true" title="Crear entidad" data-reveal-id="modal-base-create-entity" data-options="disable_for_touch:true"><i class="mdi mdi-plus"></i></a>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="codigo_clase_producto" name="codigo_clase_producto" class="" required data-placeholder="Seleccione clasificación" placeholder="Seleccione clasificación">
					<option value="" disabled selected>Seleccione clasificación</option>
                    @if(App\Institucion::getMartketplaceOnlyServices(App\RegistroSesion::getInstitution()) )
                        <option value="{{App\ClaseProducto::getClassProduct('service')}}">Servicio</option>
                    @else
                        @foreach( App\ClaseProducto::getClassProductList() as $key => $value )
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    @endif
				</select>
				<label>Clasificación:</label>
			</div>
		</div>

		<div class="row">
			<div class="tablet-12 columns input-field">
				<input type="text" name="nombre_producto" id="nombre_producto" value="" required class="validate" >
				<label for="nombre_producto">Nombre</label>
			</div>
		</div>

		<div class="row">
			<div class="tablet-4 columns input-field">
				<select name="codigo_categoria_prod_insti" id="codigo_categoria_prod_insti" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('marketplace.categoriaproducto.index') ) %>"  data-param="category" data-initial-value="<%- typeof(categoria) !== 'undefined' ? categoria : '' %>"   data-placeholder="Seleccione Categoría" placeholder="Seleccione Categoría }}" required>
				</select>
				<label for="categoria_producto">Categoría:</label>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="modalidad_prestacion_servicio" name="modalidad_prestacion_servicio" class="choice-modality-product" data-placeholder="Elige una modalidad" placeholder="Elige una modalidad">
					<option value="" disabled selected>Elige una modalidad</option>
					<option value="1">{{ transtp('marketplace.create.modality.virtual') }}</option>
					<option value="2">{{ transtp('marketplace.create.modality.semipresencial') }}</option>
					<option value="3">{{ transtp('marketplace.create.modality.presencial') }}</option>
				</select>
				<label>Modalidad:</label>
			</div>
			<div class="tablet-2 columns input-field">
				<input type="text" name="precio_producto" id="precio_producto" value="" placeholder="Precio del producto" class="currency-mask-cop" required>
				<label for="precio_producto">Precio:</label>
			</div>
			<div class="tablet-2 columns input-field">
				<input type="text" name="cantidad_producto" id="cantidad_producto" value="" placeholder="Unidades del producto" class="spinner-quantity">
				<label for="cantidad_producto">Unidades:</label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="tablet-6 columns">
				<input name="domicilio_producto" id="domicilio_producto" type="checkbox" value="true" class="filled-in">
				<label for="domicilio_producto" class="thin-text">Envío Domicilio</label>
			</div>
			<div class="tablet-6 columns">
				<input name="producto_oferta" id="producto_oferta" type="checkbox" value="true" class="filled-in">
				<label for="producto_oferta" class="thin-text">Recibir Oferta</label>
			</div>
			{{-- <div class="tablet-3 columns">
				<input name="acuerdo_producto" id="acuerdo_producto" type="checkbox" value="true" class="filled-in">
				<label for="acuerdo_producto" class="thin-text">Acuerdo de servicio</label>
			</div> --}}
            <div class="tablet-3 columns">
				<input name="producto_sin_precio" id="producto_sin_precio" type="checkbox" value="true" class="filled-in">
				<label for="producto_sin_precio" class="thin-text">Producto sin precio</label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="tablet-6 columns">
				<label>Imagen principal:</label>
				<small class="description-field-form">Elige una imagen principal para publicar tu producto.</small>
				<div id="product-main-image" class="wrapper-image-edit image-area-drop product-img-main">
					{{-- Render image template--}}
				</div>
			</div>
			<div class="tablet-6 columns">
				<label>Galería de imágenes:</label>
				<small class="description-field-form">Elige varias imágenes para mostrar una vista más detallada de tu producto.</small>
				<ul id="product-gallery-edit" class="mobile-block-grid-2 tablet-block-grid-3">
					{{-- Render attachments products --}}
				</ul>
			</div>
		</div>

		<div class="row">
			<div class="tablet-6 columns input-field">
				<textarea required name="resumen_producto" id="resumen_producto" cols="50" rows="4" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
				<label for="resumen_producto">Describe tu producto</label>
			</div>

			<div class="tablet-6 columns">
				<label for="resumen_producto">Descripción Detallada</label>
				<section id="form-product-editor">
					{{-- Render component pulse-editor --}}
					<input type="hidden" name="descripcion_producto">
				</section>
			</div>
		</div>

		<div class="save-section">
			<div class="row">
				<div class="tablet-2 tablet-offset-4 columns">
					<a href="<%- Route.route('marketplace.index') %>" class="button white btn-shadow xmedium expand radius">Cancelar</a>
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
