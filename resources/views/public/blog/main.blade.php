@extends('public.blog.blog')

@section('blog.content')

	{{-- ------------------ Blog Templates JS -------------------- --}}
	<script type="text/template" id="blog-sidemenu-filter-tpl">
		<div class="wrapper-side-nav radius-bottom sticky-side-nav">
			<a href="#" class="hide-fx-left-btn on">
				<span class="title-side-nav text-sm">Categorías</span>
				<i class="side-nav-arrow"></i>
			</a>
			<div class="content-filters-sidemenu scroll-general-v">
				<ul class="side-nav-slide">
					<li class="divider"></li>
					@foreach (App\TipoContenido::getTypes() as $item)
						<li class="<%- category == '{{ $item->url_tipo_contenido }}' ? 'active' : '' %>">
							<a href="<%= Route.route( 'blog.categoria', {'category': '{{ $item->url_tipo_contenido }}' }) %>">{{{ $item->nombre_tipo_contenido }}}</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	</script>
	{{-- Section Blogs --}}
	<script type="text/template" id="blog-list-tpl">

        <!-- module navigation -->
        <!--div id="blog-submenu-nav" class="wrapper-module-menu-section inst-bgcolor-secondary show-for-large-up">
            <div class="row">
                <div class="small-12 columns">
                    <ul id="blog-tabs-navs" class="tabs-sub-nav-alt tabs tabs-route text-right" data-tab data-tab-init="is_hover:false">
                        <li class="tab-title">
                            <a href="" title="" class="linkto-inst-color">Artículos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div-->

        <!-- module responsive navigation -->
        <!--div id="module-responsive-nav-bar" class="wrapper-module-responsive-nav hide-for-large-up inst-bgcolor-secondary">
            <div class="row collapse">
                <div class="small-12 columns">
                    <dl class="sub-nav">
                        <button data-dropdown="drop-main-menu" aria-controls="drop-main-menu" aria-expanded="false" class="button dropdown right">Artículos<i class="mdi mdi-chevron-down mdi-18 gutter-left vcenter"></i></button>
                        <ul id="drop-main-menu" data-dropdown-content class="f-dropdown dropdown-main inst-bgcolor-secondary" aria-hidden="true">
                        <li class="">
                            <a href="" title="">Artículos principal</a>
                        </li>
                        @if( Auth::check() )
                            <li>
                                <a href=""><i class="mdi mdi-plus mdi-18 gutter-right vcenter"></i>Crear evento</a>
                            </li>
                        @endif
                        </ul>
                    </dl>
                </div>
            </div>
        </div-->

		<div id="content-article-main">
			<% if( $.inArray(tab,['createArticle']) != -1 ){ %>
			<div class="row">
				<div class="small-12 columns">
					<section class="content" id="create-article">
						{{-- Render create article form--}}
					</section>
				</div>
			</div>
			<% }else{ %>
				<div class="row">
					<div class="small-12 columns">
						<div class="last-article-blog">
							{{-- Render last article --}}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<div class="">
							<div class="row">

								<div class="tablet-8 columns">
									<div id="content-articles-list" class="content-data-list content-articles-list">
										@include('public.noresults')
										<ul id='article-list' class="small-block-grid-1 medium-block-grid-2 browse-list-card browse-list-articles">
											<!-- Render blog list -->
										</ul>
									</div>
								</div>

								<div class="tablet-4 columns">
									<aside class="data-aside data-aside-right">
										<div id="content-mostviewed-list" class="content-data-list content-mostviewed-list sticky-aside scroll-aside">
											<div class="title-section-block">
												<h6 class="inner-title-section">Artículos recomendados</h6>
											</div>
											<div class="content">
												@include('public.noresults')
												<ul id='most-viewed-articles' class="small-block-grid-1 browse-list-data browse-list-most-viewed-articles">
													<!-- Render blog list -->
												</ul>
											</div>
										</div>
									</aside>
								</div>

							</div>
						</div>
					</div>
				</div>
			<% } %>
		</div>
	</script>

	{{-- last article blog element --}}
	<script type="text/template" id="last-article-blog-tpl">
		<div class="row collapse col-equal-height">

			<div class="mobile-12 tablet-7 columns">
				<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" title="<%- nombre_contenido %>" class="image-last-article">
					<img src="<%- imagen_contenido %>" alt="<%- nombre_contenido %>" class="item-thumb" onerror="imageDefault(this, '{{ config('tuproyecto.no_event_image') }}')">
				</a>
			</div>

			<div class="mobile-12 tablet-5 columns">
				<div class="detail-last-article">
					<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" ><h3 class="dark-text"><%- nombre_contenido %></h3></a>

					<p class="last-article-resumen thin-text ellipsis"><%- resumen_contenido %></p>

					<div class="mask-last-article">
						<ul class="article-author-details">
							<li>
								<span class="thin-text gray-base-text text-md">Por <a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nickname_usuario %>" class="inst-color-secondary bold-text"><%- nombre_usuario %></a></span>
							</li>
							<li>
								<ul class="post-social-shared extend inline-list-grid">
									<li class="vtop">
										<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
									</li>
									<li class="vbottom text-right"><em class="article-published light-text gray-light-text text-sm"><%- window.moment(fecha_contenido).format('L') %></em></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>

		</div>
	</script>

	{{-- item Blog list --}}
	<script type="text/template" id="article-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="top-item-card">
				<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" class="card-thumb">
					<img src="<%= imagen_contenido %>" alt="<%- nombre_contenido %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';"/>
				</a>
			</div>
			<div class="content-item-card text-left">
				<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" class="is-hovered"><h5 class="title-item-card ellipsis is-hovered"><%- nombre_contenido %></h5></a>
			</div>
			<div class="bottom-item-card">
				<ul class="no-bullet">
					<li>
						<a href="<%= window.Misc.urlFull( url_profile ) %>" class="dark-text bold-text text-md" ><%- nombre_usuario %></a>
					</li>
				</ul>
				<ul class="post-social-shared extend clearfix">
					<li class="left">
						<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
					</li>
					<li class="right"><em class="light-text gray-light-text text-sm"><%- window.moment(fecha_contenido).format('L') %></em></li>
				</ul>
			</div>
		</div>
	</script>

	{{-- item Most Viewed Blog list --}}
	<script type="text/template" id="most-viewed-article-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="row col-equal-height valign-top collapse">
				<div class="mobile-4 columns">
					<div class="picture-item-data">
						<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" class="data-thumbnail">
							<img src="<%= imagen_contenido %>" alt="" class="item-thumb" onerror="imageDefault(this, '{{ config('tuproyecto.no_event_image') }}')"/>
						</a>
					</div>
				</div>

				<div class="mobile-8 columns">
					<div class="content-item-data">
						<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" class="data-thumbnail is-hovered">
							<p class="block-text-xsmall bold-text gray-base-text ellipsis is-hovered"><%- nombre_contenido %></p>
						</a>
					</div>
					<em class="article-published light-text gray-light-text text-sm"><%- window.moment(fecha_contenido).fromNow() %></em>
				</div>
			</div>
		</div>
	</script>

	{{-- Section Detail Article --}}
	<script type="text/template" id="article-detail-tpl">
		<% if(owner){ %>
			{{-- dropdown edit form --}}
			<div id="drop-edit-form" data-dropdown-content class="md-dropdown drop-editing radius content medium" aria-hidden="true" aria-autoclose="false">
				{{-- Render profile edit form --}}
			</div>
		<% } %>
		<div id="article-detail-content" class="article-detail-content">
			<div class="row">
				<div class="tablet-8 columns">
					<div id="inner-article-detail">
						<div class="article-header">
							<div class="row">
								<div class="small-12 columns">
									<div id="article-main-image" class="wrapper-image-edit image-area-drop product-img-main">
										{{-- Render image template--}}
									</div>

									<div class="row">
										<div class="tablet-10 columns">
											<div id="article-main-title" class="mask-article-header">
												{{-- <h3 class="article-title bold-header"><%- nombre_contenido %></h3>--}}
											</div>
										</div>
										<div class="tablet-2 columns">
											<ul class="right article-icons-shared social-box-icons">
												<li>
													<ul id="drop-shared-social-article" class="friendship-dropdown no-arrow items-wrap radius" data-dropdown-content aria-hidden="true">
														<li class="text-center">
															<label class="label single gray-base-text">Compartir en redes:</label>
															<ul class="inline-list-grid align-top">
																<li class="text-center">
																	<a href="http://www.facebook.com/share.php?u=<%- window.Misc.urlFull( Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido }) ) %>&title=<%- nombre_contenido %>" title="Compartir en facebook" class="tp_facebook_share">
																		<i class="mdi mdi-facebook mdi-21 facebook"></i>
																	</a>
																</li>
																<li class="text-center">
																	<a href="http://www.linkedin.com/shareArticle?mini=true&url=<%= window.Misc.urlFull( Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido }) ) %>&title=<%- nombre_contenido %>&source=DOMAIN" title="Compartir en linkedin" class="tp_linkedin_share">
																		<i class="mdi mdi-linkedin mdi-21 linkedin"></i>
																	</a>
																</li>
																<li class="text-center">
																	<a href="http://twitter.com/intent/tweet?status=<%- nombre_contenido %>+<%- window.Misc.urlFull( Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido }) ) %>" title="Compartir en X" class="">
																		<i class="mdi mdi-close-outline mdi-21 twitter"></i>
																	</a>
																</li>
															</ul>
														</li>
													</ul>
													<a title="Compartir" data-dropdown="drop-shared-social-article" aria-controls="drop-shared-social-article" data-options="align:bottom;is_hover:false;hover_timeout:500">
														<i class="mdi mdi-share-variant mdi-21"></i>
													</a>
												</li>
												<li>
													<ul id="drop-liked-article" class="post-social-shared article-shared-list clearfix md-dropdown drop-strip radius" data-dropdown-content>
														<li class="left">
															<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
														</li>
													</ul>
													<a class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta" data-dropdown="drop-liked-article" aria-controls="drop-liked-article" data-options="align:top;is_hover:true;hover_timeout:500">
														<i class="mdi mdi-thumb-up-outline mdi-21"></i>
														<span class="data-count-likes text-xmd"><%- contador_like %></span>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="article-detail-info">
							<div class="row">
								<div class="small-8 columns">
									<ul class="article-author-details">
										<li>
											<span class="thin-text gray-base-text text-md">Por: <a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nickname_usuario %>" class="inst-color-secondary bold-text"><%- nombre_usuario %></a></span>
										</li>
									</ul>
								</div>
								<div class="small-4 columns text-right">
									<em class="article-published light-text gray-light-text text-sm"><%- window.moment(fecha_contenido).format('dddd, DD [de] MMMM [de] YYYY ') %></em>
								</div>
							</div>
							@if (Auth::check())
								<% if(owner){ %>
									<br>
									<div class="row">
										<div class="small-12 columns">
											<div class="content-state-article">
												<ul id="buttons-article-action" class="inline-list-grid align-top">
													{{-- Render buttons follows --}}
												</ul>
											</div>
										</div>
									</div>
								<% } %>
							@endif
						</div>

						<hr class="no-margin sky-blue pull-border-side" width="30px">

						<div class="article-content">
							<div class="row">
								<div class="small-12 columns">
									<div id="article-infodescription-container" class="editable-item">
										{{-- Render info description--}}
									</div>
								</div>
							</div>
						</div>

						<hr class="no-margin gray-base pull-border-side" width="80px">

						{{-- Comment Section --}}
						<div class="article-comments">
							<div class="row">
								<div class="small-12 columns">
									<div class="content active" id="wrapper-posts-discussion">
										@if (Auth::check())
											{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-discussion-article') ) !!}
												<div class="textarea-post-discussion clearfix">
													<textarea placeholder="Comenta aquí" required="required" name="texto_discucion" id="texto_discucion" class="materialize-textarea validate"></textarea>
													<label for="texto_discucion" data-error="El campo esta vació o tiene muy pocos caracteres"></label>
													<button class="right button tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
												</div>
												<input type="hidden" name="codigo_contenido" value="<%= codigo_contenido %>" />
											{!! Form::close() !!}
										@endif
										@include('public.noresults', ['message' => 'No hay discusiones'])
										<section id="discussion-posts-wrap" class="">
											{{-- Render Tasks template --}}
										</section>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tablet-4 columns">
					<aside class="data-aside no-spacing-top data-aside-right">
						<div id="content-mostviewed-list" class="content-data-list content-mostviewed-list sticky-aside scroll-aside">
							<div class="title-section-block">
								<h6 class="inner-title-section">Artículos recomendados</h6>
							</div>
							<div class="content">
								@include('public.noresults', ['message' => 'No hay artículos recomendados'])
								<ul id='most-viewed-articles' class="small-block-grid-1 browse-list-data browse-list-most-viewed-articles">
									<!-- Render blog list -->
								</ul>
							</div>
						</div>
					</aside>
				</div>
			</div>
		</div>
	</script>

	{{-- Section Comment Article --}}
	<script type="text/template" id="article-comment-tpl">

		{{-- row post user data box --}}
		<div class="post-user-data-box">
			<div class="row collapse">
				<div class="small-12 columns">
					<ul class="post-user-card">
						<li>
							<a href="<%= window.Misc.urlFull( url_profile ) %>" class="post-avatar" title="<%- nombre_usuario %>">
								<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>">
							</a>
						</li>
						<li>
							<ul class="post-user-data">
								<li>
									<span>
										<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="nickname-user-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
									</span>
								</li>
								<li>
									{{-- row post content box --}}
									<div class="post-content-box">
										<div class="row collapse">
											<div class="medium-12 columns">
												<div class="text-description-post container-more"><%= texto_comentario %></div>
											</div>
										</div>
									</div>
								</li>
								<li>
									<span class="light-text"> <%- time_ago %></span>
									{{-- <a href=""><i class="icon icon-add-friend"></i></a> --}}
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		@if (Auth::check())
		<div class="post-footer-box">
			<div>
				<div class="row">
					<div class="medium-9 columns">
						<ul class="post-social-shared comment-shared-list">
							<li>
								<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
							</li>
						</ul>
					</div>
					<div class="medium-3 columns">
						<ul class="right footer-box-icons post-icons-list">
							<li>
								<a href="#" class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
									<i class="icon icon-like"></i>
									<span class="data-count-likes"><%- contador_like %></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		@endif

	</script>

	{{-- item Most Viewed Internal Blog list --}}
	<script type="text/template" id="most-viewed-article-internal-item-list-tpl">
		<div class="item-wrap-list radius">
			<div class="row col-equal-height valign-top collapse">
				<div class="mobile-4 columns">
					<div class="picture-item-data">
						<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" class="data-thumbnail">
							<img src="<%= imagen_contenido %>" alt="" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';"/>
						</a>
					</div>
				</div>

				<div class="mobile-8 columns">
					<div class="content-item-data">
						<a href="<%= Route.route('blog.categoria.articulo', {'category': url_tipo_contenido, 'article': url_contenido}) %>" title="<%- nombre_contenido %>" class="data-thumbnail is-hovered">
							<p class="block-text-xsmall bold-text gray-base-text ellipsis is-hovered"><%- nombre_contenido %></p>
						</a>
					</div>
					<em class="article-published light-text gray-light-text text-sm"><%- window.moment(fecha_contenido).fromNow() %></em>
				</div>
			</div>
		</div>
	</script>

	{{-- form create article --}}
	<script type="text/template" id="blog-create-tpl">
		<div id="new-product-content" class="panel-info with-title radius">
			<h5 class="title-panel text-left">Nuevo artículo</h5>
			<div class="container-fields-product">
				@include('public.blog.form.createarticle')
			</div>
		</div>
	</script>

	{{-- Image main article Create template --}}
	<script type="text/template" id="main-image-article-create-tpl">
		<img src="<%- imagen_contenido %>" alt="<%- nombre_contenido %>" title="<%- nombre_contenido %>" class="item-thumb" onerror="if (this.src != '{{ config('tuproyecto.no_image') }}') this.src = '{{ config('tuproyecto.no_image') }}';">
		<% if(owner){ %>
			<button id="change-image-article" class="edit-photo change-photo small">
				<div class="edit-photo-content">
					<i class="mdi mdi-camera mdi-24 vcenter"></i>
					<span>Añadir una Imagen</span>
					<span class="editing-photo-message">Cambiar Imagen</span>
				</div>
			</button>
		<% } %>
		<input type="hidden" id="imagen_contenido" name="imagen_contenido" value="<%- imagen_contenido %>">
	</script>

	{{-- Title article template --}}
	<script type="text/template" id="info-article-tpl">
		<h3 class="article-title bold-header">
			<span class="field-text"><%- nombre_contenido %></span>
			<button class="edit-field-button edit-field" data-dropdown="drop-edit-form" aria-controls="drop-edit-form" data-options="align:left" aria-expanded="false" data-edit-template="infobasic"><i class="mdi mdi-pencil"></i></button>
		</h3>
	</script>

	{{-- Info Description Product template --}}
	<script type="text/template" id="info-description-article-tpl">
		<button class="edit-field-button edit-field right" data-edit-template="infodescription"><i class="mdi mdi-pencil"></i></button>

		<div class="content-description-article field-for-edit edit-field clearfix wrap-text" data-edit-template="infodescription">
			<div class="prepared-to-edit"><%= window.Misc.stripTags(texto_contenido) ? texto_contenido : '' %><%= !window.Misc.stripTags(texto_contenido) && owner ? '<span class="edit-no-result text-dmd">Agrega un contenido</span>' : '' %></div>
		</div>
		<div class="field-editing">
			{{-- Render template edit form--}}
		</div>
	</script>

	<script type="text/template" id="edit-article-basic-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-infobasic-article') ) !!}
		<div class="row">
			<div class="small-12 columns input-field">
				<input type="text" name="nombre_contenido" id="nombre_contenido" value="<%- nombre_contenido %>" placeholder="" required class="validate">
				<label for="nombre_contenido" data-error="El campo esta vacío">Título</label>
			</div>
		</div>
		<div class="row">
			<div class="columns mobile-4 mobile-offset-8 tablet-3 tablet-offset-9">
				{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}
			</div>
		</div>
		{!! Form::close() !!}
	</script>

	<script type="text/template" id="edit-article-description-form-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-edit-description-article') ) !!}
			<div class="row">
				<div class="mobile-9 small-9 tablet-10 columns input-field">
					<section id="form-project-editor">
						{{-- Render component pulse-editor --}}
						<input type="hidden" name="texto_contenido" value="<%- texto_contenido %>" required >
					</section>
				</div>
			</div>
			<div class="row">
				<div class="mobile-12 tablet-5 tablet-offset-7 columns">
				  	<ul class="inline-list-grid">
				  		<li><button class="button tiny expand white btn-shadow radius close-editing">Cancelar</button></li>
				  		<li>{!! Form::submit('Guardar', array('class' => 'button tiny expand sky-blue btn-shadow radius')) !!}</li>
				  	</ul>
				</div>
			</div>
		{!! Form::close() !!}
	</script>

@stop
