{{-- <li class="has-dropdown">
	<a href="#" class="has-icon-notify message-notify"><span class=""><i class="mdi mdi-message vcenter"></i></span></a>
	<ul class="dropdown right">
		<li>
			<div>
				render notifications
			</div>
		</li>
	</ul>
</li> --}}
<li class="has-dropdown">
	<a href="#" class="has-icon-notify friendship-notify" data-options="align:bottom;is_hover:false;hover_timeout:0" data-dropdown="friendship-opt-notify">
		<span class="friendship-notify-quantity notify-quantity"><i class="mdi mdi-account-plus mdi-24"></i></span>
	</a>
	<div id="friendship-opt-notify" class="friendship-opt-notify content-notifications notification-layer-dropdown content medium radius" data-dropdown-content aria-autoclose="false" aria-hidden="true">
		<ul class="settings-top-notificication">
			<li class="text-left">
				<a href="{{ route('usuario.index') }}" class="text-sm gray-base-text thin-text">
					<i class="mdi mdi-magnify mdi-21 vcenter icon-btn"></i>
					<span>Buscar contactos</span>
				</a>
			</li>
		</ul>
		@include('public.noresults', ['message' => '<span class="text-md">No tienes solicitudes pendientes</span>'])
		<ul class="notifications-list list-inner-dropdown list-separator scroll-general-v">
			{{-- Render friendship notifications --}}
		</ul>
		<ul class="settings-bottom-notificication">
			<li class="text-right">
				<a href="{{ route('usuario.index') }}" class="text-sm gray-base-text thin-text">Ver todas</a>
			</li>
		</ul>
	</div>
</li>
<li class="has-dropdown">
	<a href="#" class="has-icon-notify notification-notify" data-options="align:bottom;is_hover:false;hover_timeout:0" data-dropdown="notification-opt-notify">
		<span class="general-notify-quantity notify-quantity"><i class="mdi mdi-bell mdi-24"></i></span>
	</a>
	<div id="notification-opt-notify" class="notification-opt-notify content-notifications notification-layer-dropdown content medium radius" data-dropdown-content aria-autoclose="false" aria-hidden="true">
		{{-- <ul class="settings-top-notificication">
			<li>
				<div class="clearfix">
					<a href="#" class="text-sm gray-base-text thin-text right">Ver todas</a>
				</div>
			</li>
		</ul> --}}
		@include('public.noresults', ['message' => '<span class="text-md">No tienes notificaciones</span>'])
		<ul class="notifications-list list-inner-dropdown list-separator scroll-general-v">
			{{-- Render general notifications --}}
		</ul>
		<ul class="settings-bottom-notificication">
			<li class="text-right">
				<a href="{{ route('notificaciones.index') }}" class="text-sm gray-base-text thin-text">Ver todas</a>
			</li>
		</ul>
	</div>
</li>
