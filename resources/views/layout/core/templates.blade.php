{{-- Global Templates js platform --}}
{{-- Breadcrumb template --}}
<script type="text/template" id="breadcrumb-tp">
	<% _.each(breadcrumbs, function(path) { %>
		<li class="<%- !_.isUndefined(path.current) && path.current === true ? 'current' : '' %><%- !_.isUndefined(path.unavailable) && path.unavailable === true ? ' unavailable' : ''  %>">
			<a href="<%= path.url %>">
				<% if(!_.isUndefined(path.type) && path.type == 'home') { %>
					<i class="mdi mdi-home mdi-21"></i>
				<% }else{ %>
					<%- path.title %>
				<% } %>
			</a>
		</li>
	<% }); %>
</script>

{{-- Pagination template --}}
<script type="text/template" id="pagination-tpl">
	<li class="arrow start-page"><a href="#!"><i class="mdi mdi-chevron-left"></i></a></li>
	<li class="arrow prev-page"><a href="#!"><i class="mdi mdi-chevron-left hide-for-tablet-up"></i>Anterior</a></li>
	<% _.each( items, function(item) { %>
		<li class="<%= item.classes %> <%- !_.contains(item.classes.split(' '), 'active') ? 'waves-effect' : '' %>">
			<a href="#<%= item.indx %>"><%- item.title %></a>
		</li>
	<% }); %>
	<li class="arrow next-page"><a href="#!"><i class="mdi mdi-chevron-right hide-for-tablet-up"></i>Siguiente</a></li>
	<li class="arrow end-page"><a href="#!"><i class="mdi mdi-chevron-right"></i></a></li>
</script>

{{-- Button view more template --}}
<script type="text/template" id="btn-view-more-tpl">
	<div class="row collapse">
		<div class="small-12 columns">
			<a href="#" class="button expand xsmall btn-view-more white btn-resetc btn-clean-margin">Mostrar más</a>
		</div>
	</div>
</script>

{{-- browse result count --}}
<script type="text/template" id="browse-result-count-tpl">
	<span class="gray-dark-text text-dmd bold-text"><%- from %> - <%- to %> <span class="lighter-text">de</span> <%- totalRecords %></span>
</script>

<script type="text/template" id="section-title-tpl">
	<% if (_.isUndefined(subtitle) || _.isNull(subtitle)) { %>
		<div class="row">
			<div class="small-12 columns">
				<h2 class="title-header">{{{ TuProyecto::getTitleSection() }}}</h2>
			</div>
		</div>
	<% }else{ %>
		<div class="row">
			<div class="small-12 columns">
				<h2 class="title-category"><span class="subtitle">{{{ TuProyecto::getTitleSection() }}} &frasl;</span><%= subtitle %></h2>
			</div>
		</div>
	<% } %>
</script>
{{-- modal event description --}}
<script type="text/template" id="event-modal-tpl">
	<div class="content-event">
		<div class="event-date-info text-center inst-bgcolor inst-color">
			<label class="event-item-title"><%- nombre_evento %></label>
			<div class="event-date"><%- fecha_label_evento %></div>
			<span class="place-event">
				<%- lugar_evento %> <br/>
				<%- fecha_evento %> <%- hora_inicio_evento ? hora_inicio_evento : '' %>
				<%- fecha_fin_evento ? fecha_fin_evento : '' %> <%- hora_fin_evento ? hora_fin_evento : '' %>
			</span>
		</div>

		<div class="event-description">
			<p><%- descripcion_evento %></p>
		</div>
	</div>
</script>

{{-- Users that like its template --}}
<script type="text/template" id="user-likes-tpl">
	<div class="row collapse info-user-likes">
		<div class="small-12 columns">
			<ul class="info-basic-user">
				<li>
					<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="avatar-user">
						<img src="<%= imagen_usuario %>" alt="<%- nombre_usuario %>" onerror="if (this.src != '{{ config('tuproyecto.avatar_image') }}') this.src = '{{ config('tuproyecto.avatar_image') }}';"/>
					</a>
				</li>
				<li>
					<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="name-user dark-text">
						<%- nombre_usuario %>
					</a>
					<em class="thin-text"><a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="nickname-user">
						<%- window.Misc.strToNickname(nickname_usuario) %>
					</a></em>
				</li>
			</ul>
		</div>
	</div>
</script>

{{-- post Discussion template --}}
<script type="text/template" id="discussion-item-tpl">
	<% if(owner){ %>
		<a href="#" class="close content-close discussion-post-hide" title="Remover Discusión">×</a>
	<% } %>
	<div class="post-user-data-box">
		<div class="row">
			<div class="small-12 columns">
				<ul class="post-user-card ss">
					<li>
						<a href="<%= window.Misc.urlFull( 'usuario/' + nickname_usuario ) %>" target="_blank" class="post-avatar" title="<%- nombre_usuario %>">
							<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size45" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
						</a>
					</li>
					<li>
						<ul class="post-user-data">
							<li>
								<span>
									<a href="<%= window.Misc.urlFull( 'usuario/' + nickname_usuario ) %>" target="_blank" title="<%- nombre_usuario %>" class="nickname-user-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
								</span>
								<span class="text-xsm light-text">&bull;</span>
								<span class="light-text"><%- window.moment([fecha_discusion].join(' '), "YYYY-MM-DD HH:mm:ss").utc('5').format("MMMM DD YYYY, h:mm:ss a") %></span>
							</li>
							<li>
								{{-- post content box --}}
								<div class="post-content-box">
									<div class="row collapse">
										<div class="small-12 columns">
											<div class="text-description-post container-more"><%= texto_discucion %></div>
										</div>
									</div>
								</div>
							</li>
							<li>
								{{-- footer box --}}
								<div class="post-footer-box">
									<div>
										<div class="row">
											<div class="small-9 columns">
												<ul class="post-social-shared comment-shared-list">
													<li>
														<span>A <a href="#" class="show-user-likes"><span class="data-count-likes"><%- contador_like %></span> {{ transtp('likes') }} </a> les gusta esto.</span>
													</li>
												</ul>
											</div>
											<div class="small-3 columns">
												<ul class="right footer-box-icons post-icons-list">
													<li>
														<a href="#" class="data-post-share TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
															<i class="icon icon-like"></i>
															<span class="data-count-likes"><%- contador_like %></span>
														</a>
													</li>
													<li>
														<a href="#" class="show-comment-field" title="Haz un comentario">
															<i class="icon icon-comment"></i>
															<span class="data-count-comments"><%= contador_comentarios_discucion %></span>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</li>
							<li>
								{{-- Discussion comments box--}}
								<div class="post-comments-box discussion-comments-box hidesoft">
									@if( Auth::check() )
										<div class="user-comment discussion-user-comment">
											<div class="row">
												<div class="small-12 columns">
													<ul class="post-user-card">
														<li>
															<a href="{{ Auth::user()->nickname_usuario ? URL::route('usuario.nickname', Auth::user()->nickname_usuario) : '#' }}" class="picture-comment-post" title="{{ Auth::user()->nombre_usuario }}">
																<img src="{{{ Auth::user()->imagen_usuario ? Auth::user()->imagen_usuario :  Config::get('tuproyecto.avatar_image') }}}" alt="{{{ Auth::user()->nickname_usuario }}}" class="rounded-img size35" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')" />
															</a>
														</li>
														<li>
															<div class="comment-post-field textarea-post-discussion">
																{!! Form::open( array('action' => null, 'data-abide' => '', 'class' => 'form-comment-discussion') ) !!}
																	<div class="row collapse col-equal-height">
																		<div class="mobile-9 small-10 columns">
																			<textarea name="texto_comentario_discucion" placeholder="Escribe un comentario" rows="1" class="comment-discussion materialize-textarea" required autofocus></textarea>
																		</div>
																		<div class="mobile-3 small-2 columns vbottom">
																			<button class="right button expand tiny sky-blue radius btn-shadow btn-lowerc" type="submit">Comentar</button>
																		</div>
																	</div>
																	<input type="hidden" name="codigo_discucion" value="<%- codigo_discucion %>">
																{!! Form::close() !!}
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									@endif

									<section class="comments-discussion-list hidesoft">
										{{-- Render user commnet--}}
									</section>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</script>

{{-- comment discussion template --}}
<script type="text/template" id="comment-discussion-tpl">
	<div class="row">
		<div class="small-12 columns">
			<ul class="post-user-card">
				<li>
					<a href="<%= window.Misc.urlFull( url_profile ) %>" title="" class="picture-comment-post">
						<img src="<%- imagen_usuario ? imagen_usuario : window.Misc.dv().avatar %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size35" onerror="imageDefault(this, '{{ config('tuproyecto.avatar_image') }}')">
					</a>
				</li>
				<li>
					<ul class="post-user-data">
						<li>
							<span>
								<a href="<%= window.Misc.urlFull( url_profile ) %>" class="nickname-comment-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
							<span>
							<span class="text-xsm light-text">&bull;</span>
							<span class="light-text"><%- window.moment([fecha_comentario, hora_comentario].join(' '), "YYYY-MM-DD HH:mm:ss").format("MMMM DD YYYY, h:mm:ss a") %></span>
						</li>
						<li>
							<div class="comment-content-post">
								<div class="text-description-comment container-more">
									<%= texto_comentario %>
								</div>
							</div>
						</li>
						<li>
							<ul class="comment-icons-list">
								<li>
									<a href="#" class="TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
										<i class="icon icon-like"></i>
										<span class="data-count-likes"><%- contador_like %></span>
									</a>
								</li>
								<li><span class="text-xsm light-text">&bull;</span></li>
								<li>
									<span><a href="#" class="show-user-likes">A quién le gusta esto.</a></span>
								</li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</script>

