<% if( !_.isUndefined(state_purchase) && !_.isNull(state_purchase) ){ %>

    <% if(state_purchase == 'pending'){ %>
        <li>
            <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Completar compra</a>
            <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <li><a href="<%- window.Misc.urlFull(Route.route('marketplace.compras.shipping.edit', {'shipping': codigo_compra})) %>">Completar compra</a></li>
                <li><a href="#" class="cancel-purchase">Cancelar compra</a></li>
            </ul>
        </li>
    <% }else if( state_purchase == 'confirm' ) { %>
        <% if( acuerdo_producto === false || (acuerdo_producto === true && !_.isNull(state_agreement) && state_agreement !== window._tp.getState['progress'] && state_agreement !== window._tp.getState['active'] && state_agreement !== window._tp.getState['confirm'] && state_purchase == window._tp.getState['review_deliverables'])) { %>
            <li>
                <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Confirmar compra</a>
                <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                    <li class="<%- acuerdo_producto === true && state_agreement !== window._tp.getState['finalized'] && state_agreement !== window._tp.getState['confirmed'] ? 'disabled': '' %>">
                        <a href="#" class="confirm-purchase">Compra realizada</a>
                    </li>
                    <% if(codigo_tipo_pago == window._tp.getTypePayment.accord) { %>
                        <li>
                            <a href="#" class="cancel-purchase">Cancelar compra</a>
                        </li>
                    <% } %>
                </ul>
            </li>
        <% } else if( acuerdo_producto === false || (acuerdo_producto === true && !_.isNull(state_agreement) && state_agreement !== window._tp.getState['progress'] && state_agreement !== window._tp.getState['active'] && state_agreement !== window._tp.getState['confirm'] && state_purchase !== window._tp.getState['review_deliverables'])) { %>
            <span class="gray-dark-text text-sm linear-span vcenter-text">Esperando entregables</span>
        <% } %>
    <% }else if(state_purchase == 'offered'){ %>

        <li><a class="button xsmall gray-dark-text radius btn-shadow btn-lowerc disabled">Ofertado</a></li>

    <% }else if(state_purchase == 'removed'){ %>

        <li>
            <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Compra cancelada</a>
            <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <li>
                    <a class="cancellation-reason">Motivo cancelación</a>
                </li>
            </ul>
        </li>

    <% }else if(!evaluation_purchase || state_purchase != 'finalized'){ %>
            <li>
                <% if(!evaluation_purchase && state_purchase != 'finalized' && acuerdo_producto && state_agreement == window._tp.getState['confirmed'] || state_agreement == window._tp.getState['rejection_of_deliverables']) { %>
                        <li>
                            <span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.purchaserMessages.purchaseinDevelopment', ['institution' => App\RegistroSesion::getInstitutionName()]) }}</span>
                        </li>
                    <% } %>
                <% if(!evaluation_purchase && state_purchase != 'finalized' && state_agreement == window._tp.getState['review_deliverables']) { %>
                    <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Completar requisitos</a>
                    <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <% } %>
                    <% if( state_purchase != 'finalized' && acuerdo_producto && state_agreement == window._tp.getState['review_deliverables']) { %>
                        <li>
                            <a class="deriverables-purchase">Revisar entregables</a>
                        </li>
                    <% } %>
                    <% if(!evaluation_purchase && !acuerdo_compra) { %>
                        <li>
                            <a class="evaluation-purchase">Calificar</a>
                        </li>
                    <% } %>
                    <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement == window._tp.getState['to_finalize']) { %>
                        <span class="gray-dark-text text-sm linear-span vcenter-text">En aprobación</span>
                    <% } %>
                <% if(!evaluation_purchase && state_purchase != 'finalized') { %>
                    </ul>
                <% } %>
            </li>
    <% }else if( state_purchase == 'finalized') { %>
        <li>
            <div class="button xsmall sky-blue radius btn-shadow btn-lowerc">Finalizado</div>
        </li>
    <% } %>
<% } %>