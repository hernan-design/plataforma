{{-- Templates for notification --}}
<script type="text/template" id="count-notify-tpl">
	<span class="quantity-value label round"><%- count %></span>
</script>
<script type="text/template" id="friendship-notification-tpl">
	<div class="item-friendship-notify">
		<ul class="inline-list-grid valign-top">
			<li class="has-image">
				<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {nickname: _.flatten([deliveredBy])[0].nickname})) %>" title="<%- window.Misc.strToNickname(_.flatten([deliveredBy])[0].nickname) %>" class="toNotifyLink">
					<img src="<%- _.flatten([deliveredBy])[0].avatar %>" alt="<%- window.Misc.strToNickname(_.flatten([deliveredBy])[0].nickname) %>" class="rounded-img size45" onerror="imageDefault(this, window._tp.thumbs.avatar())">
				</a>
			</li>
			<li>
				<a href="<%- window.Misc.urlFull(Route.route('usuario.nickname', {nickname: _.flatten([deliveredBy])[0].nickname})) %>" title="<%- window.Misc.strToNickname(_.flatten([deliveredBy])[0].nickname) %>" class="toNotifyLink text-xmd dark-text normal-text"><%- _.flatten([deliveredBy])[0].name %></a>
				<div class="text-xmd gray-dark-text"><%- content %></div>
			</li>
		</ul>
		<a href="#" title="Quitar notificación" class="remove-notify content-close">&times;</a>
	</div>
</script>
<script type="text/template" id="general-notification-tpl">
	<div class="item-notify">
		<a href="<%- window.Misc.urlFull(url) %>" title="<%- title %>" class="wrapper-link-notify toNotifyLink">
			<ul class="card-info-notify inline-list-grid valign-top">
				<li class="has-image">
					<img src="<%- image %>" alt="<%- title %>" class="image-item-notify" onerror="imageDefault(this, window._tp.thumbs.global())" />
				</li>
				<li>
					<% if(title) { %>
						<span class="text-xmd dark-text normal-text linear-span"><%- title %></span>
					<% } %>
					<div class="description-item-notify text-xmd gray-dark-text ellipsis"><%- window.Misc.stripTags(content) %></div>
					<ul class="sub-items-notification inline-list-items">
						<li>
						<% if(type === window._tp.typeNotify['discussion']) { %>
							<i class="mdi mdi-comment-text mdi-16 sky-blue vcenter"></i>
						<% } else { %>
							<i class="mdi mdi-clipboard-text mdi-16 sky-blue vcenter"></i>
						<% } %>
						</li>
						<li><span class="text-sm gray-base-text thin-text"><%- window.moment(created).fromNow() %></span></li>
					</ul>
				</li>
			</ul>
		</a>
		<a href="#" title="Quitar notificación" class="remove-notify content-close">&times;</a>
	</div>
</script>
<script type="text/template" id="like-notification-tpl">
	<div class="item-notify">
		<a href="<%- window.Misc.urlFull(url) %>" title="<%- title %>" class="wrapper-link-notify toNotifyLink">
			<ul class="card-info-notify inline-list-grid valign-top">
				<li class="has-image">
					<img src="<%- _.flatten([deliveredBy])[0].avatar %>" alt="<%- window.Misc.strToNickname(_.flatten([deliveredBy])[0].nickname) %>" class="rounded-img size45" onerror="imageDefault(this, window._tp.thumbs.avatar())">
				</li>
				<li>
					<span class="text-xmd dark-text normal-text linear-span"><%- title %></span>
					<div class="description-item-notify text-xmd gray-dark-text ellipsis"><%- window.Misc.stripTags(content) %></div>
					<ul class="sub-items-notification inline-list-items">
						<% if(type == window._tp.typeNotify['like']) { %>
							<li><i class="mdi mdi-thumb-up mdi-16 sky-blue vcenter"></i></li>
						<% } else if(type == window._tp.typeNotify['favorite']) { %>
							<li><i class="mdi mdi-star mdi-16 sky-blue vcenter"></i></li>
						<% } %>
						<li><span class="text-sm gray-base-text thin-text"><%- window.moment(created).fromNow() %></span></li>
					</ul>
				</li>
			</ul>
		 </a>
		<a href="#" title="Quitar notificación" class="remove-notify content-close">&times;</a>
	</div>
</script>
