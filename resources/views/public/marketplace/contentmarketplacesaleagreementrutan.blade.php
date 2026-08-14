<div id="content-marketplace-sale-agreement">
    <div class="row">
        <div class="small-12 columns">
            <% if(tab == 'ventas') { %>
                @include('public.marketplace.form.createsaleagreement')
            <% } else if(tab == 'compras') { %>
                <div class="panel-marketplace-sale-agreement panel-content radius">
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
                                        <span class="text-xmd vcenter-text linear-span">Entregables aprobados.</span>
                                        {{-- <a href="<%- url_acuerdo_compra %>" target="_blank" class="text-skyblue upper-text text-lg normal-text">VER EN PDF</a> </li> --}}
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
                                <% if(codigo_estado === 21 && comprador) { %>
                                    <li>
                                        <button id="confirm-sale-agreement" class="button xmedium sky-blue btn-shadow bold-text radius btn-clean-margin">Aceptar entregables</button>
                                    </li>
                                <% } %>
                            </ul>
                        </div>

                    </div>
                </div>
            <% } %>

        </div>
    </div>
</div>