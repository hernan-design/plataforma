<div class="panel-marketplace-sale-agreement panel-content radius">
	{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-sale-agreement') ) !!}

		<div class="row">
			<div class="small-12 columns">
				<h4 class="thin-header sky-blue-text">Alcance del servicio</h4>
				<p class="clean-bottom gray-dark-text text-md">Describe de manera clara y concisa las actividades a desarrollar para la prestación del servicio.</p>
                <% if((tab == 'ventas') && (  (typeof(codigo_acuerdo_compra) === 'undefined') || _.isNull(codigo_acuerdo_compra) ) ) { %>    
                        <% alcance_acuerdo_compra = typeof(sale.alcance_servicio) !== 'undefined' ? sale.alcance_servicio : alcance_acuerdo_compra %>
                <% } %>     
				<div class="row">
					<div class="small-12 columns input-field">
                        <textarea name="alcance_acuerdo_compra" id="alcance_acuerdo_compra" cols="50" rows="2" class="materialize-textarea"  required readonly><%- alcance_acuerdo_compra %></textarea>
                        <label for="alcance_acuerdo_compra">Descripción</label>				
					</div>
				</div>
			</div>
		</div>
		{{-- agreement activities --}}
		<fieldset class="panel-section-form" name="fields_agreement_activities">
			<div class="row">
				<div class="tablet-6 columns">
					<h4 class="thin-header sky-blue-text">Actividades a desarrollar</h4>
					<p class="clean-bottom gray-dark-text text-md">Describir de manera clara y concisa cada una de las actividades a desarrollar con prestación del servicio.</p>

					<div class="row">
						<div class="small-12 columns input-field">
							<textarea name="desc_actividad_acuerdo" id="desc_actividad_acuerdo" cols="5" rows="2" class="materialize-textarea" data-abide-validator="maxWords" data-maxlen="200" required data-abide-ignore></textarea>
							<label for="desc_actividad_acuerdo">Descripción</label>
						</div>
					</div>
				</div>
				<div class="tablet-6 columns">
					<h4 class="thin-header sky-blue-text">No. de sesiones de trabajo presenciales</h4>
					<p class="gray-dark-text text-md">Selecciona el número de sesiones del trabajo presencial requeridos.</p>

					<div class="row">
						<div class="tablet-6 small-3 medium-3 columns">
							<label for="sesiones_presencial" class="active">No. sesiones</label>
							<input type="text" name="sesiones_presencial" id="sesiones_presencial" value="" class="spinner-quantity" pattern="integer" data-abide-ignore required="false">
						</div>
						<div class="tablet-6 small-3 medium-3 columns left">
							<label for="sesiones_presencial_horas">No. horas</label>
							<input type="text" name="sesiones_presencial_horas" id="sesiones_presencial_horas" value="" pattern="integer" class="spinner-quantity" data-abide-ignore required="false">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="tablet-6 columns">
					<h4 class="thin-header sky-blue-text">Responsable</h4>
					<p class="gray-dark-text text-md">Indique si el responsable de la actividad es el empresario/emprendedor o el asesor/proveedor.</p>

					<div class="row">
						<div class="mobile-6 columns">
							<input type="radio" name="resp_actividad_acuerdo" value="resp_comprador_actividad" id="resp_comprador_actividad" class="with-gap" required data-abide-ignore>
							<label for="resp_comprador_actividad">Empresario</label>
						</div>
						<div class="mobile-6 columns">
							<input type="radio" name="resp_actividad_acuerdo" value="resp_proveedor_actividad" id="resp_proveedor_actividad" class="with-gap" required data-abide-ignore>
							<label for="resp_proveedor_actividad">Proveedor</label>
						</div>
					</div>
				</div>
				<div class="tablet-6 columns">
					<h4 class="thin-header sky-blue-text">No. de sesiones de trabajo virtuales</h4>
					<p class="gray-dark-text text-md">Selecciona el número de sesiones del trabajo virtual requeridos.</p>

					<div class="row">
						<div class="tablet-3 small-3 medium-3 columns">
							<label for="sesiones_virtual_horas" class="active">No. sesiones</label>
							<input type="text" name="sesiones_virtual" value="" class="spinner-quantity" pattern="integer">
						</div>
						<div class="tablet-3 small-3 medium-3 columns left">
							<label for="sesiones_virtual_horas" class="active">No. horas</label>
							<input type="text" name="sesiones_virtual_horas" id="sesiones_virtual_horas" value="" pattern="integer" class="spinner-quantity" data-abide-ignore required="false">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="tablet-6 columns end">
					<h4 class="thin-header sky-blue-text">Fechas</h4>
					<div class="row">
						<div class="mobile-6 columns input-field">
							<input type="text" name="fecha_inicial_actividad_acuerdo_nuevo" id="fecha_inicial_actividad_acuerdo_nuevo" value="" required pattern="date" class="datepk" data-abide-ignore>
							<label for="fecha_inicial_actividad_acuerdo_nuevo">Fecha inicio</label>
						</div>
						<div class="mobile-6 columns input-field">
							<input type="text" name="fecha_final_actividad_acuerdo_nuevo" id="fecha_final_actividad_acuerdo_nuevo" value="" required pattern="date" class="datepk" data-abide-ignore>
							<label for="fecha_final_actividad_acuerdo_nuevo">Fecha fin</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns text-center">
					<a id="add-agreement-activity" class="button xtiny sky-blue radius btn-shadow btn-lowerc text-dmd"><i class="mdi mdi-plus mdi-24 vcenter"></i>Agregar</a>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns">
                    <input type="hidden" name="activities_required" id="activities_required" value="" required>
					<small class="error text-center">Debes agregar mínimo una actividad</small>
					<table id="sale-agreement-activities" class="strip-separate align-top responsive-table">
						<thead>
							<tr>
								<th style="width:30%" class="dark-text">Actividades a desarrollar</th>
								<th style="width:11%" class="dark-text">Responsable</th>
								<th style="width:10%" class="dark-text">Fecha inicio</th>
								<th style="width:10%" class="dark-text">Fecha fin</th>
								<th style="width:9%" class="dark-text">No. sesiones trabajo presencial</th>
								<th style="width:9%" class="dark-text">No. horas por sesión presencial</th>
								<th style="width:9%" class="dark-text">No. sesiones trabajo virtual</th>
								<th style="width:9%" class="dark-text">No. horas por sesión virtual</th>
								<th style="width:3%" class="dark-text">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							{{-- Render items activity:id = item-agreement-sale-activity-tpl --}}
						</tbody>
					</table>
				</div>
			</div>
		</fieldset>

		{{-- agreement deliverables  --}}
		<fieldset class="panel-section-form" name="fields_agreement_deliverables">
			<div class="row">
				<div class="small-12 columns">
					<h4 class="thin-header sky-blue-text">Entregables acordados <em class="required-msg lighter-text gray-dark-text text-xmd"><span class="alert-text">*</span> Agrega mínimo un entregable</em></h4>
					<p class="clean-bottom gray-dark-text text-md">Describir de manera clara y concisa cada uno de los entregables para la presentación del servicio.</p>

					<div class="row">
						<div class="small-12 columns input-field">
							<textarea name="descripcion_entregable" id="descripcion_entregable" cols="50" rows="2" class="materialize-textarea" data-abide-validator="maxWords" data-maxlen="200" required data-abide-ignore></textarea>
							<label for="descripcion_entregable">Descripción</label>

						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns text-center">
					<a id="add-agreement-deliverable" class="button xtiny sky-blue radius btn-shadow btn-lowerc text-dmd"><i class="mdi mdi-plus mdi-24 vcenter"></i>Agregar</a>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns">
					<input type="hidden" name="deliverables_required" id="deliverables_required" value="" required>
					<small class="error text-center">Debes agregar mínimo un entregable</small>
					<table id="sale-agreement-deliverables" class="strip-separate align-top responsive-table">
						<tbody>
							{{-- Render items deliverable:id = item-agreement-sale-deliverable-tpl --}}
						</tbody>
					</table>
				</div>
			</div>
		</fieldset>

		<div class="row">
			<div class="small-12 columns">
				<h4 class="thin-header sky-blue-text">Resultados a lograr</h4>
				<p class="clean-bottom gray-dark-text text-md">Describir de manera clara y concisa cada uno de los resultados a lograr por la empresa con la prestación del servicio.</p>
                <% if((tab == 'ventas') && (  (typeof(codigo_acuerdo_compra) === 'undefined') || _.isNull(codigo_acuerdo_compra) ) ) { %>    
                        <% resultados_acuerdo_compra = typeof(sale.resultados_servicio) !== 'undefined' ? sale.resultados_servicio : resultados_acuerdo_compra %>
                <% } %> 
				<div class="row">
					<div class="small-12 columns input-field">
						<textarea name="resultados_acuerdo_compra" id="resultados_acuerdo_compra" cols="50" rows="2" class="materialize-textarea"  required readonly><%- resultados_acuerdo_compra %></textarea>
						<label for="resultados_acuerdo_compra">Descripción</label>
					</div>
				</div>
			</div>
		</div>

		<fieldset class="panel-section-form" name="fields_agreement_advisors">
			<h4 class="thin-header sky-blue-text">Equipo de trabajo del asesor</h4>
			<% if (sale.codigo_usuario_entidad){ %>
				{{-- agreement advisors --}}
				<div class="row">
					<div class="tablet-8 tablet-offset-2 columns input-field">
						<select name="codigo_grupo_usuario" id="codigo_grupo_usuario" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('usuario.equipo.index', {codigo_usuario: sale.codigo_usuario_entidad}) ) %>" data-initial-value="" data-list="true" data-placeholder="Seleccione un integrante" placeholder="Seleccione un integrante">
						</select>
						<label>Integrantes:</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns text-center">
						<a id="add-agreement-adviser" class="button xtiny sky-blue radius btn-shadow btn-lowerc text-dmd"><i class="mdi mdi-plus mdi-24 vcenter"></i>Agregar</a>
					</div>
				</div>
			<% } %>

			<div class="row">
				<div class="small-12 columns">
                    <input type="hidden" name="advisors_required" id="advisors_required" value="" required>
					<small class="error text-center">Debes agregar mínimo un integrante del equipo de trabajo del asesor</small>
					<table id="sale-agreement-advisors" class="strip-separate align-top responsive-table">
						<thead>
							<tr>
								<th style="width:30%" class="dark-text">Nombre</th>
								<th style="width:30%" class="dark-text">Cargo</th>
								<th style="width:30%" class="dark-text">Datos</th>
								<th style="width:10%" class="dark-text">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							{{-- Render items adviser:id = item-agreement-sale-adviser-tpl --}}
						</tbody>
					</table>
				</div>
			</div>
		</fieldset>

		{{-- agreement work team --}}
		<fieldset class="panel-section-form" name="fields_agreement_workteam">
			<h4 class="thin-header sky-blue-text">Equipo de trabajo del empresario</h4>

			<div class="row">
				<div class="tablet-4 columns input-field">
					<input type="text" name="nombre_usuario_empresario" id="nombre_usuario_empresario" value="" required data-abide-ignore>
					<label for="nombre_usuario_empresario">Nombre</label>
				</div>
				<div class="tablet-4 columns input-field">
					<input type="text" name="cargo_usuario_empresario" id="cargo_usuario_empresario" value="" required data-abide-ignore>
					<label for="cargo_usuario_empresario">Cargo</label>
				</div>
				<div class="tablet-4 columns input-field">
					<input type="text" name="correo_usuario_empresario" id="correo_usuario_empresario" value="" pattern="email" required data-abide-ignore>
					<label for="correo_usuario_empresario">Correo electronico</label>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns text-center">
					<a id="add-agreement-workteam" class="button xtiny sky-blue radius btn-shadow btn-lowerc text-dmd"><i class="mdi mdi-plus mdi-24 vcenter"></i>Agregar</a>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns">
                    <input type="hidden" name="workteam_required" id="workteam_required" value="" required>
					<small class="error text-center">Debes agregar mínimo un integrante del equipo de trabajo del empresario</small>
					<table id="sale-agreement-workteam" class="strip-separate align-top responsive-table">
						<thead>
							<tr>
								<th style="width:30%" class="dark-text">Nombre</th>
								<th style="width:30%" class="dark-text">Cargo</th>
								<th style="width:30%" class="dark-text">Datos</th>
								<th style="width:10%" class="dark-text">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							{{-- Render items adviser:id = item-agreement-sale-adviser-tpl --}}
						</tbody>
					</table>
				</div>
			</div>
		</fieldset>

		<div class="row">
			<div class="small-12 columns">
				<ul class="list-info-data no-bullet gray-base-text">
					<li>
						<i class="mdi mdi-information-outline gray-base mdi-24 vcenter"></i>
						<span class="text-xmd vcenter-text">Valor asumido por la unidad (el cual no podrá superar el valor de la llave de acceso)</span>
					</li>
					<li>
						<i class="mdi mdi-information-outline gray-base mdi-24 vcenter"></i>
						<span class="text-xmd vcenter-text">Valor asumido por el empresario (en el evento que la ri del servicio supere el valor de la llave de acceso)</span>
					</li>
				</ul>
			</div>
		</div>

		<div class="panel-detail gray-light-alt-bg">
			<table class="table-content responsive-table">
				<thead>
					<tr>
						<th class="dark-text" style="width:31%">Servicio</th>
						<th class="dark-text" style="width:23%">Valor unidad</th>
						<th class="dark-text" style="width:23%">Valor empresario</th>
						<th class="dark-text" style="width:23%">Total</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><%- sale.nombre_producto %></td>
						<td><%- window.copCurrencyF.to(parseFloat(sale.valor_total_compra)) %></td>
						<td><%- window.copCurrencyF.to(0) %></td>
						<td><%- window.copCurrencyF.to(parseFloat(sale.valor_total_compra)) %></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="row save-section">
			<div class="small-12 columns">
				<ul class="inline-list-items text-right">
					<li>
						<a href="<%- Route.route('marketplace.ventas.index') %>" class="text-skyblue upper-text text-lg normal-text">Volver a ventas</a>
					</li>
					<li>
						<input type="submit" value="Guardar" class="button xmedium sky-blue btn-shadow bold-text radius btn-clean-margin">
					</li>
					<% if(codigo_estado === window._tp.getState['progress']) { %>
					<li>
						<input type="button" id="send-agreement-confirm" value="Enviar acuerdo a aprobación" class="button xmedium sky-blue btn-shadow bold-text radius btn-clean-margin">
					</li>
					<% } %>
				</ul>
			</div>
		</div>

	{!! Form::close() !!}
</div>
