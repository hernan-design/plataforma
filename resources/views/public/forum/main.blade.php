@extends('public.forum.forum')

@section('forum.content')
	{{-- Render foro templates--}}
	<div id="forum-posts"></div>
	<div class="more-commented">
		<div class="title-section">
			<h6 class="inner-title-section">Temas más comentados</h6>
		</div>
		<table class="table-content tbl-info">
			@foreach ($mostCommented as $posts)
				<tr>
					<td width="3%">
						<i class="fa fa-comments-o"></i>
					</td>
					<td width="77%">
						<a href="{{ URL::route('foro.categoria.tema', array($posts->url_categoria_foro, $posts->url_foro)) }}">{{{ $posts->titulo_foro }}}</a>
					</td>
					<td width="20%">{{{ $posts->contador_comentario }}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	<div class="recent-comments">
		<div class="title-section">
			<h6 class="inner-title-section">Comentarios recientes</h6>
		</div>
		<table class="table-content tbl-info">
			@foreach ($recentComments as $comment)
				<tr>
					<td width="3%"><i class="fa fa-twitch"></i></td>
					<td width="77%">
						<a href="{{ URL::route('foro.categoria.tema', array($comment->url_categoria_foro, $comment->url_foro)) }}">Re:{{{ $comment->titulo_foro }}}</a>
						<p>por <a href="{{ URL::route('usuario.nickname', $comment->nickname_usuario) }}" class="created-by">{{{ $comment->nickname }}}</a> </p>
					</td>
					<td width="20%">
						<span class="thin-text">{{{ $comment->date_time }}}<span/>
					</td>
				</tr>
			@endforeach
		</table>
	</div>

	<script type="text/template" id="list-categories">
		<!-- <div class="title-section clearfix">
			<ul class="right pagination">
				<li class="arrow"><a href="">Anterior</a></li>
				<li><a href="#">1</a></li>
				<li class="current"><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li class="arrow"><a href="">Siguiente</a></li>
			</ul>
		</div> -->
		<div class="title-section">
			<h6 class="inner-title-section"><%= 'Comunidad' %></h6>
		</div>
		<table role="grid" class="table-content" id="forum-categories-data">
			<thead>
				<tr>
					<th width="60%" colspan="2"><%= 'Categoría &#8260; Temas' %></th>
					<th width="15%"><%= 'Comentarios' %></th>
					<th width="25%"><%= 'Último comentario' %></th>
				</tr>
			</thead>
			<!-- Render category posts template -->
			<!-- <tfoot>
					<tr>
						<td colspan="4">
							<ul class="right pagination">
								<li class="arrow unavailable"><a href="">Anterior</a></li>
								<li class="current"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li><a href="#">6</a></li>
								<li><a href="#">7</a></li>
								<li class="arrow"><a href="">Siguiente</a></li>
							</ul>
						</td>
					</tr>
				</tfoot> -->
		</table>
	</script>

	<script type="text/template" id="category-posts">
		<% //Category %>
		<tr>
		    <th colspan="4">
	            <%- nombre_categoria_foro %>
	            <span class="thin-text">
	            	(<%= posts_num %> <%= posts_num.length > 1 ? 'items' : 'item' %>)
	            </span>
		    </th>
		</tr>
		<% //Category themes %>
		<% _.each(posts, function(post) { %>
			<tr>
			    <td><i class="fa fa-unlock"></i></td>
			    <td>
			        <a href="<%= Route.route( 'foro.categoria.tema', {'category': url_categoria_foro, 'theme': post.url_foro } ) %>"><%- post.titulo_foro %></a>
			        <p>Creado por - <a href="<%= window.Misc.urlFull( post.url_profile ) %>" class="created-by"><%= post.nickname %></a> -
			        <span class="light-text"><%= post.time_ago %></span></p>
			    </td>
			    <td><%= post.comments_num %></td>
			    <td>
			        <% if( post.comments_num > 0 ){ %>
			            <p><%= post.comment_date_time %><br/>
			            por <a href="<%= window.Misc.urlFull( post.url_profile ) %>" class="created-by"><%= post.comment_nickname %></a></p>
			        <% }else{ %>
			            <p>No Registra</p>
			        <% } %>
			    </td>
			</tr>
		<% }); %>
	</script>

	<script type="text/template" id="forum-detail">
		<div class="title-section clearfix">
			<h6 class="right inner-title-section"><a href="#comment-forum-form" class="anchor-to">Comentar</a></h6>
		</div>
		<section id="container-forum-detail" class="wrapper-comments-list">
			<article class="row collapse main-question-detail">
				<div class="large-3 columns profile-datas-post">
					<div class="avatar-post">
						<a href="<%= window.Misc.urlFull( url_profile ) %>">
							<img src="<%= imagen_usuario %>" alt="<%= nickname_usuario %>" />
						</a>
						<h6 class="name-user-post">
							<%- nombre_usuario %>
						</h6>
					</div>
					<div class="profile-post">
						<ul>
							<li><a href="<%= window.Misc.urlFull( url_profile ) %>"><%= nickname %></a></li>
							<li><%= ciudad_usuario %></li>
							<li>Comentarios: <%= comentarios_usuario %></li>
						</ul>
					</div>
				</div>
				<div class="large-9 columns question-post">
					<dl class="inner-post-detail">
						<dd>
							<h3 class="title-post-question"><%- titulo_foro %></h3>
						</dd>
						<dd class="clearfix">
							<div class="row collapse">
								<div class="large-7 off large-offset-1 columns tags-post-post">
									<ul class="tags-list-post inst-color-invert">
										<li><strong>Tags:</strong></li>
										<li><%= tags %></li>
									</ul>
								</div>
							</div>
						</dd>
						<dd>
							<div class="text-md"><%= descripcion_foro %></div>
							<div class="row collapse share-icons">
								<div class="large-5 columns">
									<span class="date-post-published inst-color-invert"><%= time_ago %></span>
								</div>
								<div class="large-7 columns text-right">
									<ul class="forum-icons-list post-icons-follow inst-color-invert">
										@if (Auth::check())
											<li>
												<a href="#" class="data-post-share TPlikelink inst-color-invert" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}">
													{{  Lang::get('like.like') }}
												</a>
											</li>
										@endif
									</ul>

									<ul class="forum-icons-list post-icons-share inst-color-invert">
										<!-- <li>
											<a href="#"><i class="fa fa-share"></i></a>
										</li> -->
										@if (Auth::check())
											<li>
												<a href="#" class="show-user-likes">
													<i class="fa fa-lightbulb-o"></i>
													<span class="data-count data-count-likes"><%= contador_like%></span>
												</a>
											</li>
										@endif
										<li>
											<a href="#comment-forum-form" class="anchor-to">
												<i class="fa fa-comment"></i>
												<span class="data-count data-count-comments"><%= contador_comentario%></span>
											</a>
										</li>
										<!-- <li><a href="">Reportar como inapropiado</a></li> -->
									</ul>
								</div>
							</div>
						</dd>
					</dl>
				</div>
			</article>
		</section>
		<div id="comment-forum-form">
			@if (Auth::check())
				{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-comment-forum') ) !!}
					<fieldset>
						<div class="textarea-post wysiwyg-forum-comment clearfix">
							<textarea placeholder="Comentario y/o Respuesta" required="required" name="texto_respuesta_foro" cols="50" rows="8" pattern="max_char_textarea" class="wysiwyg-single"></textarea>
							<small class="error">El campo esta vació o tiene muy pocos caracteres</small>
							<button class="right button tiny" type="submit">Comentar</button>
						</div>
						<input type="hidden" name="codigo_foro" value="<%= codigo_foro %>" />
					</fieldset>
				{!! Form::close() !!}
			@else
				@include('public.unauth', array('message' => Lang::get('forum.unauth.comment')))
			@endif
		</div>
	</script>

	<script type="text/template" id="comment-forum">
		<div class="large-3 columns profile-datas-post">
			<div class="avatar-post">
				<a href="<%= window.Misc.urlFull( url_profile ) %>">
					<img src="<%= imagen_usuario %>" alt="<%= nickname_usuario %>" />
				</a>
				<h6 class="name-user-post"><%- nombre_usuario %></h6>
			</div>
			<div class="profile-post">
				<ul>
					<li><a href="<%= window.Misc.urlFull( url_profile ) %>"><%= nickname %></a></li>
					<li><%= ciudad_usuario %></li>
					<li>Comentarios: <%= comentarios_usuario %></li>
				</ul>
			</div>
		</div>
		<div class="large-9 columns answer-post">
			<div class="inner-comment-detail inner-post-detail">
				<div class="description-wysiwyg post-answer-text"><%= texto_respuesta_foro %></div>
				<div class="row collapse share-icons">
					<div class="large-5 columns">
						<span class="date-post-published inst-color-invert"><%= fecha_respuesta_foro %></span>
					</div>
					<div class="large-7 columns text-right">
						<ul class="comment-icons-list post-icons-follow inst-color-invert">
							@if (Auth::check())
								<li>
									<a href="#" class="data-post-share TPlikelink inst-color-invert" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}">
										{{  Lang::get('like.like') }}
									</a>
								</li>
							@endif
						</ul>
						<ul class="comment-icons-list post-icons-share inst-color-invert">
							<!-- <li>
								<a href="#"><i class="fa fa-share"></i></a>
							</li> -->
							@if (Auth::check())
								<li>
									<a href="#" class="show-user-likes">
										<i class="fa fa-lightbulb-o"></i>
										<span class="data-count data-count-likes"><%= contador_like%></span>
									</a>
								</li>
							@endif
							<!-- <li><a href="">Reportar como inapropiado</a></li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</script>

	<script type="text/template" id="forum-search-results">
		<!-- <div class="title-section clearfix">
			<ul class="pagination">
				<li class="arrow"><a href="">Anterior</a></li>
				<li><a href="#">1</a></li>
				<li class="current"><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">6</a></li>
				<li><a href="#">7</a></li>
				<li class="arrow"><a href="">Siguiente</a></li>
			</ul>
		</div> -->
		<div class="title-section">
			<h6 class="inner-title-section">Resultados de busqueda para foro</h6>
		</div>

		<table id="forum-results-data" class="table-content">
			<!-- Render results list template -->
			<tbody>
				@include('public.noresults')
			</tbody>
		<!-- <tfoot>
				<tr>
					<td colspan="4">
						<ul class="pagination">
							<li class="arrow unavailable"><a href="">Anterior</a></li>
							<li class="current"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">6</a></li>
							<li><a href="#">7</a></li>
							<li class="arrow"><a href="">Siguiente</a></li>
						</ul>
					</td>
				</tr>
			</tfoot> -->
		</table>
	</script>

	<script type="text/template" id="forum-theme-result">
		<td width="70%" class="text-left">
			<a href="<%= Route.route( 'foro.categoria.tema', {'category': url_categoria_foro, 'theme': url_foro } ) %>"><%- titulo_foro %></a>
	        <p>Creado por - <a href="<%= window.Misc.urlFull( url_profile ) %>" class="created-by"><%= nickname %></a> -
	        <span class="light-text"><%= time_ago %></span></p>
		</td>
		<td width="30%" class="text-left">
			<ul class="list-tags-result inst-color-invert">
				<% _.each(tags, function(tag) { %>
					<li><%= tag.texto_tag %></li>
				<% }); %>
			</ul>
		</td>
	</script>
@stop
