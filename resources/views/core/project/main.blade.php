@extends('core.project.project')

@section('project.content')
	{{-- ------------------ Project Templates JS -------------------- --}}
	<script type="text/template" id="form-create-project-tpl">
		<div class="row">
			<div class="small-12 columns">
				<div id="content-create-entity-form" class="panel-info with-title radius">
					<h5 class="title-panel text-left">{{ transtp('entities.create') }}</h5>
					@include('core.project.form.create')
				</div>
			</div>
		</div>
	</script>

	{{-- Section Projects --}}
	<script type="text/template" id="project-content-tpl">
        <!-- module navigation -->
        <div id="project-menu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
            <div class="row">
                <div class="small-12 columns">
                    <ul id="project-tabs-navs" class="tabs-sub-nav-alt tabs tabs-route" data-tab data-tab-init="is_hover:false">
						<% if( type == 'detail'){ %>
						<li class="tab-title">
							<a id="onBack" class="linkto-inst-color"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter"></i> volver</a>
						</li>
						<% } %>
						<div class="right">
							<li class="tab-title <%- type == 'principal' ? 'active' : '' %>">
								<a href="<%- Route.route('proyecto.index') %>" title="{{ transtp('entities.main') }}" class="linkto-inst-color">{{ transtp('entities.main') }}</a>
							</li>
							<li class="tab-title <%- type == 'micontenido' ? 'active' : '' %>">
								<a class="linkto-inst-color" href="<%- Route.route('proyecto.tipo', {'type': 'micontenido'}) %>" title="{{ transtp('entities.mycontent') }}">{{ transtp('entities.mycontent') }}</a>
							</li>

							@if( Auth::check())
								<li class="tab-title has-dropdown tab-more" data-options role="navigation">
									<a href="" data-dropdown="drop-desk-nav" data-options="is_hover:true"  class="mdi mdi-chevron-down vcenter link-option-submenu tab-icon-right">Más</a>
									<ul id="drop-desk-nav" data-dropdown-content class="tabs-dropdown dropdown no-bullet inst-bgcolor-secondary f-dropdown">
										<li>
											<a href="{{ route('proyecto.create') }}" class="mdi mdi-plus drop-icon-left">{{ transtp('entities.createentity') }}</a>
										</li>
									</ul>
								</li>
							@endif
						</div>
                    </ul>
                </div>
            </div>
        </div>

        <!-- module responsive navigation -->
        <div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
						<% if( type == 'detail'){ %>

							<button type="button" id="onBack"  class="left"><i class="mdi mdi-chevron-left mdi-18 gutter-left vcenter"></i> volver</button>

						<% } %>
                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">{{ transtp('entities.main') }}<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
                        <ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">

                            <li class="<%- type == 'principal' ? 'active' : '' %>">
                                <a href="<%- Route.route('proyecto.index') %>" title="{{ transtp('entities.main') }}">{{ transtp('entities.main') }}</a>
                            </li>

                            <li class="<%- type == 'micontenido' ? 'active' : '' %>">
                                <a href="<%- Route.route('proyecto.tipo', {'type': 'micontenido'}) %>" title="{{ transtp('entities.mycontent') }}">{{ transtp('entities.mycontent') }}</a>
                            </li>

                            @if( Auth::check() )
                                <li>
                                    <a href="{{ route('proyecto.create') }}"><i class="mdi mdi-plus mdi-18 gutter-right vcenter"></i>{{ transtp('entities.createentity') }}</a>
                                </li>
                            @endif
                        </ul>
                    </dl>
                </div>
            </div>
        </div>
		<div id="project-content-main">

			<% if(type == 'principal' || type == 'micontenido'){ %>
				<div id="project-inner-content" class="section-inner-content">
					<div class="row mobile-collapse tablet-uncollapse">
						<div class="small-12 columns">
							<div class="fx-main-content">
								<div class="fx-col-left">
									<div id="wrapper-filter-bar" class="sticky-filter-top">
										<div id="side-menu-filter" class="filter-side-nav-left">
											{{-- Render side menu filter id="project-sidemenu-filter-tpl"--}}
										</div>
									</div>
								</div>
								<div class="fx-col-content">
									<div class="row">
										<div class="small-12 columns">
											<ul class="settings-section-browse show-for-tablet-up">
												<li class="has-image no-wrap">
													<ul class="views-filter-nav inline-list-grid no-spacing">
														<li class="<%- dataFilter.v == 'list' ? 'active' : '' %>">
															<a href="<%- Route.route( 'proyecto.index', jQuery.extend({}, dataFilter, {'v': 'list'}) ) %>" title="Ver en lista" class="">
																<i class="mdi mdi-format-list-bulleted"></i>
															</a>
														</li>
														<li class="<%- dataFilter.v == 'grid' ? 'active' : '' %>">
															<a href="<%- Route.route( 'proyecto.index', jQuery.extend({}, dataFilter, {'v': 'grid'}) ) %>" title="Ver en grilla" class="">
																<i class="mdi mdi-view-grid"></i>
															</a>
														</li>
													</ul>
												</li>
												<li>
													<div class="wrap-result-count">{{-- Render browse result count template --}}</div>
												</li>
											</ul>
											<% if(dataFilter.v !== undefined) { %>
												<div id="content-project-list" class="content-browse-projects content-data-list">
													@include('public.noresults')
													<ul class="mobile-block-grid-1 small-block-grid-<%- dataFilter.v =='grid' ? '2' : 1 %> tablet-block-grid-<%- dataFilter.v =='grid' ? '3' : 1 %> medium-block-grid-<%- dataFilter.v =='grid' ? '3' : 1 %> xxlarge-block-grid-<%- dataFilter.v =='grid' ? '4' : 1 %> browse-list-mask browse-list-projects responsive-browse">
														<!-- Render programs list -->
													</ul>
												</div>
											<% } %>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<% }else{ %>
				<div id="project-detail">
					{{-- Render template id="project-detail-tpl" --}}
				</div>
			<% } %>
		</div>
	</script>

	{{-- projects filters menu  --}}
	<script type="text/template" id="project-sidemenu-filter-tpl">
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
				{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-project'))  !!}
					<ul class="side-nav-slide">
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="text" name="name" id="nombre_producto" value="<%- name %>" class="keyup-search">
									<label for="nombre_producto">{{ transtp('entities.filters.project') }}</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<input type="number" name="identification" id="identification" value="<%- identification %>" class="keyup-search">
									<label for="identification">Documento de identificación</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="department" id="department" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-department="true" data-initial-value="<%- typeof(department) !== 'undefined' ? department : '' %>" data-placeholder="Seleccione un departamento" placeholder="Seleccione un departamento">
									</select>
									<label>Departamento:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="city" id="city" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-val="#department" data-initial-value="<%- typeof(city) !== 'undefined' ? city : '' %>" data-placeholder="Seleccione una ciudad" placeholder="Seleccione una ciudad">
									</select>
									<label>Ciudad:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select name="program" id="program" class="change-choice" required data-placeholder="Selecciona una convocatoria" placeholder="Selecciona una convocatoria">
										<option value="" selected disabled>Selecciona una convocatoria</option>
										<option value="">Todas</option>
										@foreach( App\Convocatoria::getProgramList() as $value)
											<option value="{{ $value->key }}" <%- typeof(program) !== 'undefined' && program == '{{ $value->key }}' ? 'selected': ''%>>{{ $value->value}}</option>
										@endforeach
									</select>
									<label>Convocatoria:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select id="stage" name="stage" class="change-choice" required data-placeholder="{{ transtp('entities.project.placeholder.stage') }}" placeholder="{{ transtp('entities.project.placeholder.stage') }}">
										<option value="">Todos</option>
										@foreach( App\EtapaProyecto::getStages() as $value)
											<option value="{{ $value->codigo_etapa_proyecto }}" <%- typeof(stage) !== 'undefined' && stage == '{{ $value->codigo_etapa_proyecto }}' ? 'selected': ''%>>{{ $value->nombre_etapa_proyecto }}</option>
										@endforeach
									</select>
									<label>{{ transtp('entities.project.stage') }}:</label>
								</div>
							</div>
						</li>
						<li>
							<div class="row">
								<div class="small-12 columns input-field">
									<select id="category" name="category" class="change-choice" data-placeholder="{{ transtp('entities.project.placeholder.industry') }}" placeholder="{{ transtp('entities.project.placeholder.industry') }}" required>
										<option value="">Todos</option>
										@foreach( App\CategoriaProyecto::getCategoriesList() as $value )
											<option value="{{ $value->key }}" <%- category == '{{ $value->key }}' ? 'selected' : ''%> >{{ $value->value }}</option>
										@endforeach
									</select>
									<label>{{ transtp('entities.project.industry') }}:</label>
								</div>
							</div>
						</li>
						<li class="divider"></li>
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

	{{-- item Project list --}}
	<script type="text/template" id="project-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="top-item-list no-border">
				<a href="<%= Route.route('proyecto.proyecto', {'proyecto': nickname_usuario}) %>" title="<%- nombre_usuario %>" title="<%- nombre_usuario %>" class="image-last-article">
					<img src="<%= imagen_usuario %>" alt="<%= nombre_usuario %>" onclick="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
				</a>
			</div>
			<div class="content-item-list text-left">
				<h5 class="title-item-list is-hovered ellipsis black-text">
					<a href="<%= Route.route('proyecto.proyecto', {'proyecto': nickname_usuario}) %>" title="<%- nombre_usuario %>"><%- nombre_usuario %></a>
				</h5>
				<p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- biografia_usuario %></p>
				<p class="text-xsm category-list-item ellipsis is-truncated upper-text"><%- nombre_categoria_proyecto %></p>
				<div class="bottom-item-list">
					<ul class="inline-list-grid align-center">
						<% if(!_.isNull(nombre_ciudad)){ %>
						<li class="text-left project-location">
							<ul class="inline-list-grid align-center gray-base-text no-spacing overflowed-text">
								<li class="has-image"><i class="mdi mdi-map-marker mdi-16 vcenter"></i></li>
								<li class="no-wrap">
									<span class="text-xsm"><%- nombre_ciudad+ ' · ' +distrito_ciudad %></span>
								</li>
							</ul>
						</li>
						<% } %>
						<li class="text-right no-wrap short-col">
							<ul id="drop-liked-project-<%- codigo_entidad %>" class="post-social-shared program-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
								<li>
									<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
								</li>
							</ul>
							<ul class="social-box-icons">
								@if(App\RegistroSesion::getVotation())
									<li class="no-wrap">
										<i class="mdi mdi-vote  vcenter mdi-16"></i>
										<span class="text-xsm"> <%- contador_votos %> </span>
										</a>
									</li>
								@else
									<li class="no-wrap">
										<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-project-<%- codigo_entidad %>" aria-controls="drop-liked-project-<%- codigo_entidad %>" data-options="align:top;is_hover:true;hover_timeout:500">
										<i class="mdi mdi-thumb-up-outline mdi-16 vcenter"></i>
										<span class="data-count-likes text-xsm"><%- contador_like %></span>
										</a>
									</li>
								@endif
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</script>

	{{-- view project roster on list --}}
	<script type="text/template" id="project-roster-list-tpl">
		<div class="item-wrap-list radius">
			<div class="row collapse col-equal-height">
				<div class="mobile-4 tablet-4 columns">
					<div class="top-item-list no-border">
						<a href="<%- Route.route('proyecto.proyecto', {'proyecto': nickname_usuario}) %>" title="<%- nombre_usuario %>" class="item-thumb">
							<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" onerror="imageDefault(this,'{{ config('tuproyecto.no_project_image') }}')" />
						</a>
					</div>
				</div>
				<div class="mobile-8 tablet-8 columns">
					<div class="content-item-list content-roster-list">
						<h6 class="title-item-list clean-top black-text bold-header is-hovered">
							<a href="<%= Route.route('proyecto.proyecto', {'proyecto': nickname_usuario}) %>" title="<%- nombre_usuario %>" class="dark-text is-hovered"><%- nombre_usuario %></a>
						</h6>
						<p class="description-list-item text-sm gray-dark-text clean-bottom ellipsis is-truncated show-for-tablet-up"><%- biografia_usuario %></p>
						<p class="category-list-item ellipsis is-truncated upper-text"><%- nombre_categoria_proyecto %></p>
						<div class="bottom-item-list content-bottom-item-roster">
							<ul class="inline-list-grid align-center">
								<% if(!_.isNull(nombre_ciudad)){ %>
								<li class="text-left project-location">
									<ul class="inline-list-grid align-center gray-base-text no-spacing overflowed-text">
										<li class="has-image"><i class="mdi mdi-map-marker mdi-16 vcenter"></i></li>
										<li class="no-wrap">
											<span class="text-xsm"><%- nombre_ciudad+ ' · ' +distrito_ciudad %></span>
										</li>
									</ul>
								</li>
								<% } %>
								<li class="text-right no-wrap short-col">
									<ul id="drop-liked-project-<%- codigo_entidad %>" class="post-social-shared program-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
										<li>
											<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
										</li>
									</ul>
									<ul class="social-box-icons">
										<li class="no-wrap">
											<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-project-<%- codigo_entidad %>" aria-controls="drop-liked-project-<%- codigo_entidad %>" data-options="align:top;is_hover:true;hover_timeout:500">
											<i class="mdi mdi-thumb-up-outline mdi-16 vcenter"></i>
											<span class="data-count-likes text-xsm"><%- contador_like %></span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section Detail Project --}}
	<script type="text/template" id="project-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown radius content medium" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-lg" data-dropdown-content class="md-dropdown radius content large" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
		<% } %>

		<div id="wrapper-detail-project">
			{{-- header project --}}
			<div id="project-header-content">
				<div class="row col-equal-height">
					<div class="medium-6 columns">
						<div class="card card-project-detail <%- owner ? 'editable' : '' %>">
							<div id="project-main-image" class="card-image wrapper-image-edit image-area-drop card-image">
								{{-- Render image template--}}
							</div>

							<div class="card-content project-info-detail">
								<ul id="project-gallery" class="mobile-block-grid-3 tablet-block-grid-6 slick-gallery">
									{{-- Render gallery --}}
								</ul>
								<% if(owner){ %>
									<div id="opt-edit-gallery-project" class="editable-item">
										<input type="checkbox" name="edit-gallery-project" id="edit-gallery-project" value="0" class="edit-gallery-images" checked>
										<label for="edit-gallery-project">Galería editable</label>
									</div>
								<% } %>

								<div id="project-name-container" class="editable-item">
									{{-- Render info basic --}}
								</div>
							</div>

							<div class="card-action project-action-detail">
								<ul class="inline-list-grid align-center">
									<li>
										<div id="project-location-container" class="editable-item">
											{{-- Render info location --}}
										</div>
									</li>
									<li>
										<ul class="text-right project-icons-shared social-box-icons">
											<li>
												<ul id="drop-shared-social-project" class="drop-shared-social-project opts-action-dropdown drop-shared-social no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
													<li class="text-center">
														<label class="label single gray-base-text">Compartir en redes:</label>
														<ul class="inline-list-grid align-top">
															<li class="text-center">
																<a href="http://www.facebook.com/share.php?u=<%- window.Misc.urlFull( Route.route( 'proyecto.proyecto', {proyecto: url_nickname}) ) %>&title=<%- nombre_usuario %>" title="Compartir en facebook" class="tp_facebook_share">
																	<i class="mdi mdi-facebook mdi-21 facebook"></i>
																</a>
															</li>
															<li class="text-center">
																<a href="http://www.linkedin.com/shareArticle?mini=true&url=<%= window.Misc.urlFull( Route.route( 'proyecto.proyecto', {proyecto: url_nickname}) ) %>&title=<%- nombre_usuario %>&source=DOMAIN" title="Compartir en linkedin" class="tp_linkedin_share">
																	<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
																</a>
															</li>
															<li class="text-center">
																<a href="http://twitter.com/intent/tweet?status=<%- nombre_usuario %>+<%- window.Misc.urlFull( Route.route( 'proyecto.proyecto', {proyecto: url_nickname}) ) %>" title="Compartir en X" class="">
																	<i class="mdi mdi-close-outline mdi-21 twitter"></i>
																</a>
															</li>
														</ul>
													</li>
												</ul>
												<a title="Compartir" data-dropdown="drop-shared-social-project" aria-controls="drop-shared-social-project" data-options="align:bottom;is_hover:false;hover_timeout:500">
													<i class="mdi mdi-share-variant mdi-21"></i>
												</a>
											</li>
											<li>
												<ul id="drop-liked-project" class="post-social-shared project-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
													<li>
														<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
													</li>
												</ul>
												<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-project" aria-controls="drop-liked-project" data-options="align:top;is_hover:true;hover_timeout:500">
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

					<div class="medium-6 columns">
						<div class="card card-project-detail-info <%- owner ? 'editable' : '' %>">
							<div class="card-content project-info-detail">
								<ul class="project-list-info">
									<li>
										<h6 class="dark-text bold-header">Descripción breve</h6>
										<div id="project-summary-container" class="editable-item">
											{{-- Render info summary --}}
										</div>
									</li>
									<li>
										<h6 class="dark-text bold-header">Correo de contacto</h6>
										<div id="project-mail-contact" class="editable-item">
											{{-- Render mail contact --}}
										</div>
									</li>
									<% if( !_.isEmpty(cargo_entidad) &&  !_.isNull(cargo_entidad) ) { %>
										<li>
											<h6 class="dark-text bold-header">{{ transtp('entities.project.appointment') }}</h6>
											<div id="project-appointment-container">
												<span class="project-top-info-item text-md field-text"><%- cargo_entidad %></span>
											</div>
										</li>
									<% } %>
									<li>
										<h6 class="dark-text bold-header">{{ transtp('entities.project.industry') }}</h6>
										<div id="project-industry-container" class="editable-item">
											{{-- Render project industry --}}
										</div>
										<br />
									</li>
									<li>
										<h6 class="dark-text bold-header">{{ transtp('entities.project.stage') }}</h6>
										<div id="project-stage-container">
											{{-- Render project stages --}}
										</div>
										<br />
									</li>
									<li>
										<h6 class="dark-text bold-header">Página web</h6>
										<div id="project-pageweb-container" class="editable-item">
											{{-- Render project stages --}}
										</div>
										<br />
									</li>
									<li>
										<h6 class="dark-text bold-header">{{ transtp('entities.company.cellphone') }}</h6>
										<div id="project-numerowhatsapp-container" class="editable-item">
											{{-- Render project stages --}}
										</div>
										<br />
									</li>
									<% if( _.isEmpty(haveProducts) &&  haveProducts ) { %>
										<li>
											<a
												target="_blank"
												href="<%- window.Misc.urlFull( 'marketplace?provider='+provider ) %>"
												class="icon-data-basic">
												<i class="mdi mdi-cart  vcenter mdi-21 gutter-right gray-base-text"></i>
												<spam class="dark-text bold-header">Visita mi tienda virtual</spam>
											</a>
											<br />
											<br />
										</li>
									<% } %>
									<li>
										<h6 class="dark-text bold-header">{{ transtp('entities.project.creator') }}</h6>
										<div class="content-creator-info content-data-list">
											<ul class="project-creator-list small-block-grid-1 browse-list-users">
												<li>
													<div class="item-wrap-list radius">
														<ul class="inline-list-grid align-center">
															<li class="has-image">
																<a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_founder}) ) %>" class="item-thumb" title="<%- window.Misc.strToNickname(nickname_founder) %>">
																	<img src="<%- imagen_founder ? imagen_founder : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_founder) %>" class="rounded-img size45" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
																</a>
															</li>
															<li>
																<ul class="no-bullet">
																	<li>
																		<h6 class="carduser-namename-user bold-header dark-text clean-header is-hovered"><a href="<%- window.Misc.urlFull( Route.route('usuario.nickname', {'nickname': nickname_founder}) ) %>" title="<%-nombre_founder %>" class="is-hovered"><%- nombre_founder %></a></h6>
																	</li>
																	<% if( !_.isUndefined(ciudad_founder) &&  !_.isNull(ciudad_founder)) { %>
																		<li><span class="gray-dark-text text-sm linear-span"><%- ciudad_founder %>, <%- distrito_ciudad_founder %></span></li>
																	<% } %>
																</ul>
															</li>
															<li>
																<ul id="buttons-connect-friendship" class="stages-friendship-user right">
																	{{-- Render buttoms follows --}}
																</ul>
															</li>
														</ul>
													</div>
												</li>
											</ul>
										</div>
									</li>

									<li>
									<% if( !_.isUndefined(correo_electronico_usuario) &&  !_.isNull(correo_electronico_usuario)) { %>
										<div class="item-basic-profile text-sm">
											<span class="icon-data-basic"><i class="mdi mdi-email  vcenter mdi-21 gutter-right gray-base-text"></i> </span>
											<em><%- correo_electronico_usuario %></em>
										</div>
									<% } %>
									</li>
									<li>
									<% if( !_.isUndefined(telefono_usuario) &&  !_.isNull(telefono_usuario)) { %>
										<div class="item-basic-profile text-sm">
											<span class="icon-data-basic"><i class="mdi mdi-phone  vcenter mdi-21 gutter-right gray-base-text"></i> </span>
											<em><%- telefono_usuario %></em>
										</div>
									<% } %>
									</li>
									@if (App\RegistroSesion::getVotation())
										<li>
											<span class="item-basic-profile text-sm">
												<i class="mdi mdi-vote  vcenter mdi-21 gutter-right  gray-base-text"></i>
												<em><%- contador_votos %></em>
											</span>
											@if (Carbon\Carbon::now()->format('Y-m-d') <= App\RegistroSesion::getCierreVotation())
												<div class="text-left">
													<button class="left button tiny sky-blue radius btn-shadow btn-lowerc user-vote" data-entity="<%- id_entidad %>" type="button">Votar </button>
												</div>
											@endif
										</li>
									@endif
									<li class="no-wrap">
										<div id="project-socials-container" class="text-right" >
											{{-- Render Socials Group --}}
										</div>
									</li>
									<li>
										<div id="project-tag-container" class="editable-item">
											{{-- Render info tags --}}
										</div>
									</li>
								</ul>
							</div>

							<div class="card-action project-action-detail">

									<!-- Card settings is only seen by the owner or creator -->
									<% if(owner || creator) { %>

											<span class="icon-circle-active card-title activator" title="Ajustes">
												<i class="mdi mdi-settings"></i>
											</span>

									<% } %>

										<div class="container-selection-text">
											<i class="activator-selection mdi mdi-link mdi-24 gray-dark-text vcenter tip-top radius" data-tooltip aria-haspopup="true" title="Haz click para copiar vínculo del proyecto"></i>
											<h5 class="selection-text text-sm gray-base-text">
												<%- window.Misc.urlFull( Route.route('proyecto.proyecto', {'proyecto': nickname_usuario}) ) %>
											</h5>
										</div>


							</div>

							<!-- Card settings is only seen by the owner or creator -->
							<% if(owner || creator) { %>
								<div class="card-reveal">
									<span class="card-title"><i class="mdi mdi-window-close right"></i></span>
									<ul class="project-list-info">
										<li>
											<label class="label single bold-text dark-text">Ajustes</label>
											<div id="project-share-container" class="project-top-info-item <%- owner ? 'editable' : '' %>">
												<ul class="project-share-items no-bullet">
													<li class="clearfix">
														<ul id="buttons-project-privacy-action" class="left no-bullet states-product-privacy">
															{{-- Render buttoms follows --}}
														</ul>
													</li>
							 						<li>
														<a href="#" title="{{ transtp('entities.remove') }}" class="text-sm gray-dark-text normal-text on-remove-project">
							 								<i class="mdi mdi-delete-forever mdi-21 gray-base-text vcenter"></i>{{ transtp('entities.remove') }}
														</a>
													</li>
												</ul>
											</div>
										</li>
									</ul>
								</div>
							<% } %>
						</div>
					</div>
				</div>
			</div>

			{{-- submenu tabs project--}}
			<div id="project-submenu-nav" class="wrapper-submenu-section">
				<div class="row">
					<div class="small-12 columns">
						<div id="project-submenu-tabs" class="clearfix">
							<ul id="project-tabs-filter" class="tabs-sub-nav tabs-route" data-tab>
								<li class="tab-title <%- tab=='basico' ? 'active' : '' %>">
									<a href="#project-basic" title="Información general" class="get-basic-project" aria-controls="project-basic">Información general</a>
								</li>
								<% if(owner || creator || permissions.see_programs_apply) { %>
									<li class="tab-title <%- tab=='convocatorias' ? 'active' : '' %>">
										<a href="#project-programs" title="{{ transtp('programs.title') }}" class="get-programs-project" aria-controls="project-programs">{{ transtp('programs.title') }}</a>
									</li>
								<% } %>

								<li class="tab-title <%- tab=='integrantes' ? 'active' : '' %>">
									<a href="#project-members" title="Integrantes" class="get-members-project" aria-controls="project-members">Integrantes</a>
								</li>
								<!--<li class="tab-title <%- tab=='productos' ? 'active' : '' %>">
									<a href="#project-product" title="Productos" class="get-product-project" aria-controls="project-product">Productos</a>
								</li>-->
								<li class="tab-title <%- tab=='discusiones' ? 'active' : '' %> ">
									<a href="#project-discussion" title="{{ transtp('entities.project.conversations') }}" class="get-discussion-project">{{ transtp('entities.project.conversations') }}</a>
								</li>
								<li class="tab-title <%- tab=='documentos' ? 'active' : '' %>">
									<a href="#project-document" title="{{ transtp('entities.project.documents.title') }}" class="get-documents-project">{{ transtp('entities.project.documents.title') }}</a>
								</li>
								<% if( (owner || creator || permissions.see_bussines_model) && modelo_negocio_institucion) { %>
									<li class="tab-title  <%- tab=='modelodenegocio' ? 'active' : '' %>">
										<a href="#project-business-model" title="Modelo de negocio" class="get-business-model-project">Modelo de negocio</a>
									</li>
								<% } %>
								{{--<li class="tab-title  <%- tab=='encuestas' ? 'active' : '' %>">
									<a href="#project-survey" title="Encuestas" class="get-surveys-project">{{ transtp('surveys') }}</a>
								</li>--}}
							</ul>
						</div>
					</div>
				</div>
			</div>

			{{-- content project detail --}}
			<div id="project-detail-content">
				<div class="row">
					<div class="tablet-12 columns">
						<div class="tabs-content">
							{{-- Content project basic --}}
							<div class="content <%- tab=='basico' ? 'active' : '' %>" id="project-basic">
								<div class="row">
									<div class="tablet-3 columns">
										<aside class="data-aside-left">
											<div class="<%- owner ? 'editable' : '' %>">
												<div id="project-video-container" class="editable-item clearfix ">
													{{-- Render info video --}}
												</div>
											</div>
										</aside>
									</div>
									<div class="tablet-9 columns">

										<div class="panel-info radius <%- owner ? 'editable' : '' %>">
											<div id="project-description-container" class="editable-item">
												<h5 class="title-panel-single dark-text text-left clearfix">
													<span class="field-text">{{ transtp('entities.project.description') }}</span>
													<button class="edit-field-button edit-field" data-edit-template="description"><i class="mdi mdi-pencil"></i></button>
												</h5>
												<div class="wrapper-description-project project-bottom-info-item">
													{{-- Render info description--}}
												</div>
												<% if( !_.isUndefined(descripcion_adicional_usuario) &&  !_.isNull(descripcion_adicional_usuario)) { %>
													<div><%= descripcion_adicional_usuario %></div>
												<% } %>
											</div>


											<div id="project-interests-container" class="editable-item">
												<h5 class="title-panel-single dark-text text-left clearfix">
													<span class="field-text">Sectores de interés</span>
													<button class="edit-field-button edit-field" data-edit-template="interests"><i class="mdi mdi-pencil"></i></button>
												</h5>
												<div class="field-editing content-form-editing">
													{{-- Render template edit form--}}
												</div>
												<div class="content-data-list content-interests-list">
													@include('public.noresults', ['message' => '<span class="edit-no-result text-dmd">Agrega sectores de interés</span>'])
													<ul class="list-info-editing list-interests-project list-separator disc text-md">
														{{-- Render views item of interests --}}
													</ul>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>

							{{-- Content project members --}}
							<div class="content <%- tab=='integrantes' ? 'active' : '' %>" id="project-members">

								<div class="row">
									<div class="small-12 columns">
										<div class="panel-info radius <%- owner ? 'editable' : '' %>">
											<div id="project-members-container" class="editable-item">
												<h5 class="title-panel-single dark-text">
													<span class="field-text">Participantes</span>
													<button class="edit-field-button edit-field" data-edit-template="members"><i class="mdi mdi-pencil"></i></button>
												</h5>
												<div class="field-editing content-form-editing">
													{{-- Render template edit form--}}
												</div>
												<div class="content-members-project-info content-data-list">
													<ul class="list-members-project mobile-block-grid-1 tablet-block-grid-2 browse-list-users">
														{{-- Render views item of members --}}
													</ul>
												</div>
											</div>

											<div id="project-sponsor-container" class="editable-item">
												<h5 class="title-panel-single dark-text">
													<span class="field-text">Aliados</span>
													<button class="edit-field-button edit-field" data-edit-template="sponsors"><i class="mdi mdi-pencil"></i></button>
												</h5>
												<div class="field-editing content-form-editing">
													{{-- Render template edit form--}}
												</div>
												<div class="content-sponsor-list">
													<ul class="list-sponsor-project list-data-editing mobile-block-grid-2 tablet-block-grid-5 medium-block-grid-6">
														{{-- Render views item of sponsor --}}
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>

							{{-- Content project product --}}
							<div class="content <%- tab=='productos' ? 'active' : '' %>" id="project-product">
								<div class="row">
									<div class="small-12 columns">
										<div id="content-product-list" class="content-browse-list content-data-list h-hollow-top">
											@include('public.noresults')
											<ul id='project-product-list' class="tablet-block-grid-3 medium-block-grid-3 browse-list-mask browse-list-products">
												<!-- Render products list -->
											</ul>
										</div>
									</div>
								</div>
							</div>

							{{-- Content project program --}}
							<div class="content <%- tab=='convocatorias' ? 'active' : '' %>" id="project-programs">
								{{-- Render programs section --}}
							</div>

							{{-- Content project discussion --}}
							<div class="content <%- tab=='discusiones' ? 'active' : '' %>" id="project-discussion">
								<div class="row">
									<div class="small-12 columns">
										<div class="panel-content radius" id="wrapper-posts-discussion">
											@if(Auth::check())
												{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-project') ) !!}
													<div class="textarea-post-discussion clearfix">
														<textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" cols="50" rows="2" pattern="max_char_textarea" class="materialize-textarea validate"></textarea>
														<label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
														<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
													</div>
													<input type="hidden" name="codigo_usuario" value="<%= codigo_usuario %>" />
												{!! Form::close() !!}
											@endif
											@include('public.noresults', ['message' => 'No hay discusiones'])
											<section id="discussion-posts-wrap" class="">
												{{-- Render discussions template --}}
											</section>
										</div>
									</div>
								</div>
							</div>

							{{-- Content project documents --}}
							<div class="content <%- tab=='documentos' ? 'active' : '' %>" id="project-document">
								<div class="row">
									<div class="small-12 columns">
										<div class="panel-info with-title <%- owner ? '' : '' %>">
											<div id="project-documents-container" class="editable-item">
												<h5 class="title-panel text-left">
													<i class="mdi mdi-paperclip"></i> <span class="field-text">Documentos</span>
												</h5>
												<section id="wrap-documents" class="">
													{{-- Render  Documents --}}
												</section>
											</div>
										</div>
									</div>
								</div>
							</div>

							{{-- Content project survey --}}
							<div class="content <%- tab=='encuestas' ? 'active' : '' %>" id="project-survey">
								<div class="row">
									<div class="small-12 columns">
										<div id="content-survey-list" class="content-browse-list content-data-list h-hollow-top">
											@include('public.noresults')
											<ul id='project-survey-list' class="tablet-block-grid-3 medium-block-grid-3 browse-list-mask">
												<!-- Render survey list -->
											</ul>
										</div>
									</div>
								</div>
							</div>

							{{-- Content business model --}}
							<div class="content <%- tab=='modelodenegocio' ? 'active' : '' %>" id="project-business-model">
								{{-- Render project busines model --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section business model --}}
	<script type="text/template" id="project-section-business-model-tpl">
		<div class="row">
			<div class="tablet-12 medium-12 columns">
				<div class="tabs-content">
					<div id="content-review-business-model-project" class="content active section">
						{{-- Render review business-model --}}
					</div>
				</div>
			</div>
		</div>
	</script>

	{{-- Section programs --}}
	<script type="text/template" id="project-section-programs-tpl">
		<div class="row">
			<div class="tablet-3 medium-2 columns">
				<ul id="project-program-list" class="section table-of-contents no-bullet vertical" data-tab>
					{{-- Render item program --}}
				</ul>
			</div>
			<div class="tablet-9 medium-10 columns">
				<div class="tabs-content">
					@include('public.noresults', ['message' => 'No tiene convocatorias inscritas para este proyecto'])
					<div id="content-review-program-project" class="content active section scrollspy">
						{{-- Render review program --}}
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="item-program-preview-list-tpl">
		<a href="#content-review-program-project" class="to-open-review">
			<span class="gray-dark-text text-md"><%- nombre_convocatoria %></span>
		</a>
		<ul>
			<li class="gray-dark-text text-sm"><%- nombre_fase %></li>
			<li class="gray-dark-text text-sm"><%- fecha_registro_convocatoria %></li>
		</ul>
	</script>

@stop
