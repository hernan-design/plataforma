<div class="row">
	<div class="small-12 columns">
		<div class="panel-marketplace-purchase-evaluation panel-content radius">

			<div class="row">
				<div class="mobile-10 small-9 mobile-centered columns">
					<div class="wrap-icon-marketplace text-center">
						<span class="marketplace-circle circle-reflex-bottom">
							<i class="mdi mdi-upload"></i>
						</span>
					</div>
					<div class="description-content text-center">
						<h5 class="lighter-header sky-blue-text title-info"><%- tab == 'compras' ? 'Revisa los entregables de tu servicio' : 'Adjuntos de la venta' %></h5>
						<!-- <p class="text-md thin-text">Nos gustaría saber si salió todo bien. Tu comentario es muy importante para el resto de los usuarios.</p> -->
					</div>
				</div>
			</div>

			<div class="content-data-list content-data-products-evaluation">
				<div class="row">
					<div class="mobile-10 small-9 mobile-centered columns">
						<ul class="mobile-block-grid-1 browse-list-mask list-products-evaluation adaptive-images">
							<li>
								<div class="item-wrap-list radius">
									<div class="row collapse col-equal-height">
										<div class="mobile-5 medium-4 columns">
											<div class="top-item-list no-border">
												<div class="item-thumb">
													<img src="<%- imagen_producto %>" title="<%- nombre_producto %>" alt="<%- nombre_producto %>">
												</div>
											</div>
										</div>
										<div class="mobile-7 medium-8 columns">
											<div class="content-item-list text-left">
												<h5 class="title-product-evaluation sky-blue-text"><%- nombre_producto %></h5>
												<p class="desc-product-purchase-evaluation text-md lighter-text dark-text ellipsis"><%- resumen_producto %></p>

												<div class="bottom-item-list no-border">
													<ul class="no-bullet options-bottom-item">
														<li>
															<span class="text-xlg dark-text heavy-text"><%- window.copCurrencyF.to(parseFloat(valor_total_compra)) %></span>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="mobile-11 small-10 tablet-10 mobile-centered columns">
					<div id="upload-documents-container" class="editable-item">
						{{-- <input type="hidden" id="codigo_usuario" value="{{ \Auth::user()->codigo_usuario }}"> --}}
						<section id="wrap-documents" class="">
							{{-- Render  Documents --}}
						</section>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="small-12 tablet-10 mobile-centered columns">
					<div class="reg-content-box">
						<div class="mobile-4 mobile-left small-4 tablet-4 medium-3 column">
							<button id="btn-back" class="button expand xmedium sky-blue radius btn-shadow btn-submit">Volver a mis <%- tab && tab == 'ventas' ? 'ventas' : 'compras' %> </button>
						</div>
						<% if(_.isNull(evaluation_purchase) && state_agreement == 1	) { %>
						<div class="mobile-4 small-4 tablet-4 medium-3 columns end">
							<button id="send-deliverables" class="button expand xmedium sky-blue radius btn-shadow btn-submit">Enviar</button>
						</div>
						<% } %>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="mobile-11 small-10 tablet-9 mobile-centered columns">
					{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-deliverables-purchase') ) !!}

						<% if( !_.isEmpty(acuerdos_adjuntos) && state_purchase != 'cancelled' && state_purchase != 'removed' ) { %>
							</br>
							<div class="row">
								<div class="small-12 columns">
									<% if(tab ==='compras') { %>
										{{-- <p class="text-md">En el siguiente checklist, marca las casillas únicamente de las condiciones que se cumplieron en el proceso de tu compra.</p> --}}
									<% } else { %>
										{{-- <p class="text-md">Carga aquí los entregables necesarios para completar el proceso de calificación de la compra.</p> --}}
									<% } %>
									</br>

									<table id="attachements-deliverables-purchase" class="strip-separate radius align-center">
										<tbody>
											<% _.each(acuerdos_adjuntos, function (deliverable) { %>
												<tr>
													<td class="text-md dark-text">
														<% if(tab === 'compras') { %>
															<% if(deliverable.direccion_adjunto) { %>
																<input type="checkbox" name="entregable_adjunto_<%- deliverable.codigo_entregable_acuerdo %>" id="check_deliverable-<%- deliverable.codigo_entregable_acuerdo %>" class="filled-in" required>
															<% } else { %>
																<input type="checkbox" name="entregable_adjunto_<%- deliverable.codigo_entregable_acuerdo %>" id="check_deliverable-<%- deliverable.codigo_entregable_acuerdo %>" class="filled-in" required disabled>
															<% } %>
														<% } %>
														<label for="check_deliverable-<%- deliverable.codigo_entregable_acuerdo %>" class="dark-text"><%- deliverable.descripcion_entregable %></label>
													</td>
													<td>
														{{-- <% if (state_agreement != window._tp.getState['finalized']) { %> --}}
														<% if (state_agreement == 1 && _.isNull(evaluation_purchase) && state_purchase != 'finalized') { %>
															<div class="uploader-attachments-deliverables">
																{{-- Render attachements deliverables --}}
															</div>
														<% } else { %>
															<ul class="no-bullet inline-list-grid align-center">
																<% if (!_.isNull(deliverable.direccion_adjunto)) { %>
																	<li class="text-right">
																		<ul>
																			<li>
																				<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
																				<a class="preview-link dark-text" target="_blank" href="<%- deliverable.direccion_adjunto %>">
																					<span class="qq-upload-file-selector qq-upload-file text-md">
																						<%- deliverable.nombre_adjunto %>
																					</span>
																				</a>
																			</li>
																		</ul>
																	</li>
																	<li class="text-right has-image no-wrap">
																		<div class="qq-upload-button-selector qq-upload-btn-icon action-hover-circle">
																			<a type="button" role="button" class="qq-download-button action-hover-circle" title="Descargar adjunto" target="_blank" href="<%- deliverable.direccion_adjunto %>">
																				<i class="mdi mdi-download"></i>
																			</a>
																		</div>
																	</li>
																<% } %>
															</ul>
														<% } %>
													</td>
												</tr>
											<% }) %>
										</tbody>
									</table>
									
									<% if((purchaser) || (seller && state_agreement == window._tp.getState['finalized'])) { %>
										<div id="deliverable_final">
											<table id="attachements-deliverables-purchase" class="strip-separate radius align-center">
												<tbody>
													<tr>
														<td class="text-md dark-text">
															<% if(tab === 'compras') { %>
																<input type="checkbox" name="entregable_adjunto_>" id="check_deliverable-<%- codigo_adjunto %>" class="filled-in" required>
															<% } %>
															<label for="check_deliverable-<%- codigo_adjunto %>" class="dark-text"> Informe Final </label>
														</td>
														<td>
															<ul class="no-bullet inline-list-grid align-center">
																<li class="text-right">
																	<ul>
																		<li>
																			<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
																			<a class="preview-link dark-text" target="_blank" id="<%- codigo_adjunto_informe_final %>" href="<%- direccion_adjunto_informe_final %>">
																				<span class="qq-upload-file-selector qq-upload-file text-md">
																					<%- nombre_adjunto_informe_final %>
																				</span>
																			</a>
																		</li>
																	</ul>
																</li>
																<li class="text-right has-image no-wrap">
																	<div class="qq-upload-button-selector qq-upload-btn-icon action-hover-circle">
																		<a type="button" role="button" class="qq-download-button action-hover-circle" title="Descargar adjunto" target="_blank" href="<%- direccion_adjunto_informe_final %>">
																			<i class="mdi mdi-download"></i>
																		</a>
																	</div>
																</li>
															</ul>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										{{-- <% if(tab === 'ventas') { %>
											<div id="deliverable_final">
												<table id="attachements-deliverables-purchase" class="strip-separate radius align-center">
													<tbody>
														<tr>
															<td class="text-md dark-text">
																<% if(tab === 'compras') { %>
																	<input type="checkbox" name="entregable_adjunto_>" id="check_deliverable-<%- codigo_adjunto_certificate %>" class="filled-in" required>
																<% } %>
																<label
																	for="check_deliverable-<%- codigo_adjunto_certificate %>"
																	class="dark-text">
																	  Archivo unificado de entregables (haga un solo pdf con todos los entregables) 
																</label>
															</td>
															<td>
																<ul class="no-bullet inline-list-grid align-center">
																	<li class="text-right">
																		<ul>
																			<li>
																				<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
																				<a
																					class="preview-link dark-text"
																					target="_blank"
																					id="<%- codigo_adjunto_certificate %>"
																					href="<%- direccion_adjunto_certificate %>">
																					<span class="qq-upload-file-selector qq-upload-file text-md">
																						<%- nombre_adjunto_certificate %>
																					</span>
																				</a>
																			</li>
																		</ul>
																	</li>
																	<li class="text-right has-image no-wrap">
																		<div class="qq-upload-button-selector qq-upload-btn-icon action-hover-circle">
																			<a
																				type="button"
																				role="button"
																				class="qq-download-button action-hover-circle"
																				title="Descargar adjunto"
																				target="_blank"
																				href="<%- direccion_adjunto_certificate %>">
																				<i class="mdi mdi-download"></i>
																			</a>
																		</div>
																	</li>
																</ul>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										<% } %> --}}
									<% } %>

									<% if (purchaser && acuerdo_producto) { %>
										{{-- <div class="row">
											<div class="small-12 medium-12 medium-centered tablet-7 columns input-field">
												<textarea name="cometario_evaluacion_compra" id="comentario_rechazo_entregables" cols="500" rows="3" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
												<label for="comentario_rechazo_entregables" data-error="El campo esta vació o tiene muy pocos caracteres">Si los entrégales no cumplen con lo pactado en el acuerdo de negociación, diligencia este campo y oprime el botón de rechazar. </label>
											</div>
										</div> --}}
									<% } %>

								</div>
							</div>
						<% } %>

						<div class="row">
							<% if( (acuerdo_producto === true && !_.isEmpty(acuerdos_adjuntos)) || state_purchase == 'cancelled' || state_purchase == 'removed' || !acuerdo_producto ) { %>

								{{-- <div class="mobile-4 mobile-left small-4 tablet-4 medium-3 column">
									<button id="btn-back" class="button expand xmedium sky-blue radius btn-shadow btn-submit">Volver a mis <%- tab && tab == 'ventas' ? 'ventas' : 'compras' %> </button>
								</div> --}}
								<% if(state_agreement != window._tp.getState['finalized']) { %>
									{{-- <div class="mobile-4 small-4 tablet-4 medium-3 columns end">
										<button class="button expand xmedium sky-blue radius btn-shadow send-deliverables btn-submit" type="submit"><%- state_agreement == window._tp.getState['rejection_of_deliverables'] ? 'Enviar' : 'Siguiente'  %></button>
									</div> --}}
								<% } %>
								<% if (purchaser && acuerdo_producto) { %>
									{{-- <div class="mobile-4 small-4 mobile-center tablet-4 medium-3 columns">
										<button id="refuseDeliverables" class="button expand xmedium sky-blue radius btn-shadow btn-submit">Rechazar</button>
									</div> --}}
								<% } %>

							<% } else { %>
								<div class="small-12 columns save-section">
									<% if(purchaser){ %>
										<p class="text-md alert-text text-center">{{ transtp('marketplace.agreement.deliverables.purchaser') }}
										</p>
									<% } %>
									<% if(seller){ %>
										{{-- <p class="text-md alert-text text-center">AA{{ transtp('marketplace.agreement.deliverables.seller') }}
										</p> --}}
									<% } %>
								</div>
							<% } %>
						</div>

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>