@extends('layout.core.layout')

@section('title_site'){{ Lang::get('app.terms.title') }}@stop
@section('meta_title'){{ Lang::get('app.terms.title') }}@stop
@section('meta_description'){{ Lang::get('app.terms.description') }}@stop
@section('meta_url'){{ Request::url() }}@stop

@section('content')
	<div class="row">
		<div class="small-12 columns">
			<article class="terms-institution panel-info">
				@if(isset($terminos))
					<h3 class="text-center bold-header">{{{ $terminos->titulo_terminos_condiciones }}}</h3>
					{!! $terminos->texto_version_terminos !!}
				@endif
			</article>
		</div>
	</div>
@stop
