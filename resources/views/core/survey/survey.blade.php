@extends('layout.core.layout')

@section('content')
	<section id="survey-wrapper">
		<section id="survey-content" class="survey-content">
			{{-- Render survey --}}
		</section>
		@yield('survey.content')
	</section>
@stop
