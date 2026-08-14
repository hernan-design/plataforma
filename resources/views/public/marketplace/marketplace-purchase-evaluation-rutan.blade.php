<div class="row">
    <div class="small-12 columns">
        <div class="panel-marketplace-purchase-evaluation panel-content radius">

            <div class="row">
                <div class="mobile-10 small-9 mobile-centered columns">
                    <div class="wrap-icon-marketplace text-center">
                        <span class="marketplace-circle circle-reflex-bottom">
                            <i class="mdi <%- state_purchase == 'cancelled' || state_purchase == 'removed' ? 'mdi-close' : 'mdi-star' %>"></i>
                        </span>
                    </div>
                    <div class="description-content text-center">
                        <h5 class="lighter-header sky-blue-text title-info"><%- state_purchase == 'cancelled' || state_purchase == 'removed' ? 'Cancelación' : 'Calificación' %> de la <%- tab == 'compras' ? 'compra' : 'venta' %></h5>
                        <p class="text-md thin-text"><%- state_purchase == 'cancelled' || state_purchase == 'removed' ? '' : 'Nos gustaría saber si salió todo bien. Tu comentario es muy importante para el resto de los usuarios.' %></p>
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
                <div class="mobile-11 small-10 tablet-9 mobile-centered columns">
                    {!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-eval-purchase') ) !!}
                        <% if(state_purchase == 'confirmed' || state_purchase == 'finalized'){ %>
                            <div class="row">
                                <div class="small-12 columns">
                                    <ul id="items-purchase-evaluation" class="list-highlighted no-bullet">
                                        @foreach(App\ItemEvaluacionCompra::getItemEvalPurchaseList() as $itemeval)
                                            <% if( {{ $itemeval->tipo_item_evaluacion_compra }} == window._tp.typePart[ (tab == 'compras' ? 'purchaser' : 'seller') ]) {  %>
                                                <li>
                                                    <div class="clearfix" data-dropdown="drop-evaluation-{{$itemeval->codigo_item_evaluacion_compra}}" aria-controls="drop-evaluation-{{$itemeval->codigo_item_evaluacion_compra}}" data-options="align:top;is_hover:true;" aria-expanded="false">
                                                        <a  class="text-md gray-dark-text is-hovered">{{ $itemeval->nombre_item_evaluacion_compra }}</a>
                                                        <div id="drop-evaluation-{{$itemeval->codigo_item_evaluacion_compra}}" class="md-dropdown content radius" data-dropdown-content aria-hidden="true" >
                                                            {{ $itemeval->descripcion_item_eval_compra }}
                                                        </div>
                                                        <div class="right stars-rating stars-30">
                                                            <input type="radio" name="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}" id="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_5" value="5" required="required" class="check-star">
                                                            <label for="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_5" class="label-terms"><i class="mdi mdi-star"></i></label>
                                                            <input type="radio" name="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}" id="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_4" value="4" required="required" class="check-star">
                                                            <label for="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_4" class="label-terms"><i class="mdi mdi-star"></i></label>
                                                            <input type="radio" name="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}" id="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_3" value="3" required="required" class="check-star">
                                                            <label for="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_3" class="label-terms"><i class="mdi mdi-star"></i></label>
                                                            <input type="radio" name="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}" id="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_2" value="2" required="required" class="check-star">
                                                            <label for="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_2" class="label-terms"><i class="mdi mdi-star"></i></label>
                                                            <input type="radio" name="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}" id="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_1" value="1" required="required" class="check-star">
                                                            <label for="evaluacion_item_compra_{{$itemeval->codigo_item_evaluacion_compra}}_1" class="label-terms"><i class="mdi mdi-star"></i></label>
                                                        </div>
                                                    </div>
                                                </li>
                                            <% } %>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        <% } %>
                        <% if(state_purchase == 'cancelled' || state_purchase == 'removed'){ %>
                            <div class="row">
                                <div class="small-12 columns input-field">
                                    <select name="codigo_motivo_cancel_compra" class="" required data-placeholder="Motivo de cancelación" placeholder="Motivo de cancelación">
                                        <option value="" selected disabled>Motivo de cancelación</option>
                                        @foreach( App\MotivoCancelacionCompra::getCancellReasonList() as $reason)
                                            <% if( {{ $reason->clase_motivo_cancelacion_compra }} == window._tp.typePart[ (tab == 'compras' ? 'purchaser' : 'seller') ]) {  %>
                                            <option value="{{ $reason->codigo_motivo_cancel_compra }}">{{ $reason->nombre_motivo_cancel_compra }}</option>
                                            <% } %>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        <% } %>

                        <% if(seller && state_purchase != 'cancelled'){ %>
                            <div class="row col-equal-height align-bottom">
                                <div class="tablet-7 columns input-field">
                                    <textarea required name="cometario_evaluacion_compra" id="cometario_evaluacion_compra" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200" required></textarea>
                                    <label for="cometario_evaluacion_compra" data-error="El campo esta vació o tiene muy pocos caracteres">Recomendaciones para el empresario (Cosas por mejorar y/o aspectos a tener en cuenta para su crecimiento)  </label>
                                </div>
                                <div class="tablet-5 columns input-field">
                                    <select name="tipo_comentario_evaluacion" class="" data-placeholder="Seleccione la opción" placeholder="Seleccione la opción" required>
                                        <option value="" selected disabled>Seleccione la opción</option>
                                        @foreach( App\TipoComentarioEvaluacion::getEvaluationCommitType(App\Compra::getTypeUser('seller')) as $value)
                                            <option value="{{ $value->tipo_comentario_evaluacion }}">{{ $value->nombre_tipo_comentario }}</option>
                                        @endforeach
                                    </select>
                                    <label>Elige si tu comentario es positivo, negativo o neutral</label>
                                </div>
                            </div>
                        <% }else if(purchaser  && state_purchase != 'cancelled'  ){ %>
                            <div class="row col-equal-height align-bottom">
                                <div class="tablet-7 columns input-field">
                                    <select name="tipo_comentario_evaluacion" id="tipo_comentario_evaluacion" class="" data-placeholder="Seleccione la opción" placeholder="Seleccione la opción" required>
                                        <option value="" selected disabled>Seleccione la opción</option>
                                        @foreach( App\TipoComentarioEvaluacion::getEvaluationCommitType(App\Compra::getTypeUser('purchaser')) as $value)
                                            <option value="{{ $value->tipo_comentario_evaluacion }}">{{ $value->nombre_tipo_comentario }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_comentario_evaluacion">{{ transtp('evaluations.typeevaluationcommentpurchaser') }}</label>
                                </div>
                                <div class="tablet-5 columns input-field">
                                    <textarea required name="cometario_evaluacion_compra" id="cometario_evaluacion_compra" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
                                    <label for="cometario_evaluacion_compra" data-error="El campo esta vació o tiene muy pocos caracteres">¿Por qué?</label>
                                </div>
                            </div>
                            <% if( (state_purchase != 'cancelled') && (state_purchase != 'removed'  ) ){ %>
                                @php
                                    $typeEvaluationQualityCommentList = App\TipoComentarioEvaluacion::getEvaluationCommitType(App\Compra::getTypeUser('purchaser'), 'quality');
                                @endphp
                                @if( !empty($typeEvaluationQualityCommentList) && ($typeEvaluationQualityCommentList  instanceof Illuminate\Database\Eloquent\Collection) && $typeEvaluationQualityCommentList->isNotEmpty())
                                    <div class="row col-equal-height align-bottom">
                                        <div class="tablet-7 columns input-field">
                                            <select name="cor_tipo_comentario_evaluacion" id="tipo_comentario_calidad" class="" data-placeholder="Seleccione la opción" placeholder="Seleccione la opción" required>
                                                <option value="" selected disabled>Seleccione la opción</option>
                                                @foreach( $typeEvaluationQualityCommentList as $value)
                                                    <option value="{{ $value->tipo_comentario_evaluacion }}">{{ $value->nombre_tipo_comentario }}</option>
                                                @endforeach
                                            </select>
                                            <label for="tipo_comentario_calidad"> {{transtp('evaluations.typequalitycommentpurchaser')}}</label>
                                        </div>
                                        <div class="tablet-5 columns input-field">
                                            <textarea required name="cometario_calidad_compra" id="comentario_calidad_compra" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
                                            <label for="comentario_calidad_compra" data-error="El campo esta vació o tiene muy pocos caracteres">¿Por qué?</label>
                                        </div>
                                    </div>
                                @endif
                            <% } %>
                        <% } %>
                        <div class="row">
                                {{-- <% if( (acuerdo_producto === true && !_.isEmpty(acuerdos_adjuntos) && validationDeliverables) || state_purchase == 'cancelled' || state_purchase == 'removed' || !acuerdo_producto ) { %> --}}

                                <div class="mobile-12 small-12 tablet-offset-2 tablet-4 medium-3 medium-offset-3 columns">
                                    <a href="{{ route('marketplace.compras.index') }}" title="Ver mis compras" class="button medium sky-blue expand btn  btn-shadow radius btn-lowerc">Ver mis compras</a>
                                </div>
                                <div class="mobile-12 small-12 tablet-4 medium-3 columns end">
                                    <button class="button expand xmedium sky-blue radius btn-shadow register-calification btn btn-submit" type="submit">Enviar</button>
                                </div>

                            {{-- <% } else { %>
                                <div class="small-12 columns save-section">
                                    <% if(purchaser){ %>
                                        <p class="text-md alert-text text-center">{{ transtp('marketplace.agreement.deliverables.purchaser') }}
                                        </p>
                                    <% } %>
                                    <% if(seller){ %>
                                        <p class="text-md alert-text text-center">{{ transtp('marketplace.agreement.deliverables.seller') }}
                                        </p>
                                    <% } %>
                                </div>
                                <div class="small-11 tablet-4 medium-3 small-centered columns">
                                    <a href="{{ route('marketplace.compras.index') }}" title="Ver mis compras" class="button medium sky-blue expand btn-shadow radius btn-lowerc">Ver mis compras</a>
                                </div>
                            <% } %> --}}
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>