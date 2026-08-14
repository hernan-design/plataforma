@extends('core.discussion.discussion')

@section('discussion.content')

	{{-- Section view only Discussion --}}
	<script type="text/template" id="discussion-tpl">

		<div id="main-wrapper-discussion">
			<div class="row">
				<div class="small-12 columns">
					<hr class="h-hollow-both">

					<div class="row">
						<div class="small-12 tablet-6 columns">

							<div class="detail-content-discussion panel-content radius">
								<label class="label single text-md lighter-text gray-dark-text">
									Esta discusión se generó en: <a href="<%- window.Misc.urlFull( origin.url_origen ) %>" title="<%- origin.titulo_origen %>" class="inst-color-secondary"><i class=""></i><%- origin.nombre_origen %></a>
								</label>

								<div class="info-detail-discussion">
									<ul class="inline-list-grid align-top">
										<% if(origin.imagen_origen) { %>
											<li class="has-image">
												<a href="<%- window.Misc.urlFull( origin.url_origen ) %>" title="<%- origin.titulo_origen %>">
													<img src="<%- origin.imagen_origen %>" alt="<%- origin.titulo_origen %>" class="image-info-discussion">
												</a>
											</li>
										<% } %>
										<li>
											<div class="description-post-discussion">
												<% if( origin.titulo_origen && origin.titulo_origen.length ) { %>
													<h6 class="bold-header gray-dark-text"> <%- origin.titulo_origen %></h6>
												<% } %>
												<p class="text-sm lighter-text clean-bottom gray-dark-text"><%= origin.texto_origen %></p>
											</div>
										</li>
									</ul>
								</div>

								<hr>

								<div id="wrapper-posts-discussion" class="content-discussion">
									@include('public.noresults', ['message' => 'No hay discusión'])
									<article class="discussion-post-box">
										<div id="discussion-posts-wrap">
											{{-- Render info Comment Discussion--}}
										</div>
									</article>
								</div>
							</div>

						</div>

						<div class="small-12 tablet-6 columns">
							<label class="label single text-md lighter-text gray-dark-text">Tienes esta discusión con</label>

							<div id="participant-discussion" class="content-data-list">
								@include('public.noresults', ['message' => 'No hay resultados'] )
								<ul id="participants-discussion-wrap" class="small-block-grid-1 browse-list-users">
									{{-- Render Tasks template --}}
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</script>
@stop
