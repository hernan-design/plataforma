@extends('public.marketplace.marketplace')

@section('marketplace.content')

	{{-- ------------------ MarketPlace Templates JS -------------------- --}}
	{{-- marketplace filter menu  --}}
	<script type="text/template" id="marketplace-sidemenu-filter-tpl">
		<div class="wrapper-side-nav radius-bottom">
			<a href="#" class="toggle-slide-collapse button-collapse hide-for-tablet-up" data-activates="slide-out">
				<i class="mdi mdi-filter mdi-21 vcenter gray-base"></i>
				<span class="title-side-nav text-sm">Filtrar</span>
			</a>
			<a href="#" class="toggle-slide-drop show-for-tablet-up">
				<i class="mdi mdi-filter mdi-21 vcenter gray-base"></i>
				<span class="title-side-nav text-sm">Filtrar el contenido</span>
			</a>
			<div id="slide-out" class="content-filters-sidemenu">
				{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-marketplace')) !!}
					<ul class="side-nav-slide">
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="provider" id="nombre_proveedor" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('marketplace.provider.index') ) %>" data-param="<%- window._tp.getRole['seller'] %>" data-initial-value="<%- typeof(provider) !== 'undefined' ? provider : '' %>" data-placeholder="Seleccione {{ transtp('marketplace.filters.provider') }}" placeholder="Seleccione {{ transtp('marketplace.filters.provider') }}">
									</select>
									<label for="nombre_proveedor">{{ transtp('marketplace.filters.provider') }}</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="text" name="name" id="nombre_producto" value="<%- typeof(name) !== 'undefined' ? name : '' %>" class="keyup-search">
									<label for="nombre_producto">{{ transtp('marketplace.filters.product') }}</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="category" id="categoria_producto" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('marketplace.categoriaproducto.index') ) %>"  data-param="category" data-initial-value="<%- typeof(categoria) !== 'undefined' ? categoria : '' %>"   data-placeholder="Seleccione Categoría" placeholder="Seleccione Categoría }}">
									</select>
									<label for="categoria_producto">Categoría:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="modality" class="browser-default choice-select-deselect change-choice" data-placeholder="Seleccione una modalidad" placeholder="Seleccione una modalidad">
										<option value=""></option>
										<option value="1" <%- typeof(modality) !== 'undefined' && modality == 1 ? 'selected': ''%>>{{ transtp('marketplace.create.modality.virtual') }}</option>
										<option value="2" <%- typeof(modality) !== 'undefined' && modality == 2 ? 'selected': ''%>>{{ transtp('marketplace.create.modality.semipresencial') }}</option>
										<option value="3" <%- typeof(modality) !== 'undefined' && modality == 3 ? 'selected': ''%>>{{ transtp('marketplace.create.modality.presencial') }}</option>
									</select>
									<label>Modalidad:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="city" class="browser-default choice-select-deselect change-choice" data-placeholder="Seleccione una ubicación">
										<option value=""></option>
										@foreach( App\Ciudad::getCities() as $city)
											<option value="{{ $city->key }}" <%- typeof(city) !== 'undefined' && city == '{{ $city->key }}' ? 'selected': ''%> >{{ $city->value }}</option>
										@endforeach
									</select>
									<label>Ciudad:</label>
								</div>
							</div>
						</li>
						<li>
							<!--<div class="row">
								<div class="small-12 columns range-field">
									<label>Rango: <span class="dark-text">Precios</span></label>
									<div class="range-price" data-inputrange="precio_minimo,precio_maximo"></div>
								</div>
							</div>-->
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="text" name="price_min" id="precio_minimo" class="currency-mask-cop">
									<label for="precio_minimo">Precio mínimo</label>
								</div>
							</div>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="text" name="price_max" id="precio_maximo" class="currency-mask-cop">
									<label for="precio_maximo">Precio máximo</label>
								</div>
							</div>
							<div class="row">
								<div class="small-12 columns">
									<button class="button xtiny sky-blue radius btn-clean-margin right" type="submit"><i class="mdi mdi-chevron-right mdi-24"></i></button>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="mobile-12 small-11 small-centered columns">
									<a href="#" class="clean-filters button xsmall inst-secondary-outline expand radius btn-clean-margin btn-lowerc">Borrar todos los filtros</a>
								</div>
							</div>
						</li>
					</ul>
				{!! Form::close() !!}
			</div>
		</div>
	</script>

	{{-- Section Products --}}
	<script type="text/template" id="marketplace-list-tpl">

		{{-- Top marketplace header --}}

		<!-- module navigation -->
		<div id="marketplace-menu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
			<div class="row">
				<div class="small-12 columns">
                    <div class="tabs-container">
                        <ul id="marketplace-tabs-navs" class="tabs-sub-nav-alt tabs-route text-right" data-tab data-tab-init="is_hover:false">
                            <li class="tab-title <%- tab == 'browse' ? 'active' : '' %>">
                                <a href="<%- Route.route('marketplace.index') %>" title="Catálogo" aria-controls="catalogo-marketplace" clas="">Catálogo</a>
                            </li>
                            @if( Auth::check() )
                                <li class="tab-title <%- tab == 'myBuys' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.compras.index') %>" title="Mis {{transtp('marketplace.purchaseTitle')}}" aria-controls="my-purchases">{{transtp('marketplace.purchaseTitle')}} ({{ Auth::user()->institucion->contador_compras }})</a>
								</li>
								@if(Auth::user()->hasRole(['seller', 'super-admin']))
                                <li class="tab-title <%- tab == 'mySales' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.ventas.index') %>" title="Mis Ventas" aria-controls="my-sales"> Ventas ({{ Auth::user()->institucion->contador_ventas }})</a>
								</li>
								@endif
                                <li class="tab-title <%- tab == 'myFavorites' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.tab', {tab: 'favoritos'})%>" title="Mis Favoritos" aria-controls="catalogo-marketplace">Favoritos ({{ Auth::user()->productosFavoritos() }})</a>
                                </li>
                                @if(Auth::user()->hasRole(['seller', 'super-admin']))
                                    <li class="tab-title <%- tab == 'myProducts' ? 'active' : '' %>">
                                        <a href="<%- Route.route('marketplace.tab', {tab: 'misproductos'})%>" title="{{ transtp('marketplace.products') }}" aria-controls="catalogo-marketplace">{{ transtp('marketplace.products') }} ({{ Auth::user()->productos()  }})</a>
                                    </li>
                                    <li class="tab-title <%- tab == 'myPromotions' ? 'active' : '' %>">
                                        <a href="<%- Route.route('marketplace.ventas.promocion.index')%>" title="Mis Promociones" aria-controls="catalogo-marketplace">Promociones</a>
                                    </li>
                                @endif

                                @if( Auth::user()->ability('super-admin', 'create', ['module'  => '/marketplace']) && App\Institucion::hasPermission('create-products') )
                                    <li class="tab-title has-dropdown tab-more" data-options role="navigation">
                                        <a href="" data-dropdown="drop-desk-nav" data-options="is_hover:true" class="mdi mdi-chevron-down vcenter link-option-submenu tab-icon-right">Más</a>
                                        <ul id="drop-desk-nav" data-dropdown-content class="tabs-dropdown dropdown no-bullet inst-bgcolor-secondary f-dropdown">
                                            <li>
                                                <a href="<%- window.Misc.urlFull(Route.route('marketplace.create')) %>" class="mdi mdi-plus drop-icon-left">{{ transtp('marketplace.create.products') }}</a>
                                            </li>
                                            <li>
                                                <a href="<%- window.Misc.urlFull(Route.route('marketplace.ventas.promocion.create')) %>" class="mdi mdi-plus drop-icon-left">Crear promoción</a>
                                            </li>
                                        </ul>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </div>
				</div>
			</div>
		</div>

        <!-- module responsive navigation -->
        <div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">Marketplace<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
                        <ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
                            <li class="<%- tab == 'browse' ? 'active' : '' %>">
                                <a href="<%- Route.route('marketplace.index') %>">Catálogo</a>
                            </li>
                            @if( Auth::check() )
                                <li class="<%- tab == 'myBuys' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.compras.index') %>">Compras ({{ Auth::user()->institucion->contador_compras }})</a>
                                </li>
                                <li class="<%- tab == 'mySales' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.ventas.index') %>">Ventas ({{ Auth::user()->institucion->contador_ventas }})</a>
                                </li>
                                <li class="<%- tab == 'myFavorites' ? 'active' : '' %>">
                                    <a href="<%- Route.route('marketplace.tab', {tab: 'favoritos'})%>" title="Mis Favoritos" aria-controls="catalogo-marketplace">Favoritos ({{ Auth::user()->institucion->contador_favoritos }})</a>
                                </li>
                                @if(Auth::user()->hasRole(['seller', 'super-admin']))
                                    <li class="<%- tab == 'myProducts' ? 'active' : '' %>">
                                        <a href="<%- Route.route('marketplace.tab', {tab: 'misproductos'})%>" title="{{ transtp('marketplace.products') }}" aria-controls="catalogo-marketplace">{{ transtp('marketplace.products') }} ({{ Auth::user()->productos() }})</a>
                                    </li>
                                    <li class="<%- tab == 'myPromotions' ? 'active' : '' %>">
                                        <a href="<%- Route.route('marketplace.ventas.promocion.index')%>" title="Mis Promociones" aria-controls="catalogo-marketplace">Promociones</a>
                                    </li>
                                @endif
                                @if( Auth::user()->ability('super-admin', 'create', ['module'  => '/marketplace']) && App\Institucion::hasPermission('create-products') )
                                    <li>
                                        <a href="<%- window.Misc.urlFull(Route.route('marketplace.create')) %>" class="mdi mdi-plus drop-icon-left">{{ transtp('marketplace.create.products') }}</a>
                                    </li>
                                    <li>
                                        <a href="<%- window.Misc.urlFull(Route.route('marketplace.ventas.promocion.create')) %>" class="mdi mdi-plus drop-icon-left">Crear promoción</a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </dl>
                </div>
            </div>
        </div>

		{{-- marketplace content main --}}
		<div id="marketplace-content-main">
			<div class="row mobile-collapse tablet-uncollapse">
				<div class="small-12 columns">
					<div class="fx-main-content">
						<div class="fx-col-left">
							<div id="wrapper-filter-bar" class="sticky-filter-top">
								<div id="side-menu-filter" class="filter-side-nav-left">
									{{-- Render side menu filter --}}
								</div>
							</div>
						</div>

						<div class="fx-col-content">
							{{-- marketplace promotions --}}
							<div class="row">
								<div class="small-12 columns">
									<div id="content-marketplace-promotions-list" class="content-data-list content-marketplace-promotions-list h-hollow-bottom">
										{{-- @include('public.noresults', ['message' => 'No hay promociones']) --}}
										<ul id='marketplace-product-promotions-list' class="mobile-block-grid-1 small-block-grid-3 medium-block-grid-5 browse-list-mask browse-list-marketplaces-trending slick-browse adaptive-images">
											<!-- Render marketplace promotions list -->
										</ul>
									</div>
								</div>
							</div>

							{{-- marketplace trending --}}
							@if( App\RegistroSesion::institution()->lista_favoritos_marketplace )
								<% if( jQuery.inArray(tab, ['browse', 'createSeller']) !== -1 ) { %>
									<div class="row">
										<div class="small-12 columns">
											<div id="content-marketplace-trending-list" class="content-data-list content-marketplace-trending-list h-hollow-bottom">
												@include('public.noresults', ['message' => 'No hay productos destacados'])
												<ul id='marketplace-product-trending-list' class="mobile-block-grid-1 small-block-grid-3 medium-block-grid-5 browse-list-mask browse-list-marketplaces-trending slick-browse adaptive-images">
													<!-- Render marketplace Trending list -->
												</ul>
											</div>
										</div>
									</div>
								<% } %>
							@endif

							{{-- content create seller --}}
                            @if( Auth::check() && App\Institucion::hasPermission('assign-seller') && !Auth::user()->hasRole(['seller']) )
                                <div id="content-create-seller">
									<div class="row">
										<div class="small-12 columns">
											<p class="text-md clean-bottom text-center">
												Aún no eres un proveedor. <a href="<%- Route.route('marketplace.ventas.create') %>" class="button tiny sky-blue radius btn-lowerc btn-bold">Sé un proveedor</a> crea productos para publicarlos.
											</p>
										</div>
									</div>
									<hr class="h-hollow-top">
								</div>
							@endif

							<div class="row">
								<div class="small-12 columns">
									{{-- section marketplace content --}}
									<div class="tabs-content section-content-marketplace">
										<section class="content <%- $.inArray(tab,['createSeller','browse','myProducts','myFavorites']) != -1 ? 'active' : '' %>" id="catalogo-marketplace">
											{{-- Render browse product template id:browse-product-tpl --}}
										</section>

										@if( Auth::check() )
											<section class="content <%- $.inArray(tab,['createProduct']) != -1 ? 'active' : '' %>" id="create-product-marketplace">
													{{-- Render id="marketplace-create-product-tpl --}}
											</section>

											<section class="content <%- $.inArray(tab,['createPromotion']) != -1 ? 'active' : '' %>" id="create-promotion-marketplace">
													{{-- Render id="marketplace-create-promotion-tpl --}}
											</section>

											<section class="content <%- $.inArray(tab,['myBuys']) != -1 ? 'active' : '' %>" id="my-purchases">
												<div class="row">
													<div class="small-9 small-offset-3 columns">
														<ul class="inline-list-grid no-bullet align-center">
															<li class="has-image no-wrap">
																<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
															</li>
															<li>
																<div class="wrap-pagination clearfix">
																	{{-- Render Pagination--}}
																</div>
															</li>
														</ul>
													</div>
												</div>

												{{-- wallet user section  --}}
												<div class="row">
													@if (App\RegistroSesion::getIntitutionTypeCoin())
														<div class="small-3 columns">
															<div class="wallet-section">
																<div class="panel-content with-title radius">
																	<h6 class="title-panel white-bg lighter-header clean-bottom text-sm gray-base-text text-right">
																		<span class="left">Monedero</span><i class="mdi mdi-wallet mdi-18 gray-light vcenter"></i>
																	</h6>
																	<div class="user-wallet">
																		<ul class="list-separator no-bullet">
																			<li>
																				<ul class="wallet-item inline-list-grid align-middle no-bullet">
																					<li class="text-left">
																						<span class="text-xsm"><i class="mdi mdi-tag-text-outline mdi-24 vcenter icon-circle gutter-right item-label"></i>Compras</span>
																					</li>
																					<li class="text-right">
																						<span class="black-text text-sm">{{ App\DetalleVoucher::getDetailVoucher() ?  number_format(App\DetalleVoucher::getDetailVoucher()->valor_total_acuerdos, 0, ",", ".") : '0' }}</span>
																					</li>
																				</ul>
																			</li>
																			<li>
																				<ul class="wallet-item inline-list-grid align-middle no-bullet">
																					<li class="text-left">
																						<span class="text-xsm"><i class="mdi mdi-currency-usd mdi-24 vcenter icon-circle gutter-right item-label wallet-balance"></i>Saldo</span>
																					</li>
																					<li class="text-right">
																						<span class="ballance-number bold-text">{{ App\DetalleVoucher::getDetailVoucher() ?  number_format(App\DetalleVoucher::getDetailVoucher()->saldo_detalle_voucher, 0, ",", ".") : '0' }}</span>
																					</li>
																				</ul>
																			</li>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
													@endif

													{{-- purchases list --}}
													<div class="small-9 columns">
														<div class="content-data-list">
															@include('public.noresults', ['message' => transtp('marketplace.nonePurchase')])
															<ul id='my-purchases-list' class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-3 browse-list-mask list-my-purchases">
																<!-- Render mypurchases list -->
															</ul>
														</div>
													</div>
												</div>

												{{-- purchases pagination --}}
												<div class="row">
													<div class="small-9 small-offset-3 columns">
														<ul class="inline-list-grid no-bullet align-center">
															<li class="has-image no-wrap">
																<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
															</li>
															<li>
																<div class="wrap-pagination clearfix">
																	{{-- Render Pagination--}}
																</div>
															</li>
														</ul>
													</div>
												</div>
											</section>

											@if( Auth::user()->hasRole(['seller']) )
												<section class="content <%- $.inArray(tab,['mySales']) != -1 ? 'active' : '' %>" id="my-sales">
													<ul class="inline-list-grid no-bullet align-center">
														<li class="has-image no-wrap">
															<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
														</li>
														<li>
															<div class="wrap-pagination clearfix">
																{{-- Render Pagination--}}
															</div>
														</li>
													</ul>
													<div class="content-data-list">
														@include('public.noresults', ['message' => 'No tienes ventas.'])
														<ul id='my-sales-list' class="mobile-block-grid-1 small-block-grid-2 tablet-block-grid-4 browse-list-mask list-my-sales">
															<!-- Render mysales list -->
														</ul>
													</div>
													<ul class="inline-list-grid no-bullet align-center">
														<li class="has-image no-wrap">
															<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
														</li>
														<li>
															<div class="wrap-pagination clearfix">
																{{-- Render Pagination--}}
															</div>
														</li>
													</ul>
												</section>
												<section class="content <%- $.inArray(tab,['myPromotions']) != -1 ? 'active' : '' %>" id="my-promotions">
													<ul class="inline-list-grid no-bullet align-center">
														<li class="has-image no-wrap">
															<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
														</li>
														<li>
															<div class="wrap-pagination clearfix">
																{{-- Render Pagination--}}
															</div>
														</li>
													</ul>
													<div class="content-data-list">
														@include('public.noresults', ['message' => 'No tienes promociones.'])
														<ul id='my-promotions-list' class="mobile-block-grid-1 small-block-grid-2 browse-list-mask list-my-promotions">
															<!-- Render promotions list -->
														</ul>
													</div>
													<ul class="inline-list-grid no-bullet align-center">
														<li class="has-image no-wrap">
															<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
														</li>
														<li>
															<div class="wrap-pagination clearfix">
																{{-- Render Pagination--}}
															</div>
														</li>
													</ul>
												</section>
											@endif
										@endif

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="browse-product-tpl">
		<%
			var routePath = {
				'browse': 'marketplace.index',
				'myProducts': 'marketplace.tab',
				'myFavorites': 'marketplace.tab'
			}, routeTab = {
				'myProducts': 'misproductos',
				'myFavorites': 'favoritos'
			};

			var parameters = dataFilter;
			if(routeTab[tab]) _.extend( parameters, {tab:routeTab[tab]} );
		%>
		<ul class="settings-section-browse">
			<li class="has-image no-wrap">
				<ul class="views-filter-nav inline-list-grid no-spacing show-for-tablet-up">
					<li class="<%- dataFilter.v == 'list' ? 'active' : '' %>">
						<a href="<%- Route.route(routePath[tab], _.extend({}, parameters, {'v': 'list'}) ) %>" title="Ver en lista">
							<i class="mdi mdi-format-list-bulleted"></i>
						</a>
					</li>
					<li class="<%- dataFilter.v == 'grid' ? 'active' : '' %>">
						<a href="<%- Route.route(routePath[tab], _.extend({}, parameters, {'v': 'grid'}) ) %>" title="Ver en grilla">
							<i class="mdi mdi-view-grid"></i>
						</a>
					</li>
				</ul>
			</li>
			<!-- <li class="has-image no-wrap">
				<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
			</li> -->

			<li class="text-right">
				<ul class="inline-list-items">
					<li>
						<span class="gray-base-text text-md normal-text show-for-tablet-up">Ordernar por:</span>
					</li>
					<li>
						<select name="ordering" id="marketplace-ordering" class="select-ordering">
							<option value="" selected disabled>Ordenar por</option>
							<option value="desc" <%- dataFilter.orderBy && dataFilter.orderBy == 'desc' ? 'selected' : ''%>>{{ transtp('marketplace.filters.upscore') }}</option>
							<option value="asc" <%- dataFilter.orderBy && dataFilter.orderBy == 'asc' ? 'selected' : ''%>>{{ transtp('marketplace.filters.downscore') }}</option>
							<option value=">" <%- dataFilter.orderBy && dataFilter.orderBy == '>' ? 'selected' : ''%>>Mayor precio</option>
							<option value="<" <%- dataFilter.orderBy && dataFilter.orderBy == '<' ? 'selected' : ''%>>Menor precio</option>
						</select>
					</li>
				</ul>
			</li>
		</ul>
		<ul class="inline-list-grid no-bullet align-center">
			<li>
				<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
			</li>
			<li>
				<div class="wrap-pagination">
					{{-- Render Pagination--}}
				</div>
			</li>
		</ul>
		<hr class="h-hollow-bottom">
		<div id="content-marketplace-list" class="content-browse-list content-data-list h-hollow-bottom">
			@include('public.noresults')
			<ul id='marketplace-product-list' class="mobile-block-grid-1 small-block-grid-<%- dataFilter.v =='grid' ? '2' : 1 %> medium-block-grid-<%- dataFilter.v =='grid' ? '3' : 1 %> xxlarge-block-grid-<%- dataFilter.v =='grid' ? '4' : 1 %> browse-list-mask browse-list-marketplaces responsive-browse">
				<!-- Render marketplace list -->
			</ul>
		</div>
		<ul class="inline-list-grid no-bullet align-center">
			<li>
				<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
			</li>
			<li>
				<div class="wrap-pagination">
					{{-- Render Pagination--}}
				</div>
			</li>
		</ul>
	</script>

	{{-- item MarketPlace Trending list --}}
	<script type="text/template" id="trending-product-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="row collapse col-equal-height">
				<div class="mobile-4 tablet-4 xxlarge-3 columns">
					<div class="top-item-list no-border">
						<a href="<%= !_.isNull(promotion_code) ? Route.route('marketplace.show', {'marketplace': url_producto, promotion_code: promotion_code}) : Route.route('marketplace.show', {'marketplace': url_producto}) %>" title="<%- nombre_producto %>" class="item-thumb">
							<img src="<%= imagen_producto %>" alt="<%= nombre_producto %>"/>
						</a>
					</div>
				</div>
				<div class="mobile-8 tablet-8 xxlarge-9 columns">
					<div class="content-item-list">
						<h6 class="title-trending-marketplace bold-header">
							<a href="<%= !_.isNull(promotion_code) ? Route.route('marketplace.show', {'marketplace': url_producto, promotion_code: promotion_code}) : Route.route('marketplace.show', {'marketplace': url_producto}) %>" title="<%- nombre_producto %>" class="dark-text is-hovered">
								<%- nombre_producto %>
							</a>
						</h6>
						<p class="desc-trending-product text-md thin-text ellipsis"><%- resumen_producto %></p>

						<ul class="list-info-data no-bullet">
							<li>
								<span class="dark-text text-sm">&middot; <%- nombre_categoria_producto %></span>
							</li>
							<li>
								<div class="stars-rating stars-18 readonly disabled">
									<input type="radio" id="average_purchase_<%- id_producto %>_5" value="5" <%- window.Misc.inStar(avg_purchase_user) == 5 ? 'checked' : '' %>>
									<label for="average_purchase_<%- id_producto %>_5" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 5 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

									<input type="radio" id="average_purchase_<%- id_producto %>_4" value="4" <%- window.Misc.inStar(avg_purchase_user) == 4 ? 'checked' : '' %>>
									<label for="average_purchase_<%- id_producto %>_4" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 4 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

									<input type="radio" id="average_purchase_<%- id_producto %>_3" value="3" <%- window.Misc.inStar(avg_purchase_user) == 3 ? 'checked' : '' %>>
									<label for="average_purchase_<%- id_producto %>_3" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 3 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

									<input type="radio" id="average_purchase_<%- id_producto %>_2" value="2" <%- window.Misc.inStar(avg_purchase_user) == 2 ? 'checked' : '' %>>
									<label for="average_purchase_<%- id_producto %>_2" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 2 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

									<input type="radio" id="average_purchase_<%- id_producto %>_1" value="1" <%- window.Misc.inStar(avg_purchase_user) == 1 ? 'checked' : '' %>>
									<label for="average_purchase_general_1" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 1 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>
								</div>
							</li>
						</ul>
						<div class="bottom-item-list">
							<ul class="inline-list-grid options-bottom-item">
								<li class="text-left">
									<ul class="inline-list-items">
										<% if(precio_producto) {%>
										<li>
                                            <% if(descuento > 0){ %>
                                                <span class="gray-light-text heavy-text text-line-through">
                                                    <%- precio_producto > 0 ? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%>
                                                </span>
                                                <br>
                                                <span class="gray-light-text heavy-text text-xbg">
                                                    (-<%- porcentaje_descuento %>%)
                                                </span>
                                                <span class="gray-dark-text heavy-text text-xbg">
                                                    <%- window.copCurrencyF.to(parseFloat(descuento)) %>
                                                    <em class="gray-light-text text-xbg normal-text">iva incl.</em>
                                                </span>
                                            <% }else{ %>
                                                <span class="gray-dark-text heavy-text text-xbg">
                                                    <%- precio_producto > 0 ? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%>
                                                    <em class="gray-light-text text-xbg normal-text">iva incl.</em>
                                                </span>
                                            <% } %>
										</li>
										<% } %>
										<li>
											<i class="mdi mdi-star-circle mdi-24 sky-blue vtop tip-top radius" data-tooltip aria-haspopup="true" title="Destacado"></i>
										</li>
									</ul>
								</li>
								<li class="text-right">
									<a href="<%- window.Misc.urlFull(Route.route('marketplace.compras.create', {'product': url_producto})) %>" class="inst-color-secondary upper-text text-md normal-text">Adquirir</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- item promotions list --}}
	<script type="text/template" id="promotions-product-item-list-tpl">
		<div style="position:relative;height:100%" class="clearfix">
			<div class="item-wrap-list radius">
				<div class="top-item-list no-border">
					<% if(promo){ %>
						<a href="<%- Route.route('marketplace.show', {'marketplace': url_producto, promotion_code: promotion_code}) %>" title="<%- nombre_producto %>">
					<% }else{ %>
						<a href="<%- Route.route('marketplace.index', {user: codigo_usuario}) %>">
					<% } %>
                        <img src="<%- imagen_promocion %>" alt="<%- nombre_producto %>" title="<%- nombre_producto %>" class="">
                    </a>
				</div>
			</div>
		</div>
	</script>

	{{-- item MarketPlace list --}}
	<script type="text/template" id="product-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="top-item-list no-border">
				<a href="<%= Route.route('marketplace.show', {'marketplace': url_producto}) %>" title="<%- nombre_producto %>" class="item-thumb">
					<img src="<%- imagen_producto %>" alt="<%- nombre_producto %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_image') }}')">
				</a>
			</div>

			<div class="content-item-list text-left">
				<h5 class="title-item-list black-text is-hovered ellipsis is-truncated">
					<a href="<%= window.Misc.urlFull(Route.route('marketplace.show', {'marketplace': url_producto}))%>" title="<%- nombre_producto %>">
					<%- nombre_producto %>
					</a>
                </h5>
                <p class="nombre-entidad-list-item ellipsis is-truncated text-md bold-text"> <span class="dark-text"> <%- nombre_entidad %> </span></p>
				<p class="upper-text ellipsis is-truncated text-md"><%- nombre_categoria_producto %></p>

				<div class="bottom-item-list card-action">
					<ul class="inline-list-grid align-center">
						<li class="product-price">
							<span class="dark-text heavy-text"><%- (precio_producto > 0 && !producto_sin_precio) ? window.copCurrencyF.to(parseFloat(precio_producto)) : '' %></span>
						</li>
						<li>
							<span class="right">
								<a href="#" title="Añadir a favoritos" class="post-favorite-icon TPfavoritelink gray-light-text">
									<i class="mdi mdi-heart-outline mdi-24 vcenter"></i>
								</a>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</div>
    </script>

	{{-- view product roster on list --}}
	<script type="text/template" id="product-roster-list-tpl">
		<div class="item-wrap-list radius">
			<div class="row collapse col-equal-height">
				<div class="mobile-4 tablet-4 xxlarge-3 columns">
					<div class="top-item-list no-border">
						<a href="<%= !_.isNull(promotion_code) ? Route.route('marketplace.show', {'marketplace': url_producto, promotion_code: promotion_code}) : Route.route('marketplace.show', {'marketplace': url_producto}) %>" title="<%- nombre_producto %>" class="item-thumb">
							<img src="<%= imagen_producto %>" alt="<%= nombre_producto %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_image') }}')">
						</a>
					</div>
				</div>
				<div class="mobile-8 tablet-8 xxlarge-9 columns">
					<div class="content-item-list text-left content-roster-list">
						<h5 class="title-item-list black-text is-hovered ellipsis is-truncated">
							<a href="<%= !_.isNull(promotion_code) ? Route.route('marketplace.show', {'marketplace': url_producto, promotion_code: promotion_code}) : Route.route('marketplace.show', {'marketplace': url_producto}) %>" title="<%- nombre_producto %>">
							<%- nombre_producto %>
							</a>
						</h5>
                        <p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- resumen_producto %></p>
                        <span class="nombre-entidad-list-item dark-text text-sm bold-text"> <%- nombre_entidad %> </span>
                        <span class="product-nombre-entidad-middot">&bull;</span>
						<span class="category-list-item upper-text text-sm"><%- nombre_categoria_producto %></span>

						<div class="content-bottom-item-roster card-action">
							<ul class="inline-list-grid align-center">
								<li class="product-price">
									<% if(activacion_promocion) { %>
										<% if(descuento > 0 && precio_producto > 0 && !producto_sin_precio){ %>
											<span class="gray-light-text heavy-text text-line-through">
												<%- precio_producto > 0 ? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%>
											</span>
											<br>
											<span class="gray-light-text heavy-text text-xbg">
												(-<%- porcentaje_descuento %>%)
											</span>
											<span class="gray-dark-text heavy-text text-xbg">
												<%- window.copCurrencyF.to(parseFloat(descuento)) %>
											</span>
										<% } %>
									<% } else { %>
											<span class="gray-dark-text heavy-text text-xbg">
												<%- (precio_producto > 0 && !producto_sin_precio) ? window.copCurrencyF.to(parseFloat(precio_producto)) : '' %>
											</span>
									<% } %>
								</li>
								<li>
									<span class="right">
										<a href="#" title="Añadir a favoritos" class="post-favorite-icon TPfavoritelink gray-light-text">
											<i class="mdi mdi-heart-outline vcenter"></i>
										</a>
									</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section Detail Product --}}
	<script type="text/template" id="product-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true" aria-autoclose="false">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true" aria-autoclose="false">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-lg" data-dropdown-content class="md-dropdown drop-editing radius content large" aria-hidden="true" aria-autoclose="false">
				{{-- Render profile edit form --}}
			</div>
		<% } %>

		<div id="wrapper-detail-product" class="wrapper-detail-product">
			<div>
					<a class="button small btn-shadow" href="javascript:history.back();" ><i class="mdi mdi-chevron-left">Volver</i></a>
			</div>
			<div id="top-product-detail" class="top-product-detail">
				<div class="row col-equal-height">
					<div class="tablet-6 columns">
						<div class="card card-product-detail">
							<div id="product-main-image" class="wrapper-image-edit image-area-drop product-img-main card-image">
								{{-- Render image template--}}
							</div>

							<div class="card-content product-info-detail">
								<ul id="product-gallery-marketplace" class="mobile-block-grid-3 tablet-block-grid-6 slick-gallery">
									{{-- Render gallery --}}
								</ul>
								<% if(owner){ %>
									<div id="opt-edit-gallery-product" class="editable-item">
										<input type="checkbox" name="edit-gallery-product" id="edit-gallery-product" value="0" class="">
										<label for="edit-gallery-product">Galería editable</label>
									</div>
								<% } %>
								<div id="product-infobasic-container" class="editable-item">
									{{-- Render info basic --}}
								</div>
							</div>

							<div class="card-action product-action-detail">
								<ul class="inline-list-grid align-center">
									<li>
										<div id="product-location-container" class="editable-item">
											{{-- Render info location --}}
										</div>
									</li>
									<li>
										<ul class="text-right product-icons-shared social-box-icons">
											<li>
												<a href="#" title="Añadir a favoritos" class="post-favorite-icon TPfavoritelink">
													<i class="mdi mdi-heart-outline mdi-24"></i>
												</a>
											</li>
											<li>
												<ul id="drop-shared-social-product" class="drop-shared-social-product opts-action-dropdown drop-shared-social no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
													<li class="text-center">
														<label class="label single gray-base-text">Compartir en redes:</label>
														<ul class="inline-list-grid align-top">
															<li class="text-center">
																<a href="http://www.facebook.com/share.php?u=<%- window.Misc.urlFull( Route.route( 'marketplace.show', {marketplace: url_producto}) ) %>&title=<%- nombre_producto %>" title="Compartir en facebook" class="tp_facebook_share">
																	<i class="mdi mdi-facebook mdi-21 facebook"></i>
																</a>
															</li>
															<li class="text-center">
																<a href="http://www.linkedin.com/shareArticle?mini=true&url=<%= window.Misc.urlFull( Route.route( 'marketplace.show', {marketplace: url_producto}) ) %>&title=<%- nombre_producto %>&source=DOMAIN" title="Compartir en linkedin" class="tp_linkedin_share">
																	<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
																</a>
															</li>
															<li class="text-center">
																<a href="http://twitter.com/intent/tweet?status=<%- nombre_producto %>+<%- window.Misc.urlFull( Route.route( 'marketplace.show', {marketplace: url_producto}) ) %>" title="Compartir en X" class="">
																	<i class="mdi mdi-close-outline mdi-21 twitter"></i>
																</a>
															</li>
														</ul>
													</li>
												</ul>
												<a title="Compartir" data-dropdown="drop-shared-social-product" aria-controls="drop-shared-social-product" data-options="align:bottom;is_hover:false;hover_timeout:500">
													<i class="mdi mdi-share-variant mdi-21"></i>
												</a>
											</li>
											<li>
												<ul id="drop-liked-product" class="post-social-shared product-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
													<li>
														<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
													</li>
												</ul>
												<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-product" aria-controls="drop-liked-product" data-options="align:top;is_hover:true;hover_timeout:500">
													<i class="mdi mdi-thumb-up-outline mdi-21"></i>
													<span class="data-count-likes text-xmd"><%- contador_like %></span>
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="tablet-6 columns">
						<div class="card card-product-detail-info">
							<div class="card-content product-info-detail info-product-detail">
								<ul class="product-list-info no-bullet">
									<li>
										<h6 class="dark-text bold-header">{{ transtp('marketplace.product.abstract') }}</h6>
										<div id="product-summary-container" class="editable-item">
											{{-- Render info summary --}}
										</div>
									</li>
									<% if(!_.isUndefined(seg_codigo_usuario) && !_.isNull(seg_codigo_usuario)) { %>
										<li>
											<h6 class="dark-text bold-header">{{ transtp('entities.entity') }}</h6>
											<div id="product-infoentity-container" class="editable-item">
												{{-- Render info entity --}}
											</div>
										</li>
									<% } %>
									<li>
										<h6 class="dark-text bold-header">{{ transtp('entities.company.cellphone') }}</h6>
										<div id="product-infowhatsapp-container" class="editable-item">
											{{-- Render info entity --}}
											<a
												target="_blank"
												<%= !_.isNull(numero_whatsapp) ? "href=https://wa.me/57"+numero_whatsapp : "" %>
											>
												<span class="icon-data-basic">
													<i
														class="mdi mdi-whatsapp  vcenter mdi-21 gutter-right  gray-base-text"
														style="color: #45C655 !important;"
													>
													</i>
												</span>
												<%= !_.isNull(numero_whatsapp)
													? numero_whatsapp+'<i class="mdi mdi-gesture-double-tap  vcenter mdi-15 gutter-right  gray-base-text"></i>'
													: '' %>
											</a>
										</div>
									</li>
									<li>
										<h6 class="dark-text bold-header">Otra información</h6>
										<div id="product-infoclasification-container" class="editable-item">
											{{-- Render info clasificacion --}}
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="content-product-detail">
				@if (Auth::check())
					<% if(owner){ %>
						<div class="row">
							<div class="small-12 columns">
								<div class="content-state-product">
									<ul id="buttons-marketplace-product-action" class="inline-list-grid align-top">
										{{-- Render buttons follows --}}
									</ul>
								</div>
							</div>
						</div>
					<% } %>
				@endif

				<div class="row">
					<div class="tablet-6 columns">
						<div id="section-content-product-detail" class="panel-content radius">
							<h6 class="gray-dark-text bold-header">{{ transtp('marketplace.product.user-product-detail_title') }}</h6>

							<div class="card-user-product-detail card-user-info">
								<ul class="inline-list-grid align-center">
									<li class="has-image">
										<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="rounded-thumb"><img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size45"></a>
									</li>
									<li>
										<ul class="list-info-data no-bullet">
											<li>
												<h6 class="carduser-name-user bold-header dark-text clean-header is-hovered"><a href="<%= window.Misc.urlFull( url_profile  ) %>" title="<%- nombre_usuario %>" class="is-hovered"><%- nombre_usuario %></a></h6>
											</li>
											<li>
												<span class="gray-dark-text text-sm linear-span">
													<a href="<%= window.Misc.urlFull( url_profile ) %>" class="dark-text"><%- window.Misc.strToNickname(nickname_usuario) %></a>
													<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
														<span class="vertical-separator">&VerticalSeparator;</span>
														<%- nombre_ciudad %>, <%- nombre_pais %>
													<% } %>
                                                </span>
                                            </li>
                                            <% if(visibility_info_provider){ %>
                                                <li>
                                                    <span class="gray-dark-text text-sm linear-span">
                                                        <% if(!_.isNull(movil_usuario)){ %><span><%- movil_usuario %> &middot;</span><% } %>
                                                        <% if(!_.isNull(telefono_usuario)){ %><span><%- telefono_usuario %> &middot;</span><% } %>
                                                        <span><%- correo_electronico %></span>
                                                    </span>
                                                </li>
                                            <% } %>
											<li>
												<div class="stars-rating stars-18 readonly disabled">
													<input type="radio" id="average_purchase_<%- id_producto %>_5" value="5" <%- window.Misc.inStar(avg_purchase_user) == 5 ? 'checked' : '' %>>
													<label for="average_purchase_<%- id_producto %>_5" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 5 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

													<input type="radio" id="average_purchase_<%- id_producto %>_4" value="4" <%- window.Misc.inStar(avg_purchase_user) == 4 ? 'checked' : '' %>>
													<label for="average_purchase_<%- id_producto %>_4" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 4 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

													<input type="radio" id="average_purchase_<%- id_producto %>_3" value="3" <%- window.Misc.inStar(avg_purchase_user) == 3 ? 'checked' : '' %>>
													<label for="average_purchase_<%- id_producto %>_3" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 3 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

													<input type="radio" id="average_purchase_<%- id_producto %>_2" value="2" <%- window.Misc.inStar(avg_purchase_user) == 2 ? 'checked' : '' %>>
													<label for="average_purchase_<%- id_producto %>_2" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 2 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

													<input type="radio" id="average_purchase_<%- id_producto %>_1" value="1" <%- window.Misc.inStar(avg_purchase_user) == 1 ? 'checked' : '' %> >
													<label for="average_purchase_general_1" class="label-terms <%- window.Misc.inStarHalf(avg_purchase_user) == 1 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>
												</div>
											</li>
										</ul>
                                    </li>
								</ul>
							</div>

							<% if(averagepurchase.length > 0) { %>
								<div class="product-result-average-evaluation">
									<ul class="list-info-data no-bullet">
										<% _.each(averagepurchase, function (average, index) { %>
											<li>
												<ul class="inline-list-grid no-bullet align-center">
													<li>
														<span class="gray-base-text normal-text text-md"><%- average.nombre_item_evaluacion_compra %></span>
													</li>
													<li class="has-image no-wrap">
														<span class="circle-outline xsmall icon-14 gray-base bold-text"><%- average.valor_promedio %></span>
													</li>
													<li class="has-image no-wrap">
														<div class="stars-rating stars-30 readonly disabled">
															<input type="radio" id="average_purchase<%- index %>_5" value="5" <%- window.Misc.inStar(average.valor_promedio) == 5 ? 'checked' : '' %>>
															<label for="average_purchase<%- index %>_5" class="label-terms <%- window.Misc.inStarHalf(average.valor_promedio) == 5 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

															<input type="radio" id="average_purchase<%- index %>_4" value="4" <%- window.Misc.inStar(average.valor_promedio) == 4 ? 'checked' : '' %>>
															<label for="average_purchase<%- index %>_4" class="label-terms <%- window.Misc.inStarHalf(average.valor_promedio) == 4 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

															<input type="radio" id="average_purchase<%- index %>_3" value="3" <%- window.Misc.inStar(average.valor_promedio) == 3 ? 'checked' : '' %>>
															<label for="average_purchase<%- index %>_3" class="label-terms <%- window.Misc.inStarHalf(average.valor_promedio) == 3 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

															<input type="radio" id="average_purchase<%- index %>_2" value="2" <%- window.Misc.inStar(average.valor_promedio) == 2 ? 'checked' : '' %>>
															<label for="average_purchase<%- index %>_2" class="label-terms <%- window.Misc.inStarHalf(average.valor_promedio) == 2 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>

															<input type="radio" id="average_purchase<%- index %>_1" value="1" <%- window.Misc.inStar(average.valor_promedio) == 1 ? 'checked' : '' %> >
															<label for="average_purchase<%- index %>_1" class="label-terms <%- window.Misc.inStarHalf(average.valor_promedio) == 1 ? 'star-half' : '' %>"><i class="mdi mdi-star"></i></label>
														</div>
													</li>
												</ul>
											</li>
										<% }); %>
									</ul>
								</div>
							<% } %>

							<hr>
							<div id="product-infodescription-container" class="editable-item">
								{{-- Render info description--}}
							</div>
						</div>
					</div>

                    <% if(!_.isEmpty(recomendaciones)){ %>
                        <div class="tablet-6 columns">
                            <div class="panel-content radius">
                                <h6 class="dark-text bold-header">Recomendaciones de seguridad en la compra</h6>
                                <div id="section-product-recommendation">
                                    <ul class="wrapper-more-list align-center">
                                        <% _.each(recomendaciones, function(value, key){ %>
                                            <li class="has-image no-wrap text-justify gray-base-text">
                                                <span class="text-justify gray-base-text wrap-text normal-text text-xsm"><%- value.nombre_reco_marketplace %></span>
                                            </li>
                                        <% }) %>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <% } %>

					<div class="tablet-6 columns">
						<div id="section-product-discussion" class="panel-content radius">
							<div class="" id="wrapper-posts-discussion">
                                @if (Auth::check())
                                    <% if(!owner){ %>
                                        {!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-product') ) !!}
                                            <div class="textarea-post-discussion clearfix">
                                                <textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" pattern="max_char_textarea" class="materialize-textarea validate"></textarea>
                                                <label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
                                                <button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
                                            </div>
                                            <input type="hidden" name="codigo_producto" value="<%= codigo_producto %>" />
                                        {!! Form::close() !!}
                                    <% } %>

                                    @include('public.noresults', ['message' => 'No hay discusiones'])
                                    <section id="discussion-posts-wrap" class="">
                                        {{-- Render Tasks template --}}
                                    </section>
                                @else
                                    <span>Inicia sesión para realizar discusiones con el vendedor.</span>
                                @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Image main Product Create template --}}
	<script type="text/template" id="main-image-product-create-tpl">
		<img src="<%- imagen_producto %>" alt="<%- nombre_producto %>" title="<%- nombre_producto %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
		<button id="change-image-product" class="edit-photo change-photo small">
			<div class="edit-photo-content">
				<i class="mdi mdi-camera mdi-24 vcenter"></i>
				<span>Añadir una Imagen</span>
				<span class="editing-photo-message">Elegir una Imagen</span>
			</div>
		</button>
		<input type="hidden" id="imagen_producto" name="imagen_producto" value="<%- imagen_producto %>">
	</script>

	{{-- Image main promotion create template --}}
	<script type="text/template" id="main-image-promotion-create-tpl">
		<img src="<%- imagen_promocion %>" alt="" title="" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_promotion_image') }}') this.src = '{{ config('tuproyecto.no_promotion_image') }}';">
		<button id="change-image-promotion" class="edit-photo change-photo small">
			<div class="edit-photo-content">
				<i class="mdi mdi-camera mdi-24 vcenter"></i>
				<span>Añadir una Imagen</span>
				<span class="editing-photo-message">Elegir una Imagen</span>
			</div>
		</button>
		<input type="hidden" id="imagen_promocion" name="imagen_promocion" value="<%- imagen_promocion %>">
	</script>

	{{-- Visor de images miniatura --}}
	<script type="text/template" id="product-detail-attachment-item-tpl">
		<div class="product-gallery-image <%- editable ? 'image-area-drop' : 'light-preview-image' %>" data-gallery-img="g-img-<%- codigo_adjunto %>" data-lightbox="<%- direccion_adjunto ? direccion_adjunto : '{{ config('tuproyecto.no_image') }}' %>">
			<a href="#" class="<%- editable ? 'change-image-gallery' : '' %>" data-gallery-img="g-img-<%- codigo_adjunto %>">
				<img src="<%- direccion_adjunto ? direccion_adjunto : '{{ config('tuproyecto.no_image') }}' %>" alt="">
				<i class="mdi mdi-plus hidesoft"></i>
			</a>
		</div>
	</script>

	@if( Auth::check() )
		{{-- item my buy list --}}
		<script type="text/template" id="my-buy-item-list-tpl">
			@switch(App\RegistroSesion::getInstitutionSlug())
				@case('rutan')
					@include('public.marketplace.mybuyitemlistrutan')
					@break
				@default
					@include('public.marketplace.mybuyitemlist')
			@endswitch
		</script>

		{{-- item My Sales list --}}
		<script type="text/template" id="my-sales-item-list-tpl">
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
							<% if( !_.isUndefined(valor_total_compra) && valor_total_compra > 0) { %>
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
								<li>
									<label class="label single lighter-text dark-text text-xmd">Compra ofertada</label>
									<ul class="inline-list-grid no-bullet align-center">
										<li class="has-image">
											<i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
										</li>
										<li>
											<span class="gray-dark-text text-sm linear-span vcenter-text">Validar oferta</span>
										</li>
									</ul>
								<li>
							<% }else if(acuerdo_producto && _.contains(['confirm','confirmed','finalized'], state_purchase)) { %>
								<li>
									@if (App\RegistroSesion::getInstitutionSlug() != 'rutan')
									<ul class="inline-list-grid no-bullet align-center">
										<% if(acuerdo_compra) { %>
											<% if(state_agreement === window._tp.getState['progress']) { %>
												<li class="has-image">
													<i class="mdi mdi-table-edit mdi-24 gray-light vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">En progreso (<a href="<%- Route.route('marketplace.ventas.acuerdo.edit', {acuerdo: codigo_acuerdo_compra }) %>" class="sky-blue-text">editar acuerdo</a>)</span>
												</li>
											<% } else if(state_agreement === window._tp.getState['confirm'] || state_agreement === window._tp.getState['correction']) { %>
												<li class="has-image">
													<i class="mdi mdi-clock mdi-24 sky-blue vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.confirm', ['institution' => App\RegistroSesion::getInstitutionName()]) }}</span>
												</li>
											<% } else if(state_agreement === window._tp.getState['confirmed'] || state_agreement === window._tp.getState['finalized'] || state_agreement === window._tp.getState['review_deliverables']) { %>
												<li class="has-image">
													<i class="mdi mdi-check-all mdi-24 success vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">Aprobado (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver acuerdo</a>)</span>
												</li>
											<% } else if (state_agreement === window._tp.getState['rejection_of_deliverables']) { %>
											 	<li class="has-image">
													<i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">Pendiente de entregables (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver acuerdo</a>)</span>
												</li>
											 <% } else if (state_agreement === window._tp.getState['to_finalize']) { %>
												<li class="has-image">
													<i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.confirm', ['institution' => App\RegistroSesion::getInstitutionName()]) }} (<a href="<%- Route.route('marketplace.compras.acuerdo.show', {acuerdo: codigo_acuerdo_compra}) %>" class="sky-blue-text">ver acuerdo</a>)</span>
												</li>
											  <% } else { %>
												<li class="has-image">
													<i class="mdi mdi-clock mdi-24 gray-light vcenter"></i>
												</li>
												<li>
													<span class="gray-dark-text text-sm linear-span vcenter-text">{{ transtp('marketplace.agreement.waitconfirmationpurchaser') }} (<a href="<%- Route.route('marketplace.ventas.acuerdo.edit', {acuerdo: codigo_acuerdo_compra }) %>" class="sky-blue-text">editar acuerdo</a>)</span>
												</li>
											<% } %>
										<% } else { %>
											<li class="has-image">
												<i class="mdi mdi-human-greeting mdi-24 gray-light vcenter"></i>
											</li>
											<li>
												<span class="gray-dark-text text-sm linear-span vcenter-text">Acuerdo solicitado (<a href="<%- Route.route('marketplace.ventas.acuerdo.create', {venta: codigo_compra }) %>" class="sky-blue-text">crear acuerdo de negociación</a>)</span>
											</li>
										<% } %>
									</ul>
									@endif
								</li>
							<% } %>
						</ul>
					</div>
					<div class="bottom-item-list">
						<input type="checkbox" id="toggle-reveal-info-purchase-<%- id %>" class="toggle-reveal-info">
						<label for="toggle-reveal-info-purchase-<%- id %>" class="sky-blue btn-floating waves-effect waves-light"></label>

						<ul class="inline-list-grid">
							<li>
								<ul class="buttons-sale-action no-bullet left text-left inst-color-secondary">
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
									<label class="label single lighter-text dark-text text-xmd">{{ transtp('marketplace.purchaser') }}</label>
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
										<label class="label single lighter-text dark-text text-xmd"><%- nombre_clase_empren_insti ? nombre_clase_empren_insti : nombre_clase_emprendimiento %></label>
										<a href="<%= window.Misc.urlFull(Route.route( 'proyecto.proyecto', {'proyecto': nickname_entidad }))%>" title="<%- nombre_entidad %>" class="gray-dark-text text-sm"><%- nombre_entidad %></a>
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
									<ul class="buttons-sale-action no-bullet left text-left inst-color-secondary">
										{{-- Render buttoms Purchase --}}
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</script>

		{{-- My promotions list item --}}
		<script type="text/template" id="my-promotions-item-list-tpl">
			<div class="clearfix user-promotion-item radius-tablet-up">
				<a href="<%= Route.route('marketplace.ventas.promocion.edit', {'promocion': codigo_promocion}) %>" class="item-thumb radius">
					<img src="<%- imagen_promocion %>" alt="" title="" class="">
				</a>
			</div>
		</script>

		{{-- form create Seller --}}
		<script type="text/template" id="marketplace-create-seller-tpl">
			<div class="row">
				<div class="small-12 columns">
					<div id="section-create-seller" class="panel-content radius">
						@include('public.marketplace.form.createseller')
					</div>
				</div>
			</div>
		</script>

		{{-- form create Product --}}
		<script type="text/template" id="marketplace-create-product-tpl">
			<div id="new-product-content" class="panel-info with-title radius">
				<h5 class="title-panel text-left">{{ transtp('marketplace.create_product.new_producto') }}</h5>
				<div class="container-fields-product">
					@switch(App\RegistroSesion::getInstitutionSlug())
						@case('rutan')
							@include('public.marketplace.form.formcreateproduct.createproductrutan')
							@break
						@default
							@include('public.marketplace.form.formcreateproduct.createproduct')
					@endswitch
				</div>
			</div>
		</script>

		{{-- form create Promotion --}}
		<script type="text/template" id="marketplace-create-promotion-tpl">
			<div id="new-product-content" class="panel-info with-title radius">
				<h5 class="title-panel text-left">Nueva promoción</h5>
				<div class="container-fields-product">
					@include('public.marketplace.form.createpromotion')
				</div>
			</div>
		</script>

		{{-- Product attachement item --}}
		<script type="text/template" id="product-attachment-item-tpl">
			<div class="product-gallery-image image-area-drop" data-gallery-img="g-img-<%- codigo_adjunto %>">
				<a href="#" class="change-image-gallery" data-gallery-img="g-img-<%- codigo_adjunto %>">
					<input type="hidden" name="images_gallery" class="img_gallery" value="<%- direccion_adjunto %>">
					<img src="<%- direccion_adjunto ? direccion_adjunto : '{{ config('tuproyecto.no_image') }}' %>" alt="">
					<i class="mdi mdi-plus"></i>
				</a>
			</div>
		</script>

		{{-- Section Detail Product --}}
		<script type="text/template" id="marketplace-purchase-tpl">
			<div id="content-purchase-marketplace">
				<div class="row">
					<div class="small-12 columns">

						<div class="panel-purchase-confirm panel-info with-title">
							<h5 class="title-panel text-left">{!! transtp('marketplace.titleconfirmPurchase') !!}</h5>

							<div class="row">
								<div class="small-10 small-centered columns">
									<div class="wrap-icon-confirm-purchase text-center">
										<span class="confirm-purchase-circle circle-reflex-bottom">
											<i class="mdi mdi-cart-outline"></i>
										</span>
									</div>
									<div class="description-content text-center">
										<span class="dark-text bold-text text-lg">{{ Auth::user()->nombre_usuario }}, <span class="thin-text sky-blue-text">{!! transtp('marketplace.confirmPurchase') !!}</span></span>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="small-12 small-centered columns">
									{!! Form::open( ['action' => null, 'data-abide' => '', 'id' => 'form-purchase-order'] ) !!}

										<div class="content-data-list content-data-products-purchase">
											<ul class="mobile-block-grid-1 browse-list-mask list-products-purchase adaptive-images">
												<li>
													<div class="item-wrap-list radius">
														<div class="row collapse col-equal-height">
															<div class="small-5 medium-4 columns">
																<div class="top-item-list no-border">
																	<div class="item-thumb">
																		<img src="<%= imagen_producto %>" alt="<%- nombre_producto %>">
																	</div>
																</div>
															</div>
															<div class="small-7 medium-8 columns">
																<div class="content-item-list text-left">

																	<h5 class="title-product-purchase sky-blue-text"><%- nombre_producto %></h5>
																	<p class="desc-product-purchase text-md lighter-text dark-text ellipsis"><%- resumen_producto %></p>

																	<div class="no-border">
																		<ul class="no-bullet options-bottom-item">
																			<% if(manejo_unidades) { %>
																				<li>
																					<ul class="no-bullet inline-list-grid no-wrap vcenter">
																						<li class="has-image">
																							<label class="label single text-lg lighter-text sky-blue-text">Cantidad:</label>
																						</li>
																						<li style="width:20%">
																							<input type="text" name="unidades" id="quantity-buy" value="<%- quantity %>" class="spinner-quantity no-change" required pattern="greater_than_zero" />
																						</li>
																						<li>
																							<span class="text-md">&nbsp;Unidades de <%- cantidad_producto %></span>
																						</li>
																					</ul>
																				</li>
																			<% } %>
																			<li>
																				<label class="label single text-lg lighter-text sky-blue-text">Email:</label>
																				<span class="text-md">{{ Auth::user()->correo_electronico }}</span>
																			</li>
																			<li>
																				<% if (activacion_promocion) { %>
																					<% if(descuento > 0 && precio_producto > 0 && !producto_sin_precio){ %>
																						<span class="gray-light-text heavy-text text-line-through">
																							<%- precio_producto > 0 ? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%>
																						</span>
																						<br>
																						<span class="gray-light-text heavy-text text-xbg">
																							(-<%- porcentaje_descuento %>%)
																						</span>
																						<span class="gray-dark-text heavy-text text-xbg">
																							<%- window.copCurrencyF.to(parseFloat(descuento)) %>
																							<em class="gray-light-text text-xbg normal-text">iva incl.</em>
																						</span>
																					<% }else if( (typeof oferta !== 'undefined' && oferta > 0) ){  %>
																						<span class="gray-dark-text heavy-text text-xbg">
																							<%- oferta > 0 ? window.copCurrencyF.to(parseFloat(oferta)) : ''%>
																							<em class="gray-light-text text-xbg normal-text">iva incl.</em>
																						</span>
																					<% } %>
																				<% } else {  %>

																						<span class="gray-dark-text heavy-text text-xbg">
																							<%- precio_producto > 0 && !producto_sin_precio ? window.copCurrencyF.to(parseFloat(precio_producto)) : window.copCurrencyF.to(parseFloat(0))%>
																							<em class="gray-light-text text-xbg normal-text">iva incl.</em>
																						</span>
																					<% } %>

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
										<div class="row">
                                            <div class="mobile-12 small-3 small-offset-1 medium-3 columns">
                                                        <a href="{{ route('marketplace.index') }}" title="Volver a catálogo" class="button medium sky-blue expand btn-shadow radius btn-lowerc">Volver a catálogo</a>
                                            </div>
											<div class="mobile-12 small-4 tablet-4 medium-4 columns">
												{!! Form::submit(transtp('marketplace.titleButtonConfirmPurchase'), ['class' => 'button medium sky-blue expand btn-shadow radius btn-lowerc']) !!}
                                            </div>
                                            <div class="mobile-12 small-3 medium-3 columns end">
                                                <a href="{{ route('marketplace.compras.index') }}" title="{!! transtp('marketplace.showPurchases') !!}" class="button medium sky-blue expand btn-shadow radius btn-lowerc">{!! transtp('marketplace.showPurchases') !!}</a>
                                            </div>
                                        </div>
									{!! Form::close() !!}
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</script>

		<script type="text/template" id="marketplace-deliverables-agreement-tpl">
			@switch(App\RegistroSesion::getInstitutionSlug())
				@case('rutan')
					@include('public.marketplace.adjuntosventarutan')
					@break
				@default
					@include('public.marketplace.adjuntosventa')
			@endswitch
		</script>

