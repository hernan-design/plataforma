<div style="position:relative;height:100%" class="clearfix">
    <div class="item-wrap-list radius">
        <div class="top-item-list no-border">
            <a href="<%= Route.route('marketplace.show', {'marketplace': url_producto}) %>" class="item-thumb">
                <img src="<%- imagen_producto %>" alt="<%- nombre_producto %>" title="<%- nombre_producto %>" class="img-product-purchase">
            </a>
        </div>
        <div class="content-item-list">
            <h6 class="title-item-list is-hovered ellipsis">
                <a href="<%= Route.route('marketplace.show', {'marketplace': url_producto}) %>"><%- nombre_producto %></a>
            </h6>
            <ul class="list-info-data no-bullet">
                <% if( !_.isUndefined(valor_total_compra) && valor_total_compra > 0 ) { %>
                    <li>
                        <span class="gray-base-text text-sm normal-text"><%- state_purchase == 'offered' ? 'Oferta actual' : 'Precio'%>: </span><span class="lighter-text text-md normal-text"><%- window.copCurrencyF.to(parseFloat(valor_total_compra)) %></span>
                    </li>
                <% } %>

                <% if( precio_producto && state_purchase == 'offered' ) { %>
                    <li>
                        <span class="gray-base-text text-sm normal-text">Precio: </span><span class="lighter-text text-md normal-text"><%- producto_sin_precio ? window.copCurrencyF.to(parseFloat(0)) : window.copCurrencyF.to(parseFloat(precio_producto)) %></span>
                    </li>
                <% } %>

                <% if(unidad_producto > 0) { %>
                    <li>
                        <span class="gray-base-text text-sm normal-text">Cantidad: </span><span class="lighter-text text-md normal-text"><%- unidad_producto %></span>
                    </li>
                <% } %>

                <% if(state_purchase == 'cancelled') { %>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">Compra cancelada</label>
                        <ul class="inline-list-grid no-bullet align-center">
                            <li class="has-image">
                                <i class="mdi mdi-block-helper mdi-21 gray-base vcenter"></i>
                            </li>
                            <li>
                                <span class="gray-dark-text text-sm linear-span vcenter-text">Cancelada</span>
                            </li>
                        </ul>
                    <li>
                <% }else if(state_purchase == 'offered') { %>
                    {{-- <li>
                        <label class="label single lighter-text dark-text text-xmd">Compra ofertada</label>
                        <ul class="inline-list-grid no-bullet align-center">
                            <li class="has-image">
                                <i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
                            </li>
                            <li>
                                <span class="gray-dark-text text-sm linear-span vcenter-text">Esperando aprobación</span>
                            </li>
                        </ul>
                    <li> --}}
                <% }else if(acuerdo_producto && _.contains(['confirm','confirmed','finalized'], state_purchase)) { %>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">Entregables</label>
                        <ul class="inline-list-grid no-bullet align-center">
                            <% if(acuerdo_compra) { %>
                                <% if(state_agreement === window._tp.getState['progress']) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-table-edit mdi-24 gray-light vcenter"></i>
                                    </li>
                                    <li>
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">En progreso.</span>
                                    </li>
                                <% } else if(state_agreement === window._tp.getState['confirm'] || state_agreement === window._tp.getState['correction']) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-clock mdi-24 sky-blue vcenter"></i>
                                    </li>
                                    <li>
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.waitconfirmation', ['institution' => App\RegistroSesion::getInstitutionName()]) }}</span>
                                    </li>
                                <% } else if(state_agreement === window._tp.getState['confirmed'] || state_agreement === window._tp.getState['finalized']) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-check-all mdi-24 success vcenter"></i>
                                    </li>
                                    <li>
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">Aprobado (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver entregables</a>)</span>
                                    </li>
                                <% } else if(state_agreement === window._tp.getState['review_deliverables'] || state_agreement === window._tp.getState['rejection_of_deliverables']) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-check-all mdi-24 success vcenter"></i>
                                    </li>
                                    <li>
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">Entregables (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver entregables</a>)</span>
                                    </li>
                                <% } else if (state_agreement === window._tp.getState['to_finalize']) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-check-all mdi-24 success vcenter"></i>
                                    </li>
                                    <li>
                                        {{-- <span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.confirm', ['institution' => App\RegistroSesion::getInstitutionName()]) }} (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver acuerdo</a>)</span> --}}
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">Finalizado</span>

                                    </li>
                                 <% } else if(state_agreement === 21) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-check mdi-24 success vcenter"></i>
                                    </li>
                                    <li>
                                        <span
                                            class="gray-dark-text text-sm linear-span vcenter-text">
                                            Enviados (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver entregables</a>)
                                        </span>
                                    </li>

                                <% } else if(state_agreement !== 21) { %>
                                    <li class="has-image">
                                        <i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
                                    </li>
                                    <li>
                                        <span class="gray-dark-text text-sm linear-span vcenter-text">Esperando entregables</span>
                                    </li>
                                <% } %>

                            <% } else if(state_agreement !== 21) { %>
                                <li class="has-image">
                                    <i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
                                </li>
                                <li>
                                    <span class="gray-dark-text text-sm linear-span vcenter-text">Esperando entregables</span>
                                </li>
                            <% } %>
                        </ul>
                    </li>
                <% } %>
            </ul>
        </div>
        <div class="bottom-item-list">
            <input type="checkbox" id="toggle-reveal-info-purchase-<%- id %>" class="toggle-reveal-info">
            <label for="toggle-reveal-info-purchase-<%- id %>" class="sky-blue btn-floating waves-effect waves-light"></label>

            <ul class="inline-list-grid">
                <li>
                    <ul class="buttons-purchase-action no-bullet left text-left inst-color-secondary">
                        {{-- Render buttoms Purchase --}}
                    </ul>
                </li>
            </ul>

            <div class="reveal-data-info">
                <ul class="list-info-data no-bullet">
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">No. de compra</label>
                        <span class="gray-dark-text text-sm"><%- id %></span>
                    </li>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">{{ transtp('marketplace.seller') }}</label>
                        <div class="card-user-info">
                            <ul class="inline-list-grid no-bullet align-center no-spacing">
                                <li class="has-image">
                                    <a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="rounded-thumb" title="<%- nickname_usuario %>">
                                        <img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%- nickname_usuario %>" class="rounded-img size40" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
                                    </a>
                                </li>
                                <li>
                                    <ul class="no-bullet">
                                        <li>
                                            <a href="<%= window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_usuario}) ) %>" class="text-xmd dark-text normal-text"><%- nombre_usuario %></a>
                                        </li>
                                        {{-- <li><span class="text-xmd gray-base-text linear-span"><%- correo_electronico %></span></li> --}}
                                        <% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
                                            <li>
                                                <span class="text-xmd gray-base-text linear-span">Bogotá, Colombia</span>
                                            </li>
                                        <% } %>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <% if( !_.isUndefined(nickname_entidad) &&  !_.isNull(nickname_entidad)) { %>
                        <li>
                            <label class="label single lighter-text dark-text text-xmd"><%-nombre_clase_empren_insti ? nombre_clase_empren_insti : nombre_clase_emprendimiento %></label>
                            <a href="<%= window.Misc.urlFull(Route.route( 'proyecto.proyecto',{'proyecto': nickname_entidad }))%>" title="<%- nombre_entidad %>" class="gray-dark-text text-sm"><%- nombre_entidad %></a>
                        </li>
                    <% } %>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">Fecha de compra</label>
                        <span class="gray-dark-text text-sm"><%- window.moment(fecha_compra, "YYYY-MM-DD").format("MMMM DD, [de] YYYY") %></span>
                    </li>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">Pago</label>
                        <span class="gray-dark-text text-sm"><%- nombre_tipo_pago %></span>
                    </li>
                    <li>
                        <label class="label single lighter-text dark-text text-xmd">Envío</label>
                        <span class="gray-dark-text text-sm"><%- nombre_tipo_envio %></span>
                    </li>
                    <li class="text-left clearfix">
                        <ul class="buttons-purchase-action no-bullet left text-left inst-color-secondary">
                            {{-- Render buttoms Purchase --}}
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>