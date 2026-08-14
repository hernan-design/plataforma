<% if( !_.isUndefined(state_purchase) && !_.isNull(state_purchase) && state_purchase !== 'pending' ){ %>
    <% if((state_purchase == 'confirm' || !evaluation_purchase || state_purchase != 'finalized' || !acuerdo_producto)  && state_agreement != 32 ) { %>
        <ul class="inline-list-grid no-bullet align-center">
            <li>
                <% if(!evaluation_purchase && state_purchase != 'finalized' && state_agreement != window._tp.getState['to_finalize']) { %>
                    <a class="button xsmall sky-blue radius btn-shadow btn-lowerc" data-dropdown="drop-opts-purchase-<%- id %>-<%- index %>" aria-controls="drop-opts-purchase-<%- id %>-<%- index %>" data-options="is_hover:true;">Completar requisitos</a>
                    <ul id="drop-opts-purchase-<%- id %>-<%- index %>" data-dropdown-content class="opts-action-dropdown radius" aria-hidden="true">
                <% } %>
                    {{-- mostrar boton rutan-innpulsa --}}
                    {{-- <%-state_purchase %> <%-acuerdo_producto %> <%-state_agreement %> --}}
                    <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement != 30 && state_agreement != 32 && state_agreement != 29) { %>
                        <li><a class="deriverables-sale">Cargar entregables</a></li>

                    <% }%>

                    <% if (state_agreement === window._tp.getState['finalized']) { %>
                        <li class="has-image">
                            <i class="mdi mdi-check-all mdi-24 success vcenter"></i>
                        </li>
                        <li>
                            {{-- <span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.confirm', ['institution' => App\RegistroSesion::getInstitutionName()]) }} (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver acuerdo</a>)</span> --}}
                            <span class="gray-dark-text text-sm linear-span vcenter-text">Finalizado</span>

                        </li>
                    <% }%>
                    <% if(state_purchase == 'confirmed' && state_agreement == 30 ){%>
                        <li><a class="evaluation-sales">Calificar</a></li>
                    <% }%>
                {{-- end mostrar boton --}}

                    {{-- esperando confirmacon de entregables --}}
                    <% if(state_purchase != 'finalized' && acuerdo_producto && state_agreement == 21) { %>
                        <li>
                            <span class="gray-dark-text text-sm linear-span vcenter-text">&nbsp;{{ transtp('marketplace.agreement.deliverables.review', ['institution' => App\RegistroSesion::getInstitutionName()]) }}&nbsp;</span>
                        </li>
                    <% } %>

                    <% if(state_purchase != 'finalized' && state_purchase && state_agreement == 6) { %>
                        <span class="gray-dark-text text-sm linear-span vcenter-text">  En aprobación</span>
                    <% } %>

                    <% if(!evaluation_purchase && !acuerdo_producto && state_agreement != window._tp.getState['forward']) { %>
                        <li><a class="evaluation-sales">Calificar</a></li>
                    <% } %>

                <% if(!evaluation_purchase && state_purchase != 'finalized' && state_agreement != window._tp.getState['to_finalize']) { %>
                    </ul>
                <% } %>
            </li>
        </ul>
    <% }else if( state_purchase == 'finalized') { %>
        AA
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