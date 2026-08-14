@extends('layout.core.layout')
@section('content')
	<section id="discussion-wrapper">

		<div class="fx-main-content">
			<div class="fx-col-left is-hide">
				<div id="side-menu-filter" class="wrapper-side-nav sticky-side-nav">
					{{-- Render side menu filter --}}
				</div>
			</div>
			<div class="fx-col-content">
				<section id="discussion-content" class="discussion-content">
					{{-- Discussion dinamic content  --}}
					@yield('discussion.content')
				</section>
			</div>

		</div>

	</section>
@stop
