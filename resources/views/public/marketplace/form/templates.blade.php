{{-- ----------------- --}}
{{-- Editing templates --}}
{{-- ----------------- --}}
@if(Auth::check())
	<script type="text/template" id="edit-product-basic-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-infobasic-product') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<input type="text" name="nombre_producto" id="nombre_producto" value="<%- nombre_producto %>" placeholder="" required class="validate">
					<label for="nombre_producto">Nombre de producto</label>
				</div>
			</div>
			<% if(!_.isUndefined(seg_codigo_usuario) && !_.isNull(seg_codigo_usuario)){ %>
				<div class="row">
					<div class="small-12 columns input-field">
						<select name="seg_codigo_usuario" class="" data-placeholder="Seleccione una empresa" placeholder="Seleccione una empresa">
							<option value="" disabled selected>Seleccione una empresa</option>
							@foreach( App\Entidad::getEntitysList() as $entity)
								<option value="{{ $entity->key }}" <%- seg_codigo_usuario == '{{ $entity->key }}' ? 'selected': ''%> >{{ $entity->value }}</option>
							@endforeach
						</select>
						<label>Emprendimiento asociado:</label>
					</div>
				</div>
			<% } %>
			<div class="row">
				<div class="columns mobile-4 mobile-offset-8 tablet-3 tablet-offset-9">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	<script type="text/template" id="edit-product-summary-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-product-summary') ) !!}
			<div class="row col-equal-height valign-bottom">
				<div class="mobile-9 tablet-10 columns">
					<textarea name="resumen_producto" placeholder="Ingresa resumen del producto" class="edit-field-text materialize-textarea validate" required data-abide-validator="maxWords" data-maxlen="200"><%- resumen_producto %></textarea>
				</div>
				<div class="mobile-3 tablet-2 columns">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	<script type="text/template" id="edit-product-infoclassification-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-infoclassification-product') ) !!}
			<div class="row">
				<div class="columns small-12 input-field">
					<select name="codigo_categoria_prod_insti" class="" required data-placeholder="Seleccione una categoría" placeholder="Seleccione una categoría">
						<option value="" disabled selected>Seleccione una categoría</option>
						@foreach( App\CategoriaProducto::getCategories() as $key => $value)
							<option value="{{ $key }}" <%- codigo_categoria_prod_insti == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
						@endforeach
					</select>
					<label>Categoría:</label>
				</div>
			</div>
			<div class="row">
				<div class="columns small-12 input-field">
					<select name="codigo_clase_producto" id="codigo_clase_producto" class="" required data-placeholder="Seleccione clase de producto" placeholder="Seleccione clase de producto">
						<option value="" disabled selected>Seleccione clase de producto</option>
						@foreach( App\ClaseProducto::getClassProductList() as $key => $value)
							<option value="{{ $key }}" <%- codigo_clase_producto == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
						@endforeach
					</select>
					<label>Clasificación:</label>
				</div>
			</div>
			<div class="row">
				<div class="columns small-12 input-field">
					<input type="text" id="precio_producto" name="precio_producto" value="<%- precio_producto %>" placeholder="" class="currency-mask-cop validate" required>
					<label for="precio_producto">Precio</label>
				</div>
			</div>
			<div class="row">
				<div class="columns small-12 input-field">
					<div id="clasifications-options">
						{{-- Render clasifications options --}}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="columns mobile-4 mobile-offset-8 tablet-3 tablet-offset-9">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- template product modality --}}
	<script type="text/template" id="edit-product-modality-form-tpl">
		<select name="modalidad_prestacion_servicio" id="modalidad_prestacion_servicio" class="" required data-placeholder="Seleccione prestación de servicio" placeholder="Seleccione prestación de servicio">
			<option value="" disabled selected>Seleccione prestación de servicio</option>
			@foreach( App\Producto::$provisionServices as $key => $value)
				<option value="{{ $key }}" <%- modalidad_prestacion_servicio == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
			@endforeach
		</select>
		<label>Modalidad:</label>
	</script>

	{{-- template product quantity --}}
	<script type="text/template" id="edit-product-quantity-form-tpl">
		<div class="row">
			<div class="columns small-6 input-field">
				<input type="text" name="cantidad_producto" id="quantity-buy" value="<%- cantidad_producto %>" class="spinner-quantity no-change" required pattern="greater_than_zero" />
				<label for="quantity-buy" class="active">Cantidad:</label>
			</div>
			<div class="columns small-6 input-field">
				<input type="checkbox" name="domicilio_producto" id="domicilio_producto" placeholder="envío domicilio" class="filled-in" <%- domicilio_producto == true ? 'checked' : '' %> >
				<label for="domicilio_producto">Envío Domicilio</label>
			</div>
		</div>
	</script>

	<script type="text/template" id="edit-product-description-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-description-product') ) !!}
			<div class="row">
				<div class="mobile-12 columns">
					<section id="form-product-editor">
                    	{{-- Render component pulse-editor --}}
                    	<input type="hidden" name="descripcion_producto" value="<%- descripcion_producto %>" required>
                	</section>
				</div>
			</div>
			<div class="row">
				<div class="mobile-12 tablet-5 tablet-offset-7 columns">
				  	<ul class="inline-list-grid">
				  		<li><button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button></li>
				  		<li>{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}</li>
				  	</ul>
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	<script type="text/template" id="edit-product-location-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-product-location') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<select name="codigo_ciudad" class="browser-default choice-select" required data-placeholder="Seleccione una ubicación" placeholder="Seleccione una ubicación">
						<option value=""></option>
						@foreach( App\Ciudad::getCities() as $city)
							<option value="{{ $city->key }}" <%- 'codigo_ciudad' == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
						@endforeach
					</select>
					<label>Ciudad:</label>
				</div>
			</div>

			<div class="row">
				<div class="columns mobile-4 mobile-offset-8 tablet-3 tablet-offset-9">
					{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>
@endif

{{-- --------------------------- --}}
{{-- for edit sections templates --}}
{{-- --------------------------- --}}
{{-- Image main Product template --}}
<script type="text/template" id="main-image-product-tpl">
	<img src="<%- imagen_producto %>" alt="<%- nombre_producto %>" title="<%- nombre_producto %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
	<% if(owner){ %>
		<button id="change-image-product" class="edit-photo change-photo small">
			<div class="edit-photo-content">
				<i class="mdi mdi-camera mdi-24 vcenter"></i>
				<span>Añadir una Imagen</span>
				<span class="editing-photo-message">Cambiar Imagen</span>
			</div>
		</button>
	<% } %>
</script>

{{-- Info Entity Product template --}}
<script type="text/template" id="info-entity-product-tpl">
	<a href="<%= tipo_usuario == window._tp.typeUser['person'] ? window.Misc.urlFull( url_profile  ) : window.Misc.urlFull(Route.route('proyecto.proyecto', {'proyecto': nickname_entidad}) ) %>" title="<%- nombre_entidad %>" class= "name-user text-md" target="_blank">
		<span class="dark-text"><%-  tipo_usuario == window._tp.typeUser['person'] ? nombre_usuario : nombre_entidad %></span>
	</a>
	<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:left" aria-expanded="false" data-edit-template="infobasic"><i class="mdi mdi-pencil"></i></button>
</script>

{{-- Info Basic Product template --}}
<script type="text/template" id="info-basic-product-tpl">
	<h3 class="title-detail-product-main lighter-header clean-header dark-text">
		<span class="field-text"><%- nombre_producto %></span>
		<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:left" aria-expanded="false" data-edit-template="infobasic"><i class="mdi mdi-pencil"></i></button>
	</h3>
</script>

{{-- Info summary product template --}}
<script type="text/template" id="info-summary-product-tpl">
	<div class="content-summary-product field-for-edit edit-field clearfix" data-edit-template="summary">
		<ul class="field-and-button-edit align-top no-bullet">
			<li>
				<p class="text-summary-product text-md dark-text prepared-to-edit ellipsis wrap-text"><%- resumen_producto %><%= !resumen_producto.length && owner ? '<span class="edit-no-result text-dmd">Ingresa resumen del producto</span>' : '' %></p>
			</li>
			<li class="has-image">
				<button class="edit-field-button btn-clean-margin"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>

{{-- Info Classification Product template --}}
<script type="text/template" id="info-classification-product-tpl">
	<button class="edit-field-button edit-field right" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:left" aria-expanded="false" data-edit-template="infoclassification"><i class="mdi mdi-pencil"></i></button>

	{!! Form::open( ['action' => null, 'data-abide' => '', 'id' => 'form-buy-product'] ) !!}
		<ul class="product-detail-features text-md">
			<li>
				<em class="text-md light-text">Categoría: </em>
				<span class="dark-text"><%- nombre_categoria_producto %></span>
			</li>
			<li>
				<em class="text-md light-text">Clasificación:</em>
				<span class="dark-text"><%- nombre_clase_producto %></span>
			</li>
			<% if(window._tp.classProduct['service'] != codigo_clase_producto) { %>
				<li>
					<em class="text-md light-text">Envío Domicilio: </em>
					<span class="dark-text"><%- domicilio_producto ? 'Si':'No' %></span>
				</li>
			<% } %>
			<% if(window._tp.classProduct['service'] == codigo_clase_producto) { %>
				<li>
					<em class="text-md light-text">Modalidad: </em>
					<span class="dark-text"><%- modalidad_texto %></span>
				</li>
			<% } %>

			<% if(manejo_unidades) { %>
				<li>
					<em class="text-md light-text">Disponibles: </em>
					<span class="dark-text"><%- cantidad_producto > 0 ? cantidad_producto : 'Agotado' %></span>
				</li>
				<li>
					<div class="row valign-middle">
						<div class="mobile-3 tablet-2 columns"><em class="text-md light-text">Cantidad: </em></div>
						<div class="mobile-6 tablet-2 columns ends">
							<input type="text" name="unidades" id="quantity-buy" value="1" class="spinner-quantity no-change validate" required pattern="greater_than_zero" />
						</div>
					</div>
				</li>
			<% } %>
			<li>
				<div class="panel-section-form gray-light-alt-bg">
					<div class="row valign-middle">
						<div class="mobile-5 small-4 medium-3 columns">
							{!! Form::submit(transtp('marketplace.buyProduct'), ['class' => 'button small sky-blue btn-shadow radius expand btn-clean-margin']) !!}
						</div>
						<div class="mobile-7 small-8 medium-9 columns">
							<% if (activacion_promocion) { %>
								<% if(descuento > 0){ %>
									<span class="gray-light-text heavy-text text-line-through">
										<%- precio_producto > 0 ? window.copCurrencyF.to(parseFloat(precio_producto)) :  window.copCurrencyF.to(parseFloat(0)) %>
									</span>
									<br>
									<span class="gray-light-text heavy-text text-xbg">
										(-<%- porcentaje_descuento %>%)
									</span>
									<span class="gray-dark-text heavy-text text-xbg">
										<%- window.copCurrencyF.to(parseFloat(descuento)) %>
										<em class="gray-light-text text-xbg normal-text">iva incl.</em>
									</span>
								<% } %>
							<% } else { %>
								<span class="gray-dark-text heavy-text text-xbg">
									<%  if (precio_producto > 0 && !producto_sin_precio) { %>
										<%- window.copCurrencyF.to(parseFloat(precio_producto)) %>
										<em class="gray-light-text text-xbg normal-text">iva incl.</em>
									<% } %>
								</span>
							<% } %>
						</div>
					</div>
				</div>
			</li>
			<% if(producto_oferta){ %>
			<li>
				<fieldset class="panel-section-form gray-light-alt-bg" name="fields_product_offer">
					<div class="row col-equal-height align-bottom">
						<div class="mobile-5 small-4 medium-3 columns">
							<input type="button" id='product-offer' value="Ofertar" class="button small sky-blue btn-shadow radius expand btn-clean-margin">
						</div>
						<div class="mobile-7 small-8 medium-9 columns input-field">
				 			<input type="text" name="valor_total_compra" id="valor_total_compra" value="" required data-abide-ignore class="currency-mask-cop">
							<label for="valor_total_compra">Introduce un valor aquí (ej. $ 40.000)</label>
						</div>
					</div>
				</fieldset>
			</li>
			<% } %>
		</ul>
	{!! Form::close() !!}
</script>

{{-- Info Description Product template --}}
<script type="text/template" id="info-description-product-tpl">
	<button class="edit-field-button edit-field right" data-edit-template="infodescription"><i class="mdi mdi-pencil"></i></button>

	<div class="content-description-product  clearfix" data-edit-template="infodescription">
		<div class="prepared-to-edit text-md wrap-text"><%= window.Misc.stripTags(descripcion_producto) ? descripcion_producto : '' %><%= !window.Misc.stripTags(descripcion_producto) && owner ? '<span class="edit-no-result text-dmd">Agrega una descripción...</span>' : '' %></div>
	</div>
	<div class="field-editing">
		{{-- Render template edit form--}}
	</div>
</script>

{{-- Info Location product template --}}
<script type="text/template" id="info-location-product-tpl">
	<span class="gray-base-text text-lg normal-text field-text">
		<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
			<i class="mdi mdi-map-marker-radius mdi-21 vcenter"></i>
			<span class="bold-text dark-text"><%- nombre_ciudad %></span>, <%- nombre_pais %>
		<% }else { %>
			<span class="edit-no-result text-dmd">Ciudad, País</span>
		<% } %>
	</span>
	<button class="edit-field-button edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="infolocation"><i class="mdi mdi-pencil"></i></button>
</script>
