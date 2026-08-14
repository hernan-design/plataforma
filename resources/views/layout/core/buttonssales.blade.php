<% if( !_.isUndefined(state_purchase) && !_.isNull(state_purchase) && state_purchase !== 'pending' ){ %>
    <% if(state_purchase == 'confirm'){ %>
        <% if( acuerdo_producto === false || (acuerdo_producto === true && !_.isNull(state_agreement) && state_agreement !== window._tp.getState['progress'] && state_agreement !== window._tp.getState['active'] && state_agreement !== window._tp.getState['confirm'])) { %>
            <li>
                <a class="button small sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-sale-<%- id %>-<%- index %>" aria-controls="drop-opts-sale-<%- id %>-<%- index %>" data-options="is_hover:true;">
                        Completar requisitos
                </a>
                <ul id="drop-opts-sale-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                    <li class="<%- acuerdo_producto === true && state_agreement !== window._tp.getState['finalized'] && state_agreement !== window._tp.getState['confirmed'] ? 'disabled': '' %>">
                        <a href="#" class="confirm-sale">Cargar entregables</a>
                    </li>

                    <% if(codigo_tipo_pago == window._tp.getTypePayment.accord) { %>
                        <li>
                            <a href="#" class="cancel-sale">Cancelar venta</a>
                        </li>
                    <% } %>
                </ul>
            </li>
        <% } %>
        {{-- end mostrar boton --}}
    <% }else if(state_purchase == 'offered'){ %>
        <li>
            <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-offer-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-offer-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Ofertado</a>
            <ul id="drop-opts-offer-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <li><a href="#" class="confirm-offer">Aceptar oferta</a></li>
                <li><a href="#" class="cancel-offer">Cancelar oferta</a></li>
            </ul>
        </li>
    <% }else if(state_purchase == 'cancelled'){ %>
        <li>
            <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Venta cancelada</a>
            <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <li>
                    <a class="cancellation-reason">Motivo cancelación</a>
                </li>
            </ul>
        </li>
    <% }else if(!evaluation_purchase || state_purchase != 'finalized' || !acuerdo_producto) { %>
    <ul class="inline-list-grid no-bullet align-center">
        <li>
            <% if(!evaluation_purchase && state_purchase != 'finalized' && state_agreement != window._tp.getState['to_finalize']) { %>
                <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Completar requisitos</a>
                <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
            <% } %>

                <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement != window._tp.getState['review_deliverables'] && state_agreement != window._tp.getState['to_finalize']) { %>
                    <li><a class="deriverables-sale">Cargar entregables</a></li>
                <% } %>

                <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement == window._tp.getState['review_deliverables']) { %>
                    <li>
                        <span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.deliverables.review', ['institution' => App\RegistroSesion::getInstitutionName()]) }}</span>
                    </li>
                <% } %>
                <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement == window._tp.getState['to_finalize']) { %>
                    <span class="gray-dark-text text-sm linear-span vcenter-text">En aprobación</span>
                <% } %>
                <% if(!evaluation_purchase && !acuerdo_producto && state_agreement != window._tp.getState['review_deliverables']) { %>
                    <li><a class="evaluation-sales">Calificar</a></li>
                <% } %>
            <% if(!evaluation_purchase && state_purchase != 'finalized' && state_agreement != window._tp.getState['to_finalize']) { %>
                </ul>
            <% } %>
        </li>
    </ul>
    <% }else if( state_purchase == 'finalized') { %>
        <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Finalizado</a>
        <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
            <li><a class="deriverables-sale">Revisar entregables</a></li>
        </ul>
    <% } %>
<% }else if(!_.isUndefined(state_purchase) && !_.isNull(state_purchase) && state_purchase == 'pending') { %>
    <li>
        <div class="button xsmall sky-blue radius btn-shadow btn-lowerc">Esperando confirmación</div>
    </li>
<% } %>