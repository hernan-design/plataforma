<div id="content-marketplace-sale-agreement">
    <div class="row">
        <div class="small-12 columns">
            <% if(tab == 'ventas') { %>
                @include('public.marketplace.form.createsaleagreement')
            <% } else if(tab == 'compras') { %>
                @include('public.marketplace.form.acceptsaleagreement')
            <% } %>

            <% if( typeof codigo_acuerdo_compra !== 'undefined' && !_.isNull(codigo_acuerdo_compra) ) { %>
                <div class="row">
                    <div class="small-6 columns">
                        <div id="wrapper-sale-agreement-discussion" class="panel-content radius">
                            {!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-sale-greement') ) !!}
                                <div class="textarea-post-discussion clearfix">
                                    <textarea placeholder="Comenta sobre el acuerdo" required name="texto_discucion" id="texto_discucion" cols="50" rows="2" class="materialize-textarea validate"></textarea>
                                    <label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
                                    <button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
                                </div>
                            {!! Form::close() !!}
                            @include('public.noresults', ['message' => 'No hay discusiones'])
                            <section id="discussion-posts-wrap" class="">
                                {{-- Render Tasks template --}}
                            </section>
                        </div>
                    </div>
                    <div class="small-6 columns">
                        <label class="label single text-md lighter-text gray-dark-text">Participantes en esta discusión</label>

                        <div id="participant-discussion" class="content-data-list">
                            @include('public.noresults', ['message' => 'No hay resultados'] )
                            <ul id="participants-discussion-wrap" class="mobile-block-grid-1 browse-list-users">
                                {{-- Render Tasks template --}}
                            </ul>
                        </div>
                    </div>
                </div>
            <% } %>
        </div>
    </div>
</div>