{{-- ----------------- --}}
{{-- Editing templates --}}
{{-- ----------------- --}}
<script type="text/template" id="edit-project-industry-form-tpl">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-project-industry') ) !!}
		<div class="row">
			<div class="small-12 columns input-field">
				<select name="cor_codigo_categoria_proyecto" required data-placeholder="Seleccione una categoria" placeholder="Seleccione una categoria">
					<option value="" disabled selected>Seleccione una categoria</option>
					@foreach( App\CategoriaProyecto::getCategoriesList() as $category)
						<option value="{{ $category->key }}" <%- cor_codigo_categoria_proyecto == '{{ $category->key }}' ? 'selected': ''%> >{{ $category->value }}</option>
					@endforeach
				</select>
				<label>Categorias:</label>
			</div>
		</div>

		<div class="row">
			<div class="columns tablet-4 tablet-offset-8">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>


{{-- --------------------------- --}}
{{-- for edit sections templates --}}
{{-- --------------------------- --}}
<script type="text/template" id="info-industry-project-tpl">
	<div class="edit-field" data-dropdown="drop-edit-form-alt" aria-controls="drop-edit-form-alt" data-options="align:right" aria-expanded="false" data-edit-template="industry-project">
		<ul class="inline-list-grid no-spacing align-top">
			<li>
				<p class="text-sm dark-text"><%- !_.isUndefined(cor_nombre_categoria_proyecto) && !_.isNull(cor_nombre_categoria_proyecto) ? cor_nombre_categoria_proyecto : nombre_categoria_proyecto %></p>
			</li>
			<li class="has-image">
				<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</div>
</script>
