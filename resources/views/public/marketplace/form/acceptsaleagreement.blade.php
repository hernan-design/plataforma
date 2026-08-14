<div class="panel-marketplace-sale-agreement panel-content radius">
	<div class="row">
		<div class="small-12 columns">
			<h4 class="thin-header sky-blue-text">Alcance del servicio</h4>
			<p class="text-md"><%- alcance_acuerdo_compra %></p>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<table id="sale-agreement-activities" class="table-content no-border striped align-top responsive-table">
				<thead>
					<tr>
						<th style="width:30%" class="sky-blue-text">Actividades a desarrollar</th>
						<th style="width:12%" class="sky-blue-text">Responsable</th>
						<th style="width:10%" class="sky-blue-text">Fecha inicio</th>
						<th style="width:10%" class="sky-blue-text">Fecha fin</th>
						<th style="width:10%" class="sky-blue-text">No. sesiones trabajo presencial</th>
						<th style="width:9%" class="sky-blue-text">No. horas por sesión presencial</th>
						<th style="width:10%" class="sky-blue-text">No. sesiones trabajo virtual</th>
						<th style="width:9%" class="sky-blue-text">No. horas por sesión virtual</th>
					</tr>
				</thead>
				<tbody class="gray-light-alt-bg">
					{{-- Render items activity:id = item-agreement-sale-activity-tpl --}}
				</tbody>
			</table>
			<br/><br/>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<h4 class="thin-header sky-blue-text">Entregables acordados</h4>
			<table id="sale-agreement-deliverables" class="table-content no-border striped align-top responsive-table">
				<tbody class="gray-light-alt-bg">
					{{-- Render items deliverable:id = item-agreement-sale-deliverable-tpl --}}
				</tbody>
			</table>
			<br/><br/>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<h4 class="thin-header sky-blue-text">Resultados a lograr</h4>
			<p class="text-md"><%- resultados_acuerdo_compra %></p>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<h4 class="thin-header sky-blue-text">Equipo de trabajo del asesor</h4>
			<table id="sale-agreement-advisors" class="table-content no-border striped align-top responsive-table">
				<thead>
					<tr>
						<th style="width:40%" class="sky-blue-text">Nombre</th>
						<th style="width:30%" class="sky-blue-text">Cargo</th>
						<th style="width:30%" class="sky-blue-text">Datos</th>
					</tr>
				</thead>
				<tbody class="gray-light-alt-bg">
					{{-- Render items adviser:id = item-agreement-sale-adviser-tpl --}}
				</tbody>
			</table>
			<br/><br/>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<h4 class="thin-header sky-blue-text">Equipo de trabajo del empresario</h4>
			<table id="sale-agreement-workteam" class="table-content no-border striped align-top responsive-table">
				<thead>
					<tr>
						<th style="width:40%" class="sky-blue-text">Nombre</th>
						<th style="width:30%" class="sky-blue-text">Cargo</th>
						<th style="width:30%" class="sky-blue-text">Datos</th>
					</tr>
				</thead>
				<tbody class="gray-light-alt-bg">
					{{-- Render items adviser:id = item-agreement-sale-workteam-tpl --}}
				</tbody>
			</table>
			<br/><br/>
		</div>
	</div>

	<div class="panel-detail gray-light-alt-bg">
		<table class="table-content responsive-table">
			<thead>
				<tr>
					<th class="sky-blue-text" style="width:31%">Servicio</th>
					<th class="sky-blue-text" style="width:23%">Valor unidad</th>
					<th class="sky-blue-text" style="width:23%">Valor empresario</th>
					<th class="sky-blue-text" style="width:23%">Total</th>
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
	<br/>

	<div class="row">
		<div class="small-8 tablet-6 medium-7 columns">
			<% if(codigo_estado === window._tp.getState['confirm']) { %>
				<ul class="inline-list-grid align-top no-bullet dark-text lighter-text">
					<li class="has-image">
						<i class="mdi mdi-information-outline mdi-24 vcenter"></i>
					</li>
					<li>
						<span class="text-xmd vcenter-text linear-span">Este acuerdo debe ser aprobado por la entidad. Recibiras una notificacion en tu correo de dicha confirmación.</span>
					</li>
				</ul>
			<% } else if(codigo_estado === window._tp.getState['confirmed'] || codigo_estado === window._tp.getState['to_finalize'] || codigo_estado === window._tp.getState['finalized']) { %>
				<ul class="inline-list-grid align-top no-bullet dark-text lighter-text">
					<li class="has-image">
						<i class="mdi mdi-check-circle-outline success mdi-24 vcenter"></i>
					</li>
					<li>
						<span class="text-xmd vcenter-text linear-span">Acuerdo aprobado.</span>
						<a href="<%- url_acuerdo_compra %>" target="_blank" class="text-skyblue upper-text text-lg normal-text">VER EN PDF</a> </li>
				</ul>
			<% } %>
		</div>
		<div class="small-4 tablet-6 medium-5 columns">
			<ul class="inline-list-items text-right">
				<li>
					<% if(comprador) { %>
						<a href="<%- Route.route('marketplace.compras.index') %>" class="text-skyblue upper-text text-lg normal-text">Volver a compras</a>
					<% } else { %>
						<a href="<%- Route.route('marketplace.ventas.index') %>" class="text-skyblue upper-text text-lg normal-text">Volver a ventas</a>
					<% } %>
				</li>
				<% if(codigo_estado === window._tp.getState['active'] && comprador) { %>
					<li>
						<button id="confirm-sale-agreement" class="button xmedium sky-blue btn-shadow bold-text radius btn-clean-margin">Confirmar acuerdo</button>
					</li>
				<% } %>
			</ul>
		</div>
	</div>
</div>
