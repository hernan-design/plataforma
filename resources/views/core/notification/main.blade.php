@extends('core.notification.notification')

@section('notification.content')

	{{-- Section Notifications --}}
	<script type="text/template" id="notification-list-tpl">
		<div id="notification-content-main">
			<div class="row">
				<div class="small-12 columns">

					<div id="content-notification-list" class="content-notifications">
						<ul class="list-separator browse-list-notification notifications-list h-hollow-both">
							<!-- Render notifications list -->
						</ul>
						@include('public.noresults', ['message' => '<span class="text-lg">No tiene notificaciones</span>'])
					</div>

				</div>
			</div>
		</div>
	</script>

@stop