<script type="text/template" id="vote-form-tpl">
	{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-vote-user')) !!}
		<div class="row">
			<div class="small-12 columns text-center">
				<dl class="definition-info-participation">
					<dd>
						<p class="thin-text text-center">Por favor ingresa tus datos para votar por tu proyecto favorito.</p>
					</dd>
				</dl>
			</div>
		</div>
		</br>
		<div class="row">
			<div class="small-12 columns">
				<input type="text" id="email" name="email" placeholder="E-mail" required pattern="email">
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<input type="text" name="nombre_usuario" id="nombre_usuario" placeholder="Nombre" required pattern="[a-zA-Z]+">
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns">
				<input type="text" id="primer_apellido_persona" name="primer_apellido_persona" placeholder="Apellido" required maxlength="200" class="view-input">
			</div>
		</div>
		<div class="row">
			<div class="columns tablet-5  tablet-centered">
				{!! Form::submit('Votar', array('class' => 'button tiny sky-blue btn-shadow radius expand')) !!}
			</div>
		</div>
	{!! Form::close() !!}
</script>

{{-- Template for image loader --}}
<script type="text/template" id="qq-img-uploader-template">
    <div class="qq-uploader-selector qq-uploader-picture" qq-drop-area-text="Arrastra una imagen aquí">
    	<div class="qq-upload-drop-area-selector" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <small class="description-field-form">
        	<span>Arrastra el cuadrado para cambiar la posición y el tamaño.</span>
			<br>
			<!-- <span>El tamaño optimo de la imagen es de 365px X 240px</span> -->
			<br>
            <div class="qq-upload-button-selector qq-upload-btn-picture">
	            <div>{{ transtp('programs.uploadimgprogram') }}</div>
	        </div>
        </small>
        <ul class="qq-upload-list-selector" aria-live="polite" aria-relevant="additions removals">
        	<li></li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cerrar</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">No</button>
                <button class="qq-ok-button-selector">Si</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cancelar</button>
                <button class="qq-ok-button-selector">Continuar</button>
            </div>
        </dialog>
    </div>
</script>

{{-- Template for image product loader --}}
<script type="text/template" id="qq-img-product-uploader-template">
    <div class="qq-uploader-selector qq-uploader-picture" qq-drop-area-text="Arrastra una imagen aquí">
    	<div class="qq-upload-drop-area-selector" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <small class="description-field-form">
        	<span>Arrastra el cuadrado para cambiar la posición y el tamaño.</span>
			<br>
			<span>El tamaño optimo de la imagen es de 646px X 374px</span>
			<br>
            <div class="qq-upload-button-selector qq-upload-btn-picture">
	            <div>{{ transtp('programs.uploadimgprogram') }}</div>
	        </div>
        </small>
        <ul class="qq-upload-list-selector" aria-live="polite" aria-relevant="additions removals">
        	<li></li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cerrar</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">No</button>
                <button class="qq-ok-button-selector">Si</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cancelar</button>
                <button class="qq-ok-button-selector">Continuar</button>
            </div>
        </dialog>
    </div>
</script>

{{-- Template for image promotion loader --}}
<script type="text/template" id="qq-img-promotion-uploader-template">
    <div class="qq-uploader-selector qq-uploader-picture" qq-drop-area-text="Arrastra una imagen aquí">
    	<div class="qq-upload-drop-area-selector" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <small class="description-field-form">
        	<span>Arrastra el cuadrado para cambiar la posición y el tamaño.</span>
			<br>
			<span>El tamaño optimo de la imagen es de 1180px X 320px</span>
			<br>
            <div class="qq-upload-button-selector qq-upload-btn-picture">
	            <div>{{ transtp('programs.uploadimgprogram') }}</div>
	        </div>
        </small>
        <ul class="qq-upload-list-selector" aria-live="polite" aria-relevant="additions removals">
        	<li></li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cerrar</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">No</button>
                <button class="qq-ok-button-selector">Si</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button class="qq-cancel-button-selector">Cancelar</button>
                <button class="qq-ok-button-selector">Continuar</button>
            </div>
        </dialog>
    </div>
</script>
{{-- Template for attachment loader --}}
<script type="text/template" id="qq-attachment-uploader-template">
	<div class="qq-uploader-selector qq-uploader-one-attachment">

        <div class="content-attachment scroll-general-v">
        	<ul class="no-bullet inline-list-grid align-center">
        		<li class="text-right">
        			<ul class="qq-upload-list-selector qq-upload-list-attachments" aria-live="polite" aria-relevant="additions removals">
			            <li>
			                {{-- <div class="qq-progress-bar-container-selector">
			                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
			                </div> --}}
			                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
			                <a class="preview-link dark-text" target="_blank">
			                	<span class="qq-upload-file-selector qq-upload-file text-md"></span>
			                </a>
			                {{-- <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
			                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text"> --}}

			                <span class="qq-upload-size-selector qq-upload-size"></span>
			                <button type="button" class="qq-btn qq-upload-cancel-selector tip-top radius" title="Cancelar" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
			                	<i class="mdi mdi-close sky-blue mdi-24"></i>
			                </button>
			                <button type="button" class="qq-btn qq-upload-retry-selector tip-top radius" title="Procesar de nuevo" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
			                	<i class="mdi mdi-reload sky-blue mdi-24"></i>
			                </button>
			                <button type="button" class="qq-btn qq-upload-delete-selector tip-top radius" title="Eliminar" data-tooltip aria-haspopup="true" data-options="disable_for_touch:true">
			                	<i class="mdi mdi-delete sky-blue mdi-24"></i>
			                </button>
			                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
			            </li>
			        </ul>
        		</li>
				<li class="text-right has-image no-wrap">
					<div class="qq-upload-button-selector qq-upload-btn-icon action-hover-circle">
						<i class="mdi mdi-upload"></i>
					</div>
					<a type="button" role="button" class="qq-download-button action-hover-circle qq-hide" title="Descargar adjunto" target="_blank">
						<i class="mdi mdi-download"></i>
					</a>
					<span class="message-no-attachment text-md gray-dark-text qq-hide">¡No hay adjunto!</span>
				</li>
        	</ul>
        	<input type="hidden" class="qq-attachment-required" name="qq-attachment-required[]" value="" required>
        </div>

        {{-- <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Close</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">No</button>
                <button type="button" class="qq-ok-button-selector">Yes</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Cancel</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog> --}}
    </div>
</script>

{{-- gallery image template --}}
<script type="text/template" id="gallery-image-item-tpl">
	<div class="item-gallery-image <%- editable ? 'image-area-drop' : 'light-preview-image' %>" data-gallery-img="g-img-<%- codigo_adjunto %>" data-lightbox="<%- direccion_adjunto ? direccion_adjunto : '{{ config('tuproyecto.no_image') }}' %>">
		<a href="#" class="<%- editable ? 'change-image-gallery' : '' %>" data-gallery-img="g-img-<%- codigo_adjunto %>">
			<img src="<%- direccion_adjunto ? direccion_adjunto : '{{ config('tuproyecto.no_image') }}' %>" alt="">
			<i class="mdi mdi-plus hidesoft"></i>
		</a>
	</div>
</script>

@if (Auth::check())
	{{-- Templates for wall section --}}
	{{-- preview post wall --}}
	<script type="text/template" id="preview-post">
		<a href="#" class="close content-close">×</a>
		<div class="row collapse wall-description-site">
			<% if( image && window.Misc.isUrl(window.Misc.trim(image)) ){ %>
				<div class="large-5 columns">
					<a href="<%- url %>" target="_blank" class="picture-site-post" title="<%- title %>">
						<img src="<%- image %>" alt="<%- title %>">
					</a>
				</div>
				<div class="large-7 columns">
					<a href="<%- url %>" target="_blank" title="<%- title %>">
						<h6 class="wall-namesite-post"><%- title %></h6>
					</a>
					<p><%- description %></p>
					<a href="http://<%- author %>" class="domain-site-post" target="blank">
						<%- author %>
					</a>
				</div>
			<% }else{ %>
				<div class="large-12 columns">
					<a href="<%- url %>" target="_blank" title="">
						<h6 class="wall-namesite-post"><%- title %></h6>
					</a>
					<p><%- description %></p>
					<a href="http://<%- author %>" class="domain-site-post" target="blank">
						<%- author %>
					</a>
				</div>
			<% } %>
		</div>
	</script>

	{{-- post wall template --}}
	<script type="text/template" id="wall-post-tpl">
		@if (Auth::check())
		<% if(owner){ %>
			<a href="#" class="close content-close wall-post-hide" title="Remover entrada">×</a>
		<% } %>

		{{-- wall main post box--}}
		<div class="post-user-data-box">
			<div class="row">
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
									<% if( _.isString(nickname_reference) && nickname_reference.length ){ %>
										<span class="nickname-user-ref-post">
											<a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_reference %>" class="nickname-user-post"><%- window.Misc.strToNickname(nickname_reference) %></a>
										</span>
									<% } %>
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

		{{-- post content box --}}
		<div class="post-content-box">
			<div class="row">
				<div class="medium-12 columns">
					<div class="text-description-post container-more"><%= texto_muro %></div>
				</div>
			</div>
			<% if( metadatos_muro.success ){ %>
				<div class="wall-description-site">
					<div class="row">
						<% if( metadatos_muro.image && window.Misc.isUrl(window.Misc.trim(metadatos_muro.image)) ){ %>
							<div class="large-5 columns">
								<a href="<%- metadatos_muro.url %>" target="_blank" class="picture-site-post" title="<%- metadatos_muro.title %>">
									<img src="<%- metadatos_muro.image %>" alt="<%- metadatos_muro.title %>" >
								</a>
							</div>
							<div class="large-7 columns">
								<a href="<%= metadatos_muro.url %>" target="_blank" title="<%- metadatos_muro.title %>">
									<h6 class="wall-namesite-post"><%- metadatos_muro.title %></h6>
								</a>
								<p><%- metadatos_muro.description %></p>
								<a href="http://<%- metadatos_muro.author %>" class="domain-site-post" target="blank">
									<%- metadatos_muro.author %>
								</a>
							</div>
						<% }else{ %>
							<div class="large-12 columns">
								<a href="<%- metadatos_muro.url %>" target="_blank" title="">
									<h6 class="wall-namesite-post"><%- metadatos_muro.title %></h6>
								</a>
								<p><%- metadatos_muro.description %></p>
								<a href="http://<%- metadatos_muro.author %>" class="domain-site-post" target="blank">
									<%- metadatos_muro.author %>
								</a>
							</div>
						<% } %>
					</div>
				</div>
			<% } %>
		</div>

		{{-- footer box --}}
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
							<li>
								<a href="#" class="show-comment-field" title="Haz un comentario">
									<i class="icon icon-comment"></i>
									<span class="data-count-comments"><%= contador_comentario %></span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		{{-- wall comments box--}}
		<div class="post-comments-box hidesoft">

			<div class="user-comment wall-user-comment">
				<div class="row">
					<div class="small-12 columns">

						<ul class="post-user-card">
							<li>
								<a href="{{ Auth::user()->nickname_usuario ? URL::route('usuario.nickname', Auth::user()->nickname_usuario) : '#' }}" class="picture-comment-post" title="{{ Auth::user()->nombre_usuario }}">
									<img src="{{{ Auth::user()->imagen_usuario ? Auth::user()->imagen_usuario :  Config::get('tuproyecto.avatar_image') }}}" alt="{{{ Auth::user()->nickname_usuario }}}" />
								</a>
							</li>
							<li>
								<div class="wrap-field-comment comment-post-field">
									{!! Form::open( array('action' => null, 'data-abide' => '', 'class' => 'form-comment-post') ) !!}
										<div class="row collapse">
											<div class="large-10 columns">
												<textarea name="texto_comentario" placeholder="Escribe un comentario" rows="1" class="wysiwyg-commentpost" required="required" autofocus></textarea>
											</div>
											<div class="large-2 columns">
												<button class="right button-user-comment" type="submit">Comentar</button>
											</div>
										</div>
										<input type="hidden" name="codigo_muro" value="<%- codigo_muro %>">
									{!! Form::close() !!}
								</div>
							</li>
						</ul>

					</div>
				</div>
			</div>

			<section class="comments-post-list hidesoft">

				{{-- Render user commnet--}}

			</section>

		</div>
		@endif
	</script>

	{{-- comment wall template --}}
	<script type="text/template" id="comment-post-tpl">
		<div class="row">
			<div class="small-12 columns">
				<ul class="post-user-card">
					<li>
						<a href="<%= window.Misc.urlFull(url_profile) %>" title="" class="picture-comment-post">
							<img src="<%- imagen_usuario ? imagen_usuario : window.Misc.dv().avatar %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>">
						</a>
					</li>
					<li>
						<ul class="post-user-data">
							<li>
								<span class="comment-content-post">
									<a href="<%= window.Misc.urlFull( url_profile ) %>" class="nickname-comment-post"><%- window.Misc.strToNickname(nickname_usuario) %></a>
									<span>&middot; </span><%= texto_comentario %>
								<span>
							</li>
							<li>
								<ul class="social-box-icons comment-icons-list">
									<li>
										<span class="light-text"><%- time_ago %></span>
									</li>
									<li><span>&middot;</span></li>
									<li>
										<a href="#" class="TPlikelink no-text-like" data-srcparams="<%- srcparams %>" data-csrf-token="{{ csrf_token() }}" title="Me gusta">
											<i class="icon icon-like"></i>
											<span class="data-count-likes"><%- contador_like %></span>
										</a>
									</li>
									<li><span>&middot;</span></li>
									<li>
										<span><a href="#" class="show-user-likes">A quién le gusta esto.</a></span>
									</li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</script>

	<script type="text/template" id="wall-post-confirm-hide-tpl">
		<p>{{ Lang::get('wall.hide.confirm') }}</p>
	</script>

	{{-- form request mentoring --}}
	<script type="text/template" id="request-mentoring-tpl">
		{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-request-mentoring')) !!}
			<div class="text-center">
				<label class="label single text-dmd text-center gray-dark-text">{{ Lang::get('mentoring.request.view') }}</label>
				<h4 class="thin-header sky-blue-text"><%- typeof nombre_usuario !== 'undefined' ? nombre_usuario : '' %></h4>
			</div>
			<br>
			<div class="row">
				<div class="tablet-12 columns input-field">
					<select id="codigo_entidad" name="codigo_entidad" class="" required data-placeholder="Elige un proyecto" placeholder="Proyecto empresarial o empresa">
						<option value="" selected disabled>Proyecto empresarial o empresa</option>
						@foreach( App\Entidad::getEntitysList() as $value)
							<option value="{{ TuProyecto::encryptSrcParams([$value->key]) }}">{{ $value->value }}</option>
						@endforeach
					</select>
					<label for="codigo_entidad" class="sky-blue-text">Emprendimiento:</label>
				</div>
				<div class="tablet-12 columns input-field">
					<select id="codigo_tipo_asesoria" name="codigo_tipo_asesoria" class="" required data-placeholder="Elige un tema" placeholder="Elige un tema">
						<option value="" selected disabled>Elige un tema</option>
						@foreach( App\TemaMentoria::getThemesList() as $value)
							<option value="{{$value->codigo_tipo_asesoria}}">{{ $value->nombre_tipo_asesoria }}</option>
						@endforeach
					</select>
					<label for="codigo_tipo_asesoria" class="sky-blue-text">Tema:</label>
				</div>
			</div>

			<div class="row">
				<div class="small-12 columns">
					<h5 class="thin-header clean-header inst-color-secondary">Inicia la conversación:</h5>
					<div class="row">
						<div class="small-12 columns input-field">
							<textarea required name="descripcion_asesoria" id="descripcion_asesoria" cols="50" rows="4" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"></textarea>
							<label for="descripcion_asesoria">Mensaje</label>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="tablet-12 columns input-field">
					<input type="text" id="tags_asesoria" name="tags_asesoria" class="" value="" placeholder="Agrega una etiqueta.">
					<label for="tags_asesoria" class="sky-blue-text">Tags:</label>
				</div>
			</div>

			<input type="hidden" name="codigo_usuario" value="<%= typeof codigo_usuario !== 'undefined' ? codigo_usuario : '' %>" />
			<div class="row">
				<div class="small-12 columns save-section">
					<div class="row">
						<div class="mobile-12 columns">
                            <div class="text-right">
                                {!! Form::submit('Solicitar', array('class' => 'button xsmall sky-blue radius')) !!}
			                </div>
			            </div>
					</div>
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- form event create --}}
	<script type="text/template" id="create-calendar-event-tpl">
		{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-create-calendar-event') ) !!}
			<div class="row">
				<div class="small-12 columns input-field">
					<select id="codigo_tipo_evento" name="codigo_tipo_evento" class="choice-filter-events type-event-calendar" required data-placeholder="Tipo evento" placeholder="Elige un tipo evento">
						<option value="" disabled selected>Elige un tipo evento</option>
						@foreach( App\TipoEvento::getTypes('user')->pluck('nombre_tipo_evento', 'codigo_tipo_evento')->toArray() as $key => $value)
							<option value="{{ $key }}" <%- codigo_tipo_evento == '{{ $key }}' ? 'selected': ''%> >{{ $value }}</option>
						@endforeach
					</select>
					<label>Tipo:</label>
				</div>
			</div>
			<div class="row">
				<div class="small-6 columns">
					<label for="start-event">Fecha Inicio</label>
					<input type="text" name="fecha_inicio" id="start-event" value="<%- typeof start !== 'undefined' ? start : '' %>" class="datetimepk" required>
				</div>
				<div class="small-6 columns">
					<label for="end-event">Fecha Fin</label>
					<input type="text" name="fecha_fin" id="end-event" value="<%- typeof end !== 'undefined' ? end : ''%>" class="datetimepk" required>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns input-field">
					<select name="codigo_ciudad" id="codigo_ciudad" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%- window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-initial-value="<%- typeof(codigo_ciudad) !== 'undefined' ? codigo_ciudad : '' %>" data-placeholder="Seleccione" placeholder="Seleccione" required>
                    </select>
                    <label for="codigo_ciudad">Ciudad</label>
				</div>
			</div>
			<div class="row">
				<div class="small-12 columns input-field">
					<input type="text" name="lugar_evento" id="lugar_evento" value="<%-lugar_evento %>" required class="validate" >
					<label for="lugar_evento">Lugar</label>
				</div>
			</div>
			<div class="row can-readonly-field">
				<div class="tablet-12 columns input-field">
					<input type="text" name="nombre_evento" id="nombre_evento" area-default="{{ trans('event.mentoring.name.event') }}" value="<%- typeof nombre_evento !== 'undefined' ? nombre_evento : '' %>" required class="validate">
					<label for="nombre_evento">Título del evento</label>
				</div>
			</div>
			<div class="row can-readonly-field">
				<div class="small-12 columns input-field">
					<label>Descripción</label>
					<textarea name="descripcion_evento" area-default="{{ Lang::get('event.mentoring.description.event') }}" rows="2" required  class="materialize-textarea validate"><%- typeof descripcion_evento !== 'undefined' ? descripcion_evento : '' %></textarea>
				</div>
			</div>
			<div class="row save-section">
				<div class="small-12 medium-3 medium-offset-6 columns">
					<% if(!_.isUndefined(typeof(codigo_evento)) && !_.isNull(codigo_evento)) { %>
						<input type="button" class="button flat small close-reveal-modal btn-clean-margin on-remove-event" value="Eliminar">
					<% }%>
				</div>
				<div class="small-12 medium-3 columns">
					<input class="button small sky-blue btn-bold radius btn-clean-margin expand" value="<%- (_.isUndefined(typeof(codigo_evento)) || _.isNull(codigo_evento)) ? 'Crear': 'Editar' %>" type="submit">
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- form event create --}}
	<script type="text/template" id="create-request-mentoring-tpl">

		@switch(App\RegistroSesion::getInstitutionSlug())
			@case('rutan')
				@include('layout.templateinstitution.formevent.rutan')
				@break
			@default
				@include('layout.templateinstitution.formevent.general')
		@endswitch

	</script>

	{{-- modal confirm event mentoring from mentoring profile  --}}
	<script type="text/template" id="confirm-mentoring-profile-tpl">
		<div class="content-confirm-mentoring">
			{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-confirm-mentoring') ) !!}
					<div class="row">
						<div class="small-12 columns">
							<ul class="no-bullet">
								<% if(typeof( start) !== 'undefined' && typeof(end) !== 'undefined' ){ %>
									<li><%- start +' - '+ end %></li>
								<% } %>
								<li><a href="<%- window.Misc.urlFull(Route.route('calendario.evento.show', { evento: url_evento })) %>" target="_blank"><h6 class="inst-color-invert"><%- nombre_evento %></h6></a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<p><%- typeof( descripcion_mentoria) !== 'undefined' ? descripcion_mentoria : '' %></p>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<p><%- typeof( lugar_evento) !== 'undefined' ? lugar_evento : '' %></p>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
                        <% if(typeof(objetivos_mentoria) !== 'undefined' && !_.isEmpty(objetivos_mentoria)){ %>
                        <label for="">Objetivos</label>
                        <ul class="targets-schedule-mentoring list-data-aside">
                            <% _.each(objetivos_mentoria, function (target) { %>
                            <li><%- target.texto_tag %></li>
                            <% }); %>
                        </ul>
                        <% } %>
						</div>
					</div>
					<% if( owner && clase_tipo_evento != window._tp.getClassTypeEvent['plataform']) { %>
					<div class="row">
						<div class="small-12 columns">
							<label for="">Lugar de la mentoría</label>
							<input type="text" required name="lugar_evento" placeholder="Lugar..." value="<%- typeof( lugar_evento) !== 'undefined' ? lugar_evento : '' %>" >
						</div>
					</div>
					<% } %>
					<div class="row">
						<% if(typeof stateEvent !== 'undefined' && stateEvent == 'confirm'){ %>
							<% if(  owner ) { %>
								<div class="row">
									<div class="small-12 medium-3 medium-offset-6 columns">
										<a href="#" id="cancel-mentoring" class="button small sky-blue btn-bold radius btn-clean-margin expand">Cancelar</a>
									</div>
									<div class="small-12 medium-3 columns">
										{!! Form::submit('Confirmar', array('class' => 'button small sky-blue btn-bold radius btn-clean-margin expand')) !!}
									</div>
								</div>

							 <% }else{ %>
								<div class="small-12 columns">
									<div data-alert class="notice-box-tp text-center warning">
										<span>
											!Pendiente por confirmar mentoría!
										</span>
										<i class="icon-alert"></i>
									</div>
								</div>
							<% } %>
						<% }else if(typeof stateEvent !== 'undefined' && stateEvent== 'available' && !owner){%>
							<div class="small-12 columns">
								<div data-alert class="notice-box-tp text-center secondary">
									<span>
										!Pendiente para solicitud de mentoría!
									</span>
									<i class="icon-alert"></i>
								</div>
							</div>
                        <% }else if(typeof stateEvent !== 'undefined' && stateEvent == 'unregistered'){%>
							<div class="small-12 columns">
                            <% if(typeof(view) !== 'undefined' && view){%>
								<div data-alert class="notice-box-tp text-center primaryy">
									<span>
                                        <a id="button-participate-unregistered-event" href="<%- window.Misc.urlFull(Route.route('calendario.evento.show', { evento: url_evento })) %>"  target="_blank" class="button xsmall sky-blue radius  btn-bold btn-clean-margin waves-effect waves-light right">{{ transtp('event.button.participate') }}</a>
									</span>
									<i class="icon-alert"></i>
								</div>
                            <% } %>
							</div>
						<% }else if(typeof stateEvent !== 'undefined' && stateEvent == 'confirmed'){%>
							<div class="small-12 columns">
								<div data-alert class="notice-box-tp text-center success">
									<span>
										!La mentoría ya fue confirmada!
									</span>
									<i class="icon-alert"></i>
								</div>
							</div>
						<% } %>

					</div>
			{!! Form::close() !!}
		</div>
	</script>

	{{-- modal confirm event mentoring --}}
	<script type="text/template" id="confirm-mentoring-schedule-tpl">
		<div class="content-confirm-mentoring">
			{!! Form::open( array('action' => null, 'data-abide' => '', 'id' => 'form-confirm-mentoring') ) !!}
					<div class="row">
						<div class="small-12 columns">
							<ul class="no-bullet">
							<% if(typeof( start) !== 'undefined' && typeof(end) !== 'undefined' ){ %>
								<li><%- start +' - '+ end %></li>
							<% } %>
								<li><a href="<%- window.Misc.urlFull(Route.route('calendario.evento.show', { evento: url_evento })) %>" target="_blank"><h6 class="inst-color-invert"><%- nombre_evento %></h6></a></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<p><%- typeof( descripcion_mentoria) !== 'undefined' ? descripcion_mentoria : '' %></p>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
							<p><%- typeof( lugar_evento ) !== 'undefined' ? lugar_evento  : '' %></p>
						</div>
					</div>
					<div class="row">
						<div class="small-12 columns">
                        <% if(typeof(objetivos_mentoria) !== 'undefined' && !_.isEmpty(objetivos_mentoria)){ %>
                        <label for="">Objetivos</label>
                        <ul class="targets-schedule-mentoring list-data-aside">
                            <% _.each(objetivos_mentoria, function (target) { %>
                            <li><%- target.texto_tag %></li>
                            <% }); %>
                        </ul>
                        <% } %>
						</div>
					</div>
					<% if( owner && clase_tipo_evento != window._tp.getClassTypeEvent['plataform']) { %>
					<div class="row">
						<div class="small-12 columns">
							<label for="">Lugar de la mentoría</label>
							<input type="text" required name="lugar_evento" placeholder="Lugar..." value="<%- lugar_evento %>" >
						</div>
					</div>
					<% } %>
					<div class="row">
						<% if(typeof stateEvent !== 'undefined' && stateEvent == 'confirm'){ %>
							<% if(  owner ) { %>
								<div class="small-12 columns">
									<div data-alert class="notice-box-tp text-center warning">
										<span>
											!Pendiente por confirmar en el calendario de mentorías!
										</span>
										<i class="icon-alert"></i>
									</div>
								</div>
							<% }else{ %>
									<div class="small-12 columns">
										<div data-alert class="notice-box-tp text-center warning">
											<span>
												!Pendiente por confirmar mentoría!
											</span>
											<i class="icon-alert"></i>
										</div>
									</div>
							<% } %>
						<% }else if(typeof stateEvent !== 'undefined' && stateEvent== 'available' && !owner){%>
							<% if(typeof codigo_tipo_evento !== 'undefined' && codigo_tipo_evento == 1){ %>
								<div class="small-12 columns">
									<div data-alert class="notice-box-tp text-center secondary">
										<span>
											!Pendiente para solicitud de mentoría!
										</span>
										<i class="icon-alert"></i>
									</div>
								</div>
							<% } %>
                        <% }else if(typeof stateEvent !== 'undefined' && stateEvent == 'unregistered'){%>
							<div class="small-12 columns">
                            <% if(typeof(view) !== 'undefined' && view){%>
								<div data-alert class="notice-box-tp text-center primaryy">
									<span>
                                        <a id="button-participate-unregistered-event" href="<%- window.Misc.urlFull(Route.route('calendario.evento.show', { evento: url_evento })) %>"  target="_blank" class="button xsmall sky-blue radius  btn-bold btn-clean-margin waves-effect waves-light right">{{ transtp('event.button.participate') }}</a>
									</span>
									<i class="icon-alert"></i>
								</div>
                            <% } %>
							</div>
						<% }else if(typeof stateEvent !== 'undefined' && stateEvent == 'confirmed'){%>
							<div class="small-12 columns">
								<div data-alert class="notice-box-tp text-center success">
									<span>
										!La mentoría ya fue confirmada!
									</span>
									<i class="icon-alert"></i>
								</div>
							</div>
						<% } %>

					</div>
			{!! Form::close() !!}
		</div>
	</script>

	{{-- section Buttons Friendship --}}
	<script type="text/template" id="buttons-friendly-user-tpl">
		<% if( owner ){ %>
			<% if( !_.isUndefined(state_friendship) && !_.isNull(state_friendship) ){ %>
				<% if(state_friendship == 'friend'){ %>
					<li class="tablet-text-right">
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'arrow' ) { %>
							<a class="action-friendship" data-dropdown="drop-opts-friendship-<%- nickname_usuario %>" aria-controls="drop-opts-friendship-<%- nickname_usuario %>"><i class="mdi mdi-dots-vertical mdi-18 vcenter icon-circle item-label"></i></a>
						<% }else { %>
							<a class="action-friendship btn-friendship button button-outline xtiny radius btn-lowerc" data-dropdown="drop-opts-friendship-<%- nickname_usuario %>" aria-controls="drop-opts-friendship-<%- nickname_usuario %>" data-options="is_hover:true;">
							<i class="icon-btn mdi mdi-account-check mdi-16 vcenter"></i>
								Ya es tu contacto
							<i class="mdi mdi-menu-down mdi-16 vcenter"></i>
							</a>
						<% } %>
						<ul id="drop-opts-friendship-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown tiny radius text-sm no-bullet no-arrow" aria-hidden="true">
							<li>
								<a href="#" class="hide-friendship-user text-left" area-title="Eliminar Contacto">
									<ul class="inline-list-grid align-center no-bullet">
										<li>Eliminar Contacto</li>
										<li class="short-col"><i class="mdi mdi-account-remove mdi-21 vcenter gutter-left"></i></li>
									</ul>
								</a>
							</li>
							<!--<li>
								<a href="#" class="message-friendship-user">Enviar un Mensaje<i class="mdi mdi-email mdi-24 vcenter"></i></a>
							</li>-->
						</ul>
					</li>
				<% }else if(state_friendship == 'waiting_answer'){ %>
					<li class="tablet-text-right">
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'arrow' ) { %>
							<a class="action-friendship" data-dropdown="drop-waiting-friendship-<%- nickname_usuario %>" aria-controls="drop-waiting-friendship-<%- nickname_usuario %>"><i class="mdi mdi-clock-outline mdi-18 vcenter icon-circle item-label"></i></a>
						<% }else { %>
							<a class="action-friendship btn-friendship button button-outline xtiny btn-lowerc radius" data-dropdown="drop-waiting-friendship-<%- nickname_usuario %>" aria-controls="drop-waiting-friendship-<%- nickname_usuario %>" data-options="is_hover:true;">
								<i class="icon-btn mdi mdi-clock-outline mdi-16 vcenter"></i>
								Esperando aceptación
								<i class="mdi mdi-menu-down mdi-16 vcenter"></i>
							</a>
						<% } %>
							<ul id="drop-waiting-friendship-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown tiny radius no-arrow text-sm no-bullet" aria-hidden="true">
								<li>
									<a href="#" class="cancel-network-user text-left" area-title="Eliminar Solicitud">
										<ul class="inline-list-grid align-center no-bullet">
											<li>Cancelar solicitud</li>
											<li class="short-col"><i class="mdi mdi-account-off mdi-21 vcenter gutter-left"></i></li>
										</ul>
									</a>
								</li>
							</ul>
					</li>
				<% }else if(state_friendship == 'pending_confirm'){ %>
					<li class="tablet-text-right">
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'arrow' ) { %>
							<a class="action-friendship" data-dropdown="drop-pending-friendship-<%- nickname_usuario %>" aria-controls="drop-pending-friendship-<%- nickname_usuario %>"><i class="mdi mdi-dots-vertical mdi-21 vcenter icon-circle item-label"></i></a>
						<% }else { %>
							<a class="action-friendship btn-friendship button xtiny radius btn-lowerc" data-dropdown="drop-pending-friendship-<%- nickname_usuario %>" aria-controls="drop-pending-friendship-<%- nickname_usuario %>" data-options="is_hover:true;"> <i class="icon-btn mdi mdi-account-plus mdi-16 vcenter"></i>
								Responder solicitud
								<i class="mdi mdi-menu-down mdi-16 vcenter"></i>
							</a>
						<% } %>
						<ul id="drop-pending-friendship-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown tiny radius no-arrow text-sm no-bullet" aria-hidden="true">
							<li>
								<a href="#" class="network-user text-left" area-title="Aceptar Contacto">
									<ul class="inline-list-grid align-center no-bullet">
										<li>Aceptar contacto</li>
										<li class="short-col"><i class="mdi mdi-account-check mdi-21 vcenter gutter-left"></i></li>
									</ul>
								</a>
							</li>
							<li>
								<a href="#" class="cancel-network-user text-left" area-title="Rechazar solicitud">
									<ul class="inline-list-grid align-center no-bullet">
										<li>Rechazar solicitud</li>
										<li class="short-col"><i class="mdi mdi-account-off mdi-21 vcenter gutter-left"></i></li>
									</ul>
								</a>
							</li>
						</ul>
					</li>
				<% }else{ %>
					<li class="tablet-text-right">
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'arrow' ) { %>
							<i class="mdi mdi-account-remove mdi-24 gray-light tip-bottom radius" title="No es tu contacto" data-tooltip aria-haspopup="true"></i>
							<a class="action-friendship" data-dropdown="drop-add-friendship-<%- nickname_usuario %>" aria-controls="drop-add-friendship-<%- nickname_usuario %>"><i class="mdi mdi-chevron-down mdi-21"></i></a>
						<% }else { %>
							<a href="#" class="action-friendship btn-friendship button button-outline xtiny btn-lowerc radius network-user">
								<i class="icon-btn mdi mdi-account-plus mdi-16 vcenter"></i>
								Agregar contacto
							</a>
						<% } %>
						<ul id="drop-add-friendship-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown tiny radius no-arrow text-sm no-bullet" aria-hidden="true">
							<li>
								<a href="#" class="cancel-network-user text-left" area-title="Agregar contacto">
									<ul class="inline-list-grid align-center no-bullet">
										<li>Agregar contacto</li>
										<li class="short-col"><i class="mdi mdi-account-off mdi-21 vcenter gutter-left"></i></li>
									</ul>
								</a>
							</li>
						</ul>
					</li>
				<% }%>
			<% } %>
		<% } %>
	</script>

	{{-- form message contact --}}
	<script type="text/template" id="user-message-contact-tpl">
		{!! Form::open(array('route' => null, 'data-abide' => '', 'id' => 'form-message-contact')) !!}
			<div class="row">
				<div class="columns small-2">
					<p>Mensaje</p>
				</div>
				<div class="columns small-10">
					<textarea name="texto_discucion" id="texto_discucion" rows="3" required></textarea>
				</div>
			</div>
			<input type="hidden" name="codigo_usuario" value="<%= codigo_usuario %>" />
			<div class="row">
				<div class="columns tablet-5  tablet-centered">
					{!! Form::submit('Enviar', array('class' => 'button tiny sky-blue btn-shadow radius expand')) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</script>

	{{-- section Buttons Marketplace --}}
	<script type="text/template" id="buttons-marketplace-product-tpl">
		<% if( owner ){ %>
			<% if( !_.isUndefined(state_product) && !_.isNull(state_product) ){ %>
				<% if(state_product == 'review'){ %>
					<li>
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'state' ) { %>
							<a class="action-state-drop text-mdi lighter-text" data-dropdown="drop-opts-review-<%- url_producto %>" aria-controls="drop-opts-review-<%- url_producto %>">
								<i class="mdi mdi-clock-outline mdi-21 icon-drop icon-left"></i>
								<span>Por aprobación</span>
								<i class="mdi mdi-menu-down mdi-21 icon-drop icon-right"></i>
							</a>
						<% }else { %>
							<div class="row">
								<div class="mobile-12 small-4 tablet-3 columns end">
									<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-review-<%- url_producto %>" aria-controls="drop-opts-review-<%- url_producto %>" data-options="is_hover:true;">Por aprobación</a>
								</div>
								<div class="mobile-12 small-8 tablet-9 columns">
									<ul class="inline-list-grid align-top">
										<li class="has-image">
											<i class="mdi mdi-clock-outline mdi-42"></i>
										</li>
										<li>
											<span class="dark-text bold-text text-md">Publicación de producto en proceso de aprobación</span>
											<br/>
											<span class="text-md">Esta es una vista previa de la publicación de tu producto. Tu publicación estará lista después de un proceso de aprobación.
											</span>
										</li>
									</ul>
								</div>
							</div>
						<% } %>
						<ul id="drop-opts-review-<%- url_producto %>" data-dropdown-content class="friendship-dropdown radius" aria-hidden="true">
							<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'state' ) { %>
								<li>
									<a href="#" class="edit-product">Editar</a>
								</li>
							<% } %>
							<li>
								<a href="#" class="cancel-request-product">Cancelar Solicitud</a>
							</li>
						</ul>
					</li>
				<% }else if(state_product == 'pending'){ %>
					<li>
					<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'state' ) { %>
						<a class="action-state-drop text-mdi lighter-text" data-dropdown="drop-opts-pending-<%- url_producto %>" aria-controls="drop-opts-pending-<%- url_producto %>">
							<i class="mdi mdi-content-save mdi-21 icon-drop icon-left"></i>
							<span>Guardado</span>
							<i class="mdi mdi-menu-down mdi-21 icon-drop icon-right"></i>
						</a>
					<% }else { %>
						<div class="row">
							<div class="mobile-12 small-4 tablet-3 columns">
								<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-pending-<%- url_producto %>" aria-controls="drop-opts-pending-<%- url_producto %>" data-options="is_hover:false;align:bottom">Guardado</a>
							</div>
							<div class="mobile-12 small-8 tablet-9 columns">
								<ul class="inline-list-grid align-top">
									<li class="has-image">
										<i class="mdi mdi-content-save mdi-42"></i>
									</li>
									<li>
										<span class="dark-text bold-text text-md">Producto guardado</span>
										<br/>
										<span class="text-md">Tu producto se encuentra guardado. Cuando creas que tu producto está listo, puedes solicitar la publicación.
										</span>
									</li>
								</ul>
							</div>
						</div>
					<% } %>
						<ul id="drop-opts-pending-<%- url_producto %>" data-dropdown-content class="friendship-dropdown radius" aria-hidden="true">
							<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'state' ) { %>
								<li>
									<a href="#" class="edit-product">Editar</a>
								</li>
							<% } %>
							<li>
								<a href="#" class="add-request-product">Solicitar Publicación</a>
							</li>
						</ul>
					</li>
				<% }else{ %>
					<li>
						<% if( !_.isUndefined(type_action) && type_action.toLowerCase() == 'state' ) { %>
							<ul class="inline-list-grid align-center no-bullet">
								<li>
									<span class="action-state-drop text-mdi lighter-text light-text">
										<i class="mdi mdi-check mdi-21 icon-drop icon-left"></i>
										<span>Publicado</span>
									</span>
								</li>
								<li>
									<a href="#" class="right button tiny inst-secondary-outline btn-lowerc radius edit-product btn-clean-margin is-hovered">Editar</a>
								</li>
							</ul>
						<% }else { %>
							<div class="row">
								<div class="mobile-12 small-4 tablet-3 columns">
									<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-finish-<%- url_producto %>" aria-controls="drop-opts-finish-<%- url_producto %>" data-options="is_hover:true;">Producto publicado</a>
								</div>
								<div class="mobile-12 small-8 tablet-9 columns">
									<ul id="drop-opts-finish-<%- url_producto %>" data-dropdown-content class="friendship-dropdown radius inline-list-grid align-top" aria-hidden="true">
										<li>
											<a href="#" class="finish-product">Pausar Publicación</a>
										</li>
									</ul>
									<ul class="inline-list-grid align-top">
										<li class="has-image">
											<i class="mdi mdi-check mdi-42"></i>
										</li>
										<li>
											<span class="dark-text bold-text text-md">Producto publicado</span>
											<br/>
											<span class="text-md">Para editar tu producto primero debes terminar la publicación, una vez guardes tus cambios debes solicitar de nuevo su publicación.
											</span>
										</li>
									</ul>
								</div>
							</div>
						<% } %>
					</li>
				<% }%>
			<% } %>
		<% } %>
	</script>

	{{-- section Buttons Article --}}
	<script type="text/template" id="buttons-article-tpl">
		<% if( owner ){ %>
			<% if( !_.isUndefined(state_article) && !_.isNull(state_article) ){ %>
				<% if(state_article == 'review'){ %>
					<li>
						<div class="row">
							<div class="mobile-12 small-4 tablet-4 columns end">
								<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-review-<%- url_contenido %>" aria-controls="drop-opts-review-<%- url_contenido %>" data-options="is_hover:true;">Por aprobación</a>
							</div>
							<div class="mobile-12 small-8 tablet-8 columns">
								<ul class="inline-list-grid align-top">
									<li class="has-image">
										<i class="mdi mdi-clock-outline mdi-42"></i>
									</li>
									<li>
										<span class="dark-text bold-text text-md">Publicación de artículo en proceso de aprobación</span>
										<br/>
										<span class="text-md">Esta es una vista previa de la publicación de tu artículo. Tu publicación estará lista después de un proceso de aprobación.
										</span>
									</li>
								</ul>
							</div>
						</div>
						<ul id="drop-opts-review-<%- url_contenido %>" data-dropdown-content class="friendship-dropdown radius" aria-hidden="true">
							<li>
								<a href="#" class="cancel-request-article">Cancelar Solicitud</a>
							</li>
						</ul>
					</li>
				<% }else if( state_article == 'pending' || state_article == 'inactive' ){ %>
					<li>
						<div class="row">
							<div class="mobile-12 small-4 tablet-4 columns">
								<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-pending-<%- url_contenido %>" aria-controls="drop-opts-pending-<%- url_contenido %>" data-options="is_hover:false;align:bottom">Guardado</a>
							</div>
							<div class="mobile-12 small-8 tablet-8 columns">
								<ul class="inline-list-grid align-top">
									<li class="has-image">
										<i class="mdi mdi-content-save mdi-42"></i>
									</li>
									<li>
										<span class="dark-text bold-text text-md">Artículo guardado</span>
										<br/>
										<span class="text-md">Tu artículo se encuentra guardado. Cuando creas que tu artículo está listo, puedes solicitar la publicación.
										</span>
									</li>
								</ul>
							</div>
						</div>
						<ul id="drop-opts-pending-<%- url_contenido %>" data-dropdown-content class="friendship-dropdown radius" aria-hidden="true">
							<li>
								<a href="#" class="add-request-article">Solicitar Publicación</a>
							</li>
						</ul>
					</li>
				<% }else{ %>
					<li>
						<div class="row">
							<div class="mobile-12 small-4 tablet-4 columns">
								<a class="button xmedium expand sky-blue radius btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-finish-<%- url_contenido %>" aria-controls="drop-opts-finish-<%- url_contenido %>" data-options="is_hover:true;">Artículo publicado</a>
							</div>
							<div class="mobile-12 small-8 tablet-8 columns">
								<ul id="drop-opts-finish-<%- url_contenido %>" data-dropdown-content class="friendship-dropdown radius inline-list-grid align-top" aria-hidden="true">
									<li>
										<a href="#" class="finish-article">Terminar Publicación</a>
									</li>
								</ul>
								<ul class="inline-list-grid align-top">
									<li class="has-image">
										<i class="mdi mdi-check mdi-42"></i>
									</li>
									<li>
										<span class="dark-text bold-text text-md">Artículo publicado</span>
										<br/>
										<span class="text-md">Para editar tu artículo primero debes terminar la publicación, una vez guardes tus cambios debes solicitar de nuevo su publicación.
										</span>
									</li>
								</ul>
							</div>
						</div>
					</li>
				<% }%>
			<% } %>
		<% } %>
	</script>

	{{-- section Buttons Marketplace Purchases --}}
	<script type="text/template" id="buttons-purchases-tpl">
		@switch(App\RegistroSesion::getInstitutionSlug())
			@case('rutan')
				@include('layout.core.buttonspurchasesrutan')
				@break
			@default
				@include('layout.core.buttonspurchases')
		@endswitch
	</script>

	{{-- section Buttons Marketplace Sales --}}
	<script type="text/template" id="buttons-sales-tpl">
		@switch(App\RegistroSesion::getInstitutionSlug())
			@case('rutan')
				@include('layout.core.buttonssalesrutan')
				@break
			@default
				@include('layout.core.buttonssales')
		@endswitch
	</script>

