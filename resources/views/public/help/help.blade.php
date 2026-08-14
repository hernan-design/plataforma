@extends('layout.core.layout')

@section('content')
	<section id="help-wrapper" class="wrapper-help">
		<section id="help-content" class="help-content">
			{{-- Help dinamic content  --}}
			@yield('help.content')
		</section>
	</section>
@stop
