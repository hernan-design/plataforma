
@extends('core.group.group')

@section('group.content')
	{{-- ------------------ Project Templates JS -------------------- --}}
	{{-- Group filter menu  --}}
	<script type="text/template" id="group-sidemenu-filter-tpl">
		<a href="#" class="hide-fx-left-btn on">
			<span class="title-side-nav text-sm">Filtrar Por...</span>
			<i class="side-nav-arrow"></i>
		</a>
		{!! Form::open(array('url' => null, 'method' => 'POST', 'id' => 'form-filters-group'))  !!}
			<ul class="side-nav-slide">
				<li class="divider"></li>
				@if(Auth::check())
					<li>
						<input type="checkbox" name="type" id="type-owner" value="owner" class="check-filter filter-check" <%- type == 'owner' ? 'checked' : '' %> >
						<label for="type-owner">
							Mis grupos
							<i class="right mdi mdi-account-multiple mdi-18"></i>
						</label>
					</li>
				@endif

				<li><span class="title-side-nav text-sm">Filtrar por Categoria</span></li>
				<li>
					<input type="radio" name="category" id="category-all" value="" class="check-filter filter-radio" <%- category == '' ? 'checked' : '' %> >
					<label for="category-all">Todos</label>
				</li>
				@foreach( App\CategoriaProyecto::getCategories() as $key => $value)
					<li>
						<input type="radio" name="category" id="category-{{ $key }}" value="{{ $key }}" class="check-filter filter-radio" <%- category == '{{ $key }}' ? 'checked' : '' %> >
						<label for="category-{{ $key }}">{{ $value }}</label>
					</li>
				@endforeach

				<li><span class="title-side-nav text-sm">Filtrar por tipo</span></li>
				<li>
					<input type="radio" name="grade" id="grade-all" value="" class="check-filter filter-radio" <%- grade == '' ? 'checked' : '' %> >
					<label for="grade-all">Todas</label>
				</li>
				@foreach( App\CategoriaClaseEspacio::getCategoryClassSpace(App\ClaseEmprendimiento::getClass('group')) as $value)
					<li>
						<input type="radio" name="grade" id="grade-{{ $value->codigo_categoria_clase_espacio }}" value="{{ $value->codigo_categoria_clase_espacio }}" class="check-filter filter-radio" <%- grade == '{{ $value->codigo_categoria_clase_espacio }}' ? 'checked' : '' %> >
						<label for="grade-{{ $value->codigo_categoria_clase_espacio }}">{{ $value->nombre_categoria_clase_espacio }}</label>
					</li>
				@endforeach
			</ul>
		{!! Form::close() !!}
	</script>

	{{-- Section Groups list --}}
	<script type="text/template" id="group-list-tpl">
		<div id="group-content-main">
			<div class="row">
				<div class="small-12 columns">
					<ul class="views-sub-nav">
						<li class="<%- dataFilter.v == 'list' ? 'active' : '' %>">
							<a href="<%- Route.route( 'grupo.index', jQuery.extend({}, dataFilter, {'v': 'list'}) ) %>" title="Ver en lista" class="button xtiny radius btn-bold">
								<i class="mdi mdi-view-list"></i>
								Lista
							</a>
						</li>
						<li class="<%- dataFilter.v == 'grid' ? 'active' : '' %>">
							<a href="<%- Route.route( 'grupo.index', jQuery.extend({}, dataFilter, {'v': 'grid'}) ) %>" title="Ver en grilla" class="button xtiny radius btn-bold">
								<i class="mdi mdi-view-grid"></i>
								Grilla
							</a>
						</li>
					</ul>
					<section>
						</br>
						<% if(dataFilter.v !== undefined) { %>
							<div id="content-project-list" class="content-browse-list content-data-list h-hollow-top">
								@include('public.noresults')
								<ul class="tablet-block-grid-<%- dataFilter.v =='grid' ? '3' : 1 %> medium-block-grid-<%- dataFilter.v =='grid' ? '4' : 1 %> browse-list-mask browse-list-groups">
									<!-- Render programs list -->
								</ul>
							</div>
						<% } %>
					</section>
				</div>
			</div>
		</div>
	</script>

	{{-- item Group list --}}
	<script type="text/template" id="group-item-list-tpl">
		<div class="item-wrap-list">
			<div class="top-item-mask no-border">
				<a href="<%= Route.route('grupo.grupo', {'grupo': nickname_usuario}) %>" title="<%- nombre_usuario %>" title="<%- nombre_usuario %>" class="item-thumb">
					<img src="<%= imagen_usuario %>" alt="<%= nombre_usuario %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
				</a>
			</div>
			<div class="content-item-mask text-left">
				<h5 class="title-item-list">
					<a href="<%= Route.route('grupo.grupo', {'grupo': nickname_usuario}) %>" title="<%- nombre_usuario %>">
						<%- nombre_usuario %>
					</a>
				</h5>
			</div>
			<div class="bottom-item-list">
				<ul class="inline-list-grid align-center">
					<li>
						<ul class="social-box-icons">
							<li>
								<a href="#" class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
									<i class="mdi mdi-thumb-up-outline sky-blue mdi-18 icon-btn"></i>
								</a>
								<span class="text-xmd light-text">A <a href="#" class="show-user-likes text-xmd"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</script>

	{{-- view group roster on list --}}
	<script type="text/template" id="group-roster-list-tpl">
		<div class="item-wrap-list">
			<div class="row collapse col-equal-height">
				<div class="mobile-3 columns">
					<div class="top-item-list no-border">
						<a href="<%= Route.route('grupo.grupo', {'grupo': nickname_usuario}) %>" title="<%- nombre_usuario %>" class="item-thumb">
							<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';"/>
						</a>
					</div>
				</div>
				<div class="mobile-9 columns">
					<div class="content-item-list">
						<h5 class="dark-text bold-header is-hovered">
							<a href="<%= Route.route('grupo.grupo', {'grupo': nickname_usuario}) %>" title="<%- nombre_usuario %>" class="dark-text is-hovered"><%- nombre_usuario %></a>
						</h5>
						<p class="description-project-item text-md light-text"><%- window.Misc.maxLen(biografia_usuario, 450) %></p>
						<div class="">
							<ul class="inline-list-grid align-center">
								<li>
									<ul class="social-box-icons">
										<li>
											<a href="#" class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
												<i class="mdi mdi-thumb-up-outline sky-blue mdi-18 icon-btn"></i>
											</a>
										</li>
										<li><span class="text-xmd gray-light-text">&bull;</span></li>
										<li>
											<span class="text-xmd light-text">A <a href="#" class="show-user-likes text-xmd"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }}</a> les gusta esto.</span>
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


	{{-- Section Detail Group --}}
	<script type="text/template" id="group-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing content large" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
			<div id="drop-edit-form-alt" data-dropdown-content class="md-dropdown drop-editing content large" aria-hidden="true">
				{{-- Render profile edit form --}}
			</div>
		<% } %>

		<div id="wrapper-detail-project">
			{{-- header project --}}
			<div id="project-header-content" class="panel-content <%- owner ? 'editable' : '' %>">
				<div class="row">
					<div class="small-12 columns">
						<div class="project-basic-info">
							<div class="row col-equal-height">
								<div class="tablet-4 columns">
									<div id="group-main-image" class="wrapper-image-edit image-area-drop">
										{{-- Render image template--}}
									</div>
								</div>
								<div class="tablet-8 columns">
									<div class="project-info-detail">

										<div class="row">
											<div class="mobile-12 columns">
												<div id="group-name-container" class="editable-item">
													{{-- Render info basic --}}
												</div>

												<div id="group-summary-container" class="editable-item">
													{{-- Render info summary--}}
												</div>

												<div id="group-location-container" class="editable-item">
													{{-- Render info location --}}
												</div>

												<div id="group-tag-container" class="editable-item">
													{{-- Render info tags --}}
												</div>

												<div id="group-like-container">
													<ul class="left social-box-icons project-top-info-item">
														<li>
															<ul id="drop-liked-program" class="post-social-shared program-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
																<li>
																	<span class="lighter-text light-text">A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
																</li>
															</ul>
															<a href="#" class="button xtiny radius btn-shadow btn-resetc data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-program" aria-controls="drop-liked-program" data-options="align:top;is_hover:true;hover_timeout:500">
																<i class="mdi mdi-thumb-up-outline mdi-24 icon-btn"></i>
																<span class="data-count-likes text-md"><%- contador_like %></span>
															</a>
														</li>
													</ul>
												</div>
												<ul class="right no-bullet">
							 						<li >
														<ul id="buttons-group-join-action" class="no-bullet left states-product-browse">
															{{-- Render buttoms --}}
														</ul>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- submenu tabs project--}}
			<div id="marketplace-submenu-nav">
				<div class="row">
					<div class="small-12 columns">
						<div id="project-submenu-tabs" class="clearfix">
							<ul id="project-tabs-filter" class="tabs-sub-nav tabs tabs-route" data-tab>
								<li class="tab-title  <%- tab=='basico' ? 'active' : '' %>">
									<a href="#group-basic" title="Vista general" class="get-basic-group" aria-controls="group-basic">Vista general</a>
								</li>
								<li class="tab-title  <%- tab=='integrantes' ? 'active' : '' %>">
									<a href="#group-members" title="Integrantes" class="get-members-group" aria-controls="group-members">Integrantes</a>
								</li>
								<li class="tab-title  <%- tab=='discusiones' ? 'active' : '' %> ">
									<a href="#group-discussion" title="Conversaciones" class="get-discussion-group">Conversaciones</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			{{-- content project detail --}}
			<div id="project-detail-content">
				<div class="row">
					<div class="small-3 columns">
						<aside class="data-aside-left">
							<div class="<%- owner ? 'editable' : '' %> /*sticky-aside-general*/">
								<div id="group-video-container" class="editable-item clearfix ">
									{{-- Render info video --}}
								</div>
							</div>

							<div class="panel <%- owner ? 'editable' : '' %>">
								<ul class="list-separator no-bullet">
									<li class="clearfix">
										<div id="group-socials-container" class="left text-left" >
											{{-- Render Socials Group --}}
										</div>
									</li>
									<li class="clearfix">
										<% if(owner){ %>
											<ul id="buttons-group-privacy-action" class="no-bullet left states-product-browse">
												{{-- Render buttoms follows --}}
											</ul>
										<% } %>
									</li>
								</ul>
							</div>
						</aside>
					</div>
					<div class="small-9 columns">
						<div class="tabs-content">
							{{-- Content project basic --}}
							<div class="content <%- tab=='basico' ? 'active' : '' %>" id="group-basic">
								<div class="row">
									<div class="small-12 columns">

										<div class="panel-info with-title <%- owner ? 'editable' : '' %>">
											<div id="group-interests-container" class="editable-item">
												<h5 class="title-panel text-left">
													<span class="field-text">Sectores de interés</span>
													<button class="edit-field-button right edit-field" data-edit-template="interests"><i class="mdi mdi-pencil"></i></button>
												</h5>
												<div class="field-editing content-form-editing">
													{{-- Render template edit form--}}
												</div>
												<ul class="list-info-project list-interests-project disc text-md">
													{{-- Render views item of interests --}}
												</ul>
											</div>
										</div>

										<div class="panel-info with-title <%- owner ? 'editable' : '' %>">
											<div id="group-description-container" class="editable-item">
												{{-- Render info description--}}
											</div>
										</div>
									</div>
								</div>
							</div>

							{{-- Content project members --}}
							<div class="content <%- tab=='integrantes' ? 'active' : '' %>" id="group-members">

								<div class="row">
									<div class="small-12 columns">
										<div class="panel-info with-title">
											<div id="project-members-container" class="editable-item">
												<h5 class="title-panel text-left">
													<i class="mdi mdi-lightbulb"></i> <span class="field-text">Miembros</span>
												</h5>
												<ul class="list-members-project tablet-block-grid-2">
													{{-- Render views item of members --}}
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>

							{{-- Content project discussion --}}
							<div class="content <%- tab=='discusiones' ? 'active' : '' %>" id="group-discussion">
								<div class="row">
									<div class="small-12 columns">
										<div class="product-img-main">
											<section id="mentoring-wrapper">
												<section id="mentoring-content" class="mentoring-content">
													<div id="container-sections-mentoring">
														<div class="content active" id="wrapper-posts-discussion">
															@if(Auth::check())
																{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-project') ) !!}
																	<div class="textarea-post-discussion clearfix">
																		<textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" cols="50" rows="2" pattern="max_char_textarea"></textarea>
																		<small class="error">El campo esta vació o tiene muy pocos caracteres</small>
																		<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
																	</div>
																	<input type="hidden" name="codigo_usuario" value="<%= codigo_usuario %>" />
																{!! Form::close() !!}
															@endif
															@include('public.noresults', ['message' => 'No hay discusiones'])
															<section id="discussion-posts-wrap" class="">
																{{-- Render Tasks template --}}
															</section>
														</div>
													</div>
												</<section>
											</section>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</script>

	{{-- Image main Project template --}}
	<script type="text/template" id="main-image-group-tpl">
		<img src="<%- imagen_usuario %>" alt="<%- nombre_usuario %>" title="<%- nombre_usuario %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
		<% if(owner){ %>
			<button id="change-image-group" class="edit-photo change-photo small">
				<div class="edit-photo-content">
					<i class="mdi mdi-camera mdi-24 vcenter"></i>
					<span>Añadir una Imagen</span>
					<span class="editing-photo-message">Cambiar Imagen</span>
				</div>
			</button>
		<% } %>
	</script>

	{{-- Info Basic Project template --}}
	<script type="text/template" id="info-basic-group-tpl">
		<h3 class="title-detail-product-main lighter-text dark-text clean-top edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="name-project">
			<span class="field-text"><%- nombre_usuario %></span>
			<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
		</h3>
	</script>

	{{-- Info summary project template --}}
	<script type="text/template" id="info-summary-group-tpl">
		<div class="content-summary-project field-for-edit edit-field clearfix" data-edit-template="summary">
			<p class="text-summary-project block-text-medium clean-bottom project-top-info-item"><%- biografia_usuario %></p>
			<button class="edit-field-button"><i class="mdi mdi-pencil"></i></button>
		</div>
		<div class="field-editing">
			{{-- Render template edit form--}}
		</div>
	</script>

	{{-- Info Location Project template --}}
	<script type="text/template" id="info-location-group-tpl">
		<div class="edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="location-project">
			<span class="edit-field project-top-info-item text-lg">
				<span id="project-category-edit" class="gray-light-text field-text"><em><%- nombre_categoria_proyecto %></em></span>
				<% if(!_.isUndefined(nombre_ciudad) && !_.isNull(nombre_ciudad)) { %>
					<span class="slah-separator">&frasl;</span>
					<span class="gray-light-text field-text">
						<i class="mdi mdi-map-marker-radius mdi-21 vcenter"></i>
						<%- nombre_ciudad %>, <%- nombre_pais %>
					</span>
				<% } %>
			</span>
			<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
		</div>
	</script>

	{{-- Info Tags Project template--}}
	<script type="text/template" id="info-tag-group-tpl">
		<div class="edit-field" data-edit-template="tags">
			<% if(tags.length) { %>
				<ul class="tags-icon-list field-text project-top-info-item">
					<% _.each(tags.split(','), function (tag) { %>
						<li><span class="tag-item"><%- tag %></span></li>
					<% }) %>
				</ul>
			<% } %>
			<button class="edit-field-button vtop"><i class="mdi mdi-pencil"></i></button>
		</div>
		<div class="field-editing content-form-editing">
			{{-- Render template edit form--}}
		</div>
	</script>

	{{-- Info Video Project template--}}
	<script type="text/template" id="info-video-group-tpl">
		<div class="video-content-preview wrapper-video-edit flex-video widescreen vimeo">
			<i class="icon icon-cam-video icon-placeholder"></i>
			<iframe id="video-group-preview" class="preview-video" src="<%- window.Misc.convertVideoEmbed(video_entidad,'embed') %>" scrolling="no" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

			<% if(owner){ %>
				<button class="edit-video change-video small edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" aria-expanded="false" data-options="align:right;" data-edit-template="video-group">
					<div class="edit-video-content">
						<i class="mdi mdi-camera mdi-24 vcenter"></i>
						<span>Añadir un vídeo</span>
						<span class="editing-video-message">Cambiar vídeo</span>
					</div>
				</button>
			<% } %>
		</div>
	</script>

	{{-- Info Socials Project template--}}
	<script type="text/template" id="info-socials-group-tpl">
		<ul class="socials-project-profile">
			<li>
				<a href="<%- twitter_usuario %>" title="X" class="<%- twitter_usuario ? 'twitter' : 'disabled' %>" target="_blank"><i class="mdi mdi-close-outline mdi-18 <%- twitter_usuario ? 'twitter' : '' %>"></i></a>

				<a href="<%- facebook_usuario %>" title="Facebook" class="<%- facebook_usuario ? 'facebook' : 'disabled' %>" target="_blank"><i class="mdi mdi-facebook mdi-18 <%- facebook_usuario ? 'facebook' : '' %>"></i></a>

				<a href="<%- linkedin_usuario %>" title="Linkedin" class="<%- linkedin_usuario ? 'linkedin' : 'disabled' %>" target="_blank"><i class="mdi mdi-linkedin mdi-18 <%- linkedin_usuario ? 'linkedin' : '' %>" ></i></a>

				<a href="<%- tiktok_usuario %>" title="TikTok" class="<%- tiktok_usuario ? 'tiktok' : 'disabled' %>" target="_blank"><i class="mdi mdi-linkedin mdi-18 <%- tiktok_usuario ? 'tiktok' : '' %>" ></i></a>

				<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:right" aria-expanded="false" data-edit-template="socials"><i class="mdi mdi-pencil"></i></button>
			</li>
		</ul>
	</script>

	<script type="text/template" id="info-description-group-tpl">

		<div class="content-description-project edit-field clearfix" data-edit-template="description">
			<h5 class="title-panel text-left">
				<span class="field-text">Descripción General</span>
				<button class="right edit-field-button"><i class="mdi mdi-pencil"></i></button>
			</h5>
			<p class="block-text-xmedium">
				<% if(!_.isUndefined(descripcion_entidad) && !_.isNull(descripcion_entidad)) { %>
					<%= descripcion_entidad %>
				<% }%>
			</p>
		</div>
		<div class="field-editing">
		{{-- Render template edit form--}}
		</div>
	</script>

	{{-- section Confirm Remove Project --}}
	<script type="text/template" id="project-confirm-remove-tpl">
		<p>{{ Lang::get('project.close.confirm') }}</p>
	</script>

@stop