{{-- template upload documnts rutan --}}
<script type="text/template" id="edit-upload-documents-form-tpl">
	{!! Form::open(array('data-abide' => '', 'id' => 'form-edit-upload-documents')) !!}
	<% if(state_agreement != 21 && state_agreement != 6 && state_agreement != 7 && state_agreement != 29 && state_agreement != 30) { %>
		<div class="row">
			<div class="small-12 tablet-12 columns">
				<div class="reg-content-box">
					<div class="row">
						<div class="tablet-6 columns input-field">
							<input
								type="text"
								name="nombre_entregable"
								pattern="[a-zA-Z]+"
								class="validate"
								required>
							<label for="nombre_entregable">Nombre entregable (*)</label>
							<small class="error">¡El nombre es obligatorio!</small>
						</div>
						<div class="tablet-6 columns input-field">
							<div class="mobile-4 tablet-4 columns">
								<select name="year" id="year" data-placeholder="{{ Lang::choice('app.year', 1) }}" placeholder="{{ Lang::choice('app.year', 1) }}" required>
									<option value="" disabled selected>{{ Lang::choice('app.year', 1) }}</option>
									@foreach( TuProyecto::getPastYears() as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<div class="mobile-4 tablet-4 columns">
								<select name="month" id="month" data-placeholder="{{ Lang::choice('app.month', 1) }}" placeholder="{{ Lang::choice('app.month', 1) }}" required>
									<option value="" disabled selected>{{ Lang::choice('app.month', 1) }}</option>
									@foreach( TuProyecto::getMonths() as $key => $value)
										<option value="{{ $key }}">{{ $value }}</option>
									@endforeach
								</select>
							</div>
							<div class="mobile-4 tablet-4 end columns">
								<select name="day" id="day" data-placeholder="{{ Lang::choice('app.day', 1) }}" placeholder="{{ Lang::choice('app.day', 1) }}" required>
									<option value="" disabled selected>{{ Lang::choice('app.day', 1) }}</option>
									@for($i = 1; $i <= 31; $i++)
										<option value="{{ $i  }}">{{ $i }}</option>
									@endfor
								</select>
							</div>
							<label class="active">Fecha ejecución del entregable (*)</label>
						</div>
					</div>
					<div class="row">
						<div class="tablet-12 columns input-field">
							<input
								type="text"
								name="observacion"
								>
							<label for="observacion">Observación</label>
						</div>
					</div>

					<small class="alert-text">(*) campos obligatorios</small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="small-12 tablet-12 columns">
				<div id="fnuploader-attach-file" class="uploader-attachments"></div>
			</div>
		</div>
		<div class="row" style="justify-content: center;margin-top: 5px;">
			<div class="">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
	<% }%>


	{!! Form::close() !!}
</script>

		<script type="text/template" id="deliverable-final-tpl">
			<div class="row">
				<div class="small-12 columns">
					<p class="text-md">En el siguiente checklist, marca las casillas únicamente de las condiciones que se cumplieron en el proceso de tu compra.</p>
					<table id="attachements-deliverables-purchase" class="strip-separate radius align-center">
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</script>

		<script type="text/template" id="marketplace-purchase-evaluation-tpl">
			@switch(App\RegistroSesion::getInstitutionSlug())
				@case('rutan')
					@include('public.marketplace.marketplace-purchase-evaluation-rutan')
					@break
				@default
					@include('public.marketplace.marketplace-purchase-evaluation')
			@endswitch
		</script>

		<script type="text/template" id="marketplace-purchase-general-evaluation-tpl">
			<div class="row">
				<div class="small-12 columns">

						{{-- Render survey --}}
						<section id="survey-content" class="survey-content">
							{{-- Render survey --}}
						</section>


				</div>
			</div>
		</script>

		{{-- form sale agreement --}}
		<script type="text/template" id="marketplace-sale-agreement-tpl">
			@switch(App\RegistroSesion::getInstitutionSlug())
				@case('rutan')
					@include('public.marketplace.contentmarketplacesaleagreementrutan')
					@break
				@default
					@include('public.marketplace.contentmarketplacesaleagreement')
			@endswitch
        </script>

        {{-- Render tempalte item agreement sale activity --}}
			<script type="text/template" id="item-agreement-sale-activity-tpl">
                <td><%- desc_actividad_acuerdo %></td>
                <td>
                    <% if(resp_comprador_actividad == true) { %>
                        <i class="mdi mdi-briefcase mdi-24 gray-light vcenter"></i> Empresario
                         
                    <% }else if(resp_proveedor_actividad == true) { %>
                        <i class="mdi mdi-truck mdi-24 gray-light vcenter"></i> Proveedor
                    <% } %>
                </td>
            <% if((tab.toLowerCase() == 'ventas') && (typeof(codigo_actividad_servicio) !== 'undefined') && (parseInt(codigo_actividad_servicio) > 0) ) { %>
                <td><input type="text" name="fecha_inicial_actividad_acuerdo" id="fecha_inicial_actividad_producto-<%-codigo_actividad_servicio%>" data-id="<%-codigo_actividad_servicio%>" value="" required pattern="date" class="datepk fecha_inicial_actividad_producto" data-abide-ignore></td>
                <td><input type="text" name="fecha_final_actividad_acuerdo" id="fecha_final_actividad_producto-<%-codigo_actividad_servicio%>" value="" data-id="<%-codigo_actividad_servicio%>" required pattern="date" class="datepk fecha_final_actividad_producto" data-abide-ignore></td>
            <% }else if((tab.toLowerCase() == 'ventas') && (typeof(codigo_actividad_acuerdo) !== 'undefined') && (parseInt(codigo_actividad_acuerdo) > 0) ) { %>
                <td><input type="text" name="fecha_inicial_actividad_acuerdo" id="fecha_inicial_actividad_acuerdo-<%-codigo_actividad_acuerdo%>" value="<%- fecha_inicial_actividad_acuerdo%>" data-id="<%-codigo_actividad_acuerdo%>"  required pattern="date" class="datepkactivityagree fecha_inicial_actividad_acuerdo" data-abide-ignore></td>
                <td><input type="text" name="fecha_final_actividad_acuerdo" id="fecha_final_actividad_acuerdo-<%-codigo_actividad_acuerdo%>" value="<%- fecha_inicial_actividad_acuerdo%>" data-id="<%-codigo_actividad_acuerdo%>" required pattern="date" class="datepkactivityagree fecha_final_actividad_acuerdo" data-abide-ignore></td>
            <% } else { %>
                <td><%- window.moment(fecha_inicial_actividad_acuerdo, 'YYYY-MM-DD').format('DD/MM/YYYY') %></td>
                <td><%- window.moment(fecha_final_actividad_acuerdo, 'YYYY-MM-DD').format('DD/MM/YYYY') %></td>
            <% } %>
                <td><%- sesiones_presencial %></td>
                <td><%- sesiones_presencial_horas %></td>
                <td><%- sesiones_virtual %></td>
                <td><%- sesiones_virtual_horas %></td>

                <% if( (tab.toLowerCase() == 'ventas') && (typeof(actividad_acuerdo_fija) !== 'undefined') && !actividad_acuerdo_fija ){%>
                    <td class="text-right">
                        <a href="#" title="Quitar elemento" class="remove-item-agreement close-hover-circle"><i class="mdi mdi-window-close"></i></a>
                    </td>
                <% } else{%>
                    <td></td>
                <% }%>
		</script>
		<script type="text/template" id="item-agreement-sale-adviser-tpl">
			<td><%- nombre_usuario_acuerdo %></td>
			<td><%- cargo_usuario_acuerdo %></td>
			<td><%- correo_usuario_acuerdo %></td>
			<% if(tab.toLowerCase() == 'ventas') { %>
				<% if (typeof codigo_usuario_entidad != 'undefined'){ %>
				<td class="text-right">
					<a href="#" title="Quitar elemento" class="remove-item-agreement close-hover-circle"><i class="mdi mdi-window-close"></i></a>
				</td>
				<% } %>
			<% } %>
		</script>
		<script type="text/template" id="item-agreement-sale-deliverable-tpl">
			@switch(App\RegistroSesion::getInstitutionSlug())
				@case('rutan')
					@include('public.marketplace.rutan.item-agreement-sale-deliverable')
					@break
				@default
					@include('public.marketplace.item-agreement-sale-deliverable')
			@endswitch
		</script>
		<script type="text/template" id="item-agreement-sale-workteam-tpl">
			<td><%- nombre_usuario_empresario %></td>
			<td><%- cargo_usuario_empresario %></td>
			<td><%- correo_usuario_empresario %></td>
			<% if(tab.toLowerCase() == 'ventas') { %>
				<td class="text-right">
					<a href="#" title="Quitar elemento" class="remove-item-agreement close-hover-circle"><i class="mdi mdi-window-close"></i></a>
				</td>
			<% } %>
		</script>
	@endif
	@include('public.surveytemplates')
@stop