{{-- Template attachments file uploader Rutan --}}
<script type="text/template" id="qq-attachments-upload-entregable-template">
	<div class="qq-uploader-selector qq-uploader qq-uploader-attachments" qq-drop-area-text="Documentos">
		<div
		class="row"
		style="justify-content: center;"
		>
		<div class="small-12 tablet-4 tablet-centered columns">
			<div id="button-upload" class="qq-upload-button-selector qq-upload-btn-file  button tiny expand sky-blue btn-shadow radius">
				<div>Selecciona tu archivo</div>
			</div>
		</div>
		</div>
		<div id="bar-progress" class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
		<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
		</div>
		<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
			<span class="qq-upload-drop-area-text-selector"></span>
		</div>
		<span class="qq-drop-processing-selector qq-drop-processing">
			<span>Processing dropped files...</span>
			<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
		</span>
		<div class="content-list-attachments scroll-general-v">
			<ul class="qq-upload-list-selector qq-upload-list-attachments" aria-live="polite" aria-relevant="additions removals">
				<li>
					<div class="qq-progress-bar-container-selector">
						<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
					</div>
					<div class="row">
						<div class="small-12 medium-6  columns">
							<span class="qq-upload-spinner-selector qq-upload-spinner-circle"></span>
							<img class="qq-thumbnail-selector" qq-max-size="50" qq-server-scale>
							<a class="preview-link" target="_blank">
								<span class="qq-upload-file-selector qq-upload-file"></span>
							</a>
							<span class="qq-upload-size-selector qq-upload-size"></span>

							<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
							<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
							<button class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancelar</button>
							<button class="qq-btn qq-upload-retry-selector qq-upload-retry">Procesar de nuevo</button>
							<button id="clean-upload" class="qq-btn qq-upload-delete-selector qq-upload-delete">Borrar</button>
							<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</script>

	{{-- section Buttons Privacy --}}
	<script type="text/template" id="buttons-privacy-project-tpl">
		<li>
			<a class="action-state-drop text-md normal-text gray-dark-text" data-dropdown="drop-opts-privacy-<%- nickname_usuario %>" aria-controls="drop-opts-privacy-<%- nickname_usuario %>">
				<i class="<%- icono_privacidad_contenido %> mdi-21 icon-drop icon-left gray-base-text"></i>
				<%- nombre_privacidad_contenido %>
				<i class="mdi mdi-menu-down mdi-21 icon-drop icon-right"></i>
			</a>
			<ul id="drop-opts-privacy-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown items-wrap no-arrow no-bullet items-checked small radius" aria-hidden="true">
				@foreach( App\PrivacidadContenido::getPrivacyContent() as $privacy)
					<li class="<%- codigo_privacidad_contenido == '{{ $privacy->codigo_privacidad_contenido }}' ? 'active' : '' %>" >
						<a href="#" class="edit-privacy" id="{{ $privacy->codigo_privacidad_contenido}}" title="{{ $privacy->nombre_privacidad_contenido }}">
							<ul class="inline-list-grid valign-top no-bullet">
								<li>
									<span class="text-md">{{ $privacy->nombre_privacidad_contenido }}</span>
									<div class="text-xmd gray-base-text lighter-text">{{ $privacy->descripcion_privacidad_contenido }}</div>
								</li>
								<li class="has-image">
									<i class="{{ $privacy->icono_privacidad_contenido }} mdi-24 vtop secondary"></i>
								</li>
							</ul>
						</a>
					</li>
				@endforeach
			</ul>
		</li>
	</script>

	{{-- Section buttons group --}}
	<script type="text/template" id="buttons-group-tpl">

		<% if( !_.isUndefined(statejoin) && !_.isNull(statejoin) ){ %>
			<% if(statejoin == 'join'){ %>

				<li>
					<div class="row">
						<div class="small-12 columns">
							<a class="button xmedium expand sky-blue radius btn-bold btn-shadow btn-lowerc btn-clean-margin dropdown" data-dropdown="drop-opts-review-<%- nickname_usuario %>" aria-controls="drop-opts-review-<%- nickname_usuario %>" data-options="is_hover:true;">Haces parte de este <%- nombre_categoria_clase_espacio %>
							</a>
						</div>
					</div>
					<ul id="drop-opts-review-<%- nickname_usuario %>" data-dropdown-content class="friendship-dropdown radius" aria-hidden="true">
						<li>
							<a href="#" class="cancel-request-group">Abandonar <%- nombre_categoria_clase_espacio %></a>
						</li>
					</ul>
				</li>
			<% }else if(statejoin == 'desert'){ %>
				<div class="tablet-6' columns">
					<a href="#" id="link-join-group" class="button medium sky-blue radius btn-bold btn-shadow btn-lowerc">unirme</a>
				</div>
			<% } %>
		<% } %>

	</script>

	<script type="text/template" id="discussion-confirm-hide-tpl">
		<p>{{ Lang::get('marketplace.remove.entry.confirm') }}</p>
	</script>


	{{-- section Confirm Remove Event --}}
	<script type="text/template" id="event-confirm-remove-tpl">
		<p>{{ Lang::get('event.remove.event.confirm') }}</p>
	</script>

	{{-- section Confirm Remove Mentoring --}}
	<script type="text/template" id="mentoring-confirm-remove-tpl">
		<p>{{ Lang::get('mentoring.remove.mentoring.confirm') }}</p>
	</script>

	{{-- Confirm remove user contact --}}
	<script type="text/template" id="user-confirm-contact-tpl">
		<p>{{ Lang::get('user.contact.remove.confirm') }}</p>
	</script>

	{{-- Templates for create company --}}
	<script type="text/template" id="form-create-company-tpl">
		<div class="row">
			<div class="small-12 tablet-12 columns">
				<div class="class-detail-container">
					<p class="text-sm gray-base-text">{{ @App\ClaseEmprendimiento::getClassEntity()->where('codigo_clase_emprendimiento', App\ClaseEmprendimiento::getClass('company'))->first()->descripcion_clase_emprendimiento }}</p>
					&nbsp;
				</div>
			</div>
		</div>

		<div class="row">
			<div class="small-12 tablet-6 columns input-field">
				<select id="codigo_tipo_identificacion" name="codigo_tipo_identificacion" class="" data-placeholder="Tipo de identificación" placeholder="Tipo de identificación" required>
					<option value="" disabled selected>Seleccione tipo de identificación</option>
					@foreach( App\TipoIdentificacion::getIdentificationType() as $key => $value )
					 	@if ($key==3)
							<option
								value="{{ $key }}"
									<%-
										typeof(codigo_tipo_identificacion) !== 'undefined'
										? codigo_tipo_identificacion == '{{ $key }}'
										? 'selected' : '' : ''
									%>
							>
								{{ $value }}
							</option>
						@endif
					@endforeach
				</select>
				<label for="codigo_tipo_identificacion">Tipo de identificación (*)</label>
			</div>
			<div class="small-12 tablet-6 columns input-field">
				<div id="identification-type">
					{{-- Render template id=identification-type-tpl--}}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="small-12 tablet-6 columns input-field">
				<input required type="text" name="nombre_usuario" id="nombre_usuario" value="<%- typeof nombre_usuario !== 'undefined' ? nombre_usuario : '' %>" class="validate" length="80" maxlength="80" />
				<label for="nombre_usuario">Nombre (*)</label>
				<small class="error">¡El nombre es obligatorio!</small>
			</div>
			<div class="small-12 tablet-6 columns input-field">
				<select name="codigo_ciudad" id="codigo_ciudad" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-initial-value="<%- typeof(codigo_ciudad) !== 'undefined' ? codigo_ciudad : '' %>" data-placeholder="{{ transtp('entities.project.placeholder.city') }}" placeholder="{{ transtp('entities.project.placeholder.city') }}" required>
				</select>
				<label>{{ transtp('entities.project.city') }} (*)</label>
			</div>
		</div>
		<div class="row">
			@if (App\RegistroSesion::getInstitutionSlug() == 'rutan')
				<div class="small-12 tablet-6 columns input-field">
					<div>
						<input
							type="text"
							name="telefono_usuario"
							id="telefono_usuario"
							value="<%- telefono_usuario %>"
							class="phone-mask-co validate"
							required
						/>
						<label class="active" for="telefono_usuario">
							Teléfono empresa (*)
						</label>
						<small class="error">¡El número de telefono es obligatorio!</small>
					</div>
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<input
						type="text"
						name="numero_whatsapp"
						id="numero_whatsapp"
						value="<%- numero_whatsapp %>"
						class="phone-mask-co validate"
						required
					/>
					<label class="active" for="numero_whatsapp">
						{{ transtp('entities.company.cellphone') }} (*)
					</label>
					<small class="error">¡El número de celular es obligatorio!</small>
				</div>
			@elseif (App\RegistroSesion::getInstitutionSlug() != 'siinova')
				<div class="small-12 tablet-6 columns input-field">
					<div>
						<input
							type="text"
							name="telefono_usuario"
							id="telefono_usuario"
							value="<%- telefono_usuario %>"
							class="phone-mask-co validate"
						/>
						<label class="active" for="telefono_usuario">
							Teléfono empresa
						</label>
					</div>
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<input
						type="text"
						name="numero_whatsapp"
						id="numero_whatsapp"
						value=""
						class="phone-mask-co validate"
					/>
					<label class="active" for="numero_whatsapp">
						{{ transtp('entities.company.cellphone') }}
					</label>
				</div>
			@endif
		</div>
		<div class="row">
			<div class="small-12 tablet-6 columns input-field">
				<label for="fecha_nacimiento_usuario">Fecha inicio de operación (*)</label>
				<input type="text" name="fecha_nacimiento_usuario" id="fecha_nacimiento_usuario" value="<%- fecha_nacimiento_usuario %>" class="dateafterpk validate" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"  required>
				<small class="error">¡La fecha de inicio es obligatoria!</small>
			</div>
			<div class="small-12 tablet-6 columns input-field">
				<select
					id="codigo_categoria_proyecto"
					name="codigo_categoria_proyecto"
					class="choice-select browser-default"
					data-placeholder="{{ transtp('entities.company.placeholder.industry') }}"
					placeholder="{{ transtp('entities.company.placeholder.industry') }}"
					required
				>
					<option value="" disabled selected>{{ transtp('entities.company.placeholder.industry') }}</option>
					@foreach( App\CategoriaProyecto::getCategoriesList() as $value )
						<option
							value="{{ $value->key }}" <%- codigo_categoria_proyecto == '{{ $value->key }}' ? 'selected' : ''%> >{{ $value->value }}
						</option>
					@endforeach
				</select>
				<label>{{ transtp('entities.company.industry') }} (*)</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 tablet-6 columns input-field">
				<select
					id="codigo_etapa_proyecto"
					name="codigo_etapa_proyecto"
					class=""
					required
					data-placeholder="{{ transtp('entities.company.placeholder.stage') }}"
					placeholder="{{ transtp('entities.company.placeholder.stage') }}"
				>
					<option value="" disabled selected>{{ transtp('entities.company.placeholder.stage') }}</option>
					@foreach( App\EtapaProyecto::getStages() as $value)
						<option
							value="{{ $value->codigo_etapa_proyecto }}" <%- codigo_etapa_proyecto == '{{ $value->codigo_etapa_proyecto }}' ? 'selected' : '' %> >{{ $value->nombre_etapa_proyecto }}
						</option>
					@endforeach
				</select>
				<label>{{transtp('entities.company.stage')}} (*)</label>
			</div>
			<div class="small-12 tablet-6 columns input-field">
				<select name="codigo_sector_interes" id="codigo_sector_interes" class="choice-select browser-default" data-placeholder="Seleccione actividad económica" placeholder="Seleccione actividad económica" required>
					<option value=""></option>
					@foreach( App\SectorInteres::getInterests() as $interest)
					<option value="{{ $interest->codigo_sector_interes }}" <%- typeof(codigo_sector_interes) !== 'undefined' ? codigo_sector_interes == {{ $interest->codigo_sector_interes }} ? 'selected' : '' : '' %>>{{ $interest->codigo_sector_interes.' - '.$interest->nombre_sector_interes }}</option>
					@endforeach
				</select>
				<label for="codigo_sector_interes">Actividad económica - CIIU (*)</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 tablet-6 columns input-field">
				<select name="codigo_tipo_sociedad" id="codigo_tipo_sociedad"
						class="choice-select browser-default"
						data-placeholder="{{transtp('entities.company.society_type')}}"
						placeholder="{{transtp('entities.company.society_type')}}" required>
				<option value=""></option>
				@foreach( App\TipoSociedad::typeSociety() as $typesocie)
					<option value="{{ $typesocie->codigo_tipo_sociedad }}" <%- typeof(codigo_tipo_sociedad) !== 'undefined' ? codigo_tipo_sociedad == {{ $typesocie->codigo_tipo_sociedad }} ? 'selected' : '' : '' %>>{{ $typesocie->nombre_tipo_sociedad }}</option>
				@endforeach
				</select>
				<label for="codigo_tipo_sociedad">{{transtp('entities.company.society_type')}} (*)</label>
			</div>
			<div class="small-12 tablet-6 columns input-field">
				<select name="cubrimiento_entidad" id="cubrimiento_entidad" class="choice-select browser-default"
						data-placeholder="{{ transtp('entities.company.placeholder.covering') }}"
						placeholder="{{ transtp('entities.company.placeholder.covering') }}"
						required>
				<option value="" disabled selected>{{ transtp('entities.company.placeholder.covering') }}</option>
				@if (App\RegistroSesion::getInstitutionSlug() == 'rutan')
					@foreach( App\Entidad::$size as $key => $value)
						<option value="{{ $key }}" <%- typeof(cubrimiento_entidad) !== 'undefined' ? cubrimiento_entidad == {{ $key }} ? 'selected' : '' : '' %>>{{ $value }}</option>
					@endforeach
				@else
					@foreach( App\Entidad::$cover as $key => $value)
					<option value="{{ $key }}" <%- typeof(cubrimiento_entidad) !== 'undefined' ? cubrimiento_entidad == {{ $key }} ? 'selected' : '' : '' %>>{{ $value }}</option>
					@endforeach
				@endif
				</select>
				<label for="cubrimiento_entidad">{{ transtp('entities.company.covering') }} (*)</label>
			</div>
		</div>
			<div class="row">
				@if (App\RegistroSesion::getInstitutionSlug() == 'rutan')
					<div class="small-12 tablet-12 columns input-field">
						<input
							type="text"
							name="correo_contacto"
							id="correo_contacto"
							value="<%- correo_contacto %>"
							class="validate"
							length="80"
							maxlength="80"
							required
						/>
						<label for="correo_contacto">Correo de contacto (*)</label>
						<small class="error">¡El correo es obligatorio!</small>
					</div>
				@elseif (App\RegistroSesion::getInstitutionSlug() != 'siinova')
					<div class="small-12 tablet-12 columns input-field">
						<input
							type="text"
							name="correo_contacto"
							id="correo_contacto"
							value="<%- correo_contacto %>"
							class="validate"
							length="80"
							maxlength="80"
						/>
						<label for="correo_contacto">Correo de contacto</label>
					</div>
				@endif
			</div>
		<div class="row">
			<div class="small-12 tablet-12 columns input-field">
				<textarea required name="biografia_usuario" id="biografia_usuario" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"><%- biografia_usuario %></textarea>
				<label for="biografia_usuario">Describe tu empresa (*)</label>
			</div>
		</div>
		@if (App\RegistroSesion::getInstitutionSlug() != 'siinova')
			<div class="row">
				<div class="small-12 tablet-6 columns input-field">
					<label for="facebook">Facebook</label>
					<input type="text" name="facebook_usuario" id="facebook_usuario" value="<%- facebook_usuario %>" class="validate">
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">X</label>
					<input type="text" name="twitter_usuario" id="twitter_usuario" value="<%- twitter_usuario %>" class="validate">
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">Instagram</label>
					<input type="text" name="instagram_usuario" id="instagram_usuario" value="<%- instagram_usuario %>" class="validate">
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">Linkedin</label>
					<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" class="validate">
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">TikTok</label>
					<input type="text" name="tiktok_usuario" id="tiktok_usuario" value="<%- tiktok_usuario %>" class="validate">
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">Página web</label>
					<input type="text" name="pagina_web_usuario" id="pagina_web_usuario" value="<%- pagina_web_usuario %>" class="validate">
				</div>
			</div>
		@endif
	</script>

	{{-- Templates for create entrepreneurship --}}
	<script type="text/template" id="form-create-entrepreneurship-tpl">

		<div class="row">
			<div class="small-12 tablet-12 columns">
				<div class="class-detail-container">
					<p class="text-sm gray-light-text">{{ @App\ClaseEmprendimiento::getClassEntity()->where('codigo_clase_emprendimiento', App\ClaseEmprendimiento::getClass('entrepreneurship'))->first()->descripcion_clase_emprendimiento }}</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="small-12 tablet-12 columns input-field">
				<input type="text" name="nombre_usuario" id="nombre_usuario" value="<%- nombre_usuario %>" required pattern="[a-zA-Z]+" class="validate" length="80" maxlength="80">
				<label for="nombre_usuario">Nombre (*)</label>
				<small class="error">¡El nombre es obligatorio!</small>
			</div>
		</div>
		<div class="row">
			@if (App\RegistroSesion::getInstitutionSlug() != 'siinova')
				<div class="small-12 tablet-12 columns input-field">
					<select
						id="codigo_categoria_proyecto"
						name="codigo_categoria_proyecto"
						class="choice-select browser-default"
						data-placeholder="{{ transtp('entities.project.placeholder.industry') }}"
						placeholder="{{ transtp('entities.project.placeholder.industry') }}"
						{{ transtp('entities.project.required') }}
					>
						<option value="" disabled selected>{{ transtp('entities.project.placeholder.industry') }}</option>
						@foreach( App\CategoriaProyecto::getCategoriesList() as $value )
							<option
								value="{{ $value->key }}"
								<%- codigo_categoria_proyecto == '{{ $value->key }}' ? 'selected' : ''%> >{{ $value->value }}
							</option>
						@endforeach
					</select>
					<label>{{ transtp('entities.project.industry') }}</label>
					<small class="error">{{ transtp('entities.project.error_industry') }}</small>
				</div>
			@endif
				<div class="small-12 tablet-12 columns input-field">
					<select
						id="codigo_etapa_proyecto"
						name="codigo_etapa_proyecto"
						class="choice-select browser-default"
						data-placeholder="{{ transtp('entities.project.placeholder.stage') }}"
						placeholder="{{ transtp('entities.project.placeholder.stage') }}"
						required
					>
						<option value="" disabled selected>{{ transtp('entities.project.placeholder.stage') }}</option>
							@foreach( App\EtapaProyecto::getStages() as $value)
								<option value="{{ $value->codigo_etapa_proyecto }}" <%- codigo_etapa_proyecto == '{{ $value->codigo_etapa_proyecto }}' ? 'selected' : '' %> >{{ $value->nombre_etapa_proyecto }}</option>
							@endforeach
					</select>
					<label>{{ transtp('entities.project.stage') }} (*)</label>
					<small class="error">{{ transtp('entities.project.error_stage') }}</small>
				</div>
		</div>
		@if (App\RegistroSesion::getInstitutionSlug() != 'siinova')
			<div class="row">
				<div class="small-12 tablet-6 columns input-field">
					<label for="facebook">Facebook</label>
					<input type="text" name="facebook_usuario" id="facebook_usuario" value="<%- facebook_usuario %>" class="validate">
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">X</label>
					<input type="text" name="twitter_usuario" id="twitter_usuario" value="<%- twitter_usuario %>" class="validate">
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">Instagram</label>
					<input type="text" name="instagram_usuario" id="instagram_usuario" value="<%- instagram_usuario %>" class="validate">
				</div>
				<div class="small-12 tablet-6 columns input-field">
					<label for="start-event">Linkedin</label>
					<input type="text" name="linkedin_usuario" id="linkedin_usuario" value="<%- linkedin_usuario %>" class="validate">
				</div>
			</div>
			<div class="row">
				<div class="small-12 tablet-12 columns input-field">
					<label for="start-event">TikTok</label>
					<input type="text" name="tiktok_usuario" id="tiktok_usuario" value="<%- tiktok_usuario %>" class="validate">
				</div>
			</div>
		@endif
		<div class="row">
			<div class="small-12 tablet-12 columns input-field">
				<select name="codigo_ciudad" id="codigo_ciudad" class="browser-default choice-select-autocomplete change-choice" data-ajax--url="<%= window.Misc.urlFull( Route.route('ciudades.index') ) %>" data-initial-value="<%- typeof(codigo_ciudad) !== 'undefined' ? codigo_ciudad : '' %>" data-placeholder="{{ transtp('entities.project.placeholder.city') }}" placeholder="{{ transtp('entities.project.placeholder.city') }}" required>
				</select>
				<label>{{ transtp('entities.project.city_entrepreneurship') }} (*)</label>
				<small class="error">¡La ciudad es obligatoria!</small>
			</div>
		</div>
		<div class="row">
			<div class="small-12 tablet-12 columns input-field">
				<textarea required name="biografia_usuario" id="biografia_usuario" cols="50" rows="2" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"><%- biografia_usuario %></textarea>
				<label for="biografia_usuario">{{ transtp('entities.project.placeholder.description') }} (*)</label>
				<small class="error">¡La descripción es obligatoria!</small>
			</div>
		</div>
	</script>

	{{-- Templates for create group --}}
	<script type="text/template" id="form-create-group-tpl">
		<div class="row">
			<div class="small-12 columns">
				<div class="class-detail-container">
					<p class="text-sm gray-light-text">{{ @App\ClaseEmprendimiento::getClassEntity()->where('codigo_clase_emprendimiento', App\ClaseEmprendimiento::getClass('group'))->first()->descripcion_clase_emprendimiento }}</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="tablet-4 columns input-field">
				<input type="text" name="nombre_usuario" id="nombre_usuario" value="<%- nombre_usuario %>" required pattern="[a-zA-Z]+" class="validate" length="80" maxlength="80">
				<label for="nombre_usuario">Nombre</label>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="codigo_categoria_clase_espacio" name="codigo_categoria_clase_espacio" class="" required data-placeholder="Elige tipo de grupo" placeholder="Elige tipo de grupo">
					<option value="" disabled selected>Elige tipo de grupo</option>
					@foreach( App\CategoriaClaseEspacio::getCategoryClassSpace(App\ClaseEmprendimiento::getClass('group')) as $value)
						<option value="{{ $value->codigo_categoria_clase_espacio }}" <%- codigo_categoria_clase_espacio == '{{ $value->codigo_categoria_clase_espacio }}' ? 'selected' : '' %> >{{ $value->nombre_categoria_clase_espacio }}</option>
					@endforeach
				</select>
				<label>Tipo de grupo:</label>
			</div>
			<div class="tablet-4 columns input-field">
				<select id="codigo_categoria_proyecto" name="codigo_categoria_proyecto" class="" required data-placeholder="Elige una categoría" placeholder="Elige una categoría">
					<option value="" disabled selected>Elige una categoría</option>
					@foreach( App\CategoriaProyecto::getCategoriesList() as $value)
						<option value="{{ $value->key }}" <%- codigo_categoria_proyecto == '{{ $value->key }}' ? 'selected' : '' %> >{{ $value->value }}</option>
					@endforeach
				</select>
				<label>Categoría:</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns input-field">
				<textarea required="required" name="biografia_usuario" id="biografia_usuario" cols="50" rows="4" pattern="max_char_textarea" class="materialize-textarea validate" data-abide-validator="maxWords" data-maxlen="200"><%- biografia_usuario %></textarea>
				<label for="biografia_usuario">Describe tu grupo</label>
			</div>
		</div>
	</script>

	{{-- Participants Discussion template --}}
	<script type="text/template" id="participants-discussion-tpl">
		<div class="item-wrap-list radius">
			<ul class="inline-list-grid align-center">
				<li class="has-image">
					<a href="<%= window.Misc.urlFull( url_profile ) %>" class="item-thumb" title="<%- nombre_usuario %>">
						<img src="<%- imagen_usuario ? imagen_usuario : window._tp.thumbs.avatar() %>" alt="<%= window.Misc.strToNickname(nickname_usuario) %>" class="rounded-img size50">
					</a>
				</li>
				<li>
					<ul class="no-bullet">
						<li>
							<h6 class="carduser-namename-user bold-header gray-dark-text clean-header is-hovered"><a href="<%= window.Misc.urlFull( url_profile ) %>" title="<%- nombre_usuario %>" class="is-hovered"><%- nombre_usuario %></a></h6>
						</li>
						<% if( !_.isUndefined(nombre_ciudad) &&  !_.isNull(nombre_ciudad)) { %>
							<li><span class="light-text text-sm linear-span"><%- nombre_ciudad %>, <%- nombre_pais %></span></li>
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
	</script>

	{{-- notification permission template --}}
	<script type="text/template" id="desktop-notify-permission-tpl">
		<h6>Notificaciones de escritorio</h6>
		<% if(permissionLevel === 'default') {%>
			<a href="#" class="request-permission-notify button skyblue xsmall radius btn-resetc bold-btn btn-clean-margin"><i class="mdi mdi-bell mdi-16 vtop icon-btn"></i>Habilitar notificaciones de escritorio</a>
		<% } else if(permissionLevel === 'waiting') { %>
			<div class="notice-outline-tp info radius">
				<i class="icon-alert mdi-24"></i>
				<span class="reset-case-text text-xmd normal-text">Dale "Permitir" en el pop-up del navegador para habilitar las notificaciones.</span>
			</div>
		<% } else if(permissionLevel === 'granted') { %>
			<div class="notice-outline-tp success radius">
				<i class="icon-alert mdi-24"></i>
				<span class="reset-case-text text-xmd normal-text">¡Notificaciones de escritorio habilitadas!</span>
			</div>
		<% } else if(permissionLevel === 'denied') { %>
			<div class="notice-outline-tp warning radius">
				<i class="icon-alert mdi-24"></i>
				<span class="reset-case-text text-xmd normal-text">No haz permitido las notificaciones en tu navegador. Necesitaras abrir las preferencias de tu navegador para cambiar esto.</span>
			</div>
		<% } else if (permissionLevel === 'unknown') { %>
			<div class="notice-outline-tp gray-light radius">
				<span class="reset-case-text text-xmd normal-text">Tu navegador no soporta las notificaciones de escritorio.</span>
			</div>
		<% } %>
	</script>

	{{-- Identification template --}}
	<script type="text/template" id="identification-type-tpl">
				<input type="text" name="identificacion_usuario" id="identificacion_usuario"
					value="<%- typeof(identificacion_usuario) !== 'undefined' ? identificacion_usuario : '' %>"
					class="<%- typeof(classInput) !== 'undefined' ? classInput : '' %> validate text-right"
					maxlength="13" required>
				<label>{{ transtp('entities.company.nit') }} (*)</label>
				<small class="error">¡El número de identificación es obligatorio!</small>
	</script>
@endif
