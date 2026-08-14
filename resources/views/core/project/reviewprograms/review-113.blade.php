<script type="text/template" id="project-program-review-113-tpl">
	<div class="panel-review-program-project panel-content radius">
		<div class="submenu-tabs-review-program no-shadow no-border clearfix">
			<ul id="project-tabs-navs-review" class="project-program-submenu-review tabs-sub-nav" data-tab data-tab-init="is_hover:false">
				<li class="tab-title active">
					<a href="#program-preview-result" title="Resultado" aria-controls="program-preview-result">Resultado</a>
				</li>
				<li class="tab-title">
					<a href="#program-preview-diagnostic" title="Diagnóstico" aria-controls="program-preview-diagnostic">Diagnóstico</a>
				</li>
				{{-- <li class="tab-title">
					<a href="#program-preview-financial" title="Análisis financiero" aria-controls="program-preview-financial">Análisis financiero</a>
				</li> --}}
				<li class="tab-title">
					<a href="#program-preview-opportunities" title="Oportunidades" aria-controls="program-preview-opportunities">Oportunidades</a>
				</li>
			</ul>
		</div>

		<div class="tabs-content">

			<div id="program-preview-result" class="content active">
				<!-- Informacion de la empresa -->
				<%= report.data_general.texto_carta %>
			</div>

			<div id="program-preview-diagnostic" class="content">
				<div class="inner-panel-program-review">
					<h5 class="inst-color-secondary bold-text">Resultado por área de la empresa</h5>
					<canvas id="chart-area-result-program" width="940" height="450"></canvas>
				</div>
				<div class="inner-panel-program-review text-justify">
					<% if( !_.isUndefined(report.data_general.texto_respuesta) && !_.isNull(report.data_general.texto_respuesta) && report.data_general.texto_respuesta != ''){ %>
						<h5 class="inst-color-secondary bold-header">Recomendación general</h5>
						<div class="text-md lighter-text"><%= report.data_general.texto_respuesta %></div>
						<br />
					<% } %>

					<h5 class="inst-color-secondary bold-header">Gestión administrativa</h5>
					<div class="text-md lighter-text"><%= report.data_admin_management.texto_respuesta %></div>
					<br />

					<h5 class="inst-color-secondary bold-header">Gestión humana y cultura de la innovación</h5>
					<div class="text-md lighter-text"><%= report.data_human_management.texto_respuesta %></div>
					<br />

					<h5 class="inst-color-secondary bold-header">Gestión financiera</h5>
					<div class="text-md lighter-text"><%= report.data_financial_management.texto_respuesta %></div>
					<br />

					<h5 class="inst-color-secondary bold-header">Gestión comercial</h5>
					<div class="text-md lighter-text"><%= report.data_commercial_management.texto_respuesta %></div>
					<br />

					<h5 class="inst-color-secondary bold-header">Gestión de la producción</h5>
					<div class="text-md lighter-text"><%= report.data_production_management.texto_respuesta %></div>
					<br />
				</div>
			</div>

			{{-- <div id="program-preview-financial" class="content">
				<div class="inner-panel-program-review">
					<!-- Flujo de caja -->
					<h6 class="inst-color-secondary bold-header">Flujo de caja</h6>
					<p class="text-sm lighter-text gray-dark-text clean-bottom">¿Qué es el flujo de caja? Son los flujos de entrada y de salida de efectivo en un periodo dado. En un indicador muy importante en la determinación de la liquidez de la empresa. Los flujos de caja sirven para determinar problemas de liquidez e la empresa y viabilidad de proyectos de inversión.</p>
				</div>

				<div class="inner-panel-program-review has-table">
					<table class="table-content responsive-table bordered">
						<thead>
							<tr>
								<th class="medium-text-left dark-text" style="width:50%">FLUJO DE EFECTIVO GENERADO POR LA OPERACIÓN</th>
								<th class="medium-text-right dark-text" style="width:21%">Diciembre 2014</th>
								<th class="medium-text-right dark-text" style="width:21%">Diciembre 2015</th>
								<th style="width:8%">&nbsp;</th>
							</tr>
						</thead>
					</table>
				</div>
				<ul class="collapsible collapsible-table no-bullet" data-collapsible="accordion">
					<li class="active">
						<div class="collapsible-header active">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td style="width:50%"><strong>EBITDA</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.ebita_2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.ebita_2015)) %></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table class="table-content bordered">
									<tbody>
										<tr>
											<td style="width:50%">(Aumento) / Disminución Cartera</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_cartera2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_cartera2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(Aumento)/ Disminución Inventarios</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_inventarios2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_inventarios2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(Aumento)/ Disminución Otros Activos Corrientes</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_otros_activos_corrientes2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_otros_activos_corrientes2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Aumento / (Disminución) Proveedores</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_proveedores2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_proveedores2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Aumento / (Disminución) Otros Pasivos Corrientes</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_otros_pasivos_corrientes2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminucion_otros_pasivos_corrientes2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%"><strong>INVERSION EN CAPITAL DE TRABAJO</strong></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.inversion_capital_trabajo2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.inversion_capital_trabajo2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(-) Impuestos</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.impuestos2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.impuestos2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_ebitda %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_ebitda %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td style="width:50%"><strong>EFECTIVO NETO OPERACIONAL</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_operacional2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_operacional2015)) %></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_efectivo_neto_operacional %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_efectivo_neto_operacional %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td class="medium-text-left dark-text" style="width:50%"><strong>FLUJO DE EFECTIVO EN ACTIVIDADES DE INVERSION</strong></td>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2014</strong></td>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2015</strong></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<tbody>
										<tr>
											<td style="width:50%">(Mantenimiento y Expansión) / Venta de Activos Fijos</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.ventas_activos_fijos_2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.ventas_activos_fijos_2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(Aumento) / Disminución en Inversiones Permanentes</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminuciones_inversiones_permanentes2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminuciones_inversiones_permanentes2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(Aumento) / Disminución en Activos Diferidos e Intangibles</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminuciones_activos_diferidos2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.disminuciones_activos_diferidos2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_efectivo_actividades_inversion %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_efectivo_actividades_inversion %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="inner-panel-program-review has-table">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%"><strong>EFECTIVO NETO EN ACTIVIDADES DE INVERSION</strong></td>
										<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividdes_inversion2014)) %></td>
										<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividdes_inversion2015)) %></td>
										<td style="width:8%">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td style="width:50%"><strong>FLUJO DE CAJA LIBRE</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre2015)) %></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_flujo_caja_libre %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_flujo_caja_libre %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td class="medium-text-left dark-text" style="width:50%"><strong>FLUJO DE EFECTIVO EN ACTIVIDADES DE FINANCIACION</strong></td>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2014</strong></td>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2015</strong></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<tbody>
										<tr>
											<td style="width:50%">(-/+) Gastos Financieros</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.gastos_financieros2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.gastos_financieros2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(+/-) Amortizacion Bancos y Bonos CP</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_cp2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_cp2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(+/-) Amortizacion Bancos y Bonos LP</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_lp2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_lp2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
									<tbody>
								</table>
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_efectivo_actividades_financiacion %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_efectivo_actividades_financiacion %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="inner-panel-program-review has-table">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%"><strong>EFECTIVO NETO EN ACTIVIDADES DE FINANCIACION</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividades_financiacion2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividades_financiacion2015)) %></td>
										<td style="width:8%">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td style="width:50%"><strong>FLUJO DE CAJA LIBRE DESPUES DE FINANCIACION</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_caja_libre_despues_financiacion %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_caja_libre_despues_financiacion %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td class="medium-text-left dark-text" style="width:50%"><strong>OTROS FLUJOS DE EFECTIVO</strong></td>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2014</strong></th>
											<td class="medium-text-right dark-text" style="width:21%"><strong>Diciembre 2015</strong></th>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table>
									<tbody>
										<tr>
											<td style="width:50%">Ingresos Financieros</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.gastos_financieros2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.gastos_financieros2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Otros (Neto no Operacional)</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_cp2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_cp2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">(Aumento)/ Disminución Otros Activos</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_lp2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.amortizacion_bancos_bonos_lp2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Aumento / (Disminución) Otros Pasivos</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividades_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.efectivo_neto_actividades_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Capital Social</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">Aumento / (Disminución) Patrimonio de los Accionistas</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_efectivo_neto_otros %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_efectivo_neto_otros %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>

					<li>
						<div class="inner-panel-program-review has-table">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%"><strong>EFECTIVO NETO EN OTROS</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
										<td style="width:8%">&nbsp;</td>
									</tr>
								</tbody>
							</table>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<div class="inner-panel-program-review">
								<table class="table-content align-center">
									<tbody>
										<tr>
											<td style="width:50%"><strong>FLUJO DE CAJA NETO</strong></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td class="medium-text-right" style="width:21%"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td class="medium-text-right" style="width:8%">
												<i class="mdi mdi-information mdi-24 gray-light tip-top radius" data-tooltip aria-haspopup="true" title="Haz clic para ver más detalles"></i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="collapsible-body">
							<div class="inner-section-program-review">
								<table class="table-content bordered">
									<tbody>
										<tr>
											<td style="width:50%">SALDO INICIAL DISPONIBLE E INVERSIONES TEMPORALES</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%">SALDO FINAL DISPONIBLE E INVERSIONES TEMPORALES</td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
										<tr>
											<td style="width:50%"><strong>(AUMENTO) / DISMINUCION EN DISPONIBLE</strong></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2014)) %></td>
											<td style="width:21%" class="medium-text-right"><%- window.copCurrency(parseFloat(report.cash_flow.flujo_caja_libre_despues_financiacion2015)) %></td>
											<td style="width:8%">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table>
									<thead>
										<tr>
											<th class="dark-text" style="width:50%">Definición</th>
											<th class="dark-text" style="width:50%">Interpretación</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:50%"><%- report.interpretation_cash_flow.definition_flujo_caja_neto %></td>

											<td style="width:50%"><%- report.interpretation_cash_flow.interpretation_flujo_caja_neto %></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</li>
				</ul>

				<div class="inner-panel-program-review">
					<h6 class="inst-color-secondary bold-header">Razones financieras</h6>
				</div>

				<table class="table-content bordered">
					<thead>
						<tr>
							<th class="medium-text-left dark-text" style="width:50%">Concepto</th>
							<th class="medium-text-right dark-text" style="width:25%">Diciembre 2014</th>
							<th class="medium-text-right dark-text" style="width:25%">Diciembre 2015</th>
						</tr>
					</thead>
				</table>
				<ul class="collapsible collapsible-table no-bullet" data-collapsible="accordion">
					<li>
						<table class="table-content">
							<tbody>
								<tr>
									<td colspan="3"><strong>EVOLUCIÓN OPERACIONAL Y RENTABILIDAD</strong></td>
								</tr>
							</tbody>
						</table>
					</li>

					<li class="active">
						<div class="collapsible-header active">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Evolución de Ventas</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.evolucion_ventas2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.evolucion_ventas2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_evluacion_ventas %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_interpretacion_evluacion_ventas %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Evolución EBITDA</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.evolucion_ebitda2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.evolucion_ebitda2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_evolucion_ebitda %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_interpretacion_evolucion_ebitda %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">CAPEX / Ventas</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.capex_ventas2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.capex_ventas2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">ROA</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.roa2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.roa2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_roa %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_roa %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">ROE</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.roe2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.roe2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_roe %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_roe %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<table class="table-content">
							<tbody>
								<tr>
									<td class="medium-text-left dark-text" style="width:50%"><strong>ENDEUDAMIENTO</strong></td>
									<td class="medium-text-right dark-text" style="width:25%"><strong>Diciembre 2014</strong></td>
									<td class="medium-text-right dark-text" style="width:25%"><strong>Diciembre 2015</strong></td>
								</tr>
							</tbody>
						</table>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Grado de Endeudamiento (Total Pasivo / Total Activo)</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.grado_endeudamiento2014) %>%</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.grado_endeudamiento2015) %>%</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_grado_endeudamiento %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_grado_endeudamiento %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Obligaciones Financieras / Ventas</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.obligaciones_financieras_ventas2014) %></td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.obligaciones_financieras_ventas2015) %></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_obligaciones_financieras_ventas %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_obligaciones_financieras_ventas %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Obligaciones Financieras / EBITDA</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.obligaciones_financieras_ebitda2014) %></td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.obligaciones_financieras_ebitda2015) %></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_obligaciones_financieras_ebitda %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_obligaciones_financieras_ebitda %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td colspan="3">Cobertura Deuda</td>
									</tr>
								</tbody>
							</table>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Ebitda / Gastos Financieros</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ebitda_gastos_financieros2014) %></td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ebitda_gastos_financieros2015) %></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_ebitda_gf %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_ebitda_gf %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Ebitda / (Total Deuda CP + Gastos Financieros)</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ebitda_gastos_tdcp_gf2014) %></td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ebitda_gastos_tdcp_gf2015) %></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_ebitda_gf_dt %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_ebitda_gf_dt %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Flujo Caja Libre / Gastos Financieros</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.flujo_caja_libre2014) %></td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.flujo_caja_libre2015) %></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_flujo_caja_libre %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_flujo_caja_libre %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<table class="table-content">
							<tbody>
								<tr>
									<td class="medium-text-left dark-text" style="width:50%"><strong>ACTIVIDAD</strong></td>
									<td class="medium-text-right dark-text" style="width:25%"><strong>Diciembre 2014</strong></td>
									<td class="medium-text-right dark-text" style="width:25%"><strong>Diciembre 2015</strong></td>
								</tr>
							</tbody>
						</table>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Días Plazo Cobro (Cartera)</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_plazo_cobro2014) %> días</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_plazo_cobro2015) %> días</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_dias_plazo_cobro %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_dias_plazo_cobro %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Días de Inventarios</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_inventario2014) %> días</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_inventario2015) %> días</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_dias_inventario %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_dias_inventario %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Días Plazo Pago (Proveedores)</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_plazo_pago2014) %> días</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.dias_plazo_pago2015) %> días</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_dias_plazo_pago %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_dias_plazo_pago %></p>
								</li>
							</ul>
						</div>
					</li>

					<li>
						<div class="collapsible-header">
							<table class="table-content">
								<tbody>
									<tr>
										<td style="width:50%">Ciclo Operacional</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ciclo_operacional2014) %> días</td>
										<td class="medium-text-right" style="width:25%"><%- Math.round(report.financial_reasons.ciclo_operacional2015) %> días</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="collapsible-body">
							<ul class="list-detail-program-review no-bullet">
								<li>
									<label class="label single bold-text dark-text">Interpretación</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.interpretacion_ciclo_operacional %></p>
								</li>
								<li>
									<label class="label single bold-text dark-text">Plan</label>
									<p class="text-sm lighter-text gray-dark-text clean-bottom"><%- report.interpretation_financial_reasons.plan_ciclo_operacional %></p>
								</li>
							</ul>
						</div>
					</li>
				</ul>
			</div> --}}

			<div id="program-preview-opportunities" class="content">
				<h5 class="title-inner-program-review inst-color-secondary bold-header">Cursos recomendados</h5>
				<div class="inner-panel-program-review">
					Te invitamos a desarrollar los siguientes cursos para que fortalezcas tu negocio en las áreas identificadas en la sección de Diagnóstico.
				</div>
				<div class="content-data-program-review-list content-data-list">

					<ul class="browse-list-program-review browse-list-piece">
						<% _.each( report.data_general.oportunidades, function(item) { %>
						<li>
							<a href="<%- item.url %>" title="<%- item.titulo %>" target="_blank" class="wrapper-pointer-item">
								<div class="item-wrap-list">
									<div class="row collapse col-equal-height">
										<div class="mobile-3 columns">
											<div class="top-item-list">
												<img src="<%- item.imagen %>" alt="<%- item.titulo %>">
											</div>
										</div>
										<div class="mobile-9 columns">
											<div class="content-item-list">
												<h6 class="bold-header dark-text is-hovered"><%- item.titulo %></h6>
												<% if( !_.isUndefined(item.descripcion) && !_.isNull(item.descripcion) && item.descripcion != ''){ %>
													<p class="description-piece-content text-md gray-dark-text ellipsis"><%- item.descripcion %></p>
												<% } %>
											</div>
										</div>
									</div>
								</div>
							</a>
						</li>
						<% }); %>
					</ul>
				</div>
				<div class="inner-panel-program-review text-justify">
					<div class="text-sm lighter-text">
						El Ministerio de Comercio, Industria y Turismo e iNNpulsa Colombia no asumen ninguna responsabilidad sobre el contenido de terceros. Se reserva el derecho para suprimir o rechazar la distribución de cualquier contenido en el servicio que infrinjan estas condiciones. Las ideas, afirmaciones y opiniones expresadas en los contenidos y actividades del curso no reflejan las del Ministerio de Comercio, Industria y Turismo e iNNpulsa Colombia. La responsabilidad de las mismas es responsabilidad exclusiva de sus autores.
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
